<?php

// This file is part of the MRBS block for Moodle
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

function renameifexists($dbman, $oldname, $newname) {
    global $DB, $CFG;

    $tbl = $DB->get_records_sql('SELECT table_name FROM information_schema.tables WHERE table_name = ? AND table_schema = ?',
                                array($oldname, $CFG->dbname));
    if (empty($tbl)) {
        return;
    }

    // I would like to use this function, but it is protected
    //$dbman->execute_sql('ALTER TABLE '.$oldname.' RENAME TO '.$newname);
    $DB->execute('ALTER TABLE '.$oldname.' RENAME TO '.$newname);
}

function xmldb_block_mrbs_upgrade($oldversion=0) {
    global $DB, $CFG;

    $dbman = $DB->get_manager();

    if ($oldversion < 2011042600) {
        // Cannot use the built-in Moodle database manipulation commands, as they all assume the prefix
        renameifexists($dbman, 'mrbs_area', $CFG->prefix.'mrbs_area');
        renameifexists($dbman, 'mrbs_entry', $CFG->prefix.'mrbs_area');
        renameifexists($dbman, 'mrbs_repeat', $CFG->prefix.'mrbs_area');
        renameifexists($dbman, 'mrbs_room', $CFG->prefix.'mrbs_area');

        upgrade_block_savepoint(true, 2011042600, 'mrbs');
    }

}