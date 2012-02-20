<?php

# $Id: functions.php,v 1.18 2009/06/19 10:32:36 mike1989 Exp $
require_once("../../../config.php"); //for Moodle integration
# probably a bad place to put this, but for error reporting purposes
# $pview must be defined. if it's not then there's errors generated all
# over the place. so we test to see if it is set, and if not then set
# it.

$pview = optional_param('pview', 0, PARAM_INT);

// if (!isset($pview)) { //better to handle with optional_param
//	$pview = 0;
// }

function print_header_mrbs($day=NULL, $month=NULL, $year=NULL, $area=NULL) //if values are not passed assume NULL
{
	global $mrbs_company, $mrbs_company_url, $search_str, $locale_warning;
    $cfg_mrbs=get_config('block/mrbs');
    $strmrbs = get_string('blockname','block_mrbs');

    if(!$site = get_site()) {
        redirect($CFG->wwwroot.'/'.$CFG->admin.'/index.php');
    }


    $navlinks = array();
    $navlinks[] = array('name' => $strmrbs,
                        'link' =>$cfgmrbs->serverpath.'index.php',
                        'type' => 'misc');
    $pagetitle = '';
    $navigation = build_navigation($navlinks);
    print_header("$site->shortname: $strmrbs: $pagetitle", $strmrbs, $navigation,
                 '', '', true, '', user_login_string($site));


    $context = get_context_instance(CONTEXT_SYSTEM);
    require_capability('block/mrbs:viewmrbs', $context); // Only users with view permission can get this far

	# If we dont know the right date then make it up
	if(!$day)
		$day   = date("d");
	if(!$month)
		$month = date("m");
	if(!$year)
		$year  = date("Y");
	if (empty($search_str))
		$search_str = "";
/*
	if ($unicode_encoding)
	{
		header("Content-Type: text/html; charset=utf-8");
	}
	else
	{

		header("Content-Type: text/html; charset=".get_string('charset','block_mrbs'));
	}

	header("Pragma: no-cache");                          // HTTP 1.0
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
*/


/*<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
                      "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
  <HEAD>
*
*/

?>

<?php
   include "style.php";
?>

    <SCRIPT LANGUAGE="JavaScript">

function ChangeOptionDays(formObj, prefix, updatefreerooms, roomsearch){

    var week=new Array(7);
    week[1]="<?php print_string('mon','calendar'); ?>";
    week[2]="<?php print_string('tue','calendar'); ?>";
    week[3]="<?php print_string('wed','calendar'); ?>";
    week[4]="<?php print_string('thu','calendar'); ?>";
    week[5]="<?php print_string('fri','calendar'); ?>";
    week[6]="<?php print_string('sat','calendar'); ?>";
    week[0]="<?php print_string('sun','calendar'); ?>";
     
     
  var DaysObject = eval("formObj." + prefix + "day");
    var currentDay = DaysObject.selectedIndex;
  var MonthObject = eval("formObj." + prefix + "month");
  var YearObject = eval("formObj." + prefix + "year");

    //wipe current list
    for (j = DaysObject.options.length; j >= 0; j--) {
        DaysObject.options[j] = null;
    }
    var day=DaysObject.selectedIndex+1;
    var month=MonthObject.selectedIndex;
    var year=YearObject.options[YearObject.selectedIndex].value;


    var i=new Date();
    i.setDate(1);
    i.setMonth(month);
    i.setYear(year);

    while (i.getMonth()==month){

      DaysObject.options[i.getDate()-1] = new Option(week[i.getDay()]+" "+i.getDate(),i.getDate());
      i.setTime(i.getTime() + 86400000);
  }
   DaysObject.selectedIndex = currentDay;
   
    if(updatefreerooms){
        updateFreeRooms();
    }
    if(roomsearch){
        RoomSearch();
}
}


    </SCRIPT>
  </HEAD>
  <BODY BGCOLOR="#ffffed" TEXT=black LINK="#5B69A6" VLINK="#5B69A6" ALINK=red>
	   <?php if ( $GLOBALS["pview"] != 1 ) { ?>

   <?php # show a warning if this is using a low version of php
       if (substr(phpversion(), 0, 1) == 3)
	       echo get_string('not_php3','block_mrbs');
       if (!empty($locale_warning))
               echo "[Warning: ".$locale_warning."]";
   ?>

    <TABLE WIDTH="100%">
      <TR>
        <TD BGCOLOR="#5B69A6">
          <TABLE WIDTH="100%" BORDER=0>
            <TR>
              <TD CLASS="banner" BGCOLOR="#C0E0FF">
          <FONT SIZE=4><B><a href='<?php echo $mrbs_company_url ?>'><?php echo $mrbs_company ?></a></B><BR>
           <A HREF="index.php"><?php echo get_string('mrbs','block_mrbs') ?></A>
                </FONT>
              </TD>
              <TD CLASS="banner" BGCOLOR="#C0E0FF">
                <FORM ACTION="day.php" METHOD=GET name="Form1">
                  <FONT SIZE=2>
<?php
   genDateSelector("", $day, $month, $year); // Note: The 1st arg must match the last arg in the call to ChangeOptionDays below.
   if (!empty($area))
        echo "
                    <INPUT TYPE=HIDDEN NAME=area VALUE=$area>\n"

?>
	            <SCRIPT LANGUAGE="JavaScript">
                    <!--
                    // fix number of days for the $month/$year that you start with
                    ChangeOptionDays(document.Form1, ''); // Note: The 2nd arg must match the first in the call to genDateSelector above.
                    // -->
                    </SCRIPT>
	    <INPUT TYPE=SUBMIT VALUE="<?php echo get_string('goto','block_mrbs') ?>">
                  </FONT>
                </FORM>
              </TD>
<?php if (has_capability("block/mrbs:forcebook",get_context_instance(CONTEXT_SYSTEM))) echo'<TD CLASS="banner" BGCOLOR="#C0E0FF" ALIGN=CENTER>
                  <a href="edit_entry.php?force=TRUE">Forcibly book a room</a>
              </TD>';?>
              <TD CLASS="banner" BGCOLOR="#C0E0FF" ALIGN=CENTER>
<a target="popup" title="<?php print_string('roomsearch','block_mrbs');?>" href="roomsearch.php" onclick="this.target='popup'; return openpopup('/blocks/mrbs/web/roomsearch.php', 'popup', 'toolbar=1,location=0,scrollbars,resizable,width=500,height=400', 0);"><?php print_string('roomsearch','block_mrbs');?></a>
              </TD>

              <TD CLASS="banner" BGCOLOR="#C0E0FF" ALIGN=CENTER>
          <A HREF="help.php?day=<?php echo $day ?>&month=<?php echo $month ?>&year=<?php echo $year ?>"><?php echo get_string('help') ?></A>
              </TD>
              <TD CLASS="banner" BGCOLOR="#C0E0FF" ALIGN=CENTER>
          <A HREF="admin.php?day=<?php echo $day ?>&month=<?php echo $month ?>&year=<?php echo $year ?>"><?php echo get_string('admin') ?></A>
              </TD>
              <TD CLASS="banner" BGCOLOR="#C0E0FF" ALIGN=CENTER>
          <A HREF="report.php"><?php echo get_string('report') ?></A>
              </TD>
              <TD CLASS="banner" BGCOLOR="#C0E0FF" ALIGN=CENTER>
                <FORM METHOD=GET ACTION="search.php">
           <FONT SIZE=2><A HREF="search.php?advanced=1"><?php echo get_string('search') ?></A> </FONT>
                  <INPUT TYPE=TEXT   NAME="search_str" VALUE="<?php echo $search_str ?>" SIZE=10>
                  <INPUT TYPE=HIDDEN NAME=day        VALUE="<?php echo $day        ?>"        >
                  <INPUT TYPE=HIDDEN NAME=month      VALUE="<?php echo $month      ?>"        >
                  <INPUT TYPE=HIDDEN NAME=year       VALUE="<?php echo $year       ?>"        >
<?php
   if (!empty($area))
        echo "
                  <INPUT TYPE=HIDDEN NAME=area VALUE=$area>\n"
?>
                </FORM>
              </TD>
<?php
    # For session protocols that define their own logon box...
#    if (function_exists('PrintLogonBox')) {
#        PrintLogonBox();
#   	}
?>
            </TR>
          </TABLE>
        </TD>
      </TR>
    </TABLE>
<?php } ?>
<?php
}

