<?php // -*-mode: PHP; coding:utf-8;-*-

// $Id: block_mrbs.php,v 1.1 2009/02/26 07:20:13 arborrow Exp $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is an Italian file.
//
// Translations provided by: Gianni
//
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$string["charset"]            = "utf-8";

// Used for Moodle
$string['blockname'] = 'Booking system';
$string['accessmrbs'] = 'Schedule a Resource';

// Used in style.inc
$string["mrbs"]               = "Sistema di Prenotazione Sale";

// Used in functions.inc
$string["report"]             = "Report";
$string["admin"]              = "Admin";
$string["help"]               = "Aiuto";
$string["search"]             = "Ricerca";
$string["not_php3"]           = "ATTENZIONE: Probabilmente non funziona con PHP3";

// Used in day.php
$string["bookingsfor"]        = "Prenotazioni per";
$string["bookingsforpost"]    = "";
$string["areas"]              = "Aree";
$string["daybefore"]          = "Vai al Giorno Prima";
$string["dayafter"]           = "Vai al Giorno Dopo";
$string["gototoday"]          = "Vai a oggi";
$string["goto"]               = "Vai a";
$string["highlight_line"]     = "Evidenzia questa linea";
$string["click_to_reserve"]   = "Clicca sulla cella per effettuare una prenotazione.";

// Used in trailer.inc
$string["viewday"]            = "Vedi Giorno";
$string["viewweek"]           = "Vedi Settimana";
$string["viewmonth"]          = "Vedi Mese";
$string["ppreview"]           = "Anteprima Stampa";

// Used in edit_entry.php
$string["addentry"]           = "Aggiungi";
$string["editentry"]          = "Modifica";
$string["copyentry"]          = "Copia";
$string["editseries"]         = "Modifica Serie";
$string["copyseries"]         = "Copia Serie";
$string["namebooker"]         = "Breve Descrizione";
$string["fulldescription"]    = "Descrizione Completa:<br>&nbsp;&nbsp;(Numero di persone,<br>&nbsp;&nbsp;Interno/Esterno ecc..)";
$string["date"]               = "Data";
$string["start_date"]         = "Ora Inizio";
$string["end_date"]           = "Ora Fine";
$string["time"]               = "ora";
$string["period"]             = "Periodo";
$string["duration"]           = "Durata";
$string["seconds"]            = "secondi";
$string["minutes"]            = "minuti";
$string["hours"]              = "ora";
$string["days"]               = "giorni";
$string["weeks"]              = "settimane";
$string["years"]              = "anni";
$string["periods"]            = "periodi";
$string["all_day"]            = "Tutto il giorno";
$string["type"]               = "Tipo";
$string["internal"]           = "Interno";
$string["external"]           = "Esterno";
$string["save"]               = "Salva";
$string["rep_type"]           = "Tipo ripetizione";
$string["rep_type_0"]         = "Nessuno";
$string["rep_type_1"]         = "Giornaliero";
$string["rep_type_2"]         = "Settimanale";
$string["rep_type_3"]         = "Mensile";
$string["rep_type_4"]         = "Annuale";
$string["rep_type_5"]         = "Mensile, giorno corrispondente";
$string["rep_type_6"]         = "Settimanale";
$string["rep_end_date"]       = "Ripeti fino al";
$string["rep_rep_day"]        = "Ripeti Girno";
$string["rep_for_weekly"]     = "(per (n) settimane)";
$string["rep_freq"]           = "Frequenza";
$string["rep_num_weeks"]      = "Numero di settimane";
$string["rep_for_nweekly"]    = "(per (n) settimane";
$string["ctrl_click"]         = "Usa il tasto Ctrl per selezionare piu' di una stanza";
$string["entryid"]            = "Entry ID ";
$string["repeat_id"]          = "Repeat ID "; 
$string["you_have_not_entered"] = "Non hai inserito";
$string["you_have_not_selected"] = "Non hai selezionato";
$string["valid_room"]         = "stanza.";
$string["valid_time_of_day"]  = "orari validi del giorno.";
$string["brief_description"]  = "Breve descrizione.";
$string["useful_n-weekly_value"] = "utile valore n-settimanale.";

