<?php

/* $Id: session_ip.php,v 1.1 2007/04/05 22:25:33 arborrow Exp $
 *
 * Session management scheme that uses IP addresses to identify users.
 * Anyone who can access the server can make bookings.
 * Administrators are also identified by their IP address.
 *
 * To use this authentication scheme set the following
 * things in config.inc.php:
 *
 * $auth["type"]    = "none";
 * $auth["session"] = "ip";
 *
 * Then, you may configure admin users:
 *
 * $auth["admin"][] = "127.0.0.1"; // Local host = the server you're running on
 * $auth["admin"][] = "192.168.0.1";
 */
require_once("../../../config.php"); //for Moodle integration
# No need to prompt for a name - ip address always there
function authGet() { }

function getUserName()
{
	global $REMOTE_ADDR;
	return $REMOTE_ADDR;
}

?>
