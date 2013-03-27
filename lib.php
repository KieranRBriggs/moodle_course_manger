<?php


	function show_pending_courses($user = null) {
		global $CFG, $DB, $OUTPUT, $USER;
		
		require_once($CFG->dirroot.'/lib/moodlelib.php');
		
		if ($user) {
			$pending = $DB->get_records('block_mcmanager_records', array('createdbyid' => $user, 'status' => 'pending'));
		} else {
			$pending = $DB->get_records('block_mcmanager_records', array('status' => 'pending'));
		}
		
		if (empty($pending)) {
			$content =  $OUTPUT->heading(get_string('nopendingcourses'));
		} else {
			$content = $OUTPUT->heading(get_string('coursespending'));
			$content .= '<table id="courselist">';
			foreach($pending as $crs){
				$options = show_options($crs->id);
				$userid = $crs->createdbyid;
		   		$name = $DB->get_record('user', array('id' =>$userid), $fields='firstname, lastname', $strictness=IGNORE_MISSING);
		   		$content .= '<tr>
						<th>Course Name:</th><td width="60%"> '.$crs->longname.'</td><td rowspan=4 class="options">'.$options.'</td>
					</tr>
					<tr>
						<th>Short Name:</th><td> '.$crs->shortname.'</td>
					</tr>
					<tr>
						<th>EBS Code:</th><td> '.$crs->ebscode.'</td>
					</tr>
					<tr>
						<th>Linked Course Codes:</th><td> '.$crs->extraebs.'</td>
					</tr>
					<tr>
						<th>Department Head:</th><td> '.$crs->hod.'</td>
					</tr>
					<tr>
						<th>Extra Editors:</th><td> '.$crs->extrateachers.'</td>
					</tr>
					<tr>
						<th>Extra Information:</th><td>'.$crs->extrainfo.'</td>
					</tr>
					<tr class="comments">
						<th>Comments:</th><td colspan=2 > Comments go here...</td>
					</tr>
					<tr>
						<th>Requested By:</th><td><a href="'.$CFG->wwwroot.'/user/profile.php?id='.$crs->createdbyid.'">'.$name->firstname.' '.$name->lastname.'</a></td>
					</tr>
					<tr>
						<td colspan=3><hr /></td>';
			};
		
		$content .= '</table>';
		
		};
		
	
		return $content;
	}
	
	function show_archived_courses($user = null) {
		global $CFG, $DB, $OUTPUT, $USER; 
		
		require_once($CFG->dirroot.'/lib/moodlelib.php');
		
		$content = '';
		$select = "status NOT 'pending'";
		if ($user) {
			$archived = $DB->get_records_select('block_mcmanager_records',"status <> 'pending' AND createdbyid = ". $user);
			//'array('createdbyid' => $user, 'status' => 'approved', 'status' => 'denied'));
		} else {
			$archived = $DB->get_records_select('block_mcmanager_records', "status <> 'pending'");
		}
		if (empty($archived)) {
			$content =  $OUTPUT->heading(get_string('noarchivedcourses', 'block_mcmanager'));
		} else {
		   $table = new html_table();
		   $table->attributes['class'] = 'archivedcourserequests generaltable';
		   $table->align = array('center', 'center', 'center', 'center', 'center', 'center');
		   if (!$user) {
		   	$table->head = array(get_string('coursetitle','block_mcmanager'), get_string('ebscode', 'block_mcmanager'), get_string('extraebscode', 'block_mcmanager'), get_string('requestreason'), get_string('requestby', 'block_mcmanager'),get_string('hod', 'block_mcmanager'),get_string('extrateachers', 'block_mcmanager'),get_string('status', 'block_mcmanager'), get_string('options', 'block_mcmanager'));
		   	} else {
			 $table->head = array(get_string('coursetitle','block_mcmanager'), get_string('ebscode', 'block_mcmanager'), get_string('extraebscode', 'block_mcmanager'), get_string('requestreason'), get_string('extrateachers', 'block_mcmanager'),get_string('status', 'block_mcmanager'));  	
		   	}
		  
		   foreach ($archived as $course) {
		   		$userid = $course->createdbyid;
		   		$name = $DB->get_record('user', array('id' =>$userid), $fields='firstname, lastname', $strictness=IGNORE_MISSING);
		   		$options = show_options($course->id);
				$row = array();
		        $row[] = format_string($course->longname);
		        $row[] = format_string($course->ebscode);
		        $row[] = format_string($course->extraebs);
		        $row[] = $course->extrainfo;
		        if(!$user) {
		        	//$row[] = format_string($name, true);
		        	$row[] = '<a href="'.$CFG->wwwroot.'/user/profile.php?id='.$course->createdbyid.'">'. format_string($name->firstname).' '.format_string($name->lastname).'</a>';
		        	$row[] = format_string($course->hod);
		        }
		        $row[] = format_string($course->extrateachers);
		        $row[] = format_string($course->status);
		        if(!$user){
		        	$row[] = $options;
		        }
	        }
	        
		    /// Add the row to the table.
		     $table->data[] = $row;
		    
		
		    // Display the table.
		    $content = html_writer::table($table); 
		}
		return $content;
	}
	
	function show_options($courseid, $user = null) {
		global $CFG;
		$content = '';
		if($user) {
		$content .= '<a href="'.$CFG->wwwroot.'/blocks/mcmanager/view_request_actions.php?action=approve&id='.$courseid.'"><img src="'.$CFG->wwwroot.'/blocks/mcmanager/pix/tick.png" /></a>';
		}
		$content .= '<a href="'.$CFG->wwwroot.'/blocks/mcmanager/view_request_actions.php?action=delete&id='.$courseid.'"><img src="'.$CFG->wwwroot.'/blocks/mcmanager/pix/cross.png" /></a>
		<a href="'.$CFG->wwwroot.'/blocks/mcmanager/view_request_actions.php?action=edit&id='.$courseid.'"><img src="'.$CFG->wwwroot.'/blocks/mcmanager/pix/page_edit.png" /></a>
		<a href="'.$CFG->wwwroot.'/blocks/mcmanager/view_comments.php?courseid='.$courseid.'"><img src="'.$CFG->wwwroot.'/blocks/mcmanager/pix/pencil.png" /></a>';
		
		return $content;
		
	}

	function show_comments($courseid) {
		global $CFG, $DB;
		
		$previous_comments = $DB->get_records('block_mcmanager_comments', array('requestid' => $courseid));
		
		if(!empty($previous_comments)){
			$table = new html_table();
			$table->attributes['class'] = 'comments generaltable';
			$table->align = array('center', 'center', 'center');
			$table->head = array(get_string('date','block_mcmanager'), get_string('message', 'block_mcmanager'), get_string('from', 'block_mcmanager'));
			foreach($previous_comments as $comment) {
				$name = $DB->get_record('user', array('id' =>$comment->createdbyid), $fields='firstname, lastname', $strictness=IGNORE_MISSING);
		   		
				$row = array();
			    $row[] = gmdate("d/m/Y - H:m", $comment->dt);
			    //$row[] = format_string($comment->dt);
			    $row[] = format_string($comment->message);
			    $row[] = '<a href="'.$CFG->wwwroot.'/user/profile.php?id='.$comment->createdbyid.'">'. format_string($name->firstname).' '.format_string($name->lastname).'</a>';
			 }
			 $table->data[] = $row;
			 $content = html_writer::table($table);
			 return $content;
		}

	}

