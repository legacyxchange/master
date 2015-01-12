<?php 

class Redirector {
	private $db;
	private $CI;
	
	public function __construct(){ 
		$this->CI = & get_instance();
		//var_dump($this->CI->session->redirectUri); 
	}
}