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
 * @author  Sasha Anastasi <sasha.anastasi@catalyst.net.nz>,
 *          Jonathan Harker <jonathan@catalyst.net.nz>,
 *          Eugene Venter <eugene@catalyst.net.nz>
 * @package local_login
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_login\output;

/**
 * Output buttons.
 */
class login {

    /**
     * Output login buttons to page.
     *
     * @param string $wantsurl
     * @return string
     */
    public static function output_login_options($wantsurl) {
        // Could have used a renderer, but just nicer to have everything in the same file.
        global $OUTPUT;

        // Output.
        $output = '';
        $output .= \html_writer::start_tag('div', array('id' => 'local-login-options', 'class' => 'container-fluid'));

        $authsequence = get_enabled_auth_plugins(); // Get all auths, in sequence.
        $potentialidps = array();
        foreach ($authsequence as $authname) {
            $authplugin = get_auth_plugin($authname);
            $potentialidps = array_merge($potentialidps, $authplugin->loginpage_idp_list($this->page->url->out(false)));
        }

        if (!empty($potentialidps)) {
            foreach ($potentialidps as $idp) {
                $output .= \html_writer::start_tag('div', array('class' => 'idp-login container-fluid'));
                $output .= '<a class="btn btn-secondary btn-block" ';
                $output .= 'href="' . $idp['url']->out() . '" title="' . s($idp['name']) . '">';
                if (!empty($idp['iconurl'])) {
                    $output .= '<img src="' . s($idp['iconurl']) . '" width="24" height="24" class="mr-1"/>';
                }
                $output .= s($idp['name']) . '</a>';
                $output .= \html_writer::end_tag('div');
            }
        }

        // Now display link to manual login page.
        $urlparams = [
            'noredirect' => 1,
            'passive' => 'off'
        ];
        $manualloginurl = new \moodle_url('/login/index.php', $urlparams);
        $output .= \html_writer::start_tag('div', array('class' => 'manual-login container-fluid'));
        $output .= \html_writer::tag('p', get_string('manuallogindesc', 'local_pickerpage'), array('class' => 'option-desc'));
        $output .= $OUTPUT->single_button($manualloginurl, get_string('manuallogin', 'local_pickerpage'), 'get');
        $output .= \html_writer::end_tag('div');

        $output .= \html_writer::end_tag('div');

        return $output;
    }
}
