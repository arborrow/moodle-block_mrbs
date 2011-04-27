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

/*
  Index is just a stub to redirect to the appropriate view
  as defined in config.inc.php using the variable $default_view
  If $default_room is defined in config.inc.php then this will
  be used to redirect to a particular room.
*/
require_once(dirname(dirname(dirname(__FILE__))).'/config.php'); //for Moodle integration
require_once "grab_globals.inc.php";
include("config.inc.php");
include("$dbsys.php");


$day   = date("d");
$month = date("m");
$year  = date("Y");

switch ($default_view)
{
	case "month":
        //UT
		$redirect = new moodle_url('/blocks/mrbs/month.php', array('year'=>$year, 'month'=>$month));
		break;
	case "week":
        //UT
		$redirect = new moodle_url('/blocks/mrbs/week.php', array('year'=>$year, 'month'=>$month, 'day'=>$day));
		break;
	default:
        //UT
        $redirect = new moodle_url('/blocks/mrbs/day.php', array('day'=>$day, 'month'=>$month, 'year'=>$year));
}

if (!empty($default_room)) {
    //UT
	$sql = "select area_id from $tbl_room where id=$default_room";
	$res = $DB->get_record('mrbs_room', 'area_id', array('id'=>$default_room));
	if (!empty($res)) {
        $redirect->params(array('area'=>$res->area_id, 'room'=>$default_room));
	}
}

redirect($redirect);
