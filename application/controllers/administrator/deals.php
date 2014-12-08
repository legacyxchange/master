<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Deals extends CI_Controller {

    function Deals() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('deals_model', 'deals', true);
        $this->load->model('menu_model', 'menu', true);
        $this->load->model('profile_model', 'profile', true);
        $this->load->model('dojos_model', 'dojos', true);
        $this->load->model('locations_model', 'locations', true);
        $this->load->model('reviews_model', 'reviews', true);
        $this->load->model('search_model', 'search', true);
        $this->load->helper('form');
        $this->load->helper('url');
    }
    
    // $id = locations primary key
    public function index($id = null) {
    	
    	$header['headscript'] = $this->functions->jsScript('jquery-1.6.min.js jquery.reveal.js deals.js');
    	
    	$body['deals'] = $this->deals->fetchAll();
    	
    	$this->functions->checkLoggedIn();
    	
        $userid = $this->session->userdata('userid');
        $body['userid'] = $userid;
        $body['location_id'] = $id;
        
        $body['administrator_menu'] = $this->load->view('administrator/administrator_menu', null, true);
        $this->load->view('administrator/template/header', $header);
        $this->load->view('administrator/deals', $body);
        $this->load->view('administrator/template/footer');
    }

    protected function getContentPage($location_id){
    	switch($this->uri->segment(2)){
    		case 'deals':
    			$body['content_page'] = 'deals';
    	        $body['content_uri'] = '/administrator/deals/deal/'.$location_id;
    	    break;
    		case 'menu':
    			
    	    break;
    	}
    	return $body;	
    }
    
	public function deal($id = null) {
    	if(empty($this->session->userdata['userid']) || !$id) {
    	   return $this->view(); exit; // redirect to $this->view() if not logged in
    	}
  
    	$header['headscript'] = $this->functions->jsScript('deals.js');
    	
    	$location_info = $this->dojos->getLocationInfo($id);
    	
    	$body['name'] = $location_info->name;
    	
    	$this->functions->checkLoggedIn();
    	
        $userid = $this->session->userdata('userid');
        $body['userid'] = $userid;
        $body['location_id'] = $id;
        
        try {
            $body['deals'] = $this->deals->getDealsByLocation($id);
            
            if(empty($body['deals'])) {
                header('Location: /admin/deals/add/'.$id); exit;
            }  
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $this->load->view('deals/deals', $body);
        
    } 
    
    public function edit($dealid, $id) {
    	if(!$dealid || !$id)
    	   header('Location: /admin/deals/index/');

    	$userid = $this->session->userdata('userid');
        $body['userid'] = $userid;   
    	$body['deals'] = $this->deals->getDealById($dealid);
    	$body['location_id'] = $id;
    	
        if (!empty($_POST)) {
        	$params = $_POST;
        	
        	if(!empty($_FILES['userfile']['name'])){
        		$this->doUpload();      		
        	}
            try {
            	$where = 'dealid = "'.$dealid.'"';
            	
                $this->deals->save($where);

                $this->session->set_flashdata('SUCCESS', 'Your info has been updated!');
                
                header('Location: /administrator/deals/index/'.$id); exit;
                
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);

                $this->session->set_flashdata('FAILURE', $e->getMessage());
            }
        }      
        $this->load->view('deals/edit', $body);
    }
    
    public function add() {    	
        if (!empty($_POST)) {
        	$params = $_POST;
        	 var_dump($params); exit;      	
            try {
            	//var_dump($params); exit;
            	$this->deals->save();

            	if(!empty($_FILES['userfile']['name'])){
            	
            		$ret = $this->doUpload($userid);
            		if(!empty($ret['file_name'])){
            			$_POST['profileimg'] = $ret['file_name'];
            			$_POST['id'] = $userid;
            			$this->user->save(array('where' => 'id = '.$userid));
            		}
            	}
            	
                $this->session->set_flashdata('SUCCESS', 'Your info has been updated!');
                
                header('Location: /administrator/deals/index'); exit;
                
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);

                $this->session->set_flashdata('FAILURE', $e->getMessage());
            }
        }
        $this->load->view('deals/add', $body);        
    }
    
    public function delete($dealid, $id) {
    	if(!$dealid || !$id)
    	   header('Location: /deals/index/'.$id);

        $dealid = $this->deals->delete($dealid);   
    		
    	$this->session->set_flashdata('SUCCESS', 'Your deal has been deleted!');
        header("Location: /deals/index/$id");
        exit;
    }
    
    private function doUpload($userid)
	{
		$path = 'public' . DS . 'uploads' . DS . 'deals' . DS . $userid . DS;
  
        // ensures company uploads directory has been created
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
	
	public function setfeatured($dealid) {
		$num_rows_affected = $this->deals->setFeatured($dealid); 
		if($num_rows_affected > 0) {
			echo $dealid;
		}else{
			echo 0;
		}
		exit;
	}
	
    public function getfeatured() {
		$num_rows_affected = $this->deals->getFeatured($dealid); 
		if($num_rows_affected > 0) {
			echo $dealid;
		}else{
			echo 0;
		}
		exit;
	}
	
    public function dealimg($size = 50, $userid = 0, $file = null) {
        if (empty($userid))
            $userid = $this->session->userdata('userid');

        $path = $_SERVER["DOCUMENT_ROOT"] . 'public' . DS . 'uploads' . DS . 'deals' . DS . $userid . DS;

        if (!empty($file))
            $file = urlencode($file);

        try {

            if (!empty($file))
                $img = $file;

            if (!file_exists($path . $img))
                $img = null;

           if (empty($img)) {
                $path = $_SERVER["DOCUMENT_ROOT"] . DS . 'public' . DS . 'images' . DS;
                $img = 'no_dojo_profilepic.png';
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


        #echo "NW: {$nw} | NH: {$nh} | Scale: {$scale} | ";
        #echo "topBuffer: {$topBuffer}";
        #echo "leftBuffer: {$leftBuffer}";
        header('Content-Type: image/jpg');
        imagejpeg($destImg);

        imagedestroy($destImg);
        imagedestroy($srcImg);
    }
}