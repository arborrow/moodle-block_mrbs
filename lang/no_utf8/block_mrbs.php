<?php // -*-mode: PHP; coding:utf-8;-*-

// $Id: block_mrbs.php,v 1.1 2009/02/26 07:20:13 arborrow Exp $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is the Norwegian file.
//
// Translations provided by: Rune Johansen (rune.johansen@finedamer.com)
// Further translated by: Emil Støa (emil@consider.no)
//
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$string["charset"]            = "utf-8";

// Used for Moodle
$string['blockname'] = 'Møteromsbooking';
$string['accessmrbs'] = 'Schedule a Resource';

// Used in style.inc
$string["mrbs"]               = "Møteromsbooking";

// Used in functions.inc
$string["report"]             = "Rapport";
$string["admin"]              = "Admin";
$string["help"]               = "Hjelp";
$string["search"]             = "Søk";
$string["not_php3"]           = "NB: Dette virker sannsynligvis ikke med PHP3";

// Used in day.php
$string["bookingsfor"]        = "Booking for";
$string["bookingsforpost"]    = "";
$string["areas"]              = "Område";
$string["daybefore"]          = "Gå til forrige dag";
$string["dayafter"]           = "Gå til neste dag";
$string["gototoday"]          = "Gå til idag";
$string["goto"]               = "gå til";
$string["highlight_line"]     = "Merk denne linjen";
$string["click_to_reserve"]   = "Trykk i cellen for å reservere.";

// Used in trailer.inc
$string["viewday"]            = "Vis dag";
$string["viewweek"]           = "Vis Uke";
$string["viewmonth"]          = "Vis Måned";
$string["ppreview"]           = "Forhåndsvisning";

// Used in edit_entry.php
$string["addentry"]           = "Booking";
$string["editentry"]          = "Endre booking";
$string["editseries"]         = "Endre serie";
$string["namebooker"]         = "Kort beskrivelse";
$string["fulldescription"]    = "Lang beskrivelse:<br>&nbsp;&nbsp;(Antall personer,<br>&nbsp;&nbsp;Internt/Eksternt osv)";
$string["date"]               = "Dato";
$string["start_date"]         = "Starttid";
$string["end_date"]           = "Sluttid";
$string["time"]               = "Tid";
$string["period"]             = "Period";
$string["duration"]           = "Lengde";
$string["seconds"]            = "sekunder";
$string["minutes"]            = "minutter";
$string["hours"]              = "timer";
$string["days"]               = "dager";
$string["weeks"]              = "uker";
$string["years"]              = "år";
$string["periods"]            = "periods";
$string["all_day"]            = "hele dagen";
$string["type"]               = "Type";
$string["internal"]           = "Internt";
$string["external"]           = "Eksternt";
$string["save"]               = "Lagre";
$string["rep_type"]           = "Repetisjonstype";
$string["rep_type_0"]         = "ingen";
$string["rep_type_1"]         = "daglig";
$string["rep_type_2"]         = "ukentlig";
$string["rep_type_3"]         = "månedlig";
$string["rep_type_4"]         = "årlig";
$string["rep_type_5"]         = "Månedlig, samme dag";
$string["rep_type_6"]         = "n-ukentlig";
$string["rep_end_date"]       = "Repetisjon sluttdato";
$string["rep_rep_day"]        = "Repetisjonsdag";
$string["rep_for_weekly"]     = "(ved hver uke)";
$string["rep_freq"]           = "Frekvens";
$string["rep_num_weeks"]      = "Antall uker";
$string["rep_for_nweekly"]    = "(for n-uker)";
$string["ctrl_click"]         = "Hold inne kontrolltasten for å velge mer enn ett rom";
$string["entryid"]            = "Booking ID ";
$string["repeat_id"]          = "Repetisjons ID "; 
$string["you_have_not_entered"] = "Du har ikke angitt";
$string["you_have_not_selected"] = "Du har ikke valgt ";
$string["valid_room"]         = "ett rom.";
$string["valid_time_of_day"]  = "ett gyldig tidspunkt.";
$string["brief_description"]  = "en kort beskrivelse.";
$string["useful_n-weekly_value"] = "en gyldig verdi for antall uker.";

// Used in view_entry.php
$string["description"]        = "Beskrivelse";
$string["room"]               = "Rom";
$string["createdby"]          = "Laget av";
$string["lastupdate"]         = "Senest oppdatert";
$string["deleteentry"]        = "Slett booking";
$string["deleteseries"]       = "Slett serie";
$string["confirmdel"]         = "Er du sikker på at\\ndu vil slette bookingen?\\n\\n";
$string["returnprev"]         = "Tilbake til forrige side";
$string["invalid_entry_id"]   = "Ugyldig booking-ID.";
$string["invalid_series_id"]  = "Ugyldig serie-ID.";

// Used in edit_entry_handler.php
$string["error"]              = "Feil";
$string["sched_conflict"]     = "Bookingkonflikt";
$string["conflict"]           = "Bookingen er i konflikt med følgende booking(er)";
$string["too_may_entrys"]     = "De valgte instillinger skaper for mange bookinger.<br>Vennligst bruk andre instillinger!";
$string["returncal"]          = "Tilbake til kalender";
$string["failed_to_acquire"]  = "Kunne ikke oppnå eksklusiv databasetilgang"; 

// Authentication stuff
$string["accessdenied"]       = "Ingen adgang";
$string["norights"]           = "Du har ingen rettigheter til å endre bookingen.";
$string["please_login"]       = "Vennligst logg inn";
$string["user_name"]          = "Navn";
$string["user_password"]      = "Passord";
$string["unknown_user"]       = "Ukjent bruker";
$string["you_are"]            = "Bruker: ";
$string["login"]              = "Logg inn";
$string["logoff"]             = "Logg ut";

