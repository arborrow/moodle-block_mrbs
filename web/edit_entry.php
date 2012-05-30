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

require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/config.php'); //for Moodle integration
include "config.inc.php";
include "functions.php";
require_once('mrbs_auth.php');

global $twentyfourhour_format, $morningstarts;

$day = optional_param('day', 0, PARAM_INT);
$month = optional_param('month', 0, PARAM_INT);
$year = optional_param('year', 0, PARAM_INT);
$area = optional_param('area', 0,  PARAM_INT);
$edit_type = optional_param('edit_type', '', PARAM_ALPHA);
$id = optional_param('id', 0, PARAM_INT);
$room = optional_param('room', 0, PARAM_INT);
$hour = optional_param('hour', '', PARAM_INT);
$minute = optional_param('minute', '', PARAM_INT);
$force = optional_param('force', FALSE, PARAM_BOOL);
$period = optional_param('period', 0, PARAM_INT);
$all_day = optional_param('all_day', FALSE, PARAM_BOOL);

//If we dont know the right date then make it up
if(($day==0) or ($month==0) or ($year==0)) {
	$day   = date("d");
	$month = date("m");
	$year  = date("Y");
}

$thisurl = new moodle_url('/blocks/mrbs/web/edit_entry.php', array('day'=>$day, 'month'=>$month, 'year'=>$year));

if ($area) {
    $thisurl->param('area', $area);
} else {
    $area = get_default_area();
}
if ($id) {
    $thisurl->param('id', $id);
}
if ($force) {
    $thisurl->param('force', $force);
}
if ($room) {
    $thisurl->param('room', $room);
}
if (!empty($edit_type)) {
    $thisurl->param('edit_type', $edit_type);
}
if (!empty($hour)) {
    $thisurl->param('hour', $hour);
}
if (!empty($minute)) {
    $thisurl->param('minute', $minute);;
}

$PAGE->set_url($thisurl);
require_login();

if(!getAuthorised(1)) {
	showAccessDenied($day, $month, $year, $area);
	exit;
}



// This page will either add or modify a booking

// We need to know:
//  Name of booker
//  Description of meeting
//  Date (option select box for day, month, year)
//  Time
//  Duration
//  Internal/External

