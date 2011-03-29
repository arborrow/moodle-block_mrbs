<?php

/*****************************************************************************\
*									      *
*   File name       auth_db_ext.php					      *
*									      *
*   Description	    Authenticate users from a table in another database.      *
*									      *
*   Notes	    To use this authentication scheme, set in config.inc.php: *
*			$auth["type"]  = "db_ext";			      *
*                   Assumes passwords are stored in the other table in        *
*                   plaintext, authValidateUser() will need to be changed if  *
*                   the password is stored differently.                       *
*									      *
*   History								      *
*    2005/05/11 JPB Created this file					      *
*									      *
\*****************************************************************************/

// $Id: auth_db_ext.php,v 1.1 2007/04/05 22:25:24 arborrow Exp $


/* authValidateUser($user, $pass)
 * 
 * Checks if the specified username/password pair are valid
 * 
 * $user  - The user name
 * $pass  - The password
 * 
 * Returns:
 *   0        - The pair are invalid or do not exist
 *   non-zero - The pair are valid
 */

require_once("../../../config.php");


function authValidateUser($user, $pass)
{
   global $auth;

   $retval = 0;

   $user=strtolower($user);

   $conn = mysql_connect($auth['db_ext']['db_host'],
                         $auth['db_ext']['db_username'],
                         $auth['db_ext']['db_password']);

   mysql_select_db($auth['db_ext']['db_name'], $conn);

   $user = addslashes($user);

   if ($auth['db_ext']['use_md5_passwords'] == 1)
   {
//     $pass = md5($pass);
        $pass = $USER->password;
   }

   $query = "SELECT " . $auth['db_ext']['column_name_password'] .
            " FROM " . $auth['db_ext']['db_table'] .
            " WHERE ". $auth['db_ext']['column_name_username'] . "='$user'";

   $r = mysql_query($query, $conn);

   if ($r && (mysql_num_rows($r) == 1)) // force a unique match
   {
     $row = mysql_fetch_row($r);

     switch ($auth['db_ext']['password_format'])
     {
       case 'md5':
         if (($pass == $row[0]) and substr($USER->username,0,1)>'0')
         {
           $retval = 1;
         }
         break;

       case 'sha1':
         if (sha1($pass) == $row[0])
         {
           $retval = 1;
         }
         break;

       case 'crypt':
         $recrypt = crypt($pass,$row[0]);
         if ($row[0] == $recrypt)
         {
           $retval = 1;
         }
         break;

       default:
         // Otherwise assume plaintext
         if ($pass == $row[0])
         {
           $retval = 1;
         }
         break;
     }
   }

   mysql_close($conn);

   return $retval;
}

/* authGetUserLevel($user)
 * 
 * Determines the users access level
 * 
 * $user - The user name
 *
 * Returns:
 *   The users access level
 */
function authGetUserLevel($user, $lev1_admin)
{global $USER;
$user=$USER->username;
   // User not logged in, user level '0'
//   if ((!isset($user)) or (substr($USER->username,0,1) == '0'))
//hard coded course id (1492) for faculty (all faculty members who can schedule a room are teachers of this course)
   if ( (!isset($user)) or (!isteacher(1492,$USER->id)) )
      return 0;

   // Check if the user is can modify
   for($i = 0; isset($lev1_admin[$i]); $i++)
   {
      if(strcasecmp($user, $lev1_admin[$i]) == 0)
	 return 2;
   }

   // Everybody else is access level '1'
   return 1;
}

?>
