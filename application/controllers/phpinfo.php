<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Phpinfo extends CI_Controller {

    function Phpinfo() {
        parent::__construct();
        $this->load->model('test_model', 'test', true);
    }
    
    public function index(){
    	phpinfo(); exit;
    }
}