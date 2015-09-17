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
        $this->load->model('payment_types_model', 'payment_types', true);
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
        
        $and = null;
        if($this->input->post('start_date') && $this->input->post('end_date')){
        	$and = ' and created between "'.$this->input->post('start_date').'" AND "'.$this->input->post('end_date').'" ';
        }
        if($this->input->post('transaction_id')){
        	$and = ' and transaction_id LIKE("'.$this->input->post('transaction_id').'%")';
        }
        if($this->input->post('payment_type')){
        	$and = ' and payment_type = '.$this->input->post('payment_type');
        }
        if($this->input->post('amount')){
        	$and = ' and amount LIKE("'.$this->input->post('amount').'%")';
        }
        if($this->input->post('order_id')){
        	$and = ' and order_id LIKE("'.$this->input->post('order_id').'%")';
        }
       
        $orders = $this->orders->fetchAll(array('where' => 'user_id = '.$user_id.$and));

        foreach($orders as $o){ 
            if(!is_null($o->payment_type)){
        		$o->payment_type = $this->payment_types->fetchAll(array('where' => 'payment_type_id = '.$o->payment_type ))[0]->payment_type;
            }else{
            	$o->payment_type = 'Visa';
            }
        }
        //var_dump($orders); exit;
        $data['orders'] = $orders; 
        
        $data['admin_menu'] = $this->load->view('admin/admin_menu', $menu, true);
        
        $this->layout->load('admin/purchases', $data, 'admin');
    }
}