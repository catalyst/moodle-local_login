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
 * Updates the background image of the login page.
 *
 * @package   local_login
 * @author    Sumaiya Javed <sumaiya.javed@catalyst.net.nz>
 * @copyright Catalyst IT
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

define([], function() {
    return {
        init: function() {
            var backgroundimage = document.querySelector('.backgroundimage').innerHTML;
            var value = "background-image: url('" + backgroundimage + "')";
            document.querySelector('#page-content').setAttribute('style', value);
        }
    };
});
