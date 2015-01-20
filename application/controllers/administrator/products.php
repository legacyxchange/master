<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends CI_Controller {

    function Products() {
    	
        parent::__construct();

        $this->load->driver('cache');

        $this->load->model('user_model', 'user', true);
        
        $this->load->model('profile_model', 'profile', true);
        
        $this->load->model('products_model', 'product', true);
        
        $this->load->model('product_types_model', 'product_type', true);
        
        $this->load->library('library');
        
        $this->load->library('pagination');
        
        $this->functions->checkSudoLoggedIn();
    }

    public function index($id = null, $page = 0) { 
    	$header['headscript'] = $this->functions->jsScript('products.js');
        
        if(is_null($product_id)){
        	try {
        		/* $pagination_config['base_url'] = '/administrator/products/index//'.$page;
        		$pagination_config['total_rows'] = $this->product->countAll('product_type_id = 1');
        		$pagination_config['per_page'] = 5;
        		$pagination_config['cur_page'] = $page;
        		$pagination_config['use_page_numbers'] = TRUE;
        		$this->pagination->initialize($pagination_config); */
        		
        		//$products = $this->product->fetchAll(array('where' => 'product_type_id = 1', 'orderby' => 'product_id DESC', 'limit' => $pagination_config['per_page'], 'offset' => $page));
        		$products = $this->product->fetchAll(array('orderby' => 'product_id DESC'));
        		
        	} catch (Exception $e) {
        		$this->functions->sendStackTrace($e);
        	}
        }else{
        	$products = $this->product->fetchAll(array('where' => 'product_id = '.$product_id, 'orderby' => 'product_id DESC'));        	
        }
        
        foreach($products as $product){        	
        	$types = $this->product_type->fetchAll(array('where' => 'product_type_id = '.$product->product_type_id));
        	foreach($types as $type){
        		$product->product_type = $type->type;
        	}
        	$prods []= $product; 
        }
        
        $body['products'] = $prods;
        $body['administrator_menu'] = $this->load->view('administrator/administrator_menu', null, true);
        $this->load->view('administrator/template/header', $header);
        $this->load->view('administrator/products', $body);
        $this->load->view('administrator/template/footer');
    }
    
    public function add() {    	 
    	if (!empty($_POST)) {
    		$params = $_POST;
    		
    		try {
    			
    		$product_id = $this->product->save();

    		if(!empty($_FILES['userfile']['name'])){
    			 
    			$ret = $this->doUpload($product_id);
    			if(!empty($ret['file_name'])){
    				$_POST['image'] = $ret['file_name'];
    				$_POST['product_id'] = $product_id;
    				$_POST['userid'] = $this->session->userdata['userid'];
    				$this->product->save('product_id = '.$product_id);
    			}
    		}
    		
    		$this->session->set_flashdata('SUCCESS', 'Your info has been updated!');
    
    		header('Location: /administrator/products/index'); exit;
    
    	    } catch (Exception $e) {
    			$this->functions->sendStackTrace($e);
    
    			$this->session->set_flashdata('FAILURE', $e->getMessage());
    		}
    	}
    	return $this->index();
    }
    
    public function edit($product_id) {
    	if(!$product_id)
    		header('Location: /administrator/products');
    
    	$body['product_id'] = $product_id;
    	
    	if (!empty($_POST)) {
    		$params = $_POST;
    		   		
    		if(!empty($_FILES['userfile']['name'])){
    			
    			$ret = $this->doUpload($product_id);
    			
    			if(!empty($ret['file_name'])){
    				$_POST['image'] = $ret['file_name'];
    				$_POST['product_id'] = $product_id;
    				$_POST['user_id'] = $this->session->userdata['user_id'];
    				
    				$this->product->save('product_id = '.$product_id);
    			}
    		}
    		
    		try {
    			$where = 'product_id = '.$product_id;
    			 
    			$this->product->save($where);
    
    			$this->session->set_flashdata('SUCCESS', 'Your info has been updated!');
    
    			header('Location: /administrator/products/'); exit;
    
    		} catch (Exception $e) {
    			$this->functions->sendStackTrace($e);
    
    			$this->session->set_flashdata('FAILURE', $e->getMessage());
    		}
    	}      	
    }
    
    public function delete($product_id){
    	if ($this->session->userdata('logged_in') == false || $this->session->userdata['permissions'] < 1){
    		header('Location: /'); exit;
    	}
    	 
    	$this->product->delete('product_id', $product_id);
    	 
    	$this->session->set_flashdata('SUCCESS', 'Your data has been updated.');
    	
    	header('Location: /administrator/products'); exit;
    }
    
    public function productsform($product_id = null){    	
    	$out = null;
    	if(!is_null($product_id)){
    		$products = $this->product->fetchAll(array('where' => 'product_id = '.$product_id, 'orderby' => 'product_id DESC'));
    		
    		foreach($products as $r){ 
    			$out .= '
    			<div class="modal-header">
                <h3 class="modal-title">'.$r->listing_name.'</h3>
                </div> <!-- modal-header -->
                <div class="modal-body">
    			';
    			$out .= '<div role="form">';    	        
    			$out .= form_open_multipart('/administrator/products/edit/'.$r->product_id); 
    			
        		$out .= form_hidden('product_id', $r->product_id);
        		$out .= form_hidden('user_id', $r->user_id);
        		
        		$out .= '<div class="form-group">';
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
    			$out .= form_input(array('name' => 'name', 'placeholder' => 'Product Name', 'value' => $r->name));
    			$out .= '</div>';   	
    			$out .= '<div class="form-group">';
    			$out .= form_input(array('name' => 'description', 'placeholder' => 'Description', 'value' => $r->description));
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			$out .= form_input(array('name' => 'short description', 'placeholder' => 'Short Description', 'value' => $r->short_description));
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			$out .= form_input(array('name' => 'cost', 'placeholder' => 'Cost', 'value' => $r->cost));
    			$out .= '</div>'; 
    			$out .= '<div class="form-group">';
    			$out .= form_input(array('name' => 'retail_price', 'placeholder' => 'Retail', 'value' => $r->retail_price));
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			$out .= '<input type="file" name="userfile" size="20" />'; 
    			if(isset($r->image)){
    				$out .= 'Current Image: <img src="/admin/products/productimg/100/'.$r->product_id.'/'.$r->image.'" />';
    			}
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			$out .= form_input(array('name' => 'active', 'placeholder' => 'Active', 'value' => $r->active));
    			$out .= '</div>';
    			
    			$out .= form_submit(array('name' => 'submit', 'value' => 'Save', 'class' => 'sign_save'));
    			$out .= '</form>';
    			$out .= '</div>';
    		}   
    	} else {
    		$out .= '
    			<div class="modal-header">
                <h3 class="modal-title">'.$r->listing_name.'</h3>
                </div> <!-- modal-header -->
                <div class="modal-body">
    			';
    		$out .= '<div role="form">';
    		$out .= form_open_multipart('/administrator/products/add');
    		 
    		//$out .= form_hidden('product_id', $r->product_id);
    		$out .= form_hidden('user_id', $r->user_id);
    		
    		$out .= '<div class="form-group">';
        	$out .= '<select name="product_type_id">';
        		
        	$alltypes = $this->product_type->fetchAll();       		      			
        	foreach($alltypes as $atype){        			
        		$out .= '<option value="'.$atype->product_type_id.'">'.$atype->type.'</option>';    			      			
        	}
        		
        	$out .= '</select>';      		
        	$out .= '</div>';
    		
    		$out .= '<div class="form-group">';
    		$out .= form_input(array('name' => 'name', 'placeholder' => 'Product Name', 'value' => ''));
    		$out .= '</div>';
    		$out .= '<div class="form-group">';
    		$out .= form_input(array('name' => 'description', 'placeholder' => 'Description', 'value' => ''));
    		$out .= '</div>';
    		$out .= '<div class="form-group">';
    		$out .= form_input(array('name' => 'short description', 'placeholder' => 'Short Description', 'value' => ''));
    		$out .= '</div>';
    		$out .= '<div class="form-group">';
    		$out .= form_input(array('name' => 'cost', 'placeholder' => 'Cost', 'value' => ''));
    		$out .= '</div>';
    		$out .= '<div class="form-group">';
    		$out .= '<input type="file" name="userfile" size="20" />';
    		if(isset($r->image)){
    			$out .= 'Current Image: <img src="/products/productimg/100/" />';
    		}
    		$out .= '</div>';
    		
    		$out .= form_submit(array('name' => 'submit', 'value' => 'Save', 'class' => 'sign_save'));
    		$out .= '</form>';
    		$out .= '</div>';
    	} 
        echo $out; exit;
    }
   
    public function productimg($size = 50, $product_id = 0, $file = null) {
        
        $path = $_SERVER["DOCUMENT_ROOT"] . 'public' . DS . 'uploads' . DS . 'products' . DS . $product_id . DS;

        if (!empty($file))
            $file = urlencode($file);

        try {

            if (!empty($product_id)){
                $user = $this->products->fetchAll(array('where' => 'product_id = '.$product_id));               
            }

            if (!empty($file))
                $img = $file;

            if (!file_exists($path . $img))
                $img = null;

            if (empty($img)) {
                $path = $_SERVER["DOCUMENT_ROOT"] . DS . 'public' . DS . 'images' . DS;
                $img = 'dude.gif';
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

            $leftBuffer = $leftBuffer * -1;
            $topBuffer = $topBuffer * -1;

            if ($ext == "JPG")
                $srcImg = imagecreatefromjpeg($path . $img);
            if ($ext == "GIF")
                $srcImg = imagecreatefromgif($path . $img);
            if ($ext == "PNG")
                $srcImg = imagecreatefrompng($path . $img);

            $destImg = imagecreatetruecolor($size, $size); // new image
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