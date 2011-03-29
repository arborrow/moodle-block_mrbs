<?php

# $Id: help.php,v 1.1.2.1 2009/03/09 14:34:27 arborrow Exp $
require_once("../../../config.php"); //for Moodle integration
require_once "grab_globals.inc.php";
include "config.inc.php";
include "$dbsys.php";
include "functions.php";

#If we dont know the right date then make it up
if(!isset($day) or !isset($month) or !isset($year))
{
	$day   = date("d");
	$month = date("m");
	$year  = date("Y");
}
if(empty($area))
	$area = get_default_area();

print_header_mrbs($day, $month, $year, $area);

echo "<H3>" . get_vocab("about_mrbs") . "</H3>\n";
echo "<P><a href=\"http://mrbs.sourceforge.net\">".get_vocab("mrbs")."</a> - $mrbs_version\n";
echo "<BR>" . get_vocab("database") . sql_version() . "\n";
echo "<BR>" . get_vocab("system") . php_uname() . "\n";
echo "<BR>PHP: " . phpversion() . "\n";

echo "<H3>" . get_vocab("help") . "</H3>\n";
echo get_vocab("please_contact") . '<a href="mailto:' . $mrbs_admin_email
	. '">' . $mrbs_admin
	. "</a> " . get_vocab("for_any_questions") . "\n";
 
if (file_exists('../lang/'.$USER->lang.'/help/site_faq.html')) {
    include '../lang/'.$USER->lang.'/help/site_faq.html';
} else {
    include '../lang/en_utf8/help/site_faq.html';
}


include "trailer.php";
?>