function toTimeString(&$dur, &$units)
{
	if($dur >= 60)
	{
		$dur /= 60;

		if($dur >= 60)
		{
			$dur /= 60;

			if(($dur >= 24) && ($dur % 24 == 0))
			{
				$dur /= 24;

				if(($dur >= 7) && ($dur % 7 == 0))
				{
					$dur /= 7;

					if(($dur >= 52) && ($dur % 52 == 0))
					{
						$dur  /= 52;
						$units = get_string('years');
					}
					else
						$units = get_string('weeks','block_mrbs');
				}
				else
					$units = get_string('days');
			}
			else
				$units = get_string('hours','block_mrbs');
		}
		else
			$units = get_string('minutes');
	}
	else
		$units = get_string('secs');
}


function toPeriodString($start_period, &$dur, &$units)
{
	global $enable_periods;
        global $periods;

        $max_periods = count($periods);

	$dur /= 60;

        if( $dur >= $max_periods || $start_period == 0 )
        {
                if( $start_period == 0 && $dur == $max_periods )
                {
                        $units = get_string('days');
                        $dur = 1;
                        return;
                }

                $dur /= 60;
                if(($dur >= 24) && is_int($dur))
                {
                	$dur /= 24;
			$units = get_string('days');
                        return;
                }
                else
                {
			$dur *= 60;
                        $dur = ($dur % $max_periods) + floor( $dur/(24*60) ) * $max_periods;
                        $units = get_string('periods','block_mrbs');
                        return;
		}
        }
        else
		$units = get_string('periods','block_mrbs');
}



function genDateSelector($prefix, $day, $month, $year, $updatefreerooms=false, $roomsearch=false) {
	if($day   == 0) $day = date("d");
	if($month == 0) $month = date("m");
	if($year  == 0) $year = date("Y");

	echo "
                  <SELECT NAME=\"${prefix}day\" ";if($updatefreerooms){echo"onChange=\"updateFreeRooms()\"";} if($roomsearch){echo"onChange=\"RoomSearch()\"";} echo">";

	for($i = 1; $i <= 31; $i++)
		echo "
                    <OPTION " . ($i == $day ? " SELECTED" : "") . ">$i</OPTION>";

	echo "
                  </SELECT>

                  <SELECT NAME=\"${prefix}month\" onchange=\"ChangeOptionDays(this.form,'$prefix'";if($updatefreerooms){echo",true";} if($roomsearch){echo",false,true";} echo")\">";

	for($i = 1; $i <= 12; $i++)
	{
		$m = userdate(mktime(0, 0, 0, $i, 1, $year)+date('Z', mktime(0,0,0,$i,1,$year)),'%b','0');

		print "
                    <OPTION VALUE=\"$i\"" . ($i == $month ? " SELECTED" : "") . ">$m";
	}

	echo "
                  </SELECT>
              <SELECT NAME=\"${prefix}year\" onchange=\"ChangeOptionDays(this.form,'$prefix'";if($updatefreerooms){echo",true";} if($roomsearch){echo",false,true";} echo")\">";

	$min = min($year, date("Y")) - 5;
	$max = max($year, date("Y")) + 5;

	for($i = $min; $i <= $max; $i++)
		print "
                    <OPTION VALUE=\"$i\"" . ($i == $year ? " SELECTED" : "") . ">$i";

	echo "
                  </SELECT>";
}

# Error handler - this is used to display serious errors such as database
# errors without sending incomplete HTML pages. This is only used for
# errors which "should never happen", not those caused by bad inputs.
# If $need_header!=0 output the top of the page too, else assume the
# caller did that. Alway outputs the bottom of the page and exits.
function fatal_error($need_header, $message)
{
	if ($need_header) print_header_mrbs(0, 0, 0, 0);
	echo $message;
	include "trailer.php";
	exit;
}

