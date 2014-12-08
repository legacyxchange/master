<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact extends CI_Controller {

    function Contact() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->library('email');
    }
    
    // user that is not logged in will be redirected to this function
    public function index(){
    	$this->load->view('admin/template/header', $header);
        $this->load->view('contact/index', $body);         
        $this->load->view('template/footer');
    }
    
    public function send(){
    	$config['protocol'] = 'sendmail';
    	$config['mailpath'] = '/usr/sbin/sendmail';
    	$config['charset'] = 'iso-8859-1';
    	$config['wordwrap'] = TRUE;
    	$config['smtp_host'] = 'imap.secureserver.net'; 
    	$config['smtp_user'] = 'nickr@legacyxchange.com';
    	$config['smtp_pass'] = '031866YuP';
    	
    	$this->email->initialize($config);
    	//var_dump($this->email); exit;
    	$this->email->from($_POST['email'], $_POST['fullname']);
    	$this->email->to('support@legacyxchange.com');
    	//$this->email->cc('another@another-example.com');
    	//$this->email->bcc('them@their-example.com');
    	
    	$this->email->subject('Contact Page');
    	$this->email->message($_POST['message']);
    	
    	$this->email->send();
    	
    	$this->session->set_flashdata('SUCCESS', 'Your message has been received and we will respond within 24 hours.');
    	header('Location: /contact'); exit;
    }
}