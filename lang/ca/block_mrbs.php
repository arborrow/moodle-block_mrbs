<?php // -*-mode: PHP; coding:utf-8;-*-

// $Id: block_mrbs.php,v 1.1 2009/02/26 07:20:13 arborrow Exp $

// This file contains PHP code that specifies language specific strings 
// The default strings come from lang.en, and anything in a locale 
// specific file will overwrite the default. This is a Catalan file.
//
//
//
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$string["charset"]            = "utf-8";

// Used for Moodle
$string['blockname'] = 'Reserva de sales';
$string['accessmrbs'] = 'Administrar ressources';

// Used in style.inc
$string["mrbs"]               = "Reserva de sales";

// Used in functions.inc
$string["report"]             = "Informes";
$string["admin"]              = "Administració";
$string["help"]               = "Ajuda";
$string["search"]             = "Cerca";
$string["not_php3"]           = "PERILL: Segurament no funcionarà amb PHP3";

// Used in day.php
$string["bookingsfor"]        = "Reserves per a";
$string["bookingsforpost"]    = ""; // Goes after the date
$string["areas"]              = "Famílies";
$string["daybefore"]          = "Dia anterior";
$string["dayafter"]           = "Dia següent";
$string["gototoday"]          = "Dia actual";
$string["goto"]               = "Anar a";
$string["highlight_line"]     = "Destacar aquesta línia";
$string["click_to_reserve"]   = "Clicar per fer una reserva.";

// Used in trailer.inc
$string["viewday"]            = "Veure dia";
$string["viewweek"]           = "Veure setmana";
$string["viewmonth"]          = "Veure mes";
$string["ppreview"]           = "Imprimir vista prèvia.";

// Used in edit_entry.php
$string["addentry"]           = "Nova reserva";
$string["editentry"]          = "Editar reserva";
$string["editseries"]         = "Editar series";
$string["namebooker"]         = "Nom";
$string["fulldescription"]    = "Descripció:";
$string["date"]               = "Data";
$string["start_date"]         = "Data d'inici";
$string["end_date"]           = "Data de fi";
$string["time"]               = "Hora";
$string["period"]             = "Període";
$string["duration"]           = "Duració";
$string["seconds"]            = "segons";
$string["minutes"]            = "minuts";
$string["hours"]              = "hores";
$string["days"]               = "dies";
$string["weeks"]              = "setmanes";
$string["years"]              = "anys";
$string["periods"]            = "períodes";
$string["all_day"]            = "Dia complet";
$string["type"]               = "Entitat";
$string["internal"]           = "Intern";
$string["external"]           = "Extern";
$string["save"]               = "Guardar";
$string["rep_type"]           = "Tipus de repetició";
$string["rep_type_0"]         = "Cap";
$string["rep_type_1"]         = "Diària";
$string["rep_type_2"]         = "Setmanal";
$string["rep_type_3"]         = "Mensual";
$string["rep_type_4"]         = "Anual";
$string["rep_type_5"]         = "Menusal, en el mateix dia";
$string["rep_type_6"]         = "n-Setmanal";
$string["rep_end_date"]       = "Data màxima Repetició";
$string["rep_rep_day"]        = "Dia de repetició";
$string["rep_for_weekly"]     = "(setmanal)";
$string["rep_freq"]           = "Freqüència";
$string["rep_num_weeks"]      = "Número de setmanes";
$string["rep_for_nweekly"]    = "(n-setmanes)";
$string["ctrl_click"]         = "Control-Clic per seleccionar més d'un recurs";
$string["entryid"]            = "ID d'entrada";
$string["repeat_id"]          = "ID de repetició";
$string["you_have_not_entered"] = "No ha entrat";
$string["you_have_not_selected"] = "No ha sel·leccionat";
$string["valid_room"]         = "room.";
$string["valid_time_of_day"]  = "valid time of day.";
$string["brief_description"]  = "Breu descriptció.";
$string["useful_n-weekly_value"] = "useful n-weekly value.";

// Used in view_entry.php
$string["description"]        = "Descripció";
$string["room"]               = "Recurs";
$string["createdby"]          = "Creada per";
$string["lastupdate"]         = "Última actualizació";
$string["deleteentry"]        = "Esborrar reserva";
$string["deleteseries"]       = "Esborrar sèrie";
$string["confirmdel"]         = "Segur que\\ndesitja esborrar\\naquesta reserva?\\n\\n";
$string["returnprev"]         = "Tornar a la pàgina anterior";
$string["invalid_entry_id"]   = "Valor d'entrada invàlid.";
$string["invalid_series_id"]  = "Valor de sèrie invàlid.";

// Used in edit_entry_handler.php
$string["error"]              = "Error";
$string["sched_conflict"]     = "Conflicte de planificació";
$string["conflict"]           = "La nova reserva entra en conflicte amb le(s) següent(s) entrade(s)";
$string["too_may_entrys"]     = "Les opcions sel·leccionades crearan mases entrades.<br>Si us plau, revisi les opcions";
$string["returncal"]          = "Tornar a la vista del calendari";
$string["failed_to_acquire"]  = "Fallada en l'intent d'obtenir accés a la base de dades"; 

// Authentication stuff
$string["accessdenied"]       = "Accés denegat";
$string["norights"]           = "No te autorizació per modificar aquesta dada.";
$string["please_login"]       = "Si us plau, iniciï la sessió";
$string["user_name"]          = "Nom";
$string["user_password"]      = "Contrasenya";
$string["unknown_user"]       = "Usuari desconegut";
$string["you_are"]            = "Ets ";
$string["login"]              = "Connectar";
$string["logoff"]             = "Desconectar";

