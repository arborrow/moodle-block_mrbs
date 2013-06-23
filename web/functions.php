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
// probably a bad place to put this, but for error reporting purposes
// $pview must be defined. if it's not then there's errors generated all
// over the place. so we test to see if it is set, and if not then set
// it.
require_once('mrbs_auth.php');

$pview = optional_param('pview', 0, PARAM_INT);

function print_user_header_mrbs($day=NULL, $month=NULL, $year=NULL, $area=NULL) {
    print_header_mrbs($day, $month, $year, $area, true);
}

function print_header_mrbs($day=NULL, $month=NULL, $year=NULL, $area=NULL, $userview = false) //if values are not passed assume NULL
{
    global $mrbs_company, $mrbs_company_url, $search_str, $locale_warning, $pview;
    global $OUTPUT, $PAGE, $USER;
    global $javascript_cursor;
    global $CFG;

    $cfg_mrbs = get_config('block/mrbs');
    $strmrbs = get_string('blockname','block_mrbs');

    if(!$site = get_site()) {
        redirect(new moodle_url('/admin/index.php'));
    }

    if ($CFG->version < 2011120100) {
        $context = get_context_instance(CONTEXT_SYSTEM);
    } else {
        $context = context_system::instance();
    }
    require_capability('block/mrbs:viewmrbs', $context);

    // If we dont know the right date then make it up
    if(!$day) {
        $day   = date("d");
    }
    if(!$month) {
        $month = date("m");
    }
    if(!$year) {
        $year  = date("Y");
    }
    if (empty($search_str)) {
            $search_str = "";
    }

    if ($CFG->version < 2011120100) {
        $context = get_context_instance(CONTEXT_SYSTEM);
    } else {
        $context = context_system::instance();
    }

    /// Print the header
    $PAGE->set_context($context);
    $PAGE->navbar->add($strmrbs);
    $PAGE->set_pagelayout('incourse');
    $PAGE->set_title($strmrbs);
    $PAGE->set_heading(format_string($strmrbs));

    // Load extra javascript
    $PAGE->requires->js('/blocks/mrbs/web/roomsearch.js', true); // For the 'ChangeOptionDays' function
    if ($javascript_cursor) {
        $PAGE->requires->js('/blocks/mrbs/web/xbLib.js', true);
    }

    echo $OUTPUT->header();

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

    echo '<div id="mrbscontainer">';

    if ( $pview != 1 ) {
        if (!empty($locale_warning)) {
               echo "[Warning: ".$locale_warning."]";
        }

        $titlestr = get_string('mrbs', 'block_mrbs');
        $homeurl = new moodle_url('/blocks/mrbs/web/index.php');

        $gotostr = get_string('goto', 'block_mrbs');
        $gotourl = new moodle_url('/blocks/mrbs/web/day.php');
        if ($userview) {
            $gotourl = new moodle_url('/blocks/mrbs/web/userweek.php');
        }

        $roomsearchstr = get_string('roomsearch', 'block_mrbs');
        $roomsearchurl = new moodle_url('/blocks/mrbs/web/roomsearch.php');

        $helpstr = get_string('help');
        $helpurl = new moodle_url('/blocks/mrbs/web/help.php', array('day'=>$day, 'month'=>$month, 'year'=>$year));

        $adminstr = get_string('admin');
        $adminurl = new moodle_url('/blocks/mrbs/web/admin.php', array('day'=>$day, 'month'=>$month, 'year'=>$year));

        $reportstr = get_string('report');
        $reporturl = new moodle_url('/blocks/mrbs/web/report.php');

        $searchstr = get_string('search');
        $searchurl = new moodle_url('/blocks/mrbs/web/search.php');
        $searchadvurl = new moodle_url($searchurl, array('advanced'=>1));

        $level = authGetUserLevel($USER->id);
        $canadmin = $level >= 2;

        echo <<<HTML1END

    <TABLE WIDTH="100%" class="banner" >
      <TR>
        <TD BGCOLOR="#5B69A6">
          <TABLE WIDTH="100%" BORDER=0>
            <TR>
              <TD CLASS="banner" BGCOLOR="#C0E0FF">
          <FONT SIZE=4>
           <A HREF="$homeurl">$titlestr</A>
                </FONT>
              </TD>
              <TD CLASS="banner" BGCOLOR="#C0E0FF">
                <FORM ACTION="$gotourl" METHOD=GET name="Form1">
                  <FONT SIZE=2>
HTML1END;

        genDateSelector("", $day, $month, $year); // Note: The 1st arg must match the last arg in the call to ChangeOptionDays below.
        if (!empty($area)) {
            echo "<INPUT TYPE=HIDDEN NAME=area VALUE=$area>\n";
        }

        echo <<<HTML2END
                <SCRIPT LANGUAGE="JavaScript">
                    <!--
                    // fix number of days for the $month/$year that you start with
                    ChangeOptionDays(document.Form1, ''); // Note: The 2nd arg must match the first in the call to genDateSelector above.
                    // -->
                    </SCRIPT>
	    <INPUT TYPE=SUBMIT VALUE="$gotostr">
                  </FONT>
                </FORM>
              </TD>
HTML2END;
        if (!$userview) {
            if (has_capability("block/mrbs:forcebook", $context)) {
                echo'<TD CLASS="banner" BGCOLOR="#C0E0FF" ALIGN=CENTER>
                  <a href="edit_entry.php?force=TRUE">'.get_string('forciblybook', 'block_mrbs').'</a>
              </TD>';
            }

            echo '<TD CLASS="banner" BGCOLOR="#C0E0FF" ALIGN=CENTER>';
            echo '<a target="popup" title="'.$roomsearchstr.'" href="'.$roomsearchurl.'" ';
            echo 'onclick="this.target=\'popup\'; return openpopup(\''.$roomsearchurl.'\', \'popup\', \'toolbar=1,location=0,scrollbars,resizable,width=500,height=400\', 0);">';
            echo $roomsearchstr.'</a></TD>';

        } // !$userview

        echo '<TD CLASS="banner" BGCOLOR="#C0E0FF" ALIGN=CENTER><A HREF="'.$helpurl.'">'.$helpstr.'</A></TD>';

        if (!$userview) {
            if ($canadmin) {
                echo '<TD CLASS="banner" BGCOLOR="#C0E0FF" ALIGN=CENTER><A HREF="'.$adminurl.'">'.$adminstr.'</A></TD>';
            }
            echo '<TD CLASS="banner" BGCOLOR="#C0E0FF" ALIGN=CENTER><A HREF="'.$reporturl.'">'.$reportstr.'</A></TD>';
            echo '<TD CLASS="banner" BGCOLOR="#C0E0FF" ALIGN=CENTER><FORM METHOD=GET ACTION="'.$searchurl.'">';
            echo '<FONT SIZE=2><A HREF="'.$searchadvurl.'">'.$searchstr.'</A></FONT>
                  <INPUT TYPE=TEXT   NAME="search_str" VALUE="'.$search_str.'" SIZE=10>
                  <INPUT TYPE=HIDDEN NAME=day        VALUE="'.$day.'"        >
                  <INPUT TYPE=HIDDEN NAME=month      VALUE="'.$month.'"        >
                  <INPUT TYPE=HIDDEN NAME=year       VALUE="'.$year.'"        >';
            if (!empty($area)) {
                echo "<INPUT TYPE=HIDDEN NAME=area VALUE=$area>\n";
            }
            echo '</FORM></TD>';
        } // !$userview

        echo '</TR> </TABLE> </TD> </TR> </TABLE>';
    }
}

