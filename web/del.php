<?php
# $Id: del.php,v 1.6 2008/08/22 18:43:14 arborrow Exp $
require_once("../../../config.php"); //for Moodle integration
require_once "grab_globals.inc.php";
include "config.inc.php";
include "functions.php";
include "$dbsys.php";
include "mrbs_auth.php";
require_login();
$day = optional_param('day', 0, PARAM_INT);
$month = optional_param('month', 0, PARAM_INT);
$year = optional_param('year', 0, PARAM_INT); 
$area = optional_param('area', get_default_area(),  PARAM_INT);
$room = optional_param('room', 0,  PARAM_INT);
$type = optional_param('type', '', PARAM_ALPHA);
$confirm = optional_param('confirm', 0, PARAM_BOOL);

#If we dont know the right date then make it up
if(($day==0) or ($month==0) or ($year==0))
{
	$day   = date("d");
	$month = date("m");
	$year  = date("Y");
}

// if (empty($area)) // - handling with optional_param -ab.
//	$area = get_default_area();

if(!getAuthorised(2))
{
	showAccessDenied($day, $month, $year, $area);
	exit();
}

# This is gonna blast away something. We want them to be really
# really sure that this is what they want to do.

if($type == "room")
{
	# We are supposed to delete a room
	if(isset($confirm))
	{
		# They have confirmed it already, so go blast!
		sql_begin();
		# First take out all appointments for this room
		sql_command("delete from $tbl_entry where room_id=$room");
		
		# Now take out the room itself
		sql_command("delete from $tbl_room where id=$room");
		sql_commit();
		
		# Go back to the admin page
		Header("Location: admin.php");
	}
	else
	{
		print_header_mrbs($day, $month, $year, $area);
		
		# We tell them how bad what theyre about to do is
		# Find out how many appointments would be deleted
		
		$sql = "select name, start_time, end_time from $tbl_entry where room_id=$room";
		$res = sql_query($sql);
		if (! $res) echo sql_error();
		elseif (sql_count($res) > 0)
		{
			echo get_string('deletefollowing','block_mrbs') . ":<ul>";
			
			for ($i = 0; ($row = sql_row($res, $i)); $i++)
			{
				echo "<li>$row[0] (";
				echo time_date_string($row[1]) . " -> ";
				echo time_date_string($row[2]) . ")";
			}
			
			echo "</ul>";
		}
		
		echo "<center>";
		echo "<H1>" .  get_string('sure','block_mrbs') . "</h1>";
		echo "<H1><a href=\"del.php?type=room&room=$room&confirm=Y\">" . get_string('yes') . "!</a> &nbsp;&nbsp;&nbsp; <a href=admin.php>" . get_string('no') . "!</a></h1>";
		echo "</center>";
		include "trailer.php";
	}
}

if($type == "area")
{
	# We are only going to let them delete an area if there are
	# no rooms. its easier
    $n = sql_query1("select count(*) from $tbl_room where area_id=$area");
	if ($n == 0)
	{
		# OK, nothing there, lets blast it away
		sql_command("delete from $tbl_area where id=$area");
		
		# Redirect back to the admin page
		header("Location: admin.php");
	}
	else
	{
		# There are rooms left in the area
		print_header_mrbs($day, $month, $year, $area);
		
		echo get_string('delarea','block_mrbs');
		echo "<a href=admin.php>" . get_string('backadmin','block_mrbs') . "</a>";
		include "trailer.php";
	}
}
?>