<?php
# $Id: edit_entry.php,v 1.17 2009/12/27 19:15:18 arborrow Exp $
require_once("../../../config.php"); //for Moodle integration
require_once('grab_globals.inc.php');
include "config.inc.php";
include "functions.php";
include "$dbsys.php";
include "mrbs_auth.php";
require_login();
global $twentyfourhour_format;

$day = optional_param('day', 0, PARAM_INT);
$month = optional_param('month', 0, PARAM_INT);
$year = optional_param('year', 0, PARAM_INT); 
$area = optional_param('area', get_default_area(),  PARAM_INT);
$edit_type = optional_param('edit_type', '', PARAM_ALPHA);
$rep_id = optional_param('rep_id', 0, PARAM_INT);
$id = optional_param('id', 0, PARAM_INT);
$room_id = optional_param('room_id', 0, PARAM_INT);
$start_hour = optional_param('start_hour', 0, PARAM_INT);
// $morningstarts = optional_param('morningstarts', 0, PARAM_INT); //I believe this is coming from somewhere else - not URL - ab.
// $rep_type could use a closer look but I believe this is not passed via URL -ab.
$start_min = optional_param('start_min', 0, PARAM_INT);
$rep_num_weeks = optional_param('rep_num_weeks', 0, PARAM_INT); 
$force = optional_param('force', FALSE, PARAM_BOOL); 
$duration = optional_param('duration', 60, PARAM_INT);
$all_day = optional_param('all_day', FALSE, PARAM_BOOL);
$series = optional_param('series', 0, PARAM_INT);
$create_by = optional_param('create_by', 0, PARAM_INT);

#If we dont know the right date then make it up
if(($day==0) or ($month==0) or ($year==0)) {
	$day   = date("d");
	$month = date("m");
	$year  = date("Y");
}
// if(empty($area)) //handled by optional_param -ab
//	$area = get_default_area();

// if(!isset($edit_type)) //handled by optional_param -ab
// 	$edit_type = "";

if(!getAuthorised(1)) {
	showAccessDenied($day, $month, $year, $area);
	exit;
}

# This page will either add or modify a booking

# We need to know:
#  Name of booker
#  Description of meeting
#  Date (option select box for day, month, year)
#  Time
#  Duration
#  Internal/External

# Firstly we need to know if this is a new booking or modifying an old one
# and if it's a modification we need to get all the old data from the db.
# If we had $id passed in then it's a modification.
if ($id>0) {
	$sql = "SELECT name, create_by, description, start_time, end_time, type, room_id, entry_type, repeat_id, timestamp 
			FROM $tbl_entry 
			WHERE id=$id";
	$res = sql_query($sql);
	if (! $res) { 
	    fatal_error(1, sql_error());
	}
	if (sql_count($res) != 1) {
	    fatal_error(1, get_string('entryid','block_mrbs') . $id . get_string('not_found','block_mrbs'));
	}
	$row = sql_row($res, 0);
	sql_free($res);
	// Note: Removed stripslashes() calls from name and description. Previous
	// versions of MRBS mistakenly had the backslash-escapes in the actual database
	// records because of an extra addslashes going on. Fix your database and
	// leave this code alone, please.
	$name        = $row[0];
	$create_by   = $row[1];
	$description = $row[2];
    $start_time   = $row[3];
	$start_day   = userdate($row[3], '%d');
	$start_month = userdate($row[3], '%m');
	$start_year  = userdate($row[3], '%Y');
	$start_hour  = userdate($row[3], '%H');
	$start_min   = userdate($row[3], '%M');
    $end_time    = $row[4];
	$duration    = $row[4] - $row[3] - cross_dst($row[3], $row[4]);
	$type        = $row[5];
	$room_id     = $row[6];
    //put this here so that a move can be coded into the get data
    if(!empty($room)) {
        $room_id=$room;
    }
	$entry_type  = $row[7];
	$rep_id      = $row[8];
	
	if($entry_type >= 1) {
		$sql = "SELECT rep_type, start_time, end_date, rep_opt, rep_num_weeks, timestamp
		        FROM $tbl_repeat WHERE id=$rep_id";
		
		$res = sql_query($sql);
		if (! $res) {
		    fatal_error(1, sql_error());
		}
		if (sql_count($res) != 1) {
		    fatal_error(1, get_string('repeat_id','block_mrbs') . $rep_id . get_string('not_found','block_mrbs'));
		}
		$row = sql_row($res, 0);
		sql_free($res);
		$rep_type = $row[0];

		if($edit_type == "series") {
			$start_day   = (int)userdate($row[1], '%d');
			$start_month = (int)userdate($row[1], '%m');
			$start_year  = (int)userdate($row[1], '%Y');
			
			$rep_end_day   = (int)userdate($row[2], '%d');
			$rep_end_month = (int)userdate($row[2], '%m');
			$rep_end_year  = (int)userdate($row[2], '%Y');
			
			switch($rep_type) {
				case 2:
				case 6:
					$rep_day[0] = $row[3][0] != "0";
					$rep_day[1] = $row[3][1] != "0";
					$rep_day[2] = $row[3][2] != "0";
					$rep_day[3] = $row[3][3] != "0";
					$rep_day[4] = $row[3][4] != "0";
					$rep_day[5] = $row[3][5] != "0";
					$rep_day[6] = $row[3][6] != "0";

					if ($rep_type == 6)
					{
						$rep_num_weeks = $row[4];
					}
					
					break;
				
				default:
					$rep_day = array(0, 0, 0, 0, 0, 0, 0);
			}
		} else {
			$rep_type     = $row[0];
			$rep_end_date = userdate($row[2], '%A %d %B %Y');
			$rep_opt      = $row[3];
		}
	}
} else { // It is a new booking. The data comes from whichever button the user clicked
	$edit_type   = "series";
	$name        = getUserName();
	$create_by   = getUserName();
	$description = "Class";
	$start_day   = $day;
	$start_month = $month;
	$start_year  = $year;
    // Avoid notices for $hour and $minute if periods is enabled
    (isset($hour)) ? $start_hour = $hour : '';
	(isset($minute)) ? $start_min = $minute : '';
    //$duration    = ($enable_periods ? 60 : 60 * 60);
	$type        = "I";
	$room_id     = $room;
        $start_time = mktime(12,$period,00,$start_month,$start_day,$start_year);
    unset($id);
       $end_time=$start_time;
	$rep_id        = 0;
	$rep_type      = 0;
	$rep_end_day   = $day;
	$rep_end_month = $month;
	$rep_end_year  = $year;
	$rep_day       = array(0, 0, 0, 0, 0, 0, 0);
}

