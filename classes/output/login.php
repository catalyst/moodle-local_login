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
 * Generalised login page
 * @copyright  Catalyst IT 2022
 * @package    local_login
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_login\output;

use Mustache_Engine;

/**
 * Output buttons.
 */
class login {

    /**
     * Output login page.
     *
     * @param string $wantsurl
     * @return string
     */
    public static function login($wantsurl) {
        global $CFG;

        $config = get_config('local_login');
        $context = new \stdClass();

        $idplist = [];
        $count = 0;
        $authsequence = get_enabled_auth_plugins(); // Get all auths, in sequence.
        foreach ($authsequence as $authname) {
            if ($authname == 'mnet' && empty(get_config('local_login', 'showmnet'))) {
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
                    $count++;
                    $idploginpath = $idp['url'];
                }
            }
        }
        $context->idplist = $idplist;
        
        // If only one IDP is available in authentication plugins then auto-redirect to it.
        $noredirect  = optional_param('noredirect', 0, PARAM_BOOL); // Don't redirect.
        if ($count === 1 && get_config('local_login', 'autoredirect')  && empty($noredirect)) {
            redirect($idploginpath);
        }

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

            $context->manual = $manual;
        }

        $context->header = format_text($config->headertext);
        $context->footer = format_text($config->footertext);

        $template = $config->template ?? '';
        if (empty($template)) {
            $template = file_get_contents($CFG->dirroot . '/local/login/templates/login-minimal.mustache');
        }

        // Custom mustache engine to load a string into context.
        $engine = new Mustache_Engine([
            'escape' => 's',
            'pragmas' => [\Mustache_Engine::PRAGMA_BLOCKS],
        ]);

        return $engine->render($template, $context);
    }
}
