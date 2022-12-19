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
 * Superframe renderer.
 *
 * @package    block_superframe
 * @copyright  Daniel Neis <danielneis@gmail.com>
 * @copyright  2022 G J Barnard - {@link http://moodle.org/user/profile.php?id=442195}.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Modified for use in MoodleBites for Developers Level 1
 * by Gareth Barnard, Richard Jones & Justin Hunt.
 */

namespace block_superframe\output;

use moodle_url;
use stdClass;

class renderer extends \plugin_renderer_base {

    /**
     * Method to render the view.
     * @param view $view the view widget.
     *
     * @return Markup.
     */
    public function render_view(view $view) {
        $output = $this->output->header();
        $output .= $this->render_from_template('block_superframe/view', $view->export_for_template($this));
        $output .= $this->output->footer();

        return $output;
    }

    /**
     * Method to render the block content.
     * @param block_content $blockcontent the block content widget.
     *
     * @return Markup.
     */
    public function render_block_content(block_content $blockcontent) {
        return $this->render_from_template('block_superframe/block_content', $blockcontent->export_for_template($this));
    }

    /**
     * Function to display a table of records
     * @param array the records to display.
     * @return none.
     */
    public function display_block_table($records) {
        // Prepare the data for the template.
        $table = new stdClass();

        // Table headers.
        $table->tableheaders = [
            get_string('blockid', 'block_superframe'),
            get_string('blockname', 'block_superframe'),
            get_string('course', 'block_superframe'),
            get_string('catname', 'block_superframe'),
        ];

        // Build the data rows.
        foreach ($records as $record) {
            $data = array();
            $data[] = $record->id;
            $data[] = $record->blockname;
            $data[] = $record->shortname;
            $data[] = $record->catname;
            $table->tabledata[] = $data;
        }

        // Start output to browser.
        echo $this->output->header();

        // Call our template to render the data.
        echo $this->render_from_template('block_superframe/block_data', $table);

        // Finish the page.
        echo $this->output->footer();
    }
}
