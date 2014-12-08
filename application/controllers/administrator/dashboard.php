<?php
error_reporting(E_ALL & ~E_NOTICE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function Dashboard() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('deals_model', 'deals', true);
        $this->load->model('profile_model', 'profile', true);
        $this->load->model('dojos_model', 'dojos', true);
        $this->load->model('dashboard_model', 'dashboard', true);
        $this->load->model('search_model', 'search', true);
        $this->load->model('reviews_model', 'reviews', true);
        $this->load->helper('form');
        $this->load->helper('url');
    }
    
	public function index() {
		
        $this->functions->checkLoggedIn();
        $header['headscript'] = $this->functions->jsScript('search.js welcome.js');
        
        $this->load->view('administrator/template/header', $header);
        $this->load->view('administrator/dashboard', $body);
        $this->load->view('administrator/template/footer');
    }
}