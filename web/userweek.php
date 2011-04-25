<?php
# $Id: userweek.php,v 1.2 2009/06/10 15:07:11 mike1989 Exp $

# mrbs/week.php - Week-at-a-time view
require_once("../../../config.php"); //for Moodle integration
require_once "grab_globals.inc.php";
include "config.inc.php";
include "functions.php";
include "userfunctions.php";
include "$dbsys.php";
include "mrbs_auth.php";
include "mincals.php";

if ($CFG->forcelogin) {
        require_login();
    }
$day = optional_param('day', 0, PARAM_INT);
$month = optional_param('month',0,  PARAM_INT);
$year = optional_param('year', 0, PARAM_INT);
$id = optional_param('id', 0, PARAM_INT);
$room = optional_param('room', 0, PARAM_INT);
$debug_flag = optional_param('debug_flag', 0, PARAM_INT);
$morningstarts_minutes = optional_param('morningstarts_minutes', 0, PARAM_INT);
$pview = optional_param('pview', 0, PARAM_INT);

$user = optional_param('user', $USER->id, PARAM_INT);
if(empty($user) || !has_capability('block/mrbs:viewalltt',get_context_instance(CONTEXT_SYSTEM))){$TTUSER=$DB->get_record('user',array('id'=>$USER->id));}else{$TTUSER=$DB->get_record('user',array('id'=>$user));}

if (empty($debug_flag)) $debug_flag = 0;

$num_of_days=5; #could also pass this in as a parameter or whatever // let's not -ab.

# If we don't know the right date then use today:
if (($day==0) or ($month==0) or ($year==0)) //I think we should separate these out and handle each variable independently -ab
{
    $day   = date("d");
    $month = date("m");
    $year  = date("Y");
} else {
# Make the date valid if day is more then number of days in month:
    while (!checkdate(intval($month), intval($day), intval($year)))
        $day--;
}

# Set the date back to the previous $weekstarts day (Sunday, if 0):
$time = mktime(12, 0, 0, $month, $day, $year);
if (($weekday = (date("w", $time) - $weekstarts + 7) % 7) > 0)
{
    $time -= $weekday * 86400;
    $day   = date("d", $time);
    $month = date("m", $time);
    $year  = date("Y", $time);
}


# print the page header
print_user_header_mrbs($day, $month, $year, $area);

$format = "Gi";
if( $enable_periods ) {
    $format = "i";
    $resolution = 60;
    $morningstarts = 12;
    $morningstarts_minutes = 0;
    $eveningends = 12;
    $eveningends_minutes = count($periods)-1;

}

# ensure that $morningstarts_minutes defaults to zero if not set
// if( empty( $morningstarts_minutes ) ) //not needed with optional_param
//  $morningstarts_minutes=0;

# Define the start and end of each day of the week in a way which is not
# affected by daylight saving...
for ($j = 0; $j<=($num_of_days-1); $j++) {
    # are we entering or leaving daylight saving
    # dst_change:
    # -1 => no change
    #  0 => entering DST
    #  1 => leaving DST
    $dst_change[$j] = is_dst($month,$day+$j,$year);
    $am7[$j]=mktime($morningstarts,$morningstarts_minutes,0,$month,$day+$j,$year,is_dst($month,$day+$j,$year,$morningstarts));
    $pm7[$j]=mktime($eveningends,$eveningends_minutes,0,$month,$day+$j,$year,is_dst($month,$day+$j,$year,$eveningends));
}

if ( $pview != 1 ) {
    # Table with areas, rooms, minicals.
    echo "<table width=\"100%\"><tr><td width=60%>";


}





if ( $pview != 1 ) {
    echo "</td>\n";

    #Draw the three month calendars
    minicals($year, $month, $day, $area, $room, 'week',$user);
    echo "</tr></table>\n";
}



# Show area and room:
echo '<h2 align=center>'.get_string('ttfor','block_mrbs').$TTUSER->firstname.' '.$TTUSER->lastname.'</h2>\n';

