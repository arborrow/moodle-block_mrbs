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
include "config.inc.php";
include "functions.php";

$id = required_param('id', PARAM_INT);
$day = optional_param('day', 0, PARAM_INT);
$month = optional_param('month', 0, PARAM_INT);
$year = optional_param('year', 0, PARAM_INT);
$area = optional_param('area', 0, PARAM_INT);
$room = optional_param('room', 0, PARAM_INT);
$series = optional_param('series', 0, PARAM_INT);
$pview = optional_param('pview', 0, PARAM_INT);

if ($CFG->version < 2011120100) {
    $context = get_context_instance(CONTEXT_SYSTEM);
} else {
    $context = context_system::instance();
}

//if the booking belongs to the user looking at it, they probably want to edit it
if($record=$DB->get_record('block_mrbs_entry',array('id'=>$id))) {
    if(strtolower($record->create_by)==strtolower($USER->username)) {
        $redirect = true;
        if (has_capability('block/mrbs:editmrbsunconfirmed', $context, null, false)) {
            if ($USER->email != $DB->get_field('block_mrbs_room', 'room_admin_email', array('id'=>$record->room_id))) {
                if ($record->type != 'U') {
                    $redirect = false;  // Do not redirect to edit screen if the booking is confirmed
                }
            }
        }
        if ($redirect) {
            redirect(new moodle_url('/blocks/mrbs/web/edit_entry.php', array('id'=>$id)));
        }
    }
}

//If we dont know the right date then make it up
if(($day==0) or ($month==0) or ($year==0)) {
	$day   = date("d");
	$month = date("m");
	$year  = date("Y");
}

$thisurl = new moodle_url('/blocks/mrbs/web/view_entry.php', array('day'=>$day, 'month'=>$month, 'year'=>$year, 'id'=>$id));

if($area) {
    $thisurl->param('area', $area);
} else {
    $area = get_default_area();
}
if ($room) {
    $thisurl->param('room', $room);
}
if ($series) {
    $thisurl->param('series', $series);
}
if ($pview) {
    $thisurl->param('pview', $pview);
}

$PAGE->set_url($thisurl);
require_login();

if ($series) {
    $sql = "SELECT re.name,
            re.description,
	        re.create_by,
	        r.room_name,
	        a.area_name,
	        re.type,
	        re.room_id,
	        re.timestamp,
	        (re.end_time - re.start_time) duration,
	        re.start_time,
	        re.end_time,
	        re.rep_type,
	        re.end_date,
	        re.rep_opt,
	        re.rep_num_weeks,
	        u.id as userid,
            u.firstname,
            u.lastname
			FROM  {block_mrbs_repeat} re left join {user} u on u.username = re.create_by, {block_mrbs_room} r, {block_mrbs_area} a
			WHERE re.room_id = r.id
			AND r.area_id = a.id
			AND re.id= ?";
} else {
	$sql = "SELECT e.name,
	        e.description,
	        e.create_by,
	        r.room_name,
	        a.area_name,
	        e.type,
	        e.room_id,
	        e.timestamp,
	       	(e.end_time - e.start_time) duration,
	        e.start_time,
	        e.end_time,
	        e.repeat_id,
	        u.id as userid,
            u.firstname,
            u.lastname
			FROM  {block_mrbs_entry} e left join {user} u on u.username = e.create_by, {block_mrbs_room} r, {block_mrbs_area} a
			WHERE e.room_id = r.id
			AND r.area_id = a.id
			AND e.id= ?";
}

$booking = $DB->get_record_sql($sql, array($id), MUST_EXIST);
$booking->fullname = fullname($booking);

// Note: Removed stripslashes() calls from name and description. Previous
// versions of MRBS mistakenly had the backslash-escapes in the actual database
// records because of an extra addslashes going on. Fix your database and
// leave this code alone, please.
$name         = s($booking->name);
$description  = s($booking->description);
$userurl      = new moodle_url('/user/view.php', array('id'=>$booking->userid));
$create_by    = '<a href="'.$userurl.'">'.s($booking->fullname).'</a>';
$room_name    = s($booking->room_name);
$area_name    = s($booking->area_name);
$type         = $booking->type;
$room_id      = $booking->room_id;
$updated      = time_date_string($booking->timestamp);
// need to make DST correct in opposite direction to entry creation
// so that user see what he expects to see
$duration     = $booking->duration - cross_dst($booking->start_time, $booking->end_time);

