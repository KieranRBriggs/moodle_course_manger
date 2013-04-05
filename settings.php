<?php

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
 
    $settings->add(new admin_setting_configtextarea(
            'mcmanager/newcourseuser_email',
            get_string('newcourseuser', 'block_mcmanager'),
            get_string('descnewcourseuser', 'block_mcmanager'),
            get_string('defaultnewcourseuser', 'block_mcmanager')
        ));
};