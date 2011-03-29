<?
# $Id: lang.es.php,v 1.3 2007/04/15 23:44:37 arborrow Exp $

# This file contains PHP code that specifies language specific strings
# The default strings come from lang.en, and anything in a locale
# specific file will overwrite the default. This is a Spanish file.
#
#
#
#
# This file is PHP code. Treat it as such.

# The charset to use in "Content-type" header
$vocab["charset"]            = "iso-8859-1";

# Used in style.php
$vocab["mrbs"]               = "Gestor de Reserva de Salas";

# Used in functions.php
$vocab["report"]             = "Informes";
$vocab["admin"]              = "Administración";
$vocab["help"]               = "Ayuda";
$vocab["search"]             = "Búsqueda:";
$vocab["not_php3"]             = "<H1>ATENCIÓN: Es probable que no funcione con PHP3</H1>";

# Used in day.php
$vocab["bookingsfor"]        = "Reservas para el";
$vocab["bookingsforpost"]    = ""; # Goes after the date
$vocab["areas"]              = "Edificios";
$vocab["daybefore"]          = " Día anterior";
$vocab["dayafter"]           = "Día siguiente ";
$vocab["gototoday"]          = "Día actual";
$vocab["goto"]               = "Ir a";
$vocab["highlight_line"]     = "Resaltar esta línea";
$vocab["click_to_reserve"]   = "Pulsa sobre la celda para hacer una reserva.";

# Used in trailer.php
$vocab["viewday"]            = "Ver día";
$vocab["viewweek"]           = "Ver semana";
$vocab["viewmonth"]          = "Ver mes";
$vocab["ppreview"]           = "Previsualización para imprimir";

# Used in edit_entry.php
$vocab["addentry"]           = "Nueva reserva";
$vocab["editentry"]          = "Editar reserva";
$vocab["editseries"]         = "Editar series";
$vocab["namebooker"]         = "Nombre que figurará:";
$vocab["fulldescription"]    = "Descripción completa:<br>&nbsp;&nbsp;(Número de personas,<br>&nbsp;&nbsp;Interna/Externa, etc)";
$vocab["date"]               = "Fecha:";
$vocab["start_date"]         = "Fecha comienzo:";
$vocab["end_date"]           = "Fecha final:";
$vocab["time"]               = "Hora:";
$vocab["period"]             = "Periodo:";
$vocab["duration"]           = "Duración:";
$vocab["seconds"]            = "segundos";
$vocab["minutes"]            = "minutos";
$vocab["hours"]              = "horas";
$vocab["days"]               = "días";
$vocab["weeks"]              = "semanas";
$vocab["years"]              = "años";
$vocab["periods"]            = "periodos";
$vocab["all_day"]            = "Día completo";
$vocab["type"]               = "Tipo:";
$vocab["internal"]           = "Interna";
$vocab["external"]           = "Externa";
$vocab["save"]               = "Guardar";
$vocab["rep_type"]           = "Tipo de repetición:";
$vocab["rep_type_0"]         = "Ninguna";
$vocab["rep_type_1"]         = "Diaria";
$vocab["rep_type_2"]         = "Semanal";
$vocab["rep_type_3"]         = "Mensual";
$vocab["rep_type_4"]         = "Anual";
$vocab["rep_type_5"]         = "Mensual, día correspondiente";
$vocab["rep_type_6"]         = "n-Semanal";
$vocab["rep_end_date"]       = "Fecha límite de repetición:";
$vocab["rep_rep_day"]        = "Día Repetición:";
$vocab["rep_for_weekly"]     = "(para semanal)";
$vocab["rep_freq"]           = "Frecuencia:";
$vocab["rep_num_weeks"]      = "Número de semanas";
$vocab["rep_for_nweekly"]    = "(n-semanas)";
$vocab["ctrl_click"]         = "Utilice Control+Clic para seleccionar más de una sala";
$vocab["entryid"]            = "Introducir ID ";
$vocab["repeat_id"]          = "Repetir ID "; 
$vocab["you_have_not_entered"] = "No ha introducido";
$vocab["you_have_not_selected"] = "No ha seleccionado";
$vocab["valid_room"]         = "sala.";
$vocab["valid_time_of_day"]  = "horario válido del día.";
$vocab["brief_description"]  = "Breve descripción.";
$vocab["useful_n-weekly_value"] = "valor n-weekly útil.";