# Apply backslash-escape quoting unless PHP is configured to do it
# automatically. Use this for GET/POST form parameters, since we
# cannot predict if the PHP configuration file has magic_quotes_gpc on.
function slashes($s)
{
	if (get_magic_quotes_gpc()) return $s;
	else return addslashes($s);
}

# Remove backslash-escape quoting if PHP is configured to do it with
# magic_quotes_gpc. Use this whenever you need the actual value of a GET/POST
# form parameter (which might have special characters) regardless of PHP's
# magic_quotes_gpc setting.
function unslashes($s)
{
	if (get_magic_quotes_gpc()) return stripslashes($s);
	else return $s;
}

# Return a default area; used if no area is already known. This returns the
# lowest area ID in the database (no guaranty there is an area 1).
# This could be changed to implement something like per-user defaults.
function get_default_area()
{
	global $tbl_area;
	$area = sql_query1("SELECT id FROM $tbl_area ORDER BY area_name LIMIT 1");
	return ($area < 0 ? 0 : $area);
}

# Return a default room given a valid area; used if no room is already known.
# This returns the first room in alphbetic order in the database.
# This could be changed to implement something like per-user defaults.
function get_default_room($area)
{
	global $tbl_room;
	$room = sql_query1("SELECT id FROM $tbl_room WHERE area_id=$area ORDER BY room_name LIMIT 1");
	return ($room < 0 ? 0 : $room);
}

# Get the local day name based on language. Note 2000-01-02 is a Sunday.
function day_name($daynumber)
{
	return userdate(mktime(0,0,0,1,2+$daynumber,2000), "%A");
}

function hour_min_format()
{
        global $twentyfourhour_format;
        if ($twentyfourhour_format)
	{
  	        return "%H:%M";
	}
	else
	{
		return "%I:%M%p";
	}
}

function period_date_string($t, $mod_time=0)
{
        global $periods;

	$time = getdate($t);
        $p_num = $time["minutes"] + $mod_time;
        if( $p_num < 0 ) $p_num = 0;
        if( $p_num >= count($periods) - 1 ) $p_num = count($periods ) - 1;
	# I have made the separater a ',' as a '-' leads to an ambiguious
	# display in report.php when showing end times.
        return array($p_num, $periods[$p_num] . userdate($t, ", %A %d %B %Y"));
}

function period_time_string($t, $mod_time=0)
{
        global $periods;

	$time = getdate($t);
        $p_num = $time["minutes"] + $mod_time;
        if( $p_num < 0 ) $p_num = 0;
        if( $p_num >= count($periods) - 1 ) $p_num = count($periods ) - 1;
        return $periods[$p_num];
}

function time_date_string($t)
{
        global $twentyfourhour_format;

        if ($twentyfourhour_format)
	{
  	        return userdate($t, "%H:%M:%S - %A %d %B %Y");
	}
	else
	{
	        return userdate($t, "%I:%M:%S%p - %A %d %B %Y");
	}
}

# Output a start table cell tag <td> with color class and fallback color.
# $colclass is an entry type (A-J), "white" for empty, or "red" for highlighted.
# The colors for CSS browsers can be found in the style sheet. The colors
# in the array below are fallback for non-CSS browsers only.
function tdcell($colclass)
{
	# This should be 'static $ecolors = array(...)' but that crashes PHP3.0.12!
	static $ecolors;
	if (!isset($ecolors)) $ecolors = array("A"=>"#FFCCFF", "B"=>"#99CCCC",
		"C"=>"#FF9999", "D"=>"#FFFF99", "E"=>"#C0E0FF", "F"=>"#FFCC99",
		"G"=>"#FF6666", "H"=>"#66FFFF", "I"=>"#DDFFDD", "J"=>"#CCCCCC",
		"red"=>"#FFF0F0", "white"=>"#FFFFFF");
	if (isset($ecolors[$colclass]))
		echo "<td class=\"$colclass\" bgcolor=\"$ecolors[$colclass]\">";
	else
		echo "<td class=\"$colclass\">";
}

# Display the entry-type color key. This has up to 2 rows, up to 5 columns.
function show_colour_key()
{
	global $typel;
	echo "<table border=0><tr>\n";
	$nct = 0;
	for ($ct = "A"; $ct <= "Z"; $ct++)
	{
		if (!empty($typel[$ct]))
		{
			if (++$nct > 5)
			{
				$nct = 0;
				echo "</tr><tr>";
			}
			tdcell($ct);
			echo "$typel[$ct]</td>\n";
		}
	}
	echo "</tr></table>\n";
}

# Round time down to the nearest resolution
function round_t_down($t, $resolution, $am7)
{
        return (int)$t - (int)abs(((int)$t-(int)$am7)
				  % $resolution);
}

# Round time up to the nearest resolution
function round_t_up($t, $resolution, $am7)
{
	if (($t-$am7) % $resolution != 0)
	{
		return $t + $resolution - abs(((int)$t-(int)
					       $am7) % $resolution);
	}
	else
	{
		return $t;
	}
}

# generates some html that can be used to select which area should be
# displayed.
function make_area_select_html( $link, $current, $year, $month, $day )
{
	global $tbl_area;
	$out_html = "
<form name=\"areaChangeForm\" method=get action=\"$link\">
  <select name=\"area\" onChange=\"document.areaChangeForm.submit()\">";

	$sql = "select id, area_name from $tbl_area order by area_name";
   	$res = sql_query($sql);
   	if ($res) for ($i = 0; ($row = sql_row($res, $i)); $i++)
   	{
		$selected = ($row[0] == $current) ? "selected" : "";
		$out_html .= "
    <option $selected value=\"".$row[0]."\">" . htmlspecialchars($row[1]);
   	}
	$out_html .= "
  </select>

  <INPUT TYPE=HIDDEN NAME=day        VALUE=\"$day\">
  <INPUT TYPE=HIDDEN NAME=month      VALUE=\"$month\">
  <INPUT TYPE=HIDDEN NAME=year       VALUE=\"$year\">
  <input type=submit value=\"".get_string('savechanges')."\">
</form>\n";

	return $out_html;
} # end make_area_select_html

