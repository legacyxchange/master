<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailer
{
	private $ci;
    
    public function __construct() {
        $this->ci = & get_instance();
    }
    
    public function send($to_email, $subject, $message, $full_name = null, $from_email = null, $from_name = null){
    	if(!$to_email)
    	{
    		$this->ci->session->set_flashdata('FAILURE', 'You must supply a valid email.');
    		return false;    		
    	}    	
    	
    	require_once BASEPATH.'libraries/Email.php';
    	$mailer = new CI_Email();
    	    	   	
    	$config['protocol'] = 'mail';
    	$config['mailpath'] = '/bin/mail';
    	$config['charset'] = 'iso-8859-1';
    	$config['wordwrap'] = TRUE;
    	$config['smtp_host'] = 'imap.secureserver.net';
    	$config['smtp_user'] = 'nickr@legacyxchange.com';
    	$config['smtp_pass'] = '031866YuP';
    	 
    	$mailer->initialize($config);
    	
    	$mailer->from($from_email, $from_name);
    	$mailer->to($to_email);
    	
    	$mailer->subject($subject);
    	$mailer->message($message);
    	$mailer->mailtype = 'html';
    	$s = $mailer->send();
    	 
    	//var_dump($s, $email, $subject, $message, $full_name); exit;
    	return true;
    }
}