if ($enable_periods) {
	list( $start_period, $start_date) =  period_date_string($booking->start_time);
} else {
    $start_date = time_date_string($booking->start_time);
}

if ($enable_periods) {
    list( , $end_date) =  period_date_string($booking->end_time, -1);
} else {
    $end_date = time_date_string($booking->end_time);
}

$rep_type = 0;

if ($series == 1) {
	$rep_type     = $booking->rep_type;
	$rep_end_date = userdate($booking->end_date, '%A %d %B %Y');
	$rep_opt      = $booking->rep_opt;
	$rep_num_weeks = $booking->rep_num_weeks;
    $repeat_id = false;
	// I also need to set $id to the value of a single entry as it is a
	// single entry from a series that is used by del_entry.php and
	// edit_entry.php
	// So I will look for the first entry in the series where the entry is
	// as per the original series settings
    $entry = $DB->get_records('block_mrbs_entry', array('repeat_id'=>$id, 'entry_type'=>1), 'start_time', 'id', 0, 1);
    if (empty($entry)) {
		// if all entries in series have been modified then
		// as a fallback position just select the first entry
		// in the series
		// hopefully this code will never be reached as
		// this page will display the start time of the series
		// but edit_entry.php will display the start time of the entry
        $entry = $DB->get_records('block_mrbs_entry', array('repeat_id'=>$id), 'start_time', 'id', 0, 1);
	}
    $entry = reset($entry); // Get the first (and only) record
    $id = $entry->id;
} else {
	$repeat_id = $booking->repeat_id;
	if ($repeat_id != 0) {
        $repeat = $DB->get_record('block_mrbs_repeat', array('id'=>$repeat_id));
        if ($repeat) {
			$rep_type     = $repeat->rep_type;
			$rep_end_date = userdate($repeat->end_date, '%A %d %B %Y');
			$rep_opt      = $repeat->rep_opt;
			$rep_num_weeks = $repeat->rep_num_weeks;
		}
	}
}

$enable_periods ? toPeriodString($start_period, $duration, $dur_units) : toTimeString($duration, $dur_units);

$repeat_key = "rep_type_" . $rep_type;

$roomadmin = false;
if (has_capability('block/mrbs:editmrbsunconfirmed', $context, null, false)) {
    $adminemail = $DB->get_field('block_mrbs_room', 'room_admin_email', array('id'=>$booking->room_id));
    if ($adminemail == $USER->email) {
        $roomadmin = true;
    }
}

if ($roomadmin && $type == 'U') {
    redirect(new moodle_url('/blocks/mrbs/web/edit_entry.php', array('id'=>$id)));
}
// Now that we know all the data we start drawing it
print_header_mrbs($day, $month, $year, $area);
?>

<H3>
    <?php
    if ($course = $DB->get_record('course',array('shortname'=>$name))) {
        $courseurl = new moodle_url('/course/view.php', array('id'=>$course->id));
        echo '<a href="'.$courseurl.'">'.$name.'</a>';
        $sizequery="SELECT count(*) as size
                    FROM {context} cx
                        JOIN {role_assignments} ra ON ra.contextid = cx.id
                            AND ra.roleid=5
                        JOIN {course} c ON cx.contextlevel = 50
                            AND cx.instanceid = c.id
                    WHERE c.id  = ?";
        $size = $DB->get_record_sql($sizequery, array($course->id));
        echo '<br />class size: '.$size->size;
    } else {
        echo $name;
    }
    ?>
</H3>