// Firstly we need to know if this is a new booking or modifying an old one
// and if it's a modification we need to get all the old data from the db.
// If we had $id passed in then it's a modification.
if ($id>0) {
    $entry = $DB->get_record('block_mrbs_entry', array('id'=>$id), '*', MUST_EXIST);
	// Note: Removed stripslashes() calls from name and description. Previous
	// versions of MRBS mistakenly had the backslash-escapes in the actual database
	// records because of an extra addslashes going on. Fix your database and
	// leave this code alone, please.
	$name        = $entry->name;
	$create_by   = $entry->create_by;
	$description = $entry->description;
    $start_time   = $entry->start_time;
	$start_day   = userdate($entry->start_time, '%d');
	$start_month = userdate($entry->start_time, '%m');
	$start_year  = userdate($entry->start_time, '%Y');
	$start_hour  = userdate($entry->start_time, '%H');
	$start_min   = userdate($entry->start_time, '%M');
    $end_time    = $entry->end_time;
	$duration    = $entry->end_time - $entry->start_time - cross_dst($entry->start_time, $entry->end_time);
	$type        = $entry->type;
	$room_id     = $entry->room_id;
    //put this here so that a move can be coded into the get data
    if(!empty($room)) {
        $room_id=$room;
    }
	$entry_type  = $entry->entry_type;
	$rep_id      = $entry->repeat_id;

	if($entry_type >= 1) {
        $repeat = $DB->get_record('block_mrbs_repeat', array('id'=>$rep_id), '*', MUST_EXIST);
		$rep_type = $repeat->rep_type;

		if($edit_type == "series") {
			$start_day   = (int)userdate($repeat->start_time, '%d');
			$start_month = (int)userdate($repeat->start_time, '%m');
			$start_year  = (int)userdate($repeat->start_time, '%Y');

			$rep_end_day   = (int)userdate($repeat->end_date, '%d');
			$rep_end_month = (int)userdate($repeat->end_date, '%m');
			$rep_end_year  = (int)userdate($repeat->end_date, '%Y');

			switch($rep_type) {
				case 2:
				case 6:
					$rep_day[0] = $repeat->rep_opt[0] != "0";
					$rep_day[1] = $repeat->rep_opt[1] != "0";
					$rep_day[2] = $repeat->rep_opt[2] != "0";
					$rep_day[3] = $repeat->rep_opt[3] != "0";
					$rep_day[4] = $repeat->rep_opt[4] != "0";
					$rep_day[5] = $repeat->rep_opt[5] != "0";
					$rep_day[6] = $repeat->rep_opt[6] != "0";

					if ($rep_type == 6)
					{
						$rep_num_weeks = $repeat->rep_num_weeks;
					}

					break;

				default:
					$rep_day = array(0, 0, 0, 0, 0, 0, 0);
			}
		} else {
			$rep_type     = $repeat->rep_type;
			$rep_end_date = userdate($repeat->end_date, '%A %d %B %Y');
			$rep_opt      = $repeat->rep_opt;
		}
	}
} else { // It is a new booking. The data comes from whichever button the user clicked
	$edit_type   = "series";
	$name        = getUserName();
	$create_by   = getUserName();
	$description = '';
	$start_day   = $day;
	$start_month = $month;
	$start_year  = $year;
    // Avoid notices for $hour and $minute if periods is enabled
    $start_hour = $hour;
	$start_min = $minute;
    $duration    = ($enable_periods ? 60 : 60 * 60);
	$type        = "I";
	$room_id     = $room;
    $start_time = mktime(12,$period,00,$start_month,$start_day,$start_year);
    $end_time=$start_time;
	$rep_id        = 0;
	$rep_type      = 0;
	$rep_end_day   = $day;
	$rep_end_month = $month;
	$rep_end_year  = $year;
	$rep_day       = array(0, 0, 0, 0, 0, 0, 0);
}

// These next 4 if statements handle the situation where
// this page has been accessed directly and no arguments have
// been passed to it.
// If we have not been provided with a room_id

if ($room_id==0  ) {
    $dbroom = $DB->get_records('block_mrbs_room', null, 'room_name', 'id', 0, 1);
    if ($dbroom) {
        $dbroom = reset($dbroom);
        $room_id = $dbroom->id;
    }
}

// If we have not been provided with starting time
if (empty($start_hour) && $morningstarts<10) {
    $start_hour = "0$morningstarts";
}

if (empty($start_hour)) {
    $start_hour = "$morningstarts";
}

if (empty($start_min)) {
    $start_min = "00";
}

// Remove "Undefined variable" notice
if (empty($rep_num_weeks)) {
    $rep_num_weeks = "";
}

$enable_periods ? toPeriodString($start_min, $duration, $dur_units) : toTimeString($duration, $dur_units);

//now that we know all the data to fill the form with we start drawing it

if ($CFG->version < 2011120100) {
    $context = get_context_instance(CONTEXT_SYSTEM);
} else {
    $context = context_system::instance();
}

$roomadmin = false;
if(!getWritable($create_by, getUserName())) {
    if (has_capability('block/mrbs:editmrbsunconfirmed', $context, null, false)) {
        if ($room_id) {
            $dbroom = $DB->get_record('block_mrbs_room', array('id' => $room_id));
            if ($dbroom->room_admin_email == $USER->email) {
                $roomadmin = true;
            }
        }
    }

    if (!$roomadmin) {
        showAccessDenied($day, $month, $year, $area);
        exit;
    }
}

$PAGE->requires->js('/blocks/mrbs/web/updatefreerooms.js', true);

