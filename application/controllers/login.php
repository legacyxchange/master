<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    function Login() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('user_model', 'user', true);
        $this->load->library('email');
    }
    
    // user that is not logged in will be redirected to this function
    public function index(){ 
    	$this->layout->load('welcome/login', null);         
    }
}