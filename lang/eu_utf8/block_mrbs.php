<?php // -*-mode: PHP; coding:utf-8;-*-

// $Id: block_mrbs.php,v 1.1 2009/02/26 07:20:14 arborrow Exp $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is a Basque file.
//
//
//
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$string["charset"]            = "utf-8";

// Used for Moodle
$string['blockname'] = 'Booking system';
$string['accessmrbs'] = 'Schedule a Resource';

// Used in style.php
$string["mrbs"]               = "Baliabideen Erreserba Sistema";

// Used in functions.php
$string["report"]             = "Txostenak";
$string["admin"]              = "Kudeaketa";
$string["help"]               = "Laguntza";
$string["search"]             = "Bilatu:";
$string["not_php3"]           = "Kontuz: Honek seguru asko ez du PHP3rekin ongi funtzionatuko";

// Used in day.php
$string["bookingsfor"]        = "Noiz erreserbatu: ";
$string["bookingsforpost"]    = ""; // Dataren ondoren doa
$string["areas"]              = "Baliabide mota";
$string["daybefore"]          = "Aurreko eguna";
$string["dayafter"]           = "Hurrengo eguna";
$string["gototoday"]          = "Gaurko eguna";
$string["goto"]               = "Hona joan";
$string["highlight_line"]     = "Lerro honi lehentasuna eman";
$string["click_to_reserve"]   = "Erreserba egiteko karratutxoan klik egin.";

// Used in trailer.php
$string["viewday"]            = "Eguna ikusi";
$string["viewweek"]           = "Astea ikusi";
$string["viewmonth"]          = "Hilabetea ikusi";
$string["ppreview"]           = "Inprimatzeko aurrebista";

// Used in edit_entry.php
$string["addentry"]           = "Erreserba berria";
$string["editentry"]          = "Erreserba editatu";
$string["editseries"]         = "Segidak editatu";
$string["namebooker"]         = "Deskribapen motza";
$string["fulldescription"]    = "Deskribapen osoa:";
$string["date"]               = "Data";
$string["start_date"]         = "Hasiera data";
$string["end_date"]           = "Amaiera data";
$string["time"]               = "Ordua";
$string["period"]             = "Periodoa";
$string["duration"]           = "Iraupena";
$string["seconds"]            = "segunduak";
$string["minutes"]            = "minutuak";
$string["hours"]              = "orduak";
$string["days"]               = "egun";
$string["weeks"]              = "asteak";
$string["years"]              = "urteak";
$string["periods"]            = "tarte ordu erdikoak";
$string["all_day"]            = "Egun osorako";
$string["type"]               = "Mota";
$string["internal"]           = "Arrunta";
$string["external"]           = "Berezia";
$string["save"]               = "Gorde";
$string["rep_type"]           = "Errepikapen mota";
$string["rep_type_0"]         = "Ezein ez";
$string["rep_type_1"]         = "Egunekoa";
$string["rep_type_2"]         = "Astekoa";
$string["rep_type_3"]         = "Hilekoa";
$string["rep_type_4"]         = "Urtekoa";
$string["rep_type_5"]         = "Hilekoa, dagokion eguna";
$string["rep_type_6"]         = "n astetan";
$string["rep_end_date"]       = "Errepikapenaren bukaera data";
$string["rep_rep_day"]        = "Errepikapenaren eguna";
$string["rep_for_weekly"]     = "(asteko eta n astekoan)";
$string["rep_freq"]           = "Maiztasuna";
$string["rep_num_weeks"]      = "Aste kopurua";
$string["rep_for_nweekly"]    = "(n aste)";
$string["ctrl_click"]         = "Elementu bat gehiago aukeratzeko Kontrol-klik egin";
$string["entryid"]            = "IDa sartu";
$string["repeat_id"]          = "IDa errepikatu"; 
$string["you_have_not_entered"] = "Ez duzu sartu ";
$string["you_have_not_selected"] = "Ez duzu aukeratu ";
$string["valid_room"]         = "baliabidea.";
$string["valid_time_of_day"]  = "egunaren denbora baliagarria.";
$string["brief_description"]  = "Deskribapen laburra.";
$string["useful_n-weekly_value"] = "n astetan baliagarria.";

