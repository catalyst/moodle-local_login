<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Generalised login page renderer.
 * @copyright  Catalyst IT 2022
 * @package    local_login
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_login\output;

use cache;
use Mustache_Engine;
use Mustache_Exception;

/**
 * Output buttons.
 */
class renderer extends \plugin_renderer_base {

    /**
     * The path to the default template.
     */
    const DEFAULT_TEMPLATE_PATH = '/local/login/templates/login-minimal.mustache.default';

    /**
     * Output login page.
     *
     * @param string $wantsurl wantsurl to append to auth links.
     * @param bool $noredirect enable to prevent redirection.
     * @return string
     */
    public function render_login($wantsurl, $noredirect = false) {
        global $CFG;
        $config = get_config('local_login');
        $mustachecontext = new \stdClass();
        $mustachecontext->pageheader = $this->output->header();
        $mustachecontext->pagefooter = $this->output->footer();

        $idplist = [];
        $authsequence = get_enabled_auth_plugins(); // Get all auths, in sequence.
        foreach ($authsequence as $authname) {
            if ($authname === 'mnet' && empty(get_config('local_login', 'showmnet'))) {
                // Don't show mnet options on the page.
                continue;
            }
            $authplugin = get_auth_plugin($authname);
            $potentialidps = $authplugin->loginpage_idp_list($wantsurl);
            if (!empty($potentialidps)) {
                foreach ($potentialidps as $idp) {
                    $idpcontext = [
                        'auth' => $authname,
                        'name' => s($idp['name']),
                        'url' => $idp['url']
                    ];
                    if (!empty($idp['iconurl'])) {
                        $idpcontext['iconurl'] = s($idp['iconurl']);
                    }
                    $idplist[] = (object) $idpcontext;
                }
            }
        }
        $mustachecontext->idplist = $idplist;

        // If only one IDP is available in authentication plugins then auto-redirect to it.
        if (count($idplist) === 1 && get_config('local_login', 'autoredirect')  && empty($noredirect)) {
            $idp = reset($idplist);
            redirect($idp['url']);
        }

        // If data exists in the cache, use it if it is still valid.
        // We need to check this after calculating the IDP data to ensure its current.
        $cache = cache::make('local_login', 'renderedlogin');
        $cachehash = $cache->get('idphash');
        $idphash = sha1(json_encode($idplist));
        $cacheval = $cache->get('html');
        if ($cachehash === $idphash && !empty($cacheval)) {
            return $cacheval;
        }

        // Create manual config seperately. No icon, no URL on the auth object.
        if (!empty($config->showmanual)) {
            $manual = new \stdClass();

            // Now display link to manual login page.
            $urlparams = [
                'noredirect' => 1,
                'passive' => 'off' // Prevent Saml2 from triggering passive check on manual login page.
            ];
            $manual->manualurl = new \moodle_url('/login/index.php', $urlparams);

            if (!empty($config->beforemanualtext)) {
                $manual->beforemanual = format_text($config->beforemanualtext);
            }

            $name = !empty($config->custommanualtext) ? format_string($config->custommanualtext) : get_string('manuallogin', 'local_login');
            $manual->manualname = $name;

            $mustachecontext->manual = $manual;
        }

        $mustachecontext->header = format_text($config->headertext);
        $mustachecontext->footer = format_text($config->footertext);

        // Try to load the template from settings.
        $template = $config->template ?? '';
        if (empty($template)) {
            $template = file_get_contents($CFG->dirroot . self::DEFAULT_TEMPLATE_PATH);
        }

        // Custom mustache engine to load a string into context.
        // Core only allows templates to be on disk, we need to load from string.
        $engine = new Mustache_Engine([
            'escape' => 's',
            'pragmas' => [\Mustache_Engine::PRAGMA_BLOCKS],
        ]);

        try {
            $html = $engine->render($template, $mustachecontext);
        } catch (Mustache_Exception $e) {
            // If something went wrong, fall back to the base template so there is *something*.
            // If it explodes here, there are bigger problems.
            $html = $engine->render(file_get_contents($CFG->dirroot . self::DEFAULT_TEMPLATE_PATH), $mustachecontext);
        }
        $cache->set('html', $html);
        $cache->set('idphash', $idphash);
        return $html;
    }
}
