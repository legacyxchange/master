<?php
error_reporting(E_ALL & ~E_NOTICE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function Dashboard() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('deals_model', 'deals', true);
        $this->load->model('products_model', 'product', true);
        $this->load->model('dashboard_model', 'dashboard', true);
        $this->load->model('listings_model', 'listing', true);
    }
    
	public function index() {
		
        $this->functions->checkLoggedIn();
        $header['headscript'] = $this->functions->jsScript('search.js welcome.js');
        
        $body['deals'] = $this->deals->getDealsByUserId($this->session->userdata['user_id']);
        $body['products'] = $products = $this->product->fetchAll(array('where' => 'user_id = '.$this->session->userdata('user_id')));
        $body['listings'] = $listings = $this->listing->fetchAll(array('join' => 'products', 'on' => 'products.product_id = listings.product_id', 'where' => 'products.user_id = '.$this->session->userdata('user_id')));
        
        $body['admin_menu'] = $this->load->view('admin/admin_menu', null, true);
        $this->load->view('admin/template/header', $header);
        $this->load->view('admin/dashboard', $body);
        $this->load->view('template/footer');
    }
}