// Authentication database
$string["user_list"]          = "Llista d'usuaris";
$string["edit_user"]          = "Editar usuari";
$string["delete_user"]        = "Eliminar aquest usuari";
//$string["user_name"]         = Use the same as above, for consistency.
//$string["user_password"]     = Use the same as above, for consistency.
$string["user_email"]         = "Adreça de correu";
$string["password_twice"]     = "Si vols canviar la contrasenya, introdueix-la dues vegades";
$string["passwords_not_eq"]   = "Error: Les contrasenyes no són 
iguals.";
$string["add_new_user"]       = "Afegir nou usuari";
$string["rights"]             = "Drets";
$string["action"]             = "Acció";
$string["user"]               = "Usuari";
$string["administrator"]      = "Administrador";
$string["unknown"]            = "Desconegut";
$string["ok"]                 = "D'acord";
$string["show_my_entries"]    = "Fer Clic per mostar tots els events pròxims";

// Used in search.php
$string["invalid_search"]     = "Cadena de cerca buida o incorrecte.";
$string["search_results"]     = "Cercar resultats de";
$string["nothing_found"]      = "No s'han trobat coincidencies";
$string["records"]            = "Registres ";
$string["through"]            = " a través ";
$string["of"]                 = " de ";
$string["previous"]           = "Anterior";
$string["next"]               = "Següent";
$string["entry"]              = "Entrada";
$string["view"]               = "Veure";
$string["advanced_search"]    = "Cerca avançada";
$string["search_button"]      = "Cerca";
$string["search_for"]         = "Cerca per";
$string["from"]               = "De";

// Used in report.php
$string["report_on"]          = "Informe de reunions";
$string["report_start"]       = "Data des de";
$string["report_end"]         = "Data fins a";
$string["match_area"]         = "Trobar famila";
$string["match_room"]         = "Trobar recurs";
$string["match_type"]         = "Trobar tipus";
$string["ctrl_click_type"]    = "Fes servir control-clic per sel·leccionar múltiples elements";
$string["match_entry"]        = "Trobar descripció breu";
$string["match_descr"]        = "Encontar descripció completa";
$string["include"]            = "Incloure";
$string["report_only"]        = "Només informe";
$string["summary_only"]       = "Només resum";
$string["report_and_summary"] = "Informe i resum";
$string["summarize_by"]       = "Resumir per";
$string["sum_by_descrip"]     = "Descripció breu";
$string["sum_by_creator"]     = "Creador";
$string["entry_found"]        = "registre trobat";
$string["entries_found"]      = "registres trobats";
$string["summary_header"]     = "Resum de (Registres) Hores";
$string["summary_header_per"] = "Resum de (Registres) Periodes";
$string["total"]              = "Total";
$string["submitquery"]        = "Executar informe";
$string["sort_rep"]           = "Ordenar informe per";
$string["sort_rep_time"]      = "Inici data/hora";
$string["rep_dsp"]            = "Ensenya en l'informe";
$string["rep_dsp_dur"]        = "Duració";
$string["rep_dsp_end"]        = "Temps esgotat";

// Used in week.php
$string["weekbefore"]         = "Anar a la setmana anterior";
$string["weekafter"]          = "Anar a la setmana posterior";
$string["gotothisweek"]       = "Anar a la setmana actual";

// Used in month.php
$string["monthbefore"]        = "Anar al mes anterior";
$string["monthafter"]         = "Anar al mes posterior";
$string["gotothismonth"]      = "Anar al mes actual";

// Used in {day week month}.php
$string["no_rooms_for_area"]  = "No hi ha recursos definits per aquest edifici";

// Used in admin.php
$string["edit"]               = "Editar";
$string["delete"]             = "Esborrar";
$string["rooms"]              = "Recursos";
$string["in"]                 = "a";
$string["noareas"]            = "No hi ha famílies";
$string["addarea"]            = "Afegir família";
$string["name"]               = "Nombre";
$string["noarea"]             = "No ha sel·leccionat família";
$string["browserlang"]        = "El seu visor està configurat per els llenguatges";
$string["addroom"]            = "Afegir recurs";
$string["capacity"]           = "Capacitat (persones)";
$string["norooms"]            = "No hi han recursos.";
$string["administration"]     = "Administració";

// Used in edit_area_room.php
$string["editarea"]           = "Editar familia";
$string["change"]             = "Canviar";
$string["backadmin"]          = "Tornar a admintració";
$string["editroomarea"]       = "Editar descripció de família o recurs";
$string["editroom"]           = "Editar recurs";
$string["update_room_failed"] = "Actualització de recurs fallida: ";
$string["error_room"]         = "Error: recurs ";
$string["not_found"]          = " no trobat";
$string["update_area_failed"] = "Actualització d'area fallida:: ";
$string["error_area"]         = "Error: area ";
$string["room_admin_email"]   = "Recuros admin email";
$string["area_admin_email"]   = "Area admin email";
$string["invalid_email"]      = "email invàlid!";

// Used in del.php
$string["deletefollowing"]    = "Aixó esborra les següents agendes";
$string["sure"]               = "ESTA SEGUR?";
$string["YES"]                = "SÍ";
$string["NO"]                 = "NO";
$string["delarea"]            = "S'han d'esborrar tots els recursos d'aquesta família per poder esborrar-lo<p>";

// Used in help.php
$string["about_mrbs"]         = "Sobre l'MRBS";
$string["database"]           = "Base de dades";
$string["system"]             = "Sistema";
$string["please_contact"]     = "Si us plau contacta ";
$string["for_any_questions"]  = "per a altres consultes.";

// Used in mysql.inc AND pgsql.inc
$string["failed_connect_db"]  = "Error Fatal: Fallada al conectar a la base de dades";

?>
