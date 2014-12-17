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
        
        $this->load->model('product_types_model', 'product_types', true);
        
        $this->load->model('listings_model', 'listing', true);
        
        $this->load->model('product_ownership_records_model', 'product_ownership_record', true);
        
        $this->load->model('bidding_model', 'bidding', true);
        
        $this->load->library('cart');
    }

    public function index($product_type = null) {   
    	$header['headscript'] = $this->functions->jsScript('listing-product.js  search.js ');
        try {
        	if($product_type){
        		$query = $this->db->query('Select * from listings join products using(product_id) join product_types using(product_type_id) 
        				                           where NOW() BETWEEN start_time and end_time and product_types.type = "'.$product_type.'"');
        		$listings = $query->result();
        		
        		foreach($listings as $listing){
        			$listing->product = $this->product->fetchAll(array('where' => 'product_id = '.$listing->product_id))[0];
        			$listing->product->product_type = $this->product_types->fetchAll(array('where' => 'product_type_id = '.$listing->product->product_type_id))[0];
        			$listing->product->product_images = $this->product_image->fetchAll(array('where' => 'product_id = '.$listing->product_id, 'orderby' => 'order_index ASC'));
        			$listing->product->ownership_records = $this->product_ownership_record->fetchAll(array('where' => 'product_id = '.$listing->product_id, 'orderby' => 'product_ownership_record_id DESC', 'limit' => 5));
        			$listing->product->user = $this->user->fetchAll(array('where' => 'user_id = '.$listing->product->user_id))[0];
        			$listing->bidding = $this->bidding->fetchAll(array('where' => 'listing_id = '.$listing->listing_id));       			       			
        		}
        		        		
        		$body['listings'] = $listings;
        	}else 
        		$body['listings'] = $this->listing->fetchAll();
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }
        
        $this->load->view('template/header', $header);
        $this->load->view('listings/index', $body);
        $this->load->view('template/footer');
    }

    public function product($product_id) {
    	$header['headscript'] = $this->functions->jsScript('listing-product.js  search.js ');
    	$listings = $this->listing->fetchAll(array('where' => 'product_id = '.$product_id));
    	
    	foreach($listings as $listing){
    		$listing->product = $this->product->fetchAll(array('where' => 'product_id = '.$product_id))[0];
    		$listing->product->product_type = $this->product_types->fetchAll(array('where' => 'product_type_id = '.$listing->product->product_type_id))[0];
    		$listing->product->product_images = $this->product_image->fetchAll(array('where' => 'product_id = '.$product_id, 'orderby' => 'order_index ASC'));  		    		
    		$listing->product->ownership_records = $this->product_ownership_record->fetchAll(array('where' => 'product_id = '.$product_id, 'orderby' => 'product_ownership_record_id DESC', 'limit' => 5));  
    		$listing->product->user = $this->user->fetchAll(array('where' => 'user_id = '.$listing->product->user_id))[0];
    	}
    	$listings[0]->bidding = $this->bidding->fetchAll(array('where' => 'listing_id = '.$listings[0]->listing_id));
    	
        $body['listing'] = $listings[0];
        $this->load->view('template/header', $header);
        $this->load->view('listings/listing_product', $body);
        $this->load->view('template/footer');
    }
    
    public function buynow($listing_id){
    	//var_dump($_REQUEST); exit;
    	$user_id = $this->session->userdata['user_id'];
    	if(!$user_id){
    		echo json_encode(array('status' => 'FAILURE', 'message' => 'Not Logged In')); exit;
    	}
    	
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