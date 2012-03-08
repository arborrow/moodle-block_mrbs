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

/** mrbsCheckFree()
 *
 * Check to see if the time period specified is free
 *
 * $room_id   - Which room are we checking
 * $starttime - The start of period
 * $endtime   - The end of the period
 * $ignore    - An entry ID to ignore, 0 to ignore no entries
 * $repignore - A repeat ID to ignore everything in the series, 0 to ignore no series
 *
 * Returns:
 *   nothing   - The area is free
 *   something - An error occured, the return value is human readable
 */
function mrbsCheckFree($room_id, $starttime, $endtime, $ignore, $repignore)
{
    global $DB;
	global $enable_periods;
    global $periods;

    // Select any meetings which overlap ($starttime,$endtime) for this room:
	$sql = "start_time < ? AND end_time > ? AND room_id = ? ";

    $params = array($endtime, $starttime, $room_id);

	if ($ignore > 0) {
		$sql .= " AND id <> ?";
        $params[] = $ignore;
    }
	if ($repignore > 0) {
		$sql .= " AND repeat_id <> ?";
        $params[] = $repignore;
    }

    $entries = $DB->get_records_select('block_mrbs_entry', $sql, $params, 'start_time');

	if (empty($entries))
	{
		return "";
	}
	// Get the room's area ID for linking to day, week, and month views:
	$area = mrbsGetRoomArea($room_id);

	// Build a string listing all the conflicts:
	$err = "";
	foreach ($entries as $entry) {
		$starts = getdate($entry->start_time);
		$param_ym = array('area'=>$area, 'year'=>$starts['year'], 'month'=>$starts['mon']);
		$param_ymd = array_merge($param_ym, array('day'=>$starts['mday']));

		if( $enable_periods ) {
        	$p_num =$starts['minutes'];
        	$startstr = userdate($entry->start_time, '%A %d %B %Y, ') . $periods[$p_num];
        }
		else
        	$startstr = userdate($entry->start_time, '%A %d %B %Y %H:%M:%S');

        $viewurl = new moodle_url('/blocks/mrbs/web/view_entry.php', array('id'=>$entry->id));
        $dayurl = new moodle_url('/blocks/mrbs/web/day.php', $param_ymd);
        $weekurl = new moodle_url('/blocks/mrbs/web/week.php', array_merge($param_ymd, array('room'=>$room_id)));
        $monthurl = new moodle_url('/blocks/mrbs/web/month.php', array_merge($param_ym, array('room'=>$room_id)));

        $err .= "<LI><A HREF=\"".$viewurl."\">$entry->name</A>"
		. " ( " . $startstr . ") "
		. "(<A HREF=\"".$dayurl."\">".get_string('viewday','block_mrbs')."</a>"
		. " | <A HREF=\"".$weekurl."\">".get_string('viewweek','block_mrbs')."</a>"
		. " | <A HREF=\"".$monthurl."\">".get_string('viewmonth','block_mrbs')."</a>)";
	}

	return $err;
}

/** mrbsDelEntry()
 *
 * Delete an entry, or optionally all entrys.
 *
 * $user   - Who's making the request
 * $id     - The entry to delete
 * $series - If set, delete the series, except user modified entrys
 * $all    - If set, include user modified entrys in the series delete
 * $roomadminoverride - If set, then the user can delete the entry, even if they are not the original booker
 *
 * Returns:
 *   0        - An error occured
 *   non-zero - The entry was deleted
 */
function mrbsDelEntry($user, $id, $series, $all, $roomadminoverride = false) {
	global $DB;

	$repeat_id = $DB->get_field('block_mrbs_entry', 'repeat_id', array('id'=>$id));
	if ($repeat_id < 0)
		return 0;

	if($series) {
        $params = array('repeat_id'=>$repeat_id);
	} else {
        $params = array('id'=>$id);
    }

	$removed = 0;
    $entries = $DB->get_records('block_mrbs_entry', $params);
    foreach ($entries as $entry) {
		if(!$roomadminoverride && !getWritable($entry->create_by, $user))
			continue;

		if($series && $entry->entry_type == 2 && !$all)
			continue;

        $DB->delete_records('block_mrbs_entry', array('id'=>$entry->id));

        $removed++;
	}

	if ($repeat_id > 0 && $DB->count_records('block_mrbs_entry', array('repeat_id'=>$repeat_id)) == 0) {
        $DB->delete_records('block_mrbs_repeat', array('id'=>$repeat_id));
    }

	return $removed > 0;
}

