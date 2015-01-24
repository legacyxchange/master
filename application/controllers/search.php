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
    	    
    		$this->load->file('application/vendor/sphinxapi.php', true);
    		
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
    	
        $header['headscript'] = $this->functions->jsScript('search.js welcome.js timer.js');
        
        if($iStr !== 'no matches'){ 
        	$listings = $this->listing->fetchAll(array('where' => 'start_time <= NOW() AND end_time >= NOW()'.$iStr, 'orderby' => 'end_time ASC'));
        	//var_dump($listings); exit;
        	foreach($listings as $key=>$listing){ 
        		$listing->original = $this->product->fetchAll(array('where' => 'product_id = '.$listing->product_id.' AND product_type_id = 1'))[0];
        		
        		$listing->secondary = $this->product->fetchAll(array('where' => 'product_id = '.$listing->product_id.' AND product_type_id = 2'))[0];
        		
        		if(!is_null($listing->original)){
        			$listings['original'][] = $listing->original;
        		}
        		if(!is_null($listing->secondary)){
        			$listings['secondary'][] = $listing->secondary;
        		}
        	}        
        } 
        
        $body['stores'] = $this->getStores();                      
        $body['flash_listings'] = $this->getFlashListings();
        $body['listings'] = $listings;
        $this->load->view('template/header', $header);
        $this->load->view('search/index', $body);
        $this->load->view('template/footer');
    }
    
    protected function getStores($limit = 6){
    	$query = $this->db->query('
        		select * from locations as l join locationimages as li on l.id = li.locationid group by l.id order by l.id DESC limit '.$limit.';
        ');
    	if(count($query->result()) > 0){
    		$stores = array();
    		foreach($query->result() as $key=>$store){
    			$stores []= $store;
    		}
    	}else{
    		$stores = 'Sorry...There are no Stores Available.';
    	}
    	
    	return $stores;
    }
    
    protected function getFlashListings($limit = 4){
    	$query = $this->db->query('
        		select * from flash_sale_listings as fsl
				join listings as l using(listing_id)
				join products as p using(product_id)
				where NOW() BETWEEN l.start_time AND l.end_time limit '.$limit.';
        ');
    	
    	if(count($query->result()) > 0){
    		$flash_listings = array();
    		foreach($query->result() as $key=>$flash_listing){
    			$flash_listings []= $flash_listing;
    		}
    	}else{
    		$flash_listings = 'Sorry...There are no Flash Sales Today.';
    	}
    	
    	return $flash_listings;
    }
    
    /* public function search_keywords(){
    	$partialWord = 'foo';
    	
    	$query = $this->db->query('select l.keywords, p.description from listings as l join products as p using(product_id)');
    	
    	foreach($query->result() as $r){ var_dump(explode(' ', $r->description)); exit;var_dump($this->getWords($partialWord, $r->description)); exit;
    		if(!is_null($r->keywords))
    			$words []= $this->getWords($partialWord, $r->keywords, ',');  		
    	}
    	
    	
    	var_dump(array_unique($words));	
    	exit;
    }
    
    private function getWords($pWord, $words, $delimiter = ' '){
    	
    	
    		$array = explode($delimiter,$words);
    		$a = array_unique($array);
    		
    		foreach($a as $keyword){
    			if(stristr($keyword, $pWord))
    				return $keyword;
    		}
    	
    
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
    } */
}