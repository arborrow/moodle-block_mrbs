<?php

# $Id: admin.php,v 1.6 2008/08/17 23:07:28 arborrow Exp $
require_once("../../../config.php");
require_once "grab_globals.inc.php";
include "config.inc.php";
include "functions.php";
include "$dbsys.php";
include "mrbs_auth.php";
require_login();
$day=optional_param('day',0 ,PARAM_INT);
$month=optional_param('month', 0 ,PARAM_INT);
$year=optional_param('year', 0, PARAM_INT);
$area = optional_param('area', get_default_area(), PARAM_INT);
$area_name = optional_param('area_name', '', PARAM_TEXT);

#If we dont know the right date then make it up 
if(($day==0) or ($month==0) or ($year==0))
{
	$day   = date("d");
	$month = date("m");
	$year  = date("Y");
}

//if (empty($area)) // going to handle with optional_param -ab.
//{
//    $area = get_default_area();
//}

if(!getAuthorised(2))
{
	showAccessDenied($day, $month, $year, $area);
	exit();
}

print_header_mrbs($day, $month, $year, isset($area) ? $area : "");

// If area is set but area name is not known, get the name.
if (isset($area))
{
	if (empty($area_name))
	{
		$res = sql_query("select area_name from $tbl_area where id=$area");
    	if (! $res) fatal_error(0, sql_error());
		if (sql_count($res) == 1)
		{
			$row = sql_row($res, 0);
			$area_name = $row[0];
		}
		sql_free($res);
	} else {
		$area_name = unslashes($area_name);
	}
}
?>

<h2><?php echo get_string('administration') ?></h2>

<table border=1>
<tr>
<th><center><b><?php echo get_string('areas','block_mrbs') ?></b></center></th>
<th><center><b><?php echo get_string('rooms','block_mrbs') ?> <?php if(isset($area_name)) { echo get_string('in','block_mrbs') . " " .
  htmlspecialchars($area_name); }?></b></center></th>
</tr>

<tr>
<td>
<?php 
# This cell has the areas
$res = sql_query("select id, area_name from $tbl_area order by area_name");
if (! $res) fatal_error(0, sql_error());

if (sql_count($res) == 0) {
	echo get_string('noareas','block_mrbs');
} else {
	echo "<ul>";
	for ($i = 0; ($row = sql_row($res, $i)); $i++) {
		$area_name_q = urlencode($row[1]);
		echo "<li><a href=\"admin.php?area=$row[0]&area_name=$area_name_q\">"
			. htmlspecialchars($row[1]) . "</a> (<a href=\"edit_area_room.php?area=$row[0]\">" . get_string('edit') . "</a>) (<a href=\"del.php?type=area&area=$row[0]\">" .  get_string('delete') . "</a>)\n";
	}
	echo "</ul>";
}
?>
</td>
<td>
<?php
# This one has the rooms
if(isset($area)) {
	$res = sql_query("select id, room_name, description, capacity from $tbl_room where area_id=$area order by room_name");
	if (! $res) fatal_error(0, sql_error());
	if (sql_count($res) == 0) {
		echo get_string('norooms','block_mrbs');
	} else {
		echo "<ul>";
		for ($i = 0; ($row = sql_row($res, $i)); $i++) {
			echo "<li>" . htmlspecialchars($row[1]) . " (" . htmlspecialchars($row[2])
			. ", $row[3]) (<a href=\"edit_area_room.php?room=$row[0]\">" . get_string('edit') . "</a>) (<a href=\"del.php?type=room&room=$row[0]\">" . get_string('delete') . "</a>)\n";
		}
		echo "</ul>";
	}
} else {
	echo get_string('noarea','block_mrbs');
}

?>

</tr>
<tr>
<td>
<h3 ALIGN=CENTER><?php echo get_string('addarea','block_mrbs') ?></h3>
<form action=add.php method=post>
<input type=hidden name=type value=area>

<TABLE>
<TR><TD><?php echo get_string('name') ?>:       </TD><TD><input type=text name=name></TD></TR>
</TABLE>
<input type=submit value="<?php echo get_string('addarea','block_mrbs') ?>">
</form>
</td>

<td>
<?php if (0 != $area) { ?>
<h3 ALIGN=CENTER><?php echo get_string('addroom','block_mrbs') ?></h3>
<form action=add.php method=post>
<input type=hidden name=type value=room>
<input type=hidden name=area value=<?php echo $area; ?>>

<TABLE>
<TR><TD><?php echo get_string('name') ?>:       </TD><TD><input type=text name=name></TD></TR>
<TR><TD><?php echo get_string('description') ?>: </TD><TD><input type=text name=description></TD></TR>
<TR><TD><?php echo get_string('capacity','block_mrbs') ?>:   </TD><TD><input type=text name=capacity></TD></TR>
</TABLE>
<input type=submit value="<?php echo get_string('addroom','block_mrbs') ?>">
</form>
<?php } else { echo "&nbsp;"; }?>
</td>
</tr>
</table>

<br>
<?php echo get_string('browserlang','block_mrbs') . " " . $HTTP_ACCEPT_LANGUAGE . " " . get_string('postbrowserlang','block_mrbs') ; ?>

<?php include "trailer.php" ?>