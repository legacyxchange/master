<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    
require_once 'abstract_model.php';

class location_hours_model extends abstract_model {

    public $location_hours_id;
    public $location_id;
    public $monday_opening_time;
    public $monday_closing_time;
    public $tuesday_opening_time;
    public $tuesday_closing_time;
    public $wednesday_opening_time;
    public $wednesday_closing_time;
    public $thursday_opening_time;
    public $thursday_closing_time;
    public $friday_opening_time;
    public $friday_closing_time;
    public $saturday_opening_time;
    public $saturday_closing_time;
    public $sunday_opening_time;
    public $sunday_closing_time;
    
    function __construct() {
        parent::__construct();
    }

    public function getLocationHoursByLocationId($location_id) {
        $mtag = "location_hours-{$location_id}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('*');
            $this->db->from('location_hours');
            $this->db->where('location_id', $location_id);

            $query = $this->db->get();

            $res = $query->result();
            
            $data = $res[0];

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        if(!is_null($data))
    		$data->day_open = $this->getDayOpen($data);
    	
        return $data;
    }

	protected function getDayOpen($data){
		
		$now = date('Y-m-d H:i:s');
    	$today = strtolower(date('l')); 
    	$days = array('monday','tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
    	foreach($days as $k=>$day){
    		if($day == $today)
    		{     			
    			$day_open = $day.'_opening_time';
    			$day_close = $day.'_closing_time';
    			
    			if($data->$day_open == 'closed'){
    				return null;
    			}
    			$open = date('Y-m-d H:i:s', strtotime(date('Y-m-d').$data->$day_open));
    			$close = date('Y-m-d H:i:s', strtotime(date('Y-m-d').$data->$day_close));
    			
    			if($now >= $open && $now <= $close){
    				return 'Open';
    			}
    			else {
    				return 'Closed';
    			}
    		}
    	}
    	return null;
    }
    
	public function save($params) {
    	$params = $this->cleanseParams($params);
    	
    	if(!empty($params['location_id'])) {
    		$lh = $this->getLocationHoursByLocationId($params['location_id']);
    	
    		if(count($lh) > 0){
    	    	$this->db->where('location_id', $params['location_id']);
            	$this->db->update('location_hours', $params);
    		}else{   			
    			$this->db->insert('location_hours', $params);
    		}
    	}
    	return true;
    }
    
    protected function cleanseParams($params) {
    	foreach($params as $key=>$val) {
    		if(!property_exists($this, $key))
    		    unset($params[$key]);
    		elseif($params[$key] == '' || $params[$key] == 'closed')
    		   $params[$key] = 'closed';
    	}
    	return $params;
    }
}