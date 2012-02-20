<?php // -*-mode: PHP; coding:utf-8;-*-

// $Id: block_mrbs.php,v 1.1 2009/02/26 07:20:12 arborrow Exp $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is a sl_SI Slovenian file.
// translated by Martin Terbuc 2007/02/24
//
//
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$string["charset"]            = "utf-8";

// Used for Moodle
$string['blockname']          = 'Booking system';
$string['accessmrbs']         = 'Schedule a Resource';

// Used in style.inc
$string["mrbs"]               = "Prikaži urnike prostorov";

// Used in functions.inc
$string["report"]             = "Poročilo";
$string["admin"]              = "Admin";
$string["help"]               = "Pomoč";
$string["search"]             = "Išči";
$string["not_php3"]           = "OPOZORILO: Verjetno ne bo delovalo z PHP3";

// Used in day.php
$string["bookingsfor"]        = "Rezervacija za";
$string["bookingsforpost"]    = ""; // Goes after the date
$string["areas"]              = "Področja";
$string["daybefore"]          = "Prejšnji dan";
$string["dayafter"]           = "Naslednji dan";
$string["gototoday"]          = "Danes";
$string["goto"]               = "pojdi";
$string["highlight_line"]     = "Poudari to vrsto";
$string["click_to_reserve"]   = "Za dodajanje rezervacije klikni na celico.";

// Used in trailer.inc
$string["viewday"]            = "Pogled dan";
$string["viewweek"]           = "Pogled teden";
$string["viewmonth"]          = "Pogled mesec";
$string["ppreview"]           = "Predogled tiskanja";

// Used in edit_entry.php
$string["addentry"]           = "Dodaj vnos";
$string["editentry"]          = "Uredi vnos";
$string["copyentry"]          = "Kopiraj vnos";
$string["editseries"]         = "Uredi ponavljanja";
$string["copyseries"]         = "Kopiraj vrsto";
$string["namebooker"]         = "Kratek opis";
$string["fulldescription"]    = "Dolgi opis:<br>&nbsp;&nbsp;(Število oseb,<br>&nbsp;&nbsp;Interno/Zunanje, itd.)";
$string["date"]               = "Datum";
$string["start_date"]         = "Začetni čas";
$string["end_date"]           = "Končni čas";
$string["time"]               = "Čas";
$string["period"]             = "Ponavljajoč";
$string["duration"]           = "Trajanje (za decimalko uporabi piko)";
$string["seconds"]            = "sekund";
$string["minutes"]            = "minut";
$string["hours"]              = "ur";
$string["days"]               = "dni";
$string["weeks"]              = "tednov";
$string["years"]              = "let";
$string["periods"]            = "ponavljanj";
$string["all_day"]            = "Vse dni";
$string["type"]               = "Tip";
$string["internal"]           = "Interno";
$string["external"]           = "Zunanje";
$string["save"]               = "Shrani";
$string["rep_type"]           = "Način ponavljanja";
$string["rep_type_0"]         = "Brez";
$string["rep_type_1"]         = "Dnevno";
$string["rep_type_2"]         = "Tedensko";
$string["rep_type_3"]         = "Mesečno";
$string["rep_type_4"]         = "Letno";
$string["rep_type_5"]         = "Mesečno na pripadajoč dan v tednu";
$string["rep_type_6"]         = "n-tednov";
$string["rep_end_date"]       = "Datum konca ponavljanj";
$string["rep_rep_day"]        = "Ponavljaj dni";
$string["rep_for_weekly"]     = "(ponavljaj (n-tednov)";
$string["rep_freq"]           = "Frequenca";
$string["rep_num_weeks"]      = "Število tednov ";
$string["rep_for_nweekly"]    = "(za n-tednov)";
$string["ctrl_click"]         = "Uporabite Ctrl+klik za izbiro več prostorov";
$string["entryid"]            = "ID vnosa ";
$string["repeat_id"]          = "ID ponavljanj"; 
$string["you_have_not_entered"] = "Niste vnesli";
$string["you_have_not_selected"] = "Niste izbrali";
$string["valid_room"]         = "prostor.";
$string["valid_time_of_day"]  = "veljavne ure v dnevu.";
$string["brief_description"]  = "kratek opis.";
$string["useful_n-weekly_value"] = "prave vrednosti za n-tednov.";

// Used in view_entry.php
$string["description"]        = "Opis";
$string["room"]               = "Prostor";
$string["createdby"]          = "Vnesel";
$string["lastupdate"]         = "Zadnja sprememba";
$string["deleteentry"]        = "Izbriši vnos";
$string["deleteseries"]       = "Izbriši ponavljanja";
$string["confirmdel"]         = "Ste prepričani\\nda želite\\nizbrisati ta vnos?\\n\\n";
$string["returnprev"]         = "Vrni na prejšnjo stran";
$string["invalid_entry_id"]   = "Napačen vnos.";
$string["invalid_series_id"]  = "Napačen vnos ponavljanj.";

// Used in edit_entry_handler.php
$string["error"]              = "Napaka";
$string["sched_conflict"]     = "Konflikt rezervacij";
$string["conflict"]           = "Konflikt nove rezervacije z naslednjim(i) obsoječim(i)";
$string["too_may_entrys"]     = "Izbrane nastavitve bi ustvarile preveč vnosov.<br>Prosimo izvedite drugačno izbiro!";
$string["returncal"]          = "Vrnitev na pogled koledarja";
$string["failed_to_acquire"]  = "Napaka pri dostopu do baze";
$string["invalid_booking"]    = "Napačna rezervacija";
$string["must_set_description"] = "Vnesti morate kratek opis rezervacije. Prosimo vrnite se in jo vnesite.";
$string["mail_subject_entry"] = "Vnos dodan/spremenjen za vaš MRBS";
$string["mail_body_new_entry"] = "Dodan je bil nov vnos in tukaj so podrobnosti:";
$string["mail_body_del_entry"] = "Vnos je bil izbrisan in tukaj so podrobnosti:";
$string["mail_body_changed_entry"] = "Vnos je bil spremenjen in tukaj so podrobnosti:";
$string["mail_subject_delete"] = "Vnos za vaš MRBS je bil izbrisan";

// Authentication stuff
$string["accessdenied"]       = "Dostop zavrnjen";
$string["norights"]           = "Nimate pravice spreminjanja tega.";
$string["please_login"]       = "Prosim, prijavite se";
$string["user_name"]          = "Uporabniško ime";
$string["user_password"]      = "Geslo";
$string["unknown_user"]       = "Neznan uporabnik";
$string["you_are"]            = "Prijavljen";
$string["login"]              = "Prijava";
$string["logoff"]             = "Odjava";

// Authentication database
$string["user_list"]          = "Spisek uporabnikov";
$string["edit_user"]          = "Uredi uporabnika";
$string["delete_user"]        = "Izbriši tega uporabnika";
//$string["user_name"]         = Use the same as above, for consistency.
//$string["user_password"]     = Use the same as above, for consistency.
$string["user_email"]         = "e-pošni naslov";
$string["password_twice"]     = "Če želite zamenjati geslo, ga vtipkajte dvakrat";
$string["passwords_not_eq"]   = "Napaka: Gesli se ne ujemata.";
$string["add_new_user"]       = "Dodaj novega uporabnika";
$string["rights"]             = "Pravice";
$string["action"]             = "Dejanja";
$string["user"]               = "Uporabnik";
$string["administrator"]      = "Administrator";
$string["unknown"]            = "Neznan";
$string["ok"]                 = "Vredu";
$string["show_my_entries"]    = "Kliknite za prikaz vseh prihodnjih dogodkov";
$string["no_users_initial"]   = "V bazi ni uporabnikov, kreiranje osnovnih";
$string["no_users_create_first_admin"] = "Ustvarite uporabnika konfiguriranega kakor administrator in se prijavite, da boste lahko dodajali uporabnike.";

// Used in search.php
$string["invalid_search"]     = "Prazen ali napačen iskalni niz.";
$string["search_results"]     = "Rezultati iskanja za";
$string["nothing_found"]      = "Ni najdenih vnosov niza.";
$string["records"]            = "Vnosi ";
$string["through"]            = " do ";
$string["of"]                 = " od ";
$string["previous"]           = "Predhodni";
$string["next"]               = "Naslednji";
$string["entry"]              = "Vnos";
$string["view"]               = "Poglej";
$string["advanced_search"]    = "Napredno iskanje";
$string["search_button"]      = "Išči";
$string["search_for"]         = "Iskanje";
$string["from"]               = "Od";

