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

$day = optional_param('day', 0, PARAM_INT);
$month = optional_param('month',  0, PARAM_INT);
$year = optional_param('year', 0, PARAM_INT);
$area = optional_param('area', 0, PARAM_INT);
$room = optional_param('room', 0, PARAM_INT);
$pview = optional_param('pview', 0, PARAM_INT);

$From_day= optional_param('From_day',  0, PARAM_INT);
$From_month= optional_param('From_month', 0, PARAM_INT);
$From_year= optional_param('From_year', 0, PARAM_INT);
$To_day= optional_param('To_day', 0, PARAM_INT);
$To_month= optional_param('To_month', 0, PARAM_INT);
$To_year= optional_param('To_year', 0, PARAM_INT);

$submitform = optional_param('submitform', false, PARAM_TEXT);

$typematch = optional_param('typematch', "", PARAM_ALPHA);

// followup what the most appropriate default values should be - ab
$areamatch= optional_param('areamatch', '', PARAM_TEXT);
$roommatch= optional_param('roommatch', '', PARAM_TEXT);
$namematch= optional_param('namematch', '', PARAM_TEXT);
$descrmatch= optional_param('descrmatch', '', PARAM_TEXT);
$creatormatch= optional_param('creatormatch', '', PARAM_TEXT);

$summarize=optional_param('summarize', 1, PARAM_INT);
$sortby= optional_param('sortby', 'r',  PARAM_ALPHA);
$display= optional_param('display', 'd', PARAM_ALPHA);
$sumby= optional_param('sumby', 'd', PARAM_ALPHA);

function date_time_string($t) {
    global $twentyfourhour_format;
    if ($twentyfourhour_format) {
        $timeformat = "%H:%M:%S";
	} else {
        $timeformat = "%I:%M:%S%p";
	}
	return userdate($t, "%A %d %B %Y ".$timeformat);
}

function hours_minutes_seconds_format() {
	global $twentyfourhour_format;

    if ($twentyfourhour_format) {
        $timeformat = "%H:%M:%S";
	} else {
        $timeformat = "%I:%M:%S%p";
	}
	return $timeformat;
}

// Convert a start time and end time to a plain language description.
// This is similar but different from the way it is done in view_entry.
function describe_span($starts, $ends) {
	global $twentyfourhour_format;
	$start_date = userdate($starts, '%A %d %B %Y');
	$start_time = userdate($starts, hours_minutes_seconds_format());
	$duration = $ends - $starts;
	if ($start_time == "00:00:00" && $duration == 60*60*24) {
		return $start_date . " - " . get_string('all_day','block_mrbs');
    }
	toTimeString($duration, $dur_units);
	return $start_date . " " . $start_time . " - " . $duration . " " . $dur_units;
}

// Convert a start period and end period to a plain language description.
// This is similar but different from the way it is done in view_entry.
function describe_period_span($starts, $ends) {
	list( $start_period, $start_date) =  period_date_string($starts);
	list( , $end_date) =  period_date_string($ends, -1);
	$duration = $ends - $starts;
	toPeriodString($start_period, $duration, $dur_units);
	return $start_date . " - " . $duration . " " . $dur_units;
}

// this is based on describe_span but it displays the start and end
// date/time of an entry
function start_to_end($starts, $ends) {
	global $twentyfourhour_format;
	$start_date = userdate($starts, '%A %d %B %Y');
	$start_time = userdate($starts, hours_minutes_seconds_format());

	$end_date = userdate($ends, '%A %d %B %Y');
	$end_time = userdate($ends, hours_minutes_seconds_format());
	return $start_date . " " . $start_time . " - " . $end_date . " " . $end_time;
}


// this is based on describe_period_span but it displays the start and end
// date/period of an entry
function start_to_end_period($starts, $ends) {
	list( , $start_date) =  period_date_string($starts);
	list( , $end_date) =  period_date_string($ends, -1);
	return $start_date . " - " . $end_date;
}

