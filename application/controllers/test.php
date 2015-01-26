<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    function Test() {
        parent::__construct();
        $this->load->driver('cache');
        
        $this->load->model('test_model', 'test', true);
        
        $this->load->model('user_model', 'user', true);
        
        $this->load->model('listings_model', 'listings', true);
        
        $this->load->model('products_model', 'product', true);
        
        $this->load->model('product_images_model', 'product_image', true);
        
        $this->load->model('product_types_model', 'product_types', true);
        
        $this->load->model('product_ownership_records_model', 'product_ownership_record', true);
        
        $this->load->model('bidding_model', 'bidding', true);
        
        $this->load->library('cart');
        
        $this->load->helper('form');
        $this->load->helper('url');
    }
    
    public function listings(){
    	$header['headscript'] = $this->functions->jsScript('search.js welcome.js');
    	
    	$query = $this->db->query('
    			SELECT * from listings as l 
    			join products as p using(product_id);
    	');
    	
    	$body['listings'] = $query->result();
    	
    	$this->load->view('template/header', $header);
        $this->load->view('test/index', $body);
        $this->load->view('template/footer');
    }
    
    // user that is not logged in will be redirected to this function
    public function index($location_id = 2296){
    	
    	try {
            $deals = $this->test->fetchAll(
            	array(
                	'where' => 'location_id = '.$location_id.' and featured = 1',
            		'join' => 'locations as l',
            		'on' => 'l.id = deals.location_id'
            	)
            );
            var_dump($deals); exit;
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }  
    }
    
    public function phpinfo(){
    	phpinfo();
    }
    
    public function sphinx(){
    	$this->load->file('/var/www/html/application/vendor/sphinxapi.php', true);
    	$cl = new SphinxClient();
    	$cl->SetServer( "localhost", 9312 );
    	//var_dump($cl);
    	$cl->SetMatchMode( SPH_MATCH_EXTENDED  );
        $cl->SetRankingMode ( SPH_RANK_SPH04 );

        $q = $_REQUEST['q']; 
        
        $searchresults = $cl->Query($q , 'my_new_search_index' );
        
        if(!empty($searchresults['matches'])){
        	
        	foreach($searchresults['matches'] as $key=>$val){
        		$iStr .= $key.', ';
        	}
            $iStr = trim($iStr,', ');
        
            $res = $this->listings->fetchAll(array('where' => 'product_id IN('.$iStr.')')); 
            foreach($res as $r){
            	$r->product = $this->products->fetchAll(array('where' => 'product_id = '.$r->product_id));
            }
            
            var_dump($res);
        }
        echo $cl->GetLastError();
        exit;
    }
    
    public function timer($product_id = 23){
    	$header['headscript'] = $this->functions->jsScript('listing-product.js search.js timer.js');
    	
    	$listings = $this->listings->fetchAll(array('where' => 'product_id = '.$product_id));
    	
    	foreach($listings as $listing){
    		$listing->product = $this->product->fetchAll(array('where' => 'product_id = '.$product_id))[0];
    		$listing->product->product_type = $this->product_types->fetchAll(array('where' => 'product_type_id = '.$listing->product->product_type_id))[0];
    		$listing->product->product_images = $this->product_image->fetchAll(array('where' => 'product_id = '.$product_id, 'orderby' => 'order_index ASC'));  		    		
    		$listing->product->ownership_records = $this->product_ownership_record->fetchAll(array('where' => 'product_id = '.$product_id, 'orderby' => 'product_ownership_record_id DESC', 'limit' => 5));  
    		$listing->product->user = $this->user->fetchAll(array('where' => 'user_id = '.$listing->product->user_id))[0];
    	}
    	$listings[0]->bidding = $this->bidding->fetchAll(array('where' => 'listing_id = '.$listings[0]->listing_id));
    	
    	$query = $this->db->query('Select * from listings as l join products as p using(product_id) where p.product_id <> '.$listings[0]->product->product_id.' AND p.user_id = '.$listings[0]->product->user->user_id);
    	$body['listings_other'] = $query->result();
    	
    	//var_dump($listings[0]); exit;
        $body['listing'] = $listings[0];
        
    	$this->load->view('template/header', $header);
    	$this->load->view('test/timer', $body);
    	$this->load->view('template/footer');
    }
}