print_header_mrbs($day, $month, $year, $area);

?>
<SCRIPT LANGUAGE="JavaScript">

<?php
echo 'var currentroom='. $room_id.';';
if (has_capability("block/mrbs:forcebook", $context)){
    echo 'var canforcebook=true;';
} else {
    echo 'var canforcebook=false;';
}
?>
// do a little form verifying
function validate_and_submit ()
{
  // null strings and spaces only strings not allowed
  if(/(^$)|(^\s+$)/.test(document.forms["main"].name.value)) {
    alert ( "<?php echo get_string('you_have_not_entered','block_mrbs') . '\n' . get_string('name') ?>");
    return false;
  }
  // null strings and spaces only strings not allowed
  if(/(^$)|(^\s+$)/.test(document.forms["main"].description.value)) {
    alert ( "<?php echo get_string('you_have_not_entered','block_mrbs') . '\n' . get_string('description') ?>");
    return false;
  }
  <?php if( ! $enable_periods ) { ?>

  h = parseInt(document.forms["main"].hour.value);
  m = parseInt(document.forms["main"].minute.value);

  if(h > 23 || m > 59) {
    alert ("<?php echo get_string('you_have_not_entered','block_mrbs') . '\n' . get_string('valid_time_of_day','block_mrbs') ?>");
    return false;
  }
  <?php } ?>

  // check form element exist before trying to access it
  if( document.forms["main"].id )
    i1 = parseInt(document.forms["main"].id.value);
  else
    i1 = 0;

  i2 = parseInt(document.forms["main"].rep_id.value);
  if ( document.forms["main"].rep_num_weeks) {
  	n = parseInt(document.forms["main"].rep_num_weeks.value);
  }
  if ((!i1 || (i1 && i2)) && document.forms["main"].rep_type && document.forms["main"].rep_type[6].checked && (!n || n < 2)) {
    alert("<?php echo get_string('you_have_not_entered','block_mrbs') . '\n' . get_string('useful_n-weekly_value','block_mrbs') ?>");
    return false;
  }

  // check that a room(s) has been selected
  // this is needed as edit_entry_handler does not check that a room(s)
  // has been chosen
  if( document.forms["main"].elements['rooms[]'].selectedIndex == -1 ) {
    alert("<?php echo get_string('you_have_not_selected','block_mrbs') . '\n' . get_string('valid_room','block_mrbs') ?>");
    return false;
  }

  // Form submit can take some times, especially if mails are enabled and
  // there are more than one recipient. To avoid users doing weird things
  // like clicking more than one time on submit button, we hide it as soon
  // it is clicked.
  document.forms["main"].save_button.disabled="true";

  // would be nice to also check date to not allow Feb 31, etc...
  document.forms["main"].submit();

  return true;
}

function OnAllDayClick() { // Executed when the user clicks on the all_day checkbox.
  allday = document.getElementById('all_day');
  form = document.forms["main"];
  if (allday.checked) { // If checking the box...
    <?php if( ! $enable_periods ) { ?>
      form.hour.value = "00";
      form.minute.value = "00";
    <?php } ?>
    if (form.dur_units.value!="days") { // Don't change it if the user already did.
      form.duration.value = "1";
      form.dur_units.value = "days";
    }
  }
  updateFreeRooms()
}
</SCRIPT>

<H2><?php echo $id ? ($edit_type == "series" ? get_string('editseries','block_mrbs') : get_string('editentry','block_mrbs')) : get_string('addentry','block_mrbs'); ?></H2>

<FORM NAME="main" ACTION="edit_entry_handler.php" METHOD="GET">
<input type="hidden" name="sesskey" value="<?php echo sesskey(); ?>">