# Used in view_entry.php
$vocab["description"]        = "Descripción:";
$vocab["room"]               = "Sala";
$vocab["createdby"]          = "Creada por:";
$vocab["lastupdate"]         = "Última actualización:";
$vocab["deleteentry"]        = "Borrar reserva";
$vocab["deleteseries"]       = "Borrar serie";
$vocab["confirmdel"]         = "¿Está seguro de querer borrar esta reserva?";
$vocab["returnprev"]         = "Volver a la página anterior";
$vocab["invalid_entry_id"]   = "Endrada id. inválida.";
$vocab["invalid_series_id"]  = "Serie id. inválida.";

# Used in edit_entry_handler.php
$vocab["error"]              = "Error";
$vocab["sched_conflict"]     = "Conflicto de planificación";
$vocab["conflict"]           = "La nueva reserva entra en conflicto con la(s) siguiente(s) entrada(s):";
$vocab["too_may_entrys"]     = "Las opciones seleccionadas crearán demasiadas entradas.<BR>Por favor, revise las opciones";
$vocab["returncal"]          = "Volver a vista de calendario";
$vocab["failed_to_acquire"]  = "No ha sido posible adquirir acceso exclusivo a la base de datos"; 
$vocab["mail_subject_entry"] = $mail["subject"];
$vocab["mail_body_new_entry"] = $mail["new_entry"];
$vocab["mail_body_del_entry"] = $mail["deleted_entry"];
$vocab["mail_body_changed_entry"] = $mail["changed_entry"];
$vocab["mail_subject_delete"] = $mail["subject_delete"];

# Authentication stuff
$vocab["accessdenied"]       = "Acceso denegado";
$vocab["norights"]           = "No tiene autorización para modificar este dato.";
$vocab["please_login"]       = "Por favor, autentifíquese";
$vocab["user_name"]          = "Nombre";
$vocab["user_password"]      = "Contraseña";
$vocab["unknown_user"]       = "Usuario desconocido";
$vocab["you_are"]            = "Está como";
$vocab["login"]              = "Entrar";
$vocab["logoff"]             = "Salir";

# Authentication database
$vocab["user_list"]          = "Lista de usuarios";
$vocab["edit_user"]          = "Editar usuario";
$vocab["delete_user"]        = "Borrar este usuario";
#$vocab["user_name"]         = Use the same as above, for consistency.
#$vocab["user_password"]     = Use the same as above, for consistency.
$vocab["user_email"]         = "Direcciones de correo";
$vocab["password_twice"]     = "Si desea cambiar la contraseña, escriba la nueva contraseña dos veces";
$vocab["passwords_not_eq"]   = "Error: las contraseñas no coinciden.";
$vocab["add_new_user"]       = "Añadir un nuevo usuario";
$vocab["rights"]             = "Permisos";
$vocab["action"]             = "Acción";
$vocab["user"]               = "Usuario";
$vocab["administrator"]      = "Administrador";
$vocab["unknown"]            = "Desconocido";
$vocab["ok"]                 = "OK";
$vocab["show_my_entries"]    = "Pulsa para mostrar todas mis entradas subidas";

# Used in search.php
$vocab["invalid_search"]     = "Cadena de búsqueda vacía o incorrecta.";
$vocab["search_results"]     = "Buscar resultados de:";
$vocab["nothing_found"]      = "No se encontraron coincidencias.";
$vocab["records"]            = "Registros ";
$vocab["through"]            = " a través ";
$vocab["of"]                 = " de ";
$vocab["previous"]           = "Anterior";
$vocab["next"]               = "Siguiente";
$vocab["entry"]              = "Entrada";
$vocab["view"]               = "Ver";
$vocab["advanced_search"]    = "Búsqueda avanzada";
$vocab["search_button"]      = "Búsqueda";
$vocab["search_for"]         = "Búsqueda para";
$vocab["from"]               = "De";

