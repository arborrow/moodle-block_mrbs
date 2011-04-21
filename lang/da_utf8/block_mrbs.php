<?php // -*-mode: PHP; coding:utf-8;-*-

// $Id: block_mrbs.php,v 1.1 2009/02/26 07:20:13 arborrow Exp $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is the Danish file.
//
// Translations provided by: Claes Bolvig Pedersen (cp@dhi.dk)
//
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$string["charset"]            = "utf-8";

// Used for Moodle
$string['blockname'] = 'Bookning af møderum';
$string['accessmrbs'] = 'Booking ressources';

// Used in style.inc
$string["mrbs"]               = "Bookning af møderum, MRBS";

// Used in functions.inc
$string["report"]             = "Rapport";
$string["admin"]              = "Admin";
$string["help"]               = "Hjælp";
$string["search"]             = "Søg";
$string["not_php3"]           = "WARNING: This probably doesn't work with PHP3";

// Used in day.php
$string["bookingsfor"]        = "Booking for";
$string["bookingsforpost"]    = "";
$string["areas"]              = "Område";
$string["daybefore"]          = "Gå til forrige dag";
$string["dayafter"]           = "Gå til næste dag";
$string["gototoday"]          = "Gå til idag";
$string["goto"]               = "gå til";
$string["highlight_line"]     = "Highlight this line";
$string["click_to_reserve"]   = "Click on the cell to make a reservation.";

// Used in trailer.inc
$string["viewday"]            = "Vis dag";
$string["viewweek"]           = "Vis Uge";
$string["viewmonth"]          = "Vis Måned";
$string["ppreview"]           = "Forhåndsvisning";

// Used in edit_entry.php
$string["addentry"]           = "Booking";
$string["editentry"]          = "Ændre booking";
$string["editseries"]         = "Ændre serie";
$string["namebooker"]         = "Kort beskrivelse";
$string["fulldescription"]    = "Lang beskrivelse:<br>&nbsp;&nbsp;(Antal personer,<br>&nbsp;&nbsp;Internt/Eksternt osv)";
$string["date"]               = "Dato";
$string["start_date"]         = "Starttid";
$string["end_date"]           = "Sluttid";
$string["time"]               = "Tid";
$string["duration"]           = "Længde";
$string["period"]             = "Period";
$string["seconds"]            = "sekunder";
$string["minutes"]            = "minutter";
$string["hours"]              = "timer";
$string["days"]               = "dage";
$string["weeks"]              = "uger";
$string["years"]              = "år";
$string["periods"]            = "periods";
$string["all_day"]            = "hele dagen";
$string["type"]               = "Type";
$string["internal"]           = "Internt";
$string["external"]           = "Eksternt";
$string["save"]               = "Gem";
$string["rep_type"]           = "Repetitionstype";
$string["rep_type_0"]         = "ingen";
$string["rep_type_1"]         = "daglig";
$string["rep_type_2"]         = "ugentlig";
$string["rep_type_3"]         = "månedlig";
$string["rep_type_4"]         = "årlig";
$string["rep_type_5"]         = "Månedlig, samme dag";
$string["rep_type_6"]         = "n-ugentlig";
$string["rep_end_date"]       = "Repetitionsslutdato";
$string["rep_rep_day"]        = "Repetitionsdag";
$string["rep_for_weekly"]     = "(ved hver uge)";
$string["rep_freq"]           = "Frekvens";
$string["rep_num_weeks"]      = "Antal uger";
$string["rep_for_nweekly"]    = "(for n-uger)";
$string["ctrl_click"]         = "Hold kontroltasten nede for at vælge mere end et rum";
$string["entryid"]            = "Entry ID ";
$string["repeat_id"]          = "Repeat ID "; 
$string["you_have_not_entered"] = "Du har ikke indtastet et";
$string["you_have_not_selected"] = "You have not selected a";
$string["valid_room"]         = "room.";
$string["valid_time_of_day"]  = "validt tidspunkt.";
$string["brief_description"]  = "Kort beskrivelse.";
$string["useful_n-weekly_value"] = "nyttig n-ugentlig værdi.";

// Used in view_entry.php
$string["description"]        = "Beskrivelse";
$string["room"]               = "Rum";
$string["createdby"]          = "Gemt af";
$string["lastupdate"]         = "Senest opdateret";
$string["deleteentry"]        = "Slet bookning";
$string["deleteseries"]       = "Slet serie";
$string["confirmdel"]         = "Er du sikker på at\\ndu vil slette bookningen?\\n\\n";
$string["returnprev"]         = "Tilbage til forrige side";
$string["invalid_entry_id"]   = "Invalid entry id.";
$string["invalid_series_id"]  = "Invalid series id.";

// Used in edit_entry_handler.php
$string["error"]              = "Fejl";
$string["sched_conflict"]     = "Bookningskonflikt";
$string["conflict"]           = "Bookningen er i konflikt med følgende bookning(er)";
$string["too_may_entrys"]     = "De valgte instillinger skaber for mange bookninger.<br>Brug venligst andre indstillinger!";
$string["returncal"]          = "Tilbage til kalender";
$string["failed_to_acquire"]  = "Failed to acquire exclusive database access"; 

// Authentication stuff
$string["accessdenied"]       = "Ingen adgang";
$string["norights"]           = "Du har ingen rettighed til at ændre bookningen.";
$string["please_login"]       = "Please log in";
$string["user_name"]          = "Name";
$string["user_password"]      = "Password";
$string["unknown_user"]       = "Unknown user";
$string["you_are"]            = "You are";
$string["login"]              = "Log in";
$string["logoff"]             = "Log Off";