<TABLE BORDER=0>

    <?php if ($edit_type != 'series' && $rep_id) { ?>
<tr><td colspan="2"><b><?php $editseriesurl = new moodle_url('/blocks/mrbs/web/edit_entry.php', array('id' => $id, 'edit_type' => 'series'));
         echo get_string('editingserieswarning', 'block_mrbs');
echo html_writer::link($editseriesurl, get_string('editseries', 'block_mrbs')); ?>
</b></td></tr>
     <?php } ?>

<TR><TD CLASS=CR><B><?php echo get_string('namebooker','block_mrbs')?></B></TD>
  <TD CLASS=CL><INPUT NAME="name" SIZE=40 VALUE="<?php echo htmlspecialchars($name,ENT_NOQUOTES) ?>"></TD></TR>

<TR><TD CLASS=TR><B><?php echo get_string('fulldescription','block_mrbs')?></B></TD>
  <!--  <TD CLASS=TL><TEXTAREA NAME="description" ROWS=8 COLS=40 WRAP="virtual"> //removing undefined wrap attribute-->
  <TD CLASS=TL><TEXTAREA NAME="description" ROWS=8 COLS=40><?php echo
htmlspecialchars ( $description ); ?></TEXTAREA></TD></TR>

<TR><TD CLASS=CR><B><?php echo get_string('date')?></B></TD>
 <TD CLASS=CL>
  <?php genDateSelector("", $start_day, $start_month, $start_year,true) ?>
  <SCRIPT LANGUAGE="JavaScript">ChangeOptionDays(document.main, '');</SCRIPT>
 </TD>
</TR>

<?php if(! $enable_periods ) { ?>
<TR><TD CLASS=CR><B><?php echo get_string('time')?></B></TD>
  <TD CLASS=CL><INPUT NAME="hour" SIZE=2 VALUE="<?php if (!$twentyfourhour_format && ($start_hour > 12)){ echo ($start_hour - 12);} else { echo $start_hour;} ?>" MAXLENGTH=2 onChange="updateFreeRooms()">:<INPUT NAME="minute" SIZE=2 VALUE="<?php echo $start_min;?>" MAXLENGTH=2 onChange="updateFreeRooms()">
<?php
if (!$twentyfourhour_format)
{
  $checked = ($start_hour < 12) ? "checked" : "";
  echo "<INPUT NAME=\"ampm\" type=\"radio\" value=\"am\" $checked>".userdate(mktime(1,0,0,1,1,2000), "%p");
  $checked = ($start_hour >= 12) ? "checked" : "";
  echo "<INPUT NAME=\"ampm\" type=\"radio\" value=\"pm\" $checked>".userdate(mktime(13,0,0,1,1,2000), "%p");
}
?>
</TD></TR>
<?php } else { ?>
<TR><TD CLASS=CR><B><?php echo get_string('period','block_mrbs')?></B></TD>
  <TD CLASS=CL>
    <SELECT NAME="period" onChange="updateFreeRooms()">
<?php
foreach ($periods as $p_num => $p_val)
{
	echo "<OPTION VALUE=$p_num";
	if( ( isset( $period ) && $period == $p_num ) || $p_num == $start_min)
        	echo " SELECTED";
	echo ">$p_val";
}
?>
    </SELECT>

</TD></TR>

<?php } ?>
<TR><TD CLASS=CR><B><?php echo get_string('duration','block_mrbs');?></B></TD>
  <TD CLASS=CL><INPUT NAME="duration" SIZE=7 VALUE="<?php echo $duration;?>" onChange="updateFreeRooms()">
    <SELECT NAME="dur_units" onChange="updateFreeRooms()">
<?php
if( $enable_periods )
	$units = array("periods", "days");
else
	$units = array("minutes", "hours", "days", "weeks");

while (list(,$unit) = each($units))
{
	echo "<OPTION VALUE=$unit";
	if ($dur_units == get_string($unit,'block_mrbs')) echo " SELECTED";
    echo " onChange=\"updateFreeRooms()\">".get_string($unit,'block_mrbs');
}
?>
    </SELECT>
    <INPUT NAME="all_day" TYPE="checkbox" VALUE="yes" id="all_day" <?php if ($all_day) echo 'CHECKED ';?>onClick="OnAllDayClick()"> <?php echo get_string('all_day','block_mrbs');
    if ($all_day) echo '<body onload = "OnAllDayClick()"></body>'; ?>