function make_room_select_html( $link, $area, $current, $year, $month, $day )
{
	global $tbl_room;
	$out_html = "
<form name=\"roomChangeForm\" method=get action=\"$link\">
  <select name=\"room\" onChange=\"document.roomChangeForm.submit()\">";

	$sql = "select id, room_name from $tbl_room where area_id=$area order by room_name";
   	$res = sql_query($sql);
   	if ($res) for ($i = 0; ($row = sql_row($res, $i)); $i++)
   	{
		$selected = ($row[0] == $current) ? "selected" : "";
		$out_html .= "
    <option $selected value=\"".$row[0]."\">" . htmlspecialchars($row[1]);
   	}
	$out_html .= "
  </select>
  <INPUT TYPE=HIDDEN NAME=day        VALUE=\"$day\"        >
  <INPUT TYPE=HIDDEN NAME=month      VALUE=\"$month\"        >
  <INPUT TYPE=HIDDEN NAME=year       VALUE=\"$year\"      >
  <INPUT TYPE=HIDDEN NAME=area       VALUE=\"$area\"         >
  <input type=submit value=\"".get_string('savechanges')."\">
</form>\n";

	return $out_html;
} # end make_area_select_html


# This will return the appropriate value for isdst for mktime().
# The order of the arguments was chosen to match those of mktime.
# hour is added so that this function can when necessary only be
# run if the time is between midnight and 3am (all DST changes
# occur in this period.
function is_dst ( $month, $day, $year, $hour="-1" )
{

	if( $hour != -1  && $hour > 3)
		return( -1 );

	# entering DST
	if( !date( "I", mktime(12, 0, 0, $month, $day-1, $year)) &&
	    date( "I", mktime(12, 0, 0, $month, $day, $year)))
		return( 0 );

	# leaving DST
	elseif( date( "I", mktime(12, 0, 0, $month, $day-1, $year)) &&
	    !date( "I", mktime(12, 0, 0, $month, $day, $year)))
		return( 1 );
	else
		return( -1 );
}

# if crossing dst determine if you need to make a modification
# of 3600 seconds (1 hour) in either direction
function cross_dst ( $start, $end )
{

	# entering DST
	if( !date( "I", $start) &&  date( "I", $end))
		$modification = -3600;

	# leaving DST
	elseif(  date( "I", $start) && !date( "I", $end))
		$modification = 3600;
	else
		$modification = 0;

	return $modification;
}

/**
 * Convert already utf-8 encoded strings to charset defined for mails in
 * c.i.php.
 *
 * @param string    $string   string to convert
 * @return string   $string   string converted to get_string('charset','block_mrbs') [i.e. the character set of the MRBS block language pack
 */
function removeMailUnicode($string)
{
    global $unicode_encoding;
    //
    if ($unicode_encoding)
    {
        return iconv("utf-8", get_string('charset','block_mrbs'), $string);
    }
    else
    {
        return $string;
    }
}

// }}}
// {{{ getMailPeriodDateString()

/**
 * Format a timestamp in non-unicode output (for emails).
 *
 * @param   timestamp   $t
 * @param   int         $mod_time
 * @return  array
 */
function getMailPeriodDateString($t, $mod_time=0)
{
    global $periods;
    //
    $time = getdate($t);
    $p_num = $time['minutes'] + $mod_time;
    ( $p_num < 0 ) ? $p_num = 0 : '';
    ( $p_num >= count($periods) - 1 ) ? $p_num = count($periods ) - 1 : '';
    // I have made the separater a ',' as a '-' leads to an ambiguious
    // display in report.php when showing end times.
    return array($p_num, $periods[$p_num] . userdate($t, ", %A %d %B %Y"));
}

// }}}
// {{{ getMailTimeDateString()

/**
 * Format a timestamp in non-unicode output (for emails).
 *
 * @param   timestamp   $t         timestamp to format
 * @param   boolean     $inc_time  include time in return string
 * @return  string                 formated string
 */
function getMailTimeDateString($t, $inc_time=TRUE)
{
    global $twentyfourhour_format;
    // This bit's necessary, because it seems %p in userdate format
    // strings doesn't work
    $ampm = date("a",$t);
    if ($inc_time)
    {
        if ($twentyfourhour_format)
        {
            return userdate($t, "%H:%M:%S - %A %d %B %Y");
        }
        else
        {
            return userdate($t, "%I:%M:%S$ampm - %A %d %B %Y");
        }
    }
    else
    {
        return userdate($t, "%A %d %B %Y");
    }
}

// }}}
// {{{ notifyAdminOnBooking()

/**
 * Send email to administrator to notify a new/changed entry.
 *
 * @param bool    $new_entry    to know if this is a new entry or not
 * @param int     $new_id       used for create a link to the new entry
 * @return bool                 TRUE or PEAR error object if fails
 */
