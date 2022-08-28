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
     * Add div with background image to header
     * @param string The url of the background image
     * @return string
     */
    public function render_backgroundimage($url) {
        $output = "<div class='backgroundimage' style='background-image: url(\" ". $url ." \" )'>";
        return $output;
    }

    /**
     * Closes the div with the background image
     *
     */
    public function local_login_before_footer() {
        return "</div>";
    }
}
