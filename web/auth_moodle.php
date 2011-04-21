<?php

/* $Id: auth_moodle.php,v 1.2 2010/01/16 15:15:57 arborrow Exp $
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

function authValidateUser($user, $pass) {
    return 1;
}

function authGetUserLevel($user, $lev1_admin) {
    global $USER;

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
    } else { // Set access level for other users (e.g. people who access url directly)
        return 0;
    }
}

?>