// Used in view_entry.php
$string["description"]        = "Deskribapena";
$string["room"]               = "Baliabidea";
$string["createdby"]          = "Nork sortua";
$string["lastupdate"]         = "Azken eguneraketa";
$string["deleteentry"]        = "Erreserba ezabatu";
$string["deleteseries"]       = "Segida ezabatu";
$string["confirmdel"]         = "Erreserba hau ezabatu nahi duzula ziur al zaude?";
$string["returnprev"]         = "Aurreko orrira itzuli";
$string["invalid_entry_id"]   = "Invalid entry id.";
$string["invalid_series_id"]  = "Invalid series id.";

// Used in edit_entry_handler.php
$string["error"]              = "Errorea";
$string["sched_conflict"]     = "Planifikazio-gatazka";
$string["conflict"]           = "Erreserba berria beste erreserba hauekin bateraezina da:";
$string["too_may_entrys"]     = "Aukeratu duzunak arazoak sortzen ditu.<br>Aukera(k) berriz aztertu, mesedez";
$string["returncal"]          = "Egutegiaren bistara itzuli, mesedez";
$string["failed_to_acquire"]  = "Datubasera sartzeko arazoa"; 

// Authentication stuff
$string["accessdenied"]       = "Ezin zara sartu";
$string["norights"]           = "Ez duzu baimenik datua aldatzeko.";
$string["please_login"]       = "Mesedez, logea zaitez";
$string["user_name"]          = "Izena";
$string["user_password"]      = "Pasahitza";
$string["unknown_user"]       = "Erabiltzaile ezezaguna";
$string["you_are"]            = "Zu zara ";
$string["login"]              = "Sartu";
$string["logoff"]             = "Irten";

// Authentication database
$string["user_list"]          = "Erabiltzaileen zerrenda";
$string["edit_user"]          = "Erabiltzailea editatu";
$string["delete_user"]        = "Erabiltzaile hau ezabatu";
//$string["user_name"]         = Use the same as above, for consistency.
//$string["user_password"]     = Use the same as above, for consistency.
$string["user_email"]         = "Email helbidea";
$string["password_twice"]     = "Pasahitza aldatu nahi baduzu, pasahitz berria bi aldiz idatzi, mesedez";
$string["passwords_not_eq"]   = "Errorea: Pasahitzak ez datoz bat.";
$string["add_new_user"]       = "Erabiltzaile berria erantsi";
$string["rights"]             = "Baimenak";
$string["action"]             = "Ekintza";
$string["user"]               = "Erabiltzailea";
$string["administrator"]      = "Kudeatzailea";
$string["unknown"]            = "Ezezaguna";
$string["ok"]                 = "Ongi";
$string["show_my_entries"]    = "Nire sarrerak erakusteko klik egin";

// Used in search.php
$string["invalid_search"]     = "Bilaketa-kate hutsa edo desegokia.";
$string["search_results"]     = "Honen emaitzak bilatu:";
$string["nothing_found"]      = "Ez da kointzidentziarik aurkitu.";
$string["records"]            = "Taularen lehen erregistroaren orden-zenbakia: ";
$string["through"]            = " - Orain arte bistaratutako erregistroak:  ";
$string["of"]                 = " - Aurkitutako erregistrok guztira: ";
$string["previous"]           = "Aurrekoa";
$string["next"]               = "Hurrengoa";
$string["entry"]              = "Sarrera";
$string["view"]               = "Ikusi";
$string["advanced_search"]    = "Bilaketa aurreratua";
$string["search_button"]      = "Bilatu";
$string["search_for"]         = "Bilaketa aurreratua: ";
$string["from"]               = "Noiztik: ";

