<?php  //$Id: settings.php,v 1.1.2.1 2008/05/09 21:32:07 arborrow Exp $


$settings->add(new admin_setting_configtext('block_mrbs_serverpath', get_string('serverpath', 'block_mrbs'),
                   get_string('adminview', 'block_mrbs'), $CFG->wwwroot.'/blocks/mrbs/web', PARAM_URL));

?>
