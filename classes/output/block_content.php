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
 * Block content widget.
 *
 * @package    block_superframe
 * @copyright  2022 G J Barnard - {@link http://moodle.org/user/profile.php?id=442195}.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_superframe\output;

use moodle_url;

class block_content implements \renderable, \templatable {

    protected $courseid;
    protected $blockid;

    public function __construct($courseid, $blockid) {
        $this->courseid = $courseid;
        $this->blockid = $blockid;
    }

    public function export_for_template(\renderer_base $output) {
        global $DB, $SITE, $USER;

        $data = new \stdClass();

        if ((!empty($USER->firstname)) || (!empty($USER->lastname))) {
            $name = $USER->firstname.' '.$USER->lastname;
        } else {
            // Cope when the block is on the site course and not logged in etc.
            $name = get_string('guest');
        }
        $data->name = $name;
        $data->headingclass = 'block_superframe_heading';
        $data->welcome = get_string('welcomeuser', 'block_superframe', $name);

        $context = \context_block::instance($this->blockid);

        // Check the capability.
        if (has_capability('block/superframe:seeviewpagelink', $context)) {
            $data->url = new moodle_url('/blocks/superframe/view.php',
                ['blockid' => $this->blockid, 'courseid' => $this->courseid]);
            $data->text = get_string('viewlink', 'block_superframe');
        }

        // Add a link to the popup page.
        $data->popurl = new moodle_url('/blocks/superframe/block_data.php');
        $data->poptext = get_string('poptext', 'block_superframe');

        // Add a link to the table manager page.
        // With course id '$data->tableurl = new moodle_url('/blocks/superframe/tablemanager.php', ['courseid' => $courseid]);'.
        $data->tableurl = new moodle_url('/blocks/superframe/tablemanager.php');
        $data->tabletext = get_string('tabletext', 'block_superframe');

        // The users last access time to the course containing the block.
        if ($this->courseid != $SITE->id) { // Prevent issue when the block is shown on the view page.
            // Was using MUST_EXIST, but what if they'd not viewed the course yet or were not enrolled - an error is shown!
            $data->access = $DB->get_field('user_lastaccess', 'timeaccess', ['courseid' => $this->courseid,
                'userid' => $USER->id]);
        }

        // List of course students.
        if (has_capability('block/superframe:viewenrolledstudents', $context)) {
            $data->students = array();
            $users = self::get_course_users($this->courseid);
            foreach ($users as $user) {
                $data->students[] = ''.$user->lastname.', '.$user->firstname;
            }
        }

        return $data;
    }

    private static function get_course_users($courseid) {
        global $DB;

        // Just in case there are others and the 'default' value of '5' has changed.
        $studentarch = get_archetype_roles('student');

        $sql = "SELECT u.id, u.firstname, u.lastname ";
        $sql .= "FROM {course} c ";
        $sql .= "JOIN {context} x ON c.id = x.instanceid ";
        $sql .= "JOIN {role_assignments} r ON r.contextid = x.id ";
        $sql .= "JOIN {user} u ON u.id = r.userid ";
        $sql .= "WHERE c.id = :courseid ";
        $sql .= "AND r.roleid IN (".implode(',', array_keys($studentarch)).")";

        // In real world query should check users are not deleted/suspended.
        $records = $DB->get_records_sql($sql, ['courseid' => $courseid]);

        return $records;
    }
}
