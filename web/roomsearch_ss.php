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
include "mrbs_sql.php";

require_login();
$day = optional_param('day', 0, PARAM_INT);
$month = optional_param('month', 0, PARAM_INT);
$year = optional_param('year', 0, PARAM_INT);
$period = optional_param('period', 0, PARAM_INT);
$duration = optional_param('duration', 0, PARAM_INT);
$dur_units = optional_param('dur_units', 0, PARAM_TEXT);
$currentroom = optional_param('currentroom', 0,  PARAM_INT);
$mincap = optional_param('mincap', 0,  PARAM_INT);
$teaching = optional_param('teaching', false,  PARAM_BOOL);
$special = optional_param('special', false,  PARAM_BOOL);
$computer = optional_param('computer', false,  PARAM_BOOL);
$hour = optional_param('hour', null, PARAM_INT);
$minute = optional_param('minute', null, PARAM_INT);
$ampm = optional_param('ampm', null, PARAM_ALPHA);



        global $tbl_room;
        global $tbl_entry;
        global $tbl_area;

    // Support locales where ',' is used as the decimal point
    $duration = preg_replace('/,/', '.', $duration);

    if( $enable_periods ) {
        $resolution = 60;
        $hour = 12;
        $minute = $period;
            $max_periods = count($periods);
            if( $dur_units == "periods" && ($minute + $duration) > $max_periods )
            {
                $duration = (24*60*floor($duration/$max_periods)) + ($duration%$max_periods);
            }
            if( $dur_units == "days" && $minute == 0 )
            {
            $dur_units = "periods";
                    $duration = $max_periods + ($duration-1)*60*24;
            }
        }

    // Units start in seconds
    $units = 1.0;

    switch($dur_units)
    {
        case "years":
            $units *= 52;
        case "weeks":
            $units *= 7;
        case "days":
            $units *= 24;
        case "hours":
            $units *= 60;
        case "periods":
        case "minutes":
            $units *= 60;
        case "seconds":
            break;
    }

    // Units are now in "$dur_units" numbers of seconds


    if(isset($all_day) && ($all_day == "yes"))
    {
        if( $enable_periods )
        {
            $starttime = mktime(12, 0, 0, $month, $day, $year);
            $endtime   = mktime(12, $max_periods, 0, $month, $day, $year);
        }
        else
        {
            $starttime = mktime($morningstarts, 0, 0, $month, $day  , $year, is_dst($month, $day  , $year));
            $end_minutes = $eveningends_minutes + $morningstarts_minutes;
            ($eveningends_minutes > 59) ? $end_minutes += 60 : '';
            $endtime   = mktime($eveningends, $end_minutes, 0, $month, $day, $year, is_dst($month, $day, $year));
        }
    }
    else
    {
        if (!$twentyfourhour_format)
        {
          if (isset($ampm) && ($ampm == "pm") && ($hour<12))
          {
            $hour += 12;
          }
          if (isset($ampm) && ($ampm == "am") && ($hour>11))
          {
            $hour -= 12;
          }
        }

        $starttime = mktime($hour, $minute, 0, $month, $day, $year, is_dst($month, $day, $year, $hour));
        $endtime   = mktime($hour, $minute, 0, $month, $day, $year, is_dst($month, $day, $year, $hour)) + ($units * $duration);
        // Round up the duration to the next whole resolution unit.
        // If they asked for 0 minutes, push that up to 1 resolution unit.
        $diff = $endtime - $starttime;
        if (($tmp = $diff % $resolution) != 0 || $diff == 0)
            $endtime += $resolution - $tmp;

        $endtime += cross_dst( $starttime, $endtime );
    }

$sql = "SELECT r.id, r.room_name, r.description, r.capacity, a.area_name, r.area_id";
$sql .= " FROM {block_mrbs_room} r JOIN {block_mrbs_area} a on r.area_id=a.id WHERE ( SELECT COUNT(*) FROM {block_mrbs_entry} e ";

//old booking fully inside new booking
$sql .= "WHERE ((e.start_time>= ? AND e.end_time< ? ) ";
//new start time within old booking
$sql .= "OR (e.start_time< ? AND e.end_time> ?) ";
//new end time within old booking
$sql .= "OR (e.start_time< ? AND e.end_time>= ?)) ";

$sql .= "AND e.room_id = r.id ) < 1  AND r.capacity >= ? ";

$params = array($starttime, $endtime, $starttime, $starttime, $endtime, $endtime, $mincap);



if($computer) {
    $sql.= " AND ".$DB->sql_like('r.description', '?', false);
    $params[] = 'Teaching IT%';
}
if($teaching) {
    $sql.= " AND ".$DB->sql_like('r.description', '?', false);
    $params[] = 'Teaching%';
}
if($special) {
    $sql.= " AND ".$DB->sql_like('r.description', '?', false, false, true);
    $params[] = 'Teaching Specialist%';
}

$sql .= " ORDER BY a.area_name, r.room_name";

$rooms = $DB->get_records_sql($sql, $params);
if(!empty($rooms)) {
    $list='';
    foreach ($rooms as $room){
        $list.=$room->area_name.',<a href="javascript:openURL(\'edit_entry.php?room='.$room->id.'&period='.$period.'&year='.$year.'&month='.$month.'&day='.$day.'&duration='.$diff.'\')">'.$room->room_name.'</a>,'.$room->description.','.$room->capacity."\n";
    }
    //remove last \n to prevent blank row in table
    echo substr($list, 0, -1);
}
