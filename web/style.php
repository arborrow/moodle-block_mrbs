<?php

# $Id: style.php,v 1.5 2008/08/02 04:44:17 arborrow Exp $
require_once("../../../config.php"); //for Moodle integration
global $unicode_encoding;

?>
    <LINK REL="stylesheet" href="mrbs.css" type="text/css">
    <META HTTP-EQUIV="Content-Type" content="text/html; charset=<?php
   if ($unicode_encoding)
   {
     echo "utf-8";
   }
   else
   {
     echo get_string('charset','block_mrbs');
   }
?>">
    <META NAME="Robots" content="noindex">
<?php

global $refresh_rate;
global $PHP_SELF;

if (($refresh_rate != 0) &&
    preg_match("/(day|week|month)\.php/",$PHP_SELF))
{
  echo "    <META HTTP-EQUIV=\"Refresh\" CONTENT=\"$refresh_rate\">\n";
}
?>
