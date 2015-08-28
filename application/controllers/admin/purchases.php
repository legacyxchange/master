<?php
error_reporting(E_ALL & ~E_NOTICE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchases extends CI_Controller {

	private $user_id;
	private $user;
	
    function Purchases(){
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('user_model', 'users', true);
        $this->load->model('products_model', 'products', true);
        $this->load->model('listings_model', 'listings', true);
        $this->load->model('orders_model', 'orders', true);
        $this->load->model('notifications_model', 'notifications', true);
        $this->load->model('watching_model', 'watching', true);
        $this->load->model('purchases_model', 'purchases', true);
        $this->functions->checkLoggedIn();
        
        $this->user_id = $user_id = $this->session->userdata['user_id'];
        
        $this->user = $this->users->fetchAll(array('where' => 'user_id = '.$user_id))[0];
        
        $this->functions->checkLoggedIn();
    }
    
	public function index() {
		$data['title'] = 'My Purchases';
		$header['headscript'] = $this->functions->jsScript('purchases.js');
        $menu['menu_purchases'] = 1;
        $user_id = $user_id = $this->session->userdata['user_id'];
        
        $orders = $this->orders->fetchAll(array('where' => 'user_id = '.$user_id));

        foreach($orders as $o){        	
           
        }
        $body['orders'] = $orders; 
        
        $data['admin_menu'] = $this->load->view('admin/admin_menu', $menu, true);
        
        $this->layout->load('admin/purchases', $data, 'admin');
    }
}