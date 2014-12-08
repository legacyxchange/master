<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class test_model extends abstract_model {

	protected $table = 'deals';
    public $dealid;
    public $location_id;
    public $userid;
    public $deal_name;
    public $deal_description;
    public $deal_image;
    public $featured;
    public $retail_price;
    public $discount_price;
    public $start_date;
    public $end_date;
    public $repeat;
    public $created;
    public $expiration_date;
    
    function __construct() {
        parent::__construct();
    }

    public function save($params) {
    	$params = $this->cleanseParams($params);
    	
    	if(!empty($params['dealid'])) {
    		$deals = $this->getDealById($params['dealid']);
    	
    		if(count($deals) > 0){
    	    	$this->db->where('dealid', $params['dealid']);
            	$this->db->update('deals', $params);
    		}
    	}
    	else {
    		$this->db->insert('deals', $params);
    	}
    	
    	return true;
    }
    
    public function setFeatured($dealid){
        if(isset($dealid)) {
    		$deals = $this->getDealById($dealid);
    	 
    		if(count($deals) > 0){    			
    			$this->unsetFeatured($deals[0]->location_id);   			
    		    $data = array(
                   'featured' => 1,
                );
    	    	$this->db->where('dealid', $dealid);
            	$this->db->update('deals', $data);
            	return $this->db->affected_rows();
    		}
        }
    }
    
    public function setInactive($dealid){
    	if(isset($dealid)) {
    		$deals = $this->getDealById($dealid);
    	
    		if(count($deals) > 0){    			
    		    $data = array(
                   'is_running' => 0,
                );
    	    	$this->db->where('dealid', $dealid);
            	$this->db->update('deals', $data);
            	return $this->db->affected_rows();
    		}
        }
    }
    
    public function unsetFeatured($location_id){ 					
        $data = array(
           'featured' => 0,
        );
    	$this->db->where('location_id', $location_id);
        $this->db->update('deals', $data);
        return $this->db->affected_rows();	
    }
    
    public function delete($dealid) {
    	if($dealid)
    	    $this->db->delete('deals', array('dealid' => $dealid));
    	
    	return $dealid;
    }
}