<?php
require_once("../../../config.php"); //for Moodle integration
/* $Id: escapeshellarg.php,v 1.2 2007/12/28 05:53:05 arborrow Exp $
 *
 * Included if your PHP version is less than 4.0.3 and therefore this
 * function doesn't exist.
 *
 */

function escapeshellarg($x)
{
  return "'".ereg_replace("'", "'\\''", $x)."'";
} 

?>