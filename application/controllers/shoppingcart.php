<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'third_party' . DS . 'bms' . DS . 'index.php';

class ShoppingCart extends CI_Controller {

    function ShoppingCart() {
    	
        parent::__construct();

        $this->load->driver('cache');

        $this->load->model('user_model', 'user', true);
        
        $this->load->model('products_model', 'product', true);
        
        $this->load->model('product_images_model', 'product_image', true);
        
        $this->load->model('listings_model', 'listing', true);
        
        $this->load->model('product_ownership_records_model', 'product_ownership_record', true);
        
        $this->load->library('cart');
    }

    public function index($listing_id = null) {
    	$body['title'] = 'Shopping Cart';
    	
        try {
        	if($listing_id)
            	$body['listings'] = $this->listing->fetchAll(array('where' => 'listing_id = '.$listing_id));
        	else 
        		$body['listings'] = $this->listing->fetchAll();
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }
        //var_dump($body); exit;
        $this->load->view('template/header', $header);
        $this->load->view('shoppingcart/index', $body);
        $this->load->view('template/footer');
    }

    public function checkForItems() {
    	if($this->cart->total_items() > 1) { $c = $this->cart->total_items().' items'; }else{ $c = $this->cart->total_items().' item'; }
    	echo ($c.'<br /><span style="position:relative;top:-8px;left:-3px;font-size:11px;">$'.number_format($this->cart->total(),2).'</span>'); exit;
    }
}