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
 * Moodle renderer used to display special elements of the local login page
 *
 * @copyright  Catalyst IT 2022
 * @package    local_login
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class local_login_renderer extends plugin_renderer_base {

    /**
     * Returns the header for the lesson module
     *
     * @param lesson $lesson a lesson object.
     * @param string $currenttab current tab that is shown.
     * @param bool   $extraeditbuttons if extra edit buttons should be displayed.
     * @param int    $lessonpageid id of the lesson page that needs to be displayed.
     * @param string $extrapagetitle String to appent to the page title.
     * @return string
     */
    public function header() {
        global $CFG;

        // Load background image.
        $url = '';
        $fs = get_file_storage();
        $context = \context_system::instance();
        $files = $fs->get_area_files($context->id, 'local_login', 'backgroundimage', 0, 'filepath, filename', false);
        if ($files) {
            foreach ($files as $file) {
                $url = \moodle_url::make_pluginfile_url(
                    $file->get_contextid(),
                    $file->get_component(),
                    $file->get_filearea(),
                    $file->get_itemid(),
                    $file->get_filepath(),
                    $file->get_filename()
                );
            }
        }

        $output = "<div style='background-image:url(".$url.")'>Start background image";
        $output .= $this->output->header();


        return $output;
    }

    /**
     * Returns the footer
     * @return string
     */
    public function footer() {
        $output = "Closing background image</div>";
        $output .= $this->output->footer();
        return $output;
    }

}