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

// mrbs/week.php - Week-at-a-time view

require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/config.php');
include "config.inc.php";
include "functions.php";
require_once('mrbs_auth.php');
include "mincals.php";

$day = optional_param('day', 0, PARAM_INT);
$month = optional_param('month',0,  PARAM_INT);
$year = optional_param('year', 0, PARAM_INT);
$id = optional_param('id', 0, PARAM_INT);
$room = optional_param('room', 0, PARAM_INT);
$area = optional_param('area', 0, PARAM_INT);
$debug_flag = optional_param('debug_flag', 0, PARAM_INT);
$morningstarts_minutes = optional_param('morningstarts_minutes', 0, PARAM_INT);
$pview = optional_param('pview', 0, PARAM_INT);
$user = optional_param('user', 0, PARAM_INT);
$timetohighlight = optional_param('timetohighlight', 0, PARAM_INT);

$num_of_days = $cfg_mrbs->weeklength;
if ($num_of_days==0) {
    $num_of_days=5; //could also pass this in as a parameter or whatever
}

// If we don't know the right date then use today:
if (($day==0) or ($month==0) or ($year==0)) //I think we should separate these out and handle each variable independently -ab
{
    $day   = date("d");
    $month = date("m");
    $year  = date("Y");
} else {
// Make the date valid if day is more then number of days in month:
    while (!checkdate(intval($month), intval($day), intval($year)))
        $day--;
}

$format = "Gi";
if( $enable_periods ) {
    $format = "i";
    $resolution = 60;
    $morningstarts = 12;
    $morningstarts_minutes = 0;
    $eveningends = 12;
    $eveningends_minutes = count($periods)-1;

}

// Set the date back to the previous $weekstarts day (Sunday, if 0):
$time = mktime(12, 0, 0, $month, $day, $year);
if (($weekday = (date("w", $time) - $weekstarts + 7) % 7) > 0)
{
    $time -= $weekday * 86400;
    $day   = date("d", $time);
    $month = date("m", $time);
    $year  = date("Y", $time);
}

$baseurl = new moodle_url('/blocks/mrbs/web/userweek.php', array('day'=>$day, 'month'=>$month, 'year'=>$year)); // Used as the basis for URLs throughout this file
$thisurl = new moodle_url($baseurl);
if ($area > 0) {
    $thisurl->param('area', $area);
} else {
    $area = get_default_area();
}
if ($room > 0) {
    $thisurl->param('room', $area);
} else {
    $room = get_default_room($area);
    // Note $room will be 0 if there are no rooms; this is checked for below.
}
if ($morningstarts_minutes > 0) {
    $thisurl->param('morningstarts_minutes', $morningstarts_minutes);
}
if ($user) {
    $thisurl->param('user', $user);
}

$PAGE->set_url($thisurl);
require_login();

// print the page header
print_user_header_mrbs($day, $month, $year, $area);

if ($CFG->version < 2011120100) {
    $context = get_context_instance(CONTEXT_SYSTEM);
} else {
    $context = context_system::instance();
}

if (!$user || !has_capability('block/mrbs:viewalltt', $context)) {
    $user = $USER->id;
}
$TTUSER = $DB->get_record('user', array('id'=>$user));

// Define the start and end of each day of the week in a way which is not
// affected by daylight saving...
for ($j = 0; $j<=($num_of_days-1); $j++) {
    // are we entering or leaving daylight saving
    // dst_change:
    // -1 => no change
    //  0 => entering DST
    //  1 => leaving DST
    $dst_change[$j] = is_dst($month,$day+$j,$year);
    $am7[$j]=mktime($morningstarts,$morningstarts_minutes,0,$month,$day+$j,$year,is_dst($month,$day+$j,$year,$morningstarts));
    $pm7[$j]=mktime($eveningends,$eveningends_minutes,0,$month,$day+$j,$year,is_dst($month,$day+$j,$year,$eveningends));
}

if ( $pview != 1 ) {
    // Table with areas, rooms, minicals.
    echo "<table width=\"100%\"><tr><td width=60%>";
    echo "</td>\n";

    //Draw the three month calendars
    minicals($year, $month, $day, $area, $room, 'week', $user);
    echo "</tr></table>\n";
}



// Show area and room:
echo '<h2 align=center>'.get_string('ttfor','block_mrbs').$TTUSER->firstname.' '.$TTUSER->lastname.'</h2>';

