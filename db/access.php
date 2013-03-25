<?php

$capabilities = array(
	   'block/mcmanager:myaddinstance' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'editingteacher' => CAP_PREVENT,
            'manager' => CAP_PREVENT
            
        ),
 
        'clonepermissionsfrom' => 'moodle/my:manageblocks'
    ),
    
        'block/mcmanager:addinstance' => array(
        'riskbitmask' => RISK_SPAM | RISK_XSS,
 
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => array(
            'editingteacher' => CAP_PREVENT,
            'manager' => CAP_PREVENT
        ),
 
        'clonepermissionsfrom' => 'moodle/site:manageblocks'
    ),
);