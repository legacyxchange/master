<?php
error_reporting(E_ALL & ~E_NOTICE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notifications extends CI_Controller {

    function Notifications() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('notifications_model', 'notifications', true);
        $this->load->model('user_model', 'users', true);
        $this->load->helper('form');
        $this->load->helper('url');
        $this->functions->checkLoggedIn();
    }
    
	public function index() { 
        $notifications = $this->notifications->fetchAll(array('where' => 'user_id = '.$this->session->userdata['user_id']));   
        foreach($notifications as $n){
        	$n->to_user = $this->users->fetchAll(array('where' => 'user_id = '.$n->user_id))[0];
        	$n->from_user = $this->users->fetchAll(array('where' => 'user_id = '.$n->from_user_id))[0];
        }
        $data['notifications'] = $notifications;
        $data['counted_inbox_notifications'] = count($notifications);
        if(is_null($notifications)){
        	$data['notifications'] = 'No New Messages.';
        }
        
        $data['active_menu'] = "inbox";
        $this->layout->load('admin/notifications', $data, 'ecommerce');
    }
    
    public function sent() {
    	$data['notifications'] = $notifications = $this->notifications->fetchAll(array('where' => 'from_user_id = '.$this->session->userdata['user_id'].' and email_sent = 1'));
    	foreach($notifications as $n){
    		$n->to_user = $this->users->fetchAll(array('where' => 'user_id = '.$n->user_id))[0];
    		$n->from_user = $this->users->fetchAll(array('where' => 'user_id = '.$n->from_user_id))[0];
    	}
    	$data['notifications'] = $notifications;
    	$data['counted_sent_notifications'] = count($notifications);
    	if(is_null($notifications)){
    		$data['notifications'] = 'No New Messages.';
    	}
    	
        $data['active_menu'] = "sent";
    	$this->layout->load('admin/notifications', $data, 'ecommerce');
    }
    
    public function archive(){
    	$data['notifications'] = $notifications = $this->notifications->fetchAll(array('where' => 'user_id = '.$this->session->userdata['user_id'].' and status = 4'));
    	foreach($notifications as $n){
    		$n->to_user = $this->users->fetchAll(array('where' => 'user_id = '.$n->user_id))[0];
    		$n->from_user = $this->users->fetchAll(array('where' => 'user_id = '.$n->from_user_id))[0];
    	}
    	$data['notifications'] = $notifications;
    	$data['counted_archive_notifications'] = count($notifications);
    	if(is_null($notifications)){
    		$data['notifications'] = 'No New Messages.';
    	}
    	$data['counted_new_notifications'] = count($notifications);
    	$data['active_menu'] = "archive";
    	$this->layout->load('admin/notifications', $data, 'ecommerce');
    }
    
    public function trash(){
    	$data['notifications'] = $notifications = $this->notifications->fetchAll(array('where' => 'user_id = '.$this->session->userdata['user_id'].' and status = 5'));
    	foreach($notifications as $n){
    		$n->to_user = $this->users->fetchAll(array('where' => 'user_id = '.$n->user_id))[0];
    		$n->from_user = $this->users->fetchAll(array('where' => 'user_id = '.$n->from_user_id))[0];
    	}
    	$data['notifications'] = $notifications;
    	
    	if(is_null($notifications)){
    		$data['notifications'] = 'No New Messages.';
    	}
    	$data['counted_trash_notifications'] = count($notifications);
    	$data['active_menu'] = 'trash';
    	$this->layout->load('admin/notifications', $data, 'ecommerce');
    } 
    
    public function send($notification_id = null){
    	if($this->input->post('to_user_id')){
    		$res = $this->notifications->email($this->input->post('to_user_id'), $this->input->post('from_user_id'), $this->input->post('subject'), $this->input->post('message'));
    		if($res==true){
    			$this->session->set_flashdata('SUCCESS', 'You have successfully sent the email.');
    		}else{
    			$this->session->set_flashdata('FAILURE', 'Sorry, we could not complete your request at this time.');
    		}
    	}
    	
    	return $this->index();
    }
    
    public function archived($notification_id = null){ 
    	
    	$this->notifications->archive($notification_id);
    	$this->session->set_flashdata('SUCCESS', 'You successfully archived the message');
    	return $this->index();
    }
    
    public function unarchive($notification_id = null){
    	 
    	$this->notifications->unarchive($notification_id);
    	$this->session->set_flashdata('SUCCESS', 'You successfully unarchived the message');
    	return $this->index();
    }
    
    public function trashed($notification_id = null){
    	 
    	$this->notifications->trash($notification_id);
    	$this->session->set_flashdata('SUCCESS', 'You successfully archived the message');
    	return $this->index();
    }
}