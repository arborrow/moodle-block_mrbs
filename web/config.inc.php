<?php

// This file is part of the MRBS block for Moodle
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

###########################################################################
#   MRBS Configuration File
#   You shouldn't have to modify this file as all options can be set via Moode - see CONTRIB-422
###########################################################################

//For integration with Moodle
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/config.php');
$cfg_mrbs = get_config('block/mrbs'); //get Moodle config settings for the MRBS block
###################
# Database settings
###################
// All database calls now use Moodle DB directly - no settings needed here

################################
# Site identification information
#################################
$mrbs_admin = $cfg_mrbs->admin;  //moodle username of the mrbs administrator
$mrbs_admin_email = $cfg_mrbs->admin_email; // "admin@MyMoodleSite.com";

# This is the text displayed in the upper left corner of every page. Either
# type the name of your organization, or you can put your logo like this :
# $mrbs_company = "<a href=http://www.your_organisation.com/>
# <img src=your_logo.gif border=0></a>";
$mrbs_company = $SITE->fullname;
$mrbs_company_url = $CFG->wwwroot;

# This is to fix URL problems when using a proxy in the environment.
# If links inside MRBS appear broken, then specify here the URL of
# your MRBS root directory, as seen by the users. For example:
# $url_base =  "http://webtools.uab.ericsson.se/oam";
# It is also recommended that you set this if you intend to use email
# notifications, to ensure that the correct URL is displayed in the
# notification.
$url_base = $cfg_mrbs->serverpath;


###################
# Calendar settings
###################
# Note: Be careful to avoid specify options that displays blocks overlaping
# the next day, since it is not properly handled.

# This setting controls whether to use "clock" based intervals (FALSE and
# the default) or user defined periods (TRUE).  If user-defined periods
# are used then $resolution, $morningstarts, $eveningends,
# $eveningends_minutes and $twentyfourhour_format are ignored.
$enable_periods = $cfg_mrbs->enable_periods;

if ($enable_periods == 0) { //if we are not using periods then set the following values, prevents error of unset variables
# Resolution - what blocks can be booked, in seconds.
# Default is half an hour: 1800 seconds.
    $resolution = $cfg_mrbs->resolution;

# Start and end of day, NOTE: These are integer hours only, 0-23, and
# morningstarts must be < eveningends. See also eveningends_minutes.
    $morningstarts = $cfg_mrbs->morningstarts;
    $eveningends   =$cfg_mrbs->eveningends;

# Minutes to add to $morningstarts to get to the real start of the day.
# Be sure to consider the value of $eveningends_minutes if you change
# this, so that you do not cause a day to finish before the start of
# the last period.  For example if resolution=3600 (1 hour)
# morningstarts = 8 and morningstarts_minutes = 30 then for the last
# period to start at say 4:30pm you would need to set eveningends = 16
# and eveningends_minutes = 30
    $morningstarts_minutes = $cfg_mrbs->morningstarts_min;

# Minutes to add to $eveningends hours to get the real end of the day.
# Examples: To get the last slot on the calendar to be 16:30-17:00, set
# eveningends=16 and eveningends_minutes=30. To get a full 24 hour display
# with 15-minute steps, set morningstarts=0; eveningends=23;
# eveningends_minutes=45; and resolution=900.
    $eveningends_minutes = $cfg_mrbs->eveningends_min;
}

# Define the name or description for your periods in chronological order
# For example:
# $periods[] = "Period&nbsp;1"
# $periods[] = "Period&nbsp;2"
# ...
# or
# $periods[] = "09:15&nbsp;-&nbsp;09:50"
# $periods[] = "09:55&nbsp;-&nbsp;10:35"
# ...
# &nbsp; is used to ensure that the name or description is not wrapped
# when the browser determines the column widths to use in day and week
# views

// Moodle HACK

if (!isset($cfg_mrbs->periods) or empty($cfg_mrbs->periods)) {
    $periods[] = "Period&nbsp;1";
    $periods[] = "Period&nbsp;2";
    $periods[] = "Period&nbsp;3";
    $periods[] = "Period&nbsp;4";
    $periods[] = "Period&nbsp;5";
    $periods[] = "Period&nbsp;6";
    $periods[] = "Period&nbsp;7";
    $periods[] = "Period&nbsp;8";
    $periods[] = "Period&nbsp;9";
    $periods[] = "Period&nbsp;10";
    $periods[] = "Period&nbsp;11";
    $periods[] = "Period&nbsp;12";
} else {
    $pds = explode("\n", $cfg_mrbs->periods);
    foreach ($pds as $pd) {
        $pd = trim($pd);
        $periods[] = $pd;
    }
}

# Start of week: 0 for Sunday, 1 for Monday, etc.
$weekstarts = $cfg_mrbs->weekstarts;

# Trailer date format: 0 to show dates as "Jul 10", 1 for "10 Jul"
$dateformat = $cfg_mrbs->dateformat;

