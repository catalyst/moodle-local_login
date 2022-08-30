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
 * Libs.
 * @copyright  Catalyst IT 2022
 * @package    local_login
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Triggers after site config is loaded. It is used to
 *
 */
function local_login_after_config() {
    global $CFG, $SESSION, $_SERVER, $USER, $DB;
    $errorcode = 0;
    $noredirect  = optional_param('noredirect', 0, PARAM_BOOL); // don't redirect
    if (!isloggedin()) {
        // Set new login URL.
        $loginurl = new moodle_url('/local/login/index.php');
        $loginurlstr = $loginurl->out(false);

        // To stop redirect if alternateloginurl is set.
        if (!empty($CFG->alternateloginurl)) {
            unset($CFG->alternateloginurl);
        }

        if (!empty($SESSION->wantsurl) && strpos($SESSION->wantsurl, $loginurlstr) === 0) {
            // We do not want to return to alternate url.
            $SESSION->wantsurl = null;
        } else if (isset($_SERVER['REQUEST_URI'])) {
            $currenturl = $_SERVER['REQUEST_URI'];
            if (strpos($currenturl, 'login') && (strlen(strtok($currenturl, '?')) == 16)
            && $noredirect != 1 && !(strpos($currenturl, 'local/login'))) {
                // If error code then add that to url.
                if ($errorcode) {
                    $loginurl->param('errorcode', $errorcode);
                }
                redirect($loginurl->out(false));
            }
        }
    }
}


