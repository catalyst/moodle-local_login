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

namespace local_login\local\hooks;

/**
 * Class after_config
 *
 * @package    local_login
 * @author     Sumaiya Javed <sumaiya.javed@catalyst.net.nz>
 * @copyright  2024, Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class after_config {

    /**
     * Hook to be run after initial site config.
     *
     * See also https://docs.moodle.org/dev/Login_callbacks#after_config.
     *
     * @param \core\hook\after_config $hook
     */
    public static function callback(\core\hook\after_config $hook): void {

        global $CFG, $FULLME, $SESSION;

        if (during_initial_install() || isset($CFG->upgraderunning)) {
            // Do nothing during installation or upgrade.
            return;
        }

        try {
            $noredirect  = optional_param('noredirect', 0, PARAM_BOOL); // Don't redirect.
            $forceloginredirect = get_config('local_login', 'forceloginredirect');
            if (!empty($FULLME) && stripos($FULLME, $CFG->wwwroot.'/login/index.php') === 0 && !isloggedin()) {
                $noredirect = $noredirect || data_submitted() || !empty($SESSION->loginerrormsg);
                if (!empty($noredirect) && !empty($CFG->alternateloginurl)) {
                     unset($CFG->alternateloginurl);
                } else if (empty($noredirect) && $forceloginredirect) {
                    redirect($CFG->wwwroot.'/local/login/index.php');
                }
            }
            // If forcelogin is enabled then only logged in users can access site homepage.
            $forcelogin = get_config('local_login', 'forcelogin');
            $wwwrootpath = parse_url($CFG->wwwroot, PHP_URL_PATH);
            $fullmepath = !empty($FULLME) ? parse_url($FULLME, PHP_URL_PATH) : '';
            $path = '';
            if (!empty($wwwrootpath)) {
                $path = str_replace($wwwrootpath, "", $fullmepath);
            }
            if ((empty($noredirect) && empty($path) || $path == '/' || $path == '/index.php') && !isloggedin()
                && $forcelogin == 1 && stripos($FULLME, '/login/') === false) {
                redirect($CFG->wwwroot.'/login/index.php');
            }

        } catch (\Exception $exception) {
            debugging('local_login_after_config error', DEBUG_DEVELOPER, $exception->getTrace());
        }
    }
}