// Report on one entry. See below for columns in $row[].
// $last_area_room remembers the current area/room.
// $last_date remembers the current date.
function reporton(&$item, &$last_area_room, &$last_date, $sortby, $display) {
	global $typel;
    global $enable_periods;
	// Display Area/Room, but only when it changes:
	$area_room = s($item->area_name) . " - " . s($item->room_name);
	$date = userdate($item->start_time, "%d-%b-%Y");
	// entries to be sorted on area/room
	if( $sortby == "r" ) {
		if ($area_room != $last_area_room) {
			echo "<hr><h2>". get_string('room','block_mrbs') . ": " . $area_room . "</h2>\n";
        }
		if ($date != $last_date || $area_room != $last_area_room) {
			echo "<hr noshade=\"true\"><h3>". get_string('date') . " " . $date . "</h3>\n";
			$last_date = $date;
		}
		// remember current area/room that is being processed.
		// this is done here as the if statement above needs the old
		// values
		if ($area_room != $last_area_room) {
			$last_area_room = $area_room;
        }
	} else { // entries to be sorted on start date
		if ($date != $last_date) {
			echo "<hr><h2>". get_string('date') . " " . $date . "</h2>\n";
        }
		if ($area_room != $last_area_room  || $date != $last_date) {
			echo "<hr noshade=\"true\"><h3>". get_string('room','block_mrbs') . ": " . $area_room . "</h3>\n";
			$last_area_room = $area_room;
		}
		// remember current date that is being processed.
		// this is done here as the if statement above needs the old
		// values
		if ($date != $last_date) {
			$last_date = $date;
        }
	}

	echo "<hr><table width=\"100%\">\n";

	// Brief Description (title), linked to view_entry:
    $viewurl = new moodle_url('/blocks/mrbs/web/view_entry.php', array('id'=>$item->id));
	echo "<tr><td class=\"BL\"><a href=\"".$viewurl."\">"
		. s($item->name) . "</a></td>\n";

	// what do you want to display duration or end date/time
	if( $display == "d" ) {
		// Start date/time and duration:
		echo "<td class=\"BR\" align=right>" .
			(empty($enable_periods) ?
				describe_span($item->start_time, $item->end_time) :
				describe_period_span($item->start_time, $item->end_time)) .
			"</td></tr>\n";
	} else {
		// Start date/time and End date/time:
		echo "<td class=\"BR\" align=right>" .
			(empty($enable_periods) ?
				start_to_end($item->start_time, $item->end_time) :
				start_to_end_period($item->start_time, $item->end_time)) .
			"</td></tr>\n";
    }

	// Description:
	echo "<tr><td class=\"BL\" colspan=2><b>".get_string('description')."</b> " .
		nl2br(s($item->description)) . "</td></tr>\n";

	// Entry Type:
	$et = empty($typel[$item->type]) ? "?$item->type?" : $typel[$item->type];
	echo "<tr><td class=\"BL\" colspan=2><b>".get_string('type','block_mrbs')."</b> $et</td></tr>\n";
	// Created by and last update timestamp:
	echo "<tr><td class=\"BL\" colspan=2><small><b>".get_string('createdby','block_mrbs')."</b> " .
		s($item->create_by) . ", <b>".get_string('lastmodified')."</b> " .
		time_date_string($item->timestamp) . "</small></td></tr>\n";

	echo "</table>\n";
}

// Collect summary statistics on one entry. See below for columns in $row[].
// $sumby selects grouping on brief description (d) or created by (c).
// This also builds hash tables of all unique names and rooms. When sorted,
// these will become the column and row headers of the summary table.
function accumulate(&$row, &$count, &$hours, $report_start, $report_end,
	&$room_hash, &$name_hash) {
	global $sumby;
	// Use brief description or created by as the name:
    if ($sumby == "d") {
        $name = s($item->description);
    } else {
        $name = s($item->create_by);
    }
    // Area and room separated by break:
	$room = s($item->area_name) . "<br>" . s($item->room_name);
	// Accumulate the number of bookings for this room and name:
	@$count[$room][$name]++;
	// Accumulate hours used, clipped to report range dates:
	@$hours[$room][$name] += (min((int)$item->end_time, $report_end)
		- max((int)$item->start_time, $report_start)) / 3600.0;
	$room_hash[$room] = 1;
	$name_hash[$name] = 1;
}

