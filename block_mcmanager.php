<?php

class block_mcmanager extends block_list {
	
	function init() {
		$this->title = get_string('pluginname', 'block_mcmanager');
	}
	
	public function get_content() {
		
		global $CFG, $DB;
		
		if ($this->content !== null) {
			return $this->content;
		}
		
		$context = context_system::instance();		
		
		$this->content = new stdClass;
		$this->content->items = array();
		$this->content->icons = array();
		
		$this->content->items[] = html_writer::tag('a',get_string('newrequest','block_mcmanager'), array('href' => $CFG->wwwroot. '/blocks/mcmanager/view_newcourse.php'));
		$this->content->icons[] = html_writer::empty_tag('img', array('src' => $CFG->wwwroot.'/blocks/mcmanager/pix/add.png', 'class' => 'icon'));
		
		$this->content->items[] = html_writer::tag('a',get_string('managerequests','block_mcmanager'), array('href' => $CFG->wwwroot . '/blocks/mcmanager/view_courses_user.php?courses=pending'));
		$this->content->icons[] = html_writer::empty_tag('img', array('src' => $CFG->wwwroot.'/blocks/mcmanager/pix/page_edit.png', 'class' => 'icon'));
		
		if (has_capability('moodle/site:approvecourse', $context)) {
			$numRequestsPending = 0;
			$numRequestsPending = $DB->count_records('block_mcmanager_records', array('status'=>'PENDING'));
			$queue = get_string('queue','block_mcmanager') . ' [' . $numRequestsPending .' new]';
			$this->content->items[] = html_writer::tag('a',$queue, array('href' => $CFG->wwwroot . '/blocks/mcmanager/view_courses_admin.php?courses=pending'));
			$this->content->icons[] = html_writer::empty_tag('img', array('src' => $CFG->wwwroot.'/blocks/mcmanager/pix/wand.png', 'class' => 'icon'));
		}

	}	
}