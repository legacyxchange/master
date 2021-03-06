<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class notifications_model extends abstract_model {

    protected $table = 'notifications';
    protected $primary_key = 'notification_id';
    public $notification_id;
    public $user_id;
    public $from_user_id;
    public $subject;
    public $notification;
    public $attachment;
    public $status;
    public $email_sent;
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    }
    
    //sends a notification to a user from the system
    public function fromSystem($to_user_id, $notification, $subject = 'Notification from LegacyXChange.com', $email_notification = 'same'){
    	
    	if(!$to_user_id || !$notification)
    	{
    		return false;
    	}   	
    	
    	$_POST['user_id'] = $to_user_id;
    	$_POST['notification'] = $notification;    	  	    	
    	
    	if($email_notification){
    		if($email_notification != 'same')
    			$notification = $email_notification;    		
    		if(!$subject)
    			$subject = 'Notification from LegacyXChange.com';
    		
    		$_POST['status'] = 2; //sent
    		$this->email($to_user_id, 0, $notification, $subject, 1);
    	}
    	
    	$notifications = new notifications_model();
    	$notifications->save();
    }
    
    public function fromUser($to_user_id, $from_user_id, $notification, $subject = null, $addEmail = TRUE){
    	if(!$to_user_id || !$from_user_id || !$notification)
    	{
    		return false;
    	}
    	
    	$_POST['user_id'] = $to_user_id;
    	$_POST['from_user_id'] = $from_user_id;
    	$_POST['notification'] = $notification;
    	
    	if($addEmail){
    		$fuser = $this->user->fetchAll(array('where' => 'user_id = '.$from_user_id))[0];
    		
    		if(!$subject)
    			$subject = $fuser->username.' sent you a message.';
    		
    		$_POST['status'] = 2;
    		$this->email($to_user_id, $from_user_id, $notification, $subject, 1);
    	}
    	
    	$this->save();
    }
    
    protected function email($to_user_id, $from_user_id, $notification, $subject, $importance_level = 1){
    	    	
    	$fuser = $this->user->fetchAll(array('where' => 'user_id = '.$from_user_id))[0];
    	$tuser = $this->user->fetchAll(array('where' => 'user_id = '.$to_user_id))[0];
    	
    	$config['protocol'] = 'mail';
    	$config['mailpath'] = '/bin/mail';
    	$config['charset'] = 'iso-8859-1';
    	$config['wordwrap'] = TRUE;
    	$config['smtp_host'] = 'imap.secureserver.net';
    	$config['smtp_user'] = 'nickr@legacyxchange.com';
    	$config['smtp_pass'] = '031866YuP';
    	$this->email->set_mailtype("html");
    	$this->email->initialize($config);
    	
    	$this->email->from('notifications@legacyxchange.com', 'LegacyXChange.com');
    	$this->email->to($tuser->email, $tuser->firstName.' '.$tuser->lastName);
    	//$this->email->cc('another@another-example.com');
    	//$this->email->bcc('them@their-example.com');
    	 
    	$this->email->subject($subject);
    	$this->email->message($notification);
    	 
    	$this->email->send();
    	 
    	return;
    	//$this->session->set_flashdata('SUCCESS', 'Your message has been received and we will respond within 24 hours.');
    	//header('Location: /'); exit;
    }
    
    public function archive(){
    	$notification_id = $_REQUEST['notification_id'];
    	$_POST['status'] = 0;
    	//var_dump($_POST); exit;
    	$this->save('notification_id = '.$notification_id);
    	return true;
    }
}		