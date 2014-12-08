<?php if(!defined('BASEPATH')) die('Direct access not allowed'); 

$this->load->view('wall/loadposts', array('posts' => $posts));