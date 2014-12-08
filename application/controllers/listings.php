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
    	
    	$listings = $this->listing->fetchAll(array('where' => 'product_id = '.$product_id));
    	
    	foreach($listings as $listing){
    		$listing->product = $this->product->fetchAll(array('where' => 'product_id = '.$product_id))[0];
    		$listing->product->product_images = $this->product_image->fetchAll(array('where' => 'product_id = '.$product_id, 'orderby' => 'order_index ASC'));  		    		
    		$listing->product->ownership_records = $this->product_ownership_record->fetchAll(array('where' => 'product_id = '.$product_id, 'orderby' => 'product_ownership_record_id DESC', 'limit' => 5));  
    		$listing->user = $this->user->fetchAll(array('where' => 'user_id = '.$listing->product->user_id))[0];
    	}
    	//var_dump($listings); exit;
        $body['listings'] = $listings;
        $this->load->view('template/header', $header);
        $this->load->view('listings/index', $body);
        $this->load->view('template/footer');
    }
}