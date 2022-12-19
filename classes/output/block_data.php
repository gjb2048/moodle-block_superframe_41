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
 * Block data widget.
 *
 * @package    block_superframe
 * @copyright  2022 G J Barnard - {@link http://moodle.org/user/profile.php?id=442195}.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_superframe\output;

class block_data implements \renderable, \templatable {

    public function export_for_template(\renderer_base $output) {
        // Prepare the data for the template.
        $table = new \stdClass();

        // Table headers.
        $table->tableheaders = [
            get_string('blockid', 'block_superframe'),
            get_string('blockname', 'block_superframe'),
            get_string('course', 'block_superframe'),
            get_string('catname', 'block_superframe'),
        ];

        // Build the data rows.
        foreach ($this->fetch_block_data() as $record) {
            $data = array();
            $data[] = $record->id;
            $data[] = $record->blockname;
            $data[] = $record->shortname;
            $data[] = $record->catname;
            $table->tabledata[] = $data;
        }

        return $table;
    }

    protected static function fetch_block_data() {
        global $DB;
        $sql = "SELECT b.id, cat.id AS catid, cat.name AS catname, ";
        $sql .= "b.blockname, c.shortname ";
        $sql .= "FROM {context} x ";
        $sql .= "JOIN {block_instances} b ON b.parentcontextid = x.id ";
        $sql .= "JOIN {course} c ON c.id = x.instanceid ";
        $sql .= "JOIN {course_categories} cat ON cat.id = c.category ";
        $sql .= "WHERE x.contextlevel <= :clevel ";
        $sql .= "ORDER BY b.blockname DESC";

        return $DB->get_records_sql($sql, ['clevel' => CONTEXT_BLOCK]);
    }
}
