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
 * Build rubric table.
 *
 * @package   report_rubric_list
 * @copyright 2024 Lafayette College ITS
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_rubric_list;

require "$CFG->libdir/tablelib.php";

class table extends \table_sql {

    /**
     * Constructor
     * @param int $uniqueid all tables have to have a unique id, this is used
     *      as a key when storing table properties like sort order in the session.
     */
    function __construct($uniqueid) {
        parent::__construct($uniqueid);
        // Define the list of columns to show.
        $columns = array('id', 'name', 'timemodified', 'modtype', 'module', 'course');
        $this->define_columns($columns);

        // Define the titles of columns to show in header.
        $headers = array(
            get_string('rubric', 'gradingform_rubric'),
            get_string('last_updated', 'report_rubric_list'),
            get_string('activity_type', 'report_rubric_list'),
            get_string('activity', 'report_rubric_list'),
            get_string('course')
        );
        $this->define_headers($headers);
    }

    /**
     * This function is called for each data row to allow processing of the
     * username value.
     *
     * @param object $values Contains object with all the values of record.
     * @return $string Return username with link to profile or username only
     *     when downloading.
     */
    function col_name($values) {
        // If the data is being downloaded than we don't want to show HTML.
        if ($this->is_downloading()) {
            return $values->name;
        } else {
            return \html_writer::link(new \moodle_url("/grade/grading/manage.php", array('areaid' => $values->areaid)), $values->name);
        }
    }

    function col_course($values) {
        // If the data is being downloaded than we don't want to show HTML.
        if ($this->is_downloading()) {
            return $values->fullname;
        } else {
            return \html_writer::link(new \moodle_url("/course/view.php", array('id' => $values->courseid)), $values->fullname);
        }        
    }

    function col_module($values) {
        switch($values->modtype) {
            case 'assign':
                $id = $values->assignid;
                $name = $values->assignment;
                $url = "/mod/assign/view.php";
                break;
            case 'forum':
                $id = $values->forumid;
                $name = $values->forum;
                $url = "/mod/forum/view.php";
                break;
        }

        // If the data is being downloaded than we don't want to show HTML.
        if ($this->is_downloading()) {
            return $name;
        } else {
            return \html_writer::link(new \moodle_url($url, array('id' => $id)), $name);
        }
    }

    function col_timemodified($values) {
        return userdate($values->timemodified);
    }
}