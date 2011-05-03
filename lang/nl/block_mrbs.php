<?php // -*-mode: PHP; coding:utf-8;-*-

// $Id: block_mrbs.php,v 1.1 2009/02/26 07:20:13 arborrow Exp $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is an NL Dutch file.
//
// Translations provided by: Marc ter Horst
//
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$string["charset"]            = "utf-8";

// Used for Moodle
$string['blockname'] = 'Boekingssysteem';
$string['accessmrbs'] = 'Boekingen van Resources';

// Used in style.inc
$string["mrbs"]               = "Vergaderruimte Boekingssysteem";

// Used in functions.inc
$string["report"]             = "Rapportage";
$string["admin"]              = "Beheer";
$string["help"]               = "Help";
$string["search"]             = "Zoek";
$string["not_php3"]           = "Waarschuwing: Werkt waarschijnlijk niet met PHP3";

// Used in day.php
$string["bookingsfor"]        = "Boekingen voor";
$string["bookingsforpost"]    = "";
$string["areas"]              = "Gebouwen";
$string["daybefore"]          = "Naar Vorige Dag";
$string["dayafter"]           = "Naar Volgende Dag";
$string["gototoday"]          = "Naar Vandaag";
$string["goto"]               = "ga naar";
$string["highlight_line"]     = "Markeer deze regel";
$string["click_to_reserve"]   = "Klik op dit vak om een reservering te maken.";

// Used in trailer.inc
$string["viewday"]            = "Bekijk Dag";
$string["viewweek"]           = "Bekijk Week";
$string["viewmonth"]          = "Bekijk Maand";
$string["ppreview"]           = "Afdruk Voorbeeld";

// Used in edit_entry.php
$string["addentry"]           = "Boeking Toevoegen";
$string["editentry"]          = "Boeking Wijzigen";
$string["copyentry"]          = "Kopiëer Boeking";
$string["editseries"]         = "Wijzig Reeks";
$string["copyseries"]         = "Kopiëer Serie";
$string["namebooker"]         = "Korte Omschrijving";
$string["fulldescription"]    = "Volledige Omschrijving:<br>&nbsp;&nbsp;(Aantal mensen,<br>&nbsp;&nbsp;Intern/Extern etc)";
$string["date"]               = "Datum";
$string["start_date"]         = "Start Tijd";
$string["end_date"]           = "Eind Tijd";
$string["time"]               = "Tijd";
$string["period"]             = "Periode";
$string["duration"]           = "Tijdsduur";
$string["seconds"]            = "seconden";
$string["minutes"]            = "minuten";
$string["hours"]              = "uren";
$string["days"]               = "dagen";
$string["weeks"]              = "weken";
$string["years"]              = "jaren";
$string["periods"]            = "Perioden";
$string["all_day"]            = "Hele Dag";
$string["type"]               = "Soort";
$string["internal"]           = "Intern";
$string["external"]           = "Extern";
$string["save"]               = "Opslaan";
$string["rep_type"]           = "Soort Herhaling";
$string["rep_type_0"]         = "Geen";
$string["rep_type_1"]         = "Dagelijks";
$string["rep_type_2"]         = "Wekelijks";
$string["rep_type_3"]         = "Maandelijks";
$string["rep_type_4"]         = "Jaarlijks";
$string["rep_type_5"]         = "Maandelijks, Overeenkomstige dag";
$string["rep_type_6"]         = "n-wekelijks";
$string["rep_end_date"]       = "Einde herhaling datum";
$string["rep_rep_day"]        = "Herhalingsdag";
$string["rep_for_weekly"]     = "(t.b.v. wekelijks)";
$string["rep_freq"]           = "Frequentie";
$string["rep_num_weeks"]      = "Aantal weken";
$string["rep_for_nweekly"]    = "(Voor n-wekelijks)";
$string["ctrl_click"]         = "Gebruik Control-Linker muis klik om meer dan 1 ruimte te reserveren";
$string["entryid"]            = "Boeking-ID ";
$string["repeat_id"]          = "Herhalings-ID "; 
$string["you_have_not_entered"] = "U heeft het volgende niet ingevoerd : ";
$string["you_have_not_selected"] = "U heeft het volgende niet geselecteerd : ";
$string["valid_room"]         = "kamer.";
$string["valid_time_of_day"]  = "geldige tijd.";
$string["brief_description"]  = "Korte Omschrijving.";
$string["useful_n-weekly_value"] = "bruikbaar n-wekelijks aantal.";

