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
        
        $this->load->model('listings_model', 'listings', true);
        
        $this->load->model('product_ownership_records_model', 'product_ownership_record', true);
        
        $this->load->model('bidding_model', 'bidding', true);
        
        $this->load->library('cart');
        
        $this->load->helper('form');
    }

    public function index($product_type = null, $limit = null, $offset = null) {  
    	$header['headscript'] = $this->functions->jsScript('listing-product.js  search.js timer.js');
        try {
        	if($product_type){ 
        		$body['product_type'] = $product_type;
        		$query = $this->db->query('Select * from listings join products using(product_id) join product_types using(product_type_id) 
        				                           where NOW() BETWEEN start_time and end_time and product_types.type = "'.$product_type.'" LIMIT 16');
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
        	}else { 
        		
        		$query = $this->db->query('Select * from listings join products using(product_id) join product_types using(product_type_id) 
        				                           where NOW() BETWEEN start_time and end_time LIMIT 16');
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
        	} 

        	if($product_type == 'secondary'){
        		$query = $this->db->query('Select * from listings join products using(product_id) join product_types using(product_type_id)
        				                           where NOW() BETWEEN start_time and end_time AND product_type_id = 1 LIMIT 4');
        		$body['listings2'] = $query->result();
        	}else{
        		$query = $this->db->query('Select * from listings join products using(product_id) join product_types using(product_type_id)
        				                           where NOW() BETWEEN start_time and end_time AND product_type_id = 2 LIMIT 4');
        		$body['listings2'] = $query->result();
        	}
        } catch (Exception $e) { 
            $this->functions->sendStackTrace($e);
        }
        
        $this->load->view('template/header', $header);
        $this->load->view('listings/index', $body);
        $this->load->view('template/footer');
    }

    public function product($product_id) {
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
    	
        $body['listing'] = $listings[0];
        $this->load->view('template/header', $header);
        $this->load->view('listings/product', $body);
        $this->load->view('template/footer');
    }
    
    public function search($product_type=null) { 
    	$header['headscript'] = $this->functions->jsScript('listing-product.js search.js timer.js');
    	//$listings = $this->listings->fetchAll(array('where' => 'product_id = '.$product_id));
    	 
    	if (! empty ( $_POST )) { 
			$iStr = $this->_sphinx ();
			if($iStr){
				$cid = ! empty ( $_POST ['category_id'] ) ? $_POST ['category_id'] : null;
				//$ptid = ! empty ( $_POST ['product_type_id'] ) ? $_POST ['product_type_id'] : null;
				$ptype = $this->product_types->fetchAll(array('where' => 'type = "'.$product_type.'"'));
				//var_dump ( $cid, $ptid, $_POST, $iStr );
				//exit ();
				$sql = '
    	    		select * from listings as l 
					join products as p using(product_id) 
					join product_types as pt using(product_type_id)
					join product_categories as pc using(product_id)
					join categories as c using(category_id)
					where l.listing_id IN(' . $iStr . ')
    			';
			
				if (! is_null ( $cid )) {
					$sql .= ' and category_id = ' . $cid ;
				}
			
				if (! is_null ( $product_type )) {
					$sql .= ' and product_type_id = ' . $ptype[0]->product_type_id ;
				}
				
				$query = $this->db->query($sql);
			
				$listings = $query->result();
    		}
		}else{
			$listings = null;
		}
    	//var_dump($listings); exit;
    	$body['listings'] = $listings;
    	$this->load->view('template/header', $header);
    	$this->load->view('listings/index', $body);
    	$this->load->view('template/footer');  
    }
    
    public function _sphinx(){
    	if(!empty($_POST['q'])){
    		$body['q'] = $q = $_POST['q'];
    		$this->load->file('application/vendor/sphinxapi.php', true);
    		$cl = new SphinxClient();
    		$cl->SetServer( "localhost", 9312 );
    
    		$cl->SetMatchMode(SPH_MATCH_ANY);
    
    		$cl->SetFieldWeights(array('description' => 50, 'name' => 100));
    
    		$res = $cl->Query($q , 'ads');
    	}
    	 
    	if(!empty($res['matches'])){
    		$c = 1;
    		foreach ($res['matches'] AS $key => $val) {
    			if((int)$val['weight'] > 150){
    				if ($c == 1) {
    					$iStr = $val['attrs']['listing_id'];
    				}
    				else {
    					$iStr .= ',' . $val['attrs']['listing_id'];
    				}
    				 
    				$c++;
    			}
    		}
    		return $iStr;
    	}
    	return false;
    }
    
    public function bid($listing_id = null){ 
    	$this->functions->checkLoggedIn();
    	if(!empty($_POST)){
    		$_POST['user_id'] = $user_id = $this->session->userdata['user_id'];
    		$_POST['listing_id'] = $listing_id;
    		$query = $this->db->query('select sum(bid_amount) as top_bid, user_id from bidding where listing_id = '.$listing_id);
    		$top_bid = $query->result()[0]->top_bid;
    		$listing = $this->listings->fetchAll(array('where' => 'listing_id = '.$listing_id))[0];
    		$_POST['bid_amount'] = $bid = $_POST['bid'];
    		$reserve_price = $listing->reserve_price;
    		
    		//var_dump($_POST['bid'], $top_bid, $listing); exit;
    		
    		if($bid > $listing->minimum_bid && $bid > $top_bid){
    			// add bid to db
    			$lid = $this->bidding->save();
    			return $this->product($listing->product_id);
    		} else {
    			
    		}
    	}else{
    		var_dump($_SESSION); exit; 
    	}
    }
    
    public function track_bidding($listing_id = null){
    	$this->functions->checkLoggedIn();
    	
    	$_POST['user_id'] = $user_id = $this->session->userdata['user_id'];
    	$_POST['listing_id'] = $listing_id;
    	$query = $this->db->query('select * from bid_tracking where user_id = '.$user_id.' AND listing_id = '.$listing_id);
    	$tBid = $query->result()[0]->tracking;
    	$listing = $this->listings->fetchAll(array('where' => 'listing_id = '.$listing_id))[0];
    	$reserve_price = $listing->reserve_price;
    
        var_dump($_POST, $tBid, $listing); exit;
    
    	if($bid > $listing->minimum_bid && $bid > $top_bid){
    		// add bid to db
    		$lid = $this->bid_tracking->save();
    		return $this->product($listing->product_id);
    	} else {
    			 
    	}
    }
    
    public function buynow($listing_id){
    	$user_id = $this->session->userdata['user_id'];
    	if(!$user_id){
    		echo json_encode(array('status' => 'FAILURE', 'message' => 'Not Logged In')); exit;
    	}
    	
    	$listings = $this->listings->fetchAll(array('where' => 'listing_id = '.$listing_id));
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