function notifyAdminOnBooking($new_entry , $new_id)
{   global $CFG;
    global $url_base, $returl, $name, $description, $area_name;
    global $room_name, $starttime, $duration, $dur_units, $end_date, $endtime;
    global $rep_enddate, $typel, $type, $create_by, $rep_type, $enable_periods;
    global $rep_opt, $rep_num_weeks;
    global $tbl_room, $tbl_area, $tbl_entry, $tbl_users, $tbl_repeat;
    global $mail_previous, $auth;

    //
    // $recipients = '';
    $id_table = ($rep_type > 0) ? "rep" : "e";
    (MAIL_ADMIN_ON_BOOKINGS) ? $recipientlist[] = MAIL_RECIPIENTS : '';
    if (MAIL_AREA_ADMIN_ON_BOOKINGS)
    {
        // Look for list of area admins emails addresses
        if ($new_entry) {
            $sql = "SELECT a.area_admin_email ";
            $sql .= "FROM $tbl_room r, $tbl_area a, $tbl_entry e ";
            // If this is a repeating entry...
            if ($id_table == 'rep')
            {
                // ...use the repeat table
                $sql .= ", $tbl_repeat rep ";
            }
            $sql .= "WHERE ${id_table}.id=$new_id AND r.id=${id_table}.room_id AND a.id=r.area_id";
            $res = sql_query($sql);
            (! $res) ? fatal_error(0, sql_error()) : '';
            $row = sql_row($res, 0);
            if (NULL != $row[0]) { //add only if email address is already not in the string
                $recipientlist[] = $row[0];
            }
        } else {
        // if this is an edited entry, we already have area_admin_email,
        // avoiding a database hit.
           if ('' != $mail_previous['area_admin_email'])  {
               $recipientlist[] = $mail_previous['area_admin_email'];
           }
        }
    }
    if (MAIL_ROOM_ADMIN_ON_BOOKINGS)
    {
        // Look for list of room admins emails addresses
        if ($new_entry)
        {
            $sql = "SELECT r.room_admin_email ";
            $sql .= "FROM $tbl_room r, $tbl_entry e ";
            // If this is a repeating entry...
            if ($id_table == 'rep')
            {
                // ...use the repeat table
                $sql .= ", $tbl_repeat rep ";
            }
            $sql .= "WHERE ${id_table}.id=$new_id AND r.id=${id_table}.room_id";
            $res = sql_query($sql);
            (! $res) ? fatal_error(0, sql_error()) : '';
            $row = sql_row($res, 0);
            if (NULL != $row[0]) {
                $recipientlist[] = $row[0];
            }
        }
        else { // if this is an edited entry, we already have room_admin_email, avoiding a database hit.
           if ('' != $mail_previous['room_admin_email']) {
               $recipientlist[] = $mail_previous['room_admin_email'];
           }
        }
    }
    if (MAIL_BOOKER) {
        if ('moodle' == $auth['type']) { //this was previously for the db authentication type but I am hijacking it for the MRBS Moodle block to lookup the user's email
            /* It would be possible to move this query within the query in
               getPreviousEntryData to have all in one central place and to
               reduce database hits by one. However this is a bad idea. If a
               user is deleted from your user database, this will prevent all
               mails to admins when this user previously booked entries will
               be changed, as no user name will match the booker name */

            $sql = "SELECT email FROM ";
            $sql .= $CFG->prefix.'user WHERE username=';
            $sql .= "'";
            $sql .= ($new_entry) ? $create_by : $mail_previous['createdby'];
            $sql .= "'";
            $res = sql_query($sql);
            (! $res) ? fatal_error(0, sql_error()) : '';
            $row = sql_row($res, 0);
            if (NULL != $row[0]) {
                $recipientlist[] = $row[0];
            }
        }
        else { //Moodle should always look up the code so this should never execute especially since MAIL_USERNAME_SUFFIX and MAIL_DOMAIN are not defined
            if ($new_entry) {
                if ('' != $create_by) {
                    $recipientlist[] = str_replace(MAIL_USERNAME_SUFFIX, '', $create_by) . MAIL_DOMAIN;
                }
            }
            else {
                if ('' != $mail_previous['createdby']) {
                    $recipientlist[] = str_replace(MAIL_USERNAME_SUFFIX, '', $mail_previous['createdby']) . MAIL_DOMAIN;
                }
            }
        }
    }
    // If there are no recipients then don't both preparing the email
    if (sizeof($recipientlist)==0) {
        return FALSE;
    }
    //
    $subject = get_string('mail_subject_entry','block_mrbs');
    if ($new_entry)
    {
        $body = get_string('mail_body_new_entry','block_mrbs') . ": \n\n";
    }
    else
    {
        $body = get_string('mail_body_changed_entry','block_mrbs') . ": \n\n";
    }
    // Set the link to view entry page
    if (isset($url_base) && ($url_base != ""))
    {
        $body .= "$url_base/view_entry.php?id=$new_id";
    }
    else
    {
        ('' != $returl) ? $url = explode(basename($returl), $returl) : '';
        $body .= $url[0] . "view_entry.php?id=$new_id";
    }
    if ($rep_type > 0)
    {
        $body .= "&series=1";
    }
    $body .= "\n";
    // Displays/don't displays entry details
    if (MAIL_DETAILS)
    {
        $body .= "\n" . get_string('namebooker','block_mrbs') . ": ";
        $body .= compareEntries(removeMailUnicode($name),
            removeMailUnicode($mail_previous['namebooker']), $new_entry). "\n";

        // Description:
        $body .= get_string('description') . ": ";
        $body .= compareEntries(removeMailUnicode($description),
            removeMailUnicode($mail_previous['description']), $new_entry) . "\n";

        // Room:
        $body .= get_string('room','block_mrbs') . ": " .
            compareEntries(removeMailUnicode($area_name),
            removeMailUnicode($mail_previous['area_name']), $new_entry);
        $body .= " - " . compareEntries(removeMailUnicode($room_name),
            removeMailUnicode($mail_previous['room_name']), $new_entry) . "\n";

        // Start time
        if ( $enable_periods )
        {
            list( $start_period, $start_date) =
                getMailPeriodDateString($starttime);
            $body .= get_string('start_date','block_mrbs') . ": ";
            $body .= compareEntries(unHtmlEntities($start_date),
                unHtmlEntities($mail_previous['start_date']), $new_entry) . "\n";
        }
        else
        {
            $start_date = getMailTimeDateString($starttime);
            $body .= get_string('start_date','block_mrbs') . ": " .
                compareEntries($start_date, $mail_previous['start_date'], $new_entry) . "\n";
        }

        // Duration
        $body .= get_string('duration','block_mrbs') . ": " .
            compareEntries($duration, $mail_previous['duration'], $new_entry);
        $body .= " " . compareEntries($dur_units, $mail_previous['dur_units'], $new_entry) . "\n";

        // End time
        if ( $enable_periods )
        {
            $myendtime = $endtime;
            $mod_time = -1;
            list($end_period, $end_date) =  getMailPeriodDateString($myendtime, $mod_time);
            $body .= get_string('end_date','block_mrbs') . ": ";
            $body .= compareEntries(unHtmlEntities($end_date),
                unHtmlEntities($mail_previous['end_date']), $new_entry) ."\n";
        }
        else
        {
            $myendtime = $endtime;
            $end_date = getMailTimeDateString($myendtime);
            $body .= get_string('end_date','block_mrbs') . ": " .
                compareEntries($end_date, $mail_previous['end_date'], $new_entry) . "\n";
        }

        // Type of booking
        $body .= get_string('type','block_mrbs') . ": ";
        if ($new_entry)
        {
            $body .= $typel[$type];
        }
        else
        {
            $temp = $mail_previous['type'];
            $body .= compareEntries($typel[$type], $typel[$temp], $new_entry);
        }

        // Created by
        $body .= "\n" . get_string('createdby','block_mrbs') . ": " .
            compareEntries($create_by, $mail_previous['createdby'], $new_entry) . "\n";

        // Last updated
        $body .= get_string('lastmodified') . ": " .
            compareEntries(getMailTimeDateString(time()), $mail_previous['updated'], $new_entry);

        // Repeat Type
        $body .= "\n" . get_string('rep_type','block_mrbs');
        if ($new_entry)
        {
            $body .= ": " . get_string('rep_type_'.$rep_type,'block_mrbs');
        }
        else
        {
            $temp = $mail_previous['rep_type'];
            $body .=  ": " . compareEntries(get_string('rep_type_'.$rep_type,'block_mrbs'),
                get_string('rep_type_'.$temp,'block_mrbs'), $new_entry);
        }

        // Details if a series
        if ($rep_type > 0)
        {
        $opt = "";
        if (($rep_type == 2) || ($rep_type == 6))
        {
        # Display day names according to language and preferred weekday start.
        for ($i = 0; $i < 7; $i++)
        {
            $daynum = ($i + $weekstarts) % 7;
            if ($rep_opt[$daynum]) $opt .= day_name($daynum) . " ";
        }
        }
        if ($rep_type == 6)
        {
        $body .= "\n" . get_string('rep_num_weeks','block_mrbs');
        $body .=  ": " . compareEntries($rep_num_weeks, $mail_previous["rep_num_weeks"], $new_entry);
        }

        if($opt || $mail_previous["rep_opt"])
        {
        $body .= "\n" . get_string('rep_rep_day','block_mrbs');
        $body .=  ": " . compareEntries($opt, $mail_previous["rep_opt"], $new_entry);
        }

            $body .= "\n" . get_string('rep_end_date','block_mrbs');
            if ($new_entry)
            {
                $body .= ": " . userdate($rep_enddate, '%A %d %B %Y');
            }
            else
            {
                $temp = userdate($rep_enddate, '%A %d %B %Y');
                $body .=  ": " .
                    compareEntries($temp, $mail_previous['rep_end_date'], $new_entry) . "\n";
            }
        }
    $body .= "\n";
    }

    array_unique($recipientlist);

    $result=1;
    if (!$fromuser=get_user_by_email(MAIL_FROM)) {
        $result=0;
    }
    foreach ($recipientlist as $recip) {
        $recipuser = get_user_by_email($recip);
        if (($recipuser) && ($result)) {
            $result = email_to_user($recipuser, $fromuser, $subject, $body);
        } else {
            if ($recipuser<1) {
                $result=0;
                notice(get_string('no_user_with_email','block_mrbs',$recip));
            } else {
                notice(get_string('no_user_with_email','block_mrbs',MAIL_FROM));
            }
        }
    }
    return $result;
}

