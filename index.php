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
 * Display an instructor's rubrics.
 *
 * @package   report_rubric_list
 * @copyright 2024 Lafayette College ITS
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once('./classes/rubric_list_table.php');

$id = required_param('id', PARAM_INT);
$course = $DB->get_record('course', ['id' => $id], '*', MUST_EXIST);
$download = optional_param('download', '', PARAM_ALPHA);

require_login($course);

// Setup page.
$PAGE->set_url('/report/rubric_list/index.php', ['id' => $course->id]);
$PAGE->set_pagelayout('report');

// Check permissions.
$coursecontext = context_course::instance($course->id);
require_capability('report/rubric_list:view', $coursecontext);

// Get the rubrics.
$table = new report_rubric_list\table($USER->id);
$table->is_downloading($download, get_string('rubric_list_filename', 'report_rubric_list'));

if (!$table->is_downloading()) {
    $PAGE->set_title($course->shortname .': '. get_string('pluginname', 'report_rubric_list'));
    $PAGE->set_heading($course->fullname);
    echo $OUTPUT->header();
}

$table->set_sql(
    "gd.id, gd.areaid, gd.name, gd.usercreated, gd.copiedfromid, gd.timemodified, gd.status,
    c.id as courseid, c.fullname as course, cm.id as cmid, m.name as modtype,
    f.name as forum, a.name as assignment",
    "{grading_definitions} gd JOIN {grading_areas} ga ON (gd.areaid =ga.id) JOIN {context} cx ON (ga.contextid = cx.id)
    JOIN {course_modules} cm
    ON cx.instanceid = cm.id JOIN {course} c ON cm.course=c.id JOIN {modules} m ON cm.module=m.id LEFT JOIN {forum} f
    ON (cm.instance=f.id AND m.name='forum') LEFT JOIN {assign} a ON (cm.instance=a.id AND m.name='assign')",
    "gd.usercreated = ?",
    [$USER->id]
);
$table->sortable(true, 'timemodified', SORT_DESC);
$table->define_baseurl("$CFG->wwwroot/report/rubric_list/index.php?id={$id}");
$table->out(40, true);

if (!$table->is_downloading()) {
    echo $OUTPUT->footer();
}