function accumulate_periods(&$item, &$count, &$hours, $report_start, $report_end,
	&$room_hash, &$name_hash) {
	global $sumby;
    global $periods;
    $max_periods = count($periods);

	// Use brief description or created by as the name:
    if ($sumby == "d") {
        $name = s($item->description);
    } else {
        $name = s($item->create_by);
    }
    // Area and room separated by break:
	$room = s($item->area_name) . "<br>" . s($item->room_name);
	// Accumulate the number of bookings for this room and name:
	@$count[$room][$name]++;
	// Accumulate hours used, clipped to report range dates:
    $dur = (min((int)$item->end_time, $report_end) - max((int)$item->start_time, $report_start))/60;
	@$hours[$room][$name] += ($dur % $max_periods) + floor( $dur/(24*60) ) * $max_periods;
    $room_hash[$room] = 1;
	$name_hash[$name] = 1;
}

// Output a table cell containing a count (integer) and hours (float):
function cell($count, $hours)
{
	echo "<td class=\"BR\" align=right>($count) "
	. sprintf("%.2f", $hours) . "</td>\n";
}

// Output the summary table (a "cross-tab report"). $count and $hours are
// 2-dimensional sparse arrays indexed by [area/room][name].
// $room_hash & $name_hash are arrays with indexes naming unique rooms and names.
function do_summary(&$count, &$hours, &$room_hash, &$name_hash)
{
	global $enable_periods;

        // Make a sorted array of area/rooms, and of names, to use for column
	// and row indexes. Use the rooms and names hashes built by accumulate().
	// At PHP4 we could use array_keys().
	reset($room_hash);
	while (list($room_key) = each($room_hash)) {
        $rooms[] = $room_key;
    }
	ksort($rooms);
	reset($name_hash);
	while (list($name_key) = each($name_hash)) {
        $names[] = $name_key;
    }
	ksort($names);
	$n_rooms = sizeof($rooms);
	$n_names = sizeof($names);

	echo "<hr><h1>".
        (empty($enable_periods) ? get_string('summary_header','block_mrbs') : get_string('summary_header_per','block_mrbs')).
        "</h1><table border=2 cellspacing=4>\n";
	echo "<tr><td>&nbsp;</td>\n";
	for ($c = 0; $c < $n_rooms; $c++) {
		echo "<td class=\"BL\" align=left><b>$rooms[$c]</b></td>\n";
		$col_count_total[$c] = 0;
		$col_hours_total[$c] = 0.0;
	}
	echo "<td class=\"BR\" align=right><br><b>".get_string('total')."</b></td></tr>\n";
	$grand_count_total = 0;
	$grand_hours_total = 0;

	for ($r = 0; $r < $n_names; $r++) {
		$row_count_total = 0;
		$row_hours_total = 0.0;
		$name = $names[$r];
		echo "<tr><td class=\"BR\" align=right><b>$name</b></td>\n";
		for ($c = 0; $c < $n_rooms; $c++)
		{
			$room = $rooms[$c];
			if (isset($count[$room][$name]))
			{
				$count_val = $count[$room][$name];
				$hours_val = $hours[$room][$name];
				cell($count_val, $hours_val);
				$row_count_total += $count_val;
				$row_hours_total += $hours_val;
				$col_count_total[$c] += $count_val;
				$col_hours_total[$c] += $hours_val;
			} else {
				echo "<td>&nbsp;</td>\n";
			}
		}
		cell($row_count_total, $row_hours_total);
		echo "</tr>\n";
		$grand_count_total += $row_count_total;
		$grand_hours_total += $row_hours_total;
	}
	echo "<tr><td class=\"BR\" align=right><b>".get_string('total')."</b></td>\n";
	for ($c = 0; $c < $n_rooms; $c++)
		cell($col_count_total[$c], $col_hours_total[$c]);
	cell($grand_count_total, $grand_hours_total);
	echo "</tr></table>\n";
}