// }}}
// {{{ notifyAdminOnDelete()

/**
 * Send email to administrator to notify a new/changed entry.
 *
 * @param   array   $mail_previous  contains deleted entry data forr email body
 * @return  bool    TRUE or PEAR error object if fails
 */
function notifyAdminOnDelete($mail_previous)
{
    global $typel, $enable_periods, $auth, $tbl_users, $CFG;
    //
    $recipients = '';
    (MAIL_ADMIN_ON_BOOKINGS) ? $recipients = MAIL_RECIPIENTS : '';
    if (MAIL_AREA_ADMIN_ON_BOOKINGS)
    {
        if ('' != $mail_previous['area_admin_email'])
        {
            $recipientlist[] = $mail_previous['area_admin_email'];
        }
    }
    if (MAIL_ROOM_ADMIN_ON_BOOKINGS)
    {
        if ('' != $mail_previous['room_admin_email'])
        {
            $recipientlist[] = $mail_previous['room_admin_email'];
        }
    }
    if (MAIL_BOOKER)
    {
        if ('moodle' == $auth['type'])
        {
            /* It would be possible to move this query within the query in
               getPreviousEntryData to have all in one central place and to
               reduce database hits by one. However this is a bad idea. If a
               user is deleted from your user database, this will prevent all
               mails to admins when this user previously booked entries will
               be changed, as no user name will match the booker name */
            $sql = "SELECT email FROM ";
            $sql .= $CFG->prefix.'user WHERE username=';
            $sql .= "'";
            $sql .= $mail_previous['createdby'];
            $sql .= "'";
            $res = sql_query($sql);
            (! $res) ? fatal_error(0, sql_error()) : '';
            $row = sql_row($res, 0);
            if (NULL != $row[0]) {
                $recipientlist[] = $row[0];
            }
        }
        else { //this should never be the case with the MRBS Moodle block
            if ( !empty($recipients) && ('' != $mail_previous['createdby']) ) {
                if ('' != $mail_previous['createdby']) {
                    $recipientlist[] = str_replace(MAIL_USERNAME_SUFFIX, '', $mail_previous['createdby']) . MAIL_DOMAIN;
                }
            }
        }
    }
    // In case mail is allowed but someone forgot to supply email addresses...
    if (sizeof($recipientlist)==0) {
        return FALSE;
    }
    //
    $subject = get_string('mail_subject_delete','block_mrbs');
    $body = get_string('mail_body_del_entry','block_mrbs') . ": \n\n";
    // Displays deleted entry details
    $body .= "\n" . get_string('namebooker','block_mrbs') . ': ';
    $body .= removeMailUnicode($mail_previous['namebooker']) . "\n";
    $body .= get_string('description') . ": ";
    $body .= removeMailUnicode($mail_previous['description']) . "\n";
    $body .= get_string('room','block_mrbs') . ": ";
    $body .= removeMailUnicode($mail_previous['area_name']);
    $body .= " - " . removeMailUnicode($mail_previous['room_name']) . "\n";
    $body .= get_string('start_date','block_mrbs') . ': ';
    if ( $enable_periods )
    {
        $body .= unHtmlEntities($mail_previous['start_date']) . "\n";
    }
    else
    {
        $body .= $mail_previous['start_date'] . "\n";
    }
    $body .= get_string('duration','block_mrbs') . ': ' . $mail_previous['duration'] . ' ';
    $body .= $mail_previous['dur_units'] . "\n";
    if ( $enable_periods )
    {
        $body .= get_string('end_date','block_mrbs') . ": ";
        $body .= unHtmlEntities($mail_previous['end_date']) ."\n";
    }
    else
    {
        $body .= get_string('end_date','block_mrbs') . ": " . $mail_previous['end_date'];
        $body .= "\n";
    }
    $body .= get_string('type','block_mrbs') . ": ";
    $body .=  (empty($typel[$mail_previous['type']])) ? "?" .
        $mail_previous['type'] . "?" : $typel[$mail_previous['type']];
    $body .= "\n" . get_string('createdby','block_mrbs') . ": ";
    $body .= $mail_previous['createdby'] . "\n";
    $body .= get_string('lastmodified') . ": " . $mail_previous['updated'];
    $body .= "\n" . get_string('rep_type','block_mrbs');
    $temp = $mail_previous['rep_type'];
    $body .=  ": " . get_string('rep_type_'.$temp,'block_mrbs');
    if ($mail_previous['rep_type'] > 0)
    {
        if ($mail_previous['rep_type'] == 6)
        {
           $body .= "\n" . get_string('rep_num_weeks','block_mrbs');
           $body .=  ": " . $mail_previous["rep_num_weeks"];
        }

        if($mail_previous["rep_opt"])
        {
           $body .= "\n" . get_string('rep_rep_day','block_mrbs');
           $body .=  " " . $mail_previous["rep_opt"];
        }

        $body .= "\n" . get_string('rep_end_date','block_mrbs');
        $body .=  " " . $mail_previous['rep_end_date'] . "\n";
    }
    $body .= "\n";
    // End of mail details

    array_unique($recipientlist);

    $result=1;
    if (!$fromuser=get_user_by_email(MAIL_FROM)) {
        $result=0;
    }
    foreach ($recipientlist as $recip) {
        $recipuser = get_user_by_email($recip);
        if (($recipuser) && ($result)) {
            $result = email_to_user($recipuser, $fromuser, $subject, $body);
            if (!$result) {
                notice(get_string('error_send_email','block_mrbs',$recip));
            }
        } else {
            if ($recipuser<1) {
                $result=0;
                notice(get_string('no_user_with_email','block_mrbs',$recip));
            } else {
                notice(get_string('no_user_with_email','block_mrbs',MAIL_FROM));
            }
        }
    }
    return $result;
}