// Authentication database
$string["user_list"]          = "Brukerliste";
$string["edit_user"]          = "Rediger bruker";
$string["delete_user"]        = "Slett denne brukeren";
//$string["user_name"]         = Use the same as above, for consistency.
//$string["user_password"]     = Use the same as above, for consistency.
$string["user_email"]         = "Epost-addresse";
$string["password_twice"]     = "Hvis du vil endre passordet, skriv det nye passordet to ganger";
$string["passwords_not_eq"]   = "Feil: Passordene er ikke like.";
$string["add_new_user"]       = "Legg til ny bruker";
$string["rights"]             = "Rettigheter";
$string["action"]             = "Valg";
$string["user"]               = "Bruker";
$string["administrator"]      = "Administrator";
$string["unknown"]            = "Ukjent";
$string["ok"]                 = "OK";
$string["show_my_entries"]    = "Trykk for å vise kommende innlegg";

// Used in search.php
$string["invalid_search"]     = "Tom eller ugyldig søkestreng.";
$string["search_results"]     = "Søkeresultat for";
$string["nothing_found"]      = "Ingen poster ble funnet.";
$string["records"]            = "Booking ";
$string["through"]            = " til ";
$string["of"]                 = " av ";
$string["previous"]           = "Forrige";
$string["next"]               = "Neste";
$string["entry"]              = "Post";
$string["view"]               = "Vis";
$string["advanced_search"]    = "Avansert søk";
$string["search_button"]      = "Søk";
$string["search_for"]         = "Søk etter";
$string["from"]               = "Fra";

// Used in report.php
$string["report_on"]          = "Rapport";
$string["report_start"]       = "Start dato";
$string["report_end"]         = "Slutt dato";
$string["match_area"]         = "Område";
$string["match_room"]         = "Rom";
$string["match_type"]         = "Velg type";
$string["ctrl_click_type"]    = "Bruk CTRL-tasten for å velge fler enn en type";
$string["match_entry"]        = "Kort beskrivelse";
$string["match_descr"]        = "Lang beskrivelse";
$string["include"]            = "Skal inneholde";
$string["report_only"]        = "Bare rapport";
$string["summary_only"]       = "Summering";
$string["report_and_summary"] = "Rapport og Summering";
$string["summarize_by"]       = "Summering etter";
$string["sum_by_descrip"]     = "Kort beskrivelse";
$string["sum_by_creator"]     = "Hvem som booket";
$string["entry_found"]        = "post funnet";
$string["entries_found"]      = "poster funnet";
$string["summary_header"]     = "Sum timer";
$string["summary_header_per"] = "Summary of (Entries) Periods";
$string["total"]              = "Totalt";
$string["submitquery"]        = "Kjør rapport";
$string["sort_rep"]           = "Sorter rapport etter";
$string["sort_rep_time"]      = "Dato/Tid";
$string["rep_dsp"]            = "Vis i rapport";
$string["rep_dsp_dur"]        = "Varighet";
$string["rep_dsp_end"]        = "Slutt-tid";

// Used in week.php
$string["weekbefore"]         = "Gå til uken før";
$string["weekafter"]          = "Gå til uken etter";
$string["gotothisweek"]       = "Gå til denne uken";

// Used in month.php
$string["monthbefore"]        = "Gå til forrige måned";
$string["monthafter"]         = "Gå til neste måned";
$string["gotothismonth"]      = "Gå til denne måneden";

// Used in {day week month}.php
$string["no_rooms_for_area"]  = "Ingen rom definert for dette området";

// Used in admin.php
$string["edit"]               = "Endre";
$string["delete"]             = "Slett";
$string["rooms"]              = "Rom";
$string["in"]                 = "i";
$string["noareas"]            = "Ingen områder";
$string["addarea"]            = "Legg til område";
$string["name"]               = "Navn";
$string["noarea"]             = "Område ikke valgt";
$string["browserlang"]        = "Din nettleser er satt opp til å bruke følgende språk";
$string["addroom"]            = "Legg til rom";
$string["capacity"]           = "Kapasitet";
$string["norooms"]            = "Ingen rom.";
$string["administration"]     = "Administration";

// Used in edit_area_room.php
$string["editarea"]           = "Endre område";
$string["change"]             = "Endre";
$string["backadmin"]          = "Tilbake til admin";
$string["editroomarea"]       = "Endre område- eller rombeskrivelse";
$string["editroom"]           = "Endre rom";
$string["update_room_failed"] = "Oppdatering av rom feilet: ";
$string["error_room"]         = "Feil: rom ";
$string["not_found"]          = " ble ikke funnet";
$string["update_area_failed"] = "Oppdatering av område feilet: ";
$string["error_area"]         = "Feil: område ";
$string["room_admin_email"]   = "Rom-administrators E-post";
$string["area_admin_email"]   = "Område-administrators E-post";
$string["invalid_email"]      = "Ugyldig E-post!";

// Used in del.php
$string["deletefollowing"]    = "Dette vil slette følgende bookinger";
$string["sure"]               = "Er du sikker?";
$string["YES"]                = "JA";
$string["NO"]                 = "NEI";
$string["delarea"]            = "Du må slette alle rommene i dette området før du kan slette det<p>";

// Used in help.php
$string["about_mrbs"]         = "Om MRBS";
$string["database"]           = "Database";
$string["system"]             = "System";
$string["please_contact"]     = "Vennligst ta kontakt med ";
$string["for_any_questions"]  = "for spørsmål som ikke er besvart her.";

// Used in mysql.inc AND pgsql.inc
$string["failed_connect_db"]  = "Alvorlig feil: Kunne ikke koble til database";

?>
