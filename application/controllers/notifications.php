<?php
error_reporting(E_ALL & ~E_NOTICE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notifications extends CI_Controller {

    function Notifications() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('notifications_model', 'notifications', true);
        $this->load->helper('form');
        $this->load->helper('url');
    }
    
	public function index() { 
        $data['notifications'] = $notifications = $this->notifications->fetchAll(array('where' => 'user_id = '.$this->session->userdata['user_id']));   
        
        if(is_null($notifications)){
        	$data['notifications'] = 'No New Messages.';
        }
        
        $this->layout->load('admin/notifications/new', $data);
    }
    
    public function last() {
    	$n = $this->notifications->fetchAll(array('where' => 'user_id = '.$this->session->userdata['user_id'].' AND status = 1'));
    
    	$out = null;
    	foreach($n as $notification){
    		$out .= '<div class="notification">'.$notification->notification.'<button class="btn btn-danger" onclick="notifications.archive('.$notification->notification_id.');">Archive</button></div>';
    	}
    	echo $out; exit;
    }
    
    public function archive($notification_id = null){ 
    	
    	$this->notifications->archive('notification_id = '.$notification_id);
    	echo json_encode(array('status' => 'SUCCESS', 'message' => 'You successfully archived the message'));
    	exit;
    }
}