/** mrbsCreateSingleEntry()
 *
 * Create a single (non-repeating) entry in the database
 *
 * $starttime   - Start time of entry
 * $endtime     - End time of entry
 * $entry_type  - Entry type
 * $repeat_id   - Repeat ID
 * $room_id     - Room ID
 * $owner       - Owner
 * $name        - Name
 * $type        - Type (Internal/External)
 * $description - Description
 * $oldid       - Id of the entry to update (0 for create new)
 *
 * Returns:
 *   0        - An error occured while inserting the entry
 *   non-zero - The entry's ID
 */
function mrbsCreateSingleEntry($starttime, $endtime, $entry_type, $repeat_id, $room_id,
                               $owner, $name, $type, $description, $oldid=0, $roomchange=false)
{
    global $DB;

    $add = new stdClass;
    $add->start_time = $starttime;
    $add->end_time = $endtime;
    $add->entry_type = $entry_type;
    $add->repeat_id = $repeat_id;
    $add->room_id = $room_id;
    $add->create_by = $owner;
    $add->name = $name;
    $add->type = $type;
    $add->description = $description;
    $add->timestamp = time();
    $add->roomchange = $roomchange;

	// make sure that any entry is of a positive duration
	// this is to trap potential negative duration created when DST comes
	// into effect
	if( $endtime > $starttime ) {
        if ($oldid) {
            $add->id = $oldid;
            $DB->update_record('block_mrbs_entry', $add);
            return $oldid;
        } else {
            return $DB->insert_record('block_mrbs_entry', $add);
        }
    }

    return 0;
}

/** mrbsCreateRepeatEntry()
 *
 * Creates a repeat entry in the data base
 *
 * $starttime   - Start time of entry
 * $endtime     - End time of entry
 * $rep_type    - The repeat type
 * $rep_enddate - When the repeating ends
 * $rep_opt     - Any options associated with the entry
 * $room_id     - Room ID
 * $owner       - Owner
 * $name        - Name
 * $type        - Type (Internal/External)
 * $description - Description
 *
 * Returns:
 *   0        - An error occured while inserting the entry
 *   non-zero - The entry's ID
 */
function mrbsCreateRepeatEntry($starttime, $endtime, $rep_type, $rep_enddate, $rep_opt,
                               $room_id, $owner, $name, $type, $description, $rep_num_weeks, $oldrepeatid = 0)
{
    global $DB;

    $add = new stdClass;

        // Mandatory things:
	$add->start_time = 	$starttime;
	$add->end_time = 	$endtime;
	$add->rep_type = 	$rep_type;
	$add->end_date =	$rep_enddate;
	$add->room_id =	    $room_id;
	$add->create_by =	$owner;
	$add->type =		$type;
	$add->name =		$name;
    $add->timestamp =   time();

	// Optional things, pgsql doesn't like empty strings!
	if (!empty($rep_opt)) {
        $add->rep_opt =	$rep_opt;
    } else {
        $add->rep_opt =	"0";
    }
    if (!empty($description)) {
        $add->description = $description;
    }
	if (!empty($rep_num_weeks)) {
        $add->rep_num_weeks = $rep_num_weeks;
    }

    if ($oldrepeatid) {
        $add->id = $oldrepeatid;
        $DB->update_record('block_mrbs_repeat', $add);
    } else {
        $add->id = $DB->insert_record('block_mrbs_repeat', $add);
    }

    return $add->id;
}

/** same_day_next_month()
* Find the same day of the week in next month, same week number.
*
* Return the number of days to step forward for a "monthly repeat,
* corresponding day" serie - same week number and day of week next month.
* This function always returns either 28 or 35.
* For dates in the 5th week of a month, the resulting day will be in the 4th
* week of the next month if no 5th week corresponding day exist.
* :TODO: thierry_bo 030510: repeat 5th week entries only if 5th week exist.
* If we want a 5th week repeat type, only 5th weeks have to be booked. We need
* also a new "monthly repeat, corresponding day, last week of the month" type.
*
* @param    integer     $time           timestamp of the day from which we want to find
*                                       the same day of the week in next month, same
*                                       week number
* @return   integer     $days_jump      number of days to step forward to find the next occurence (28 or 35)
* @var      integer     $days_in_month  number of days in month
* @var      integer     $day            day of the month (01 to 31)
* @var      integer     $weeknumber     week number for each occurence ($time)
* @var      boolean     $temp1          first step to compute $days_jump
* @var      integer     $next_month     intermediate next month number (1 to 12)
* @global   integer     $_initial_weeknumber    used only for 5th weeks repeat type
 */
