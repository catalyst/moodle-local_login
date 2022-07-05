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
 * Generalised loginpage
 * @copyright  Catalyst IT 2022
 * @author     Sasha Anastasi <sasha.anastasi@catalyst.net.nz>,
 *             Jonathan Harker <jonathan@catalyst.net.nz>,
 *             Eugene Venter <eugene@catalyst.net.nz>
 * @package    local_login
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot.'/login/lib.php');
require_once($CFG->libdir.'/authlib.php');

if (isloggedin()) {
    // User already logged in.
    $urltogo = core_login_get_return_url();
    unset($SESSION->wantsurl);
    redirect($urltogo);
}

$wantsurl = empty($SESSION->wantsurl) ? '' : $SESSION->wantsurl;

$context = context_system::instance();
$PAGE->set_url("{$CFG->wwwroot}/local/login/index.php");
$PAGE->set_context($context);
$PAGE->set_pagelayout('login');

// Define variables used in page.
$site = get_site();

// Ignore any active pages in the navigation/settings.
// We do this because there won't be an active page there, and by ignoring the active pages the
// navigation and settings won't be initialised unless something else needs them.
$PAGE->navbar->ignore_active();
$loginsite = get_string("loginsite");
$PAGE->navbar->add($loginsite);
echo $OUTPUT->header();

$config = get_config('local_login');
if (!empty($config->headertext)) {
    echo format_text($config->headertext);
}

echo \local_login\output\login::output_login_options($wantsurl);

if (!empty($config->footertext)) {
    echo format_text($config->footertext);
}

echo $OUTPUT->footer();
