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
        $this->title = get_string('blockname','block_mrbs');
        $this->content_type = BLOCK_TYPE_TEXT;
    }

    function has_config() {
        return true;
    }


    function applicable_formats() {
        return array('all' => true);
    }

    function get_content () {
        global $USER, $CFG, $OUTPUT;

        if ($this->content !== NULL) {
            return $this->content;
        }

        $cfg_mrbs = get_config('block/mrbs');

        if ($CFG->version < 2011120100) {
            $context = get_context_instance(CONTEXT_SYSTEM);
        } else {
            $context = context_system::instance();
        }

        if (has_capability('block/mrbs:viewmrbs', $context) or has_capability('block/mrbs:editmrbs', $context) or has_capability('block/mrbs:administermrbs', $context)) {
            if (isset($CFG->block_mrbs_serverpath)) {
                $serverpath = $CFG->block_mrbs_serverpath;
            } else {
                $serverpath = $CFG->wwwroot.'/blocks/mrbs/web';
            }
            $go = get_string('accessmrbs', 'block_mrbs');
            $icon = '<img src="'.$OUTPUT->pix_url('web', 'block_mrbs').'" height="16" width="16" alt="" />';
            $target = '';
            if ($cfg_mrbs->newwindow) {
                $target = ' target="_blank" ';
            }
            $this->content = new stdClass();
            $this->content->text = '<a href="'.$serverpath.'/index.php" '.$target.'>'.$icon.' &nbsp;'.$go.'</a>';
            $this->content->footer = '';
            return $this->content;
        }

        return NULL;
    }

    function cron() {
        global $CFG, $DB;
        include($CFG->dirroot.'/blocks/mrbs/import.php');

        return true;
    }
}