// Used in report.php
$string["report_on"]          = "Poročila vnosov";
$string["report_start"]       = "Začetni datum poročila";
$string["report_end"]         = "Končni datum poročila";
$string["match_area"]         = "Ujemanje niza iz opisa področij";
$string["match_room"]         = "Ujemanje niza iz opisa prostorov";
$string["match_type"]         = "Za tip";
$string["ctrl_click_type"]    = "Uporabi Ctrl+klik za izbiro več tipov.";
$string["match_entry"]        = "Ujemanje niz iz kratkega opisa";
$string["match_descr"]        = "Ujemanje niz iz dolgega opisa";
$string["include"]            = "Vključi";
$string["report_only"]        = "Samo vnose";
$string["summary_only"]       = "Samo pregled";
$string["report_and_summary"] = "Vnose in pregled";
$string["summarize_by"]       = "Pregled po";
$string["sum_by_descrip"]     = "Kratkem opisu";
$string["sum_by_creator"]     = "Po vnosniku";
$string["entry_found"]        = "najden vnos";
$string["entries_found"]      = "najdenih vnosov";
$string["summary_header"]     = "Pregled (vnosov) ur";
$string["summary_header_per"] = "Pregled (vnosov) ponavljanj";
$string["total"]              = "Skupaj";
$string["submitquery"]        = "Naredi poročilo";
$string["sort_rep"]           = "Uredi poročilo po";
$string["sort_rep_time"]      = "Začetni datum/ura";
$string["rep_dsp"]            = "V poročilu prikaži";
$string["rep_dsp_dur"]        = "Trajanje";
$string["rep_dsp_end"]        = "Začetni - končni čas";

// Used in week.php
$string["weekbefore"]         = "Prejšni teden";
$string["weekafter"]          = "Naslednji teden";
$string["gotothisweek"]       = "Ta teden";

// Used in month.php
$string["monthbefore"]        = "Prejšni mesec";
$string["monthafter"]         = "Naslednji mesec";
$string["gotothismonth"]      = "Ta mesec";

// Used in {day week month}.php
$string["no_rooms_for_area"]  = "Ni definiranih prostorov v tem področju";

// Used in admin.php
$string["edit"]               = "Uredi";
$string["delete"]             = "Izbriši";
$string["rooms"]              = "Prostori";
$string["in"]                 = "v";
$string["noareas"]            = "Ni področij";
$string["addarea"]            = "Dodaj področje";
$string["name"]               = "Ime";
$string["noarea"]             = "Ni izbranega področja";
$string["browserlang"]        = "Vaš brskalnik je nastavljen za uporabo ";
$string["addroom"]            = "Dodaj prostor";
$string["capacity"]           = "Število mest";
$string["norooms"]            = "Ni prostorov.";
$string["administration"]     = "Administracija";

// Used in edit_area_room.php
$string["editarea"]           = "Uredi področje";
$string["change"]             = "Uporabi";
$string["backadmin"]          = "Nazaj v Admin";
$string["editroomarea"]       = "Uredi opis področja ali prostora";
$string["editroom"]           = "Uredi prostor";
$string["update_room_failed"] = "Sprememba za prostor ni uspela: ";
$string["error_room"]         = "Napaka: prostor ";
$string["not_found"]          = " ne najdem";
$string["update_area_failed"] = "Ni uspela posodobitev področja: ";
$string["error_area"]         = "Napaka: področje ";
$string["room_admin_email"]   = "e-pošta upravnika prostora";
$string["area_admin_email"]   = "e-pošta upravnika področja";
$string["invalid_email"]      = "Napačen e-pošni naslov!";

// Used in del.php
$string["deletefollowing"]    = "Izbrisali boste naslednje vnose";
$string["sure"]               = "Ste prepričanie?";
$string["YES"]                = "Da";
$string["NO"]                 = "NE";
$string["delarea"]            = "Izbrisati morate vse prostore v področju, preden ga lahko izbrišete<p>";

// Used in help.php
$string["about_mrbs"]         = "O MRBS";
$string["database"]           = "Podatkovna zbirka";
$string["system"]             = "Sistem";
$string["servertime"]         = "Čas strežnika";
$string["please_contact"]     = "Na dodatna vprašanja vam bo odgovoril ";
$string["for_any_questions"]  = ".";

// Used in mysql.inc AND pgsql.inc
$string["failed_connect_db"]  = "NAPAKA: ni se možno povezati v podatkovno bazo";

?>