function same_day_next_month($time)
{
    global $_initial_weeknumber;

    $days_in_month = date("t", $time);
    $day = date("d", $time);
    $weeknumber = (int)(($day - 1) / 7) + 1;
    $temp1 = ($day + 7 * (5 - $weeknumber) <= $days_in_month);

    // keep month number > 12 for the test purpose in line beginning with "days_jump = 28 +..."
    $next_month = date("n", mktime(11, 0 ,0, date("n", $time), $day +35, date("Y", $time))) + (date("n", mktime(11, 0 ,0, date("n", $time), $day +35, date("Y", $time))) < date("n", $time)) * 12;

    // prevent 2 months jumps if $time is in 5th week
    $days_jump = 28 + (($temp1 && !($next_month - date("n", $time) - 1)) * 7);

    /* if initial week number is 5 and the new occurence month number ($time + $days_jump)
     * is not changed if we add 7 days, then we can add 7 days to $days_jump to come
     * back to the 5th week (yuh!) */
    $days_jump += 7 * (($_initial_weeknumber == 5) && (date("n", mktime(11, 0 ,0, date("n", $time), $day + $days_jump, date("Y", $time))) == date("n", mktime(11, 0 ,0, date("n", $time), $day + $days_jump + 7, date("Y", $time)))));

    return $days_jump;
}

/** mrbsGetRepeatEntryList
 *
 * Returns a list of the repeating entrys
 *
 * $time     - The start time
 * $enddate  - When the repeat ends
 * $rep_type - What type of repeat is it
 * $rep_opt  - The repeat entrys
 * $max_ittr - After going through this many entrys assume an error has occured
 * $_initial_weeknumber - Save initial week number for use in 'monthly repeat same week number' case
 *
 * Returns:
 *   empty     - The entry does not repeat
 *   an array  - This is a list of start times of each of the repeat entrys
 */
function mrbsGetRepeatEntryList($time, $enddate, $rep_type, $rep_opt, $max_ittr, $rep_num_weeks)
{
	$sec   = date("s", $time);
	$min   = date("i", $time);
	$hour  = date("G", $time);
	$day   = date("d", $time);
	$month = date("m", $time);
	$year  = date("Y", $time);

	global $_initial_weeknumber;
	$_initial_weeknumber = (int)(($day - 1) / 7) + 1;
	$week_num = 0;
	$start_day = date('w', mktime($hour, $min, $sec, $month, $day, $year));
	$cur_day = $start_day;

	$entrys = "";
	for($i = 0; $i < $max_ittr; $i++)
	{
		$time = mktime($hour, $min, $sec, $month, $day, $year);
		if ($time > $enddate)
			break;

		$entrys[$i] = $time;

		switch($rep_type)
		{
			// Daily repeat
			case 1:
				$day += 1;
				break;

			// Weekly repeat
			case 2:
				$j = $cur_day = date("w", $entrys[$i]);
				// Skip over days of the week which are not enabled:
				while (($j = ($j + 1) % 7) != $cur_day && !$rep_opt[$j])
					$day += 1;

				$day += 1;
				break;

			// Monthly repeat
			case 3:
				$month += 1;
				break;

			// Yearly repeat
			case 4:
				$year += 1;
				break;

			// Monthly repeat on same week number and day of week
			case 5:
				$day += same_day_next_month($time);
				break;

			// n Weekly repeat
			case 6:

				while (1)
				{
					$day++;
					$cur_day = ($cur_day + 1) % 7;

					if (($cur_day % 7) == $start_day)
					{
						$week_num++;
					}

					if (($week_num % $rep_num_weeks == 0) &&
					    ($rep_opt[$cur_day] == 1))
					{
						break;
					}
				}

				break;

			// Unknown repeat option
			default:
				return;
		}
	}

	return $entrys;
}

