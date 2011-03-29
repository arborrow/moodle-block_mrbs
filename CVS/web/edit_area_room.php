<?php
// $Id: edit_area_room.php,v 1.7 2008/09/30 23:31:08 arborrow Exp $
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
$change_done = optional_param('change_done', 0, PARAM_BOOL);
$room = optional_param('room', 0, PARAM_INT); 
$area_name = optional_param('area_name', '', PARAM_TEXT);
$capacity = optional_param('capacity', 0, PARAM_INT);

// $room_admin_email = optional_param('room_admin_email', 0, PARAM_BOOL); //not sure if this is from config or passed from URL -ab. 
// $area = optional_param('area', 0, PARAM_INT); this may be passed from URL and should probably be checked; however, I need to review the logic in other places first -ab.

#If we dont know the right date then make it up
if(($day==0) or ($month==0) or ($year==0))
{
	$day   = date("d");
	$month = date("m");
	$year  = date("Y");
}

if(!getAuthorised(2))
{
	showAccessDenied($day, $month, $year, $area);
	exit();
}

// Done changing area or room information?
if (($change_done))
{
	if (!empty($room)) // Get the area the room is in
	{
		$area = sql_query1("SELECT area_id from $tbl_room where id=$room");
	}
	Header("Location: admin.php?day=$day&month=$month&year=$year&area=$area");
	exit();
}

print_header_mrbs($day, $month, $year, isset($area) ? $area : "");

?>

<h2><?php echo get_string('editroomarea','block_mrbs') ?></h2>

<table border=1>

<?php
if($room>0) {
    (!isset($room_admin_email)) ? $room_admin_email = '': '';
    $emails = explode(',', $room_admin_email);
    $valid_email = TRUE;
    foreach ($emails as $email)
    {
        // if no email address is entered, this is OK, even if isValidInetAddress
        // does not return TRUE
        if (!get_user_by_email($email) && ('' != $room_admin_email)) {
            $valid_email = FALSE;
            notice(get_string('no_user_with_email','block_mrbs',$email));
        }
    }
    //
	if ( isset($change_room) && (FALSE != $valid_email) )
	{
        if (empty($capacity)) $capacity = 0;
		$sql = "UPDATE $tbl_room SET room_name='" . slashes($room_name)
			. "', description='" . slashes($description)
			. "', capacity=$capacity, room_admin_email='"
            . slashes($room_admin_email) . "' WHERE id=$room";
		if (sql_command($sql) < 0)
			fatal_error(0, get_string('update_room_failed','block_mrbs') . sql_error());
	}

	$res = sql_query("SELECT * FROM $tbl_room WHERE id=$room");
	if (! $res) fatal_error(0, get_string('error_room','block_mrbs') . $room . get_string('not_found','block_mrbs'));
	$row = sql_row_keyed($res, 0);
	sql_free($res);
?>
<h3 ALIGN=CENTER><?php echo get_string('editroom','block_mrbs') ?></h3>
<form action="edit_area_room.php" method="post">
<input type=hidden name="room" value="<?php echo $row["id"]?>">
<CENTER>
<TABLE>
<TR><TD><?php echo get_string('name') ?>:       </TD><TD><input type=text name="room_name" value="<?php
echo htmlspecialchars($row["room_name"]); ?>"></TD></TR>
<TR><TD><?php echo get_string('description') ?></TD><TD><input type=text name=description value="<?php
echo htmlspecialchars($row["description"]); ?>"></TD></TR>
<TR><TD><?php echo get_string('capacity','block_mrbs') ?>:   </TD><TD><input type=text name=capacity value="<?php
echo $row["capacity"]; ?>"></TD></TR>
<TR><TD><?php echo get_string('room_admin_email','block_mrbs') ?></TD><TD><input type=text name=room_admin_email MAXLENGTH=75 value="<?php
echo htmlspecialchars($row["room_admin_email"]); ?>"></TD>
<?php if (FALSE == $valid_email) {
    echo ("<TD>&nbsp;</TD><TD><STRONG>" . get_string('emailmustbereal') . "<STRONG></TD>");
} ?></TR>
</TABLE>
<input type=submit name="change_room"
value="<?php echo get_string('savechanges') ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type=submit name="change_done" value="<?php echo get_string('backadmin','block_mrbs') ?>">
</CENTER>
</form>
<?php } ?>

<?php
if(!empty($area))
{
    (!isset($area_admin_email)) ? $area_admin_email = '': '';
    $emails = explode(',', $area_admin_email);
    $valid_email = TRUE;
    foreach ($emails as $email)
    {
        // if no email address is entered, this is OK, even if isValidInetAddress
        // does not return TRUE
        if (!get_user_by_email($email) && ('' != $area_admin_email)) {
            $valid_email = FALSE;
            notice(get_string('no_user_with_email','block_mrbs',$email));
        }
    }
    //
    if ( isset($change_area) && (FALSE != $valid_email) )
	{
		$sql = "UPDATE $tbl_area SET area_name='" . slashes($area_name)
			. "', area_admin_email='" . slashes($area_admin_email)
            . "' WHERE id=$area";
		if (sql_command($sql) < 0)
			fatal_error(0, get_string('update_area_failed','block_mrbs') . sql_error());
	}

	$res = sql_query("SELECT * FROM $tbl_area WHERE id=$area");
	if (! $res) fatal_error(0, get_string('error_area','block_mrbs') . $area . get_string('not_found','block_mrbs'));
	$row = sql_row_keyed($res, 0);
	sql_free($res);
?>
<h3 ALIGN=CENTER><?php echo get_string('editarea','block_mrbs') ?></h3>
<form action="edit_area_room.php" method="post">
<input type=hidden name="area" value="<?php echo $row["id"]?>">
<CENTER>
<TABLE>
<TR><TD><?php echo get_string('name') ?>:       </TD><TD><input type=text name="area_name" value="<?php
echo htmlspecialchars($row["area_name"]); ?>"></TD></TR>
<TR><TD><?php echo get_string('area_admin_email','block_mrbs') ?>:       </TD><TD><input type=text name="area_admin_email" MAXLENGTH=75 value="<?php
echo htmlspecialchars($row["area_admin_email"]); ?>"></TD>
<?php if (FALSE == $valid_email) {
    echo ("<TD>&nbsp;</TD><TD><STRONG>" . get_string('emailmustbereal') . "</STRONG></TD>");
} ?></TR>
</TABLE>
<input type=submit name="change_area"
value="<?php echo get_string('savechanges') ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type=submit name="change_done" value="<?php echo get_string('backadmin','block_mrbs') ?>">
</CENTER>
</form>
<?php } ?>
</TABLE>
<?php include "trailer.php" ?>