//y? are year, month and day of the previous week.
//t? are year, month and day of the next week.

$i= mktime(12,0,0,$month,$day-7,$year);
$yy = date("Y",$i);
$ym = date("m",$i);
$yd = date("d",$i);

$i= mktime(12,0,0,$month,$day+7,$year);
$ty = date("Y",$i);
$tm = date("m",$i);
$td = date("d",$i);

if ( $pview != 1 ) {
    //Show Go to week before and after links
    $thisweekurl = new moodle_url($baseurl, array('area'=>$area, 'room'=>$room, 'user'=>$user));
    $thisweekurl->remove_params('day', 'month', 'year');
    $weekbefore = new moodle_url($thisweekurl, array('year'=>$yy, 'month'=>$ym, 'day'=>$yd));
    $weekafter = new moodle_url($thisweekurl, array('year'=>$ty, 'month'=>$tm, 'day'=>$td));
    echo "<table width=\"100%\"><tr><td>
      <a href=\"".$weekbefore."\">
      &lt;&lt; ".get_string('weekbefore','block_mrbs')."</a></td>
      <td align=center><a href=\"".$thisweekurl."\">".get_string('gotothisweek','block_mrbs')."</a></td>
      <td align=right><a href=\"".$weekafter."\">
      ".get_string('weekafter','block_mrbs')."&gt;&gt;</a></td></tr></table>";
}

//Get all appointments for this week in the room that we care about
// This data will be retrieved day-by-day
for ($j = 0; $j<=($num_of_days-1) ; $j++) {

    $sql = "SELECT DISTINCT e.start_time, e.end_time, e.type, e.name AS entryname, r.room_name AS roomname, e.id, e.description
            FROM {block_mrbs_entry} e
                join {block_mrbs_room} r on e.room_id=r.id
                left join {course} c on e.name=c.shortname
                left join {context} cx on cx.contextlevel=50 and cx.instanceid=c.id
                left join {role_assignments} ra on ra.contextid=cx.id and ra.roleid=5
            WHERE (ra.userid= ? or e.create_by = ? )
            AND start_time <= ? AND end_time > ?";
    $params = array($TTUSER->id, $TTUSER->username, $pm7[$j], $am7[$j]);

    // Each row returned from the query is a meeting. Build an array of the
    // form:  d[weekday][slot][x], where x = id, color, data, long_desc.
    // [slot] is based at 000 (HHMM) for midnight, but only slots within
    // the hours of interest (morningstarts : eveningends) are filled in.
    // [id], [data] and [long_desc] are only filled in when the meeting
    // should be labeled,  which is once for each meeting on each weekday.
    // Note: weekday here is relative to the $weekstarts configuration variable.
    // If 0, then weekday=0 means Sunday. If 1, weekday=0 means Monday.

    if ($debug_flag) echo "<br>DEBUG: query=$sql\n";
    $entries = $DB->get_records_sql($sql, $params);
    foreach ($entries as $entry) {
        if ($debug_flag) {
            echo "<br>DEBUG: result $i, id $entry->id, starts $entry->start_time, ends $entry->end_time\n";
        }
        $entry->name = $entry->entryname.' Rm:'.$entry->roomname;

        // $d is a map of the screen that will be displayed
        // It looks like:
        //     $d[Day][Time][id]
        //                  [color]
        //                  [data]
        // where Day is in the range 0 to $num_of_days.

        // Fill in the map for this meeting. Start at the meeting start time,
        // or the day start time, whichever is later. End one slot before the
        // meeting end time (since the next slot is for meetings which start then),
        // or at the last slot in the day, whichever is earlier.
        // Note: int casts on database rows for max may be needed for PHP3.
        // Adjust the starting and ending times so that bookings which don't
        // start or end at a recognized time still appear.

        $start_t = max(round_t_down($entry->start_time, $resolution, $am7[$j]), $am7[$j]);
        $end_t = min(round_t_up($entry->end_time, $resolution, $am7[$j]) - $resolution, $pm7[$j]);

        for ($t = $start_t; $t <= $end_t; $t += $resolution)
        {
          //checks for double bookings
          if(empty($d[$j][date($format,$t)])){
              $d[$j][date($format,$t)]["id"]    = $entry->id;
              $d[$j][date($format,$t)]["color"] = $entry->type;
              $d[$j][date($format,$t)]["data"]  = "";
              $d[$j][date($format,$t)]["long_descr"]  = "";
              $d[$j][date($format,$t)]["double_booked"]  = false;
          } else {
              $d[$j][date($format,$t)]["id"]    .= ','.$entry->id;
              $d[$j][date($format,$t)]["data"]  .= "\n";
              $d[$j][date($format,$t)]["long_descr"]  .= ",";
              $d[$j][date($format,$t)]["double_booked"]  = true;
          }
        }

        // Show the name of the booker in the first segment that the booking
        // happens in, or at the start of the day if it started before today.
        if ($entry->end_time < $am7[$j])
        {
            $d[$j][date($format,$am7[$j])]["data"] .= $entry->name;
            $d[$j][date($format,$am7[$j])]["long_descr"] .= $entry->description;
        }
        else
        {
            $d[$j][date($format,$start_t)]["data"] .= $entry->name;
            $d[$j][date($format,$start_t)]["long_descr"] .= $entry->description;
        }
    }
}



