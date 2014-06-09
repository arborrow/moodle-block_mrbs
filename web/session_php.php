<?php
/*****************************************************************************\
*                                                                             *
*   File name       session_php.php                                           *
*                                                                             *
*   Description     Use PHP built-in sessions handling                        *
*                                                                             *
*   Notes           To use this authentication scheme, set in                 *
*                   config.inc.php:                                           *
*                       $auth["session"]  = "php";                            *
*                                                                             *
*                                                                             *
*   History                                                                   *
*    2003/11/09 JFL Created this file                                         *
*    Remaining history in ChangeLog and CVS logs                              *
*                                                                             *
\*****************************************************************************/

require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/config.php');
global $PHP_SELF, $USER;

if (isset($cookie_path_override))
{
    $cookie_path = $cookie_path_override;
}
else
{
    $cookie_path = $PHP_SELF;
    $cookie_path = preg_replace('|[^/]*$|', '', $cookie_path);
}
session_set_cookie_params(0, $cookie_path);
//session_start();

/*
  Target of the form with sets the URL argument "Action=SetName".
  Will eventually return to URL argument "TargetURL=whatever".
*/
if (isset($Action) && ($Action == "SetName"))
{
    /* First make sure the password is valid */
    if ($NewUserName == "") {

        // Unset the session variables
        if (isset($_SESSION)) {
            $_SESSION = array();
        } else {
            global $HTTP_SESSION_VARS;
            $HTTP_SESSION_VARS = array();
        }
    } else {
        $NewUserName = $NewUserName;
        $NewUserPassword = $NewUserPassword;
        if (!authValidateUser($NewUserName, $NewUserPassword)) {
            print_header_mrbs(0, 0, 0, 0);
            echo "<P>".get_string('usernamenotfound')."</P>\n";
            printLoginForm($TargetURL);
            exit();
        }

        if (isset($_SESSION)) {
            $_SESSION["UserName"] = $NewUserName;
        } else {
            global $HTTP_SESSION_VARS;
            $HTTP_SESSION_VARS["UserName"] = $NewUserName;
        }
    }

    header ("Location: $TargetURL"); /* Redirect browser to initial page */
    /* Note HTTP 1.1 mandates an absolute URL. Most modern browsers support relative URLs,
        which allows to work around problems with DNS inconsistencies in the server name.
        Anyway, if the browser cannot redirect automatically, the manual link below will work. */
    print_header_mrbs(0, 0, 0, 0);
    echo "<br />\n";
    echo "<p>Please click <a href=\"$TargetURL\">here</a> if you're not redirected automatically to the page you requested.</p>\n";
    echo "</body>\n";
    echo "</html>\n";
    exit();
}

/*
  Display the login form. Used by two routines below.
  Will eventually return to $TargetURL.
*/
function printLoginForm($TargetURL)
{
    global $PHP_SELF;
   $SESSION->wantsurl = $TargetURL;
   require_login();
}


/* authGet()
 *
 * Request the user name/password
 *
 * Returns: Nothing
 */
function authGet()
{
    global $PHP_SELF, $QUERY_STRING;

    print_header_mrbs(0, 0, 0, 0);

    echo "<p>".get_string('norights','block_mrbs')."</p>\n";

    $TargetURL = basename($PHP_SELF);
    if (isset($QUERY_STRING)) $TargetURL = $TargetURL . "?" . $QUERY_STRING;
    printLoginForm($TargetURL);

    exit();
}

function getUserName()
{ global $USER;
   return $USER->username;
/*
    if (isset($_SESSION) && isset($_SESSION["UserName"]) && ($_SESSION["UserName"] != ""))
    {
        return 'aborrow'; //$_SESSION["UserName"];
    }
    else
    {
        global $HTTP_SESSION_VARS;
        if (isset($HTTP_SESSION_VARS["UserName"]) && ($HTTP_SESSION_VARS["UserName"] != ""))
            return 'arborrow'; //$HTTP_SESSION_VARS["UserName"];
    }
    return 'aborrow';
*/
}

// Print the logon entry on the top banner.
function PrintLogonBox()
{
    global $PHP_SELF, $QUERY_STRING, $CFG, $user_list_link, $user_link, $day, $month;
    global $year, $auth;

    $TargetURL = basename($PHP_SELF);
    if (isset($url_base) && ($url_base != "")) $TargetURL = $url_base . '/' . $TargetURL;
    if (isset($QUERY_STRING)) $TargetURL = $TargetURL . "?" . $QUERY_STRING;
    $user=getUserName();
    if (isset($user))
    {
        // words 'you are xxxx' becomes a link to the
        // report page with only entries created by xxx. Past entries are not
        // displayed but this can be changed
       	$search_string = "report.php?From_day=$day&From_month=$month&".
          "From_year=$year&To_day=1&To_month=12&To_year=2030&areamatch=&".
          "roommatch=&namematch=&descrmatch=&summarize=1&sortby=r&display=d&".
          "sumby=d&creatormatch=$user"; ?>

              <TD CLASS="banner" BGCOLOR="#C0E0FF" ALIGN=CENTER>
                <A name="logonBox" href="<?php echo "$search_string\" title=\""
         . get_string('show_my_entries','block_mrbs') . "\">" . get_string('you_are','block_mrbs')." "
         .$user ?></A><br>
                <FORM METHOD=POST ACTION="<?php echo $CFG->wwwroot.'/login/logout.php'?>">
	          <input type="hidden" name="TargetURL" value="<?php echo $TargetURL ?>" />
	          <input type="hidden" name="Action" value="SetName" />
	          <input type="hidden" name="NewUserName" value="" />
	          <input type="hidden" name="NewUserPassword" value="" />
	    <input type="submit" value=" <?php echo get_string('logout') ?> " />
                </FORM>
<?php if (isset($user_list_link)) print "
                <br>
                <A href=\"$user_list_link\">" . get_string('user_list') . "</A><br>\n";
?>
              </TD>
<?php
    }
else
    {
?>
              <TD CLASS="banner" BGCOLOR="#C0E0FF" ALIGN=CENTER>
	  <A name="logonBox" href=""><?php echo get_string('usernamenotfound'); ?></A><br>
                <FORM METHOD=POST ACTION="admin.php">
                  <input type="hidden" name="TargetURL" value="<?php echo $TargetURL ?>" />
                  <input type="hidden" name="Action" value="QueryName" />
	    <input type="submit" value=" <?php echo get_string('login') ?> " />
                </FORM>
<?php if (isset($user_list_link)) print "
	        <br>
                <A href=\"$user_list_link\">" . get_string('user_list') . "</A><br>\n";
?>
              </TD>
<?php
    }
}
?>
