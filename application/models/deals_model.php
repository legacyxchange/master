<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class deals_model extends abstract_model {

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
    public $quantity;
    public $start_date;
    public $end_date;
    public $repeat;
    public $created;
    public $expiration_date;
    
    function __construct() {
        parent::__construct();
    }

    public function getFeaturedDeals($location_id = null, $useGeo = true){
    	if($useGeo == true){
    	    $info = $this->grabGeoIP();
    	
    	    $query = $this->db->query('select d.*, l.* from deals as d
    	                               join locations as l on d.location_id = l.id
    	                               where l.city = "'.$info->city.'" and featured > 0');   	
    	}   
    	elseif($location_id){ 
    		$query = $this->db->query('select d.*, l.* from deals as d
    	                           	   join locations as l on d.location_id = l.id
    	                               where d.location_id = '.$location_id.' and featured > 0');   	
    	}
    	else{
    		$query = $this->db->query('select d.*, l.* from deals as d
    	                               join locations as l on d.location_id = l.id
    	                               where featured > 0');  
    	} 
    	if($query->num_rows() > 0){  
    		return $this->getDistanceAndTime($info, $query);
    	}
    		
    	return null;
    }
    
    public function getDealsByDate($v,$location_id=null, $useGeo = true){
    	$info = $this->grabGeoIP();    	    		   	
    	if($v == 'newest'){
    		if(is_null($location_id)){
        		$date = date("Y-m-d", strtotime(date("Y-m-d").' - 10 day'));
        		$and = ' and created > "'.$date.'"';
    		}
    		else {
    			$date = date("Y-m-d", strtotime(date("Y-m-d").' - 10 day'));
        		$and = ' and created > "'.$date.'" and location_id = '.$location_id;
    		}
    	}
        else{
        	$date = date("Y-m-d");
        	if(is_null($location_id)){       		
        		$and = ' and expiration_date <= "'.$date.'"';
        	}else{
        		$and = ' and location_id = '.$location_id.' and expiration_date <= "'.$date.'"';
        	}
        }
        if($useGeo == true){
        	$query = $this->db->query('select d.*, l.* from deals as d
    	                           join locations as l on d.location_id = l.id
    	                           where l.city = "'.$info->city.'" and featured < 1
    	                           '.$and); 
        }else{
        	$query = $this->db->query('select d.*, l.* from deals as d
    	                           join locations as l on d.location_id = l.id
    	                           where featured < 1
    	                           '.$and); 
        } 
    	    
    	if($query->num_rows() > 0){  
    		return $this->getDistanceAndTime($info, $query);
    	}
    		
    	return null;
    }
    
    public function getDealsByPopularity($location_id = null){
    	$info = $this->grabGeoIP(); 
    	if($useGeo == true){   	
    		if(is_null($location_id)){
            	$query = $this->db->query('select d.*, l.* from deals as d
    	                           join locations as l on d.location_id = l.id
    	                           where l.city = "'.$info->city.'"
    	                           and hits > 20');  
    		}else{
    			$query = $this->db->query('select d.*, l.* from deals as d
    	                           join locations as l on d.location_id = l.id
    	                           where l.city = "'.$info->city.'"
    	                           and hits > 20 and d.location_id = '.$location_id); 
    		}
    	}else{
    		if(is_null($location_id)){
            	$query = $this->db->query('select d.*, l.* from deals as d
    	                           join locations as l on d.location_id = l.id
    	                           where hits > 20');  
    		}else{
    			$query = $this->db->query('select d.*, l.* from deals as d
    	                           join locations as l on d.location_id = l.id
    	                           where hits > 20 and d.location_id = '.$location_id); 
    		}
    	} 
    	  
    	if($query->num_rows() > 0){    		
    		return $this->getDistanceAndTime($info, $query);
    	}

    	return null;
    }
    
    protected function getDistanceAndTime($info, $query){
    	$rows = array(); 
    	foreach($query->result() as $row) {
    		
    		$row->distance = $this->getDistance($info->zipcode, $row->postalCode);
    		$exp_date = strtotime(date('Y-m-d h:i:s', strtotime($row->expiration_date)));
    		$end_date = strtotime(date('Y-m-d h:i:s', strtotime($row->end_date)));
    			
    		$now = strtotime(date('Y-m-d h:i:s'));
    		if($now >= $exp_date || $now >= $end_date){
    		    $row->time_remaining = ' Expired';
    		}else{    
    		    
    		    $days = ($end_date - $now)  / 60 / 60 / 24;
    		    
    		    $hours = fmod($days, 1) * 24; 
    		    
    		    $minutes = fmod($hours, 1) * 60;
    		    
    		    $seconds = str_pad(floor(fmod($minutes, 1) * 60),1,0,STR_PAD_LEFT);
    		    
    		    $days = floor($days) > 0 ? floor($days).' Days ' : null;
    		    $hours = floor($hours).':'.str_pad(floor($minutes),1,0,STR_PAD_LEFT).':'.$seconds.' hrs';
    		    
    		    $row->time_remaining = '<div style="text-align:center;">Offer Expires In<br/>'.$days.$hours.'</div>';
    		}
    		
    		$rows[]=$row;
    	}
    	
    	return $rows;
    }
    
    public function getDealsByLocation($id = null) {  	
    	if(!is_null($id))
    	    $query = $this->db->get_where('deals', array('location_id' => $id));
    	else 
    	    $query = $this->db->get('deals');
    	    
    	if($query->num_rows() > 0)
    	    return $query->result(); 

    	return null;
    } 
    
    public function getDeals($id = null) {  	
    	$info = $this->grabGeoIP();
    	
    	$query = $this->db->query('select d.*, l.* from deals as d
    	                           join locations as l on d.location_id = l.id');   	
    	    
        if($query->num_rows() > 0){  
    		return $this->getDistanceAndTime($info, $query);
    	}

    	return null;
    } 
    
    public function getDealsByIp($limit = 3) {  
    	if(!$this->db)
            return null;
            
    	$info = $this->grabGeoIP();
    	
    	$query = $this->db->query("select d.*, l.* from deals as d 
                                   join locations as l on(l.id = d.location_id)
                                   where l.city = \"$info->city\" limit $limit;");
    	   
        if($query->num_rows() > 0){  
    	    return $data = $this->getDistanceAndTime($info, $query);
    	}
        
    	return null;
    } 
    
    public function getDealsByUserId($user_id = null) { 
    	if(is_null($user_id))
    	    $query = $this->db->query('select d.*, p.* from deals as d
    	    		                   join products as p using(product_id)
    	    		                  '); 
    	else {
    		$query = $this->db->query('select d.*, p.* from deals as d	
    				                   join products as p using(product_id)                           
    	                               where p.user_id = '.$user_id); 
    	}
    	    
    	$info = $this->grabGeoIP();
    	
    	if($query->num_rows() > 0){  
    		return $this->getDistanceAndTime($info, $query);
    	}

    	return null;
    }
    
    public function getDealById($dealid = null) { 	
    	if(!is_null($dealid))
    	    $query = $this->db->get_where('deals', array('dealid' => $dealid));
    	else 
    	    $query = $this->db->get('deals');
    	    
    	if($query->num_rows() > 0)
    	    return $query->result(); 

    	return null;
    }
    
    /* public function save($params) {
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
    } */
    
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
    
    public function updateImage($image_name, $dealid){
    	$this->db->where('dealid', $dealid);
        $this->db->update('deals', array('deal_image' => $image_name));
    }
}