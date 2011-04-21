<?php

function print_user_header_mrbs($day=NULL, $month=NULL, $year=NULL, $area=NULL) //if values are not passed assume NULL
{
    global $mrbs_company, $mrbs_company_url, $search_str, $locale_warning;
    $cfg_mrbs=get_config('block/mrbs');
    $strmrbs = get_string('blockname','block_mrbs');

    if(!$site = get_site()) {
        redirect($CFG->wwwroot.'/'.$CFG->admin.'/index.php');
    }


    $navlinks = array();
    $navlinks[] = array('name' => $strmrbs,
                        'link' =>$cfgmrbs->serverpath.'index.php',
                        'type' => 'misc');
    $pagetitle = '';
    $navigation = build_navigation($navlinks);
    print_header("$site->shortname: $strmrbs: $pagetitle", $strmrbs, $navigation,
                 '', '', true, '', user_login_string($site));
    
    
    # If we dont know the right date then make it up 
    if(!$day)
        $day   = date("d");
    if(!$month)
        $month = date("m");
    if(!$year)
        $year  = date("Y");
    if (empty($search_str))
        $search_str = "";
/*
    if ($unicode_encoding)
    {
        header("Content-Type: text/html; charset=utf-8");
    }
    else
    {
        
        header("Content-Type: text/html; charset=".get_string('charset','block_mrbs'));
    }

    header("Pragma: no-cache");                          // HTTP 1.0
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
*/


/*<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
                      "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
  <HEAD>
*  
*/

?>

<?php
   include "style.php";
?>
 <TITLE><?php echo get_string('mrbs','block_mrbs') ?></TITLE>
    <SCRIPT LANGUAGE="JavaScript">

<!-- Begin

/*   Script inspired by "True Date Selector"
     Created by: Lee Hinder, lee.hinder@ntlworld.com 
     
     Tested with Windows IE 6.0
     Tested with Linux Opera 7.21, Mozilla 1.3, Konqueror 3.1.0
     
*/

function daysInFebruary (year){
  // February has 28 days unless the year is divisible by four,
  // and if it is the turn of the century then the century year
  // must also be divisible by 400 when it has 29 days
  return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}

//function for returning how many days there are in a month including leap years
function DaysInMonth(WhichMonth, WhichYear)
{
  var DaysInMonth = 31;
  if (WhichMonth == "4" || WhichMonth == "6" || WhichMonth == "9" || WhichMonth == "11")
    DaysInMonth = 30;
  if (WhichMonth == "2")
    DaysInMonth = daysInFebruary( WhichYear );
  return DaysInMonth;
}

//function to change the available days in a months
function ChangeOptionDays(formObj, prefix)
{
  var DaysObject = eval("formObj." + prefix + "day");
  var MonthObject = eval("formObj." + prefix + "month");
  var YearObject = eval("formObj." + prefix + "year");

  if (DaysObject.selectedIndex && DaysObject.options)
    { // The DOM2 standard way
    // alert("The DOM2 standard way");
    var DaySelIdx = DaysObject.selectedIndex;
    var Month = parseInt(MonthObject.options[MonthObject.selectedIndex].value);
    var Year = parseInt(YearObject.options[YearObject.selectedIndex].value);
    }
  else if (DaysObject.selectedIndex && DaysObject[DaysObject.selectedIndex])
    { // The legacy MRBS way
    // alert("The legacy MRBS way");
    var DaySelIdx = DaysObject.selectedIndex;
    var Month = parseInt(MonthObject[MonthObject.selectedIndex].value);
    var Year = parseInt(YearObject[YearObject.selectedIndex].value);
    }
  else if (DaysObject.value)
    { // Opera 6 stores the selectedIndex in property 'value'.
    // alert("The Opera 6 way");
    var DaySelIdx = parseInt(DaysObject.value);
    var Month = parseInt(MonthObject.options[MonthObject.value].value);
    var Year = parseInt(YearObject.options[YearObject.value].value);
    }

  // alert("Day="+(DaySelIdx+1)+" Month="+Month+" Year="+Year);

  var DaysForThisSelection = DaysInMonth(Month, Year);
  var CurrentDaysInSelection = DaysObject.length;
  if (CurrentDaysInSelection > DaysForThisSelection)
  {
    for (i=0; i<(CurrentDaysInSelection-DaysForThisSelection); i++)
    {
      DaysObject.options[DaysObject.options.length - 1] = null
    }
  }
  if (DaysForThisSelection > CurrentDaysInSelection)
  {
    for (i=0; i<DaysForThisSelection; i++)
    {
      DaysObject.options[i] = new Option(eval(i + 1));
    }
  }
  if (DaysObject.selectedIndex < 0) DaysObject.selectedIndex = 0;
  if (DaySelIdx >= DaysForThisSelection)
    DaysObject.selectedIndex = DaysForThisSelection-1;
  else
    DaysObject.selectedIndex = DaySelIdx;
}

  //  End -->
    </SCRIPT>
  </HEAD>
  <BODY BGCOLOR="#ffffed" TEXT=black LINK="#5B69A6" VLINK="#5B69A6" ALINK=red>
       <?php if ( $GLOBALS["pview"] != 1 ) { ?>

   <?php # show a warning if this is using a low version of php
       if (substr(phpversion(), 0, 1) == 3)
           echo get_string('not_php3','block_mrbs');
       if (!empty($locale_warning))
               echo "[Warning: ".$locale_warning."]";
   ?>

    <TABLE WIDTH="100%">
      <TR>
        <TD BGCOLOR="#5B69A6">
          <TABLE WIDTH="100%" BORDER=0>
            <TR>
              <TD CLASS="banner" BGCOLOR="#C0E0FF">
          <FONT SIZE=4><B><a href='<?php echo $mrbs_company_url ?>'><?php echo $mrbs_company ?></a></B><BR>
           <?php echo get_string('mrbs','block_mrbs') ?>
                </FONT>
              </TD>
              <TD CLASS="banner" BGCOLOR="#C0E0FF">
                <FORM ACTION="userweek.php" METHOD=GET name="Form1">
                  <FONT SIZE=2>
<?php
   genDateSelector("", $day, $month, $year); // Note: The 1st arg must match the last arg in the call to ChangeOptionDays below.
   if (!empty($area))
        echo "
                    <INPUT TYPE=HIDDEN NAME=area VALUE=$area>\n"
 
?>
                <SCRIPT LANGUAGE="JavaScript">
                    <!--
                    // fix number of days for the $month/$year that you start with
                    ChangeOptionDays(document.Form1, ''); // Note: The 2nd arg must match the first in the call to genDateSelector above.
                    // -->
                    </SCRIPT>
        <INPUT TYPE=SUBMIT VALUE="<?php echo get_string('goto','block_mrbs') ?>">
                  </FONT>
                </FORM>
              </TD>


              <TD CLASS="banner" BGCOLOR="#C0E0FF" ALIGN=CENTER>
          <A HREF="help.php?day=<?php echo $day ?>&month=<?php echo $month ?>&year=<?php echo $year ?>"><?php echo get_string('help') ?></A>
              </TD>
             
<?php
    # For session protocols that define their own logon box...
#    if (function_exists('PrintLogonBox')) {
#        PrintLogonBox();
#       }
?>
            </TR>
          </TABLE>
        </TD>
      </TR>
    </TABLE>
<?php } ?>
<?php
}
?>