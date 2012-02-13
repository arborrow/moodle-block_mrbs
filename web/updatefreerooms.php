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

require_login();
$day = optional_param('day', 0, PARAM_INT);
$month = optional_param('month', 0, PARAM_INT);
$year = optional_param('year', 0, PARAM_INT);
$period = optional_param('period', 0, PARAM_INT);
$duration = optional_param('duration', 0, PARAM_INT);
$dur_units = optional_param('dur_units', 0, PARAM_TEXT);
$area = optional_param('area', 0,  PARAM_INT);
$currentroom = optional_param('currentroom', 0,  PARAM_INT);

if (!$area) {
    $area = get_default_area();
}

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


$sql = 'SELECT r.id, r.room_name, r.description, r.capacity, a.area_name, r.area_id, r.booking_users ';
$sql .= 'FROM {block_mrbs_room} r JOIN {block_mrbs_area} a on r.area_id=a.id WHERE ';

$params = array();

if(!empty($day)){
    $sql.= "(( SELECT COUNT(*) FROM {block_mrbs_entry} e ";

    //old booking fully inside new booking
    $sql .= "WHERE ((e.start_time>=:starttime1 AND e.end_time<:endtime1) ";
    //new start time within old booking
    $sql .= "OR (e.start_time<:starttime2 AND e.end_time>:starttime3) ";
    //new end time within old booking
    $sql .= "OR (e.start_time<:endtime2 AND e.end_time>=:endtime3)) ";

    $sql .= "AND e.room_id = r.id ) < 1 OR r.id= :currentroom) AND ";

    $params = array('starttime1'=>$starttime, 'starttime2'=>$starttime, 'starttime3'=>$starttime,
                    'endtime1'=>$endtime, 'endtime2'=>$endtime, 'endtime3'=>$endtime,
                    'currentroom'=>$currentroom);

}

if($area=='IT'){
    $sql.='description LIKE \'Teaching IT%\' ';
}else{
    $sql.='r.area_id=:area ';
    $params['area'] = $area;
}

$sql .= " ORDER BY room_name";

$rooms = $DB->get_records_sql($sql, $params);


if(!empty($rooms)) {
    $list='';
    foreach ($rooms as $room){
        if (allowed_to_book($USER, $room)) {
            $list.= $room->id.','.$room->room_name.' ('.$room->description.' Capacity:'.$room->capacity.')'."\n";
        }
    }
    echo $list;
}

