<?php // -*-mode: PHP; coding:utf-8;-*-

// $Id: block_mrbs.php,v 1.1 2009/02/26 07:20:12 arborrow Exp $

// This file contains PHP code that specifies language specific strings
// The default strings come from lang.en, and anything in a locale
// specific file will overwrite the default. This is a French file.
//
// Translations provided by: Thierry Wehr, thierry_bo
//              updated by:  Alain Portal, dionysos-sf
//
//
// This file is PHP code. Treat it as such.

// The charset to use in "Content-type" header
$string["charset"]            = "utf-8";

// Used for Moodle
$string['blockname'] = 'Système de Réservation';
$string['accessmrbs'] = 'Administrer Ressources';

// Used in style.inc
$string["mrbs"]               = "Système de Réservation de Ressources";

// Used in functions.inc
$string["report"]             = "Rapport";
$string["admin"]              = "Gestion";
$string["help"]               = "Aide";
$string["search"]             = "Recherche&nbsp;";
$string["not_php3"]           = "ATTENTION&nbsp;: Cette application peut ne pas fonctionner correctement avec PHP3";

// Used in day.php
$string["bookingsfor"]        = "Réservation pour<br>";
$string["bookingsforpost"]    = "";
$string["areas"]              = "Lieux";
$string["daybefore"]          = "Aller au jour précédent";
$string["dayafter"]           = "Aller au jour suivant";
$string["gototoday"]          = "Aujourd'hui";
$string["goto"]               = "Afficher";
$string["highlight_line"]     = "Surligner cette ligne";
$string["click_to_reserve"]   = "Cliquer sur la case pour réserver.";

// Used in trailer.inc
$string["viewday"]            = "Voir la journée";
$string["viewweek"]           = "Voir la semaine";
$string["viewmonth"]          = "Voir le mois";
$string["ppreview"]           = "Format imprimable";

// Used in edit_entry.php
$string["addentry"]           = "Ajouter une réservation";
$string["editentry"]          = "Éditer une réservation";
$string["copyentry"]          = "Copier une réservation";
$string["editseries"]         = "Éditer une périodicité";
$string["copyseries"]         = "Copier une périodicité";
$string["namebooker"]         = "Brève description";
$string["fulldescription"]    = "Description complète&nbsp;:<br>&nbsp;&nbsp;(Nombre de personnes,<br>&nbsp;&nbsp;Interne/Externe etc)";
$string["date"]               = "Date&nbsp;";
$string["start_date"]         = "Date de début&nbsp;";
$string["end_date"]           = "Date de fin&nbsp;";
$string["time"]               = "Heure&nbsp;";
$string["period"]             = "Période&nbsp;";
$string["duration"]           = "Durée&nbsp;";
$string["seconds"]            = "secondes";
$string["minutes"]            = "minutes";
$string["hours"]              = "heures";
$string["days"]               = "jours";
$string["weeks"]              = "semaines";
$string["years"]              = "années";
$string["periods"]            = "periodes";
$string["all_day"]            = "Journée entière";
$string["type"]               = "Type&nbsp;";
$string["internal"]           = "Interne";
$string["external"]           = "Externe";
$string["save"]               = "Enregistrer";
$string["rep_type"]           = "Type de périodicité&nbsp;";
$string["rep_type_0"]         = "Aucune";
$string["rep_type_1"]         = "Jour";
$string["rep_type_2"]         = "Semaine";
$string["rep_type_3"]         = "Mois";
$string["rep_type_4"]         = "Année";
$string["rep_type_5"]         = "Mois, même jour semaine";
$string["rep_type_6"]         = "tous les n semaines";
$string["rep_end_date"]       = "Date de fin de périodicité&nbsp;";
$string["rep_rep_day"]        = "Jour&nbsp;";
$string["rep_for_weekly"]     = "(pour n-semaines)";
$string["rep_freq"]           = "Fréquence&nbsp;";
$string["rep_num_weeks"]      = "Intervalle de semaines";
$string["rep_for_nweekly"]    = "(pour n-semaines)";
$string["ctrl_click"]         = "CTRL + clic souris pour sélectionner plusieurs salles";
$string["entryid"]            = "Réservation N°";
$string["repeat_id"]          = "Périodicité N°";
$string["you_have_not_entered"] = "Vous n'avez pas saisi";
$string["you_have_not_selected"] = "Vous n'avez pas sélectionné";
$string["valid_room"]         = "salle.";
$string["valid_time_of_day"]  = "une heure valide.";
$string["brief_description"]  = "la description brève.";
$string["useful_n-weekly_value"] = "un intervalle de semaines valide.";

