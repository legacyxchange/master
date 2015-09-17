<?php 
require_once APPPATH.'models/vtracker_model.php';

class Vtracker {
	private $db;
	private $CI;
	
	public function __construct(){ 
		$this->CI = & get_instance();
	}
	
	/**
	 * Todo: Add create new db table for each day
	 *       to make the data manageable.
	 */
	public function run(){ 
		$ip = $_SERVER['REMOTE_ADDR'];
		$_POST['ip_address'] = $ip;
		$_POST['referrer'] = urlencode($this->CI->input->server('HTTP_REFERER'));
		
		if(empty($_SESSION['vtracker']['visitor'])){
			$_POST['session'] = $_SESSION['vtracker']['visitor'] = hash('MD5', $ip);
			$_POST['session_count'] = $_SESSION['vtracker']['session_count'] = 1;			
		}else{
			$_POST['session'] = $_SESSION['vtracker']['visitor'];
			$_POST['session_count'] = $_SESSION['vtracker']['session_count']++;
		}
		
		$_POST['user_id'] = $this->CI->session->userdata('user_id');
		//var_dump($_POST); exit;
		$vt = new vtracker_model();
				
		$vt->save();
	}
}