// Used in view_entry.php
$string["description"]        = "Descrizione";
$string["room"]               = "Sala";
$string["createdby"]          = "Creato da";
$string["lastupdate"]         = "Ultima Modifica";
$string["deleteentry"]        = "Cancella";
$string["deleteseries"]       = "Cancella Serie";
$string["confirmdel"]         = "Sei sicuro\\nche vuoi\\ncancellare l\'elemento?\\n\\n";
$string["returnprev"]         = "Ritorna alla Pagina Precedente";
$string["invalid_entry_id"]   = "Entry ID non valido.";
$string["invalid_series_id"]  = "Series ID non valido.";

// Used in edit_entry_handler.php
$string["error"]              = "Errore";
$string["sched_conflict"]     = "Conflitto di Prenotazione";
$string["conflict"]           = "La nuova prenotazione sara' in conflitto con questa(e)";
$string["too_may_entrys"]     = "L'opzione selezionata crea troppi inserimenti. <br>Per favore usa una opzione differente!";
$string["returncal"]          = "Ritorna al calendario";
$string["failed_to_acquire"]  = "Fallito accesso esclusivo sul DB"; 
$string["invalid_booking"]    = "Prenotazione non valida";
$string["must_set_description"] = "Devi inserire una breve descrizione per la prenotazione. Per favore torna indietro e inseriscine una.";
$string["mail_subject_entry"] = "Prenotazione aggiunta/modificata per $mrbs_company MRBS";
$string["mail_body_new_entry"] = "E' stata registrata una nuova prenotazione, questi i dettagli:";
$string["mail_body_del_entry"] = "Una prenotazione e' stata cancellata, questi i dettagli:";
$string["mail_body_changed_entry"] = "Una prenotazione e' stata modificata, questi i dettagli:";
$string["mail_subject_delete"] = "Prenotazione cancellata per $mrbs_company MRBS";

// Authentication stuff
$string["accessdenied"]       = "Accesso Negato";
$string["norights"]           = "Non hai i diritti per modificare questo oggetto.";
$string["please_login"]       = "Effettua il log in";
$string["user_name"]          = "Matricola";
$string["user_password"]      = "Password";
$string["unknown_user"]       = "Utente sconosciuto";
$string["you_are"]            = "Tu sei";
$string["login"]              = "Log in";
$string["logoff"]             = "Log Off";

// Authentication database
$string["user_list"]          = "Lista utenti";
$string["edit_user"]          = "Edita utente";
$string["delete_user"]        = "Elimina questo utente";
//$string["user_name"]         = Use the same as above, for consistency.
//$string["user_password"]     = Use the same as above, for consistency.
$string["user_email"]         = "Indirizzo email";
$string["password_twice"]     = "Se vuoi modificare la password inseriscila due volte";
$string["passwords_not_eq"]   = "Errore: La password non corrisponde.";
$string["add_new_user"]       = "Aggiungi utente";
$string["rights"]             = "Diritti";
$string["action"]             = "Azione";
$string["user"]               = "Utente";
$string["administrator"]      = "Amministratore";
$string["unknown"]            = "Sconosciuto";
$string["ok"]                 = "OK";
$string["show_my_entries"]    = "Clicca per visualizzare tutti gli inserimenti";
$string["no_users_initial"]   = "Non ci sono utenti nel database che permettano la creazione iniziale di utenti";
$string["no_users_create_first_admin"] = "Crea un utente configurato come Amministratore, quindi potrai effettuare il login e creare altri utenti.";

// Used in search.php
$string["invalid_search"]     = "Valore di Ricerca vuoto o sbagliato.";
$string["search_results"]     = "Risultati ricerca per";
$string["nothing_found"]      = "Nessun risultato trovato.";
$string["records"]            = "Trovati ";
$string["through"]            = " attraverso ";
$string["of"]                 = " di ";
$string["previous"]           = "Precedente";
$string["next"]               = "Successivo";
$string["entry"]              = "Valore";
$string["view"]               = "Vista";
$string["advanced_search"]    = "Ricerca avanzata";
$string["search_button"]      = "Ricerca";
$string["search_for"]         = "Cerca per";
$string["from"]               = "Da";