function toTimeString(&$dur, &$units) {
	if($dur >= 60) {
		$dur /= 60;

		if($dur >= 60) {
			$dur /= 60;

			if(($dur >= 24) && ($dur % 24 == 0)) {
				$dur /= 24;

				if(($dur >= 7) && ($dur % 7 == 0)) {
					$dur /= 7;

					if(($dur >= 52) && ($dur % 52 == 0)) {
						$dur  /= 52;
						$units = get_string('years');
					} else {
						$units = get_string('weeks','block_mrbs');
                    }
				} else {
					$units = get_string('days');
                }
			} else {
				$units = get_string('hours','block_mrbs');
            }
		} else {
			$units = get_string('minutes');
        }
	} else {
		$units = get_string('secs');
    }
}


function toPeriodString($start_period, &$dur, &$units) {
	global $enable_periods;
    global $periods;

    $max_periods = count($periods);

	$dur /= 60;

    if( $dur >= $max_periods || $start_period == 0 ) {
        if( $start_period == 0 && $dur == $max_periods ) {
            $units = get_string('days');
            $dur = 1;
            return;
        }

        $dur /= 60;
        if(($dur >= 24) && is_int($dur)) {
            $dur /= 24;
			$units = get_string('days');
            return;
        } else {
			$dur *= 60;
            $dur = ($dur % $max_periods) + floor( $dur/(24*60) ) * $max_periods;
            $units = get_string('periods','block_mrbs');
            return;
        }
    } else {
		$units = get_string('periods','block_mrbs');
    }
}

