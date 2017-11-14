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

class block_mrbs extends block_base {

    function init() {
        $this->title = get_string('blockname', 'block_mrbs');
        //TODO: $this->content_type = BLOCK_TYPE_TEXT;
    }

    function has_config() {
        return true;
    }

    function applicable_formats() {
        return array('all' => true);
    }

    function specialization() {
        $this->title = isset($this->config->title) ? format_string($this->config->title) : format_string(get_string('newmrbsblock', 'block_mrbs'));
    }

    function instance_allow_multiple() {
        return true;
    }

    function get_content() {
        global $CFG, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $context = context_system::instance();

        if (has_capability('block/mrbs:viewmrbs', $context) or has_capability('block/mrbs:editmrbs', $context) or has_capability('block/mrbs:administermrbs', $context)) {
            $go = get_string('accessmrbs', 'block_mrbs');
            $icon = $OUTPUT->pix_icon('web', 'MRBS icon', 'block_mrbs', array('height' => "16", 'width' => "16"));
            $target = '';
            if (isset($this->config->newwindow) and $this->config->newwindow) {
                $target = ' target="_blank" ';
            }
            if (isset($this->config->serverpath)) {
                $serverpath = $this->config->serverpath;
            } else {
                $serverpath = $CFG->wwwroot.'/blocks/mrbs/web';
            }
            if (isset($this->instance->id)) {
				$instance = $this->instance->id;
			} else {
				$instance = 0;
			}
            $this->content = new stdClass;
            $this->content->text = '<a href="'.$serverpath.'/index.php?instance='.$instance.'" '.$target.'>'.$icon.' &nbsp;'.$go.'</a>';
            $this->content->footer = '';
            return $this->content;
        }

        return null;
    }
    
    function instance_config_save($data, $nolongerused = false) {
		// modify type of select fields to be int
		$data->newwindow = intval($data->newwindow);
		$data->enable_periods = intval($data->enable_periods);
		if ($data->enable_periods == 0) {
			$data->morningstarts = intval($data->morningstarts);
			$data->morningstarts_min = intval($data->morningstarts_min);
			$data->eveningends = intval($data->eveningends);
			$data->eveningends_min = intval($data->eveningends_min);
		}
		$data->weekstarts = intval($data->weekstarts);
		$data->dateformat = intval($data->dateformat);
		$data->timeformat = intval($data->timeformat);
		$data->view_week_number = intval($data->view_week_number);
		$data->times_right_side = intval($data->times_right_side);
		$data->javascript_cursor = intval($data->javascript_cursor);
		$data->show_plus_link = intval($data->show_plus_link);
		$data->mail_admin_on_bookings = intval($data->mail_admin_on_bookings);
		$data->mail_area_admin_on_bookings = intval($data->mail_area_admin_on_bookings);
		$data->mail_room_admin_on_bookings = intval($data->mail_room_admin_on_bookings);
		$data->mail_admin_on_delete = intval($data->mail_admin_on_delete);
		$data->mail_admin_all = intval($data->mail_admin_all);
		$data->mail_details = intval($data->mail_details);
		$data->mail_booker = intval($data->mail_booker);
		parent::instance_config_save($data, $nolongerused);
    }

}
