<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class reviews_model extends abstract_model {

    public $id;
    public $location;
    public $userid;
    public $datestamp;
    public $name;
    public $email;
    public $comment;
    public $rating;
    public $autoImported;
    
    function __construct() {
        parent::__construct();
    }

    public function getReviewsByLocation($id = null) {  
    	if(!is_null($id))
    	    $query = $this->db->query('select lr.*, l.*, u.id, u.firstName, u.lastName, u.profileimg from locationReviews as lr
    	                              join locations as l on (l.id = lr.location)
    	                              join users as u on (lr.userid = u.id)
    	                              where l.id = '.$id
    	                              );
    	else 
    	    $query = $this->db->get('locationReviews');
    	    
    	$rows = array(); 
    	if($query->num_rows() > 0){
    	    foreach($query->result() as $row){     	    	
    	    	$row->created = $this->getCreatedHours($row->datestamp);   	    	  	    	    
    	    	$rows[]=$row;
    	    }
    	    return $rows;
    	}
    	return null;
    } 
    
    public function getReviewsByLocationId($id) {  
    	if(!is_null($id)){
    	    $query = $this->db->query('select l.*, lr.* from locationReviews as lr
    	                              join locations as l on (l.id = lr.location)    	                                 	                              
    	                              where l.id = '.$id
    	                              );
    	}else{ 
    	    $query = $this->db->get('locationReviews');
    	}
    	$rows = array(); 
    	if($query->num_rows() > 0){
    	    foreach($query->result() as $row){     	    	
    	    	$row->created = $this->getCreatedHours($row->datestamp);   	    	  	    	    
    	    	$rows[]=$row;
    	    }
    	    return $rows;
    	}

    	return null;
    } 
    
    protected function getCreatedHours($d){
    	$now = strtotime(date('Y-m-d H:i:s'));
    	$created = strtotime($d);
    	
    	$diff = $now - $created;
    	
    	return(date('h:i', $diff)); exit;
    }
    
    public function getReviews($limit = 3, $useGeo = true) {  	
    	$info = $this->grabGeoIP();
    	
    	if($useGeo == true){
    		$query = $this->db->query("select r.*, l.*, u.* from locationReviews as r 
                                   join locations as l on(l.id = r.location)
                                   join users as u on(r.userid = u.id)
                                   where r.comment IS NOT NULL
                                   and l.state = \"$info->state\" limit $limit;");
    	    $rows = array();   
    	    if($query->num_rows() > 0){  
    		    return $query->result();
    	    }else{
    		    $query = $this->db->query("select r.*, u.* from locationReviews as r  
    		                           join users as u on(u.id = r.userid)                                 
                                       where r.comment IS NOT NULL
                                       limit $limit;");
    		    return($query->result()); exit;
    	    }
    	}else{
    		$query = $this->db->query("select lr.*, l.* from locationReviews as lr  
    		                           join locations as l on(l.id = lr.location)                                 
                                       where lr.comment IS NOT NULL;");
    		
    		$rows = array(); 
    		if($query->num_rows() > 0){
    	    	foreach($query->result() as $row){     	    	
    	    		$row->created = $this->getCreatedHours($row->datestamp);   	    	  	    	    
    	    		$rows[]=$row;
    	    	}
    	    	return $rows;
    		}
    	}

    	return null;
    } 
    
    public function getMyReviews($userid) {  	
    	$query = $this->db->query("select r.*, l.*, u.profileimg from locationReviews as r 
                                   join locations as l on(l.id = r.location)
                                   join users as u on(r.userid = u.id)
                                   where r.comment IS NOT NULL
                                   and u.id = $userid;");
    	if($query->num_rows() > 0){  
    		var_dump($query->result()); exit;
    	}
    	
    	return null;
    } 
    
    public function save($params) {
    	$params = $this->cleanseParams($params);
    	
    	if(!empty($params['location_id'])) {
    		$reviews = $this->getReviewsByLocationId($params['location_id']);
    	
    		if(count($reviews) > 0){
    	    	$this->db->where('id', $params['location_id']);
            	$this->db->update('locationReviews', $params);
    		}
    	}
    	else {
    		$this->db->insert('locationReviews', $params);
    	}
    	
    	return true;
    }
}