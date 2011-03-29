<?php
require_once("../../../config.php"); //for Moodle integration
/* $Id: escapeshellarg.php,v 1.1 2007/04/05 22:25:30 arborrow Exp $
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
