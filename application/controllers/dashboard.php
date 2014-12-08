<?php
error_reporting(E_ALL & ~E_NOTICE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function Dashboard() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('deals_model', 'deals', true);
        $this->load->model('profile_model', 'profile', true);
        $this->load->model('dojos_model', 'dojos', true);
        $this->load->model('dashboard_model', 'dashboard', true);
        $this->load->model('search_model', 'search', true);
        $this->load->model('reviews_model', 'reviews', true);
        $this->load->helper('form');
        $this->load->helper('url');
    }
    
	public function index() { 
        $this->functions->checkLoggedIn();
        $header['headscript'] = $this->functions->jsScript('search.js welcome.js');
        //$header['backstretch'] = true;
        $header['googleMaps'] = true;

        $body['deals'] = $this->deals->getDealsByUserId();
        
        try {
            $body['places'] = $places = $this->dojos->getLocationInfoByUserId($this->session->userdata['userid']);           
            
            foreach($places as $p){
            	$avgRating = $this->search->avgReviews($p->id);
                $bodyRating['avg'] = $avgRating;
                $body['ratingHtml'][] = $this->load->view('search/listavgrating', $bodyRating, true);
                $body['reviews'][] = $this->reviews->getReviewsByLocation($p->id);               
                $body['num_reviews'][] = count($body['reviews']);                
            }
             //var_dump($body['reviews']); exit;          
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        // no lat/lng was resolved, will simply pass 0
        if (empty($_GET['lat']))
            $_GET['lat'] = 0;
        if (empty($_GET['lng']))
            $_GET['lng'] = 0;

        $header['onload'] = "search.indexInit(" . urldecode($_GET['lat']) . ", " . urldecode($_GET['lng']) . ");";

        if (isset($_GET['locate'])) {
            $header['onload'] .= "welcome.loadGettingStartingModal(this, true);";
        }

        $this->load->view('template/header', $header);
        $this->load->view('dashboard/index', $body);
        $this->load->view('template/footer');
    }
}