<?php

/* $Id: auth_moodle.php,v 1.1 2007/04/05 22:25:25 arborrow Exp $
 *
 * Assigns MRBS access levels based on the user status
 * within your Moodle installation. 
 *
 *
 * MRBS Levels
 * 0 - View only
 * 1 - View and make bookings
 * 2 - Full administration - add rooms and bookings
 *
 * Moodle Integration 
 * Defines one of the above levels to admins, teachers
 * students, creators, and guests seperately.
 *
 * Used in conjunction with session_moodle.inc
 *
 * To use this authentication scheme set the following
 * things in config.inc.php:
 *
 *      $auth["type"]    = "moodle";
 *      $auth["session"] = "moodle";
 *
 */

require_once("../../../config.php");

function authValidateUser($user, $pass)
{
    return 1;
}

function authGetUserLevel($user, $lev1_admin)
{
	global $USER;
	// OLD MOODLE 1.6.X CODE 
/* 
	// Set access level for site admins
	if (isadmin()) {
	    return 2;
    }
	
	// Set access level for course creators
	if (iscreator()) {
	    return 2;
    }
	
	// Set access level for teachers, if at course level
	if (isteacher()) {
	    return 1;
    }
	
	// Set access level for students - not implemented
	if (! isstudent($course->id)) {
		return 1;
    	}
	// Set access level for guest user
    if (isguest()) {
	return 0;
	}
*/

// HACK For Moodle 1.7 With Roles Block...	
    
    $context = get_context_instance(CONTEXT_SYSTEM, SITEID);  
   // Set Access leve for users via MRBS block and Moodle 1.7 roles
    if (has_capability('block/mrbs:administermrbs', $context)) {
    	    return 2;
    }
	// has_capability('block/mrbs:editmrbs', $context)
    if (has_capability('block/mrbs:editmrbs', $context)) {
    	    return 1;
    }
	if (has_capability('block/mrbs:viewmrbs', $context)) {
    	    return 0;
    }
	// Set access level for other users (e.g. people who access url directly)
	else {
    return 0;
	}
}

?>