// Used in view_entry.php
$string["description"]        = "Omschrijving";
$string["room"]               = "Kamer";
$string["createdby"]          = "Aangemaakt door";
$string["lastupdate"]         = "Laatste aanpassing";
$string["deleteentry"]        = "Boeking verwijderen";
$string["deleteseries"]       = "Herhalingen verwijderen";
$string["confirmdel"]         = "Weet U zeker\\ndat U deze\\nBoeking wilt verwijderen?\\n\\n";
$string["returnprev"]         = "Terug naar vorige pagina";
$string["invalid_entry_id"]   = "Ongeldig Boeking-ID.";
$string["invalid_series_id"]  = "Ongeldig Herhalings-ID.";

// Used in edit_entry_handler.php
$string["error"]              = "Fout";
$string["sched_conflict"]     = "Overlappende Boeking";
$string["conflict"]           = "De nieuwe boeking overlapt de volgende boeking(en)";
$string["too_may_entrys"]     = "De door U geselecteerde opties zullen teveel boekingen genereren.<br>Pas A.U.B. uw opties aan !";
$string["returncal"]          = "Terug naar kalender overzicht";
$string["failed_to_acquire"]  = "Het is niet gelukt om exclusive toegang tot de database te verkrijgen"; 
$string["invalid_booking"]    = "Verkeerde boeking";
$string["must_set_description"] = "Er moet een korte omschrijving worden gegeven. Ga terug een en geef korte omschrijving.";
$string["mail_subject_entry"] = "Boeking toegevoegd/aangepast voor Uw Organisatie MRBS";
$string["mail_body_new_entry"] = "Er is een nieuwe boeking geplaatst, dit zijn de details:";
$string["mail_body_del_entry"] = "Er is een boeking verdwijderd, dit zijn de details:";
$string["mail_body_changed_entry"] = "Een boeking is gewijzigd, dit zijn de details:";
$string["mail_subject_delete"] = "Boeking gewist voor Uw Organisatie MRBS";

// Authentication stuff
$string["accessdenied"]       = "Geen Toegang";
$string["norights"]           = "U heeft geen rechten om deze boeking aan te passen.";
$string["please_login"]       = "Inloggen A.U.B";
$string["user_name"]          = "Naam";
$string["user_password"]      = "Wachtwoord";
$string["unknown_user"]       = "Onbekende gebruiker";
$string["you_are"]            = "U bent";
$string["login"]              = "Inloggen";
$string["logoff"]             = "Uitloggen";

// Authentication database
$string["user_list"]          = "Gebruikerslijst";
$string["edit_user"]          = "Gebruiker aanpassen";
$string["delete_user"]        = "Deze gebruiker verwijderen";
//$string["user_name"]         = Use the same as above, for consistency.
//$string["user_password"]     = Use the same as above, for consistency.
$string["user_email"]         = "Email adres";
$string["password_twice"]     = "Als u het wachtwoord wilt wijzigen dient u het nieuwe wachtwoord tweemaal in te voeren.";
$string["passwords_not_eq"]   = "Fout: De wachtwoorden komen niet overeen.";
$string["add_new_user"]       = "Nieuwe gebruiker toevoegen";
$string["rights"]             = "Rechten";
$string["action"]             = "Handelingen";
$string["user"]               = "Gebruiker";
$string["administrator"]      = "Beheerder";
$string["unknown"]            = "Onbekend";
$string["ok"]                 = "OK";
$string["show_my_entries"]    = "Klikken om al mijn aankomende boekingen te tonen.";
$string["no_users_initial"]   = "Geen gebruiker in de database, aanmaken basis gebruiker toegestaan";
$string["no_users_create_first_admin"] = "Maak een gebruiker aan als administrator; daarna kun je inloggen en andere gebruikers aanmaken.";

// Used in search.php
$string["invalid_search"]     = "Niet bestaand of ongeldig zoek argument.";
$string["search_results"]     = "Zoek resultaten voor";
$string["nothing_found"]      = "Geen resultaten voor uw zoek opdracht gevonden.";
$string["records"]            = "Boekingregels ";
$string["through"]            = " tot en met ";
$string["of"]                 = " van ";
$string["previous"]           = "Vorige";
$string["next"]               = "Volgende";
$string["entry"]              = "Boeking";
$string["view"]               = "Overzicht";
$string["advanced_search"]    = "Uitgebreid Zoeken";
$string["search_button"]      = "Zoek";
$string["search_for"]         = "Zoeken naar";
$string["from"]               = "Van";