#y? are year, month and day of the previous week.
#t? are year, month and day of the next week.

$i= mktime(12,0,0,$month,$day-7,$year);
$yy = date("Y",$i);
$ym = date("m",$i);
$yd = date("d",$i);

$i= mktime(12,0,0,$month,$day+7,$year);
$ty = date("Y",$i);
$tm = date("m",$i);
$td = date("d",$i);

if ( $pview != 1 ) {
    #Show Go to week before and after links
    echo "<table width=\"100%\"><tr><td>
      <a href=\"userweek.php?year=$yy&month=$ym&day=$yd&area=$area&room=$room&user=$user\">
      &lt;&lt; ".get_string('weekbefore','block_mrbs')."</a></td>
      <td align=center><a href=\"userweek.php?area=$area&room=$room\">".get_string('gotothisweek','block_mrbs')."</a></td>
      <td align=right><a href=\"userweek.php?year=$ty&month=$tm&day=$td&area=$area&room=$room&user=$user\">
      ".get_string('weekafter','block_mrbs')."&gt;&gt;</a></td></tr></table>";
}

#Get all appointments for this week in the room that we care about
# row[0] = Start time
# row[1] = End time
# row[2] = Entry type
# row[3] = Entry name (brief description)
# row[4] = Entry ID
# row[5] = Complete description
# This data will be retrieved day-by-day
for ($j = 0; $j<=($num_of_days-1) ; $j++) {

    $sql = "SELECT DISTINCT start_time, end_time, type, concat($tbl_entry.name,' Rm:',$tbl_room.room_name), $tbl_entry.id, $tbl_entry.description
            FROM $tbl_entry
                join $tbl_room on room_id=$tbl_room.id
                left join {$CFG->prefix}course on $tbl_entry.name={$CFG->prefix}course.shortname
                left join {$CFG->prefix}context on contextlevel=50 and instanceid={$CFG->prefix}course.id
                left join {$CFG->prefix}role_assignments on contextid={$CFG->prefix}context.id and roleid=5
            WHERE ({$CFG->prefix}role_assignments.userid=$TTUSER->id or $tbl_entry.create_by = '$TTUSER->username')
            AND start_time <= $pm7[$j] AND end_time > $am7[$j]";

    # Each row returned from the query is a meeting. Build an array of the
    # form:  d[weekday][slot][x], where x = id, color, data, long_desc.
    # [slot] is based at 000 (HHMM) for midnight, but only slots within
    # the hours of interest (morningstarts : eveningends) are filled in.
    # [id], [data] and [long_desc] are only filled in when the meeting
    # should be labeled,  which is once for each meeting on each weekday.
    # Note: weekday here is relative to the $weekstarts configuration variable.
    # If 0, then weekday=0 means Sunday. If 1, weekday=0 means Monday.

    if ($debug_flag) echo "<br>DEBUG: query=$sql\n";
    $res = sql_query($sql);
    if (! $res) echo sql_error();
    else for ($i = 0; ($row = sql_row($res, $i)); $i++)
    {
        if ($debug_flag)
            echo "<br>DEBUG: result $i, id $row[4], starts $row[0], ends $row[1]\n";

        # $d is a map of the screen that will be displayed
        # It looks like:
        #     $d[Day][Time][id]
        #                  [color]
        #                  [data]
        # where Day is in the range 0 to $num_of_days.

        # Fill in the map for this meeting. Start at the meeting start time,
        # or the day start time, whichever is later. End one slot before the
        # meeting end time (since the next slot is for meetings which start then),
        # or at the last slot in the day, whichever is earlier.
        # Note: int casts on database rows for max may be needed for PHP3.
        # Adjust the starting and ending times so that bookings which don't
        # start or end at a recognized time still appear.

        $start_t = max(round_t_down($row[0], $resolution, $am7[$j]), $am7[$j]);
        $end_t = min(round_t_up($row[1], $resolution, $am7[$j]) - $resolution, $pm7[$j]);

        for ($t = $start_t; $t <= $end_t; $t += $resolution)
        {
          //checks for double bookings
          if(empty($d[$j][date($format,$t)])){
              $d[$j][date($format,$t)]["id"]    = $row[4];
              $d[$j][date($format,$t)]["color"] = $row[2];
              $d[$j][date($format,$t)]["data"]  .= "";
              $d[$j][date($format,$t)]["long_descr"]  .= "";
              $d[$j][date($format,$t)]["double_booked"]  = false;
          }else{
              $d[$j][date($format,$t)]["id"]    .= ','.$row[4];
              $d[$j][date($format,$t)]["data"]  .= "\n";
              $d[$j][date($format,$t)]["long_descr"]  .= ",";
              $d[$j][date($format,$t)]["double_booked"]  = true;
          }
        }

        # Show the name of the booker in the first segment that the booking
        # happens in, or at the start of the day if it started before today.
        if ($row[1] < $am7[$j])
        {
            $d[$j][date($format,$am7[$j])]["data"] .= $row[3];
            $d[$j][date($format,$am7[$j])]["long_descr"] .= $row[5];
        }
        else
        {
            $d[$j][date($format,$start_t)]["data"] .= $row[3];
            $d[$j][date($format,$start_t)]["long_descr"] .= $row[5];
        }
    }
}



