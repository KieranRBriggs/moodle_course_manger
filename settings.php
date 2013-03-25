<?php

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

	$settings->add(new admin_setting_heading(
            'headerconfig',
            get_string('headerconfig', 'block_mcmanager'),
            get_string('descconfig', 'block_mcmanager')
        ));
 
    $settings->add(new admin_setting_configcheckbox(
            'mcmanager/newcourseuser_email',
            get_string('newcourseuser', 'block_mcmanager'),
            get_string('descnewcourseuser', 'block_mcmanger'),
            '0'
        ));
};