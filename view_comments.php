<?php

require_once("../../config.php");

global $CFG;

require_once($CFG->dirroot . '/blocks/mcmanager/forms.php');
require_once($CFG->dirroot . '/blocks/mcmanager/lib.php');
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
$PAGE->navbar->add(get_string('comments', 'block_mcmanager'), new moodle_url('/blocks/mcmanager/view_comments'));


/// Where we came from. Used in a number of redirects.
$returnurl = $CFG->wwwroot . '/my/';

$courseid = required_param('courseid', PARAM_INT);
echo $OUTPUT->header();

$newcourse = new comments_form($returnurl, compact('editoroptions'));

if ($newcourse->is_cancelled()) {
    
} else if ($coursedata = $newcourse->get_data()) {
	
    
} else {
	//$newcourse->set_data($toform);
	$newcourse->display(); 
	echo '<hr />';
	$comments = show_comments($courseid);
	echo $comments;
}

echo $OUTPUT->footer();