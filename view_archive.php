<?php

require_once("../../config.php");

global $CFG;
require_login();

/** Page Settings **/
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Course Manager Archive');
$PAGE->set_heading('Course Manager Archive', 3);
$PAGE->set_url('/blocks/mcmanager/view_archive');
$PAGE->set_pagelayout('standard');
$PAGE->add_body_class('mcmanager');

/** Navigation Bar **/
$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('archive', 'block_mcmanager'), new moodle_url('/blocks/mcmanager/view_archive'));


echo $OUTPUT->header();

echo '<p>This is a test page</p>';

echo $OUTPUT->footer();