/** mrbsCreateRepeatingEntrys()
 *
 * Creates a repeat entry in the data base + all the repeating entrys
 *
 * $starttime   - Start time of entry
 * $endtime     - End time of entry
 * $rep_type    - The repeat type
 * $rep_enddate - When the repeating ends
 * $rep_opt     - Any options associated with the entry
 * $room_id     - Room ID
 * $owner       - Owner
 * $name        - Name
 * $type        - Type (Internal/External)
 * $description - Description
 *
 * Returns:
 *   0        - An error occured while inserting the entry
 *   non-zero - The entry's ID
 */
function mrbsCreateRepeatingEntrys($starttime, $endtime, $rep_type, $rep_enddate, $rep_opt,
                                   $room_id, $owner, $name, $type, $description, $rep_num_weeks, $roomchange=false, $oldid = 0)
{
	global $max_rep_entrys, $DB;

    $ret = new stdClass;
    $ret->id = 0;
    $ret->repeating = 1;
    $ret->requested = 0;
    $ret->created = 0;
    $ret->lasttime = null;
	$reps = mrbsGetRepeatEntryList($starttime, $rep_enddate, $rep_type, $rep_opt, $max_rep_entrys, $rep_num_weeks);
    $ret->requested = count($reps);
	if($ret->requested > $max_rep_entrys)
		return $ret;

    $repeatid = 0;
    if ($oldid) {
        $repeatid = $DB->get_field('block_mrbs_entry', 'repeat_id', array('id' => $oldid));
    }

	if(empty($reps))
	{
        if ($repeatid) {
            // This was a repeat entry, but the entry no longer has any repeats, so delete the repeats (but not this entry)
            $DB->delete_records_select('block_mrbs_entry', 'repeat_id = :repeatid AND id <> :oldid', compact('repeatid', 'oldid'));
            $DB->delete_records('block_mrbs_repeat', array('id' => $repeatid));
        }

		$ret->id = mrbsCreateSingleEntry($starttime, $endtime, 0, 0, $room_id, $owner, $name, $type, $description, $oldid, $roomchange);
        $ret->repeating = 0;
        $ret->requested = 1;
        $ret->created = 1;
        $ret->lasttime = $starttime;
		return $ret;
	}

	$ret->id = mrbsCreateRepeatEntry($starttime, $endtime, $rep_type, $rep_enddate, $rep_opt, $room_id, $owner, $name, $type, $description, $rep_num_weeks, $repeatid);

	if($ret->id)
	{
        $oldids = array();
        if ($repeatid) {
            // If there are old entries, we will update each of them in turn, as we go through the repeats
            // if we run out, we will create extra; any leftovers will be deleted
            $oldids = $DB->get_fieldset_sql('SELECT id FROM {block_mrbs_entry} WHERE repeat_id = ? ORDER BY start_time', array($repeatid));
        }

		for($i = 0; $i < count($reps); $i++)
		{
			// calculate diff each time and correct where events
			// cross DST
			$diff = $endtime - $starttime;
			$diff += cross_dst($reps[$i], $reps[$i] + $diff);

            if (!check_max_advance_days_timestamp($reps[$i])) {
                break; // Repeat entry is too far into the future
            }

            if ($i < count($oldids)) {
                $updateid = $oldids[$i];
            } else {
                $updateid = 0;
            }

			mrbsCreateSingleEntry($reps[$i], $reps[$i] + $diff, 1, $ret->id,
				 $room_id, $owner, $name, $type, $description, $updateid, $roomchange);
            $ret->lasttime = $reps[$i];

            $ret->created++;
		}

        // Delete any repeats that are no longer needed
        for ($i=count($reps); $i < count($oldids); $i++) {
            $DB->delete_records('block_mrbs_entry', array('id' => $oldids[$i]));
        }
	}
	return $ret;
}

/* mrbsGetEntryInfo()
 *
 * Get the booking's entrys
 *
 * $id = The ID for which to get the info for.
 *
 * Returns:
 *    nothing = The ID does not exist
 *    array   = The bookings info
 */
function mrbsGetEntryInfo($id)
{
    global $DB;
    return $DB->get_record('block_mrbs_entry', array('id'=>$id));
}

function mrbsGetRoomArea($id)
{
    global $DB;

    return $DB->get_field('block_mrbs_room', 'area_id', array('id'=>$id));
}
