<?php
error_reporting(E_ALL & ~E_NOTICE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account extends CI_Controller {

    function Account() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('user_model', 'user', true);
        $this->load->model('products_model', 'products', true);
        $this->load->model('dashboard_model', 'dashboard', true);
        $this->load->model('listings_model', 'listings', true);
        $this->functions->checkLoggedIn();
    }
    
	public function index() {
		
        $header['headscript'] = $this->functions->jsScript('search.js welcome.js');
        $menu['menu_account'] = 1;
        
        $user_id = $this->session->userdata['user_id'];
        
        $body['user'] = $this->user->fetchAll(array('where' => 'user_id = '.$user_id))[0];
        
        $body['products'] = $products = $this->products->fetchAll(array('where' => 'user_id = '.$this->session->userdata('user_id')));
        $body['listings'] = $listings = $this->listings->fetchAll(array('join' => 'products', 'on' => 'products.product_id = listings.product_id', 'where' => 'products.user_id = '.$this->session->userdata('user_id')));
        
        $body['admin_menu'] = $this->load->view('admin/admin_menu', $menu, true);
        $this->load->view('admin/template/header', $header);
        $this->load->view('admin/account', $body);
        $this->load->view('template/footer');
    }
}