# Used in report.php
$vocab["report_on"]          = "Informe de reservas:";
$vocab["report_start"]       = "Desde:";
$vocab["report_end"]         = "Hasta:";
$vocab["match_area"]         = "Encontrar edificio:";
$vocab["match_room"]         = "Encontar sala:";
$vocab["match_type"]         = "Seleccionar ítem:";
$vocab["ctrl_click_type"]    = "Utilice Control+Clic para seleccionar más de un ítem";
$vocab["match_entry"]        = "Encontrar descripción breve:";
$vocab["match_descr"]        = "Encontrar descripción completa:";
$vocab["include"]            = "Incluir:";
$vocab["report_only"]        = "Sólo el Informe";
$vocab["summary_only"]       = "Sólo el Resumen";
$vocab["report_and_summary"] = "Informe y Resumen";
$vocab["summarize_by"]       = "Resumir por:";
$vocab["sum_by_descrip"]     = "Descripción breve";
$vocab["sum_by_creator"]     = "Creador";
$vocab["entry_found"]        = "registro encontrado";
$vocab["entries_found"]      = "registros encontrados";
$vocab["summary_header"]     = "Resumen de (Entradas) horas";
$vocab["summary_header_per"] = "Resumen de (Entradas) Periodos";
$vocab["total"]              = "Total";
$vocab["submitquery"]        = "Enviar Informe";
$vocab["sort_rep"]           = "Ordenar informes por:";
$vocab["sort_rep_time"]      = "Inicio Fecha/Hora";
$vocab["rep_dsp"]            = "Mostrar en el informe:";
$vocab["rep_dsp_dur"]        = "Duración";
$vocab["rep_dsp_end"]        = "Hora final";

# Used in week.php
$vocab["weekbefore"]         = "Ir a la semana anterior";
$vocab["weekafter"]          = "Ir a la semana siguiente";
$vocab["gotothisweek"]       = "Ir a la semana actual";

# Used in month.php
$vocab["monthbefore"]        = "Ir al mes anterior";
$vocab["monthafter"]         = "Ir al mes siguiente";
$vocab["gotothismonth"]      = "Ir al mes actual";

# Used in {day week month}.php
$vocab["no_rooms_for_area"]  = "No hay salas definidas para este edificio";

# Used in admin.php
$vocab["edit"]               = "Editar";
$vocab["delete"]             = "Borrar";
$vocab["rooms"]              = "Salas";
$vocab["in"]                 = "en";
$vocab["noareas"]            = "No hay Edificios";
$vocab["addarea"]            = "Agregar Edificio";
$vocab["name"]               = "Nombre";
$vocab["noarea"]             = "No se seleccionó edificio";
$vocab["browserlang"]        = "Su visor esta configurado para usar los siguientes idiomas:";
$vocab["postbrowserlang"]    = ".";
$vocab["addroom"]            = "Agregar sala";
$vocab["capacity"]           = "Capacidad (personas)";
$vocab["norooms"]            = "No hay salas.";
$vocab["administration"]     = "Administración";

# Used in edit_area_room.php
$vocab["editarea"]           = "Editar Edificio";
$vocab["change"]             = "Cambiar";
$vocab["backadmin"]          = "Volver a Administración";
$vocab["editroomarea"]       = "Editar descripción del Edificio o Sala";
$vocab["editroom"]           = "Editar Sala";
$vocab["update_room_failed"] = "Error en la actualización de la Sala: ";
$vocab["error_room"]         = "Error: sala ";
$vocab["not_found"]          = " no encontrado";
$vocab["update_area_failed"] = "Error en la Actualización del Edificio: ";
$vocab["error_area"]         = "Error: Edificio ";
$vocab["room_admin_email"]   = "Email administrador de la Sala:";
$vocab["area_admin_email"]   = "Email administrador del Edificio:";
$vocab["invalid_email"]      = "Dirección de correo inválida";

# Used in del.php
$vocab["deletefollowing"]    = "Se borrarán las siguientes agendas";
$vocab["sure"]               = "¿Está seguro?";
$vocab["YES"]                = "SÍ";
$vocab["NO"]                 = "NO";
$vocab["delarea"]            = "Debe borrar todas las salas antes de poder borrar el edificio<p>";

# Used in help.php
$vocab["about_mrbs"]         = "Acerca de MRBS";
$vocab["database"]           = "Base de datos: ";
$vocab["system"]             = "Sistema: ";
$vocab["please_contact"]     = "Por favor, póngase en contacto con ";
$vocab["for_any_questions"]  = "para cualquier duda que tenga.";

# Used in mysql.php AND pgsql.php
$vocab["failed_connect_db"]  = "Error grave: No se puede conectar con la base de datos";

?>
