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
$string['customlogindisabled'] = 'Site settings prevent this page from being used.';
$string['backgroundimage'] = 'Background image';
$string['backgroundimage_desc'] = 'Background image that appears on the local login page.';
$string['forcelogin'] = 'Force login when accessing site homepage';
$string['forcelogin_desc'] = 'If the user is accessing the site homepage and the user is not currently logged in, this will redirect them to the login page. 
Please note that if you are using a Totara 15+ site, you need to tick forceloginredirect setting below. ';
$string['forceloginredirect'] = 'Force login page redirect.';
$string['forceloginredirect_desc'] = 'This setting allow Totara sites to use this without needing to change the csrftoken setting. Currently applicable on Totara 15+ sites. Refer to TL-19365 for details. ';
$string['autoredirect'] = 'Auto-redirect to a single IDP option';
$string['autoredirect_desc'] = 'If only one IDP is available in authentication plugins then auto-redirect to it.  ';
$string['showmnet'] = 'Show mnet providers';
$string['showmnet_desc'] = 'If mnet is enabled, these options will be included on the local login page.';
$string['template'] = 'Login page template';
$string['template_desc'] = 'The template used for rendering the login page can be overridden here. Any styles required should be added inline to the template.';
$string['cachedef_renderedlogin'] = 'Cache for the rendered data for the frontpage based on configuration.';