// }}}
// {{{ getPreviousEntryData()

/**
 * Gather all fields values for an entry. Used for emails to get previous
 * entry state.
 *
 * @param int     $id       entry id to get data
 * @param int     $series   1 if this is a serie or 0
 * @return bool             TRUE or PEAR error object if fails
 */
function getPreviousEntryData($id, $series)
{
    global $tbl_area, $tbl_entry, $tbl_repeat, $tbl_room, $enable_periods;
    //
    $sql = "
    SELECT  e.name,
            e.description,
            e.create_by,
            r.room_name,
            a.area_name,
            e.type,
            e.room_id,
            e.repeat_id,
            e.timestamp,
            (e.end_time - e.start_time) AS tbl_e_duration,
            e.start_time AS tbl_e_start_time,
            e.end_time AS tbl_e_end_time,
            a.area_admin_email,
            r.room_admin_email";
    // Here we could just use $tbl_repeat.start_time, and not use alias,
    // as the last column will take precedence using mysql_fetch_array,
    // but for portability purpose I will not use it.
    if (1 == $series)
    {
        $sql .= ", re.rep_type, re.rep_opt, re.rep_num_weeks,
            (re.end_time - re.start_time) AS tbl_r_duration,
            re.start_time AS tbl_r_start_time,
            re.end_time AS tbl_r_end_time,
            re.end_date AS tbl_r_end_date";
    }
    $sql .= "
    FROM $tbl_entry e, $tbl_room r, $tbl_area a ";
    (1 == $series) ? $sql .= ', ' . $tbl_repeat . ' re ' : '';
    $sql .= "
    WHERE e.room_id = r.id
    AND r.area_id = a.id
    AND e.id=$id";
    (1 == $series) ? $sql .= " AND e.repeat_id = re.id" : '';
    //
    $res = sql_query($sql);
    (! $res) ? fatal_error(0, sql_error()) : '';
    (sql_count($res) < 1) ? fatal_error(0, get_string('invalid_entry_id','block_mrbs')) : '';
    $row = sql_row_keyed($res, 0);
    sql_free($res);
    // Store all needed values in $mail_previous array to pass to
    // notifyAdminOnDelete function (shorter than individual variables -:) )
    $mail_previous['namebooker']    = $row['name'];
    $mail_previous['description']   = $row['description'];
    $mail_previous['createdby']     = $row['create_by'];
    $mail_previous['room_name']     = $row['room_name'];
    $mail_previous['area_name']     = $row['area_name'];
    $mail_previous['type']          = $row['type'];
    $mail_previous['room_id']       = $row['room_id'];
    $mail_previous['repeat_id']     = $row['repeat_id'];
    $mail_previous['updated']       = getMailTimeDateString($row[8]);
    $mail_previous['area_admin_email'] = $row['area_admin_email'];
    $mail_previous['room_admin_email'] = $row['room_admin_email'];
    // If we use periods
    if ( $enable_periods )
    {
        // If we delete a serie, start_time and end_time must
        // come from $tbl_repeat, not $tbl_entry.
        //
        // This is not a serie
        if (1 != $series)
        {
            list( $mail_previous['start_period'], $mail_previous['start_date'])
                =  getMailPeriodDateString($row['tbl_e_start_time']);
            list( $mail_previous['end_period'] , $mail_previous['end_date']) =
                getMailPeriodDateString($row['tbl_e_end_time'], -1);
            // need to make DST correct in opposite direction to entry creation
            // so that user see what he expects to see
            $mail_previous['duration'] = $row['tbl_e_duration'] -
                cross_dst($row['tbl_e_start_time'], $row['tbl_e_end_time']);
        }
        // This is a serie
        else
        {
            list( $mail_previous['start_period'], $mail_previous['start_date'])
                =  getMailPeriodDateString($row['tbl_r_start_time']);
            list( $mail_previous['end_period'] , $mail_previous['end_date']) =
                getMailPeriodDateString($row['tbl_r_end_time'], 0);
            // use getMailTimeDateString as all I want is the date
        $mail_previous['rep_end_date'] =
                getMailTimeDateString($row['tbl_r_end_date'], FALSE);
            // need to make DST correct in opposite direction to entry creation
            // so that user see what he expects to see
            $mail_previous['duration'] = $row['tbl_r_duration'] -
                cross_dst($row['tbl_r_start_time'], $row['tbl_r_end_time']);

        $mail_previous['rep_opt'] = "";
        switch($row['rep_type'])
        {
        case 2:
        case 6:
            $rep_day[0] = $row['rep_opt'][0] != "0";
            $rep_day[1] = $row['rep_opt'][1] != "0";
            $rep_day[2] = $row['rep_opt'][2] != "0";
            $rep_day[3] = $row['rep_opt'][3] != "0";
            $rep_day[4] = $row['rep_opt'][4] != "0";
            $rep_day[5] = $row['rep_opt'][5] != "0";
            $rep_day[6] = $row['rep_opt'][6] != "0";

            if ($row['rep_type'] == 6)
            {
                $mail_previous['rep_num_weeks'] = $row['rep_num_weeks'];
            }
            else
            {
                $mail_previous['rep_num_weeks'] = "";
            }

            break;

        default:
            $rep_day = array(0, 0, 0, 0, 0, 0, 0);
        }
        for ($i = 0; $i < 7; $i++)
        {
        $wday = ($i + $weekstarts) % 7;
        if ($rep_day[$wday])
            $mail_previous['rep_opt'] .= day_name($wday) . " ";
        }

        $mail_previous['rep_num_weeks'] = $row['rep_num_weeks'];
        }
        toPeriodString($mail_previous['start_period'],
            $mail_previous['duration'], $mail_previous['dur_units']);
    }
    // If we don't use periods
    else
    {
        // This is not a serie
        if (1 != $series)
        {
            $mail_previous['start_date'] =
                getMailTimeDateString($row['tbl_e_start_time']);
            $mail_previous['end_date'] =
                getMailTimeDateString($row['tbl_e_end_time']);
            // need to make DST correct in opposite direction to entry creation
            // so that user see what he expects to see
            $mail_previous['duration'] = $row['tbl_e_duration'] -
                cross_dst($row['tbl_e_start_time'], $row['tbl_e_end_time']);
        }
        // This is a serie
        else
        {
            $mail_previous['start_date'] =
                getMailTimeDateString($row['tbl_r_start_time']);
            $mail_previous['end_date'] =
                getMailTimeDateString($row['tbl_r_end_time']);
            // use getMailTimeDateString as all I want is the date
        $mail_previous['rep_end_date'] =
                getMailTimeDateString($row['tbl_r_end_date'], FALSE);
            // need to make DST correct in opposite direction to entry creation
            // so that user see what he expects to see
            $mail_previous['duration'] = $row['tbl_r_duration'] -
                cross_dst($row['tbl_r_start_time'], $row['tbl_r_end_time']);

        $mail_previous['rep_opt'] = "";
        switch($row['rep_type'])
        {
        case 2:
        case 6:
            $rep_day[0] = $row['rep_opt'][0] != "0";
            $rep_day[1] = $row['rep_opt'][1] != "0";
            $rep_day[2] = $row['rep_opt'][2] != "0";
            $rep_day[3] = $row['rep_opt'][3] != "0";
            $rep_day[4] = $row['rep_opt'][4] != "0";
            $rep_day[5] = $row['rep_opt'][5] != "0";
            $rep_day[6] = $row['rep_opt'][6] != "0";

            if ($row['rep_type'] == 6)
            {
                $mail_previous['rep_num_weeks'] = $row['rep_num_weeks'];
            }
            else
            {
                $mail_previous['rep_num_weeks'] = "";
            }

            break;

        default:
            $rep_day = array(0, 0, 0, 0, 0, 0, 0);
        }
        for ($i = 0; $i < 7; $i++)
        {
        $wday = ($i + $weekstarts) % 7;
        if ($rep_day[$wday])
            $mail_previous['rep_opt'] .= day_name($wday) . " ";
        }

        $mail_previous['rep_num_weeks'] = $row['rep_num_weeks'];
        }
        toTimeString($mail_previous['duration'], $mail_previous['dur_units']);
    }
    (1 == $series) ? $mail_previous['rep_type'] = $row['rep_type']
        : $mail_previous['rep_type'] = 0;
    // return entry previous data as an array
    return $mail_previous;
}

