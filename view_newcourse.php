<?php
require_once("../../config.php");

global $CFG, $DB;

require_once($CFG->dirroot . '/blocks/mcmanager/forms.php');
require_once($CFG->dirroot . '/blocks/mcmanager/lib.php');
require_login();

/** Page Settings **/
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Course Requests');
$PAGE->set_heading('Course Requests', 3);
$PAGE->set_url('/blocks/mcmanager/view_newcourse.php');
$PAGE->set_pagelayout('admin');
$PAGE->add_body_class('mcmanager');

/** Navigation Bar **/
$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('queue', 'block_mcmanager'), new moodle_url('/blocks/mcmanager/view_newcourse.php'));

/// Where we came from. Used in a number of redirects.
$returnurl = $CFG->wwwroot . '/my/';


echo $OUTPUT->header();

//$newcourse = new coursedetails_form($returnurl, compact('editoroptions'));
$newcourse = new coursedetails_form();

if ($newcourse->is_cancelled()) {
    
} else if ($fromform = $newcourse->get_data()) {
	$emailcontent = get_config('mcmanager', 'newcourseuser_email');
	create($fromform);
	// and redirect back to the course listing.
    notice($emailcontent, $returnurl);
    
} else {
	//$newcourse->set_data($toform);
	$newcourse->display();
}

echo $OUTPUT->footer();