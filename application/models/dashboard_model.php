<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';
require_once 'deals_model.php';

class dashboard_model extends abstract_model {
    
    function __construct() {
        parent::__construct();
    }

    public function getDeals() {  	
    	$deals = new deals_model();
    	
    	return $allMyDeals = $deals->getDeals($this->session->userdata('userid'));
    } 
    
    public function getDashboardSettings($dashboard_settings_id = null) {  	
    	
    	$query = $this->db->query('select * from dashboard_settings as d');   	
    	    
    	if($query->num_rows() > 0){  
    		return $query->result();
    	}

    	return null;
    } 
   
    public function save($params) {
    	$params = $this->cleanseParams($params);
    	
    	if(!empty($params['dealid'])) {
    		$deals = $this->getDealById($params['dashboard_id']);
    	
    		if(count($deals) > 0){
    	    	$this->db->where('dashboard', $params['dashboard_id']);
            	$this->db->update('dashboard', $params);
    		}
    	}
    	else {
    		$this->db->insert('dashboard', $params);
    	}
    	
    	return true;
    }
}