<?php
require_once("../../config.php");

global $CFG, $DB;

require_once(dirname('_FILE_') . '/lib.php');
require_login();
require_capability('moodle/site:approvecourse', context_system::instance());

/** Page Settings **/
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Course Requests');
$PAGE->set_heading('Course Requests', 3);
$PAGE->set_url('/blocks/mcmanager/view_courses_admin.php');
$PAGE->set_pagelayout('admin');
$PAGE->add_body_class('mcmanager');

/** Navigation Bar **/
$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('queue', 'block_mcmanager'), new moodle_url('/blocks/mcmanager/view_courses_admin.php'));

$thispageurl = '/blocks/mcmanager/view_courses_admin.php';


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
		$details = show_pending_courses();
		break;
	case 'archive':
		$details = show_archived_courses();
		break;
};

echo $details;
echo $OUTPUT->single_button($CFG->wwwroot . '/my/', get_string('backtomymoodle', 'block_mcmanager'));
echo $OUTPUT->footer();