//If we dont know the right date then make it up
if(($day==0) or ($month==0) or ($year==0))
{
	$day   = date("d");
	$month = date("m");
	$year  = date("Y");
}

$thisurl = new moodle_url('/blocks/mrbs/web/report.php', array('day'=>$day, 'month'=>$month, 'year'=>$year));

if($area==0) {
	$area = get_default_area();
} else {
    $thisurl->param('area', $area);
}
if ($room) {
    $thisurl->param('room', $room);
}
if ($pview) {
    $thisurl->param('pview', $pview);
}
if ($From_day) {
    $thisurl->param('From_day', $From_day);
}
if ($From_month) {
    $thisurl->param('From_month', $From_month);
}
if ($From_year) {
    $thisurl->param('From_year', $From_year);
}
if ($To_day) {
    $thisurl->param('To_day', $To_day);
}
if ($To_month) {
    $thisurl->param('To_month', $To_month);
}
if ($To_year) {
    $thisurl->param('To_year', $To_year);
}
if ($submitform) {
    $thisurl->param('submitform', $submitform);
}
if ($areamatch) {
    $thisurl->param('areamatch', $areamatch);
}
if ($roommatch) {
    $thisurl->param('roommatch', $roommatch);
}
if ($namematch) {
    $thisurl->param('namematch', $namematch);
}
if ($descrmatch) {
    $thisurl->param('descrmatch', $descrmatch);
}
if ($creatormatch) {
    $thisurl->param('creatormatch', $creatormatch);
}
if ($summarize != 1) {
    $thisurl->param('summarize', $summarize);
}
if ($sortby != 'r') {
    $thisurl->param('sortby', $sortby);
}
if ($display != 'd') {
    $thisurl->param('display', $display);
}
if ($sumby != 'd') {
    $thisurl->param('sumby', $sumby);
}

$PAGE->set_url($thisurl);
require_login();

// print the page header
print_header_mrbs($day, $month, $year, $area);

if ($submitform) {
	// Resubmit - reapply parameters as defaults.

	// Make default values when the form is reused.
	$areamatch_default = s($areamatch);
	$roommatch_default = s($roommatch);
    $typematch_default = $typematch;
	$namematch_default = s($namematch);
	$descrmatch_default = s($descrmatch);
    $creatormatch_default = s($creatormatch);

} else {
	// New report - use defaults.
	$areamatch_default = "";
	$roommatch_default = "";
	$typematch_default = array();
	$namematch_default = "";
	$descrmatch_default = "";
    $creatormatch_default = "";
	$From_day = $day;
	$From_month = $month;
	$From_year = $year;
	$To_time = mktime(0, 0, 0, $month, $day + $default_report_days, $year);
	$To_day   = date("d", $To_time);
	$To_month = date("m", $To_time);
	$To_year  = date("Y", $To_time);
}
// $summarize: 1=report only, 2=summary only, 3=both.
// $sumby: d=by brief description, c=by creator.
// $sortby: r=room, s=start date/time.
// $display: d=duration, e=start date/time and end date/time.

