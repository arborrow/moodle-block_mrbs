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

function renameifexists($dbman, $tablename) {
    global $DB, $CFG;

    $oldname = $tablename;
    $newname = $CFG->prefix.$tablename;

    $tbl = $DB->get_records_sql('SELECT table_name FROM information_schema.tables WHERE table_name = ? AND table_schema = ?',
                                array($oldname, $CFG->dbname));
    if (empty($tbl)) {
        // Old table does not exist - nothing to do
        return;
    }

    $newtbl = new xmldb_table($tablename);
    if ($dbman->table_exists($newtbl)) {
        // New table already exists
        $newhasdata = $DB->count_records($tablename);
        if (!$newhasdata) {
            // New table exists, but is empty - drop it, then carry on with the rename below
            $dbman->drop_table($newtbl);
        } else {
            $oldhasdata = $DB->count_records_sql('SELECT COUNT(*) FROM '.$oldname);
            if (!$oldhasdata) {
                // New table has data, old table does not - just drop the old one
                $DB->execute('DROP TABLE '.$oldname);
                return;
            } else {
                // Both contain data - display error and halt upgrade
                echo "Database tables '$oldname' and '$newname' both exist and both contain data<br/>";
                echo 'There is no way to automatically upgrade the database - please manually delete one of these tables, before trying to upgrade<br/>';
                die();
            }
        }
    }

    // I would like to use this function, but it is protected
    //$dbman->execute_sql('ALTER TABLE '.$oldname.' RENAME TO '.$newname);
    // Rename the old table to the new table name
    $DB->execute('ALTER TABLE '.$oldname.' RENAME TO '.$newname);
}

function block_mrbs_convert_timestamp($tablename, $fieldname) {
    global $DB;

    // Check to see if the field is currently of type 'timestamp'.
    $fielddef = $DB->get_record_sql("SHOW COLUMNS FROM {".$tablename."} LIKE '".$fieldname."'");
    if (!$fielddef) {
        die("$fieldname does not exist in table $tablename");
    }
    if ($fielddef->type != 'timestamp') {
        echo "$tablename.$fieldname does not need converting<br/>\n";
        return;
    }

    // Create a temporary field called '[fieldname]_conv'.
    $dbman = $DB->get_manager();
    $tempfield = "{$fieldname}_conv";
    $table = new xmldb_table($tablename);
    $field = new xmldb_field($tempfield, XMLDB_TYPE_INTEGER, 11, null, null, null, null, $fieldname);
    if (!$dbman->field_exists($table, $field)) {
        $dbman->add_field($table, $field);
    }
    // Copy & convert the current date from [fieldname] => [fieldname]_conv
    $DB->execute('UPDATE {'.$tablename.'} SET '.$tempfield.' = UNIX_TIMESTAMP('.$fieldname.')');

    // Rename [fieldname] => [fieldname]_backup + rename [fieldname]_conv => [fieldname]
    $backupfield = "{$fieldname}_backup";
    $DB->execute('ALTER TABLE {'.$tablename.'} CHANGE '.$fieldname.' '.$backupfield.' TIMESTAMP');
    $dbman->rename_field($table, $field, $fieldname);

    echo "$tablename.$fieldname converted from timestamp to integer (backup data in $tablename.$backupfield)<br/>\n";
}

function xmldb_block_mrbs_upgrade($oldversion=0) {
    global $DB, $CFG;

    $dbman = $DB->get_manager();

    if ($oldversion < 2011050600) {
        // Cannot use the built-in Moodle database manipulation commands, as they all assume the prefix
        renameifexists($dbman, 'mrbs_area');
        renameifexists($dbman, 'mrbs_entry');
        renameifexists($dbman, 'mrbs_repeat');
        renameifexists($dbman, 'mrbs_room');

        upgrade_block_savepoint(true, 2011050600, 'mrbs');
    }

    if ($oldversion < 2011111200) {
        $table = new xmldb_table('mrbs_room');
        $field = new xmldb_field('booking_users', XMLDB_TYPE_TEXT, 'medium', null, null, null, null, 'room_admin_email');

        // Conditionally launch add field booking_users
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // mrbs savepoint reached
        upgrade_block_savepoint(true, 2011111200, 'mrbs');
    }

    // Rename the tables to match the naming scheme required by Moodle.org
    if ($oldversion < 2012021300) {
        $table = new xmldb_table('mrbs_area');
        $dbman->rename_table($table, 'block_mrbs_area');

        $table = new xmldb_table('mrbs_entry');
        $dbman->rename_table($table, 'block_mrbs_entry');

        $table = new xmldb_table('mrbs_repeat');
        $dbman->rename_table($table, 'block_mrbs_repeat');

        $table = new xmldb_table('mrbs_room');
        $dbman->rename_table($table, 'block_mrbs_room');

        // mrbs savepoint reached
        upgrade_block_savepoint(true, 2012021300, 'mrbs');
    }

    if ($oldversion < 2012022700) {

        // Define field roomchange to be added to mrbs_entry
        $table = new xmldb_table('block_mrbs_entry');
        $field = new xmldb_field('roomchange', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'description');

        // Conditionally launch add field roomchange
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // mrbs savepoint reached
        upgrade_block_savepoint(true, 2012022700, 'mrbs');
    }

    // Fix any 'timestamp' fields left from a Moodle 1.9 upgrade.
    if ($oldversion < 2012091200) {
        if ($DB->get_dbfamily() == 'mysql') {
            echo "Converting timestamp fields (from early Moodle 1.9 versions of MRBS)<br/>\n";

            block_mrbs_convert_timestamp('block_mrbs_entry', 'start_time');
            block_mrbs_convert_timestamp('block_mrbs_entry', 'end_time');
            block_mrbs_convert_timestamp('block_mrbs_entry', 'timestamp');

            block_mrbs_convert_timestamp('block_mrbs_repeat', 'start_time');
            block_mrbs_convert_timestamp('block_mrbs_repeat', 'end_time');
            block_mrbs_convert_timestamp('block_mrbs_repeat', 'end_date');
            block_mrbs_convert_timestamp('block_mrbs_repeat', 'timestamp');

            // mrbs savepoint reached
            upgrade_block_savepoint(true, 2012091200, 'mrbs');
        }
    }

    return true;
}
