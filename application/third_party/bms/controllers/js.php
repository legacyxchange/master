<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Js extends CI_Controller
{
	function Js ()
	{
		parent::__construct();
		
	}
	
	public function render ()
	{
		echo 'render js';
	}
}