</TD></TR>


<?php
 // Determine the area id of the room in question first
$area_id = $DB->get_field('block_mrbs_room', 'area_id', array('id'=>$room_id), MUST_EXIST);
// determine if there is more than one area
$areas = $DB->get_records('block_mrbs_area', null, 'area_name');
// if there is more than one area then give the option
// to choose areas.
if( count($areas) > 1 ) {

?>
<script language="JavaScript">
<!--

// create area selector if javascript is enabled as this is required
// if the room selector is to be updated.
this.document.writeln("<tr><td class=CR><b><?php echo get_string('areas','block_mrbs') ?>:</b></td><td class=CL valign=top>");
this.document.writeln("          <select name=\"areas\" onChange=\"updateFreeRooms()\">");
<?php
// get list of areas

foreach ($areas as $dbarea) {
	$selected = "";
	if ($dbarea->id == $area_id) {
		$selected = "SELECTED";
	}
	print "this.document.writeln(\"            <option $selected value=\\\"".$dbarea->id."\\\">".$dbarea->area_name."\")\n";
}

print "this.document.writeln(\"            <option  value=\\\"IT\\\">".get_string('computerrooms','block_mrbs')."\")\n";
?>
this.document.writeln("          </select>");
this.document.writeln("</td></tr>");
// -->
</script>
<?php
} // if $num_areas
?>
<tr><td class=CR><b><?php echo get_string('rooms','block_mrbs') ?>:</b></td>
  <td class=CL valign=top><table><tr><td><select name="rooms[]" multiple="yes">
  <?php
// select the rooms in the area determined above
//$sql = "select id, room_name from $tbl_room where area_id=$area_id order by room_name";
$rooms = $DB->get_records('block_mrbs_room', array('area_id'=>$area_id), 'room_name');

$i = 0;
foreach ($rooms as $dbroom) {
    if (!allowed_to_book($USER, $dbroom)) {
        continue;
    }
    $selected = "";
    if ($dbroom->id == $room_id) {
        $selected = "SELECTED";
    }
    echo "<option $selected value=\"".$dbroom->id."\">".s($dbroom->room_name)." (".s($dbroom->description)." Capacity:$dbroom->capacity)";
    // store room names for emails
    $room_names[$i] = $dbroom->room_name;
    $i++;
}
  ?>
  </select></td><td><?php echo get_string('ctrl_click','block_mrbs') ?></td></tr>
  <tr><td><label for="nooccupied"><?php echo get_string('dontshowoccupied', 'block_mrbs') ?></label><input name="nooccupied" id="nooccupied" type="checkbox" checked="checked" onclick="updateFreeRooms()" /></td><td></td></tr>

  </table>
    </td></tr>

<TR><TD CLASS=CR><B><?php echo get_string('type','block_mrbs')?></B></TD>
  <TD CLASS=CL><SELECT NAME="type">
