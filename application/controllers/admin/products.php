<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends CI_Controller {

    function Products() {
    	
        parent::__construct();

        $this->load->driver('cache');

        $this->load->model('user_model', 'user', true);
        
        $this->load->model('products_model', 'product', true);
        
        $this->load->model('product_types_model', 'product_type', true);
        
        $this->load->library('library');
        
        $this->functions->checkLoggedIn();
    }

    public function index($product_id = null) {
    	$body['user_id'] = $user_id = $this->session->userdata('user_id'); 
        
        $header['headscript'] = $this->functions->jsScript('products.js');
        
        if(is_null($product_id)){
        	try {
        		$products = $this->product->fetchAll(array('where' => 'user_id = '.$user_id, 'orderby' => 'product_id DESC'));        		               		
        	} catch (Exception $e) {
        		$this->functions->sendStackTrace($e);
        	}
        }else{ 
        	$products = $this->product->fetchAll(array('where' => 'product_id = '.$product_id));        	
        }
        
        foreach($products as $product){        	
        	$types = $this->product_type->fetchAll(array('where' => 'product_type_id = '.$product->product_type_id));
        	foreach($types as $type){
        		$product->product_type = $type->type;
        	}
        	$prods []= $product; 
        }
        
        $body['products'] = $prods;
        $body['admin_menu'] = $this->load->view('admin/admin_menu', null, true);
        $this->load->view('admin/template/header', $header);
        $this->load->view('admin/products', $body);
        $this->load->view('admin/template/footer');
    }
    
    public function add() {    	 
    	if (!empty($_POST)) {
    		$params = $_POST;
    		
    		if($_POST['list-item-now'] != 'on'){
    			unset($_POST['listing_id']);
    			unset($_POST['start_date']);
    			unset($_POST['start_time']);
    			unset($_POST['end_date']);
    			unset($_POST['end_time']);
    			unset($_POST['buynow_price']);
    			unset($_POST['reserve_price']);
    			unset($_POST['list-item-now']);
    			unset($_POST['submit']);
    		}
    		var_dump($_POST); exit;
    		try {
    		
    		$product_id = $this->product->save(); 

    		if(!empty($_FILES['userfile']['name'])){
    			 
    			$ret = $this->doUpload($product_id);
    			if(!empty($ret['file_name'])){
    				$_POST['image'] = $ret['file_name'];
    				$_POST['product_id'] = $product_id;
    				$this->product->save('product_id = '.$product_id);
    			}
    		}
    		
    		$this->session->set_flashdata('SUCCESS', 'Your info has been updated!');
    
    		header('Location: /admin/products'); exit;
    
    	    } catch (Exception $e) {
    			$this->functions->sendStackTrace($e);
    
    			$this->session->set_flashdata('FAILURE', $e->getMessage());
    		}
    	}
    	return $this->index();
    }
    
    public function edit($product_id) { 
    	if(!$product_id)
    		header('Location: /admin/dashboard');
    
    	$body['user_id'] = $this->session->userdata['user_id'];
    	//var_dump($body); exit;
    	if (!empty($_POST)) {
    		$params = $_POST;
    		
            if(!empty($_POST['userfile'])){
            	//var_dump($_POST['userfile']); exit;
            }
    		if(!empty($_FILES['userfile']['name'])){
    			//var_dump($params); exit;
    			//var_dump($_FILES); exit;
    			$ret = $this->doUpload($product_id);
    			//var_dump($ret); exit;
    			if(!empty($ret['file_name'])){
    				$_POST['image'] = $ret['file_name'];
    				$_POST['product_id'] = $product_id;
    				$this->product->save('product_id = '.$product_id);
    			}
    		}
    		
    		try {
    			$where = 'product_id = "'.$product_id.'"';
    			 
    			$this->product->save($where);
    
    			$this->session->set_flashdata('SUCCESS', 'Your info has been updated!');
    
    			header('Location: /admin/products'); exit;
    
    		} catch (Exception $e) {
    			$this->functions->sendStackTrace($e);
    
    			$this->session->set_flashdata('FAILURE', $e->getMessage());
    		}
    	}      	
    }
    
    public function delete($product_id){
    	if ($this->session->userdata('logged_in') == false){
    		header('Location: /'); exit;
    	}
    	 
    	//$this->product->delete('product_id', $product_id);
    	 
    	$this->session->set_flashdata('SUCCESS', 'Your data has been updated.');
    	echo $this->index(); exit;
    }
    
    public function productsform($product_id = null){    	
    	
    	if(!is_null($product_id)){
    		$products = $this->product->fetchAll(array('where' => 'product_id = '.$product_id, 'orderby' => 'product_id DESC'));
    		foreach($products as $r){ 
    			$out .= '
    			<div class="modal-header">                
                <h3 class="modal-title">'.$r->name.'</h3>
                </div> <!-- modal-header -->
                <div class="modal-body">
    			';
    			$out .= '<div role="form">';    	        
    			$out .= form_open_multipart('/admin/products/edit/'.$r->product_id, array('name' => 'product_edit_form', 'id' => 'product_edit_form', 'onSubmit' => 'return products.submitForm();')); 
    			
        		$out .= form_hidden('product_id', $r->product_id);
        		$out .= form_hidden('user_id', $r->user_id);
        		
        		$out .= '<div class="form-group">';
        		$out .= '<label for="product_type_id">Product Type</label><br />';
        		$out .= '<select name="product_type_id">';
        		
        		$alltypes = $this->product_type->fetchAll();
        		$types = $this->product_type->fetchAll(array('where' => 'product_type_id = '.$r->product_type_id));
        		foreach($types as $type){
        			$r->product_type = $type->type;
        		}
        			
        		foreach($alltypes as $atype){ 
        			if($r->product_type == $atype->type) {  
        				$out .= '<option selected value="'.$atype->product_type_id.'">'.$atype->type.'</option>';
        			}else{
        				$out .= '<option value="'.$atype->product_type_id.'">'.$atype->type.'</option>';
        			}
        			
        		}
        		$out .= '</select>';      		
        		$out .= '</div>';       		
    			$out .= '<div class="form-group">';
    			$out .= '<label for="product_name">Product Name</label><br />';
    			$out .= form_input(array('style' => 'width:80%;', 'name' => 'name', 'placeholder' => 'Product Name', 'value' => html_entity_decode($r->name)));
    			$out .= '</div>';   	
    			$out .= '<div class="form-group">';
    			$out .= '<label for="description">Product Description</label><br />';
    			$out .= form_textarea(array('name' => 'description', 'rows' => 5, 'cols' => 40, 'placeholder' => 'Description', 'value' => html_entity_decode($r->description)));
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			$out .= '<label for="short_description">Short Description</label><br />';
    			$out .= form_textarea(array('name' => 'short description', 'rows' => 4, 'cols' => 40, 'placeholder' => 'Short Description', 'value' => html_entity_decode($r->short_description)));
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			$out .= '<label for="cost">Product Cost</label><br />';
    			$out .= '$'.form_input(array('name' => 'cost', 'placeholder' => 'Cost', 'value' => number_format($r->cost,2)));
    			$out .= '</div>';   
    			$out .= '<div class="form-group">';
    			$out .= '<label for="retail_price">Retail Price</label><br />';
    			$out .= '$'.form_input(array('name' => 'retail_price', 'placeholder' => 'Retail Price', 'value' => number_format($r->retail_price,2)));
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			
    			//$out .= form_upload(array('type' => 'file', 'id' => 'file-select', 'style' => 'width:80%;', 'name' => 'name', 'placeholder' => 'Image', 'value' => ''));
    			$out .= '<input type="file" id="userfile" name="userfile" size="20" onSubmit="return products.submitForm();"/>'; 
    			
    		    $out .= 'Current Image: <img src="/products/productimg/100/'.$product_id.'/'.$r->image.'" />';
    			
    			$out .= '</div>';   							
    			//$out .= '<input type="button" class="sign_cancel" value="Cancel" />';
    			$out .= form_submit(array('name' => 'submit', 'value' => 'Save', 'class' => 'sign_save'));
    			$out .= '</form>';
    			$out .= '</div>';
    		}   
    	} else {
    		$out = '
    			<div class="modal-header">                
                <h3 class="modal-title">Add Product</h3>
                </div> <!-- modal-header -->
                <div class="modal-body">
    	    ';
    		$out .= '<div role="form">';
    		$out .= form_open_multipart('/admin/products/add/'.$r->product_id, array('name' => 'product_edit_form', 'id' => 'product_edit_form', 'onSubmit' => 'return products.submitForm();'));
    		//$out .= form_open_multipart('/admin/products/add/'.$r->product_id, array('name' => 'product_edit_form', 'id' => 'product_edit_form')); 
    		 
    		$out .= form_hidden('product_id', $r->product_id);
    		$out .= form_hidden('user_id', $this->session->userdata['user_id']);
    		
    		$out .= '<div class="form-group">';
        	$out .= '<label for="product_type_id">Product Type</label><br />';
        	$out .= '<select name="product_type_id">';
        		
        	$alltypes = $this->product_type->fetchAll();       		      			
        	foreach($alltypes as $atype){        			
        		$out .= '<option value="'.$atype->product_type_id.'">'.$atype->type.'</option>';    			      			
        	}
        		
        	$out .= '</select>';      		
        	$out .= '</div>';
    		
    		$out .= '<div class="form-group">';
    			$out .= '<label for="product_name">Product Name</label><br />';
    			$out .= form_input(array('style' => 'width:80%;', 'name' => 'name', 'placeholder' => 'Product Name', 'value' => html_entity_decode($r->name)));
    			$out .= '</div>';   	
    			$out .= '<div class="form-group">';
    			$out .= '<label for="description">Product Description</label><br />';
    			$out .= form_textarea(array('name' => 'description', 'rows' => 5, 'cols' => 40, 'placeholder' => 'Description', 'value' => html_entity_decode($r->description)));
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			$out .= '<label for="short_description">Short Description</label><br />';
    			$out .= form_textarea(array('name' => 'short description', 'rows' => 4, 'cols' => 40, 'placeholder' => 'Short Description', 'value' => html_entity_decode($r->short_description)));
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			$out .= '<label for="cost">Product Cost</label><br />';
    			$out .= '$'.form_input(array('name' => 'cost', 'placeholder' => 'Cost', 'value' => number_format($r->cost,2)));
    			$out .= '</div>';   
    			$out .= '<div class="form-group">';
    			$out .= '<label for="retail_price">Retail Price</label><br />';
    			$out .= '$'.form_input(array('name' => 'retail_price', 'placeholder' => 'Retail Price', 'value' => number_format($r->retail_price,2)));
    			$out .= '</div>';
    		$out .= '<div class="form-group">';
    		$out .= '<input type="file" name="userfile" size="20" />';
    		
    	    $out .= 'Current Image: <img src="/products/productimg/100/'.$product_id.'/'.$r->image.'" />';
    		
    		$out .= '</div>';
    		
    		$out .= '<div class="listing-addon" style="display:none;">';
    		$out .= form_hidden('listing_id', null);
    		
    		$out .= '<div class="form-group">';
    		$out .= '<label for="start_date">Start Date</label>  <label style="margin-left:100px;" for="start_time">Start Time</label><br />';
    		$out .= form_input(array('type' => 'date', 'min' => date('Y-m-d'), 'name' => 'start_date', 'placeholder' => 'Start Date', 'value' => date('Y-m-d', strtotime(date('Y-m-d')))));
    		$out .= form_input(array('type' => 'time', 'name' => 'start_time', 'placeholder' => 'Start Time', 'value' => date('H:i:s', strtotime(date('H:i:s')))));
    		$out .= '</div>';
    		$out .= '<div class="form-group">';
    		$out .= '<label for="end_date">End Date</label>  <label style="margin-left:108px;" for="end_time">End Time</label><br />';
    		$out .= form_input(array('type' => 'date', 'min' => date('Y-m-d'), 'name' => 'end_date', 'placeholder' => 'End Date', 'value' => date('Y-m-d', strtotime(date('Y-m-d').' + 1 day'))));
    		$out .= form_input(array('type' => 'time', 'name' => 'end_time', 'placeholder' => 'Start Time', 'value' => date('H:i:s', strtotime(date('H:i:s')))));
    		$out .= '</div>';
    		$out .= '<div class="form-group">';
    		$out .= '<label for="buynow_price">Buy Now Price</label><br />';
    		$out .= '$'.form_input(array('name' => 'buynow_price', 'placeholder' => 'Buy Now Price', 'value' => number_format($r->buynow_price, 2)));
    		$out .= '</div>';
    		$out .= '<div class="form-group">';
    		$out .= '<label for="reserve_price">Reserve Price</label><br />';
    		$out .= '$'.form_input(array('name' => 'reserve_price', 'placeholder' => 'Reserve Price', 'value' => number_format($r->reserve_price, 2)));
    		$out .= '</div>';
    		$out .= '</div>';
    		$out .= '<div class="form-group">';
    		$out .= '<label for="list-item-now">List this Product</label><br />';
    		$out .= '<input onclick="toggleAddon(this)" type="checkbox" name="list-item-now" />';
    		$out .= '</div>';
    		//$out .= '<input type="button" class="sign_list_product" value="List Product" onclick="toggleAddon()" />';
    		$out .= form_submit(array('name' => 'submit', 'value' => 'Save', 'class' => 'sign_save'));
    		//$out .= '<input type="button" class="sign_save">Save</button>';
    		$out .= '</form>';
    		$out .= '</div>';
    	} 
    	$out .= '
    			</div>
                <div class="modal-footer">
                <div class="row">             	    
                    <div class="col-xs-3 col-sm-6">
                        <!-- <button type="button" class="btn btn-red" id="submitSignupBtn">SAVE</button> -->
                    </div>
                </div>
                </div> <!-- modal-footer -->
    			';
        echo $out; exit;
    }
   
    public function productimg($size = 50, $product_id = 0, $file = null) {
        
        $path = $_SERVER["DOCUMENT_ROOT"] . 'public' . DS . 'uploads' . DS . 'products' . DS . $product_id . DS; 

        if (!empty($file))
            $file = urlencode($file);

        try {

            if (!empty($product_id)){
                $user = $this->product->fetchAll(array('where' => 'product_id = '.$product_id));               
            }

            if (!empty($file))
                $img = $file;

            if (!file_exists($path . $img))
                $img = null;

            if (empty($img)) {
                $path = $_SERVER["DOCUMENT_ROOT"] . DS . 'public' . DS . 'images' . DS;
                $img = 'no_photo.png';
            }

            $is = getimagesize($path . $img);

            if ($is === false)
                throw new exception("Unable to get image size for ({$path}{$img})!");

            $ext = PHPFunctions::getFileExt($img); 

            list ($width, $height, $type, $attr) = $is;

            if ($width == $height) {
                $nw = $nh = $size;
            } elseif ($width > $height) {
                $scale = $size / $height;
                $nw = $width * $scale;
                $nh = $size;
                $leftBuffer = (($nw - $size) / 2); 
            } else {
                $nw = $size;
                $scale = $size / $width;
                $nh = $height * $scale;
                $topBuffer = (($nh - $size) / 2);
            }

            $leftBuffer = 0;
            $topBuffer =  0;

            if ($ext == "JPG")
                $srcImg = imagecreatefromjpeg($path . $img);
            if ($ext == "GIF")
                $srcImg = imagecreatefromgif($path . $img);
            if ($ext == "PNG")
                $srcImg = imagecreatefrompng($path . $img);

            $destImg = imagecreatetruecolor($nw, $nh); // new image
            //var_dump($destImg, $srcImg, $leftBuffer, $topBuffer, 0, 0, $nw, $nh, $width, $height); exit;
            imagecopyresized($destImg, $srcImg, $leftBuffer, $topBuffer, 0, 0, $nw, $nh, $width, $height);
        } catch (Exception $e) {
            PHPFunctions::sendStackTrace($e);
        }

        header('Content-Type: image/jpg');
        imagejpeg($destImg);

        imagedestroy($destImg);
        imagedestroy($srcImg);
    }

    private function doUpload($product_id)
    {
    	$path = 'public' . DS . 'uploads' . DS . 'products' . DS . $product_id . DS;
    
    	$this->functions->createDir($path);
    
    	$config['upload_path'] = './' . $path;
    	$config['allowed_types'] = "gif|jpg|png";
    	$config['max_size'] = "5120";
    	$config['encrypt_name'] = true;
    
    	$this->load->library('upload', $config);
    
    	if ( ! $this->upload->do_upload())
    	{
    		return $this->upload->display_errors();
    	}
    	else
    	{
    		$data = array('upload_data' => $this->upload->data());
    
    		return($data['upload_data']);
    	}
    }
}