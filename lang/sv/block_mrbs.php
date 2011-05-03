<?php // -*-mode: PHP; coding:utf-8;-*-

// $Id: block_mrbs.php,v 1.1 2009/02/26 07:20:14 arborrow Exp $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is the Swedish file.
//
// Translated provede by: Bo Kleve (bok@unit.liu.se), MissterX
// Modified on 2006-01-04 by: Björn Wiberg <Bjorn.Wiberg@its.uu.se>
//
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$string["charset"]            = "utf-8";

// Used for Moodle
$string['blockname']          = 'Bokningssystem';
$string['accessmrbs']         = 'Schedule a Resource';

// Used in style.inc
$string["mrbs"]               = "MRBS - MötesRumsBokningsSystem";

// Used in functions.inc
$string["report"]             = "Rapport";
$string["admin"]              = "Admin";
$string["help"]               = "Hjälp";
$string["search"]             = "Sök";
$string["not_php3"]           = "VARNING: Detta fungerar förmodligen inte med PHP3";

// Used in day.php
$string["bookingsfor"]        = "Bokningar för";
$string["bookingsforpost"]    = "";
$string["areas"]              = "Områden";
$string["daybefore"]          = "Gå till föregående dag";
$string["dayafter"]           = "Gå till nästa dag";
$string["gototoday"]          = "Gå till idag";
$string["goto"]               = "Gå till";
$string["highlight_line"]     = "Markera denna rad";
$string["click_to_reserve"]   = "Klicka på cellen för att göra en bokning.";

// Used in trailer.inc
$string["viewday"]            = "Visa dag";
$string["viewweek"]           = "Visa vecka";
$string["viewmonth"]          = "Visa månad";
$string["ppreview"]           = "Förhandsgranska";

// Used in edit_entry.php
$string["addentry"]           = "Ny bokning";
$string["editentry"]          = "Ändra bokningen";
$string["editseries"]         = "Ändra serie";
$string["namebooker"]         = "Kort beskrivning";
$string["fulldescription"]    = "Fullständig beskrivning:";
$string["date"]               = "Datum";
$string["start_date"]         = "Starttid";
$string["end_date"]           = "Sluttid";
$string["time"]               = "Tid";
$string["period"]             = "Period";
$string["duration"]           = "Längd";
$string["seconds"]            = "sekunder";
$string["minutes"]            = "minuter";
$string["hours"]              = "timmar";
$string["days"]               = "dagar";
$string["weeks"]              = "veckor";
$string["years"]              = "år";
$string["periods"]            = "perioder";
$string["all_day"]            = "hela dagen";
$string["type"]               = "Typ";
$string["internal"]           = "Internt";
$string["external"]           = "Externt";
$string["save"]               = "Spara";
$string["rep_type"]           = "Repetitionstyp";
$string["rep_type_0"]         = "ingen";
$string["rep_type_1"]         = "dagligen";
$string["rep_type_2"]         = "varje vecka";
$string["rep_type_3"]         = "månatligen";
$string["rep_type_4"]         = "årligen";
$string["rep_type_5"]         = "Månadsvis, samma dag";
$string["rep_type_6"]         = "Veckovis";
$string["rep_end_date"]       = "Repetition slutdatum";
$string["rep_rep_day"]        = "Repetitionsdag";
$string["rep_for_weekly"]     = "(vid varje vecka)";
$string["rep_freq"]           = "Intervall";
$string["rep_num_weeks"]      = "Antal veckor";
$string["rep_for_nweekly"]    = "(För x-veckor)";
$string["ctrl_click"]         = "Håll ner tangenten <I>Ctrl</I> och klicka för att välja mer än ett rum";
$string["entryid"]            = "Boknings-ID ";
$string["repeat_id"]          = "Repetions-ID "; 
$string["you_have_not_entered"] = "Du har inte angivit";
$string["you_have_not_selected"] = "Du har inte valt";
$string["valid_room"]         = "ett giltigt rum.";
$string["valid_time_of_day"]  = "en giltig tidpunkt på dagen.";
$string["brief_description"]  = "en kort beskrivning.";
$string["useful_n-weekly_value"] = "ett användbart n-veckovist värde.";