// Include the active cell content management routines.
// Must be included before the beginnning of the main table.
    if ($javascript_cursor) // If authorized in config.inc.php, include the javascript cursor management.
            {
        echo "<SCRIPT language=\"JavaScript\" type=\"text/javascript\" src=\"xbLib.js\"></SCRIPT>\n";
            echo "<SCRIPT language=\"JavaScript\">InitActiveCell("
               . ($show_plus_link ? "true" : "false") . ", "
               . "true, "
               . ((FALSE != $times_right_side) ? "true" : "false") . ", "
               . "\"$highlight_method\", "
               . "\"" . get_string('click_to_reserve','block_mrbs') . "\""
               . ");</SCRIPT>\n";
            }

#This is where we start displaying stuff
echo "<table cellspacing=0 border=1 width=\"100%\">";

# The header row contains the weekday names and short dates.
echo "<tr><th width=\"1%\"><br>".($enable_periods ? get_string('period','block_mrbs') : get_string('time'))."</th>";
if (empty($dateformat))
    $dformat = "%a<br>%b %d";
else
    $dformat = "%a<br>%d %b";
for ($j = 0; $j<=($num_of_days-1) ; $j++)
{
    $t = mktime( 12, 0, 0, $month, $day+$j, $year);
    echo "<th width=\"14%\"><a href=\"day.php?year=" . userdate($t, "%Y") .
    "&month=" . userdate($t, "%m") . "&day=" . userdate($t, "%d") .
    "&area=$area\" title=\"" . get_string('viewday','block_mrbs') . "\">"
    . userdate($t, $dformat) . "</a></th>\n";
}
# next line to display times on right side
if ( FALSE != $times_right_side )
{
    echo "<th width=\"1%\"><br>"
    . ( $enable_periods  ? get_string('period','block_mrbs') : get_string('time') )
    . "</th>";
}

echo "</tr>\n";


# This is the main bit of the display. Outer loop is for the time slots,
# inner loop is for days of the week.

# URL for highlighting a time. Don't use REQUEST_URI or you will get
# the timetohighlight parameter duplicated each time you click.
$hilite_url="week.php?year=$year&month=$month&day=$day&area=$area&room=$room&timetohighlight";

# if the first day of the week to be displayed contains as DST change then
# move to the next day to get the hours in the day.
( $dst_change[0] != -1 ) ? $j = 1 : $j = 0;

