@report @report_rubric_list
Feature: View all my rubrics
  In order to clean up rubrics that I don't need
  As a teacher
  I need to view a list of all my rubrics and where they are used

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email |
      | teacher1 | Teacher | 1 | teacher1@example.com |
      | teacher2 | Teacher | 2 | teacher2@example.com |
    And the following "courses" exist:
      | fullname | shortname | format |
      | Course 1 | C1 | topics |
      | Course 2 | C2 | topics |
      | Course 3 | C3 | topics |
      | Course 4 | C4 | topics |
    And the following "course enrolments" exist:
      | user | course | role |
      | teacher1 | C1 | editingteacher |
      | teacher1 | C2 | editingteacher |
      | teacher1 | C3 | editingteacher |
      | teacher2 | C2 | editingteacher |
      | teacher2 | C3 | editingteacher |
      | teacher2 | C4 | editingteacher |
    And the following "activities" exist:
      | activity   | name                      | intro                           | course | section | idnumber |
      | assign     | Test assignment 1 name    | Test assignment 1 description   | C1     | 1       | assign1  |
      | assign     | Test assignment 2 name    | Test assignment 2 description   | C2     | 1       | assign2  |
      | assign     | Test assignment 3 name    | Test assignment 3 description   | C3     | 1       | assign3  |
      | assign     | Test assignment 4 name    | Test assignment 4 description   | C4     | 1       | assign4  |
      | forum      | Test forum 1 name         | Test forum 1 description        | C2     | 1       | forum1   |
      | forum      | Test forum 2 name         | Test forum 2 description        | C3     | 1       | forum2   |
    And I am on the "Test assignment 1 name" "assign activity editing" page logged in as teacher1
    And I set the following fields to these values:
      | Grading method | Rubric |
    And I press "Save and return to course"
    And I go to "Test assignment 1 name" advanced grading definition page
    And I set the following fields to these values:
      | Name | Assignment 1 rubric |
      | Description | Assignment 1 description |
    And I define the following rubric:
      | Criterion 1 | Level 11 | 11 | Level 12 | 12 | Level 3 | 13 |
      | Criterion 2 | Level 21 | 21 | Level 22 | 22 | Level 3 | 23 |
      | Criterion 3 | Level 31 | 31 | Level 32 | 32 |         |    |
    And I press "Save rubric and make it ready"
    And I am on the "Test assignment 2 name" "assign activity editing" page
    And I set the following fields to these values:
      | Grading method | Rubric |
    And I press "Save and return to course"
    And I set "Test assignment 2 name" activity to use "Assignment 1 rubric" grading form
    And I am on the "Test forum 1 name" "forum activity editing" page
    And I click on "Advanced grading" "link"
    And I set the following fields to these values:
      | Change active grading method to | Rubric |
    And I set "Test forum 1 name" activity to use "Assignment 1 rubric" grading form
    And I am on the "Test assignment 3 name" "assign activity editing" page logged in as teacher2
    And I set the following fields to these values:
      | Grading method | Rubric |
    And I press "Save and return to course"
    And I go to "Test assignment 3 name" advanced grading definition page
    And I set the following fields to these values:
      | Name | Assignment 3 rubric |
      | Description | Assignment 3 description |
    And I define the following rubric:
      | Criterion 1 | Level 11 | 11 | Level 12 | 12 | Level 3 | 13 |
      | Criterion 2 | Level 21 | 21 | Level 22 | 22 | Level 3 | 23 |
      | Criterion 3 | Level 31 | 31 | Level 32 | 32 |         |    |
    And I press "Save rubric and make it ready"
    And I am on the "Test assignment 4 name" "assign activity editing" page
    And I set the following fields to these values:
      | Grading method | Rubric |
    And I press "Save and return to course"
    And I set "Test assignment 4 name" activity to use "Assignment 3 rubric" grading form
    And I am on the "Test forum 2 name" "forum activity editing" page
    And I click on "Advanced grading" "link"
    And I set the following fields to these values:
      | Change active grading method to | Rubric |
    And I set "Test forum 2 name" activity to use "Assignment 3 rubric" grading form

  @javascript
  Scenario: View report
    Given I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I navigate to "Reports" in current page administration
    And I click on "Rubric list" "link"
    And I should see "Assignment 1 rubric"
    And I should see "Ready for use"
    And I should not see "Assignment 3 rubric"
    And I log in as "teacher2"
    And I am on "Course 4" course homepage
    And I navigate to "Reports" in current page administration
    And I click on "Rubric list" "link"
    And I should see "Assignment 3 rubric"
    And I should not see "Assignment 1 rubric"