<?php
//If this is an imported booking, forcably mark it as edited so that changes are not overridden on next import
if(($type == 'K') or ($type == 'L')){
    echo '<OPTION VALUE=L SELECTED >'.$typel['L'].'</option>\n';
}else{
    $unconfirmed = false;
    $unconfirmedonly = false;
    if (has_capability('block/mrbs:editmrbsunconfirmed', $context, null, false)) {
        $unconfirmed = true;
    }
    if (authGetUserLevel(getUserName()) < 2 && $unconfirmed) {
        if ($USER->email != $rooms[$room_id]->room_admin_email) {
            $type = 'U';
            $unconfirmedonly = true;
        }
    }
    if (!$unconfirmedonly) {
        for ($c = "A"; $c <= "J"; $c++){
            if (!empty($typel[$c])){
                echo "<OPTION VALUE=$c" . ($type == $c ? " SELECTED" : "") . ">$typel[$c]\n";
            }
         }
     }
    if ($unconfirmed) {
        echo '<OPTION VALUE="U" '.($type == 'U' ? 'SELECTED="SELECTED"' : '').' >'.$typel['U'].'</OPTION>\n';
    }
}
?></SELECT></TD></TR>
<tr><td>
<?php if(has_capability("block/mrbs:forcebook", $context)){
echo'<label for="mrbsforcebook"><b>'.get_string('forciblybook2', 'block_mrbs').':</b></label></td><td><input id="mrbsforcebook" type="checkbox" name="forcebook" value="TRUE"';
    if ($force) echo ' checked="CHECKED"';
    echo' onClick="document.getElementById(\'nooccupied\').checked=!this.checked; updateFreeRooms();">';
}?>

</td></tr>
<?php if($edit_type == "series") { ?>

<TR>
 <TD CLASS=CR><B><?php echo get_string('rep_type','block_mrbs')?></B></TD>
 <TD CLASS=CL>
<?php


for($i = 0; $i<7; $i++) //manually setting this to 7 since that is how many repetition types there are -arb quick and dirty hack
{
	echo "<INPUT ID=\"radiorepeat".$i."\" NAME=\"rep_type\" TYPE=\"RADIO\" VALUE=\"" . $i . "\"";

	if($i == $rep_type)
		echo " CHECKED";

	echo '><label for="radiorepeat'.$i.'">' . get_string('rep_type_'.$i,'block_mrbs') . "</label>\n";
}

?>
 </TD>
</TR>

<TR>
 <TD CLASS=CR><B><?php echo get_string('rep_end_date','block_mrbs')?></B></TD>
 <TD CLASS=CL><?php genDateSelector("rep_end_", $rep_end_day, $rep_end_month, $rep_end_year) ?></TD>
</TR>

<TR>
 <TD CLASS=CR><B><?php echo get_string('rep_rep_day','block_mrbs')?></B> <?php echo get_string('rep_for_weekly','block_mrbs')?></TD>
 <TD CLASS=CL>
<?php
// Display day name checkboxes according to language and preferred weekday start.
for ($i = 0; $i < 7; $i++)
{
	$wday = ($i + $weekstarts) % 7;
	echo "<INPUT ID=\"chkrepeatday".$i."\" NAME=\"rep_day[$wday]\" TYPE=CHECKBOX";
	if ($rep_day[$wday]) echo " CHECKED";
	echo '><label for="chkrepeatday'.$i.'">'. day_name($wday) . "</label>\n";
}
?>
 </TD>
</TR>

<?php
}
else
{
	$key = "rep_type_" . (isset($rep_type) ? $rep_type : "0");

	echo "<tr><td class=\"CR\"><b>".get_string('rep_type','block_mrbs')."</b></td><td class=\"CL\">".get_string($key,'block_mrbs')."</td></tr>\n";

	if(isset($rep_type) && ($rep_type != 0))
	{
		$opt = "";
		if ($rep_type == 2)
		{
			// Display day names according to language and preferred weekday start.
			for ($i = 0; $i < 7; $i++)
			{
				$wday = ($i + $weekstarts) % 7;
				if ($rep_opt[$wday]) $opt .= day_name($wday) . " ";
			}
		}
		if($opt)
			echo "<tr><td class=\"CR\"><b>".get_string('rep_rep_day','block_mrbs')."</b></td><td class=\"CL\">$opt</td></tr>\n";

		echo "<tr><td class=\"CR\"><b>".get_string('rep_end_date','block_mrbs')."</b></td><td class=\"CL\">$rep_end_date</td></tr>\n";
	}
}
/* We display the rep_num_weeks box only if:
   - this is a new entry ($id is not set)
   Xor
   - we are editing an existing repeating entry ($rep_type is set and
     $rep_type != 0 and $edit_type == "series" )
*/
if ( ( ( $id==0 ) ) Xor ( isset( $rep_type ) && ( $rep_type != 0 ) && ( "series" == $edit_type ) ) )
{
?>

<TR>
 <TD CLASS=CR><B><?php echo get_string('rep_num_weeks','block_mrbs')?></B> <?php echo get_string('rep_for_nweekly','block_mrbs')?></TD>
 <TD CLASS=CL><INPUT TYPE=TEXT NAME="rep_num_weeks" VALUE="<?php echo $rep_num_weeks?>">
</TR>
<?php } ?>

