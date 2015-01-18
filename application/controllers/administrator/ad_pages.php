<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ad_pages extends CI_Controller {

    function Ad_pages() {
    	
        parent::__construct();

        $this->load->driver('cache');

        $this->load->model('user_model', 'user', true);
        
        $this->load->model('ad_pages_model', 'ad_pages', true);
        
        $this->load->library('library');
        
        $this->load->library('pagination');
        
        $this->functions->checkSudoLoggedin();
    }

    public function index($ad_pages_id = null) {
    	$body['user_id'] = $user_id = $this->session->userdata('user_id'); 
        
        $header['headscript'] = $this->functions->jsScript('ad_pages.js');
        
        if(is_null($ad_pages_id)){        	
        	try {
        		$pagination_config['base_url'] = '/administrator/ad_pages/index//'.$page;
        		$pagination_config['total_rows'] = $this->ad_pages->countAll();
        		$pagination_config['per_page'] = 5;
        		$pagination_config['cur_page'] = $page;
        		$pagination_config['use_page_numbers'] = TRUE;
        		$this->pagination->initialize($pagination_config);
        		$ad_pages = $this->ad_pages->fetchAll(array('orderby' => 'ad_pages_id DESC', 'limit' => $pagination_config['per_page'], 'offset' => $page)); 
        		
        		//foreach($listings as $listing){ 
        		//	$listing->product = $this->product->fetchAll(array('where' => 'product_id = '.$listing->product_id))[0];        			
        		//}
        		
        	} catch (Exception $e) {
        		$this->functions->sendStackTrace($e);
        	}
        }else{
        	$ad_pages = $this->ad_pages->fetchAll(array('where' => 'ad_pages_id = '.$ad_pages_id));        	
        }
        
        var_dump($ad_pages); exit;
        $body['ad_pages'] = $ad_pages;
        $body['admin_menu'] = $this->load->view('admin/admin_menu', null, true);
        $this->load->view('administrator/template/header', $header);
        $this->load->view('administrator/ad_pages', $body);
        $this->load->view('template/footer');
    }
    
    public function add() {   
    	if(!$listing_id)
    		header('Location: /admin/dashboard');
    	
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
    	}
    	return $this->index();
    }
    
    public function edit($listing_id) {
    	if(!$listing_id)
    		header('Location: /admin/dashboard');
    
    	$body['user_id'] = $this->session->userdata['user_id'];
    	
    	if (!empty($_POST)) {   		
    		try {
    			
    			$this->listings->setPostStartAndEndTimes();
    			
    			$where = 'listing_id = "'.$listing_id.'"';
    			 
    			$this->listings->save($where);
    
    			$this->session->set_flashdata('SUCCESS', 'Your listing has been updated!');
    
    			header('Location: /admin/listings'); exit;
    
    		} catch (Exception $e) {
    			$this->functions->sendStackTrace($e);
    
    			$this->session->set_flashdata('FAILURE', $e->getMessage());
    		}
    	}      	
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
                <h3 class="modal-title">'.$r->listing_name.'</h3>
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
        				$out .= '<option selected value="'.$product->product_id.'">'.$product->name.'</option>';
        			}else{
        				$out .= '<option value="'.$product->product_id.'">'.$product->name.'</option>';
        			}        			
        		}
        		$out .= '</select>';      		
        		$out .= '</div>';       		
    			$out .= '<div class="form-group">';
    			$out .= '<label for="listing_name">Listing Name</label><br />';
    			$out .= form_input(array('style' => 'width:80%;', 'name' => 'listing_name', 'placeholder' => 'Listing Name', 'value' => $r->listing_name));
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
    			$out .= form_input(array('name' => 'listing_name', 'placeholder' => 'Listing Name', 'value' => $r->listing_name));
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
    			$out .= form_submit(array('name' => 'submit', 'value' => 'Save', 'class' => 'sign_save'));
    			$out .= '</div>';
    			$out .= '</form>';
    			$out .= '</div>';
    	} 
        echo $out; exit;
    }
}