// Used in report.php
$string["report_on"]          = "Boekingsoverzicht";
$string["report_start"]       = "Start datum overzicht";
$string["report_end"]         = "Eind datum overzicht";
$string["match_area"]         = "Gebied als";
$string["match_room"]         = "Kamer als";
$string["match_type"]         = "Type als";
$string["ctrl_click_type"]    = "Gebruik Control-Linker muis klik om meer dan 1 type te selekteren";
$string["match_entry"]        = "Korte omschrijving als";
$string["match_descr"]        = "Volledige omschrijving als";
$string["include"]            = "Neem mee";
$string["report_only"]        = "Alleen overzicht";
$string["summary_only"]       = "Alleen samenvatting";
$string["report_and_summary"] = "Overzicht en samenvatting";
$string["summarize_by"]       = "Samenvatten volgens";
$string["sum_by_descrip"]     = "Korte omschrijving";
$string["sum_by_creator"]     = "Boeker";
$string["entry_found"]        = "boeking gevonden";
$string["entries_found"]      = "boekingen gevonden";
$string["summary_header"]     = "Totaal aan (geboekte) uren";
$string["summary_header_per"] = "Samenvatting van (Boekingen) Perioden";
$string["total"]              = "Totaal";
$string["submitquery"]        = "Rapport uitvoeren";
$string["sort_rep"]           = "Rapport sorteren op";
$string["sort_rep_time"]      = "Start Datum/Tijd";
$string["rep_dsp"]            = "Weergeven in rapport";
$string["rep_dsp_dur"]        = "Duur";
$string["rep_dsp_end"]        = "Eind Tijd";

// Used in week.php
$string["weekbefore"]         = "Ga naar vorige week";
$string["weekafter"]          = "Ga naar volgende week";
$string["gotothisweek"]       = "Ga naar deze week";

// Used in month.php
$string["monthbefore"]        = "Ga naar vorige maand";
$string["monthafter"]         = "Ga naar volgende maand";
$string["gotothismonth"]      = "Ga naar deze maand";

// Used in {day week month}.php
$string["no_rooms_for_area"]  = "Nog geen kamers gedefiniëerd voor dit gebouw";

// Used in admin.php
$string["edit"]               = "Wijzig";
$string["delete"]             = "Wis";
$string["rooms"]              = "Kamers";
$string["in"]                 = "in";
$string["noareas"]            = "Gebouwen";
$string["addarea"]            = "Gebouw toevoegen";
$string["name"]               = "Naam";
$string["noarea"]             = "Geen gebouw geselecteerd";
$string["browserlang"]        = "Uw browser is ingesteld op ";
$string["addroom"]            = "Kamer toevoegen";
$string["capacity"]           = "Zitplaatsen";
$string["norooms"]            = "Geen Kamers.";
$string["administration"]     = "Beheer";

// Used in edit_area_room.php
$string["editarea"]           = "Gebouw Wijzigen";
$string["change"]             = "Wijzig";
$string["backadmin"]          = "Terug naar Beheer";
$string["editroomarea"]       = "Gebouw of Kamer wijzigen";
$string["editroom"]           = "Kamer wijzigen";
$string["update_room_failed"] = "Wijzigen kamer mislukt: ";
$string["error_room"]         = "Fout: kamer ";
$string["not_found"]          = " niet gevonden";
$string["update_area_failed"] = "Wijzigen gebouw mislukt: ";
$string["error_area"]         = "Fout: gebouw ";
$string["room_admin_email"]   = "Kamer beheer email";
$string["area_admin_email"]   = "Gebouw beheer email";
$string["invalid_email"]      = "Ongeldig email adres !";

// Used in del.php
$string["deletefollowing"]    = "U gaat hiermee de volgende boekingen verwijderen";
$string["sure"]               = "Weet U het zeker?";
$string["YES"]                = "JA";
$string["NO"]                 = "NEE";
$string["delarea"]            = "U moet alle kamers in dit gebouw verwijderen voordat U het kunt verwijderen<p>";

// Used in help.php
$string["about_mrbs"]         = "Over MRBS";
$string["database"]           = "Database";
$string["system"]             = "Systeem";
$string["please_contact"]     = "Neem contact op met ";
$string["servertime"]         = "Datum en tijd op de Server";
$string["for_any_questions"]  = "Voor alle vragen die hier niet worden beantwoord.";

// Used in mysql.inc AND pgsql.inc
$string["failed_connect_db"]  = "Fatale Fout: Verbinding naar database server mislukt";

?>