<?php if ($id != 0) { ?>
<tr><td>&nbsp;</td></tr>
<tr>
<td class="CR"><label for="mrbsroomchange"><b><?php print_string('roomchange', 'block_mrbs');?></b></td>
<td><input type="checkbox" checked="checked" name="roomchange" id="mrbsroomchange" /></td>
</tr>
<?php } ?>

<TR>
 <TD colspan=2 align=center>
  <SCRIPT LANGUAGE="JavaScript">
   document.writeln ( '<INPUT TYPE="button" NAME="save_button" VALUE="<?php echo get_string('savechanges')?>" ONCLICK="validate_and_submit()">' );
  window.onload=updateFreeRooms();
  </SCRIPT>
  <NOSCRIPT>
   <INPUT TYPE="submit" VALUE="<?php echo get_string('savechanges')?>">
  </NOSCRIPT>

    <?php
    if($id){ //always be able to delete entry and if part of a series then add option to delete entire series.
        $delurl = new moodle_url('/blocks/mrbs/web/del_entry.php', array('id'=>$id, 'series'=>0, 'sesskey'=>sesskey()));
        echo "<NOSCRIPT><a id=\"dellink\" HREF=\"".$delurl."\">".get_string('deleteentry','block_mrbs')."</A></NOSCRIPT>"
                ."<script type=\"text/javascript\">
                    document.writeln('<a href=\"#\" onClick=\"if(confirm(\'".get_string('confirmdel','block_mrbs')."\')){document.location=\'".$delurl."\';}\">".get_string('deleteentry','block_mrbs')."</a>');
                 </script>";
        if($rep_id) {
            $delurl = new moodle_url('/blocks/mrbs/web/del_entry.php', array('id'=>$id, 'series'=>1, 'sesskey'=>sesskey(),
                                                                             'day'=>$day, 'month'=>$month, 'year'=>$year));
            echo " - ";
            echo "<NOSCRIPT><a id=\"dellink\" HREF=\"".$delurl."\">".get_string('deleteentry','block_mrbs')."</A></NOSCRIPT>"
                ."<script type=\"text/javascript\">
                    document.writeln('<a href=\"#\" onClick=\"if(confirm(\'".get_string('confirmdel','block_mrbs')."\')){document.location=\'".$delurl."\';}\">".get_string('deleteseries','block_mrbs')."</a>');
                 </script>";
        }
    }
    ?>
 </TD></TR>
</TABLE>

<!--<INPUT TYPE=HIDDEN NAME="returl"    VALUE="<?php echo $HTTP_REFERER?>">-->
<!--INPUT TYPE=HIDDEN NAME="room_id"   VALUE="<?php echo $room_id?>"-->
<INPUT TYPE=HIDDEN NAME="create_by" VALUE="<?php echo $create_by?>">
<INPUT TYPE=HIDDEN NAME="rep_id"    VALUE="<?php echo $rep_id?>">
<INPUT TYPE=HIDDEN NAME="edit_type" VALUE="<?php echo $edit_type?>">
<?php if(isset($id)) echo "<INPUT TYPE=HIDDEN NAME=\"id\"        VALUE=\"$id\">\n";
?>

</FORM>

<?php include "trailer.php" ?>
