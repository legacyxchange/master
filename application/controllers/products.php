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
    }

    public function index(product_$id = null) {
    	
        $body['user_id'] = $user_id = $this->session->userdata('user_id'); 
        
        $header['headscript'] = $this->functions->jsScript('jquery-1.6.min.js jquery.reveal.js products.js');
        
        if(is_null($product_id)){
        	try {
        		$products = $this->product->fetchAll(array('where' => 'user_id = '.$user_id, 'orderby' => 'product_id DESC'));        		               		
        	} catch (Exception $e) {
        		$this->functions->sendStackTrace($e);
        	}
        }else{
        	$products = $this->product->fetchAll('product_id = '.$product_id);        	
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
        $this->load->view('template/footer');
    }
    
    public function productimg($size = 50, $product_id = 0, $file = null) {
        
        $path = $_SERVER["DOCUMENT_ROOT"] . 'public' . DS . 'uploads' . DS . 'products' . DS . $product_id . DS;

        if (!empty($file))
            $img = $file = urlencode($file);

        try {

            if (!empty($product_id) && !$img){
                $product = $this->product->fetchAll(array('where' => 'product_id = '.$product_id))[0]; 
                //var_dump($product); exit;
                $img = $product->image;              
            }

            //echo $path.$img;
            //var_dump(file_exists($path . $img)); exit; 
            
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
                $ratio = $size / $width;
                $nh = $height * $ratio;
                $nw = $size;               
            } else {
            	$ratio = $size / $height;                              
                $nw = $width * $ratio;
                $nh = $size;
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
            
            imagecopyresampled($destImg, $srcImg, $leftBuffer, $topBuffer, 0, 0, $nw, $nh, $width, $height);
        } catch (Exception $e) {
            PHPFunctions::sendStackTrace($e);
        }

        header('Content-Type: image/jpeg');
        imagejpeg($destImg,NULL,80);
    }
}