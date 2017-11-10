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
            $this->content = new stdClass;
            $this->content->text = '<a href="'.$serverpath.'/index.php" '.$target.'>'.$icon.' &nbsp;'.$go.'</a>';
            $this->content->footer = '';
            return $this->content;
        }

        return null;
    }

}
