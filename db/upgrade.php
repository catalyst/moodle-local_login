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
 * Upgrade code for the assignfeedback_apt module.
 *
 * @package   assignfeedback_apt
 * @copyright 2022 Catalyst IT Ltd
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Set the initial order for the feedback apt plugin (top)
 * @return bool
 */
function xmldb_local_login_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager(); // Loads ddl manager and xmldb classes.

    if ($oldversion < 2022070501) {
        $table = new xmldb_table('local_login');
        // Adding fields to table local_login.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('redirected', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('sesskey', XMLDB_TYPE_TEXT, null, null, null, null, null);
        // Adding keys to table local_login.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Adding indexes to table local_login.
        $table->add_index('userid', XMLDB_INDEX_UNIQUE, ['userid']);
        $table->add_index('redirected', XMLDB_INDEX_NOTUNIQUE, ['redirected']);

        // Conditionally launch create table for local_login.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Login savepoint reached.
        upgrade_plugin_savepoint(true, 2022070501, 'local', 'login');
    }
    return true;
}
