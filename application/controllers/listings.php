<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'third_party' . DS . 'bms' . DS . 'index.php';

class Listings extends CI_Controller {

    function Listings() {
    	
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
        try {
        	if($listing_id)
            	$body['listings'] = $this->listing->fetchAll(array('where' => 'listing_id = '.$listing_id));
        	else 
        		$body['listings'] = $this->listing->fetchAll();
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }
        
        $this->load->view('template/header', $header);
        $this->load->view('listings/index', $body);
        $this->load->view('template/footer');
    }

    public function product($product_id) {
    	$header['headscript'] = $this->functions->jsScript('listing-product.js');
    	$listings = $this->listing->fetchAll(array('where' => 'product_id = '.$product_id));
    	
    	foreach($listings as $listing){
    		$listing->product = $this->product->fetchAll(array('where' => 'product_id = '.$product_id))[0];
    		$listing->product->product_images = $this->product_image->fetchAll(array('where' => 'product_id = '.$product_id, 'orderby' => 'order_index ASC'));  		    		
    		$listing->product->ownership_records = $this->product_ownership_record->fetchAll(array('where' => 'product_id = '.$product_id, 'orderby' => 'product_ownership_record_id DESC', 'limit' => 5));  
    		$listing->product->owner = $this->user->fetchAll(array('where' => 'user_id = '.$listing->product->user_id))[0];
    	}
    	//$this->session->unset_userdata('cart_contents');
        $body['listing'] = $listings[0];
        $this->load->view('template/header', $header);
        $this->load->view('listings/index', $body);
        $this->load->view('template/footer');
    }
    
    public function buynow($listing_id){
    	$listings = $this->listing->fetchAll(array('where' => 'listing_id = '.$listing_id));
    	foreach($listings as $listing){
    		$listing->product = $this->product->fetchAll(array('where' => 'product_id = '.$listing->product_id))[0];
    		
    		$data = array(
    				'id'      => $listing->listing_id,
    				'qty'     => 1,
    				'price'   => $listing->buynow_price,
    				'name'    => $listing->product->name,
    				//'options' => array('Size' => 'L', 'Color' => 'Red')
    		);
    		//var_dump($data); exit; 
    		$this->cart->insert($data);
    	}
    	if($this->cart->total_items() > 1) { $c = $this->cart->total_items().' items'; }else{ $c = $this->cart->total_items().' item'; }
    	echo ($c.'<br /><span style="position:relative;top:-8px;left:-3px;font-size:11px;">$'.number_format($this->cart->total(),2).'</span>'); exit;
    }
}