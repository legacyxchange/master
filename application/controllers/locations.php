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
}