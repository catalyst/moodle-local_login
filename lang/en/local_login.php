<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin strings are defined here.
 *
 * @package     local_login
 * @category    string
 * @copyright   2022 Catalyst IT
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Login splash page';
$string['privacy:metadata'] = 'The Local splash page plugin does not store any personal data.';
$string['manuallogin'] = 'Manual login';
$string['manuallogindesc'] = 'If you need to log in with your site username and its password, click here to proceed to the local login page.';
$string['showmanual'] = 'Show manual login link';
$string['showmanual_desc'] = 'If enabled, a link to the manual login page will be added to the list.';
$string['custommanualtext'] = 'Manual login text';
$string['custommanualtext_desc'] = 'If set, replaces the default "Manual login" text shown on the manual login link';
$string['beforemanualtext'] = 'Before manual login text';
$string['beforemanualtext_desc'] = 'If set, allows some text to be injected between the list of IDP/SSO links and the link to the manual login page';
$string['headertext'] = 'Header text';
$string['headertext_desc'] = 'Text that appears before the login links.';
$string['footertext'] = 'Footer text';
$string['footertext_desc'] = 'Text that appears after the login links.';
$string['settings'] = 'Login splash page settings';
$string['usecustommanual'] = 'Use custom manual login';
$string['usecustommanual_desc'] = 'If you have not applied the noredirect.patch on your site, this box must be ticked for the manual login page to work.';
$string['customlogindisabled'] = 'Site settings prevent this page from being used.';
$string['backgroundimage'] = 'Background image';
$string['backgroundimage_desc'] = 'Background image that appears on the local login page.';
