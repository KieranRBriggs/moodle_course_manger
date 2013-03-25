<?php

// This is the course manager
// Shows the teachers the courses that they have and have requested through this process.

require_once("../../config.php");

global $CFG, $USER;

require_once(dirname('_FILE_') . '/lib.php');
require_login();

/** Page Settings **/
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Course Manager - My Course Requests');
$PAGE->set_heading('Course Manager - My Course Requests', 3);
$PAGE->set_url('/blocks/mcmanager/view_courses_user.php');
$PAGE->set_pagelayout('standard');
$PAGE->add_body_class('mcmanager');

/** Navigation Bar **/
$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('mcmanagerDisplay', 'block_mcmanager'), new moodle_url('/blocks/mcmanager/view_courses_user.php'));

$thispageurl = '/blocks/mcmanager/view_courses_user.php';


echo $OUTPUT->header();


$tabs = array(array(
    new tabobject('pending', new moodle_url($thispageurl,
            array('courses' => 'pending')), get_string('pending', 'block_mcmanager')),
    new tabobject('archive', new moodle_url($thispageurl,
            array('courses' => 'archive')), get_string('archive', 'block_mcmanager')),
));

$activetab = required_param('courses', PARAM_TEXT);
print_tabs($tabs, $activetab);

switch($activetab){
	case 'pending':
		$details = show_pending_courses($USER->id);
		break;
	case 'archive':
		$details = show_archived_courses($USER->id);
		break;
};

echo $details;
echo $OUTPUT->single_button($CFG->wwwroot . '/blocks/mcmanager/view_newcourse.php', get_string('newrequest', 'block_mcmanager'));
echo $OUTPUT->single_button($CFG->wwwroot . '/my/', get_string('backtomymoodle', 'block_mcmanager'));
echo $OUTPUT->footer();