// Used in report.php
$string["report_on"]          = "Baliabideen erabilpen-txostena:";
$string["report_start"]       = "Hasiera data:";
$string["report_end"]         = "Amaiera data:";
$string["match_area"]         = "Baliabide mota bilatu:";
$string["match_room"]         = "Baliabidea bilatu:";
$string["match_type"]         = "Mota aukeratu:";
$string["ctrl_click_type"]    = "Mota bat baino gehiago aukeratzeko Kontrol-klik egin";
$string["match_entry"]        = "Deskribapen laburra aurkitu:";
$string["match_descr"]        = "Deskribapen osoa aurkitu:";
$string["include"]            = "Sartu:";
$string["report_only"]        = "Txostena soilik";
$string["summary_only"]       = "Laburpena soilik";
$string["report_and_summary"] = "Txostena eta laburpena";
$string["summarize_by"]       = "Honen arabera laburbildu:";
$string["sum_by_descrip"]     = "Deskribapen laburra";
$string["sum_by_creator"]     = "Egilea";
$string["entry_found"]        = "aurkitutako erregistroa";
$string["entries_found"]      = "aurkitutako erregistroak";
$string["summary_header"]     = "(Orduen) tarteen laburpena";
$string["summary_header_per"] = "(Orduen) tarteen laburpena";
$string["total"]              = "Guztira";
$string["submitquery"]        = "Bidali";
$string["sort_rep"]           = "Zeren arabera:";
$string["sort_rep_time"]      = "Hasiera data/ordua";
$string["rep_dsp"]            = "Txostenean erakutsi:";
$string["rep_dsp_dur"]        = "Iraupena";
$string["rep_dsp_end"]        = "Bukaera";

// Used in week.php
$string["weekbefore"]         = "Aurreko astera joan";
$string["weekafter"]          = "Hurrengo astera joan";
$string["gotothisweek"]       = "Aste honetara joan";

// Used in month.php
$string["monthbefore"]        = "Aurreko hilabetera joan";
$string["monthafter"]         = "Hurrengo hilabetera joan";
$string["gotothismonth"]      = "Hilabete honetara joan";

// Used in {day week month}.php
$string["no_rooms_for_area"]  = "Baliabide honetarako elementurik ez da zehaztu";

// Used in admin.php
$string["edit"]               = "Editatu";
$string["delete"]             = "Ezabatu";
$string["rooms"]              = "Baliabideak";
$string["in"]                 = "non: ";
$string["noareas"]            = "Ez dago baliabiderik";
$string["addarea"]            = "Baliabidea erantsi";
$string["name"]               = "Izena";
$string["noarea"]             = "Ez duzu baliabiderik aukeratu";
$string["browserlang"]        = "Zure nabigatzaileak hizkuntza hauek ikusteko ezarpena dauka:";
$string["addroom"]            = "Elementua aukeratu";
$string["capacity"]           = "Zenbat pertsonentzat";
$string["norooms"]            = "Ez dago elementurik.";
$string["administration"]     = "Kudeaketa";

// Used in edit_area_room.php
$string["editarea"]           = "Baliabidea editatu";
$string["change"]             = "Aldatu";
$string["backadmin"]          = "Kudeaketara itzuli";
$string["editroomarea"]       = "Baliabidearen deskribapena editatu";
$string["editroom"]           = "Elementua editatu";
$string["update_room_failed"] = "Elementua editatzen errorea: ";
$string["error_room"]         = "Errorea: gela ";
$string["not_found"]          = " ez da aurkitu";
$string["update_area_failed"] = "Baliabidearen eguneratzean errorea: ";
$string["error_area"]         = "Error: eraikina ";
$string["room_admin_email"]   = "Elementuaren kudeatzailearen emaila:";
$string["area_admin_email"]   = "Baliabidearen kudeatzailearen emaila:";
$string["invalid_email"]      = "Email okerra!";

// Used in del.php
$string["deletefollowing"]    = "Ekintza honek hurrengo agenda(k) ezabatuko d(it)u: ";
$string["sure"]               = "Ziur al zaude?";
$string["YES"]                = "BAI";
$string["NO"]                 = "EZ";
$string["delarea"]            = "Hau ezabatu aurretik baliabide honetako gela guztiak ezabatu behar dituzu<p>";

// Used in help.php
$string["about_mrbs"]         = "MRBSri buruz";
$string["database"]           = "Datubasea: ";
$string["system"]             = "Sistema: ";
$string["please_contact"]     = "Mesedez, harremanetan jarri: ";
$string["for_any_questions"]  = "hemen erantzuten ez den edozein galdera egiteko.";

// Used in mysql.php AND pgsql.php
$string["failed_connect_db"]  = "Errorea: Ezin izan da datubasearekiko konexioa burutu";

?>
