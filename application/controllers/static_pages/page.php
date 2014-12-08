<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Page extends CI_Controller {

    function Page() {
        parent::__construct();
    }
    
    public function how_to_sell(){ 
    	$body['title'] = 'How to Sell'; 
    	$this->load->view('admin/template/header', $header);
        $this->load->view('static_pages/how_to_sell', $body);         
        $this->load->view('template/footer');
    }
    
    public function news(){
    	$body['title'] = 'In the News';
    	$this->load->view('admin/template/header', $header);
    	$this->load->view('static_pages/news', $body);
    	$this->load->view('template/footer');
    }
    
    public function how_to_buy(){   
    	$body['title'] = 'How to Buy';
    	$this->load->view('admin/template/header', $header);
    	$this->load->view('static_pages/how_to_buy', $body);
    	$this->load->view('template/footer');
    }
    
    public function privacy(){
    	$body['title'] = 'Privacy Policy';
    	$this->load->view('admin/template/header', $header);
    	$this->load->view('static_pages/privacy', $body);
    	$this->load->view('template/footer');
    }
    
    public function terms(){
    	$body['title'] = 'Terms of Service';
    	$this->load->view('admin/template/header', $header);
    	$this->load->view('static_pages/terms', $body);
    	$this->load->view('template/footer');
    }
    
    public function about(){
    	$body['title'] = 'About Us';
    	$this->load->view('admin/template/header', $header);
    	$this->load->view('static_pages/about', $body);
    	$this->load->view('template/footer');
    } 
    
    public function rates(){ 
    	$body['title'] = 'Rates';
    	$this->load->view('admin/template/header', $header);
    	$this->load->view('static_pages/rates', $body);
    	$this->load->view('template/footer');
    }
    
    public function help(){
    	$body['title'] = 'Help / Customer Service';
    	$this->load->view('admin/template/header', $header);
    	$this->load->view('static_pages/help', $body);
    	$this->load->view('template/footer');
    }
    
    public function how_site_works(){
    	$body['title'] = 'How the Site Works.';
    	$this->load->view('admin/template/header', $header);
    	$this->load->view('static_pages/how_site_works', $body);
    	$this->load->view('template/footer');
    }
    
    public function mark_item(){
    	$body['title'] = 'Mark Items';
    	$this->load->view('admin/template/header', $header);
    	$this->load->view('static_pages/mark_item', $body);
    	$this->load->view('template/footer');
    }
    
    public function faqs(){
    	$body['title'] = 'Faq\'s';
    	$this->load->view('admin/template/header', $header);
    	$this->load->view('static_pages/faqs', $body);
    	$this->load->view('template/footer');
    }
    
    public function disclaimers(){
    	$body['title'] = 'Disclaimers';
    	$this->load->view('admin/template/header', $header);
    	$this->load->view('static_pages/disclaimers', $body);
    	$this->load->view('template/footer');
    }
    
    public function dealers(){ 
    	$body['title'] = 'Dealers';
    	$this->load->view('admin/template/header', $header);
    	$this->load->view('static_pages/dealers', $body);
    	$this->load->view('template/footer');
    }
    
    public function athletes_celebrities_agents(){
    	$body['title'] = 'Athletes | Celebrities | Agents';
    	$this->load->view('admin/template/header', $header);
    	$this->load->view('static_pages/athletes_celebrities_agents', $body);
    	$this->load->view('template/footer');
    }
    
    public function manufacturers(){
    	$body['title'] = 'Manufacturers';
    	$this->load->view('admin/template/header', $header);
    	$this->load->view('static_pages/manufacturers', $body);
    	$this->load->view('template/footer');
    } 
}