$row_class = "even_row";
for (
    $t = mktime($morningstarts, $morningstarts_minutes, 0, $month, $day+$j, $year);
    $t <= mktime($eveningends, $eveningends_minutes, 0, $month, $day+$j, $year);
    $t += $resolution, $row_class = ($row_class == "even_row")?"odd_row":"even_row"
)
{
    # use hour:minute format
    $time_t = date($format, $t);
    # Show the time linked to the URL for highlighting that time:
    echo "<tr>";
    tdcell("red");
    if( $enable_periods ){
        $time_t_stripped = preg_replace( "/^0/", "", $time_t );
        echo "<a href=\"$hilite_url=$time_t\"  title=\""
        . get_string('highlight_line','block_mrbs') . "\">"
        . $periods[$time_t_stripped] . "</a></td>";
    } else {
        echo "<a href=\"$hilite_url=$time_t\" title=\""
        . get_string('highlight_line','block_mrbs') . "\">"
        . userdate($t, hour_min_format()) . "</a></td>";
    }

    # Color to use for empty cells: white, unless highlighting this row:
    if (isset($timetohighlight) && $timetohighlight == $time_t)
        $empty_color = "red";
    else
        $empty_color = "white";

    # See note above: weekday==0 is day $weekstarts, not necessarily Sunday.
    for ($thisday = 0; $thisday<=($num_of_days-1) ; $thisday++)
    {
        # Three cases:
        # color:  id:   Slot is:   Color:    Link to:
        # -----   ----- --------   --------- -----------------------
        # unset   -     empty      white,red add new entry
        # set     unset used       by type   none (unlabelled slot)
        # set     set   used       by type   view entry

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
        }
        else
            unset($id);

        # $c is the colour of the cell that the browser sees. White normally,
        # red if were hightlighting that line and a nice attractive green if the room is booked.
        # We tell if its booked by $id having something in it
        if (isset($id))
            $c = $color;
        elseif (isset($timetohighlight) && ($time_t == $timetohighlight))
            $c = "red";
        else
            $c = $row_class;

        tdcell($c);

        # If the room isnt booked then don't allow it to be booked
        if(!isset($id))
        {
            $hour = date("H",$t);
            $minute  = date("i",$t);

            if ( $pview != 1 ) {
                if ($javascript_cursor)
                {
                    echo "<SCRIPT language=\"JavaScript\">\n<!--\n";
                    echo "BeginActiveCell();\n";
                    echo "// -->\n</SCRIPT>";
                }
                if ($javascript_cursor)
                {
                    echo "<SCRIPT language=\"JavaScript\">\n<!--\n";
                    echo "EndActiveCell();\n";
                    echo "// -->\n</SCRIPT>";
                }
            } else
                echo '&nbsp;';
        }
        elseif ($double_booked){
                $descrs=split("\n",$descr);
                $long_descrs=split(",",$long_descr);
                $ids=split(",",$id);
            }else{
                $descrs[]=$descr;
                $long_descrs[]=$long_descr;
                $ids[]=$id;
            }
            for($i=0;$i<count($descrs);$i++){
                if ($descr != ""){
                    #if it is booked then show
                    if($i>0)echo'<br>';
                    echo "<a href=\"view_entry.php?id=$ids[$i]&area=$area&day=$wday&month=$wmonth&year=$wyear\" title=\"$long_descrs[$i]\">$descrs[$i]</a>";
                }else{
                    echo "&nbsp;\"&nbsp;";
                }
            }
            unset($descrs);
            unset($long_descrs);
            unset($ids);
        echo "</td>\n";
    }

    # next lines to display times on right side
    if ( FALSE != $times_right_side )
    {
        if( $enable_periods )
        {
            tdcell("red");
            $time_t_stripped = preg_replace( "/^0/", "", $time_t );
            echo "<a href=\"$hilite_url=$time_t\"  title=\""
            . get_string('highlight_line','block_mrbs') . "\">"
            . $periods[$time_t_stripped] . "</a></td>";
        }
        else
        {
            tdcell("red");
            echo "<a href=\"$hilite_url=$time_t\" title=\""
            . get_string('highlight_line','block_mrbs') . "\">"
            . userdate($t, hour_min_format()) . "</a></td>";
        }
    }

    echo "</tr>\n";
}
echo "</table>";

show_colour_key();

//include "trailer.php";
?>
