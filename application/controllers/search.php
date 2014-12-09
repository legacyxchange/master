<?php
//testswt
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends CI_Controller {

    function Search() {
        parent::__construct(); 

        $this->load->driver('cache');
        $this->load->model('search_model', 'search', true);      
        $this->load->model('user_model', 'user', true);        
        $this->load->model('products_model', 'product', true);
        $this->load->model('product_types_model', 'product_type', true);
        $this->load->model('listings_model', 'listing', true);
    }

    public function index($word = null, $location = null) { 
    	
    	if(!empty($_POST['q'])){
    	    $q = $_POST['q'];
    	    
    	    $header['q'] = $q;
    	    
    		$this->load->file('/var/www/html/application/vendor/sphinxapi.php', true);
    		
    		$cl = new SphinxClient(); 
    		
    		$cl->SetServer( "localhost", 9312 );
    		
    		$cl->SetMatchMode( SPH_MATCH_EXTENDED  );
    		
        	$cl->SetRankingMode ( SPH_SORT_RELEVANCE );

        	$searchresults = $cl->Query($q, 'se_index' );
        	//var_dump($cl->getLastError(), $searchresults['matches']); exit;
            $iStr = null;
            
        	if(!empty($searchresults['matches'])){ 
        	
        		foreach($searchresults['matches'] as $key=>$val){
        			$iStr .= $key.', ';
        		}
        		
            	$iStr = ' and product_id in('.trim($iStr,', ').')';
            }
            else{
            	$iStr = 'no matches';
            }
    	}else{
    		$iStr = '';
    	}
    	
        $header['headscript'] = $this->functions->jsScript('search.js welcome.js timer.js jssor.slider.mini.js jssor.init.js');
        
        if($iStr !== 'no matches'){ 
        	$listings = $this->listing->fetchAll(array('where' => 'start_time <= NOW() AND end_time >= NOW()'.$iStr, 'orderby' => 'end_time ASC'));
        	
        	foreach($listings as $key=>$listing){
        		$listing->product = $this->product->fetchAll(array('where' => 'product_id = '.$listing->product_id))[0];
        		if(is_null($listing->product)){
        			unset($listings[$key]);
        		}
        	}
        } else {
        	$listings = 'Sorry No Matches for that Criteria...';
        }
        
        $body['listings'] = $listings;
        $this->load->view('admin/template/header', $header);
        $this->load->view('search/index', $body);
        $this->load->view('template/footer');
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
    	echo 'Time Left: '.$days.' '.str_pad($listing->hours, 2, 0, STR_PAD_LEFT).':'.str_pad($listing->minutes, 2, 0, STR_PAD_LEFT).':'.str_pad($listing->seconds, 2, 0, STR_PAD_LEFT);
    	exit;
    }
}