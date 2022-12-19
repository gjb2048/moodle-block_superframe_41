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
 * View page widget.
 *
 * @package    block_superframe
 * @copyright  2022 G J Barnard - {@link http://moodle.org/user/profile.php?id=442195}.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_superframe\output;

use moodle_url;

class view implements \renderable, \templatable {

    protected $url;
    protected $width;
    protected $height;
    protected $courseid;
    protected $blockid;

    public function __construct($url, $width, $height, $courseid, $blockid) {
        $this->url = $url;
        $this->width = $width;
        $this->height = $height;
        $this->courseid = $courseid;
        $this->blockid = $blockid;
    }

    public function export_for_template(\renderer_base $output) {
        global $USER;

        $data = new \stdClass();

        // Page heading and iframe data.
        $data->heading = get_string('pluginname', 'block_superframe');
        $data->url = $this->url;
        $data->height = $this->height;
        $data->width = $this->width;

        // Add the user data.
        $data->fullname = fullname($USER);

        $data->returnlink = new moodle_url('/course/view.php', ['id' => $this->courseid]);

        // Text for the links and the size parameter.
        $strings = array();
        $strings['custom'] = get_string('custom', 'block_superframe');
        $strings['small'] = get_string('small', 'block_superframe');
        $strings['medium'] = get_string('medium', 'block_superframe');
        $strings['large'] = get_string('large', 'block_superframe');

        // Create the data structure for the links.
        $links = array();
        $link = new moodle_url('/blocks/superframe/view.php', ['courseid' => $this->courseid,
            'blockid' => $this->blockid]);

        foreach ($strings as $key => $string) {
            $links[] = ['link' => $link->out(false, ['size' => $key]), 'text' => $string];
        }

        $data->linkdata = $links;

        return $data;
    }
}
