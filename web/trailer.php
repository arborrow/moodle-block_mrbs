<?php
# $Id: trailer.php,v 1.6 2008/08/04 01:17:51 arborrow Exp $
require_once("../../../config.php"); //for Moodle integration
if ( $pview != 1 ) {

echo "<P><HR><B>".get_string('viewday','block_mrbs').":</B>\n";

if(!isset($year))
	$year = strftime("%Y");

if(!isset($month))
	$month = strftime("%m");

if(!isset($day))
	$day = strftime("%d");

if (empty($area))
	$params = "";
else
	$params = "&area=$area";

for($i = -6; $i <= 7; $i++)
{
	$ctime = mktime(0, 0, 0, $month, $day + $i, $year);

	$str = userdate($ctime, empty($dateformat)? "%b %d" : "%d %b");

	$cyear  = date("Y", $ctime);
	$cmonth = date("m", $ctime);
	$cday   = date("d", $ctime);
	if ($i != -6) echo " | ";
	if ($i == 0) echo '<b>[ ';
	echo "<a href=\"day.php?year=$cyear&month=$cmonth&day=$cday$params\">$str</a>\n";
	if ($i == 0) echo ']</b> ';
}

echo "<BR><B>".get_string('viewweek','block_mrbs').":</B>\n";

if (!empty($room)) $params .= "&room=$room";

$ctime = mktime(0, 0, 0, $month, $day, $year);
# How many days to skip back to first day of week:
$skipback = (date("w", $ctime) - $weekstarts + 7) % 7;
	
for ($i = -4; $i <= 4; $i++)
{
	$ctime = mktime(0, 0, 0, $month, $day + 7 * $i - $skipback, $year);

	$cweek  = date("W", $ctime);
	$cday   = date("d", $ctime);
	$cmonth = date("m", $ctime);
	$cyear  = date("Y", $ctime);
	if ($i != -4) echo " | ";

	if ($view_week_number)
	{
		$str = $cweek;
	}
	else
	{
		$str = userdate($ctime, empty($dateformat)? "%b %d" : "%d %b");
	}
	if ($i == 0) echo '<b>[ ';
	echo "<a href=\"week.php?year=$cyear&month=$cmonth&day=$cday$params\">$str</a>\n";
	if ($i == 0) echo ']</b> ';
}

echo "<BR><B>".get_string('viewmonth','block_mrbs').":</B>\n";
for ($i = -2; $i <= 6; $i++)
{
	$ctime = mktime(0, 0, 0, $month + $i, 1, $year);
	$str = userdate($ctime, "%b %Y");
	
	$cmonth = date("m", $ctime);
	$cyear  = date("Y", $ctime);
	if ($i != -2) echo " | ";
	if ($i == 0) echo '<b>[ ';
	echo "<a href=\"month.php?year=$cyear&month=$cmonth$params\">$str</a>\n";
	if ($i == 0) echo ']</b> ';
}

echo "<HR>";
echo '<p><center><a href="' . basename($PHP_SELF) . '?' . $QUERY_STRING . '&pview=1">' . get_string('ppreview','block_mrbs') . '</a></center><p>';

}

echo $OUTPUT->footer();
?>
