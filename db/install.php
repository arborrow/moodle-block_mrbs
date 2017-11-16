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

defined('MOODLE_INTERNAL') || die();

function xmldb_block_mrbs_install() {
    global $DB;

    // Get system context.
    $context = context_system::instance();

    // Create the viewer role.
    if (!$DB->record_exists('role', array('shortname' => 'mrbsviewer'))) {
        $mrbsviewerid = create_role(get_string('mrbsviewer', 'block_mrbs'), 'mrbsviewer',
                                    get_string('mrbsviewer_desc', 'block_mrbs'));
        set_role_contextlevels($mrbsviewerid, array(CONTEXT_SYSTEM));
        assign_capability('block/mrbs:viewmrbs', CAP_ALLOW, $mrbsviewerid, $context->id, true);
    }

    // Create the editor role.
    if (!$DB->record_exists('role', array('shortname' => 'mrbseditor'))) {
        $mrbseditorid = create_role(get_string('mrbseditor', 'block_mrbs'), 'mrbseditor',
                                    get_string('mrbseditor_desc', 'block_mrbs'));
        set_role_contextlevels($mrbseditorid, array(CONTEXT_SYSTEM));
        assign_capability('block/mrbs:viewmrbs', CAP_ALLOW, $mrbseditorid, $context->id, true);
        assign_capability('block/mrbs:editmrbs', CAP_ALLOW, $mrbseditorid, $context->id, true);
    }

    // Create the admin role.
    if (!$DB->record_exists('role', array('shortname' => 'mrbsadmin'))) {
        $mrbsadminid = create_role(get_string('mrbsadmin', 'block_mrbs'), 'mrbsadmin',
                                   get_string('mrbsadmin_desc', 'block_mrbs'));
        set_role_contextlevels($mrbsadminid, array(CONTEXT_SYSTEM));
        assign_capability('block/mrbs:viewmrbs', CAP_ALLOW, $mrbsadminid, $context->id, true);
        assign_capability('block/mrbs:editmrbs', CAP_ALLOW, $mrbsadminid, $context->id, true);
        assign_capability('block/mrbs:administermrbs', CAP_ALLOW, $mrbsadminid, $context->id, true);
        assign_capability('block/mrbs:viewalltt', CAP_ALLOW, $mrbsadminid, $context->id, true);
        assign_capability('block/mrbs:forcebook', CAP_ALLOW, $mrbsadminid, $context->id, true);
        assign_capability('block/mrbs:doublebook', CAP_ALLOW, $mrbsadminid, $context->id, true);
    }

    // Add context level block to manager, student, editingteacher archetype
    $roles = ('student', 'editingteacher','manager');
    foreach($roles as $role) {
        $roleid = $DB->get_field('role', 'id', array('shortname' => $role), MUST_EXIST);
        if(! $roleid) {
            throw new \coding_exception("The \'".$role."\' role must exist<br/>\n");
        }
        $levels = get_role_contextlevels($roleid);
        if(! in_array(CONTEXT_BLOCK, $levels)) {
            array_push($levels, CONTEXT_BLOCK);
            set_role_contextlevels($roleid, $levels);
        }
    }

    // Clear any capability caches
    $context->mark_dirty();
}
