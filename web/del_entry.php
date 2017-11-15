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
global $PAGE, $DB, $USER;
include "config.inc.php";
include "functions.php";
require_once('mrbs_auth.php');
include "mrbs_sql.php";

$id = required_param('id', PARAM_INT);
$series = optional_param('series', 0, PARAM_INT);

$PAGE->set_url('/blocks/mrbs/web/del_entry.php', array('instance' => $instance_id, 'id' => $id));
require_login();

require_sesskey();

if (getAuthorised(1) && ($info = mrbsGetEntryInfo($instance_id, $id))) {
    $day = userdate($info->start_time, "%d");
    $month = userdate($info->start_time, "%m");
    $year = userdate($info->start_time, "%Y");
    $area = mrbsGetRoomArea($instance_id, $info->room_id);

    if (MAIL_ADMIN_ON_DELETE) { // Gather all fields values for use in emails.
        $mail_previous = getPreviousEntryData($id, $series);
    }
    $roomadmin = false;
    $context = context_system::instance();
    $PAGE->set_context($context);
    if (has_capability('block/mrbs:editmrbsunconfirmed', $context, null, false)) {
        $adminemail = $DB->get_field('block_mrbs_room', 'room_admin_email', array('instance' => $instance_id, 'id' => $info->room_id));
        if ($adminemail == $USER->email) {
            $roomadmin = true;
        }
    }
    $result = mrbsDelEntry(getUserName(), $instance_id, $id, $series, 1, $roomadmin);

    if ($result) {
        // Send a mail to the Administrator
        (MAIL_ADMIN_ON_DELETE) ? $result = notifyAdminOnDelete($instance_id, $mail_previous) : '';
        $desturl = new moodle_url('/blocks/mrbs/web/day.php', array(
            'instance' => $instance_id, 'day' => $day, 'month' => $month, 'year' => $year, 'area' => $area
        ));
        redirect($desturl);
        exit();
    }
}

// If you got this far then we got an access denied.
showAccessDenied($day, $month, $year, $area);