# These next 4 if statements handle the situation where
# this page has been accessed directly and no arguments have
# been passed to it.
# If we have not been provided with a room_id
if ($room_id==0  ) {
	$sql = "SELECT id FROM $tbl_room LIMIT 1";
	$res = sql_query($sql);
	$row = sql_row($res, 0);
	$room_id = $row[0];
}

# If we have not been provided with starting time
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

#now that we know all the data to fill the form with we start drawing it

if(!getWritable($create_by, getUserName())) {
	showAccessDenied($day, $month, $year, $area);
	exit;
}

print_header_mrbs($day, $month, $year, $area);

?>
<SCRIPT type="text/javascript" src="updatefreerooms.js"></SCRIPT> 
<SCRIPT LANGUAGE="JavaScript">

<?php
echo 'var currentroom='. $room_id.';';
if (has_capability("block/mrbs:forcebook",get_context_instance(CONTEXT_SYSTEM))){
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

<H2><?php echo isset($id) ? ($edit_type == "series" ? get_string('editseries','block_mrbs') : get_string('editentry','block_mrbs')) : get_string('addentry','block_mrbs'); ?></H2>

<FORM NAME="main" ACTION="edit_entry_handler.php" METHOD="GET">

<TABLE BORDER=0>

<TR><TD CLASS=CR><B><?php echo get_string('namebooker','block_mrbs')?></B></TD>
  <TD CLASS=CL><INPUT NAME="name" SIZE=40 VALUE="<?php echo htmlspecialchars($name,ENT_NOQUOTES) ?>"></TD></TR>

<TR><TD CLASS=TR><B><?php echo get_string('fulldescription','block_mrbs')?></B></TD>
  <!--  <TD CLASS=TL><TEXTAREA NAME="description" ROWS=8 COLS=40 WRAP="virtual"> //removing undefined wrap attribute-->
  <TD CLASS=TL><TEXTAREA NAME="description" ROWS=8 COLS=40>
  <?php echo
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
      # Determine the area id of the room in question first
      $sql = "select area_id from $tbl_room where id=$room_id";
      $res = sql_query($sql);
      $row = sql_row($res, 0);
      $area_id = $row[0];
      # determine if there is more than one area
      $sql = "select id from $tbl_area";
      $res = sql_query($sql);
      $num_areas = sql_count($res);
      # if there is more than one area then give the option
      # to choose areas.
      if( $num_areas > 1 ) {

?>
<script language="JavaScript">
<!--

// create area selector if javascript is enabled as this is required
// if the room selector is to be updated.
this.document.writeln("<tr><td class=CR><b><?php echo get_string('areas','block_mrbs') ?>:</b></td><td class=CL valign=top>");
this.document.writeln("          <select name=\"areas\" onChange=\"updateFreeRooms()\">");
<?php
# get list of areas
$sql = "select id, area_name from $tbl_area order by area_name";
$res = sql_query($sql);
if ($res) for ($i = 0; ($row = sql_row($res, $i)); $i++)
{
	$selected = "";
	if ($row[0] == $area_id) {
		$selected = "SELECTED";
	}
	print "this.document.writeln(\"            <option $selected value=\\\"".$row[0]."\\\">".$row[1]."\")\n";
}

//Add special IT option
    print "this.document.writeln(\"            <option  value=\\\"IT\\\">".get_string('computerrooms','block_mrbs')."\")\n";
?>
this.document.writeln("          </select>");
this.document.writeln("</td></tr>");
// -->
</script>
<?php
} # if $num_areas
?>
<tr><td class=CR><b><?php echo get_string('rooms','block_mrbs') ?>:</b></td>
  <td class=CL valign=top><table><tr><td><select name="rooms[]" multiple="yes">
  <?php
        # select the rooms in the area determined above
	$sql = "select id, room_name from $tbl_room where area_id=$area_id order by room_name";
   	$res = sql_query($sql);


   	if ($res) for ($i = 0; ($row = sql_row($res, $i)); $i++)
   	{
		$selected = "";
		if ($row[0] == $room_id) {
			$selected = "SELECTED";
		}
        echo "<option $selected value=\"".$row[0]."\">".$row[1]."($row[2] Capacity:$row[3])";
        // store room names for emails
        $room_names[$i] = $row[1];
   	}
  ?>
  </select></td><td><?php echo get_string('ctrl_click','block_mrbs') ?></td></tr>
  <tr><td><?php echo get_string('dontshowoccupied', 'block_mrbs') ?><input name="nooccupied" id="nooccupied" type="checkbox" checked="checked" onclick="updateFreeRooms()" /></td><td></td></tr>

  </table>
    </td></tr>

<TR><TD CLASS=CR><B><?php echo get_string('type','block_mrbs')?></B></TD>
  <TD CLASS=CL><SELECT NAME="type">
<?php
//If this is an imported booking, forcably mark it as edited so that changes are not overridden on next import
if(($type == 'K') or ($type == 'L')){
    echo '<OPTION VALUE=L SELECTED >'.$typel['L'].'</option>\n';
}else{  
    for ($c = "A"; $c <= "J"; $c++){
        if (!empty($typel[$c])){
		    echo "<OPTION VALUE=$c" . ($type == $c ? " SELECTED" : "") . ">$typel[$c]\n";
        }
    }
}
?></SELECT></TD></TR>
<tr><td>
<?php if(has_capability("block/mrbs:forcebook",get_context_instance(CONTEXT_SYSTEM))){
    echo'<b>Forceably book (automatically move other bookings):<input type="checkbox" name="forcebook" value="TRUE"';
    if ($force)echo '"CHECKED"';
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
	echo "<INPUT NAME=\"rep_type\" TYPE=\"RADIO\" VALUE=\"" . $i . "\"";

	if($i == $rep_type)
		echo " CHECKED";

	echo ">" . get_string('rep_type_'.$i,'block_mrbs') . "\n";
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
# Display day name checkboxes according to language and preferred weekday start.
for ($i = 0; $i < 7; $i++)
{
	$wday = ($i + $weekstarts) % 7;
	echo "<INPUT NAME=\"rep_day[$wday]\" TYPE=CHECKBOX";
	if ($rep_day[$wday]) echo " CHECKED";
	echo ">" . day_name($wday) . "\n";
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
			# Display day names according to language and preferred weekday start.
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
        echo "<NOSCRIPT><a id=\"dellink\" HREF=\"del_entry.php?id=$id&series=0\">".get_string('deleteentry','block_mrbs')."</A></NOSCRIPT>"
                ."<script type=\"text/javascript\">
                    document.writeln('<a href=\"#\" onClick=\"if(confirm(\'".get_string('confirmdel','block_mrbs')."\')){document.location=\'del_entry.php?id=$id&series=0\';}\">".get_string('deleteentry','block_mrbs')."</a>');
                 </script>";
        if($rep_id) {
            echo " - ";
            echo "<NOSCRIPT><a id=\"dellink\" HREF=\"del_entry.php?id=$id&series=1&day=$day&month=$month&year=$year\">".get_string('deleteentry','block_mrbs')."</A></NOSCRIPT>"
                ."<script type=\"text/javascript\">
                    document.writeln('<a href=\"#\" onClick=\"if(confirm(\'".get_string('confirmdel','block_mrbs')."\')){document.location=\'del_entry.php?id=$id&series=1&day=$day&month=$month&year=$year\';}\">".get_string('deleteseries','block_mrbs')."</a>');
                 </script>";
        }
    }
    ?>
 </TD></TR>
</TABLE>

<INPUT TYPE=HIDDEN NAME="returl"    VALUE="<?php echo $HTTP_REFERER?>">
<!--INPUT TYPE=HIDDEN NAME="room_id"   VALUE="<?php echo $room_id?>"-->
<INPUT TYPE=HIDDEN NAME="create_by" VALUE="<?php echo $create_by?>">
<INPUT TYPE=HIDDEN NAME="rep_id"    VALUE="<?php echo $rep_id?>">
<INPUT TYPE=HIDDEN NAME="edit_type" VALUE="<?php echo $edit_type?>">
<?php if(isset($id)) echo "<INPUT TYPE=HIDDEN NAME=\"id\"        VALUE=\"$id\">\n";
?>

</FORM>

<?php include "trailer.php" ?>