class course_manipulation {
	function create_request($data) {
    	global $USER, $DB, $CFG;
        $data->requester = $USER->id;
  
          // Setting the default category if none set.
          if (empty($data->category) || empty($CFG->requestcategoryselection)) {
              $data->category = $CFG->defaultrequestcategory;
          }
  
          // Summary is a required field so copy the text over
          $data->summary       = $data->summary_editor['text'];
          $data->summaryformat = $data->summary_editor['format'];
  
          $data->id = $DB->insert_record('block_mcmanager_records', $data);
  
          // Create a new course_request object and return it
          $request = new course_request($data);
  
          // Notify the admin if required.
          if ($users = get_users_from_config($CFG->courserequestnotify, 'moodle/site:approvecourse')) {
  
              $a = new stdClass;
              $a->link = "$CFG->wwwroot/blocks/mcmanager/view_courses_admin.php?courses=pending";
              $a->user = fullname($USER);
              $subject = get_string('courserequest');
              $message = get_string('courserequestnotifyemail', 'admin', $a);
              foreach ($users as $user) {
                  $request->notify($user, $USER, 'courserequested', $subject, $message);
              }
          }
  
          return $request;
      }
      
      function approve_course() {
          global $CFG, $DB;
          
          $data = array();
          
          // Apply course default settings
          $data->format             = $courseconfig->format;
          $data->newsitems          = $courseconfig->newsitems;
          $data->showgrades         = $courseconfig->showgrades;
          $data->showreports        = $courseconfig->showreports;
          $data->maxbytes           = $courseconfig->maxbytes;
          $data->groupmode          = $courseconfig->groupmode;
          $data->groupmodeforce     = $courseconfig->groupmodeforce;
          $data->visible            = $courseconfig->visible;
          $data->visibleold         = $data->visible;
          $data->lang               = $courseconfig->lang;

	}
}
