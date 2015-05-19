<?php
error_reporting(E_ALL & ~E_NOTICE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sales extends CI_Controller {

	private $user_id;
	private $user;
	
    function Sales(){
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('user_model', 'users', true);
        $this->load->model('products_model', 'products', true);
        $this->load->model('listings_model', 'listings', true);
        $this->load->model('bidding_model', 'bidding', true);
        $this->load->model('notifications_model', 'notifications', true);
        $this->load->model('watching_model', 'watching', true);
        $this->load->model('sales_model', 'sales', true);
        $this->functions->checkLoggedIn();
        
        $this->user_id = $user_id = $this->session->userdata['user_id'];
        
        $this->user = $this->users->fetchAll(array('where' => 'user_id = '.$user_id))[0];
        
        $this->functions->checkLoggedIn();
    }
    
	public function index() {
		$header['headscript'] = $this->functions->jsScript('sales.js');
        $menu['menu_sales'] = 1;
        $body['user'] = $this->user;
        $body['admin_menu'] = $this->load->view('admin/admin_menu', $menu, true);
        $this->load->view('admin/template/header', $header);
        $this->load->view('admin/sales', $body);
        $this->load->view('template/footer');
    }
}