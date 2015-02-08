<?php 

class Profiler {
	private $db;
	private $CI;
	
	public function __construct(){ 
		$this->CI = & get_instance();
		$this->CI->output->enable_profiler(FALSE);
	}
}