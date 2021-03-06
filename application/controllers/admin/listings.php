<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Listings extends CI_Controller {

    function Listings() {
    	
        parent::__construct();
        
        $this->load->driver('cache');

        $this->load->model('user_model', 'user', true);
        
        $this->load->model('profile_model', 'profile', true);
        
        $this->load->model('products_model', 'product', true);
        
        $this->load->model('product_types_model', 'product_type', true);
        
        $this->load->model('listings_model', 'listings', true);
        
        $this->load->model('listing_types_model', 'listing_types', true);
    }

    public function index($listing_id = null) { 
    	$this->functions->checkLoggedIn();
        
        $body['user_id'] = $user_id = $this->session->userdata('user_id'); 
        
        //$header['headscript'] = $this->functions->jsScript('listings.js');
        $body['listing_types'] = $this->listing_types->fetchAll();
        if(is_null($listing_id)){     	
        	try {
        		$listings = $this->listings->fetchAll();
        		
        		foreach($listings as $listing){ 
        			$listing->product = $this->product->fetchAll(array('where' => 'product_id = '.$listing->product_id))[0]; 
        			$listing->type = $this->listing_types->fetchAll(array('where' => 'listing_type_id = '.$listing->listing_type_id))[0];
        		}
        		
        	} catch (Exception $e) {
        		$this->functions->sendStackTrace($e);
        	}
        }else{
        	$listings = $this->listings->fetchAll(array('where' => 'listing_id = '.$listing_id));   
        	foreach($listings as $listing){
        		$listing->product = $this->product->fetchAll(array('where' => 'product_id = '.$listing->product_id))[0];
        	}    	
        }
        
        $menu['menu_listings'] = 1;
        $body['listings'] = $listings;
        $body['admin_menu'] = $this->load->view('admin/admin_menu', $menu, true);
        $this->layout->load('admin/listings/edit', $body, 'admin');
    }
    
    public function add() {   
    	
    	if (!empty($_POST)) {   		
    		try { 
    			$this->listing->setPostStartAndEndTimes();
    			  	
    			$listing_id = $this->listing->save(); 

    			$this->session->set_flashdata('SUCCESS', 'Your new listing has been added!');
    
    			header('Location: /admin/listings'); exit; 
    		   
    	    } catch (Exception $e) {
    			$this->functions->sendStackTrace($e);
    
    			$this->session->set_flashdata('FAILURE', $e->getMessage());
    		}
    	}else{
    		
    	}
    	return $this->index();
    }
    
    public function edit($listing_id) {
    	if(!$listing_id)
    		header('Location: /admin/products');
    
    	$listing = $this->listings->fetchAll(array('listing_id = '.$listing_id))[0];
    	$lt = $this->listing_types->fetchAll(array('listing_type_id = '.$listing->listing_type_id))[0];
    	$listing->type = $lt->listing_type;
    	
    	$body['listing_types'] = $this->listing_types->fetchAll();
    	
    	$body['user_id'] = $this->session->userdata['user_id'];
    	
    	if (!empty($_POST)) {   		
    		try {
    			$this->listings->setPostStartAndEndTimes();
    			
    			$where = 'listing_id = "'.$listing_id.'"';
    			 
    			$this->listings->save($where);
    
    			$this->session->set_flashdata('SUCCESS', 'Your listing has been updated!');
    
    			header('Location: /admin/listings/edit/'.$listing_id); exit;
    
    		} catch (Exception $e) {
    			$this->functions->sendStackTrace($e);
    
    			$this->session->set_flashdata('FAILURE', $e->getMessage());
    		}
    	}  
    	$menu['menu_listings'] = 1;
    	$body['listing'] = $listing;
    	$body['admin_menu'] = $this->load->view('admin/admin_menu', $menu, true);
    	$this->layout->load('admin/listings/edit', $body, 'admin');
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