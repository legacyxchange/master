<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Advertisements extends CI_Controller {

    function Advertisements() {
    	
        parent::__construct();
        
        $this->load->driver('cache');

        $this->load->model('user_model', 'user', true);
        
        $this->load->model('advertisements_model', 'advertisement', true);
        
        $this->load->model('products_model', 'product', true);
        
        $this->load->model('product_types_model', 'product_type', true);
        
        $this->load->model('listings_model', 'listing', true);
        
        $this->load->model('user_accounts_model', 'user_accounts', true);
        
        $this->load->model('advertisements_model', 'advertisements', true);
        
        $this->load->library('library');
    }

    public function index(listing_$id = null) { 
    	$this->functions->checkLoggedIn();
        
        $body['user_id'] = $user_id = $this->session->userdata('user_id'); 
        
        $header['headscript'] = $this->functions->jsScript('advertisements.js');
        
        if(is_null($advertisement_id)){        	
        	try {
        		$advertisements = $this->advertisements->fetchAll(array('where' => 'products.user_id = '.$this->session->userdata['user_id'], 'orderby' => 'advertisement_id DESC'));
        		
        		/* foreach($advertisements as $advertisement){ 
        			$advertisement->product = $this->product->fetchAll(array('where' => 'product_id = '.$listing->product_id))[0];        			
        		} */
        		
        	} catch (Exception $e) {
        		$this->functions->sendStackTrace($e);
        	}
        }else{
        	$advertisements = $this->advertisements->fetchAll('advertisement_id = '.$advertisement_id);        	
        }
        
        $menu['menu_advertisements'] = 1;
        $body['advertisement'] = $advertisements;
        $body['admin_menu'] = $this->load->view('admin/admin_menu', $menu, true);
        $this->load->view('admin/template/header', $header);
        $this->load->view('admin/advertisements', $body);
        $this->load->view('template/footer');
    }
    
    public function add($listing_id = null){ 
    	$body['user_id'] = $user_id = $this->session->userdata['user_id'];
    	$body['user_account'] = $this->user_accounts->fetchAll(array('where' => 'user_id = '.$user_id))[0];
    	
    	if(!empty($_POST)){
    		var_dump($_POST); exit;
    	}
    	if($listing_id){
    		$query = $this->db->query('Select * from listings join products using(product_id) where listing_id = '.$listing_id);
    		$listings = $query->result()[0];    		
    		$body['listings'] = $listings;
    	}
    	
    	$body['admin_menu'] = $this->load->view('admin/admin_menu', $menu, true);
        $this->load->view('admin/template/header', $header);
        $this->load->view('admin/advertisements', $body);
        $this->load->view('template/footer');
    }
    
    public function edit($advertisement_id = null){
    	$body['user_id'] = $user_id = $this->session->userdata['user_id'];
    	$body['user_account'] = $this->user_accounts->fetchAll(array('where' => 'user_id = '.$user_id))[0];
    	if(!empty($_POST)){
    		var_dump($_POST); exit;
    	}
    	if($advertisement_id){
    		$body['advertisement_id'] = $advertisement_id;
    		$body['advertisement'] = $this->advertisements->fetchAll(array('where' => 'advertisement_id = '.$advertisement_id))[0];    		
    	}
    	 
    	$body['admin_menu'] = $this->load->view('admin/admin_menu', $menu, true);
    	$this->load->view('admin/template/header', $header);
    	$this->load->view('admin/edit_advertisements', $body);
    	$this->load->view('template/footer');
    }
    
    public function save() {  
    	$body['user_id'] = $user_id = $this->session->userdata['user_id'];  
    	if (!empty($_POST)) { 		
    		try { 
    			var_dump($_POST); exit;
    			$advertisement_id = !empty($_POST['advertisement_id']) ? $_POST['advertisement_id'] : null;
    			if(!is_null($advertisement_id)){   				
    				$this->advertisements->save('advertisement_id = '.$_POST['advertisement_id']);
    			}else{
    				$this->advertisements->save();
    			}
    			// update user account balance
    			$user_account = $this->user_accounts->fetchAll(array('where' => 'user_id = '.$user_id))[0];
    			$_POST['balance'] = $user_account->balance - (float)$_POST['ad_total_amount'];
    			$_POST['user_account_id'] = $user_account->user_account_id;
    			$this->user_accounts->save();
    			
    			$this->session->set_flashdata('SUCCESS', 'Your new Advertisement has been added!');
    
    			header('Location: /admin/products'); exit; 
    		   
    	    } catch (Exception $e) {
    			$this->functions->sendStackTrace($e);
    
    			$this->session->set_flashdata('FAILURE', $e->getMessage());
    			header('Location: /admin/products'); exit;
    		}
    	}
    	return $this->index();
    }
    
    public function delete($listing_id){
    	if ($this->session->userdata('logged_in') == false){
    		header('Location: /'); exit;
    	}
    	 
    	$this->listing->delete('listing_id', $listing_id);
    	 
    	$this->session->set_flashdata('SUCCESS', 'Your listing has been deleted.');
    	
    	header('Location: /admin/listings'); exit;
    }
    
    public function listingsform($listing_id = null){    	
    	$out = null;
    	
    	if(!is_null($listing_id)){
    		
    		$listings = $this->listing->fetchAll(array('where' => 'listing_id = '.$listing_id, 'orderby' => 'listing_id DESC'));
    	    
    		foreach($listings as $r){ 
    			$out .= '
    			<div class="modal-header">
                <h3 class="modal-title">'.html_entity_decode($r->listing_name).'</h3>
                </div> <!-- modal-header -->
                <div class="modal-body">
    			';
    			$out .= '<div role="form">';    	        
    			$out .= form_open_multipart('/admin/listings/edit/'.$r->listing_id);    			
        		$out .= form_hidden('listing_id', $r->listing_id);
        		$out .= form_hidden('user_id', $r->user_id);        		
        		$out .= '<div class="form-group">';
        		$out .= '<label for="product_id">Product</label><br />';
        		$out .= '<select name="product_id">';    		
        		$products = $this->product->fetchAll(array('where' => 'user_id = '.$this->session->userdata['user_id']));
    		    foreach($products as $product){      			
        			if($product->product_id == $r->product_id) {  
        				$out .= '<option selected value="'.$product->product_id.'">'.html_entity_decode($product->name).'</option>';
        			}else{
        				$out .= '<option value="'.$product->product_id.'">'.$product->name.'</option>';
        			}        			
        		}
        		$out .= '</select>';      		
        		$out .= '</div>';       		
    			$out .= '<div class="form-group">';
    			$out .= '<label for="listing_name">Listing Name</label><br />';
    			$ln = html_entity_decode($r->listing_name); 
    			
    			$out .= form_input(array('style' => 'width:80%;', 'name' => 'listing_name', 'placeholder' => 'Listing Name', 'value' => 'etset\'s'));
    			$out .= '</div>';   	 	
    			$out .= '<div class="form-group">';
    			$out .= '<label for="start_date">Start Date</label>  <label for="start_time">Start Time</label><br />';
    			$out .= form_input(array('type' => 'date', 'min' => date('Y-m-d'), 'name' => 'start_date', 'placeholder' => 'Start Time', 'value' => date('Y-m-d', strtotime($r->start_time))));
    			$out .= form_input(array('type' => 'time', 'name' => 'start_time', 'placeholder' => 'Start Time', 'value' => date('H:i:s', strtotime($r->start_time))));
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			$out .= '<label for="end_date">End Date</label>  <label for="end_time">End Time</label><br />';
    			$out .= form_input(array('type' => 'date', 'min' => date('Y-m-d'), 'name' => 'end_date', 'placeholder' => 'End Time', 'value' => date('Y-m-d', strtotime($r->end_time))));
    			$out .= form_input(array('type' => 'time', 'name' => 'end_time', 'placeholder' => 'Start Time', 'value' => date('H:i:s', strtotime($r->end_time))));
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			$out .= '<label for="buynow_price">Buy Now Price</label><br />';
    			$out .= '$'.form_input(array('name' => 'buynow_price', 'placeholder' => 'Buy Now Price', 'value' => number_format($r->buynow_price, 2)));
    			$out .= '</div>';                     			                    						
    			$out .= '<div class="form-group">';
    			$out .= '<label for="reserve_price">Reserve Price</label><br />';
    			$out .= '$'.form_input(array('name' => 'reserve_price', 'placeholder' => 'Reserve Price', 'value' => number_format($r->reserve_price, 2)));
    			$out .= '</div>'; 
    			$out .= '<div class="form-group">';
    			$out .= '<label for="advertise">Advertise this listing?</label><br />';
    			$out .= '$'.form_input(array('type' => 'checkbox', 'name' => 'advertise', 'placeholder' => 'Advertise this listing', 'value' => ''));
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			$out .= form_submit(array('name' => 'submit', 'value' => 'Save', 'class' => 'sign_save'));
    			$out .= '</div>';
    			$out .= '</form>';
    			$out .= '</div>';		
    		}   
    	} else {
    		
    		$out = '
    			<div class="modal-header">
                <h3 class="modal-title">Add Listing</h3>
                </div> <!-- modal-header -->
                <div class="modal-body">
    	    ';
    		$out .= '<div role="form">';    	        
    			$out .= form_open_multipart('/admin/listings/add');    			
        		$out .= form_hidden('listing_id', $r->listing_id);
        		$out .= form_hidden('user_id', $this->session->userdata['user_id']);        		
        		$out .= '<div class="form-group">';
        		$out .= '<label for="product_id">Product</label><br />';
        		$out .= '<select name="product_id">';    		
        		$products = $this->product->fetchAll(array('where' => 'user_id = '.$this->session->userdata['user_id']));
    		    foreach($products as $product){      			
        			if($product->product_id == $r->product_id) {  
        				$out .= '<option selected value="'.$product->product_id.'">'.$product->name.'</option>';
        			}else{
        				$out .= '<option value="'.$product->product_id.'">'.$product->name.'</option>';
        			}        			
        		}
        		$out .= '</select>';      		
        		$out .= '</div>';       		
    			$out .= '<div class="form-group">';
    			$out .= '<label for="listing_name">Listing Name</label><br />';
    			$out .= form_input(array('name' => 'listing_name', 'placeholder' => 'Listing Name', 'value' => html_entity_decode($r->listing_name)));
    			$out .= '</div>';   	
    			$out .= '<div class="form-group">';
    			$out .= '<label for="start_date">Start Date</label>  <label for="start_time">Start Time</label><br />';
    			$out .= form_input(array('type' => 'date', 'min' => date('Y-m-d'), 'name' => 'start_date', 'placeholder' => 'Start Time'));
    			$out .= form_input(array('type' => 'time', 'name' => 'start_time', 'placeholder' => 'Start Time'));
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			$out .= '<label for="end_date">End Date</label>  <label for="end_time">End Time</label><br />';
    			$out .= form_input(array('type' => 'date', 'min' => date('Y-m-d'), 'name' => 'end_date', 'placeholder' => 'End Time'));   		
    			$out .= form_input(array('type' => 'time', 'name' => 'end_time', 'placeholder' => 'Start Time'));
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			$out .= '<label for="buynow_price">Buy Now Price</label><br />';
    			$out .= form_input(array('name' => 'buynow_price', 'placeholder' => 'Buy Now Price', 'value' => $r->buynow_price));
    			$out .= '</div>';                     			                    						
    			$out .= '<div class="form-group">';
    			$out .= '<label for="reserve_price">Reserve Price</label><br />';
    			$out .= form_input(array('name' => 'reserve_price', 'placeholder' => 'Reserve Price', 'value' => $r->reserve_price));
    			$out .= '</div>'; 
    			$out .= '<div class="form-group">';
    			$out .= '<label for="advertise">Advertise this listing?</label><br />';
    			$out .= '$'.form_input(array('type' => 'checkbox', 'name' => 'advertise', 'placeholder' => 'Advertise this listing', 'value' => ''));
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			$out .= form_submit(array('name' => 'submit', 'value' => 'Save', 'class' => 'sign_save'));
    			$out .= '</div>';
    			$out .= '</form>';
    			$out .= '</div>';
    	} 
        echo $out; exit;
    }
}