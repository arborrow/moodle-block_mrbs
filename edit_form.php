<?php
// This file is part of Moodle - http://moodle.org/
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

/**
 * Form for editing MRBS block instances.
 *
 * @package   block_mrbs
 * @copyright 2017 Frank Schütte
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_mrbs_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $CFG;

        // Fields for editing MRBS block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('configtitle', 'block_html'));
        $mform->setType('config_title', PARAM_TEXT);

        $cfg_mrbs = get_config('block/mrbs');

        $options = array(0 => get_string('pagewindow', 'block_mrbs'), 1 => get_string('newwindow', 'block_mrbs'));
        $mform->addElement('select', 'config_newwindow', get_string('config_new_window', 'block_mrbs'), $options);
        $mform->setDefault('config_newwindow',1);
        $mform->addElement('static', '', '', get_string('config_new_window2', 'block_mrbs'));
        
        $mform->addElement('text', 'config_serverpath', get_string('serverpath', 'block_mrbs'));
        $mform->setType('config_serverpath', PARAM_URL);
        $mform->setDefault('config_serverpath',$CFG->wwwroot.'/blocks/mrbs/web');
        $mform->addElement('static', '', '', get_string('adminview','block_mrbs'));
        
        $mform->addElement('text', 'config_admin', get_string('config_admin', 'block_mrbs'));
        $mform->addElement('static', '', '', get_string('config_admin2', 'block_mrbs'));
        $mform->setDefault('config_admin', $CFG->supportname);
        $mform->setType('config_admin', PARAM_TEXT);
        $mform->addElement('text', 'config_admin_email', get_string('config_admin_email', 'block_mrbs'), get_string('config_admin_email2', 'block_mrbs'), $CFG->supportemail, PARAM_TEXT);
        $options = array(0 => get_string('no'), 1 => get_string('yes'));
        $mform->addElement('selectyesno', 'config_enable_periods', get_string('config_enable_periods', 'block_mrbs'));
        $mform->addElement('static','','',get_string('config_enable_periods2','block_mrbs'));
        $mform->setDefault('config_enable_periods', 1);
        
        if (isset($cfg_mrbs->enable_periods)) {
            if ($cfg_mrbs->enable_periods == 0) {

                // Resolution

                unset($options);
                $strunits = get_string('resolution_units', 'block_mrbs');
                $options = array(
                    '900' => '15'.$strunits, '1800' => '30'.$strunits, '2700' => '45'.$strunits, '3600' => '60'.$strunits,
                    '4500' => '75'.$strunits, '5400' => '90'.$strunits, '6300' => '105'.$strunits, '7200' => '120'.$strunits
                );
                $mform->addElement('advcheckbox', 'config_resolution', get_string('config_resolution', 'block_mrbs'), get_string('config_resolution2', 'block_mrbs'), '1800', $options);

                // Start Time (Hours)
                unset($options);
                $options = array(
                    1 => '01', 2 => '02', 3 => '03', 4 => '04', 5 => '05', 6 => '06', 7 => '07', 8 => '08', 9 => '09', 10 => '10',
                    11 => '11', 12 => '12', 13 => '13', 14 => '14', 15 => '15', 16 => '16', 17 => '17', 18 => '18', 19 => '19', 20 => '20',
                    21 => '21', 22 => '22', 23 => '23'
                );
                $mform->addElement('advcheckbox', 'config_morningstarts', get_string('config_morningstarts', 'block_mrbs'), get_string('config_morningstarts2', 'block_mrbs'), 7, $options);

                // Start Time (Min)
                unset($options);
                $options = array(
                    0 => '00', 5 => '05', 10 => '10', 15 => '15', 20 => '20', 25 => '25', 30 => '30', 35 => '35', 40 => '40', 45 => '45',
                    50 => '50', 55 => '55'
                );
                $mform->addElement('advcheckbox', 'config_morningstarts_min', get_string('config_morningstarts_min', 'block_mrbs'), get_string('config_morningstarts_min2', 'block_mrbs'), 0, $options);
                
                // End Time (Hours)
                unset($options);
                $options = array(
                    1 => '01', 2 => '02', 3 => '03', 4 => '04', 5 => '05', 6 => '06', 7 => '07', 8 => '08', 9 => '09', 10 => '10',
                    11 => '11', 12 => '12', 13 => '13', 14 => '14', 15 => '15', 16 => '16', 17 => '17', 18 => '18', 19 => '19', 20 => '20',
                    21 => '21', 22 => '22', 23 => '23'
                );
                $mform->addElement('advcheckbox', 'config_eveningends', get_string('config_eveningends', 'block_mrbs'), get_string('config_eveningends2', 'block_mrbs'), 19, $options);
                
                // End Time Time (Min)
                unset($options);
                $options = array(
                    0 => '00', 5 => '05', 10 => '10', 15 => '15', 20 => '20', 25 => '25', 30 => '30', 35 => '35', 40 => '40', 45 => '45',
                    50 => '50', 55 => '55'
                );
                $mform->addElement('advcheckbox', 'config_eveningends_min', get_string('config_eveningends_min', 'block_mrbs'), get_string('config_eveningends_min2', 'block_mrbs'), 0, $options);
            } else {  //Use Custom Periods
                $mform->addElement('textarea', 'periods', get_string('config_periods', 'block_mrbs'));
                $mform->addElement('static', '', '', get_string('config_periods2', 'block_mrbs'));
                $mform->setType('periods', PARAM_TEXT);
            }
        }

        // Date Information

        //Start of Week
        unset($options);
        $options = array(
            0 => get_string('sunday', 'calendar'), 1 => get_string('monday', 'calendar'), 2 => get_string('tuesday', 'calendar'),
            3 => get_string('wednesday', 'calendar'), 4 => get_string('thursday', 'calendar'), 5 => get_string('friday', 'calendar'),
            6 => get_string('saturday', 'calendar')
        );
        $mform->addElement('select', 'config_weekstarts', get_string('config_weekstarts', 'block_mrbs'), $options);
        $mform->setDefault('config_weekstarts', 0);
        $mform->addElement('static', '', '', get_string('config_weekstarts2', 'block_mrbs'));

        //Length of week
        $mform->addElement('text', 'config_weeklength', get_string('config_weeklength', 'block_mrbs'));
        $mform->setDefault('config_weeklength', 7);
        $mform->setType(PARAM_INT);
        $mform->addElement('static', '', '', get_string('config_weeklength2', 'block_mrbs'));

        //Date Format
        unset($options);
        $options = array(0 => get_string('config_date_mmddyy', 'block_mrbs'), 1 => get_string('config_date_ddmmyy', 'block_mrbs'));
        $mform->addElement('select', 'config_dateformat', get_string('config_dateformat', 'block_mrbs'), $options);
        $mform->setDefault('config_dateformat', 0);
        $mform->addElement('static', '', '',  get_string('config_dateformat2', 'block_mrbs'));

        //Time format
        unset($options);
        $options = array(0 => get_string('timeformat_12', 'calendar'), 1 => get_string('timeformat_24', 'calendar'));
        $mform->addElement('select', 'config_timeformat', get_string('config_timeformat', 'block_mrbs'), $options);
        $mform->setDefault('config_timeformat', 1);
        $mform->addElement('static', '', '', get_string('config_timeformat2', 'block_mrbs'));

        // Misc Settings
        $mform->addElement('text', 'config_max_rep_entrys', get_string('config_max_rep_entrys', 'block_mrbs'));
        $mform->addElement('static', '', '', get_string('config_max_rep_entrys2', 'block_mrbs'));
        $mform->setDefault('config_max_rep_entrys', 365);
        $mform->setType('config_max_rep_entrys', PARAM_INT);
        
        $mform->addElement('text', 'config_max_advance_days', get_string('config_max_advance_days', 'block_mrbs'), get_string('config_max_advance_days2', 'block_mrbs'), -1, PARAM_INT);
        $mform->addElement('text', 'config_default_report_days', get_string('config_default_report_days', 'block_mrbs'), get_string('config_default_report_days2', 'block_mrbs'), 60, PARAM_INT);
        $mform->addElement('text', 'config_search_count', get_string('config_search_count', 'block_mrbs'), get_string('config_search_count2', 'block_mrbs'), 20, PARAM_INT);
        /*
        $mform->addElement('text', 'config_refresh_rate', get_string('config_refresh_rate', 'block_mrbs'), get_string('config_refresh_rate2', 'block_mrbs'), 0, PARAM_INT);

        */

        $options = array('list' => get_string('list'), 'select' => get_string('select'));
        $mform->addElement('select', 'config_area_list_format', get_string('config_area_list_format', 'block_mrbs'), $options);
        $mform->setDefault('config_area_list_format', 'list');
        $mform->addElement('static', '', '', get_string('config_area_list_format2', 'block_mrbs'));
        
        $options = array(
            'both' => get_string('both', 'block_mrbs'), 'description' => get_string('description'),
            'slot' => get_string('slot', 'block_mrbs')
        );
        $mform->addElement('select', 'config_monthly_view_entries_details', get_string('config_monthly_view_entries_details', 'block_mrbs'), $options);
        $mform->setDefault('config_monthly_view_entries_details', 'both');
        $mform->addElement('static', '', '', get_string('config_monthly_view_entries_details2', 'block_mrbs'));

        $mform->addElement('selectyesno', 'config_view_week_number', get_string('config_view_week_number', 'block_mrbs'));
        $mform->addElement('static', '', '', get_string('config_view_week_number2', 'block_mrbs'));

        $mform->addElement('selectyesno', 'config_times_right_side', get_string('config_times_right_side', 'block_mrbs'));
        $mform->addElement('static', '', '', get_string('config_times_right_side2', 'block_mrbs'));

        $mform->addElement('selectyesno', 'config_javascript_cursor', get_string('config_javascript_cursor', 'block_mrbs'));
        $mform->addElement('static', '', '', get_string('config_javascript_cursor2', 'block_mrbs'));
        $mform->setDefault('config_javascript_cursor', 1);

        $mform->addElement('selectyesno', 'config_show_plus_link', get_string('config_show_plus_link', 'block_mrbs'));
        $mform->addElement('static', '', '', get_string('config_show_plus_link2', 'block_mrbs'));
        $mform->setDefault('config_show_plus_link', 1);

        $options = array(
            'bgcolor' => get_string('bgcolor', 'block_mrbs'), 'class' => get_string('class', 'block_mrbs'),
            'hybrid' => get_string('hybrid', 'block_mrbs')
        );
        $mform->addElement('select', 'config_highlight_method', get_string('config_highlight_method', 'block_mrbs'), $options);
        $mform->setDefault('config_highlight_method', 'hybrid');
        $mform->addElement('static', '', '', get_string('config_highlight_method2', 'block_mrbs'));

        $options = array('day' => get_string('day'), 'month' => get_string('month', 'block_mrbs'), 'week' => get_string('week'));
        $mform->addElement('select', 'config_default_view', get_string('config_default_view', 'block_mrbs'), $options);
        $mform->setDefault('config_default_view', 'day');
        $mform->addElement('static', '', '', get_string('config_default_view2', 'block_mrbs'));

        $mform->addElement('text', 'config_default_room', get_string('config_default_room', 'block_mrbs'));
        $mform->addElement('static', '', '', get_string('config_default_room2', 'block_mrbs'));
        $mform->setType('config_default_room', PARAM_INT);
        
        // should this be the same as the Moodle Site cookie path?
        // $mform->addElement('text', 'cookie_path_override', get_string('config_cookie_path_override', 'block_mrbs'), get_string('config_cookie_path_override2', 'block_mrbs'), '', PARAM_LOCALURL);
        // 
        /*
        //select
        $options = array('' => get_string('', 'block_mrbs'), '' => get_string('', 'block_mrbs'));
        $mform->addElement('advcheckbox', '', get_string('config_', 'block_mrbs'), get_string('config_2', 'block_mrbs'), '', $options);
        //text or int
        $mform->addElement('text', '', get_string('config_', 'block_mrbs'), get_string('config_2', 'block_mrbs'), 0, PARAM_INT);
        */

        $mform->addElement('text', 'config_entry_type_a', get_string('config_entry_type', 'block_mrbs', 'A'), get_string('config_entry_type2', 'block_mrbs', 'A'), null, PARAM_TEXT);
        $mform->addElement('text', 'config_entry_type_b', get_string('config_entry_type', 'block_mrbs', 'B'), get_string('config_entry_type2', 'block_mrbs', 'B'), null, PARAM_TEXT);
        $mform->addElement('text', 'config_entry_type_c', get_string('config_entry_type', 'block_mrbs', 'C'), get_string('config_entry_type2', 'block_mrbs', 'C'), null, PARAM_TEXT);
        $mform->addElement('text', 'config_entry_type_d', get_string('config_entry_type', 'block_mrbs', 'D'), get_string('config_entry_type2', 'block_mrbs', 'D'), null, PARAM_TEXT);
        $mform->addElement('text', 'config_entry_type_e', get_string('config_entry_type', 'block_mrbs', 'E'), get_string('config_entry_type2', 'block_mrbs', 'E'), get_string('external', 'block_mrbs'), PARAM_TEXT);
        $mform->addElement('text', 'config_entry_type_f', get_string('config_entry_type', 'block_mrbs', 'F'), get_string('config_entry_type2', 'block_mrbs', 'F'), null, PARAM_TEXT);
        $mform->addElement('text', 'config_entry_type_g', get_string('config_entry_type', 'block_mrbs', 'G'), get_string('config_entry_type2', 'block_mrbs', 'G'), null, PARAM_TEXT);
        $mform->addElement('text', 'config_entry_type_h', get_string('config_entry_type', 'block_mrbs', 'H'), get_string('config_entry_type2', 'block_mrbs', 'H'), null, PARAM_TEXT);
        $mform->addElement('text', 'config_entry_type_i', get_string('config_entry_type', 'block_mrbs', 'I'), get_string('config_entry_type2', 'block_mrbs', 'I'), get_string('internal', 'block_mrbs'), PARAM_TEXT);
        $mform->addElement('text', 'config_entry_type_j', get_string('config_entry_type', 'block_mrbs', 'J'), get_string('config_entry_type2', 'block_mrbs', 'J'), null, PARAM_TEXT);
        $options = array('0' => get_string('no'), '1' => get_string('yes'));
        $mform->addElement('advcheckbox', 'config_mail_admin_on_bookings', get_string('config_mail_admin_on_bookings', 'block_mrbs'), get_string('config_mail_admin_on_bookings2', 'block_mrbs'), '0', $options);
        $options = array('0' => get_string('no'), '1' => get_string('yes'));
        $mform->addElement('advcheckbox', 'config_mail_area_admin_on_bookings', get_string('config_mail_area_admin_on_bookings', 'block_mrbs'), get_string('config_mail_area_admin_on_bookings2', 'block_mrbs'), 0, $options);
        $options = array('0' => get_string('no'), '1' => get_string('yes'));
        $mform->addElement('advcheckbox', 'config_mail_room_admin_on_bookings', get_string('config_mail_room_admin_on_bookings', 'block_mrbs'), get_string('config_mail_room_admin_on_bookings2', 'block_mrbs'), 0, $options);
        $options = array('0' => get_string('no'), '1' => get_string('yes'));
        $mform->addElement('advcheckbox', 'config_mail_admin_on_delete', get_string('config_mail_admin_on_delete', 'block_mrbs'), get_string('config_mail_admin_on_delete2', 'block_mrbs'), 0, $options);
        $options = array('0' => get_string('no'), '1' => get_string('yes'));
        $mform->addElement('advcheckbox', 'config_mail_admin_all', get_string('config_mail_admin_all', 'block_mrbs'), get_string('config_mail_admin_all2', 'block_mrbs'), 0, $options);
        $options = array('0' => get_string('no'), '1' => get_string('yes'));
        $mform->addElement('advcheckbox', 'config_mail_details', get_string('config_mail_details', 'block_mrbs'), get_string('config_mail_details2', 'block_mrbs'), 0, $options);
        $options = array('0' => get_string('no'), '1' => get_string('yes'));
        $mform->addElement('advcheckbox', 'config_mail_booker', get_string('config_mail_booker', 'block_mrbs'), get_string('config_mail_booker2', 'block_mrbs'), 0, $options);
        $mform->addElement('text', 'config_mail_from', get_string('config_mail_from', 'block_mrbs'), get_string('config_mail_from2', 'block_mrbs'), $CFG->supportemail, PARAM_TEXT);
        $mform->addElement('text', 'config_mail_recipients', get_string('config_mail_recipients', 'block_mrbs'), get_string('config_mail_recipients2', 'block_mrbs'), $CFG->supportemail, PARAM_TEXT);
        $mform->addElement('text', 'config_mail_cc', get_string('config_mail_cc', 'block_mrbs'), get_string('config_mail_cc2', 'block_mrbs'), null, PARAM_TEXT);
        $mform->addElement('text', 'config_cronfile', get_string('cronfile', 'block_mrbs'), get_string('cronfiledesc', 'block_mrbs'), null, PARAM_TEXT);
    }

    function set_data($defaults) {
        if (!empty($this->block->config) && is_object($this->block->config)) {
            $text = $this->block->config->text;
            $draftid_editor = file_get_submitted_draft_itemid('config_text');
            if (empty($text)) {
                $currenttext = '';
            } else {
                $currenttext = $text;
            }
            $defaults->config_text['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_html', 'content', 0, array('subdirs'=>true), $currenttext);
            $defaults->config_text['itemid'] = $draftid_editor;
            $defaults->config_text['format'] = $this->block->config->format;
        } else {
            $text = '';
        }

        if (!$this->block->user_can_edit() && !empty($this->block->config->title)) {
            // If a title has been set but the user cannot edit it format it nicely
            $title = $this->block->config->title;
            $defaults->config_title = format_string($title, true, $this->page->context);
            // Remove the title from the config so that parent::set_data doesn't set it.
            unset($this->block->config->title);
        }

        // have to delete text here, otherwise parent::set_data will empty content
        // of editor
        unset($this->block->config->text);
        parent::set_data($defaults);
        // restore $text
        if (!isset($this->block->config)) {
            $this->block->config = new stdClass();
        }
        $this->block->config->text = $text;
        if (isset($title)) {
            // Reset the preserved title
            $this->block->config->title = $title;
        }
    }
}
