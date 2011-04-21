<?php

# This should probably be a class, but you can only have protected
# class members in PHP 5, so we won't bother
require_once("../../../config.php"); //for Moodle integration
function get_mrbs_version()
{
  # MRBS developers, make sure to update this string before each release
  $mrbs_version = "MRBS 1.2.5";

  return $mrbs_version;
}

?>
