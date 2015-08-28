<?php
error_reporting(E_ALL & ~E_NOTICE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bids extends CI_Controller {

	private $user_id;
	private $user;
	
    function Bids() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('user_model', 'users', true);
        $this->load->model('products_model', 'products', true);
        $this->load->model('listings_model', 'listings', true);
        $this->load->model('bidding_model', 'bidding', true);
        $this->load->model('notifications_model', 'notifications', true);
        $this->load->model('watching_model', 'watching', true);
        $this->load->model('stores_model', 'stores', true);
        $this->functions->checkLoggedIn();        
    }
    
    public function index() {
    	$header['headscript'] = $this->functions->jsScript('bidding.js');
    	$menu['menu_bids'] = 1;
    	 
    	$user_id = $user_id = $this->session->userdata['user_id'];
    
    	$query = $this->db->query('
    			select users.username, bidding.*, listings.end_time, products.product_id, products.name, products.description from bidding
                join listings using(listing_id)
                join products using(product_id)
                join users using(user_id)
                where user_id = '.$user_id.' group by bidding.listing_id;
    			');
    	$results = $query->result();
    	foreach($results as $k=>$r){ 
    		if(isset($q->listing_id)){
    			$r->last_bid = $this->getLastBid($r->listing_id);
    			$r->current_bid = $r->last_bid + $r->minimum_bid;
    		}
    	}   
    		
    	$body['products'] = $results;
    	$body['admin_menu'] = $this->load->view('admin/admin_menu', $menu, true);
    	$this->layout->load('admin/bids', $body, 'admin');
    }
    
    public function getLastBid($listing_id){
    	return $this->db->select_max(bid_amount)->where('listing_id = '.$listing_id)->get('bidding')->result()[0]->bid_amount;
    }
    
	public function indexOLD() {
		$header['headscript'] = $this->functions->jsScript('bidding.js');
        $menu['menu_bids'] = 1;
                     
        $user_id = $user_id = $this->session->userdata['user_id'];
        
        $user = $this->users->fetchAll(array('where' => 'user_id = '.$user_id));

        foreach($user as $key => $u){        	
        	$u->products = $this->products->fetchAll(array('where' => 'user_id = '.$user_id));
        	foreach($u->products as $k=>$p){  
        		if(!is_null($p->product_id))      		
        			$p->listing = $this->listings->fetchAll(array('where' => 'product_id = '.$p->product_id))[0];
        		if(!is_null($p->listing->listing_id)){
        			$p->listing->bidding = $this->bidding->fetchAll(array('where' => 'listing_id = '.$p->listing->listing_id)); 
        			if(!empty($p->listing->bidding)){       			
        				$p->listing->last_bid = max($p->listing->bidding)->bid_amount;
        				$p->listing->current_bid = max($p->listing->bidding)->bid_amount + $p->listing->minimum_bid;
        			}else{
        				unset($user[$key]->products[$k]);
        			}
        		}
        	}        	
        }
        
        $body['user'] = $user[0]; 
        $body['admin_menu'] = $this->load->view('admin/admin_menu', $menu, true);
        $this->layout->load('admin/bids', $body, 'admin');
    }
}