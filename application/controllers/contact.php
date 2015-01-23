<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact extends CI_Controller {

    function Contact() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('user_model', 'user', true);
        $this->load->library('email');
    }
    
    // user that is not logged in will be redirected to this function
    public function index(){ 
    	$this->load->view('template/header', $header);
        $this->load->view('contact/index', $body);         
        $this->load->view('template/footer');
    }
    
    public function send(){
    	if(empty($_POST['email']))
    	{
    		$this->session->set_flashdata('FAILURE', 'You must supply a valid email.');
    		header('Location: /contact'); exit;
    	}
    	if(empty($_POST['message']))
    	{
    		$this->session->set_flashdata('FAILURE', 'Message cannot be empty.');
    		header('Location: /contact'); exit;
    	}
    	$config['protocol'] = 'mail';
    	$config['mailpath'] = '/bin/mail';
    	$config['charset'] = 'iso-8859-1';
    	$config['wordwrap'] = TRUE;
    	$config['smtp_host'] = 'imap.secureserver.net'; 
    	$config['smtp_user'] = 'nickr@legacyxchange.com';
    	$config['smtp_pass'] = '031866YuP';
    	
    	$this->email->initialize($config);
    	//var_dump($this->email); exit;
    	$this->email->from($_POST['email'], $_POST['fullname']);
    	$this->email->to('nicolino101@gmail.com');
    	//$this->email->cc('another@another-example.com');
    	//$this->email->bcc('them@their-example.com');
    	
    	$this->email->subject('Contact Page');
    	$this->email->message($_POST['message']);
    	
    	$this->email->send();
    	
    	$this->session->set_flashdata('SUCCESS', 'Your message has been received and we will respond within 24 hours.');
    	header('Location: /contact'); exit;
    }
}