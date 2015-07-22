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
        
        $this->load->model('products_model', 'products', true);
        
        $this->load->model('product_images_model', 'product_image', true);
        
        $this->load->model('product_types_model', 'product_types', true);
        
        $this->load->model('product_ownership_records_model', 'product_ownership_record', true);
        
        $this->load->model('bidding_model', 'bidding', true);
        
        $this->load->model('notifications_model', 'notifications', true);
        
        $this->load->library('cart');
        
        $this->load->helper('form');
        $this->load->helper('url');
    }
    
    public function testsha1($var = null){
    	if($var == 'ron2'){
    		$var = '4re2pst1*';
    		echo 'Legacyxtest2@gmail.com';
    	}
    	if($var == 'ron1'){
    		$var = '4re2pst1!';
    		echo 'Legacyxtest1@gmail.com';
    	}
    	var_dump($var, sha1($var)); exit;
    }
    
    public function redirecting(){ 
    	redirect('/listings'); exit;
    }
    
    public function testaim(){
    	//var_dump(__METHOD__); exit;
    	require_once '/var/www/idev/master/application/vendor/sdk-php-master/autoload.php';
    	define("AUTHORIZENET_API_LOGIN_ID", "2v54NRjeFT87");
    	define("AUTHORIZENET_TRANSACTION_KEY", "48zsA484397JkWa4"); 
    	define("AUTHORIZENET_SANDBOX", true);
    	$sale = new AuthorizeNetAIM(); 
    	
    	$sale = new AuthorizeNetAIM;
    	$sale->setFields(
    			array(
    					//'invoiceNumber', 'invoice_number' => 'tewf03r23r',
    					'description' => 'Test Item form LXC',
    					'amount' => rand(1, 1000),
    					'card_num' => '4007000000027',
    					'exp_date' => '0418'
    			)
    	);
    	$sale->addLineItem(
    			'item1', // Item Id
    			'Golf tees', // Item Name
    			'Blue tees', // Item Description
    			'2', // Item Quantity
    			'5.00', // Item Unit Price
    			'N' // Item taxable
    	);
    	
    	$sale->setCustomFields(array("coupon_code" => "SAVE2011", "description" => "Test Item from LXC"));
    	
    	$customer = (object)array();
    	$customer->first_name = "Jane";
    	$customer->last_name = "Smith";
    	$customer->company = "Jane Smith Enterprises Inc.";
    	$customer->address = "20 Main Street";
    	$customer->city = "San Francisco";
    	$customer->state = "CA";
    	$customer->zip = "94110";
    	$customer->country = "US";
    	$customer->phone = "415-555-5557";
    	$customer->fax = "415-555-5556";
    	$customer->email = "foo@example.com";
    	$customer->cust_id = "55";
    	$customer->customer_ip = "98.5.5.5";
    	$sale->setFields($customer);
    	
    	$sale->setSandbox(true);
    	
    	$response = $sale->authorizeAndCapture();
    	//$response = $sale->authorizeOnly();
    	//$response = $sale->priorAuthCapture(2235694527, 267.00);
    	//$response = $sale->captureOnly('QXW97X', 250.00, '4007000000027', '0418'); // params: authorization code, amount, last 4 of cc, exp. date
    	//$response = $sale->void(2235695034);
    	$this->functions->dump($response->response_code); //$response->response_reason_text, $response->response_reason_code, $response->response_code
		
		$body['response'] = $response;
    	$this->load->view('template/header', $header);
        $this->load->view('test/aim', $body);
        $this->load->view('template/footer');
    }
    
    
    
    public function notifications(){
    	$to_user_id = 302; //Mike Romano | nicolino101@gmail.com
    	$notification = 'Thank you for registering with LegacyXChange.com. This is your account area. Here you can add products, listings, update personal info. and more.';
                    
        $this->notifications->fromSystem($this->session->userdata['user_id'], $notification, $subject = 'Welcome to LegacyXChange.com', $importance_level = 1, $addEmail = TRUE);
    }
    
    public function email($to_user_id = 220, $from_user_id = 0, $subject = null, $notification = null){
    	
    	//$this->notifications->fromSystem($to_user_id, 'Testing the email System.');
    	
    	$this->notifications->fromUser($to_user_id, 154, 'Testing the email System.');
    	
    	exit;
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
    	if (! empty ( $_POST )) {
			$iStr = $this->_sphinx ();
			if($iStr){
				$cid = ! empty ( $_POST ['category_id'] ) ? $_POST ['category_id'] : null;
				$ptid = ! empty ( $_POST ['product_type_id'] ) ? $_POST ['product_type_id'] : null;
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
			
				if (! is_null ( $ptid )) {
					$sql .= ' and product_type_id = ' . $ptid ;
				}
				//echo $sql; exit;
				$query = $this->db->query($sql);
			
				$body['results'] = $query->result();
    		}
		}else{
			//
		}
    	
    	$this->load->view('template/header', $header);
    	$this->load->view('test/sphinx', $body);
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