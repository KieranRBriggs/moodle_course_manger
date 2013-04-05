<?php
require_once("../../config.php");

global $CFG, $DB;

require_once($CFG->dirroot . '/blocks/mcmanager/forms.php');
require_login();

/** Page Settings **/
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Course Requests');
$PAGE->set_heading('Course Requests', 3);
$PAGE->set_url('/blocks/mcmanager/view_request_actions.php');
$PAGE->set_pagelayout('admin');
$PAGE->add_body_class('mcmanager');

/** Navigation Bar **/
$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('queue', 'block_mcmanager'), new moodle_url('/blocks/mcmanager/view_request_actions.php'));

/// Where we came from. Used in a number of redirects.
$returnurl = $CFG->wwwroot . '/my/';

$action = required_param('action', PARAM_TEXT);
$courseid = required_param('id', PARAM_INT);
/// Where we came from. Used in a number of redirects.
$returnurl = $CFG->wwwroot . '/blocks/mcmanager/view_courses_admin.php?courses=pending';

echo $OUTPUT->header();

switch($action){
	case 'delete':
		$result = new reject_request_form($returnurl);
		
		if ($result->is_cancelled()) {
    
		} else if ($coursedata = $result->get_data()) {
	
			create_request();
			// and redirect back to the course listing.
			notice(get_string('courserequestsuccess'), $returnurl);
    
		} else {
			//$newcourse->set_data($toform);
			$result->display();
		}
		break;
	
	case 'approve':
		approve_course();
		break;
};


echo $OUTPUT->footer();