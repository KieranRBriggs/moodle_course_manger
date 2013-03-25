<?php


require_once("../../config.php");
require_once($CFG->wwwroot.'/blocks/mcmanager/newcourse_form.php');

global $CFG;
require_login();

/** Page Settings **/
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Course Request Comments');
$PAGE->set_heading('Comments', 3);
$PAGE->set_url('/blocks/mcmanager/view_comments');
$PAGE->set_pagelayout('admin');
$PAGE->add_body_class('mcmanager');

/** Navigation Bar **/
$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('archive', 'block_mcmanager'), new moodle_url('/blocks/mcmanager/view_comments'));


echo $OUTPUT->header();

$mform = new newcourserequest_form();


if ($mform->is_cancelled()){
	echo "<script>window.location='module_manager.php';</script>";
	die;
} else if ($fromform=$mform->get_data()){

} else {
	$mform->display();
	$mform->focus();	
};

echo $OUTPUT->footer();