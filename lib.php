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
 * local_login callbacks.
 * @copyright  Catalyst IT 2022
 * @package    local_login
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Triggers after site config is loaded. It is used to direct user to the custom login page.
 *
 */
function local_login_after_config() {
    global $CFG, $FULLME;
    $noredirect  = optional_param('noredirect', 0, PARAM_BOOL); // Don't redirect.
    if (stripos($FULLME, $CFG->wwwroot.'/login/index.php') === 0 &&
       !isloggedin() && !empty($noredirect) && !empty($CFG->alternateloginurl)) {

        unset($CFG->alternateloginurl);
    }
}
