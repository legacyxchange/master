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
        $this->load->model('bidding_model', 'bidding', true);
        $this->load->model('notifications_model', 'notifications', true);
        $this->load->model('watching_model', 'watching', true);
        $this->functions->checkLoggedIn();
    }
    
	public function index() {
		
        $header['headscript'] = $this->functions->jsScript('notifications.js');
        $menu['menu_account'] = 1;
        
        $user_id = $this->session->userdata['user_id'];
        
        $body['user'] = $this->user->fetchAll(array('where' => 'user_id = '.$user_id))[0];
        
        $query = $products = $this->db->query('select count(distinct listing_id) as bid_count from bidding join listings using(listing_id) join products using(product_id) where products.user_id = '.$this->session->userdata('user_id'));
        $body['bid_count'] = $query->result()[0]->bid_count;
        
        $body['products'] = $products = $this->products->fetchAll(array('where' => 'user_id = '.$this->session->userdata('user_id')));
        $body['listings'] = $listings = $this->listings->fetchAll(array('join' => 'products', 'on' => 'products.product_id = listings.product_id', 'where' => 'products.user_id = '.$this->session->userdata('user_id')));
        $body['notifications'] = $notifications = $this->notifications->fetchAll(array('where' => 'user_id = '.$this->session->userdata('user_id').' AND active=1'));
        $body['watching'] = $watching = $this->watching->fetchAll(array('where' => 'user_id = '.$this->session->userdata('user_id')));
        
        $body['admin_menu'] = $this->load->view('admin/admin_menu', $menu, true);
        $this->load->view('admin/template/header', $header);
        $this->load->view('admin/account', $body);
        $this->load->view('template/footer');
    }
}