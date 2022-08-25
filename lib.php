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

defined('MOODLE_INTERNAL') || die();

/**
 * Copy the updated background image to the correct location in dataroot for the image to be served
 * by /theme/image.php. Also clear theme caches.
 *
 */
function local_login_backgroundimage() {
    global $CFG;

    // This is the component name the setting is stored in.
    $component = 'local_login';

    // This is the field name the setting is stored in.
    $settingname = 'backgroundimage';

    $filename = get_config($component, $settingname);

    // We extract the file extension because we want to preserve it.
    $extension = substr($filename, strrpos($filename, '.') + 1);

    // Admin settings are stored in system context.
    $syscontext = context_system::instance();
    // This is the path in the moodle internal file system.
    $fullpath = "/{$syscontext->id}/{$component}/{$settingname}/0{$filename}";

    // This location matches the searched for location in theme_config::resolve_image_location.
    $pathname = $CFG->dataroot . '/pix_plugins/local/login/' . $settingname . '.' . $extension;

    // This pattern matches any previous files with maybe different file extensions.
    $pathpattern = $CFG->dataroot . '/pix_plugins/local/login/' . $settingname . '.*';

    // Make sure this dir exists.
    @mkdir($CFG->dataroot . '/pix_plugins/local/login/', $CFG->directorypermissions, true);

    // Delete any existing files for this setting.
    foreach (glob($pathpattern) as $filename) {
        @unlink($filename);
    }

    // Get an instance of the moodle file storage.
    $fs = get_file_storage();
    // This is an efficient way to get a file if we know the exact path.
    if ($file = $fs->get_file_by_hash(sha1($fullpath))) {
        // We got the stored file - copy it to dataroot.
        $file->copy_content_to($pathname);
    }

    // Reset theme caches.
    theme_reset_all_caches();
}