// Used in view_entry.php
$string["description"]        = "Beskrivning";
$string["room"]               = "Rum";
$string["createdby"]          = "Skapad av";
$string["lastupdate"]         = "Senast uppdaterad";
$string["deleteentry"]        = "Radera bokningen";
$string["deleteseries"]       = "Radera serie";
$string["confirmdel"]         = "Är du säker att\\ndu vill radera\\nden här bokningen?\\n\\n";
$string["returnprev"]         = "Åter till föregående sida";
$string["invalid_entry_id"]   = "Ogiltigt boknings-ID!";
$string["invalid_series_id"]  = "Ogiltigt serie-ID!";

// Used in edit_entry_handler.php
$string["error"]              = "Fel";
$string["sched_conflict"]     = "Bokningskonflikt";
$string["conflict"]           = "Den nya bokningen krockar med följande bokning(ar)";
$string["too_may_entrys"]     = "De valda inställningarna skapar för många bokningar.<br>V.g. använd andra inställningar!";
$string["returncal"]          = "Återgå till kalendervy";
$string["failed_to_acquire"]  = "Kunde ej få exklusiv databasåtkomst"; 
$string["invalid_booking"]    = "Ogiltig bokning";
$string["must_set_description"] = "Du måste ange en kort beskrivning för bokningen. Vänligen gå tillbaka och korrigera detta.";

// Authentication stuff
$string["accessdenied"]       = "Åtkomst nekad";
$string["norights"]           = "Du har inte rättighet att ändra bokningen.";
$string["please_login"]       = "Vänligen logga in";
$string["user_name"]          = "Användarnamn";
$string["user_password"]      = "Lösenord";
$string["unknown_user"]       = "Okänd användare";
$string["you_are"]            = "Du är";
$string["login"]              = "Logga in";
$string["logoff"]             = "Logga ut";

// Authentication database
$string["user_list"]          = "Användarlista";
$string["edit_user"]          = "Editera användare";
$string["delete_user"]        = "Radera denna användare";
//$string["user_name"]         = Use the same as above, for consistency.
//$string["user_password"]     = Use the same as above, for consistency.
$string["user_email"]         = "E-postadress";
$string["password_twice"]     = "Om du vill ändra ditt lösenord, vänligen mata in detta två gånger";
$string["passwords_not_eq"]   = "Fel: Lösenorden stämmer inte överens.";
$string["add_new_user"]       = "Lägg till användare";
$string["rights"]             = "Rättigheter";
$string["action"]             = "Aktion";
$string["user"]               = "Användare";
$string["administrator"]      = "Administratör";
$string["unknown"]            = "Okänd";
$string["ok"]                 = "OK";
$string["show_my_entries"]    = "Klicka för att visa alla dina aktuella bokningar";
$string["no_users_initial"]   = "Inga användare finns i databasen. Tillåter initialt skapande av användare.";
$string["no_users_create_first_admin"] = "Skapa en administrativ användare först. Därefter kan du logga in och skapa fler användare.";

// Used in search.php
$string["invalid_search"]     = "Tom eller ogiltig söksträng.";
$string["search_results"]     = "Sökresultat för";
$string["nothing_found"]      = "Inga sökträffar hittades.";
$string["records"]            = "Bokning ";
$string["through"]            = " t.o.m. ";
$string["of"]                 = " av ";
$string["previous"]           = "Föregående";
$string["next"]               = "Nästa";
$string["entry"]              = "Bokning";
$string["view"]               = "Visa";
$string["advanced_search"]    = "Avancerad sökning";
$string["search_button"]      = "Sök";
$string["search_for"]         = "Sök för";
$string["from"]               = "Från";