// Used in view_entry.php
$string["description"]        = "Description&nbsp;";
$string["room"]               = "Salle&nbsp;";
$string["createdby"]          = "Créée par&nbsp;";
$string["lastupdate"]         = "Dernière mise à jour&nbsp;";
$string["deleteentry"]        = "Effacer une réservation";
$string["deleteseries"]       = "Effacer une périodicité";
$string["confirmdel"]         = "Êtes-vous sûr\\nde vouloir effacer\\ncette réservation ?\\n\\n";
$string["returnprev"]         = "Retour à la page précédente";
$string["invalid_entry_id"]   = "N° de réservation invalide.";
$string["invalid_series_id"]  = "N° de série invalide.";

// Used in edit_entry_handler.php
$string["error"]              = "Erreur";
$string["sched_conflict"]     = "Conflit entre réservations";
$string["conflict"]           = "La nouvelle réservation entre en conflit avec la(les) réservation(s) suivante(s)&nbsp;";
$string["too_may_entrys"]     = "Les options choisies créeront trop de réservations.<br>Choisissez des options différentes&nbsp;!";
$string["returncal"]          = "Retour au calendrier";
$string["failed_to_acquire"]  = "Erreur, impossible d'obtenir l'accès exclusif à la base de données";
$string["invalid_booking"]    = "Réservation invalide";
$string["must_set_description"] = "Vous devez définir une brève description pour la réservation. Veuillez revenir en arrière et en saisir une.";
$string["mail_subject_entry"] = "Réservation ajoutée/modifiée dans le système de réservation $mrbs_company";
$string["mail_body_new_entry"] = "Une nouvelle réservation a été faite, voici les détails:";
$string["mail_body_del_entry"] = "Une réservation a été supprimée, voici les détails :";
$string["mail_body_changed_entry"] = "Une réservation a été modifiée, voici les détails :";
$string["mail_subject_delete"] = "Réservation supprimée dans le système de réservation $mrbs_company";

// Authentication stuff
$string["accessdenied"]       = "Accès refusé";
$string["norights"]           = "Vous n'avez pas les droits suffisants pour faire une modification.";
$string["please_login"]       = "Veuillez-vous identifier";
$string["user_name"]          = "Nom";
$string["user_password"]      = "Mot de passe";
$string["unknown_user"]       = "Utilisateur non identifié";
$string["you_are"]            = "Vous êtes";
$string["login"]              = "S'identifier";
$string["logoff"]             = "Se déconnecter";

// Authentication database
$string["user_list"]          = "Liste des utilisateurs";
$string["edit_user"]          = "Modification de l'utilisateur";
$string["delete_user"]        = "Supprimer cet utilisateur";
//$string["user_name"]         = Use the same as above, for consistency.
//$string["user_password"]     = Use the same as above, for consistency.
$string["user_email"]         = "Adresse courriel";
$string["password_twice"]     = "Pour modifier le mot de passe, tapez le nouveau mot de passe ici deux fois";
$string["passwords_not_eq"]   = "Erreur&nbsp;: Les mots de passe ne sont pas identiques.";
$string["add_new_user"]       = "Ajouter un nouvel utilisateur";
$string["rights"]             = "Droits";
$string["action"]             = "Action";
$string["user"]               = "Utilisateur";
$string["administrator"]      = "Administrateur";
$string["unknown"]            = "Inconnu";
$string["ok"]                 = "OK";
$string["show_my_entries"]    = "Afficher mes réservations à venir";
$string["no_users_initial"]   = "Pas d'utilisateur dans la base de données, vous pouvez créer l'utilisateur initial";
$string["no_users_create_first_admin"] = "Créez un utilisateur de type administrateur, identifiez-vous en tant que tel puis créez les autres utilisateurs.";

// Used in search.php
$string["invalid_search"]     = "Recherche invalide.";
$string["search_results"]     = "Résultats de la recherche pour&nbsp;";
$string["nothing_found"]      = "Aucune réservation n'a été trouvée.";
$string["records"]            = "Enregistrements ";
$string["through"]            = " à ";
$string["of"]                 = " sur ";
$string["previous"]           = "Précédent";
$string["next"]               = "Suivant";
$string["entry"]              = "Réservation";
$string["view"]               = "Voir";
$string["advanced_search"]    = "Recherche avancée";
$string["search_button"]      = "Recherche";
$string["search_for"]         = "Rechercher";
$string["from"]               = "À partir de";

