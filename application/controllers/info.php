<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Info extends CI_Controller {

    function Info() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('deals_model', 'deals', true);
        $this->load->model('menu_model', 'menu', true);
        $this->load->model('profile_model', 'profile', true);
        $this->load->model('dojos_model', 'dojos', true);
        $this->load->model('locations_model', 'locations', true);
        $this->load->model('reviews_model', 'reviews', true);
        $this->load->model('search_model', 'search', true);
        $this->load->helper('form');
        $this->load->helper('url');
    }
    
    // user that is not logged in will be redirected to this function
    public function index(){
    	
    	$this->load->view('/template/header', $header);
        $this->load->view('/info/index', $body);         
        $this->load->view('/template/footer');
    }
}