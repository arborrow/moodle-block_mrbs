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
require_once('mrbs_auth.php');
include "mincals.php";

$day = optional_param('day', 0, PARAM_INT);
$month = optional_param('month', 0, PARAM_INT);
$year = optional_param('year', 0, PARAM_INT);
$area = optional_param('area', 0,  PARAM_INT);
//$room = optional_param('room', 0, PARAM_INT);
$morningstarts_minutes = optional_param('morningstarts_minutes', 0, PARAM_INT);
$debug_flag = optional_param('debug_flag', 0, PARAM_INT);
$timetohighlight = optional_param('timetohighlight', -1, PARAM_INT);
$roomnotfound = optional_param('roomnotfound', NULL, PARAM_TEXT);

//If we dont know the right date then make it up
if (($day==0) or ($month==0) or ($year==0)) {
	$day   = date("d");
	$month = date("m");
	$year  = date("Y");
} else {
// Make the date valid if day is more then number of days in month
	while (!checkdate(intval($month), intval($day), intval($year))) {
		$day--;
    }
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

$baseurl = new moodle_url('/blocks/mrbs/web/day.php', array('day'=>$day, 'month'=>$month, 'year'=>$year)); // Used as basis for URLs throughout this file
$thisurl = new moodle_url($baseurl);
if ($area > 0) {
    $thisurl->param('area', $area);
} else {
    $area = get_default_area();
}
if ($morningstarts_minutes > 0) {
    $thisurl->param('morningstarts_minutes', $morningstarts_minutes);
}
if ($timetohighlight >= 0) {
    $thisurl->param('timetohighlight', $timetohighlight);
}

$PAGE->set_url($thisurl);
require_login();

// print the page header
print_header_mrbs($day, $month, $year, $area);

// Define the start and end of each day in a way which is not affected by
// daylight saving...
// dst_change:
// -1 => no change
//  0 => entering DST
//  1 => leaving DST
$dst_change = is_dst($month,$day,$year);
$am7=mktime($morningstarts,$morningstarts_minutes,0,$month,$day,$year,is_dst($month,$day,$year,$morningstarts));
$pm7=mktime($eveningends,$eveningends_minutes,0,$month,$day,$year,is_dst($month,$day,$year,$eveningends));

if ( $pview != 1 ) {
   echo "<table width=\"100%\"><tr><td width=\"40%\">";

   //Show all avaliable areas
   echo "<u>".get_string('areas','block_mrbs')."</u><br>";

   // need to show either a select box or a normal html list,
   // depending on the settings in config.inc.php
   if ($area_list_format == "select") {
       echo make_area_select_html(new moodle_url('/blocks/mrbs/web/day.php'), $area, $year, $month, $day); // from functions.php
   } else {
	// show the standard html list
       $areas = $DB->get_records('block_mrbs_area', null, 'area_name');
       foreach ($areas as $dbarea) {
           echo '<a href="'.($baseurl->out(true, array('area'=>$dbarea->id))).'">';
           if ($dbarea->id == $area) {
               echo "<font color=\"red\">" . s($dbarea->area_name) . "</font></a><br>\n";
           } else {
               echo s($dbarea->area_name) . "</a><br>\n";
           }
       }
   }
   echo "</td>\n";

   //insert the goto room form
   $gotoroom = new moodle_url('/blocks/mrbs/web/gotoroom.php');
   $gostr = get_string('goroom', 'block_mrbs');
   $gotoval = '';
   $gotomsg = '';
   if ($roomnotfound) {
       $gotoval = $roomnotfound;
       $gotomsg = ' '.get_string('noroomsfound', 'block_mrbs');
   }
   echo "<td width=\"20%\"><h3>".get_string('findroom', 'block_mrbs')."</h3>
        <form action='$gotoroom' method='get'>
            <input type='text' name='room' value='$gotoval'>
            <input type='hidden' name='day' value='$day'>
            <input type='hidden' name='month' value='$month'>
            <input type='hidden' name='year' value='$year'>
            <input type='submit' value='$gostr'>$gotomsg
        </form></td>";

   //Draw the three month calendars
   minicals($year, $month, $day, $area, '', 'day');
   echo "</tr></table>";
}

//y? are year, month and day of yesterday
//t? are year, month and day of tomorrow

$i= mktime(12,0,0,$month,$day-1,$year);
$yy = date("Y",$i);
$ym = date("m",$i);
$yd = date("d",$i);

$i= mktime(12,0,0,$month,$day+1,$year);
$ty = date("Y",$i);
$tm = date("m",$i);
$td = date("d",$i);

//We want to build an array containing all the data we want to show
//and then spit it out.

//Get all appointments for today in the area that we care about
//Note: The predicate clause 'start_time <= ...' is an equivalent but simpler
//form of the original which had 3 BETWEEN parts. It selects all entries which
//occur on or cross the current day.
// Don't continue if there are no areas:

if ($area <= 0) {
    echo "<h1>".get_string('noareas','block_mrbs')."</h1>";
    echo "</table>\n";
    (isset($output)) ? print $output : '';
    show_colour_key();
    include "trailer.php";
    exit;
}


if (!empty($area)) {
    $sql = "SELECT e.id AS eid, r.id AS rid, e.start_time, e.end_time, e.name, e.type,
            e.description
            FROM {block_mrbs_entry} e, {block_mrbs_room} r
            WHERE e.room_id = r.id
            AND r.area_id = ?
            AND e.start_time <= ? AND e.end_time > ?";

    $entries = $DB->get_records_sql($sql, array($area, $pm7, $am7));

    foreach ($entries as $entry) {
    	// $today is a map of the screen that will be displayed
	    // It looks like:
	    //     $today[Room ID][Time][id]
	    //                          [color]
	    //                          [data]
	    //                          [long_descr]

	    // Fill in the map for this meeting. Start at the meeting start time,
        // or the day start time, whichever is later. End one slot before the
        // meeting end time (since the next slot is for meetings which start then),
        // or at the last slot in the day, whichever is earlier.
        // Time is of the format HHMM without leading zeros.
        //
        // Note: int casts on database rows for max may be needed for PHP3.
        // Adjust the starting and ending times so that bookings which don't
        // start or end at a recognized time still appear.
        $start_t = max(round_t_down($entry->start_time, $resolution, $am7), $am7);
        $end_t = min(round_t_up($entry->end_time, $resolution, $am7) - $resolution, $pm7);
        for ($t = $start_t; $t <= $end_t; $t += $resolution) {
            //checks for double bookings
            if(empty($today[$entry->rid][date($format,$t)])) {
                $today[$entry->rid][date($format,$t)]["id"]    = $entry->eid;
                $today[$entry->rid][date($format,$t)]["color"] = $entry->type;
                $today[$entry->rid][date($format,$t)]["data"]  = "";
                $today[$entry->rid][date($format,$t)]["long_descr"]  = "";
                $today[$entry->rid][date($format,$t)]["double_booked"]  = false;
            } else {
                $today[$entry->rid][date($format,$t)]["id"]    .= ','.$entry->eid;
                $today[$entry->rid][date($format,$t)]["data"]  .= "\n";
                $today[$entry->rid][date($format,$t)]["long_descr"]  .= ",";
                $today[$entry->rid][date($format,$t)]["double_booked"]  = true;
            }
        }

        // Show the name of the booker in the first segment that the booking
        // happens in, or at the start of the day if it started before today.
        if ($entry->start_time < $am7) {
            $today[$entry->rid][date($format,$am7)]["data"] .= $entry->name;
            $today[$entry->rid][date($format,$am7)]["long_descr"] .= $entry->description;
        } else {
            $today[$entry->rid][date($format,$start_t)]["data"] .= $entry->name;
            $today[$entry->rid][date($format,$start_t)]["long_descr"] .= $entry->description;
        }
    }


    if ($debug_flag) {
        echo "<p>DEBUG:<pre>\n";
        echo "\$dst_change = $dst_change\n";
        echo "\$am7 = $am7 or " . date($format,$am7) . "\n";
        echo "\$pm7 = $pm7 or " . date($format,$pm7) . "\n";
        if (gettype($today) == "array")
            while (list($w_k, $w_v) = each($today))
                while (list($t_k, $t_v) = each($w_v))
                    while (list($k_k, $k_v) = each($t_v))
                        echo "d[$w_k][$t_k][$k_k] = '$k_v'\n";
        else echo "today is not an array!\n";
        echo "</pre><p>\n";
    }

    // We need to know what all the rooms area called, so we can show them all
    // pull the data from the db and store it. Convienently we can print the room
    // headings and capacities at the same time
    $rooms = $DB->get_records('block_mrbs_room', array('area_id'=>$area), 'room_name');
    foreach ($rooms as $room) {
        $room->allowedtobook = allowed_to_book($USER, $room);
    }

    // It might be that there are no rooms defined for this area.
    // If there are none then show an error and dont bother doing anything
    // else
    if (empty($rooms)) {
        echo "<h1>".get_string('no_rooms_for_area','block_mrbs')."</h1>";
    } else {
        //Show current date
        echo "<h2 align=center>" . userdate($am7, "%A %d %B %Y") . "</h2>\n";

        if ( $pview != 1 ) {
            //Show Go to day before and after links
            $todayurl = new moodle_url($baseurl, array('area'=>$area));
            $todayurl->remove_params('day', 'month', 'year');
            $daybefore = new moodle_url($todayurl, array('year'=>$yy, 'month'=>$ym, 'day'=>$yd));
            $dayafter = new moodle_url($todayurl, array('year'=>$ty, 'month'=>$tm, 'day'=>$td));
            $output = "<table width=\"100%\"><tr><td><a href=\"".$daybefore."\">&lt;&lt;".get_string('daybefore','block_mrbs')."</a></td>
            <td align=center><a href=\"".$todayurl."\">".get_string('gototoday','block_mrbs')."</a></td>
            <td align=right><a href=\"".$dayafter."\">".get_string('dayafter','block_mrbs')."&gt;&gt;</a></td></tr></table>\n";
            print $output;
        }

        // Include the active cell content management routines.
        // Must be included before the beginnning of the main table.
        if ($javascript_cursor) { // If authorized in config.inc.php, include the javascript cursor management.
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
        echo "<tr><th width=\"1%\">".($enable_periods ? get_string('period','block_mrbs') : get_string('time'))."</th>";

        $room_column_width = (int)(95 / count($rooms));
        $weekurl = new moodle_url('/blocks/mrbs/web/week.php', array('year'=>$year, 'month'=>$month, 'day'=>$day, 'area'=>$area));
        foreach ($rooms as $room) {
            echo "<th width=\"$room_column_width%\">
            <a href=\"".($weekurl->out(true, array('room'=>$room->id)))."\"
            title=\"" . get_string('viewweek','block_mrbs') . " &#10;&#10;{$room->description}\">"
                . s($room->room_name) . ($room->capacity > 0 ? "($room->capacity)" : "") . "
            <br />$room->description</a></th>";//print the room description as well
        }

        // next line to display times on right side
        if ( FALSE != $times_right_side ) {
            echo "<th width=\"1%\">". ( $enable_periods  ? get_string('period','block_mrbs') : get_string('time') )
                ."</th>";
        }
        echo "</tr>\n";

        // URL for highlighting a time. Don't use REQUEST_URI or you will get
        // the timetohighlight parameter duplicated each time you click.
        $hiliteurl = new moodle_url($baseurl, array('area'=>$area));

        // This is the main bit of the display
        // We loop through time and then the rooms we just got

        // if the today is a day which includes a DST change then use
        // the day after to generate timesteps through the day as this
        // will ensure a constant time step
        ( $dst_change != -1 ) ? $j = 1 : $j = 0;

        // Check we are not trying to book to far in advance
        $advanceok = check_max_advance_days($day, $month, $year);

        $row_class = "even_row";
        $starttime = mktime($morningstarts, $morningstarts_minutes, 0, $month, $day+$j, $year);
        $endtime = mktime($eveningends, $eveningends_minutes, 0, $month, $day+$j, $year);
        for ($t = $starttime; $t <= $endtime; $t += $resolution) {
            if ($row_class == 'even_row') {
                $row_class = 'odd_row';
            } else {
                $row_class = 'even_row';
            }

            // convert timestamps to HHMM format without leading zeros
            $time_t = date($format, $t);
            $hiliteurl->param('timetohighlight', $time_t);

            // Show the time linked to the URL for highlighting that time
            echo "<tr>";
            tdcell("red");
            if( $enable_periods ) {
                $time_t_stripped = preg_replace( "/^0/", "", $time_t );
                echo "<a href=\"".$hiliteurl."\"  title=\""
                    . get_string('highlight_line','block_mrbs') . "\">"
                    . $periods[$time_t_stripped] . "</a></td>\n";
            } else {
                echo "<a href=\"".$hiliteurl."\" title=\""
                    . get_string('highlight_line','block_mrbs') . "\">"
                    . userdate($t,hour_min_format()) . "</a></td>\n";
            }

            // Loop through the list of rooms we have for this area
            foreach ($rooms as $room) {
                if(isset($today[$room->id][$time_t]["id"])) {
                    $id    = $today[$room->id][$time_t]["id"];
                    $color = $today[$room->id][$time_t]["color"];
                    $descr = s($today[$room->id][$time_t]["data"]);
                    $long_descr = s($today[$room->id][$time_t]["long_descr"]);
                    $double_booked = $today[$room->id][$time_t]["double_booked"];
                    if($double_booked) $color='DoubleBooked';
                } else {
                    unset($id);
                }

                // $c is the colour of the cell that the browser sees. White normally,
                // red if were hightlighting that line and a nice attractive green if the room is booked.
                // We tell if its booked by $id having something in it
                if (isset($id))
                    $c = $color;
                elseif ($time_t == $timetohighlight)
                    $c = "red";
                else
                    $c = $row_class; // Use the default color class for the row.

                tdcell($c);

                // If the room isnt booked then allow it to be booked
                if(!isset($id)) {
                    $hour = date("H",$t);
                    $minute  = date("i",$t);

                    if ( $pview != 1 ) {
                        if (!$room->allowedtobook) {
                            // Not allowed to book this room
                            echo '<center>';
                            $title = get_string('notallowedbook', 'block_mrbs');
                            echo '<img src="'.$OUTPUT->pix_url('toofaradvance', 'block_mrbs').'" width="10" height="10" border="0" alt="'.$title.'" title="'.$title.'" />';
                            echo '</center>';
                        } else if (!$advanceok) {
                            // Too far in advance to edit
                            echo '<center>';
                            $title = get_string('toofaradvance', 'block_mrbs', $max_advance_days);
                            echo '<img src="'.$OUTPUT->pix_url('toofaradvance', 'block_mrbs').'" width="10" height="10" border="0" alt="'.$title.'" title="'.$title.'" />';
                            echo '</center>';
                        } else {
                            if ($javascript_cursor) {
                                echo "<SCRIPT language=\"JavaScript\">\n<!--\n";
                                echo "BeginActiveCell();\n";
                                echo "// -->\n</SCRIPT>";
                            }
                            echo "<center>";
                            $editurl = new moodle_url('/blocks/mrbs/web/edit_entry.php',
                                                      array('room'=>$room->id, 'area'=>$area, 'year'=>$year, 'month'=>$month, 'day'=>$day));
                            if( $enable_periods ) {
                                echo "<a href=\"".($editurl->out(true, array('period'=>$time_t_stripped)))."\">";
                            } else {
                                echo "<a href=\"".($editurl->out(true, array('hour'=>$hour, 'minute'=>$minute)))."\">";
                            }
                            echo '<img src="'.$OUTPUT->pix_url('new', 'block_mrbs').'" width="10" height="10" border="0"></a>';
                            echo "</center>";
                            if ($javascript_cursor) {
                                echo "<SCRIPT language=\"JavaScript\">\n<!--\n";
                                echo "EndActiveCell();\n";
                                echo "// -->\n</SCRIPT>";
                            }
                        }
                    } else {
                        echo '&nbsp;';
                    }
                    $descrs = array();
                } else if ($double_booked) {
                    $descrs=explode("\n",$descr);
                    $long_descrs=explode(",",$long_descr);
                    $ids=explode(",",$id);
                } else {
                    $descrs[]=$descr;
                    $long_descrs[]=$long_descr;
                    $ids[]=$id;
                }
                for($i=0;$i<count($descrs);$i++){
                    $viewentry = new moodle_url('/blocks/mrbs/web/view_entry.php',
                                                array('id'=>$ids[$i], 'area'=>$area, 'day'=>$day, 'month'=>$month, 'year'=>$year));
                    if ($descrs[$i] != "") {
                        //if it is booked then show
                        echo " <a href=\"".$viewentry."\" title=\"$long_descrs[$i]\">$descrs[$i]</a><br>";
                    } else {
                        echo "<a href=\"".$viewentry."\" title=\"$long_descrs[$i]\">&nbsp;\"&nbsp;</a><br>";
                    }
                }
                unset($descrs);
                unset($long_descrs);
                unset($ids);

                echo "</td>\n";
            }
            // next lines to display times on right side
            if ( FALSE != $times_right_side ) {
                    if( $enable_periods ) {
                        tdcell("red");
                        $time_t_stripped = preg_replace( "/^0/", "", $time_t );
                        echo "<a href=\"".$hiliteurl."\"  title=\""
                            . get_string('highlight_line','block_mrbs') . "\">"
                            . $periods[$time_t_stripped] . "</a></td>\n";
                    } else {
                        tdcell("red");
                        echo "<a href=\"".$hiliteurl."\" title=\""
                            . get_string('highlight_line','block_mrbs') . "\">"
                            . userdate($t,hour_min_format()) . "</a></td>\n";
                    }
            }

            echo "</tr>\n";
        }
    }
    echo "</table>\n";
    (isset($output)) ? print $output : '';
    show_colour_key();
}
unset($room);
include "trailer.php";
