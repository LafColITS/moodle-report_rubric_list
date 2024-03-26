# Rubric list

![moodle-ci](https://github.com/LafColITS/moodle-report_rubric_list/actions/workflows/moodle-ci.yml/badge.svg)

This is a simple report which lists all rubrics a user has created.

## Requirements
- Moodle 4.1 (build 2022041900 or later)

## Installation
Copy the rubric_list folder into your /report directory and visit your Admin Notification page to complete the installation.

## Administration
The report has no options.

## Usage
Once the plugin is installed, a teacher can access the functionality by going to Reports > Rubric list within the course, or by going to the URL `<mymoodle>/report/rubric_list/index.php?id=<courseid>.`

The report will display a table with the following information:

- ***Rubric***: the name of the rubric with a link to the grading area
- ***Last updated***: the last time the rubric was updated
- ***Activity type***: the associated activity type, either an assignment or forum
- ***Activity***: the name of the activity with a link
- ***Course***: the name of the course with a link

## Author
Charles Fulton (fultonc@lafayette.edu)