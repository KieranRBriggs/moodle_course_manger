<?php

	function show_pending_courses($user = null) {
		global $CFG, $DB, $OUTPUT;
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
				
				$req_user = $DB->get_records_sql('SELECT id, firstname, lastname FROM mdl_user WHERE id=?', array($crs->createdbyid));
				$content .= '<tr>
						<th>Course Name:</th><td width="60%"> '.$crs->longname.'</td><td rowspan=4 class="options"><img src="'.$CFG->wwwroot.'/blocks/mcmanager/pix/tick.png" /> <img src="'.$CFG->wwwroot.'/blocks/mcmanager/pix/cross.png" /> <img src="'.$CFG->wwwroot.'/blocks/mcmanager/pix/page_edit.png" /> <a href="'.$CFG->wwwroot.'/blocks/mcmanager/view_comments.php?request_id="'.$crs->id.'><img src="'.$CFG->wwwroot.'/blocks/mcmanager/pix/pencil.png" /></a></td>
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
						<th>Requested By:</th><td><a href="'.$CFG->wwwroot.'/user/profile.php?id='.$crs->createdbyid.'">'.$crs->createdbyid.'</a></td>
					</tr>
					<tr>
						<td colspan=3><hr /></td>';
			};
		
		$content .= '</table>';
		
		};
		
	
		return $content;
	}
	
	function show_archived_courses($user = null) {
		global $CFG, $DB, $OUTPUT; 
		$content = '';
		if ($user) {
			$archived = $DB->get_records('block_mcmanager_records', array('createdbyid' => $user, 'status' => 'approved', 'status' => 'denied'));
		} else {
			$archived = $DB->get_records('block_mcmanager_records', array('status'=> 'approved', 'status' => 'denied'));
		}
		if (empty($archived)) {
			$content =  $OUTPUT->heading(get_string('noarchivedcourses', 'block_mcmanager'));
		} else {
		   $table = new html_table();
		   $table->attributes['class'] = 'archivedcourserequests generaltable';
		   $table->align = array('center', 'center', 'center', 'center', 'center', 'center');
		   if (!$user) {
		   	$table->head = array(get_string('coursetitle','block_mcmanager'), get_string('ebscode', 'block_mcmanager'), get_string('extraebscode', 'block_mcmanager'), get_string('requestreason'), get_string('requestby', 'block_mcmanager'),get_string('hod', 'block_mcmanager'),get_string('extrateachers', 'block_mcmanager'),get_string('status', 'block_mcmanager'));
		   	} else {
			 $table->head = array(get_string('coursetitle','block_mcmanager'), get_string('ebscode', 'block_mcmanager'), get_string('extraebscode', 'block_mcmanager'), get_string('requestreason'), get_string('extrateachers', 'block_mcmanager'),get_string('status', 'block_mcmanager'));  	
		   	}
		   
		   foreach ($archived as $course) {
				$row = array();
		        $row[] = format_string($course->longname);
		        $row[] = format_string($course->ebscode);
		        $row[] = format_string($course->extraebs);
		        $row[] = $course->extrainfo;
		        if(!$user) {
		        	$row[] = format_string($course->createdbyid);
		        	$row[] = format_string($course->hod);
		        }
		        $row[] = format_string($course->extrateachers);
		        $row[] = format_string($course->status);
	        }
	        
		    /// Add the row to the table.
		     $table->data[] = $row;
		    
		
		    // Display the table.
		    $content = html_writer::table($table); 
		}
		return $content;
	}
	
