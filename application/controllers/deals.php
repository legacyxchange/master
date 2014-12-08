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
    
    // user that is not logged in will be redirected to this function
    public function index($location_id = null){
    	if (! is_null ( $location_id )) {
			$body ['featured_deals'] = $this->deals->getFeaturedDeals ( $location_id, false );
			$body ['newest_deals'] = $this->deals->getDealsByDate ( 'newest', $location_id, false );
			$body ['expiring_deals'] = $this->deals->getDealsByDate ( 'expiring', $location_id, false );
			$body ['popular_deals'] = $this->deals->getDealsByPopularity ( $location_id, false );
		}else{
			$body['featured_deals'] = $this->deals->fetchAll(array('where' => 'featured = 1', 'orderby' => 'created DESC', 'limit' => 10));
			$body['newest_deals'] = $this->deals->fetchAll(array('where' => 'featured = 0', 'orderby' => 'created DESC', 'limit' => 10));
			$body['popular_deals'] = $this->deals->fetchAll(array('orderby' => 'hits DESC', 'limit' => 10));
			$yesterday = date('Y-m-d', strtotime('yesterday')); 
			$body['expiring_deals'] = $this->deals->fetchAll(array('where' => 'expiration_date <= "'.$yesterday.'"', 'orderby' => 'created DESC', 'limit' => 10));
		}
		
        
        //var_dump($body); exit;
        /* $body['menu'] = $this->menu->getMenu($location_id);
        $body['menuOptions'] = $this->menu->getMenuOptions();
        $body['deals'] = $this->deals->getDealsByLocation($location_id);
        
        $body['reviews'] = $this->search->getReviews($location_id);
            
        $body['assigned'] = $this->search->checkLocationAssigned($location_id);
        $body['images'] = $this->search->getLocationImages($location_id); */
        
        //$body['menu_userlist'] = $this->load->view('partials/menu_userlist', $body, true);
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        	$this->load->view('/deals/front/index', $body);
        }else{
    	$this->load->view('/template/header', $header);
    	$this->load->view('/deals/front/index', $body);
        $this->load->view('/template/footer');
        }
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

            // checks if file exists
            if (!file_exists($path . $img))
                $img = null;

            // no profile image is set - loads no profile img
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
            #imagecopyresized($destImg, $srcImg, 0, 0, $leftBuffer, $topBuffer, $nw, $nh, $width, $height);
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