# Time format in pages. 0 to show dates in 12 hour format, 1 to show them
# in 24 hour format
$twentyfourhour_format = $cfg_mrbs->timeformat;

########################
# Miscellaneous settings
########################

# Maximum repeating entrys (max needed +1):
$max_rep_entrys = $cfg_mrbs->max_rep_entrys + 1;

# Max advance days for booking
$max_advance_days = isset($cfg_mrbs->max_advance_days) ? $cfg_mrbs->max_advance_days : -1;

# Default report span in days:
$default_report_days = $cfg_mrbs->default_report_days;

# Results per page for searching:
$search["count"] = $cfg_mrbs->search_count;

# Page refresh time (in seconds). Set to 0 to disable
//$refresh_rate = $cfg_mrbs->refresh_rate;

# should areas be shown as a list or a drop-down select box?
$area_list_format = $cfg_mrbs->area_list_format;

# Entries in monthly view can be shown as start/end slot, brief description or
# both. Set to "description" for brief description, "slot" for time slot and
# "both" for both. Default is "both", but 6 entries per day are shown instead
# of 12.
$monthly_view_entries_details = $cfg_mrbs->monthly_view_entries_details;

# To view weeks in the bottom (trailer.php) as week numbers (42) instead of
# 'first day of the week' (13 Oct), set this to TRUE
$view_week_number = $cfg_mrbs->view_week_number;

# To display times on right side in day and week view, set to TRUE;
$times_right_side = $cfg_mrbs->times_right_side;

# Control the active cursor in day/week/month views.
$javascript_cursor = $cfg_mrbs->javascript_cursor; # Change to false if clients have old browsers
                           # incompatible with JavaScript.
$show_plus_link = $cfg_mrbs->show_plus_link; # Change to true to always show the (+) link as in
                        # MRBS 1.1.
$highlight_method = $cfg_mrbs->highlight_method; # One of "bgcolor", "class", "hybrid".

# Define default starting view (month, week or day)
# Default is day
$default_view = $cfg_mrbs->default_view;

# Define default room to start with (used by index.php)
# Room numbers can be determined by looking at the Edit or Delete URL for a
# room on the admin page.
# Default is 0
$default_room = $cfg_mrbs->default_room;

###############################################
# Authentication settings - read AUTHENTICATION
###############################################
$auth["session"] = "php";
$auth["type"] = "moodle";
if ($CFG->sessioncookiepath=='/') { //if one is not set in Moodle then use default
    $cookie_path_override = ''; //is this even needed with the moodle auth type?
} else { //if one is set in Moodle then use that path for MRBS block cookies
    $cookie_path_override = $CFG->sessioncookiepath;
}


###############################################
# Email settings
###############################################

# Set to TRUE if you want to be notified when entries are booked. Default is
# FALSE
define ("MAIL_ADMIN_ON_BOOKINGS", $cfg_mrbs->mail_admin_on_bookings);

# Set to TRUE if you want AREA ADMIN to be notified when entries are booked.
# Default is FALSE. Area admin emails are set in room_area admin page.
define ("MAIL_AREA_ADMIN_ON_BOOKINGS", $cfg_mrbs->mail_area_admin_on_bookings);

# Set to TRUE if you want ROOM ADMIN to be notified when entries are booked.
# Default is FALSE. Room admin emails are set in room_area admin page.
define ("MAIL_ROOM_ADMIN_ON_BOOKINGS", $cfg_mrbs->mail_room_admin_on_bookings);

# Set to TRUE if you want ADMIN to be notified when entries are deleted. Email
# will be sent to mrbs admin, area admin and room admin as per above settings,
# as well as to booker if MAIL_BOOKER is TRUE (see below).
define ("MAIL_ADMIN_ON_DELETE", $cfg_mrbs->mail_admin_on_delete);

# Set to TRUE if you want to be notified on every change (i.e, on new entries)
# but also each time they are edited. Default is FALSE (only new entries)
define ("MAIL_ADMIN_ALL", $cfg_mrbs->mail_admin_all);

# Set to TRUE is you want to show entry details in email, otherwise only a
# link to view_entry is provided. Irrelevant for deleted entries. Default is
# FALSE.
define ("MAIL_DETAILS", $cfg_mrbs->mail_details);

# Set to TRUE if you want BOOKER to receive a copy of his entries as well any
# changes (depends of MAIL_ADMIN_ALL, see below). Default is FALSE. To know
# how to set mrbs to send emails to users/bookers, see INSTALL.
define ("MAIL_BOOKER", $cfg_mrbs->mail_booker);

#****************************
# Miscellaneous settings

# Set the language used for emails (choose an available lang.* file).
# Default is 'en'.
if (isset($USER->lang)) {
    define ("MAIL_ADMIN_LANG", substr($USER->lang,0,2)); //I think this should be same as the locale based on the Moodle user's langage
} else { //use 'en' as default
    define ("MAIL_ADMIN_LANG", 'en');
}
# Set the email address of the From field. Default is $mrbs_admin_email
define ("MAIL_FROM", $cfg_mrbs->mail_from);

