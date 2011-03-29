<?php // -*-mode: PHP; coding:utf-8;-*-

// $Id : lang.fi,v 1.1 Thu Jan 30 2003 thierry_bo Exp $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is the Finnish version.
//
// Translation by Vesa Palmu ( vesa.palmu@no... ),
// 2005 Tom Ingberg (tom.ingberg@iki.fi.invalid)
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$string["charset"]            = "utf-8";

// Used for Moodle
$string['blockname'] = 'Booking system';
$string['accessmrbs'] = 'Schedule a Resource';

// Used in style.inc
$string["mrbs"]               = "Huonetilojen varausjärjestelmä";

// Used in functions.inc
$string["report"]             = "Raportit";
$string["admin"]              = "Ylläpito";
$string["help"]               = "Ohjeet";
$string["search"]             = "Etsi";
$string["not_php3"]           = "Varoitus: Järjestelmä ei välttämättä toimi PHP3:lla.";

// Used in day.php
$string["bookingsfor"]        = "Varaukset";
$string["bookingsforpost"]    = ""; // Goes after the date
$string["areas"]              = "Tilat";
$string["daybefore"]          = "Edelliseen päivään";
$string["dayafter"]           = "Seuraavaan päivään";
$string["gototoday"]          = "Tähän päivään";
$string["goto"]               = "mene";
$string["highlight_line"]     = "Korosta tämä rivi";
$string["click_to_reserve"]   = "Napsauta solua tehdäksesi varauksen.";

// Used in trailer.inc
$string["viewday"]            = "Näytä päivä";
$string["viewweek"]           = "Näytä viikko";
$string["viewmonth"]          = "Näytä kuukausi";
$string["ppreview"]           = "Tulostuksen esikatselu";

// Used in edit_entry.php
$string["addentry"]           = "Lisää varaus";
$string["editentry"]          = "Muokkaa varausta";
$string["editseries"]         = "Muokkaa varaussarjaa";
$string["namebooker"]         = "Lyhyt kuvaus";
$string["fulldescription"]    = "Täydellinen kuvaus:<br>&nbsp;&nbsp;(Montako ihmistä,<br>&nbsp;&nbsp;sisäinen/ulkoinen jne)";
$string["date"]               = "Päivämäärä";
$string["start_date"]         = "Aloitusaika";
$string["end_date"]           = "Lopetusaika";
$string["time"]               = "Aika";
$string["period"]             = "Jakso";
$string["duration"]           = "Kesto";
$string["seconds"]            = "sekuntia";
$string["minutes"]            = "minuuttia";
$string["hours"]              = "tuntia";
$string["days"]               = "päivää";
$string["weeks"]              = "viikkoa";
$string["years"]              = "vuotta";
$string["periods"]            = "jaksoa";
$string["all_day"]            = "Koko päivän";
$string["type"]               = "Tyyppi";
$string["internal"]           = "Sisäinen";
$string["external"]           = "Ulkoinen";
$string["save"]               = "Tallenna";
$string["rep_type"]           = "Toiston tyyppi";
$string["rep_type_0"]         = "Ei toistoa";
$string["rep_type_1"]         = "Päivittäin";
$string["rep_type_2"]         = "Viikoittain";
$string["rep_type_3"]         = "Kuukausittain";
$string["rep_type_4"]         = "Vuosittain";
$string["rep_type_5"]         = "Kuukausittain samana viikonpäivänä";
$string["rep_type_6"]         = "Määräaikainen viikoittainen";
$string["rep_end_date"]       = "Toiston loppupäivämäärä";
$string["rep_rep_day"]        = "Toiston viikonpäivä";
$string["rep_for_weekly"]     = "(viikottaiselle toistolle)";
$string["rep_freq"]           = "Tiheys";
$string["rep_num_weeks"]      = "Montako viikkoa";
$string["rep_for_nweekly"]    = "(määräaikaiselle viikottaiselle)";
$string["ctrl_click"]         = "Pidä CTRL-nappi pohjassa valitaksesi useita huoneita.";
$string["entryid"]            = "Varauksen ID ";
$string["repeat_id"]          = "Toiston ID "; 
$string["you_have_not_entered"] = "Et ole antanut seuraavaa pakollista tietoa";
$string["you_have_not_selected"] = "Et ole valinnut";
$string["valid_room"]         = "huonetta.";
$string["valid_time_of_day"]  = "Ajankohta ei ole kelpaa.";
$string["brief_description"]  = "Lyhyt kuvaus";
$string["useful_n-weekly_value"] = "Määräaikaisen viikottaisen varauksen viikkomäärä.";

