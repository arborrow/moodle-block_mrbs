<?php

# $Id: admin.php,v 1.7 2010/01/16 14:05:45 arborrow Exp $
require_once("../../../config.php");
require_once "grab_globals.inc.php";
require "config.inc.php";
require "functions.php";
require "$dbsys.php";
require "mrbs_auth.php";
require_login();
$day=optional_param('day',0 ,PARAM_INT);
$month=optional_param('month', 0 ,PARAM_INT);
$year=optional_param('year', 0, PARAM_INT);
$area = optional_param('area', get_default_area(), PARAM_INT);
$area_name = optional_param('area_name', '', PARAM_TEXT);

#If we dont know the right date then make it up 
if (($day==0) or ($month==0) or ($year==0)) {
    $day   = date("d");
    $month = date("m");
    $year  = date("Y");
}

if (!getAuthorised(2)) {
    showAccessDenied($day, $month, $year, $area);
    exit();
}

print_header_mrbs($day, $month, $year, isset($area) ? $area : "");

// If area is set but area name is not known, get the name.
if (isset($area)) {
    if (empty($area_name)) {
        $res = sql_query("select area_name from $tbl_area where id=$area");
        if (! $res) fatal_error(0, sql_error());
        if (sql_count($res) == 1) {
            $row = sql_row($res, 0);
            $area_name = $row[0];
        }
        sql_free($res);
    } else {
        $area_name = unslashes($area_name);
    }
}
echo '<h2>'.get_string('administration').'</h2>';
echo '<table border=1>';
echo '<tr>';
echo '<th><center><b>'.get_string('areas','block_mrbs').'</b></center></th>';
echo '<th><center><b>'.get_string('rooms','block_mrbs');
if (isset($area_name)) {
    echo get_string('in','block_mrbs')." ".htmlspecialchars($area_name);
}
echo '</b></center></th></tr><tr><td>';

// This cell has the areas
$res = sql_query("select id, area_name from $tbl_area order by area_name");
if (! $res) fatal_error(0, sql_error());

if (sql_count($res) == 0) {
    echo get_string('noareas','block_mrbs');
} else {
    echo '<ul>';
    for ($i = 0; ($row = sql_row($res, $i)); $i++) {
        $area_name_q = urlencode($row[1]);
        echo "<li><a href=\"admin.php?area=$row[0]&area_name=$area_name_q\">".htmlspecialchars($row[1])."</a> (<a href=\"edit_area_room.php?area=$row[0]\">".get_string('edit')."</a>) (<a href=\"del.php?type=area&area=$row[0]\">".get_string('delete')."</a>)\n";
    }
    echo "</ul>";
}
echo '</td><td>';

// This one has the rooms
if (isset($area)) {
    $res = sql_query("select id, room_name, description, capacity from $tbl_room where area_id=$area order by room_name");
    if (! $res) fatal_error(0, sql_error());
    if (sql_count($res) == 0) {
        echo get_string('norooms','block_mrbs');
    } else {
        echo '<ul>';
        for ($i = 0; ($row = sql_row($res, $i)); $i++) {
            echo '<li>'.htmlspecialchars($row[1]).' ('.htmlspecialchars($row[2]).", $row[3]) (<a href=\"edit_area_room.php?room=$row[0]\">".get_string('edit')."</a>) (<a href=\"del.php?type=room&room=$row[0]\">".get_string('delete').'</a>)\n';
        }
        echo '</ul>';
    }
} else {
    echo get_string('noarea','block_mrbs');
}

echo '</tr><tr><td><h3 ALIGN=CENTER>'.get_string('addarea','block_mrbs').'</h3>';
echo '<form action=add.php method=post>';
echo '<input type=hidden name=type value=area>';
echo '<table><tr><td>'.get_string('name').'</td><td><input type=text name=name></td></tr></table>';
echo '<input type=submit value="'.get_string('addarea','block_mrbs').'"></form></td><td>';
if (0 != $area) { 
    echo '<h3 align=center>'.get_string('addroom','block_mrbs').'</h3>';
    echo '<form action=add.php method=post><input type=hidden name=type value=room><input type=hidden name=area value='.$area.'>';
    echo '<table><tr><td>'.get_string('name').': </td><td><input type=text name=name></td></tr>';
    echo '<tr><td>'.get_string('description').': </td><td><input type=text name=description></td></tr>';
    echo '<tr><td>'.get_string('capacity','block_mrbs').': </td><td><input type=text name=capacity></td></tr>';
    echo '</table><input type=submit value="'.get_string('addroom','block_mrbs').'"></form>';
} else { 
    echo "&nbsp;";
}
echo '</td></tr></table><br />'.get_string('browserlang','block_mrbs').' '.$HTTP_ACCEPT_LANGUAGE.' '.get_string('postbrowserlang','block_mrbs');
include 'trailer.php';
