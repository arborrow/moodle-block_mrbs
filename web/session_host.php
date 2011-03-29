<?php

/* $Id: session_host.php,v 1.1 2007/04/05 22:25:33 arborrow Exp $
 *
 * This is a slight variant of session_ip. 
 * Session management scheme that uses the DNS name of the computer
 * to identify users and administrators.
 * Anyone who can access the server can make bookings etc.
 *
 * To use this authentication scheme set the following
 * things in config.inc.php:
 *
 * $auth["type"]    = "none";
 * $auth["session"] = "host";
 *
 * Then, you may configure admin users:
 *
 * $auth["admin"][] = "DNSname1";
 * $auth["admin"][] = "DNSname2";
 */
require_once("../../../config.php"); //for Moodle integration
# No need to prompt for a name - if no DNSname is returned, ip address
# is used
function authGet() { }

function getUserName()
{
	global $REMOTE_ADDR;
	$remotehostname = gethostbyaddr($REMOTE_ADDR);
        return $remotehostname;
}

?>