function genDateSelector($prefix, $day, $month, $year, $updatefreerooms=false, $roomsearch=false) {
	if($day   == 0) $day = date("d");
	if($month == 0) $month = date("m");
	if($year  == 0) $year = date("Y");

	echo "
                  <SELECT NAME=\"${prefix}day\" ";
    if($updatefreerooms){echo"onChange=\"updateFreeRooms()\"";}
    if($roomsearch){echo"onChange=\"RoomSearch()\"";}
    echo">";

	for($i = 1; $i <= 31; $i++) {
		echo "
                    <OPTION " . ($i == $day ? " SELECTED" : "") . ">$i</OPTION>";
    }

	echo "
                  </SELECT>

                  <SELECT NAME=\"${prefix}month\" onchange=\"ChangeOptionDays(this.form,'$prefix'";
    if($updatefreerooms){echo",true";}
    if($roomsearch){echo",false,true";}
    echo")\">";

	for($i = 1; $i <= 12; $i++) {
		$m = userdate(mktime(0, 0, 0, $i, 1, $year)+date('Z', mktime(0,0,0,$i,1,$year)),'%b','0');

		print "
                    <OPTION VALUE=\"$i\"" . ($i == $month ? " SELECTED" : "") . ">$m";
	}

	echo "
                  </SELECT>
              <SELECT NAME=\"${prefix}year\" onchange=\"ChangeOptionDays(this.form,'$prefix'";
    if($updatefreerooms){echo",true";}
    if($roomsearch){echo",false,true";} echo")\">";

	$min = min($year, date("Y")) - 5;
	$max = max($year, date("Y")) + 5;

	for($i = $min; $i <= $max; $i++)
		print "
                    <OPTION VALUE=\"$i\"" . ($i == $year ? " SELECTED" : "") . ">$i";

	echo "
                  </SELECT>";
}

// Error handler - this is used to display serious errors such as database
// errors without sending incomplete HTML pages. This is only used for
// errors which "should never happen", not those caused by bad inputs.
// If $need_header!=0 output the top of the page too, else assume the
// caller did that. Alway outputs the bottom of the page and exits.
function fatal_error($need_header, $message) {
	if ($need_header) print_header_mrbs(0, 0, 0, 0);
	echo $message;
	include "trailer.php";
	exit;
}

/* // These should not be needed in Moodle 2.0

// Apply backslash-escape quoting unless PHP is configured to do it
// automatically. Use this for GET/POST form parameters, since we
// cannot predict if the PHP configuration file has magic_quotes_gpc on.
function slashes($s) {
	if (get_magic_quotes_gpc()) return $s;
	else return addslashes($s);
}

// Remove backslash-escape quoting if PHP is configured to do it with
// magic_quotes_gpc. Use this whenever you need the actual value of a GET/POST
// form parameter (which might have special characters) regardless of PHP's
// magic_quotes_gpc setting.
function unslashes($s) {
	if (get_magic_quotes_gpc()) return stripslashes($s);
	else return $s;
}

*/

// Return a default area; used if no area is already known. This returns the
// lowest area ID in the database (no guaranty there is an area 1).
// This could be changed to implement something like per-user defaults.
function get_default_area()
{
	global $DB;

    // Get first area in database
    $area = $DB->get_records('block_mrbs_area', null, 'area_name', 'id', 0, 1);
    if (empty($area)) {
        return 0;
    }
    // Extract the first (and only!) item in the returned array
    $area = reset($area);
    return $area->id;
}

// Return a default room given a valid area; used if no room is already known.
// This returns the first room in alphbetic order in the database.
// This could be changed to implement something like per-user defaults.
function get_default_room($area)
{
    global $DB;

    // Get first room in database
    $room = $DB->get_records('block_mrbs_room', array('area_id'=>$area), 'room_name', 'id', 0, 1);
    if (empty($room)) {
        return 0;
    }
    // Extract the first (and only!) item in the returned array
    $room = reset($room);
    return $room->id;
}

