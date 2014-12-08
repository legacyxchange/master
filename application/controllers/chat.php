<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'third_party' . DS . 'bms' . DS . 'index.php';

class Chat extends CI_Controller {

    function Chat() {
    	
        parent::__construct();

        $this->load->driver('cache');

        $this->load->model('user_model', 'user', true);
        
        $this->load->model('chat_model', 'chat', true);
    }

    public function index() {
    	$header['headscript'] = $this->functions->jsScript('chat.js');
    	
    	$nowMinus = date('Y-m-d H:i:s', strtotime('-1 day',time()));
    	
        $chat = $this->chat->fetchAll(array('where' => 'created > "'.$nowMinus.'"', 'orderby' => 'chat_id DESC'));
        unset($chat[0]);
        $body['chat'] = $chat;
        
        $this->load->view('chat/index', $body);
    }

    public function ajax_chat(){
    	exit;
    	$nowMinus = date('Y-m-d H:i:s', strtotime('-1 second',time()));
    	 
    	if(!$this->session->userdata['user_id']){
    		echo json_encode(array('result' => 'FAILURE', 'user_id' => 0, 'message' => '', 'created' => null, 'hash' => md5(rand(1, 509884948)))); exit;
    	}
    		
    	$chat = $this->chat->fetchAll(array('where' => 'created >= "'.$nowMinus.'"', 'orderby' => 'chat_id DESC'))[0];	

    	$hash = md5($chat->user_id.'-'.$chat->message.'-'.$chat->created);
    	
    	if(!is_null($chat->message)) {
    		echo json_encode(array('result' => 'SUCCESS', 'user_id' => $user->user_id, 'username' => $chat->username,  'message' => $chat->message, 'created' => $chat->created, 'hash' => $hash)); exit;
    	}	
	
    	echo json_encode(array('result' => 'FAILURE', 'user_id' => 0, 'message' => '', 'created' => null, 'hash' => md5(rand(1, 509884948)))); exit;
    }
    
    public function ajax_insert(){
    	
    	echo $this->chat->save(); exit;
    }
}