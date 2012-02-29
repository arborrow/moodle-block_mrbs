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

/*
 *
 * Assigns MRBS access levels based on the user status
 * within your Moodle installation.
 *
 *
 * MRBS Levels
 * 0 - View only
 * 1 - View and make bookings
 * 2 - Full administration - add rooms and bookings
 *
 * Moodle Integration
 * Defines one of the above levels to admins, teachers
 * students, creators, and guests seperately.
 *
 * Used in conjunction with session_moodle.inc
 *
 * To use this authentication scheme set the following
 * things in config.inc.php:
 *
 *      $auth["type"]    = "moodle";
 *      $auth["session"] = "moodle";
 *
 */

require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/config.php'); //for Moodle integration

function authValidateUser($user, $pass) {
    return 1;
}

function authGetUserLevel($user) {
    // HACK For Moodle 1.7 With Roles Block...
    global $CFG;
    if ($CFG->version < 2011120100) {
        $context = get_context_instance(CONTEXT_SYSTEM);
    } else {
        $context = context_system::instance();
    }

    // Set Access leve for users via MRBS block and Moodle 1.7 roles
    if (has_capability('block/mrbs:administermrbs', $context)) {
        return 2;
    }
    // has_capability('block/mrbs:editmrbs', $context)
    if (has_capability('block/mrbs:editmrbs', $context)) {
        return 1;
    }
    if (has_capability('block/mrbs:editmrbsunconfirmed', $context, null, false)) {
        return 1; // Can book rooms, but only as 'unconfirmed' (unless they are the room admin)
    }
    if (has_capability('block/mrbs:viewmrbs', $context)) {
        return 0;
    } else { // Set access level for other users (e.g. people who access url directly)
        return 0;
    }
}
