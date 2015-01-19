<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Locations extends CI_Controller {

    function Locations() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('dojos_model', 'dojos', true);
        $this->load->model('locations_model', 'locations', true);
        $this->load->model('location_hours_model', 'hours', true);
        $this->load->model('search_model', 'search', true);
        $this->load->model('profile_model', 'profile', true);
    }
    
    // $id = locations primary key
    public function index() {
    	
        try {
            $body['locations'] = $this->locations->getLocations(false);
            
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $this->load->view('template/header', $header);
        $this->load->view('locations/index', $body);
        $this->load->view('template/footer');
    }
    
    public function search($cityState){
    	$geoip = $this->search->grabGeoIP();
        $body['lat'] = $bodyListings['lat'] = $lat = $geoip->latitude; 
        $body['lng'] = $bodyListings['lng'] = $lng = $geoip->longitude;
        $header['onload'] = "search.indexInit(" . urldecode($lat) . ", " . urldecode($lng) . ");";
        $header['headscript'] = $this->functions->jsScript('search.js welcome.js');
        $header['googleMaps'] = true;
        
        try {
            $bodyListings['places'] = $places = $this->places->search(urldecode($lat), urldecode($lng), 'Marijuana');
            
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $body['initListings'] = $this->load->view('locations/listings', $bodyListings, true);
        //var_dump($body['initListings']); exit;
        $this->load->view('template/header', $header);
        $this->load->view('locations/index', $body);
        $this->load->view('template/footer');
        
    }
    
    public function profile($location_id) {
    	try {
            $body['location'] = $this->locations->getLocationById($location_id);
            $body['hours'] = $this->hours->getLocationHoursByLocationId($location_id);
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $this->load->view('template/header', $header);
        $this->load->view('locations/profile', $body);
        $this->load->view('template/footer');
    }
    
    public function followers($lid){
    	$this->locations->getFollowers($lid);
    }
    
    public function locationimg($size = 50, $location_id = 0, $file = null) {
    	 
    	$path = $_SERVER["DOCUMENT_ROOT"] . 'public' . DS . 'uploads' . DS . 'locationImages' . DS . $location_id . DS;
    
    	if (!empty($file))
    		$file = urlencode($file);
    
    	try {
    
    		if (!empty($user_id)){
    			$location = $this->locations->fetchAll(array('where' => 'id = '.$location_id));
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
    
    		$leftBuffer = $leftBuffer * -1;
    		$topBuffer = $topBuffer * -0;
    
    		if ($ext == "JPG")
    			$srcImg = imagecreatefromjpeg($path . $img);
    		if ($ext == "GIF")
    			$srcImg = imagecreatefromgif($path . $img);
    		if ($ext == "PNG")
    			$srcImg = imagecreatefrompng($path . $img);
    
    		$destImg = imagecreatetruecolor($nw, $nh); // new image
    		imagecopyresized($destImg, $srcImg, $leftBuffer, $topBuffer, 0, 0, $nw, $nh, $width, $height);
    	} catch (Exception $e) {
    		PHPFunctions::sendStackTrace($e);
    	}
    	header('Content-Type: image/jpg');
    	imagejpeg($destImg);
    
    	imagedestroy($destImg);
    	imagedestroy($srcImg);
    }
}