// Used in report.php
$string["report_on"]          = "Rapport över möten";
$string["report_start"]       = "Startdatum för rapport";
$string["report_end"]         = "Slutdatum för rapport";
$string["match_area"]         = "Sök på plats";
$string["match_room"]         = "Sök på rum";
$string["match_type"]         = "Sök på bokningstyp";
$string["ctrl_click_type"]    = "Håll ner tangenten <I>Ctrl</I> och klicka för att välja fler än en typ";
$string["match_entry"]        = "Sök på kort beskrivning";
$string["match_descr"]        = "Sök på fullständig beskrivning";
$string["include"]            = "Inkludera";
$string["report_only"]        = "Endast rapport";
$string["summary_only"]       = "Endast sammanställning";
$string["report_and_summary"] = "Rapport och sammanställning";
$string["summarize_by"]       = "Sammanställ på";
$string["sum_by_descrip"]     = "Kort beskrivning";
$string["sum_by_creator"]     = "Skapare";
$string["entry_found"]        = "bokning hittad";
$string["entries_found"]      = "bokningar hittade";
$string["summary_header"]     = "Sammanställning över (bokningar) timmar";
$string["summary_header_per"] = "Sammanställning över (bokningar) perioder";
$string["total"]              = "Totalt";
$string["submitquery"]        = "Skapa rapport";
$string["sort_rep"]           = "Sortera rapport efter";
$string["sort_rep_time"]      = "Startdatum/starttid";
$string["rep_dsp"]            = "Visa i rapport";
$string["rep_dsp_dur"]        = "Längd";
$string["rep_dsp_end"]        = "Sluttid";

// Used in week.php
$string["weekbefore"]         = "Föregående vecka";
$string["weekafter"]          = "Nästa vecka";
$string["gotothisweek"]       = "Denna vecka";

// Used in month.php
$string["monthbefore"]        = "Föregående månad";
$string["monthafter"]         = "Nästa månad";
$string["gotothismonth"]      = "Denna månad";

// Used in {day week month}.php
$string["no_rooms_for_area"]  = "Rum saknas för denna plats";

// Used in admin.php
$string["edit"]               = "Ändra";
$string["delete"]             = "Radera";
$string["rooms"]              = "Rum";
$string["in"]                 = "i";
$string["noareas"]            = "Inget område";
$string["addarea"]            = "Lägg till område";
$string["name"]               = "Namn";
$string["noarea"]             = "Inget område valt";
$string["browserlang"]        = "Din webbläsare är inställd att använda språk(en)";
$string["addroom"]            = "Lägg till rum";
$string["capacity"]           = "Kapacitet";
$string["norooms"]            = "Inga rum.";
$string["administration"]     = "Administration";

// Used in edit_area_room.php
$string["editarea"]           = "Ändra område";
$string["change"]             = "Ändra";
$string["backadmin"]          = "Tillbaka till Administration";
$string["editroomarea"]       = "Ändra område eller rum";
$string["editroom"]           = "Ändra rum";
$string["update_room_failed"] = "Uppdatering av rum misslyckades: ";
$string["error_room"]         = "Fel: rum ";
$string["not_found"]          = " hittades ej";
$string["update_area_failed"] = "Uppdatering av område misslyckades: ";
$string["error_area"]         = "Fel: område";
$string["room_admin_email"]   = "E-postadress till rumsansvarig";
$string["area_admin_email"]   = "E-postadress till områdesansvarig";
$string["invalid_email"]      = "Ogiltig e-postadress!";

// Used in del.php
$string["deletefollowing"]    = "Detta raderar följande bokningar";
$string["sure"]               = "Är du säker?";
$string["YES"]                = "JA";
$string["NO"]                 = "NEJ";
$string["delarea"]            = "Du måste ta bort alla rum i detta område innan du kan ta bort området!<p>";
$string["backadmin"]          = "Tillbaka till Administration";

// Used in help.php
$string["about_mrbs"]         = "Om MRBS";
$string["database"]           = "Databas";
$string["system"]             = "System";
$string["please_contact"]     = "Var vänlig kontakta ";
$string["for_any_questions"]  = "för eventuella frågor som ej besvaras här.";

// Used in mysql.inc AND pgsql.inc
$string["failed_connect_db"]  = "Fatalt fel: Kunde ej ansluta till databasen!";

?>
