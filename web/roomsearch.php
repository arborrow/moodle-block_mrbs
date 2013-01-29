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
require_once("mrbs_auth.php");

require_login();
global $twentyfourhour_format;

$day = optional_param('day', 0, PARAM_INT);
$month = optional_param('month', 0, PARAM_INT);
$year = optional_param('year', 0, PARAM_INT);
$area = optional_param('area', get_default_area(),  PARAM_INT);
$edit_type = optional_param('edit_type', '', PARAM_ALPHA);
$id = optional_param('id', 0, PARAM_INT);
$room_id = optional_param('room_id', 0, PARAM_INT);
$start_hour = optional_param('start_hour', 0, PARAM_INT);
// $rep_type could use a closer look but I believe this is not passed via URL -ab.
$start_min = optional_param('start_min', 0, PARAM_INT);
$rep_num_weeks = optional_param('rep_num_weeks', 0, PARAM_INT);
$force = optional_param('force', FALSE, PARAM_BOOL);
$duration = optional_param('duration', 1, PARAM_INT);
$all_day = optional_param('all_day', FALSE, PARAM_BOOL);
if ($enable_periods) {
    $default_dur_units = 'periods';
} else {
    $default_dur_units = 'hours';
}

        $dur_units = optional_param('dur_units', $default_dur_units, PARAM_TEXT);

//If we dont know the right date then make it up
if(($day==0) or ($month==0) or ($year==0))
{
    $day   = date("d");
    $month = date("m");
    $year  = date("Y");
}

?>

<html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/JavaScript">
    function openURL(sURL) {
        opener.document.location = sURL;window.close();
    }
</script>



<script type="text/javascript" src="roomsearch.js"></script>
<SCRIPT LANGUAGE="JavaScript">
function OnAllDayClick() // Executed when the user clicks on the all_day checkbox.
{
  allday = document.getElementById('all_day');
  form = document.forms["main"];
  if (allday.checked) // If checking the box...
  {
    <?php if( ! $enable_periods ) { ?>
      form.hour.value = "00";
      form.minute.value = "00";
    <?php } ?>
    if (form.dur_units.value!="days") // Don't change it if the user already did.
    {
      form.duration.value = "1";
      form.dur_units.value = "days";
    }
  }
  RoomSearch()
}
</SCRIPT>
<?php
    // Set the weekday names for the 'ChangeOptionDays' function
    echo '<script type="text/javascript">SetWeekDayNames(';
    echo '"'.get_string('mon', 'calendar').'", ';
    echo '"'.get_string('tue', 'calendar').'", ';
    echo '"'.get_string('wed', 'calendar').'", ';
    echo '"'.get_string('thu', 'calendar').'", ';
    echo '"'.get_string('fri', 'calendar').'", ';
    echo '"'.get_string('sat', 'calendar').'", ';
    echo '"'.get_string('sun', 'calendar').'"';
    echo ');</script>';
?>
</head><body>
<h2><?php echo get_string('search');?></H2>

<div id="searchform">
<FORM NAME="main" >
<TABLE BORDER=0>

<!-- Date selectors -->
    <TR><TD CLASS=CR><B><?php echo get_string('date')?></B></TD>
     <TD CLASS=CL>
      <?php genDateSelector("", $day, $month, $year,false,true) ?>
      <SCRIPT LANGUAGE="JavaScript">ChangeOptionDays(document.main, '');</SCRIPT>
     </TD>
    </TR>

<!-- Start time/period selectors -->
    <?php if(! $enable_periods ) { ?>
    <TR><TD CLASS=CR><B><?php echo get_string('time')?></B></TD>
      <TD CLASS=CL><INPUT NAME="hour" SIZE=2 VALUE="<?php if (!$twentyfourhour_format && ($start_hour > 12)){ echo ($start_hour - 12);} else { echo $start_hour;} ?>" MAXLENGTH=2 onChange="RoomSearch()">:<INPUT NAME="minute" SIZE=2 VALUE="<?php echo $start_min;?>" MAXLENGTH=2 onChange="RoomSearch()">
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
        <SELECT NAME="period" onChange="RoomSearch()">
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

<!-- Duration selectors -->
    <?php } ?>
    <TR><TD CLASS=CR><B><?php echo get_string('duration','block_mrbs');?></B></TD>
      <TD CLASS=CL><INPUT NAME="duration" SIZE=7 VALUE="<?php echo $duration;?>" onChange="RoomSearch()" onKeyUp="RoomSearch()">
        <SELECT NAME="dur_units" onChange="RoomSearch()">
    <?php
    if( $enable_periods )
        $units = array("periods", "days");
    else
        $units = array("minutes", "hours", "days", "weeks");

    while (list(,$unit) = each($units))
    {
        echo "<OPTION VALUE=$unit";
        if ($dur_units == get_string($unit,'block_mrbs')) echo " SELECTED";
        echo " onChange=\"RoomSearch()\">".get_string($unit,'block_mrbs');
    }
    ?>
        </SELECT>
        <INPUT NAME="all_day" TYPE="checkbox" VALUE="yes" id="all_day" <?php if ($all_day) echo 'CHECKED ';?>onClick="OnAllDayClick()"> <?php echo get_string('all_day','block_mrbs');
        if ($all_day) echo '<body onload = "OnAllDayClick()"></body>'; ?>
    </TD></TR>

<!-- Capacity input-->
    <TR><TD CLASS=CR><B><?php echo get_string('mincapacity','block_mrbs')?></B></TD>
     <TD CLASS=CL><INPUT NAME="mincap" SIZE="3" onChange="RoomSearch()" onKeyUp="RoomSearch()"></TD>
    </TR>

<!-- Teaching room input-->
    <TR><TD CLASS=CR><B><?php echo get_string('teachingroom','block_mrbs')?></B></TD>
     <TD CLASS=CL><INPUT TYPE="checkbox" NAME="teaching" onClick="RoomSearch()" CHECKED></TD>
    </TR>

<!-- Special room input-->
    <TR><TD CLASS=CR><B><?php echo get_string('specialroom','block_mrbs')?></B></TD>
     <TD CLASS=CL><INPUT TYPE="checkbox" NAME="special" onClick="RoomSearch()" CHECKED></TD>
    </TR>

<!-- Computer room input-->
    <TR><TD CLASS=CR><B><?php echo get_string('computerroom','block_mrbs')?></B></TD>
     <TD CLASS=CL><INPUT TYPE="checkbox" NAME="computer" onClick="RoomSearch()"></TD>
    </TR>

</TABLE>
</FORM>

</div>

<!-- Area to display rooms found -->
    <h2 id="results"></h2>
    <?php echo'<table border=1 ><thead><tr><th>'.get_string('area','block_mrbs').'</th><th>Room</th><th>'.get_string('description').'</th><th>'.get_string('capacity','block_mrbs').'</th></tr></thead><tbody id="rooms"></tbody></table>';?>


<SCRIPT LANGUAGE="JavaScript">
var langRoomsFree='<?php print_string('roomsfree','block_mrbs');?>';
var langNoRooms='<?php print_string('noroomsfound','block_mrbs');?>';
window.onload=RoomSearch();
</SCRIPT>


</body>
</html>
