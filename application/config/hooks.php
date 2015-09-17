<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller_constructor'][0] = array(
		'class'    => 'Profiler',
		'function' => '__construct',
		'filename' => 'Profiler.php',
		'filepath' => 'hooks',
		//'params'   => array('beer', 'wine', 'snacks')
);
$hook['post_controller_constructor'][1] = array(
		'class'    => 'AdMeister',
		'function' => 'run',
		'filename' => 'AdMeister.php',
		'filepath' => 'hooks',
		//'params'   => array('beer', 'wine', 'snacks')
);
$hook['post_controller_constructor'][2] = array(
		'class'    => 'VTracker',
		'function' => 'run',
		'filename' => 'VTracker.php',
		'filepath' => 'hooks',
		//'params'   => array('beer', 'wine', 'snacks')
);

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */