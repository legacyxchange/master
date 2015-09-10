<?php
error_reporting(E_ALL & ~E_NOTICE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account extends CI_Controller {

    function Account() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('user_model', 'user', true);
        $this->load->model('user_accounts_model', 'user_accounts', true);
        $this->load->model('products_model', 'products', true);
        $this->load->model('dashboard_model', 'dashboard', true);
        $this->load->model('listings_model', 'listings', true);
        $this->load->model('bidding_model', 'bidding', true);
        $this->load->model('notifications_model', 'notifications', true);
        $this->load->model('watching_model', 'watching', true);
        $this->functions->checkLoggedIn();
    }
    
	public function index() {
		$data['title'] = 'My Account';
        $header['headscript'] = $this->functions->jsScript('notifications.js');
        $menu['menu_account'] = 1;
        $data['account_type'] = 'Individual';
        $user_id = $this->session->userdata['user_id'];
        
        $data['user'] = $this->user->fetchAll(array('where' => 'user_id = '.$user_id))[0];
        
        $query = $products = $this->db->query('select count(distinct listing_id) as bid_count from bidding join listings using(listing_id) join products using(product_id) where products.user_id = '.$this->session->userdata('user_id'));
        $data['bid_count'] = $query->result()[0]->bid_count;
        
        $data['products'] = $products = $this->products->fetchAll(array('where' => 'user_id = '.$this->session->userdata('user_id')));
        $data['listings'] = $listings = $this->listings->fetchAll(array('join' => 'products', 'on' => 'products.product_id = listings.product_id', 'where' => 'products.user_id = '.$this->session->userdata('user_id')));
        $data['notifications'] = $notifications = $this->notifications->fetchAll(array('where' => 'user_id = '.$this->session->userdata('user_id').' AND status=1'));
        $data['watching'] = $watching = $this->watching->fetchAll(array('where' => 'user_id = '.$this->session->userdata('user_id')));
        $data['user_account'] = $this->user_accounts->fetchAll(array('where' => 'user_id = '.$this->session->userdata['user_id']))[0];
        $data['admin_menu'] = $this->load->view('admin/admin_menu', $menu, true);
        $this->layout->load('admin/account', $data, 'admin');
    }
}