// Include the active cell content management routines.
// Must be included before the beginnning of the main table.
    if ($javascript_cursor) // If authorized in config.inc.php, include the javascript cursor management.
            {
            echo "<SCRIPT language=\"JavaScript\">InitActiveCell("
               . ($show_plus_link ? "true" : "false") . ", "
               . "true, "
               . ((FALSE != $times_right_side) ? "true" : "false") . ", "
               . "\"$highlight_method\", "
               . "\"" . get_string('click_to_reserve','block_mrbs') . "\""
               . ");</SCRIPT>\n";
            }

//This is where we start displaying stuff
echo "<table cellspacing=0 border=1 width=\"100%\">";

// The header row contains the weekday names and short dates.
echo "<tr><th width=\"1%\"><br>".($enable_periods ? get_string('period','block_mrbs') : get_string('time'))."</th>";
if (empty($dateformat))
    $dformat = "%a<br>%b %d";
else
    $dformat = "%a<br>%d %b";
for ($j = 0; $j<=($num_of_days-1) ; $j++)
{
    $t = mktime( 12, 0, 0, $month, $day+$j, $year);
    $dayurl = new moodle_url('/blocks/mrbs/web/day.php',
                             array('year'=>userdate($t, "%Y"), 'month'=>userdate($t, "%m"),
                                   'day'=>userdate($t, "%d"), 'area'=>$area));
    echo '<th width="14%"><a href="'.$dayurl.'" title="'.get_string('viewday','block_mrbs').'">';
    echo userdate($t, $dformat) . "</a></th>\n";
}
// next line to display times on right side
if ( FALSE != $times_right_side )
{
    echo "<th width=\"1%\"><br>"
    . ( $enable_periods  ? get_string('period','block_mrbs') : get_string('time') )
    . "</th>";
}

echo "</tr>\n";


// This is the main bit of the display. Outer loop is for the time slots,
// inner loop is for days of the week.

// URL for highlighting a time. Don't use REQUEST_URI or you will get
// the timetohighlight parameter duplicated each time you click.
$hiliteurl = new moodle_url($baseurl, array('area'=>$area, 'room'=>$room));

// if the first day of the week to be displayed contains as DST change then
// move to the next day to get the hours in the day.
( $dst_change[0] != -1 ) ? $j = 1 : $j = 0;