// Upper part: The form.
if ( $pview != 1 ) {
?>
<h1><?php echo get_string('report_on','block_mrbs');?></h1>
<form method="get" action="report.php">
<table>
<tr><td class="CR"><?php echo get_string('report_start','block_mrbs');?></td>
    <td class="CL"> <font size="-1">
    <?php genDateSelector("From_", $From_day, $From_month, $From_year); ?>
    </font></td></tr>
<tr><td class="CR"><?php echo get_string('report_end','block_mrbs');?></td>
    <td class="CL"> <font size="-1">
    <?php genDateSelector("To_", $To_day, $To_month, $To_year); ?>
    </font></td></tr>
<tr><td class="CR"><?php echo get_string('match_area','block_mrbs');?></td>
    <td class="CL"><input type="text" name="areamatch" size="18"
    value="<?php echo $areamatch_default; ?>">
    </td></tr>
<tr><td class="CR"><?php echo get_string('match_room','block_mrbs');?></td>
    <td class="CL"><input type="text" name="roommatch" size="18"
    value="<?php echo $roommatch_default; ?>">
    </td></tr>
<tr><td CLASS=CR><?php echo get_string('match_type','block_mrbs')?></td>
    <td CLASS=CL valign=top><table><tr><td>
        <select name="typematch[]" multiple="yes">
<?php
foreach( $typel as $key => $val )
{
	if (!empty($val) )
		echo "<option value=\"$key\"" .
		     (is_array($typematch_default) && in_array ( $key, $typematch_default ) ? " selected" : "") .
		     ">$val\n";
}
?></select></td><td><?php echo get_string('ctrl_click_type','block_mrbs') ?></td></tr></table>
</td></tr>
<tr><td class="CR"><?php echo get_string('match_entry','block_mrbs');?></td>
    <td class="CL"><input type="text" name="namematch" size="18"
    value="<?php echo $namematch_default; ?>">
    </td></tr>
<tr><td class="CR"><?php echo get_string('match_descr','block_mrbs');?></td>
    <td class="CL"><input type="text" name="descrmatch" size="18"
    value="<?php echo $descrmatch_default; ?>">
    </td></tr>
<tr><td class="CR"><?php echo get_string('createdby','block_mrbs');?></td>
    <td class="CL"><input type="text" name="creatormatch" size="18"
    value="<?php echo $creatormatch_default; ?>">
    </td></tr>
<tr><td class="CR"><?php echo get_string('include','block_mrbs');?></td>
    <td class="CL">
      <input type="radio" name="summarize" value="1"<?php if ($summarize==1) echo " checked";
        echo ">" . get_string('report_only','block_mrbs');?>
      <input type="radio" name="summarize" value="2"<?php if ($summarize==2) echo " checked";
        echo ">" . get_string('summary_only','block_mrbs');?>
      <input type="radio" name="summarize" value="3"<?php if ($summarize==3) echo " checked";
        echo ">" . get_string('report_and_summary','block_mrbs');?>
    </td></tr>
<tr><td class="CR"><?php echo get_string('sort_rep','block_mrbs');?></td>
    <td class="CL">
      <input type="radio" name="sortby" value="r"<?php if ($sortby=="r") echo " checked";
        echo ">". get_string('room','block_mrbs');?>
      <input type="radio" name="sortby" value="s"<?php if ($sortby=="s") echo " checked";
        echo ">". get_string('sort_rep_time','block_mrbs');?>
    </td></tr>
<tr><td class="CR"><?php echo get_string('rep_dsp','block_mrbs');?></td>
    <td class="CL">
      <input type="radio" name="display" value="d"<?php if ($display=="d") echo " checked";
        echo ">". get_string('rep_dsp_dur','block_mrbs');?>
      <input type="radio" name="display" value="e"<?php if ($display=="e") echo " checked";
        echo ">". get_string('rep_dsp_end','block_mrbs');?>
    </td></tr>
<tr><td class="CR"><?php echo get_string('summarize_by','block_mrbs');?></td>
    <td class="CL">
      <input type="radio" name="sumby" value="d"<?php if ($sumby=="d") echo " checked";
        echo ">" . get_string('sum_by_descrip','block_mrbs');?>
      <input type="radio" name="sumby" value="c"<?php if ($sumby=="c") echo " checked";
        echo ">" . get_string('sum_by_creator','block_mrbs');?>
    </td></tr>
          <tr><td>&nbsp;</td><td><?php print_string('help_wildcard', 'block_mrbs'); ?></td></tr>
<tr><td colspan="2" align="center"><input name="submitform" type="submit" value="<?php echo get_string('submitquery','block_mrbs') ?>">
</td></tr>
</table>
</form>

<?php
}
// Lower part: Results, if called with parameters:
if ($submitform) {
	// Start and end times are also used to clip the times for summary info.
	$report_start = mktime(0, 0, 0, $From_month+0, $From_day+0, $From_year+0);
	$report_end = mktime(0, 0, 0, $To_month+0, $To_day+1, $To_year+0);

//   SQL result will contain the following columns:
// Col Index  Description:
//   1  [0]   Entry ID, not displayed -- used for linking to View script.
//   2  [1]   Start time as Unix time_t
//   3  [2]   End time as Unix time_t
//   4  [3]   Entry name or short description, must be HTML escaped
//   5  [4]   Entry description, must be HTML escaped
//   6  [5]   Type, single char mapped to a string
//   7  [6]   Created by (user name or IP addr), must be HTML escaped
//   8  [7]   Creation timestamp, converted to Unix time_t by the database
//   9  [8]   Area name, must be HTML escaped
//  10  [9]   Room name, must be HTML escaped

	$sql = "SELECT e.id, e.start_time, e.end_time, e.name, e.description, "
		. "e.type, e.create_by, e.timestamp, a.area_name, r.room_name"
		. " FROM {block_mrbs_entry} e, {block_mrbs_area} a, {block_mrbs_room} r"
		. " WHERE e.room_id = r.id AND r.area_id = a.id"
		. " AND e.start_time < ? AND e.end_time > ?";
    $params = array($report_end, $report_start);

	if (!empty($areamatch)) {
		$sql .= " AND " .  $DB->sql_like("a.area_name", '?', false);
        $params[] = $areamatch;
    }
	if (!empty($roommatch)) {
		$sql .= " AND " .  $DB->sql_like("r.room_name", '?', false);
        $params[] = $roommatch;
    }
	if (!empty($typematch)) {
		$sql .= " AND ";
		if( count( $typematch ) > 1 )
		{
			$or_array = array();
			foreach ( $typematch as $type ){
				$or_array[] = "e.type = ?";
                $params[] = $type;
			}
			$sql .= "(". implode( " OR ", $or_array ) .")";
		}
		else
		{
			$sql .= "e.type = ?";
            $params[] = $typematch[0];
		}
	}
	if (!empty($namematch)) {
		$sql .= " AND " .  $DB->sql_like("e.name", '?', false);
        $params[] = $namematch;
    }
	if (!empty($descrmatch)) {
		$sql .= " AND " .  $DB->sql_like("e.description", '?', false);
        $params[] = $descrmatch;
    }
    if (!empty($creatormatch)) {
        $sql .= " AND " .  $DB->sql_like("e.create_by", '?', false);
        $params[] = $creatormatch;
    }


	if( $sortby == "r" )  {
		// Order by Area, Room, Start date/time
		$sql .= " ORDER BY a.area_name, r.room_name, e.start_time";
	} else {
		// Order by Start date/time, Area, Room
		$sql .= " ORDER BY e.start_time, a.area_name, r.room_name";
    }

	// echo "<p>DEBUG: SQL: <tt> $sql </tt>\n";

    $rep = $DB->get_records_sql($sql, $params);
	$nmatch = count($rep);
	if ($nmatch == 0) {
		echo "<P><B>" . get_string('nothingtodisplay') . "</B>\n";
	} else {
		$last_area_room = "";
		$last_date = "";
		echo "<P><B>" . $nmatch . " "
		. ($nmatch == 1 ? get_string('entry_found','block_mrbs') : get_string('entries_found','block_mrbs'))
		.  "</B>\n";

        foreach ($rep as $item) {
			if ($summarize & 1) {
				reporton($item, $last_area_room, $last_date, $sortby, $display);
            }

			if ($summarize & 2) {
                if (empty($enable_periods)) {
                    accumulate($item, $count, $hours, $report_start, $report_end,
                               $room_hash, $name_hash);
                } else {
                    accumulate_periods($item, $count, $hours, $report_start, $report_end,
                                       $room_hash, $name_hash);
                }
            }
		}
		if ($summarize & 2) {
			do_summary($count, $hours, $room_hash, $name_hash);
        }
	}
}

include "trailer.php";
