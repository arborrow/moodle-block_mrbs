<?php
function list_system_locales(){
   ob_start();
   system('locale -a');
   $str = ob_get_contents();
   ob_end_clean();
   return split("\\n", trim($str));
}

$locale = "fr_FR.UTF8";
$locales = list_system_locales();

var_dump($locales);


?>