// Used in report.php
$string["report_on"]          = "Report su incontri";
$string["report_start"]       = "Report su data inizio";
$string["report_end"]         = "Report su data fine";
$string["match_area"]         = "Trova area";
$string["match_room"]         = "Trova stanza";
$string["match_type"]         = "Corrispondenze";
$string["ctrl_click_type"]    = "Usa il tasto Ctrl per selezionare piu' di un tipo";
$string["match_entry"]        = "Trova descrizione breve";
$string["match_descr"]        = "Trova descrizione completa";
$string["include"]            = "Includi";
$string["report_only"]        = "Solo Report";
$string["summary_only"]       = "Solo Raggruppamento";
$string["report_and_summary"] = "Report e Raggruppamento";
$string["summarize_by"]       = "Raggruppa per";
$string["sum_by_descrip"]     = "Breve descrizione";
$string["sum_by_creator"]     = "Creatore";
$string["entry_found"]        = "trovato valore";
$string["entries_found"]      = "trovati valori";
$string["summary_header"]     = "Gruppo di (Valori) Ore";
$string["summary_header_per"] = "Sommario di (Valori) Periodi";
$string["total"]              = "Totale";
$string["submitquery"]        = "Esegui Report";
$string["sort_rep"]           = "Ordina Report per";
$string["sort_rep_time"]      = "Inizio Data/Ora";
$string["rep_dsp"]            = "Visualizza sul report";
$string["rep_dsp_dur"]        = "Durata";
$string["rep_dsp_end"]        = "Ora fine";

// Used in week.php
$string["weekbefore"]         = "Vai alla Settimana Precedente";
$string["weekafter"]          = "Vai alla Settimana Successiva";
$string["gotothisweek"]       = "Vai alla Settimana Corrente";

// Used in month.php
$string["monthbefore"]        = "Vai al Mese Precedente";
$string["monthafter"]         = "Vai al Mese Successivo";
$string["gotothismonth"]      = "Vai al Mese Corrente";

// Used in {day week month}.php
$string["no_rooms_for_area"]  = "Non ci sono sale per questa Area";

// Used in admin.php
$string["edit"]               = "Modifica";
$string["delete"]             = "Elimina";
$string["rooms"]              = "Stanze";
$string["in"]                 = "in";
$string["noareas"]            = "Nessun area";
$string["addarea"]            = "Aggiungi area";
$string["name"]               = "Nome";
$string["noarea"]             = "Nessun area selezionata";
$string["browserlang"]        = "Il tuo browser e' configurato con il seguente ordine di preferenza per le lingue";
$string["addroom"]            = "Aggiungi stanza";
$string["capacity"]           = "Capacita'";
$string["norooms"]            = "Nessuna stanza.";
$string["administration"]     = "Amministrazione";

// Used in edit_area_room.php
$string["editarea"]           = "Modifica area";
$string["change"]             = "Cambia";
$string["backadmin"]          = "Torna all'amministrazione";
$string["editroomarea"]       = "Modifica la descrizione dell'area o della stanza";
$string["editroom"]           = "Modifica stanza";
$string["update_room_failed"] = "Aggiornamento stanza fallito: ";
$string["error_room"]         = "Errore: stanza ";
$string["not_found"]          = " non trovata";
$string["update_area_failed"] = "Aggiornamento area fallito: ";
$string["error_area"]         = "Errore: area ";
$string["room_admin_email"]   = "Email del gestore della stanza";
$string["area_admin_email"]   = "Email del gestore dell'area";
$string["invalid_email"]      = "Email non valida!";

// Used in del.php
$string["deletefollowing"]    = "Questo cancellera' le seguenti prenotazioni";
$string["sure"]               = "Sei sicuro?";
$string["YES"]                = "SI";
$string["NO"]                 = "NO";
$string["delarea"]            = "Devi cancellare tutte le stanze in quest'area prima di proseguire ";

// Used in help.php
$string["about_mrbs"]         = "About MRBS";
$string["database"]           = "Database";
$string["system"]             = "Sistema operativo";
$string["servertime"]         = "Ora del Server";
$string["please_contact"]     = "Contatta ";
$string["for_any_questions"]  = "per qualsiasi altra domanda.";

// Used in mysql.inc AND pgsql.inc
$string["failed_connect_db"]  = "Errore fatale: Fallita connessione al database";

?>
