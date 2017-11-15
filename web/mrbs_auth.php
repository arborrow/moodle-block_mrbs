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

require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/config.php');

// include the authentification wrappers
include "auth_$auth[type].php";
if (isset($auth['session'])) {
    include "session_$auth[session].php";
}

/* getAuthorised($instance_id, $level)
 *
 * Check to see if the user has required access level
 *
 * $instance_id - MRBS instance
 * $level - The access level required
 *
 * Returns:
 *   0        - The user does not have the required access
 *   non-zero - The user has the required access
 */
function getAuthorised($instance_id, $level) {
    $user = getUserName();
    if (isset($user) == false) {
        authGet();
        return 0;
    }

    return authGetUserLevel($instance_id, $user) >= $level;
}

/* getWritable($instance_id, $creator, $user)
 *
 * Determines if a user is able to modify an entry
 *
 * $instance_id - MRBS instance
 * $creator - The creator of the entry
 * $user    - Who wants to modify it
 *
 * Returns:
 *   0        - The user does not have the required access
 *   non-zero - The user has the required access
 */
function getWritable($instance_id, $creator, $user) {
    // Always allowed to modify your own stuff
    if (strcasecmp($creator, $user) == 0) {
        return 1;
    }

    if (authGetUserLevel($instance_id, $user) >= 2) {
        return 1;
    }

    // Unathorised access
    return 0;
}

/* showAccessDenied()
 *
 * Displays an appropate message when access has been denied
 *
 * Retusns: Nothing
 */
function showAccessDenied($day, $month, $year, $instance_id, $area) {
    global $OUTPUT;

    print_header_mrbs($day, $month, $year, $instance_id, $area);
    echo $OUTPUT->box(get_string('accessdenied', 'block_mrbs').'<br/>'.get_string('norights', 'block_mrbs'), 'generalbox boxaligncenter');
    echo '<br/>';
    echo $OUTPUT->footer();
}