$row_class = "even_row";
$starttime = mktime($morningstarts, $morningstarts_minutes, 0, $month, $day+$j, $year);
$endtime = mktime($eveningends, $eveningends_minutes, 0, $month, $day+$j, $year);
for ($t = $starttime; $t <= $endtime; $t += $resolution) {
    $row_class = ($row_class == "even_row") ? "odd_row" : "even_row";
    // use hour:minute format
    $time_t = date($format, $t);
    $hiliteurl->param('timetohighlight', $time_t);
    // Show the time linked to the URL for highlighting that time:
    echo "<tr>";
    tdcell("red");
    if( $enable_periods ){
        $time_t_stripped = preg_replace( "/^0/", "", $time_t );
        echo '<a href="'.$hiliteurl.'"  title="'.get_string('highlight_line', 'block_mrbs').'">';
        echo $periods[$time_t_stripped] . "</a></td>";
    } else {
        echo '<a href="'.$hilite_url.'" title="'.get_string('highlight_line','block_mrbs').'">';
        echo userdate($t, hour_min_format()) . "</a></td>";
    }

    // Color to use for empty cells: white, unless highlighting this row:
    if ($timetohighlight == $time_t)
        $empty_color = "red";
    else
        $empty_color = "white";

    // See note above: weekday==0 is day $weekstarts, not necessarily Sunday.
    for ($thisday = 0; $thisday<=($num_of_days-1) ; $thisday++)
    {
        // Three cases:
        // color:  id:   Slot is:   Color:    Link to:
        // -----   ----- --------   --------- -----------------------
        // unset   -     empty      white,red add new entry
        // set     unset used       by type   none (unlabelled slot)
        // set     set   used       by type   view entry

        $wt = mktime( 12, 0, 0, $month, $day+$thisday, $year );
        $wday = date("d", $wt);
        $wmonth = date("m", $wt);
        $wyear = date("Y", $wt);

        if(isset($d[$thisday][$time_t]["id"]))
        {
            $id    = $d[$thisday][$time_t]["id"];
            $color = $d[$thisday][$time_t]["color"];
            $descr = htmlspecialchars($d[$thisday][$time_t]["data"]);
            $long_descr = htmlspecialchars($d[$thisday][$time_t]["long_descr"]);
            $double_booked = $d[$thisday][$time_t]["double_booked"];
            if($double_booked) $color='DoubleBooked';
        } else {
            unset($id);
        }

        // $c is the colour of the cell that the browser sees. White normally,
        // red if were hightlighting that line and a nice attractive green if the room is booked.
        // We tell if its booked by $id having something in it
        if (isset($id)) {
            $c = $color;
        } else if ($time_t == $timetohighlight) {
            $c = "red";
        } else {
            $c = $row_class;
        }

        tdcell($c);

        // If the room isnt booked then don't allow it to be booked
        if(!isset($id)) {
            $hour = date("H",$t);
            $minute  = date("i",$t);

            if ( $pview != 1 ) {
                if ($javascript_cursor) {
                    echo "<SCRIPT language=\"JavaScript\">\n<!--\n";
                    echo "BeginActiveCell();\n";
                    echo "// -->\n</SCRIPT>";
                }
                if ($javascript_cursor) {
                    echo "<SCRIPT language=\"JavaScript\">\n<!--\n";
                    echo "EndActiveCell();\n";
                    echo "// -->\n</SCRIPT>";
                }
            } else {
                echo '&nbsp;';
            }
        } else if ($double_booked) {
            $descrs=split("\n",$descr);
            $long_descrs=split(",",$long_descr);
            $ids=split(",",$id);
        } else {
            $descrs = array($descr);
            $long_descrs = array($long_descr);
            $ids = array($id);
        }
        if (isset($descrs)){
            for($i=0;$i<count($descrs);$i++){
                //if it is booked then show
                if($i>0)echo'<br>';
                $viewentry = new moodle_url('/blocks/mrbs/web/view_entry.php',
                                            array('id'=>$ids[$i], 'area'=>$area, 'day'=>$wday,
                                                  'month'=>$wmonth, 'year'=>$wyear));
                echo ' <a href="'.$viewentry.'" title="'.$long_descr.'">'.$descrs[$i].'</a>';
            }
        }else{
            echo "&nbsp;&nbsp;";
        }

        unset($descrs);
        unset($long_descrs);
        unset($ids);
        echo "</td>\n";
    }

    // next lines to display times on right side
    if ( FALSE != $times_right_side )
    {
        if( $enable_periods )
        {
            tdcell("red");
            $time_t_stripped = preg_replace( "/^0/", "", $time_t );
            echo '<a href="'.$hiliteurl.'" title="'.get_string('highlight_line','block_mrbs').'">';
            echo $periods[$time_t_stripped] . "</a></td>";
        }
        else
        {
            tdcell("red");
            echo '<a href="'.$hiliteurl.'" title="'.get_string('highlight_line','block_mrbs').'">';
            echo userdate($t, hour_min_format()) . "</a></td>";
        }
    }

    echo "</tr>\n";
}
echo "</table>";

show_colour_key();

//include "trailer.php";

echo '</div>';  // Close 'mrbscontainer'

echo $OUTPUT->footer();