// Authentication database
$string["user_list"]          = "User list";
$string["edit_user"]          = "Edit user";
$string["delete_user"]        = "Delete this user";
//$string["user_name"]         = Use the same as above, for consistency.
//$string["user_password"]     = Use the same as above, for consistency.
$string["user_email"]         = "Email address";
$string["password_twice"]     = "If you wish to change the password, please type the new password twice";
$string["passwords_not_eq"]   = "Error: The passwords do not match.";
$string["add_new_user"]       = "Add a new user";
$string["rights"]             = "Rights";
$string["action"]             = "Action";
$string["user"]               = "User";
$string["administrator"]      = "Administrator";
$string["unknown"]            = "Unknown";
$string["ok"]                 = "OK";
$string["show_my_entries"]    = "Click to display all my upcoming entries";

// Used in search.php
$string["invalid_search"]     = "Tom eller ugyldig søgestreng.";
$string["search_results"]     = "Søgeresultat for";
$string["nothing_found"]      = "Ingen poster blev fundet.";
$string["records"]            = "Bookning ";
$string["through"]            = " til ";
$string["of"]                 = " af ";
$string["previous"]           = "Forrige";
$string["next"]               = "Næste";
$string["entry"]              = "Post";
$string["view"]               = "Vis";
$string["advanced_search"]    = "Avanceret søgning";
$string["search_button"]      = "Søg";
$string["search_for"]         = "Søg efter";
$string["from"]               = "Fra";

// Used in report.php
$string["report_on"]          = "Rapport";
$string["report_start"]       = "Start dato";
$string["report_end"]         = "Slut dato";
$string["match_area"]         = "Område";
$string["match_room"]         = "Rum";
$string["match_type"]         = "Match type";
$string["ctrl_click_type"]    = "Use Control-Click to select more than one type";
$string["match_entry"]        = "Kort beskrivelse";
$string["match_descr"]        = "Lang beskrivelse";
$string["include"]            = "Skal indeholde";
$string["report_only"]        = "Kun rapport";
$string["summary_only"]       = "Opsummering";
$string["report_and_summary"] = "Rapport og opsummering";
$string["summarize_by"]       = "Opsummering efter";
$string["sum_by_descrip"]     = "Kort beskrivelse";
$string["sum_by_creator"]     = "Hvem der har booket";
$string["entry_found"]        = "post fundet";
$string["entries_found"]      = "poster fundet";
$string["summary_header"]     = "Sum timer";
$string["summary_header_per"] = "Summary of (Entries) Periods";
$string["total"]              = "Total";
$string["submitquery"]        = "Kør rapport";
$string["sort_rep"]           = "Sort Report by";
$string["sort_rep_time"]      = "Start Date/Time";
$string["rep_dsp"]            = "Display in report";
$string["rep_dsp_dur"]        = "Duration";
$string["rep_dsp_end"]        = "End Time";

// Used in week.php
$string["weekbefore"]         = "Gå til ugen før";
$string["weekafter"]          = "Gå til ugen efter";
$string["gotothisweek"]       = "Gå til denne uge";

// Used in month.php
$string["monthbefore"]        = "Gå til forrige måned";
$string["monthafter"]         = "Gå til næste måned";
$string["gotothismonth"]      = "Gå til denne måned";

// Used in {day week month}.php
$string["no_rooms_for_area"]  = "Ingen rum er defineret for dette område";

// Used in admin.php
$string["edit"]               = "Ændre";
$string["delete"]             = "Slet";
$string["rooms"]              = "Rum";
$string["in"]                 = "i";
$string["noareas"]            = "Ingen områder";
$string["addarea"]            = "Tilføj område";
$string["name"]               = "Navn";
$string["noarea"]             = "Område ikke valgt";
$string["browserlang"]        = "Din browser er indstillet til at bruge følgende sprog";
$string["addroom"]            = "Tilføj rom";
$string["capacity"]           = "Kapacitet";
$string["norooms"]            = "Ingen rum.";
$string["administration"]     = "Administration";

// Used in edit_area_room.php
$string["editarea"]           = "Ændre område";
$string["change"]             = "Ændre";
$string["backadmin"]          = "Tilbage til admin";
$string["editroomarea"]       = "Ændre område- eller rumbeskrivelse";
$string["editroom"]           = "Ændre rom";
$string["update_room_failed"] = "Updater rum fejlet: ";
$string["error_room"]         = "Fejl: rum ";
$string["not_found"]          = " ikke fundet";
$string["update_area_failed"] = "Opdater område fejlet: ";
$string["error_area"]         = "Fejl: område ";
$string["room_admin_email"]   = "Room admin email";
$string["area_admin_email"]   = "Area admin email";
$string["invalid_email"]      = "Invalid email!";

// Used in del.php
$string["deletefollowing"]    = "Dette vil slette følgende bookninger";
$string["sure"]               = "Er du sikker?";
$string["YES"]                = "JA";
$string["NO"]                 = "NEJ";
$string["delarea"]            = "Du skal fjerne alle rum i dette område før du kan slette det<p>";

// Used in help.php
$string["about_mrbs"]         = "Om MRBS";
$string["database"]           = "Database";
$string["system"]             = "System";
$string["please_contact"]     = "Kontakt ";
$string["for_any_questions"]  = "for spørgsmål der ikke er besvaret her.";

// Used in mysql.inc AND pgsql.inc
$string["failed_connect_db"]  = "Fatal Error: Failed to connect to database";

?>