// Used in report.php
$string["report_on"]          = "Rapport des réservations&nbsp;";
$string["report_start"]       = "Date de début du rapport&nbsp;";
$string["report_end"]         = "Date de fin du rapport&nbsp;";
$string["match_area"]         = "Lieu&nbsp;";
$string["match_room"]         = "Salle&nbsp;";
$string["match_type"]         = "Type&nbsp;";
$string["ctrl_click_type"]    = "CTRL + clic souris pour sélectionner plusieurs types";
$string["match_entry"]        = "Brève description&nbsp;";
$string["match_descr"]        = "Description complète&nbsp;";
$string["include"]            = "Inclure&nbsp;";
$string["report_only"]        = "le rappport seulement";
$string["summary_only"]       = "le résumé seulement";
$string["report_and_summary"] = "le rapport et le résumé";
$string["summarize_by"]       = "Résumé par&nbsp;";
$string["sum_by_descrip"]     = "Brève description";
$string["sum_by_creator"]     = "Créateur";
$string["entry_found"]        = "réservation trouvée";
$string["entries_found"]      = "réservations trouvées";
$string["summary_header"]     = "Décompte des Heures Réservées";
$string["summary_header_per"] = "Décompte des Périodes Réservées";
$string["total"]              = "Total";
$string["submitquery"]        = "Afficher le rapport";
$string["sort_rep"]           = "Trier par&nbsp;";
$string["sort_rep_time"]      = "Date/Heure";
$string["rep_dsp"]            = "Afficher&nbsp;";
$string["rep_dsp_dur"]        = "la durée";
$string["rep_dsp_end"]        = "l'heure de fin";

// Used in week.php
$string["weekbefore"]         = "Voir la semaine précédente";
$string["weekafter"]          = "Voir la semaine suivante";
$string["gotothisweek"]       = "Voir cette semaine-ci";

// Used in month.php
$string["monthbefore"]        = "Voir le mois précédent";
$string["monthafter"]         = "Voir le mois suivant";
$string["gotothismonth"]      = "Voir ce mois-ci";

// Used in {day week month}.php
$string["no_rooms_for_area"]  = "Aucune salle n'est définie pour ce lieu";

// Used in admin.php
$string["edit"]               = "Modifier";
$string["delete"]             = "Supprimer";
$string["rooms"]              = "Salles";
$string["in"]                 = "de&nbsp;:";
$string["noareas"]            = "Pas de lieux";
$string["addarea"]            = "Ajouter un lieu";
$string["name"]               = "Nom";
$string["noarea"]             = "Sélectionnez d'abord un lieu";
$string["browserlang"]        = "Votre navigateur est configuré pour utiliser la langue";
$string["addroom"]            = "Ajouter une salle";
$string["capacity"]           = "Maximum de personnes";
$string["norooms"]            = "Aucune salle n'est créée pour ce lieu.";
$string["administration"]     = "Administration";

// Used in edit_area_room.php
$string["editarea"]           = "Modifier le lieu";
$string["change"]             = "Changer";
$string["backadmin"]          = "Revenir à l'écran de gestion";
$string["editroomarea"]       = "Modifiez la description d'un lieu ou d'une salle";
$string["editroom"]           = "Modifier la salle";
$string["update_room_failed"] = "La mise à jour de la salle a échoué&nbsp;: ";
$string["error_room"]         = "Erreur&nbsp;: salle ";
$string["not_found"]          = " non trouvée";
$string["update_area_failed"] = "La mise à jour du lieu a échoué&nbsp;: ";
$string["error_area"]         = "Erreur&nbsp;: lieu ";
$string["room_admin_email"]   = "Courriels des responsables&nbsp;";
$string["area_admin_email"]   = "Courriels des responsables&nbsp;";
$string["invalid_email"]      = "Adresse courriel invalide&nbsp;!";

// Used in del.php
$string["deletefollowing"]    = "Vous allez supprimer les réservations suivantes";
$string["sure"]               = "Êtes-vous certains&nbsp;?";
$string["YES"]                = "OUI";
$string["NO"]                 = "NON";
$string["delarea"]            = "Vous devez supprimer toutes les salles de ce lieu avant de pouvoir le supprimer<p>";

// Used in help.php
$string["about_mrbs"]         = "À propos de MRBS (Meeting Room Booking System)";
$string["database"]           = "Base de donnée";
$string["system"]             = "Système d'exploitation";
$string["servertime"]         = "Heure du serveur";
$string["please_contact"]     = "Contactez ";
$string["for_any_questions"]  = "si vous avez une question qui n'est pas traitée ici.";

// Used in mysql.inc AND pgsql.inc
$string["failed_connect_db"]  = "Erreur grave&nbsp;: échec de la connexion à la base de données";

?>
