<?php

require_once("$CFG->libdir/formslib.php");

class coursedetails_form extends moodleform {
	
	public function definition() {
		global $CFG, $USER;
		
		$mform = $this->_form; // Don't Forget Underscore
		
		
        $mform->addElement('header','coursedetails', get_string('courserequestdetails'));
		
		$mform->addElement('hidden', 'user', $USER->id);
				
		if (empty($CFG->requestcategoryselection)) {
            $displaylist = array();
            $parentlist = array();
            make_categories_list($displaylist, $parentlist, '');
            $mform->addElement('select', 'category', get_string('category'), $displaylist);
            $mform->setDefault('category', $CFG->defaultrequestcategory);
            $mform->addHelpButton('category', 'category');
        }
		
		$mform->addElement('text', 'longname', get_string('longname', 'block_mcmanager'),'maxlength="254" size="50"');
		$mform->addRule('longname', get_string('nolongname', 'block_mcmanager'), 'required');
        $mform->addHelpButton('longname','longname', 'block_mcmanager');
		
		$mform->addElement('text', 'shortname', get_string('shortname', 'block_mcmanager'),'maxlength="20" size="20"');
		$mform->addRule('shortname', get_string('noshortname', 'block_mcmanager'), 'required');
        $mform->addHelpButton('shortname','shortname', 'block_mcmanager');
		
		$mform->addElement('editor', 'summary', get_string('summary'));
				
		$mform->addElement('text', 'ebscode', get_string('ebscode', 'block_mcmanager'), 'maxlength="12" size="20"');
		$mform->setType('ebscode', PARAM_TEXT);
        $mform->addHelpButton('ebscode','ebscode', 'block_mcmanager');
		
		$mform->addElement('textarea', 'extraebs', get_string('extraebs', 'block_mcmanager'), 'wrap="virtual" rows="5" cols="20"');
		$mform->setType('extraebs', PARAM_TEXT);
        $mform->addHelpButton('extraebs','extraebs', 'block_mcmanager');
		
		$mform->addElement('text', 'hod', get_string('hod', 'block_mcmanager'));
		$mform->addRule('hod', get_string('nohod', 'block_mcmanager'), 'required');
		
		$mform->addElement('textarea', 'extrateachers', get_string('extrateachers', 'block_mcmanager'),'wrap="virtual" rows="5" cols="20"');
		$mform->setType('extrateachers', PARAM_TEXT);
        $mform->addHelpButton('extrateachers','extrateachers', 'block_mcmanager');
		
		$mform->addElement('header','extradetails', get_string('extrainfo', 'block_mcmanager'));
		
		$mform->addElement('textarea', 'extrainfo', get_string('extradetails', 'block_mcmanager'),'wrap="virtual" rows="5" cols="50"');
		$mform->setType('extrainfo', PARAM_TEXT);
		
		//normally you use add_action_buttons instead of this code
		$buttonarray=array();
		$buttonarray[] = &$mform->createElement('submit', 'submitbutton', get_string('requestcourse', 'block_mcmanager'));
		$buttonarray[] = &$mform->createElement('reset', 'resetbutton', get_string('clear', 'block_mcmanager'));
		$buttonarray[] = &$mform->createElement('cancel');
		$mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
		$mform->closeHeaderBefore('buttonar');
		//$this->add_action_buttons(true, get_string('requestcourse', 'block_mcmanager'));
	}

}

/**
 * A form for an administrator to reject a course request.
 */
class reject_request_form extends moodleform {
    function definition() {
        $mform =& $this->_form;

        //$mform->addElement('hidden', 'reject', 0);
        //$mform->setType('reject', PARAM_INT);

        $mform->addElement('header','coursedetails', get_string('coursereasonforrejecting'));

        $mform->addElement('textarea', 'rejectnotice', get_string('coursereasonforrejectingemail'), array('rows'=>'10', 'cols'=>'70'));
        $mform->addRule('rejectnotice', get_string('missingreqreason'), 'required', null, 'client');
        $mform->setType('rejectnotice', PARAM_TEXT);

        $this->add_action_buttons(true, get_string('reject'));
    }
}

class comments_form extends moodleform {
	function definition() {
	
		global $CFG;
		
		$mform =& $this->_form;
		
		$mform->addElement('hidden', 'courseid', '1');
		$mform->addElement('header','commentdetails', get_string('commentheader', 'block_mcmanager'));
		$mform->addElement('textarea', 'comment', get_string('commentsarea', 'block_mcmanager'), array('rows'=>'8', 'cols'=>'70'));
        $mform->addRule('comment', get_string('missingcomment', 'block_mcmanager'), 'required', null, 'client');
        $mform->setType('comment', PARAM_TEXT);

        $this->add_action_buttons(true, get_string('comment', 'block_mcmanager'));

	}

}