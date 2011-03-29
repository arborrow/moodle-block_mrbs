<?php

# $Id: help.php,v 1.9 2009/06/10 15:19:35 mike1989 Exp $
require_once("../../../config.php"); //for Moodle integration
require_once "grab_globals.inc.php";
include "config.inc.php";
include "$dbsys.php";
include "functions.php";
include "version.php";
global $USER;

if ($CFG->forcelogin) {
        require_login();
    }

$day = optional_param('day', 0, PARAM_INT);
$month = optional_param('month', 0, PARAM_INT);
$year = optional_param('year', 0, PARAM_INT); 
$area = optional_param('area', get_default_area(),  PARAM_INT);

#If we dont know the right date then make it up
if(($day==0) or ($month==0) or ($year==0))
{
	$day   = date("d");
	$month = date("m");
	$year  = date("Y");
}
//if(empty($area)) - using optional_param -ab
//	$area = get_default_area();

print_header_mrbs($day, $month, $year, $area);

echo "<H3>" . get_string('about_mrbs','block_mrbs') . "</H3>\n";
echo "<P><a href=\"http://mrbs.sourceforge.net\">".get_string('mrbs','block_mrbs')."</a> - ".get_mrbs_version()."\n";
echo "<BR>" . get_string('database','block_mrbs') . sql_version() . "\n";
echo "<BR>" . get_string('system','block_mrbs') . php_uname() . "\n";
echo "<BR>PHP: " . phpversion() . "\n";

echo "<H3>" . get_string('help') . "</H3>\n";
echo get_string('please_contact','block_mrbs') . '<a href="mailto:' . $mrbs_admin_email
	. '">' . $mrbs_admin
	. "</a> " . get_string('for_any_questions','block_mrbs') . "\n";

if (file_exists($CFG->wwwroot.'blocks/mrbs/lang/'.$USER->lang.'/help/site_faq.html')) {
    include $CFG->wwwroot.'blocks/mrbs/lang/'.$USER->lang.'/help/site_faq.html';
} else {
    include $CFG->wwwroot.'blocks/mrbs/lang/en_utf8/help/site_faq.html';
}

include "trailer.php";
?>
