<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reviews extends CI_Controller {

    function Reviews() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('deals_model', 'deals', true);
        $this->load->model('menu_model', 'menu', true);
        $this->load->model('profile_model', 'profile', true);
        $this->load->model('dojos_model', 'dojos', true);
        $this->load->model('locations_model', 'locations', true);
        $this->load->model('reviews_model', 'reviews', true);
        $this->load->model('search_model', 'search', true);
    }
    
    public function index() {
    	
        try {
            $body['reviews'] = $this->reviews->getReviews(null, false);
            
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $this->load->view('template/header', $header);
        $this->load->view('reviews/index', $body);
        $this->load->view('template/footer');
    }
    
    public function info($location_id)
    {
    	$body['reviews'] = $reviews = $this->reviews->getReviewsByLocationId($location_id);
    	$body['location_id'] = $location_id;
        $body['info'] = $info = $this->locations->getLocationById($location_id)[0];
        $body['menu'] = $this->menu->getMenu($location_id);
        $body['menuOptions'] = $this->menu->getMenuOptions();
        $body['deals'] = $this->deals->getDealsByLocation($location_id);   
        $body['assigned'] = $this->search->checkLocationAssigned($location_id);
        $body['images'] = $this->search->getLocationImages($location_id);

        $this->load->view('reviews/index', $body);
    }
    
    public function add($id){
    	
    }
}