// Get the local day name based on language. Note 2000-01-02 is a Sunday.
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
	// I have made the separater a ',' as a '-' leads to an ambiguious
	// display in report.php when showing end times.
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

// Output a start table cell tag <td> with color class and fallback color.
// $colclass is an entry type (A-J), "white" for empty, or "red" for highlighted.
// The colors for CSS browsers can be found in the style sheet. The colors
// in the array below are fallback for non-CSS browsers only.
function tdcell($colclass)
{
	// This should be 'static $ecolors = array(...)' but that crashes PHP3.0.12!
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

// Display the entry-type color key. This has up to 2 rows, up to 5 columns.
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

// Round time down to the nearest resolution
function round_t_down($t, $resolution, $am7)
{
        return (int)$t - (int)abs(((int)$t-(int)$am7)
				  % $resolution);
}

// Round time up to the nearest resolution
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

// generates some html that can be used to select which area should be
// displayed.
function make_area_select_html( $link, $current, $year, $month, $day )
{
    global $DB;

	$out_html = "
<form name=\"areaChangeForm\" method=get action=\"$link\">
  <select name=\"area\" onChange=\"document.areaChangeForm.submit()\">";

    $areas = $DB->get_records('block_mrbs_area', null, 'area_name');
    foreach ($areas as $area) {
		$selected = ($area->id == $current) ? "selected" : "";
		$out_html .= "
    <option $selected value=\"".$area->id."\">" . s($area->area_name);
   	}
	$out_html .= "
  </select>

  <INPUT TYPE=HIDDEN NAME=day        VALUE=\"$day\">
  <INPUT TYPE=HIDDEN NAME=month      VALUE=\"$month\">
  <INPUT TYPE=HIDDEN NAME=year       VALUE=\"$year\">
  <noscript><input type=submit value=\"".get_string('savechanges')."\"></noscript>
</form>\n";

	return $out_html;
} // end make_area_select_html

function make_room_select_html( $link, $area, $current, $year, $month, $day )
{
    global $DB;

	$out_html = "
<form name=\"roomChangeForm\" method=get action=\"$link\">
  <select name=\"room\" onChange=\"document.roomChangeForm.submit()\">";

    $rooms = $DB->get_records('block_mrbs_room', array('area_id'=>$area), 'room_name');
    foreach ($rooms as $room) {
		$selected = ($room->id == $current) ? "selected" : "";
		$out_html .= "
    <option $selected value=\"".$room->id."\">" . s($room->room_name);
   	}
	$out_html .= "
  </select>
  <INPUT TYPE=HIDDEN NAME=day        VALUE=\"$day\"        >
  <INPUT TYPE=HIDDEN NAME=month      VALUE=\"$month\"        >
  <INPUT TYPE=HIDDEN NAME=year       VALUE=\"$year\"      >
  <INPUT TYPE=HIDDEN NAME=area       VALUE=\"$area\"         >
  <noscript><input type=submit value=\"".get_string('savechanges')."\"></noscript>
</form>\n";

	return $out_html;
} // end make_area_select_html


// This will return the appropriate value for isdst for mktime().
// The order of the arguments was chosen to match those of mktime.
// hour is added so that this function can when necessary only be
// run if the time is between midnight and 3am (all DST changes
// occur in this period.
function is_dst ( $month, $day, $year, $hour="-1" )
{

	if( $hour != -1  && $hour > 3)
		return( -1 );

	// entering DST
	if( !date( "I", mktime(12, 0, 0, $month, $day-1, $year)) &&
	    date( "I", mktime(12, 0, 0, $month, $day, $year)))
		return( 0 );

	// leaving DST
	elseif( date( "I", mktime(12, 0, 0, $month, $day-1, $year)) &&
	    !date( "I", mktime(12, 0, 0, $month, $day, $year)))
		return( 1 );
	else
		return( -1 );
}

// if crossing dst determine if you need to make a modification
// of 3600 seconds (1 hour) in either direction
function cross_dst ( $start, $end )
{

	// entering DST
	if( !date( "I", $start) &&  date( "I", $end))
		$modification = -3600;

	// leaving DST
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
 * @param int     $modified_enddate   if set, represents the actual end date of the repeat booking (after restrictions)
 * @return bool                 TRUE or PEAR error object if fails
 */
function notifyAdminOnBooking($new_entry , $new_id, $modified_enddate = null) {
    global $DB;
    global $url_base, $returl, $name, $description, $area_name;
    global $room_name, $starttime, $duration, $dur_units, $end_date, $endtime;
    global $rep_enddate, $typel, $type, $create_by, $rep_type, $enable_periods;
    global $rep_opt, $rep_num_weeks;
    global $mail_previous, $auth, $weekstarts;

    //
    // $recipients = '';
    $id_table = ($rep_type > 0) ? "rep" : "e";
    (MAIL_ADMIN_ON_BOOKINGS) ? $recipientlist[] = MAIL_RECIPIENTS : '';
    if (MAIL_AREA_ADMIN_ON_BOOKINGS) {
        // Look for list of area admins emails addresses
        if ($new_entry) {
            $sql = "SELECT a.area_admin_email ";
            $sql .= "FROM {block_mrbs_room} r, {block_mrbs_area} a, {block_mrbs_entry} e ";
            // If this is a repeating entry...
            if ($id_table == 'rep') {
                // ...use the repeat table
                $sql .= ", {block_mrbs_repeat} rep ";
            }
            $sql .= "WHERE ${id_table}.id=? AND r.id=${id_table}.room_id AND a.id=r.area_id";
            $emails = $DB->get_records_sql($sql, array($new_id), 0, 1);
            if (!empty($emails)) {
                $email = reset($emails);
                if ($email->area_admin_email != NULL) {
                    $recipientlist[] = $email->area_admin_email;
                }
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
            $sql .= "FROM {block_mrbs_room} r, {block_mrbs_entry} e ";
            // If this is a repeating entry...
            if ($id_table == 'rep') {
                // ...use the repeat table
                $sql .= ", {block_mrbs_repeat} rep ";
            }
            $sql .= "WHERE ${id_table}.id= ? AND r.id=${id_table}.room_id";
            $emails = $DB->get_records_sql($sql, array($new_id), 0, 1);

            if (!empty($emails)) {
                $email = reset($emails);
                if ($email->room_admin_email != NULL) {
                    $recipientlist[] = $email->room_admin_email;
                }
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

            $uname = ($new_entry) ? $create_by : $mail_previous['createdby'];
            $email = $DB->get_field('user', 'email', array('username'=>$uname));
            if ($email) {
                $recipientlist[] = $email;
            }
        } else { //Moodle should always look up the code so this should never execute especially since MAIL_USERNAME_SUFFIX and MAIL_DOMAIN are not defined
            if ($new_entry) {
                if ('' != $create_by) {
                    $recipientlist[] = str_replace(MAIL_USERNAME_SUFFIX, '', $create_by) . MAIL_DOMAIN;
                }
            } else {
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
    $subjdetails = new stdClass;
    if ($enable_periods) {
        list($startperiodstr, $startdatestr) = getMailPeriodDateString($starttime);
        $subjdetails->date = $startdatestr;
    } else {
        $subjdetails->date = getMailTimeDateString($starttime);
    }
    $subjdetails->user = $create_by;
    $subjdetails->room = $room_name;
    $subjdetails->entry_type = $typel[$type];
    if ($new_entry) {
        $subject = get_string('mail_subject_newentry', 'block_mrbs', $subjdetails);
    } else {
        $subject = get_string('mail_subject_entry', 'block_mrbs', $subjdetails);
    }
    $subject = str_replace('&nbsp;', ' ', $subject);

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
        // Display day names according to language and preferred weekday start.
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
                if ($modified_enddate != null) {
                    $body .= ": " . userdate($modified_enddate, '%A %d %B %Y');
                } else {
                $body .= ": " . userdate($rep_enddate, '%A %d %B %Y');
            }
            }
            else
            {
                if ($modified_enddate != null) {
                    $temp = userdate($modified_enddate, '%A %d %B %Y');
                } else {
                $temp = userdate($rep_enddate, '%A %d %B %Y');
                }
                $body .=  ": " .
                    compareEntries($temp, $mail_previous['rep_end_date'], $new_entry) . "\n";
            }
        }
    $body .= "\n";
    }

    $recipientlist = array_unique($recipientlist);

    $result=1;
    if (!$fromuser=get_user_by_email(MAIL_FROM)) {
        $result=0;
    }
    foreach ($recipientlist as $recip) {
        $recipuser = get_user_by_email($recip);

        if (($recipuser) && ($result)) {
            $result = email_to_user($recipuser, $fromuser, $subject, $body);
            if (!$result) {
                notice(get_string('email_failed', 'block_mrbs'));
            }
        } else {
            if (!$recipuser) {
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
    global $typel, $enable_periods, $auth, $DB;

    $recipientlist = array();
    (MAIL_ADMIN_ON_BOOKINGS) ? $recipientlist[] = MAIL_RECIPIENTS : '';
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
        /* It would be possible to move this query within the query in
           getPreviousEntryData to have all in one central place and to
           reduce database hits by one. However this is a bad idea. If a
           user is deleted from your user database, this will prevent all
           mails to admins when this user previously booked entries will
           be changed, as no user name will match the booker name */

        $uname = $mail_previous['createdby'];
        $email = $DB->get_field('user', 'email', array('username'=>$uname));
        if ($email) {
            $recipientlist[] = $email;
        }
    }
    // In case mail is allowed but someone forgot to supply email addresses...
    if (sizeof($recipientlist)==0) {
        return FALSE;
    }
    //

    $subjdetails = new stdClass;
    $subjdetails->date = unHtmlEntities($mail_previous['start_date']);
    $subjdetails->user = $mail_previous['createdby'];
    $subjdetails->room = $mail_previous['room_name'];
    $subjdetails->entry_type = $typel[$mail_previous['type']];

    $subject = get_string('mail_subject_delete','block_mrbs', $subjdetails);
    $subject = str_replace('&nbsp;', ' ', $subject);
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

    $recipientlist = array_unique($recipientlist);

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
    global $DB, $enable_periods, $weekstarts;
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
    FROM {block_mrbs_entry} e, {block_mrbs_room} r, {block_mrbs_area} a ";
    (1 == $series) ? $sql .= ', ' . '{block_mrbs_repeat} re ' : '';
    $sql .= "
    WHERE e.room_id = r.id
    AND r.area_id = a.id
    AND e.id= ? ";
    (1 == $series) ? $sql .= " AND e.repeat_id = re.id" : '';
    //
    $details = $DB->get_record_sql($sql, array($id), MUST_EXIST);
    // Store all needed values in $mail_previous array to pass to
    // notifyAdminOnDelete function (shorter than individual variables -:) )
    $mail_previous['namebooker']    = $details->name;
    $mail_previous['description']   = $details->description;
    $mail_previous['createdby']     = $details->create_by;
    $mail_previous['room_name']     = $details->room_name;
    $mail_previous['area_name']     = $details->area_name;
    $mail_previous['type']          = $details->type;
    $mail_previous['room_id']       = $details->room_id;
    $mail_previous['repeat_id']     = $details->repeat_id;
    $mail_previous['updated']       = getMailTimeDateString($details->timestamp);
    $mail_previous['area_admin_email'] = $details->area_admin_email;
    $mail_previous['room_admin_email'] = $details->room_admin_email;
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
                =  getMailPeriodDateString($details->tbl_e_start_time);
            list( $mail_previous['end_period'] , $mail_previous['end_date']) =
                getMailPeriodDateString($details->tbl_e_end_time, -1);
            // need to make DST correct in opposite direction to entry creation
            // so that user see what he expects to see
            $mail_previous['duration'] = $details->tbl_e_duration -
                cross_dst($details->tbl_e_start_time, $details->tbl_e_end_time);
        }
        // This is a serie
        else
        {
            list( $mail_previous['start_period'], $mail_previous['start_date'])
                =  getMailPeriodDateString($details->tbl_r_start_time);
            list( $mail_previous['end_period'] , $mail_previous['end_date']) =
                getMailPeriodDateString($details->tbl_r_end_time, 0);
            // use getMailTimeDateString as all I want is the date
        $mail_previous['rep_end_date'] =
                getMailTimeDateString($details->tbl_r_end_date, FALSE);
            // need to make DST correct in opposite direction to entry creation
            // so that user see what he expects to see
            $mail_previous['duration'] = $details->tbl_r_duration -
                cross_dst($details->tbl_r_start_time, $details->tbl_r_end_time);

        $mail_previous['rep_opt'] = "";
        switch($details->rep_type)
        {
        case 2:
        case 6:
            $rep_day[0] = $details->rep_opt[0] != "0";
            $rep_day[1] = $details->rep_opt[1] != "0";
            $rep_day[2] = $details->rep_opt[2] != "0";
            $rep_day[3] = $details->rep_opt[3] != "0";
            $rep_day[4] = $details->rep_opt[4] != "0";
            $rep_day[5] = $details->rep_opt[5] != "0";
            $rep_day[6] = $details->rep_opt[6] != "0";

            if ($details->rep_type == 6)
            {
                $mail_previous['rep_num_weeks'] = $details->rep_num_weeks;
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

        $mail_previous['rep_num_weeks'] = $details->rep_num_weeks;
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
                getMailTimeDateString($details->tbl_e_start_time);
            $mail_previous['end_date'] =
                getMailTimeDateString($details->tbl_e_end_time);
            // need to make DST correct in opposite direction to entry creation
            // so that user see what he expects to see
            $mail_previous['duration'] = $details->tbl_e_duration -
                cross_dst($details->tbl_e_start_time, $details->tbl_e_end_time);
        }
        // This is a serie
        else
        {
            $mail_previous['start_date'] =
                getMailTimeDateString($details->tbl_r_start_time);
            $mail_previous['end_date'] =
                getMailTimeDateString($details->tbl_r_end_time);
            // use getMailTimeDateString as all I want is the date
        $mail_previous['rep_end_date'] =
                getMailTimeDateString($details->tbl_r_end_date, FALSE);
            // need to make DST correct in opposite direction to entry creation
            // so that user see what he expects to see
            $mail_previous['duration'] = $details->tbl_r_duration -
                cross_dst($details->tbl_r_start_time, $details->tbl_r_end_time);

        $mail_previous['rep_opt'] = "";
        switch($details->rep_type)
        {
        case 2:
        case 6:
            $rep_day[0] = $details->rep_opt[0] != "0";
            $rep_day[1] = $details->rep_opt[1] != "0";
            $rep_day[2] = $details->rep_opt[2] != "0";
            $rep_day[3] = $details->rep_opt[3] != "0";
            $rep_day[4] = $details->rep_opt[4] != "0";
            $rep_day[5] = $details->rep_opt[5] != "0";
            $rep_day[6] = $details->rep_opt[6] != "0";

            if ($details->rep_type == 6)
            {
                $mail_previous['rep_num_weeks'] = $details->rep_num_weeks;
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

        $mail_previous['rep_num_weeks'] = $details->rep_num_weeks;
        }
        toTimeString($mail_previous['duration'], $mail_previous['dur_units']);
    }
    (1 == $series) ? $mail_previous['rep_type'] = $details->rep_type
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

function check_max_advance_days_internal(DateTime $checkdate) {
    global $max_advance_days;


    if ($max_advance_days < 0) {
        return true;
    }

    $syscontext = context_system::instance();
    if (has_capability('block/mrbs:ignoremaxadvancedays', $syscontext)) {
        return true;
    }


        $now = new DateTime();
    if ($checkdate < $now) {
        return true;
    }
    $interval = intval($checkdate->format('U')) - intval($now->format('U'));
    $interval = intval($interval / (24*60*60));
    if ($interval > $max_advance_days) {
        return false;
    }

    return true;
}

function check_max_advance_days_timestamp($ts) {
    $tsdate = new DateTime();
    $tsdate->setTimestamp($ts);
    $checkdate = new DateTime();
    $checkdate->setDate($tsdate->format('Y'), $tsdate->format('m'), $tsdate->format('d'));
    return check_max_advance_days_internal($checkdate);
}

function check_max_advance_days($day, $month, $year) {
    $checkdate = new DateTime();
    $checkdate->setDate($year, $month, $day);
    return check_max_advance_days_internal($checkdate);
}
function allowed_to_book($user, $room) {
    if (empty($room->booking_users)) {
        return true;
    }

    $booking_users = explode(',', $room->booking_users);
    foreach ($booking_users as $email) {
        if ($user->email == $email) {
            return true;
        }
    }

    return false;
}