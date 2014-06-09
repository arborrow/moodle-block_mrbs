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
 * The block_mrbs booking created event.
 *
 * @package    block_mrbs
 * @copyright  2014 Davo Smith <moodle@davosmith.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_mrbs\event;

defined('MOODLE_INTERNAL') || die();

/**
 * The block_mrbs booking created event.
 *
 * @package    block_mrbs
 * @since      Moodle 2.7
 * @copyright  2014 Davo Smith <moodle@davosmith.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class booking_created extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'block_mrbs_entry';
        $this->context = \context_system::instance();
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventbookingcreated', 'block_mrbs');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has updated a new booking in '{$this->other['room']}' for '{$this->other['name']}'";
    }

    /**
     * Get URL related to the action
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/blocks/mrbs/web/view_entry.php', array('id' => $this->objectid));
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        global $CFG;
        return array(SITEID, 'mrbs', 'add booking', $CFG->wwwroot.'blocks/mrbs/web/view_entry.php?id='.$this->objectid,
                     $this->other['name']);
    }

    protected function validate_data() {
        if (!isset($this->other['name'])) {
            throw new \coding_exception('Must specify the name of the booking as \'other[\'name\']\'');
        }
        if (!isset($this->other['room'])) {
            throw new \coding_exception('Must specify the room for the booking as \'other[\'room\']\'');
        }
    }
}