// Used in view_entry.php
$string["description"]        = "Kuvaus";
$string["room"]               = "Huone";
$string["createdby"]          = "Varauksen tekijä";
$string["lastupdate"]         = "Päivitetty";
$string["deleteentry"]        = "Poista varaus";
$string["deleteseries"]       = "Poista varaussarja";
$string["confirmdel"]         = "Oletko varma että haluat poistaa\\ntämän varauksen?\\n\\n";
$string["returnprev"]         = "Takaisin edelliselle sivulle";
$string["invalid_entry_id"]   = "Virheellinen varauksen ID.";
$string["invalid_series_id"]  = "Virheellinen sarjan ID.";

// Used in edit_entry_handler.php
$string["error"]              = "Virhe";
$string["sched_conflict"]     = "Päällekkäinen varaus";
$string["conflict"]           = "Uusi varaus menee päällekkäin seuraavien varausten kanssa";
$string["too_may_entrys"]     = "Valituilla ehdoilla tulisi liian monta varausta.<br>Valittuja ehtoja on muutettava.";
$string["returncal"]          = "Paluu kalenterinäkymään";
$string["failed_to_acquire"]  = "Tietokantaan ei saatu (varauksetonta) yhteyttä."; 

// Authentication stuff
$string["accessdenied"]       = "Pääsy kielletty";
$string["norights"]           = "Sinulla ei ole riittävästi oikeuksia yrittämäsi toiminnon suorittamiseen.";
$string["please_login"]       = "Ole hyvä ja kirjaudu sisään";
$string["user_name"]          = "Käyttäjätunnus";
$string["user_password"]      = "Salasana";
$string["unknown_user"]       = "Tuntematon käyttäjä";
$string["you_are"]            = "Olet";
$string["login"]              = "Kirjaudu sisään";
$string["logoff"]             = "Kirjaudu ulos";

// Authentication database
$string["user_list"]          = "Käyttäjälista";
$string["edit_user"]          = "Muokkaa käyttäjää";
$string["delete_user"]        = "Poista tämä käyttäjä";
//$string["user_name"]         = Use the same as above, for consistency.
//$string["user_password"]     = Use the same as above, for consistency.
$string["user_email"]         = "Sähköpostiosoite";
$string["password_twice"]     = "Jos haluat vaihtaa salasanan, ole hyvä ja anna uusi salasana kahdesti";
$string["passwords_not_eq"]   = "Virhe: Salasanat eivät täsmää.";
$string["add_new_user"]       = "Lisää uusi käyttäjä";
$string["rights"]             = "Oikeudet";
$string["action"]             = "Toiminto";
$string["user"]               = "Käyttäjä";
$string["administrator"]      = "Ylläpitäjä";
$string["unknown"]            = "Tuntematon";
$string["ok"]                 = "OK";
$string["show_my_entries"]    = "Click to display all my upcoming entries";

// Used in search.php
$string["invalid_search"]     = "Tyhjä tai kelpaamaton haku.";
$string["search_results"]     = "Hakutulokset";
$string["nothing_found"]      = "Yhtään varausta ei löytynyt antamillasi ehdoilla. ";
$string["records"]            = "Tulokset ";
$string["through"]            = " - ";
$string["of"]                 = " tuloksia yhteensä: ";
$string["previous"]           = "Edellinen";
$string["next"]               = "Seuraava";
$string["entry"]              = "Varaus";
$string["view"]               = "Katsele";
$string["advanced_search"]    = "Tarkennettu haku";
$string["search_button"]      = "Hae";
$string["search_for"]         = "Etsi";
$string["from"]               = "Alkaen";

