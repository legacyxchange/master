<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends CI_Controller {

    function Products() {
    	
        parent::__construct();

        $this->load->driver('cache');

        $this->load->model('user_model', 'user', true);
        
        $this->load->model('product_images_model', 'product_images', true);
        
        $this->load->model('product_videos_model', 'product_videos', true);
        
        $this->load->model('products_model', 'products', true);
        
        $this->load->model('product_types_model', 'product_types', true);
        
        $this->load->model('categories_model', 'categories', true);
        
        $this->load->model('product_condition_types_model', 'product_condition_types', true);
        
        $this->load->model('product_categories_model', 'product_categories', true);
        
        $this->load->model('bidding_model', 'bidding', true);
        
        $this->load->model('user_accounts_model', 'user_accounts', true);
        
        $this->load->model('advertisements_model', 'advertisements', true);
        
        $this->load->model('user_accounts_model', 'user_accounts', true);
        
        $this->load->model('listings_model', 'listings', true);
        
        $this->load->model('listing_types_model', 'listing_types', true);
        
        $this->load->model('payment_types_model', 'payment_types', true);
        
        $this->load->model('shipping_model', 'shipping', true);
        
        $this->load->model('shipping_types_model', 'shipping_types', true);
        
        $this->load->model('shipping_carriers_model', 'shipping_carriers', true);
        
        $this->load->model('product_validator_model', 'product_validator', true);
        
        $this->load->library('library');
        
        $this->functions->checkLoggedIn();
    }
    
    public function indexNEW($sortby = 'Drafts'){
    	$body['user_id'] = $user_id = $this->session->userdata('user_id');
    	if(is_numeric($sortby)){
    		$product_id = $sortby;
    	}elseif($sortby == 'add'){
    		$product_id == null;
    		$sortby = 'Drafts';
    		$add = true;
    	}
    	
    	//$sortby = product_type
    	$data['products'] = $products = $this->products->getProductsByUserId($user_id, $sortby);
    	$product_id = is_null($product_id) ? $products[0]->product_id : $product_id;
    	 
    	$data['productListingObject'] = $productListingObject = $this->products->getProductListingObject($product_id);
    	$this->functions->dump($data);
    }

    public function index($sortby = 'Drafts'){
    	if(is_numeric($sortby)){
    		$product_id = $sortby;
    	}elseif($sortby == 'add'){
    		$product_id == null;
    		$sortby = 'Drafts';
    		$add = true;
    	}
    	
    	$body['user_id'] = $user_id = $this->session->userdata('user_id'); 
        
        $body['sortby'] = $sortby = !empty($_POST['sortby']) ? $_POST['sortby'] : $sortby;
        
        $listings_count = 0;
        if(is_null($product_id)){ 
        	try { 
        		if($sortby == 'Drafts'){
        			$query = $this->db->query('select * from products left join listings using(product_id) where user_id = '.$this->session->userdata['user_id']);        			
        			$listings_count = 0;
        		}
        		elseif($sortby == 'Listed'){
        			$query = $this->db->query('select * from products join listings using(product_id) where user_id = '.$this->session->userdata['user_id']);        			
        			$listings_count = $query->num_rows();
        		}    
        		elseif($sortby == 'Original Items') {
        			$query = $this->db->query('select * from products left join listings using(product_id) 
        					                   where user_id = '.$this->session->userdata['user_id'].
        									   ' and product_type_id = 1'
        					                 );  
        			$listings_count = $query->num_rows();
        		}
        		elseif($sortby == 'Marketplace Items') {
        			$query = $this->db->query('select * from products left join listings using(product_id) 
        					                   where user_id = '.$this->session->userdata['user_id'].
        									   ' and product_type_id = 2'
        					                 );     
        			$listings_count = $query->num_rows();
        		}  
        		elseif($sortby == 'Legacy X Plus') {
        			$query = $this->db->query('select * from products left join listings using(product_id)
        					                   where user_id = '.$this->session->userdata['user_id'].
        					' and product_type_id = 3'
        			);
        			$listings_count = $query->num_rows();
        		} 
        		$products = $query->result();	
        		$body['listings_count'] = $listings_count;
        	} catch (Exception $e) {
        		$this->functions->sendStackTrace($e);
        	}
        }else{
        	$this->products->getProductListingObject($product_id); exit;
        	$query = $this->db->query('select * from products left join listings using(product_id)
        					                   where user_id = '.$this->session->userdata['user_id'].' and products.product_id = '.$product_id
        	);      	
        }
        $body = $this->getGeneralData($product_id);
        array_push($body, $this->getSingleProductData($product_id));
        
        foreach($products as $product){        	
        	$query = $this->db->query('select listings.*, max(bidding.bid_amount) as bid_amount from listings join listing_types using(listing_type_id) join bidding using(listing_id) where listings.product_id = '.$product->product_id);
        	$product->listing = $query->result()[0];
            
        	$product->reserve_price = $query->result()[0]->reserve_price;
        	$bid = $query->result()[0]->bid_amount; 
        	if($bid > $current_bid){
        		$current_bid = $bid;
        	}
        	$product->listing_id = $query->result()[0]->listing_id;
        	$product->current_bid = $current_bid;
        	
        	$product->expires = $query->result()[0]->end_time;
        	        	
        	$product_types = $this->product_types->fetchAll(array('where' => 'product_type_id = '.$product->product_type_id));
        	foreach($product_types as $type){        		
        		$product->product_type = $type->type; 
        	}
        	$prods []= $product;         	
        }
        //var_dump($prods); exit;
        $body['product'] = $add == true ? null : $prods[0];
        $body['products'] = $prods;
        $menu['menu_products'] = 1;
        $body['admin_menu'] = $this->load->view('admin/ecommerce/template/menu', $menu, true);
        $this->layout->load('admin/ecommerce/products', $body, 'ecommerce');
    }
    
    public function save() {
    	
    		if(!empty($_POST['product_id'])){
    			
    			return $this->edit($_POST['product_id']);
    		}else{
    			return $this->add();
    		}
    	
    	exit;
    }
    
    public function add() { 	
    	$data = $this->getGeneralData();
    	
    	try {
    		$_POST['user_id'] = $this->session->userdata['user_id'];
    		if($_POST['product_type_id'] == ''){
    			$_POST['product_type_id'] = 2;
    		}
    		//var_dump($_POST); exit;
    		$product_id = $_POST['product_id'] = $this->products->save();
    			
    		if(!empty($_POST['end_time'])){
    			$this->listings->save();
    			//$this->shipping->save();
    		}
    			
    		if(!empty($_POST['cid'])){ 
    			$this->product_categories->delete('product_id', $product_id);   				    				    				   				
    			foreach($_POST['cid'] as $cid){
    				$_POST['category_id'] = $cid;
    				$this->product_categories->save();
    			}
    		}
    			
    		if(!empty($_FILES)){      	
    			
    			foreach($_FILES as $key => $file){ 
    				
    				if(!empty($file['name'])){
    					$active_key = $key;
    					$ext = explode('.', $file['name']);   						
    				}else{    						
    					unset($_FILES[$key]);
    				}
    			}
    				
    			if(!is_null($product_id) && !empty($_FILES)){ 
    				if(in_array(strtolower($ext[1]), array('jpg', 'jpeg', 'gif', 'png'))){
    					$details = $this->uploadimage($product_id, $active_key);
    					//var_dump($product_id, $_FILES, $details); exit;
    					$_POST['product_id'] = $product_id;
    					$_POST['image'] = $details['file_name'];
    					$_POST['quantity'] = !empty($_POST['quantity']) ? $_POST['quantity'] : 1;
    					$this->products->save();
    				}else{
    					$details = $this->uploadvideo($product_id, $active_key);
    					//var_dump($details); exit; 
    					$_POST['product_id'] = $product_id;
    					$_POST['product_video'] = $details['file_name'];
    					//$_POST['order_index'] = $_POST['order_index'] == 0 ? '0' : $_POST['order_index'];
    					//var_dump($_POST, $_FILES, $details); exit;
    					$this->product_videos->save();
    					$_POST['amount'] = -2; // subtract $2 from balance
    					$this->user_accounts->save();
    				}
    				//var_dump($_POST, $_FILES, $details); exit;
    				$this->session->set_flashdata('SUCCESS', 'Your info has been updated!');
    					
    				header('Location: /ecommerce/products/edit/'.$product_id); exit;
    			}    				
    		}
    			
    		$this->session->set_flashdata('SUCCESS', 'Your info has been updated!');
    			
    		header('Location: /ecommerce/products'); exit;
    
    	} catch (Exception $e) {    			
    		$this->session->set_flashdata('FAILURE', $e->getMessage());
    		header('Location: /ecommerce/products'); exit;
    	}
    	
    	$menu['menu_products'] = 1;
        $data['admin_menu'] = $this->load->view('ecommerce/menu', $menu, true);
        
        $this->layout->load('/ecommerce/products/', $data, 'ecommerce');
    }
    
    public function edit($product_id = null) {     	
    	
    	$data['product_id'] = $product_id = is_null($product_id) ? $_POST['product_id'] : $product_id;
    	
    	$data = $this->getSingleProductData($product_id);
    	
    	if(!empty($_POST)){	
    		
    		try {
    			$_POST['user_id'] = $this->session->userdata['user_id'];
    			//var_dump($_POST); exit;	
    			$this->products->save();
    			
    			if(!empty($_POST['cid'])){ 
    				$this->product_categories->delete('product_id', $product_id);   				    				    				   				
    				foreach($_POST['cid'] as $cid){
    					$_POST['category_id'] = $cid;
    					$this->product_categories->save();
    				}
    			}
    			
    			if(!empty($_FILES)){    				
    				foreach($_FILES as $key => $file){ 
    					if(!empty($file['name'])){
    						$active_key = $key;
    						$ext = explode('.', $file['name']);   						
    					}else{    						
    						unset($_FILES[$key]);
    					}
    				}
    				
    				if(!is_null($product_id) && !empty($_FILES)){
    					if(in_array($ext[1], array('jpg', 'jpeg', 'gif', 'png'))){
    						$details = $this->uploadimage($product_id, $active_key);
    						$_POST['product_id'] = $product_id;
    						$_POST['product_image'] = $details['file_name'];
    						$_POST['order_index'] = $_POST['order_index'] == 0 ? '0' : $_POST['order_index'];
    						//var_dump($_POST, $_FILES, $details); exit;
    						$this->products->save();
    					}else{
    						$details = $this->uploadvideo($product_id, $active_key); 
    						$_POST['product_id'] = $product_id;
    						$_POST['product_video'] = $details['file_name'];
    						//$_POST['order_index'] = $_POST['order_index'] == 0 ? '0' : $_POST['order_index'];
    						//var_dump($_POST, $_FILES, $details); exit;
    						$this->product_videos->save();
    						$_POST['amount'] = -2; // subtract $2 from balance
    						$this->user_accounts->save();
    					}
    					 					   				    					
    					$this->session->set_flashdata('SUCCESS', 'Your info has been updated!');
    					
    					header('Location: /ecommerce/products/edit/'.$product_id); exit;
    				}    				
    			}
    			
    			$this->session->set_flashdata('SUCCESS', 'Your info has been updated!');
    			
    			header('Location: /ecommerce/products/edit/'.$product_id); exit;
    
    	    } catch (Exception $e) {    			
    			$this->session->set_flashdata('FAILURE', $e->getMessage());
    			header('Location: /ecommerce/products/'); exit;
    		}
    	} 
    	if(!is_null($product_id))
        	$data['product'] = $this->products->fetchAll(array('where' => 'product_id = '.$product_id))[0];
    	
    	$data['admin_menu'] = $this->load->view('/ecommerce/template/menu', $menu, true);
    	
    	$this->layout->load('admin/ecommerce/products', $data, 'ecommerce');
    }
    
    public function delete($product_id){
    	
    	$this->products->delete('product_id', $product_id);
    	 
    	$this->session->set_flashdata('SUCCESS', 'Your data has been updated.');
    	echo 'SUCCESS'; exit;
    }
    
    public function checkFunds(){
    	$user_account = $this->user_accounts->fetchAll(array('where' => 'user_id = '.$this->session->userdata['user_id']))[0];
    	if(!is_null($user_account)){
    		echo json_encode(array('status' => 'SUCCESS', 'balance' => $user_account->balance)); exit;
    	}else{
    		$balance = is_null($user_account->balance) ? 0 : $user_account->balance;
    		 
    		echo json_encode(array('status' => 'FAILURE', 'balance' => $balance)); exit;
    	}
    	var_dump($this->db->last_query(), $user_account); exit;
    }
    
    private function getSingleProductData($product_id){
    	if(!is_null($product_id) && $product_id != ''){
    		$data['product'] = $product =  $this->products->fetchAll(array('where' => 'product_id = '.$product_id))[0];
    		$data['product_categories'] = $this->product_categories->fetchAll(array('where' => 'product_id = '.$product_id, 'join' => array('categories', 'product_category_id')));
    		foreach($data['product_categories'] as $key=>$val){
    			$data['pCatArray'][] = $val->category_id;
    		}
    		$data['product_images'] = $product_images = $this->product_images->fetchAll(array('where' => 'product_id ='.$product_id, 'orderby' => 'order_index'));
    		$data['product_videos'] = $product_videos = $this->product_videos->fetchAll(array('where' => 'product_id ='.$product_id));
    		$data['listings'] = $listings = $this->listings->fetchAll(array('where' => 'product_id = '.$product_id))[0];
    	    return $data;
    	}
    }
    
    private function getGeneralData($product_id = null){
    	$data['user_id'] = $this->session->userdata['user_id'];
    	
    	$data['user_account'] = $this->user_accounts->fetchAll(array('where' => 'user_id = '.$this->session->userdata['user_id']))[0];
    	
    	$data['categories'] = $categories = $this->categories->fetchAll(array('orderby' => 'category_id'));
    	    	
    	$data['product_condition_types'] = $this->product_condition_types->fetchAll();
    	
    	$data['product_types'] = $product_types = $this->product_types->fetchAll();
    	
    	$data['listing_types'] = $this->listing_types->fetchAll();  
    	
    	$data['payment_types'] = $this->payment_types->fetchAll();
    	$data['shipping_types'] = $this->shipping_types->fetchAll();
    	return $data;
    }
    
    public function checkoriginalpasscode($passcode = null){
    	var_dump($passcode); exit;
    	$product = $this->products->fetchAll(array('where' => 'original_passcode = '.$passcode))[0];
    	//check db for passcode and return json_encode(array('status'=>'SUCCESS', 'message'=>'Pass is good'));
    	// else return json_encode(array('status'=>'FAILURE', 'message'=>'IF YOU WERE NOT ISSUED A PASSCODE FOR ORIGINAL ITEMS YOU MUST LIST IN THE MARKETPLACE SECTION. IF YOU CANNOT REMEMBER YOUR PASSCODE PLEASE CONTACT CUSTOMER SERVICE AT 1-800-123-4567. <br /><div class="btn btn-silver" onclick="$('#firstSaleOption').hide();">OK</div>'));
    }
    
    public function checklegacynumber($ln = null){
    	var_dump($ln); exit;
    	$product = $this->products->fetchAll(array('where' => 'legacy_number = '.$ln))[0];
    	//check db for passcode and return json_encode(array('status'=>'SUCCESS', 'message'=>'Pass is good'));
    	// else return json_encode(array('status'=>'FAILURE', 'message'=>'IF YOU WERE NOT ISSUED A PASSCODE FOR ORIGINAL ITEMS YOU MUST LIST IN THE MARKETPLACE SECTION. IF YOU CANNOT REMEMBER YOUR PASSCODE PLEASE CONTACT CUSTOMER SERVICE AT 1-800-123-4567. <br /><div class="btn btn-silver" onclick="$('#firstSaleOption').hide();">OK</div>'));
    }
    
    public function uploadvideo($product_id, $filename) {
    	if ($_FILES) {
    		try {
    			$path = 'public' . DS . 'uploads' . DS . 'products' . DS . $product_id . DS;
    
    			$this->functions->createDir($path);
    
    			$config['upload_path'] = './' . $path;
    			$config['allowed_types'] = "*";
    			$config['max_size'] = "1999000M";
    			 
    			$config['encrypt_name'] = true;
    
    			$this->load->library('upload', $config);
    			 
    			if (!$this->upload->do_upload($filename)) {
    				throw new Exception("Unable to upload video!" . $this->upload->display_errors());  exit;
    			}
    			 
    			return $uploadData = $this->upload->data();
    		} catch (Exception $e) {
    			$this->session->set_flashdata('FAILURE', 'Sorry...Unable to upload your video at this time.');
    			header("Location: /ecommerce/products");
    			exit;
    		}
    		$this->session->set_flashdata('SUCCESS', 'You successfully uploaded your new video!');
    		header("Location: /ecommerce/products");
    		exit;
    	}
    }
    
    public function uploadimage($product_id, $filename) {
    	
    	if ($_FILES) {
    		try {
    			$path = 'public' . DS . 'uploads' . DS . 'products' . DS . $product_id . DS;
    
    			$this->functions->createDir($path);
    
    			$config['upload_path'] = './' . $path;
    			$config['allowed_types'] = "gif|jpg|png";
    			$config['max_size'] = "5120";
    			$config['encrypt_name'] = true;
    
    			$this->load->library('upload', $config);
    			 
    			if (!$this->upload->do_upload($filename)) {
    				throw new Exception("Unable to upload image!" . $this->upload->display_errors());
    			}
    			
    			return $uploadData = $this->upload->data();
    		} catch (Exception $e) { 
    			$this->session->set_flashdata('FAILURE', 'Sorry...Unable to upload your image at this time.');
    			header("Location: /ecommerce/products");
    			exit;
    		}
    		
    		$this->session->set_flashdata('SUCCESS', 'You successfully uploaded your new image!');
    		header("Location: /ecommerce/products");
    		exit;
    	}
    }
}