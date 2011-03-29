<?PHP  // $Id: phpinfo2.php,v 1.1 2007/04/05 22:25:33 arborrow Exp $
       // phpinfo.php - shows phpinfo for the current server

    require_once("../../../config.php"); //for Moodle integration
    $topframe    = optional_param('topframe', false, PARAM_BOOL);
    $bottomframe = optional_param('bottomframe', false, PARAM_BOOL);

    require_login();

    if (!isadmin()) {
        error("Only the admin can use this page");
    }

require_once "grab_globals.inc.php";
include "config.inc.php";
include "functions.php";
include "$dbsys.php";
include "mrbs_auth.php";
include "mincals.php";

    if (!$topframe && !$bottomframe) {
        ?>

        <head>
        <title>PHP info</title>
        </head>

        <frameset rows="80,*">
           <frame src="phpinfo2.php?topframe=true&amp;sesskey=<?php echo $USER->sesskey ?>">
           <frame src="phpinfo2.php?bottomframe=true&amp;sesskey=<?php echo $USER->sesskey ?>">
        </frameset>

        <?php
    } else if ($topframe && confirm_sesskey()) {
        $stradministration = get_string("administration");
        $site = get_site();

        print_header_mrbs("$site->shortname: phpinfo", "$site->fullname",
                     "<a target=\"$CFG->framename\" href=\"index.php\">$stradministration</a> -> PHP info");
        exit;
    } else if ($bottomframe && confirm_sesskey()) {
        phpinfo();
        exit;
    }
?>
