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
 * Add page to admin menu.
 *
 * @package    local_login
 * @copyright  2022 Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
require_once(__DIR__ . '/lib.php');

if ($hassiteconfig) { // Needs this condition or there is error on login page.
    $settings = new admin_settingpage(
        'local_login_settings', get_string('settings', 'local_login'));

    $settings->add(new admin_setting_configcheckbox('local_login/showmanual',
        get_string('showmanual', 'local_login'),
        get_string('showmanual_desc', 'local_login'),
        1)
    );

    $settings->add(new admin_setting_configcheckbox('local_login/usecustommanual',
        get_string('usecustommanual', 'local_login'),
        get_string('usecustommanual_desc', 'local_login'),
        0)
    );

    $settings->add(new admin_setting_configtext('local_login/custommanualtext',
        get_string('custommanualtext', 'local_login'),
        get_string('custommanualtext_desc', 'local_login'),
        '')
    );

    $settings->add(new admin_setting_configtextarea('local_login/headertext',
        get_string('headertext', 'local_login'),
        get_string('headertext_desc', 'local_login'),
        '')
    );

    $settings->add(new admin_setting_configtextarea('local_login/beforemanualtext',
        get_string('beforemanualtext', 'local_login'),
        get_string('beforemanualtext_desc', 'local_login'),
        '')
    );

    $settings->add(new admin_setting_configtextarea('local_login/footertext',
        get_string('footertext', 'local_login'),
        get_string('footertext_desc', 'local_login'),
    	'')
    );

    $backgroundimage = new admin_setting_configstoredfile(
        'local_login/backgroundimage',
        get_string('backgroundimage', 'local_login'),
        get_string('backgroundimage_desc', 'local_login'),
        'backgroundimage', 0, array('maxfiles' => 1));
    $backgroundimage->set_updatedcallback('local_login_backgroundimage');
    $settings->add($backgroundimage);

    $ADMIN->add('localplugins', $settings);
}
