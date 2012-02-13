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
require "config.inc.php";
require "functions.php";
require_once("mrbs_auth.php");

$day=optional_param('day',0 ,PARAM_INT);
$month=optional_param('month', 0 ,PARAM_INT);
$year=optional_param('year', 0, PARAM_INT);
$area = optional_param('area', 0, PARAM_INT);
$area_name = optional_param('area_name', '', PARAM_TEXT);

//If we dont know the right date then make it up
if (($day==0) or ($month==0) or ($year==0)) {
    $day   = date("d");
    $month = date("m");
    $year  = date("Y");
}

$thisurl = new moodle_url('/blocks/mrbs/web/admin.php', array('day'=>$day, 'month'=>$month, 'year'=>$year));
if ($area) {
    $thisurl->param('area', $area);
} else {
    $area = get_default_area();
}

$PAGE->set_url($thisurl);
require_login();

if (!getAuthorised(2)) {
    showAccessDenied($day, $month, $year, $area);
    exit();
}

print_header_mrbs($day, $month, $year, isset($area) ? $area : "");

// If area is set but area name is not known, get the name.
if ($area) {
    if (empty($area_name)) {
        $dbarea = $DB->get_record('block_mrbs_area', array('id'=>$area), 'area_name', MUST_EXIST);
        $area_name = $dbarea->area_name;
    } else {
        $area_name = $area_name;
    }
}
echo '<h2>'.get_string('administration').'</h2>';
echo '<table border=1>';
echo '<tr>';
echo '<th><center><b>'.get_string('areas','block_mrbs').'</b></center></th>';
echo '<th><center><b>'.get_string('rooms','block_mrbs').' ';
if (isset($area_name)) {
    echo get_string('in','block_mrbs')." ".s($area_name);
}
echo '</b></center></th></tr><tr><td class="border">';

// This cell has the areas
$areas = $DB->get_records('block_mrbs_area', null, 'area_name');

if (empty($areas)) {
    echo get_string('noareas','block_mrbs');
} else {
    echo '<ul>';
    foreach ($areas as $dbarea) {
        $area_name_q = urlencode($dbarea->area_name);
        $adminurl = new moodle_url('/blocks/mrbs/web/admin.php', array('area'=>$dbarea->id, 'area_name'=>$area_name_q, 'sesskey'=>sesskey()));
        $editroomurl = new moodle_url('/blocks/mrbs/web/edit_area_room.php', array('area'=>$dbarea->id, 'sesskey'=>sesskey()));
        $delareaurl = new moodle_url('/blocks/mrbs/web/del.php', array('area'=>$dbarea->id, 'type'=>'area', 'sesskey'=>sesskey()));
        echo '<li><a href="'.$adminurl.'">'.s($dbarea->area_name).'</a> (<a href="'.$editroomurl.'">'.get_string('edit').'</a>) (<a href="'.$delareaurl.'">'.get_string('delete')."</a>)\n";
    }
    echo "</ul>";
}
echo '</td><td class="border">';

// This one has the rooms
if ($area) {
    $rooms = $DB->get_records('block_mrbs_room', array('area_id'=>$area), 'room_name');
    if (empty($rooms)) {
        //    $res = sql_query("select id, room_name, description, capacity from $tbl_room where area_id=$area order by room_name");
        echo get_string('norooms','block_mrbs');
    } else {
        echo '<ul>';
        foreach ($rooms as $dbroom) {
            $editroomurl = new moodle_url('/blocks/mrbs/web/edit_area_room.php', array('room'=>$dbroom->id, 'sesskey'=>sesskey()));
            $delroomurl = new moodle_url('/blocks/mrbs/web/del.php', array('area'=>$area, 'room'=>$dbroom->id, 'type'=>'room', 'sesskey'=>sesskey()));
            echo '<li>'.s($dbroom->room_name).' ('.s($dbroom->description).', '.$dbroom->capacity.') (<a href="'.$editroomurl.'">'.get_string('edit').'</a>) (<a href="'.$delroomurl.'">'.get_string('delete')."</a>)\n";
        }
        echo '</ul>';
    }
} else {
    echo get_string('noarea','block_mrbs');
}

$addareaurl = new moodle_url('/blocks/mrbs/web/add.php', array('type'=>'area', 'sesskey'=>sesskey()));
$addroomurl = new moodle_url($addareaurl, array('type'=>'room', 'area'=>$area));

echo '</tr><tr><td class="border"><h3 ALIGN=CENTER>'.get_string('addarea','block_mrbs').'</h3>';
echo '<form action="'.($addareaurl->out_omit_querystring()).'" method="post">';
echo html_writer::input_hidden_params($addareaurl);
echo '<table><tr><td>'.get_string('name').'</td><td><input type=text name=name></td></tr></table>';
echo '<input type=submit value="'.get_string('addarea','block_mrbs').'"></form></td><td class="border">';
if (0 != $area) {
    echo '<h3 align=center>'.get_string('addroom','block_mrbs').'</h3>';
    echo '<form action="'.$addroomurl->out_omit_querystring().'" method="post">';
    echo html_writer::input_hidden_params($addroomurl);
    echo '<table><tr><td>'.get_string('name').': </td><td><input type="text" name="name"></td></tr>';
    echo '<tr><td>'.get_string('description').': </td><td><input type="text" name="description"></td></tr>';
    echo '<tr><td>'.get_string('capacity','block_mrbs').': </td><td><input type="text" name="capacity"></td></tr>';
    echo '</table><input type=submit value="'.get_string('addroom','block_mrbs').'"></form>';
} else {
    echo "&nbsp;";
}
echo '</td></tr></table>';
//echo '<br />'.get_string('browserlang','block_mrbs').' '.$HTTP_ACCEPT_LANGUAGE.' '.get_string('postbrowserlang','block_mrbs');
include 'trailer.php';
