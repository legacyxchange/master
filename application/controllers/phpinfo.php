<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Phpinfo extends CI_Controller {

    function Phpinfo() {
        parent::__construct();
    }
    
    // user that is not logged in will be redirected to this function
    public function index($location_id = null){
    	phpinfo();
    }
}