// }}}
// {{{ compareEntries()

/**
 * Compare entries fields to show in emails.
 *
 * @param string  $new_value       new field value
 * @param string  $previous_value  previous field value
 * @return string                  new value if no difference, new value and
 *                                 previous value in brackets otherwise
 */
function compareEntries($new_value, $previous_value, $new_entry)
{
    $suffix = "";
    if ($new_entry)
    {
        return $new_value;
    }
    if ($new_value != $previous_value)
    {
        $suffix = " ($previous_value)";
    }
    return($new_value . $suffix);
}

function unHtmlEntities($string)
{
    $trans_tbl = get_html_translation_table(HTML_ENTITIES);
    $trans_tbl = array_flip($trans_tbl);
    return strtr($string, $trans_tbl);
}

function get_user_by_email ($email)
{
    if ($recipient_user=get_complete_user_data('email',$email)) {
        return $recipient_user;
    } else {
        return false;
    }
}
// }}}

/**
 * Convert a unix time to a human readable time. Gives period output if periods are enabled.
 *
 * @param int $time     Unix timestamp
 * @return string       Name of the period or time in Hours:Minutes format
 *
 */
function to_hr_time($time){
    $cfg_mrbs = get_config('block/mrbs');
    if ($cfg_mrbs->enable_periods){
        $periods=explode("\n",$cfg_mrbs->periods);
        $period=intval(date('i',$time));
        return trim($periods[$period]);
    }else{
        return date('G:i',$time);
    }
}

?>
