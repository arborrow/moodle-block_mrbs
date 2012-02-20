<?php
# $Id: del_entry.php,v 1.5 2008/08/17 23:07:28 arborrow Exp $
require_once("../../../config.php"); //for Moodle integration
require_once "grab_globals.inc.php";
include "config.inc.php";
include "functions.php";
include "$dbsys.php";
include "mrbs_auth.php";
include "mrbs_sql.php";
require_login();
$id = required_param('id', PARAM_INT);

if(getAuthorised(1) && ($info = mrbsGetEntryInfo($id)))
{
	$day   = userdate($info["start_time"], "%d");
	$month = userdate($info["start_time"], "%m");
	$year  = userdate($info["start_time"], "%Y");
	$area  = mrbsGetRoomArea($info["room_id"]);

    if (MAIL_ADMIN_ON_DELETE) { // Gather all fields values for use in emails.
        $mail_previous = getPreviousEntryData($id, $series);
    }
    sql_begin();
	$result = mrbsDelEntry(getUserName(), $id, $series, 1);
	sql_commit();
	if ($result)
	{
        // Send a mail to the Administrator
        (MAIL_ADMIN_ON_DELETE) ? $result = notifyAdminOnDelete($mail_previous) : '';
        Header("Location: day.php?day=$day&month=$month&year=$year&area=$area");
		exit();
	}
}

// If you got this far then we got an access denied.
showAccessDenied($day, $month, $year, $area);
?>