// Used in report.php
$string["report_on"]          = "Raportti varauksista";
$string["report_start"]       = "Raportin alkupäivämäärä";
$string["report_end"]         = "Raportin loppupäivämäärä";
$string["match_area"]         = "Alue";
$string["match_room"]         = "Huone";
$string["match_type"]         = "Tyyppi";
$string["ctrl_click_type"]    = "Pidä Ctrl-näppäin alaspainettuna valitaksesi useamman tyypin.";
$string["match_entry"]        = "Lyhyt kuvaus";
$string["match_descr"]        = "Täydellinen kuvaus";
$string["include"]            = "Sisältäen";
$string["report_only"]        = "Ainoastaan raportti";
$string["summary_only"]       = "Ainoastaan yhteenveto";
$string["report_and_summary"] = "Molemmat";
$string["summarize_by"]       = "Yhteenvedon peruste";
$string["sum_by_descrip"]     = "Lyhyt kuvaus";
$string["sum_by_creator"]     = "Varaaja";
$string["entry_found"]        = "varaus löytyi";
$string["entries_found"]      = "varausta löytyi";
$string["summary_header"]     = "Varausten tunnit yhteensä";
$string["summary_header_per"] = "Summary of (Entries) Periods";
$string["total"]              = "Kaikkiaan";
$string["submitquery"]        = "Tee raportti";
$string["sort_rep"]           = "Raporttien lajittelun peruste";
$string["sort_rep_time"]      = "Aloitusaika";
$string["rep_dsp"]            = "Näytä raportissa";
$string["rep_dsp_dur"]        = "Kesto";
$string["rep_dsp_end"]        = "Loppumisaika";
 
// Used in week.php
$string["weekbefore"]         = "Edelliseen viikkoon";
$string["weekafter"]          = "Seuraavaan viikkoon";
$string["gotothisweek"]       = "Tähän viikkoon";

// Used in month.php
$string["monthbefore"]        = "Edelliseen kuukauteen";
$string["monthafter"]         = "Seuraavaan kuukauteen";
$string["gotothismonth"]      = "Tähän kuukauteen";

// Used in {day week month}.php
$string["no_rooms_for_area"]  = "Tällä alueella ei ole yhtään huonetta.";

// Used in admin.php
$string["edit"]               = "Muokkaa";
$string["delete"]             = "Poista";
$string["rooms"]              = "Huoneet";
$string["in"]                 = "alueella";
$string["noareas"]            = "Ei alueita";
$string["addarea"]            = "Lisää alue";
$string["name"]               = "Nimi";
$string["noarea"]             = "Ei valittua aluetta";
$string["browserlang"]        = "Selaimesi kieliasetus on";
$string["addroom"]            = "Lisää huone";
$string["capacity"]           = "Maksimi henkilömäärä";
$string["norooms"]            = "Ei huoneita.";
$string["administration"]     = "Ylläpito";

// Used in edit_area_room.php
$string["editarea"]           = "Muokkaa alueen tietoja";
$string["change"]             = "Tallenna";
$string["backadmin"]          = "Takaisin ylläpitoon";
$string["editroomarea"]       = "Muokkaa alueen tai huoneen kuvausta";
$string["editroom"]           = "Muokkaa huoneen tietoja";
$string["update_room_failed"] = "Huoneen tietojen päivitys epäonnistui: ";
$string["error_room"]         = "Virhe: huonetta ";
$string["not_found"]          = " ei löytynyt";
$string["update_area_failed"] = "Alueen tietojen päivitys epäonnistui: ";
$string["error_area"]         = "Virhe: aluetta ";
$string["room_admin_email"]   = "Huonevastaavan sähköposti";
$string["area_admin_email"]   = "Aluevastaavan sähköposti";
$string["invalid_email"]      = "Virheellinen sähköpostiosoite!";

// Used in del.php
$string["deletefollowing"]    = "Seuraavat varaukset poistetaan";
$string["sure"]               = "Oletko varma?";
$string["YES"]                = "KYLLÄ";
$string["NO"]                 = "EN";
$string["delarea"]            = "Sinun täytyy poistaa kaikki alueen huoneet ennnen kuin voit poistaa alueen.<p>";

// Used in help.php
$string["about_mrbs"]         = "Tietoja varausjärjestelmästä";
$string["database"]           = "Tietokanta";
$string["system"]             = "Käyttöjärjestelmä";
$string["please_contact"]     = "Järjestelmän yhteyshenkilö ";
$string["for_any_questions"]  = "antaa lisätietoja mikäli et löydä vastausta kysymykseesi näistä ohjeista.";

// Used in mysql.inc AND pgsql.inc
$string["failed_connect_db"]  = "Järjestelmävirhe: Tietokantayhteyden avaaminen ei onnistu.";

?>
