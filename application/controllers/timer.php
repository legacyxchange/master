<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Timer extends CI_Controller {

    function Timer() {
        parent::__construct();
        
        $this->load->driver('cache');
        $this->load->model('search_model', 'search', true);
        $this->load->model('user_model', 'user', true);
        $this->load->model('products_model', 'product', true);
        $this->load->model('product_types_model', 'product_type', true);
        $this->load->model('listings_model', 'listing', true);
    }
    
    // user that is not logged in will be redirected to this function
    public function index($timer_id){
    	if (! is_null ( $timer_id )) {
			$timer = $this->listing->fetchAll(array('where' => 'timer_id = '.$timer_id));
		}
		var_dump($timer);
    }
    
    public function ajax_timer($listing_id){
    	$listings = $this->listing->fetchAll(array('where' => 'listing_id = '.$listing_id));
    	 
    	foreach($listings as $listing){
    		$_seconds = (strtotime($listing->end_time) - time());
    		 
    		$days = $_seconds / 3600 / 24;
    		 
    		$listing->days = floor($_seconds / 3600 / 24);
    
    		$hours = ($days - $listing->days) * 24 - 2;
    		 
    		$listing->hours = floor(($days - $listing->days) * 24 - 2);
    
    		$minutes = ($hours - $listing->hours) * 60;
    		 
    		$listing->minutes = floor(($hours - $listing->hours) * 60);
    
    		$seconds = ($minutes - $listing->minutes) * 60;
    		 
    		$listing->seconds = floor(($minutes - $listing->minutes) * 60);
    	}
    	 
    	if($listing->days == 0  && $listing->hours == 0 && $listing->minutes == 0 && $listing->seconds < 1){
    		$this->expireListing($listing_id);
    		echo 'Time Left: Expired!'; exit;
    	}
    	if($listing->days < 2) { $_days = 'day'; } else { $_days = 'days'; }
    	$days = $listing->days > 0 ? $listing->days.' '.$_days.' ' : null;
    	echo ''.$days.' '.str_pad($listing->hours, 2, 0, STR_PAD_LEFT).':'.str_pad($listing->minutes, 2, 0, STR_PAD_LEFT).':'.str_pad($listing->seconds, 2, 0, STR_PAD_LEFT);
    	exit;
    }
}