# Set the recipient email. Default is $mrbs_admin_email. You can define
# more than one recipient like this "john@doe.com,scott@tiger.com"
define ("MAIL_RECIPIENTS", $cfg_mrbs->mail_recipients);

# Set email address of the Carbon Copy field. Default is ''. You can define
# more than one recipient (see MAIL_RECIPIENTS)
define ("MAIL_CC", $cfg_mrbs->mail_cc);

// Users wanting to use a different strings can change set them as a custom language string
# Set the content of the Subject field for added/changed entries.
$mail["subject"] = get_string('mail_subject', 'block_mrbs', $mrbs_company);

# Set the content of the Subject field for deleted fields.
$mail["subject_delete"] = get_string('mail_subject_delete', 'block_mrbs', $mrbs_company);

# Set the content of the message when a new entry is booked. What you type
# here will be added at the top of the message body.
$mail["new_entry"] = get_string('mail_new_entry','block_mrbs');

# Set the content of the message when an entry is modified. What you type
# here will be added at the top of the message body.
$mail["changed_entry"] = get_string('mail_changed_entry','block_mrbs');

# Set the content of the message when an entry is deleted. What you type
# here will be added at the top of the message body.
$mail["deleted_entry"] = get_string('mail_deleted_entry','block_mrbs');

##########
# Language
##########

//Set locale - previously in language.php which is has now been removed, may be redundant and unnecessary but just in case
if (empty($locale)) { //quick and ugly hack to avoid PHP notice
    if (isset($USER->lang)) {
        $locale=substr($USER->lang,0,2);
    } else { //use en as default
        $locale='en';
    }
}
$windows_locale = "eng";

# Set this to 1 to use UTF-8 in all pages and in the database, otherwise
# text gets entered in the database in different encodings, dependent
# on the users' language
$unicode_encoding = 1; //this should not be an option in Moodle MRBS block

# Set this to a different language specifier to default to different
# language tokens. This must equate to a lang.* file in MRBS.
# e.g. use "fr" to use the translations in "lang.fr" as the default
# translations
// TODO: Evaluate how MRBS uses locale, convert make MRBS block more consistent with Moodle approach to locales
if (isset($USER->lang)) {
    $default_language_tokens = substr($USER->lang,0,2); //this could be either set to use the user default (or the site default)
} else { //use en as default
    $default_language_tokens = 'en';
}
// echo $default_language_tokens;

# Set this to 1 to disable the automatic language changing MRBS performs
# based on the user's browser language settings. It will ensure that
# the language displayed is always the value of $default_language_tokens,
# as specified above
$disable_automatic_language_changing = 1; //this should not be an option in Moodle MRBS block

# Set this to a valid locale (for the OS you run the MRBS server on)
# if you want to override the automatic locale determination MRBS
# performs
$override_locale = ""; //this should not be an option in Moodle MRBS block, let's keep it simple and just use Moodle's $USER->lang

# This next require must be done after the definitions above, as the definitions
# are used in the included file
#require_once "language.php"; //language.php deleted using get_string instead of get_vocab

#############
# Entry Types
#############
# This array maps entry type codes (letters A through J) into descriptions.
# Each type has a color (see TD.x classes in the style sheet mrbs.css).
#    A=Pink  B=Blue-green  C=Peach  D=Yellow      E=Light blue
#    F=Tan   G=Red         H=Aqua   I=Light green J=Gray
# The value for each type is a short (one word is best) description of the
# type. The values must be escaped for HTML output ("R&amp;D").
# Please leave I and E alone for compatibility.
# If a type's entry is unset or empty, that type is not defined; it will not
# be shown in the day view color-key, and not offered in the type selector
# for new or edited entries.

$typel["A"] = $cfg_mrbs->entry_type_a;
$typel["B"] = $cfg_mrbs->entry_type_b;
$typel["C"] = $cfg_mrbs->entry_type_c;
$typel["D"] = $cfg_mrbs->entry_type_d;
$typel["E"] = $cfg_mrbs->entry_type_e;
$typel["F"] = $cfg_mrbs->entry_type_f;
$typel["G"] = $cfg_mrbs->entry_type_g;
$typel["H"] = $cfg_mrbs->entry_type_h;
$typel["I"] = $cfg_mrbs->entry_type_i;
$typel["J"] = $cfg_mrbs->entry_type_j;

//These are here so that unchanged imported bookings can be replaced on new imports
if (!empty($cfg_mrbs->cronfile)) {
    $typel["K"] = get_string('importedbooking','block_mrbs');
    $typel["L"] = get_string('importedbookingmoved','block_mrbs');
}
$typel["U"] = get_string('unconfirmedbooking', 'block_mrbs');
//WARNING: DO NOT USE TYPE M, type M is used by import script and will delete other type M bookings
//TODO: Evaluate use of error_reporting to respect Moodle debugging settings
//Moodle should handle the error reporting level itself - do not need to set it here
//error_reporting (E_ALL ^ E_NOTICE);
