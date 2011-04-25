<?php
require_once("../../../config.php");
require_once "grab_globals.inc.php";
include "config.inc.php";
include "functions.php";
include "$dbsys.php";
include "mrbs_auth.php";
include "mrbs_sql.php";
require_login();
$room = optional_param('room', 0, PARAM_INT);
$day = optional_param('day', 0, PARAM_INT);
$month = optional_param('month', 0, PARAM_INT);
$year = optional_param('year', 0, PARAM_INT); 

#If we dont know the right date then make it up 
if (($day==0) or ($month==0) or ($year==0))
{
    $day   = date("d");
    $month = date("m");
    $year  = date("Y");
} else {
# Make the date valid if day is more then number of days in month
    while (!checkdate(intval($month), intval($day), intval($year)))
        $day--;
}

if(!getAuthorised(1))
{
    showAccessDenied($day, $month, $year, $area);
    exit;
}


//$sql = "SELECT area_id,area_name FROM mdl_mrbs_room JOIN mdl_mrbs_area ON mdl_mrbs_area.id = area_id WHERE room_name ='$room' OR room_name ='0$room'";
$sql = "SELECT area_id,area_name FROM {mrbs_room} AS r JOIN {mrbs_area} AS a ON a.id = r.area_id WHERE room_name = ? OR room_name ='?'";


    //$res = get_records_sql($sql);
    $res = $DB->get_records_sql($sql, array($room, '0'.$room));
if($res){
    foreach ($res as $roomfound){echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$CFG->wwwroot/blocks/mrbs/web/day.php?area=$roomfound->area_id&day=$day&month=$month&year=$year'>You should shortly be redirected to <a href='$CFG->wwwroot/blocks/mrbs/web/day.php?area=$roomfound->area_id&day=$day&month=$month&year=$year'>$roomfound->area_name</a>";}
}else{
    echo "Sorry, no rooms were found";
}




?>