<table border=0>
    <tr>
        <td><b><?php echo get_string('description') ?></b></td>
        <td><?php    echo nl2br($description) ?></td>
    </tr>
    <tr>
        <td><b><?php echo get_string('room','block_mrbs').":" ?></b></td>
        <td><?php    echo  nl2br($area_name . " - " . $room_name) ?></td>
    </tr>
    <tr>
        <td><b><?php echo get_string('start_date','block_mrbs') ?></b></td>
        <td><?php    echo $start_date ?></td>
    </tr>
    <tr>
        <td><b><?php echo get_string('duration','block_mrbs') ?></b></td>
        <td><?php    echo $duration . " " . $dur_units ?></td>
    </tr>
    <tr>
        <td><b><?php echo get_string('end_date','block_mrbs') ?></b></td>
        <td><?php    echo $end_date ?></td>
    </tr>
    <tr>
        <td><b><?php echo get_string('type','block_mrbs') ?></b></td>
        <td><?php    echo empty($typel[$type]) ? "?$type?" : $typel[$type] ?></td>
    </tr>
    <tr>
        <td><b><?php echo get_string('createdby','block_mrbs') ?></b></td>
        <td><?php    echo $create_by ?></td>
    </tr>
    <tr>
        <td><b><?php echo get_string('lastmodified') ?></b></td>
        <td><?php    echo $updated ?></td>
    </tr>
    <tr>
        <td><b><?php echo get_string('rep_type','block_mrbs') ?></b></td>
        <td><?php    echo get_string($repeat_key,'block_mrbs') ?></td>
    </tr>

<?php

if ($rep_type != 0) {
	$opt = "";
	if (($rep_type == 2) || ($rep_type == 6)) {
		// Display day names according to language and preferred weekday start.
		for ($i = 0; $i < 7; $i++) {
			$daynum = ($i + $weekstarts) % 7;
			if ($rep_opt[$daynum]) {
			    $opt .= day_name($daynum) . " ";
			}
		}
	}
	if ($rep_type == 6)	{
		echo "<tr><td><b>".get_string('rep_num_weeks','block_mrbs').get_string('rep_for_nweekly','block_mrbs')."</b></td><td>$rep_num_weeks</td></tr>\n";
	}
	if($opt) {
	    echo "<tr><td><b>".get_string('rep_rep_day','block_mrbs')."</b></td><td>$opt</td></tr>\n";
	}
	echo "<tr><td><b>".get_string('rep_end_date','block_mrbs')."</b></td><td>$rep_end_date</td></tr>\n";
}

?>

</table>
<br />
<p>

<?php

$canedit = getWritable($booking->create_by, getUserName());
if ($canedit || $roomadmin) {
    if (!$series) {
        $editurl = new moodle_url('/blocks/mrbs/web/edit_entry.php', array('id'=>$id));
        echo '<a href="'.$editurl.'">'. get_string('editentry','block_mrbs') ."</a>";
    }
    if($repeat_id) {
        echo " - ";
    }
    if($repeat_id || $series ) {
        $editurl = new moodle_url('/blocks/mrbs/web/edit_entry.php', array('id'=>$id, 'edit_type'=>'series', 'day'=>$day, 'month'=>$month, 'year'=>$year));
        echo '<a href="'.$editurl.'">'.get_string('editseries','block_mrbs')."</a>";
    }

    echo '<br />';

    if (!$series) {
        $delurl = new moodle_url('/blocks/mrbs/web/del_entry.php', array('id'=>$id, 'series'=>0, 'sesskey'=>sesskey()));
        echo '<A HREF="'.$delurl.'" onClick="return confirm("'.get_string('confirmdel','block_mrbs').'");">'.get_string('deleteentry','block_mrbs')."</A>";
    }

    if($repeat_id) {
        echo " - ";
    }

    if($repeat_id || $series ) {
        $delurl = new moodle_url('/blocks/mrbs/web/del_entry.php', array('id'=>$id, 'series'=>1, 'sesskey'=>sesskey(), 'day'=>$day, 'month'=>$month, 'year'=>$year));
        echo '<A HREF="'.$delurl.'" onClick="return confirm("'.get_string('confirmdel','block_mrbs').'");">'.get_string('deleteseries','block_mrbs')."</A>";
    }
} // Writable
?>

<br />

<?php

if (strtolower($USER->username) != strtolower($create_by)) {
    include "request_vacate.php";
}

include "trailer.php";