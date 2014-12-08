<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class locations_model extends abstract_model {

	protected $table = 'locations';
    public $id;
    public $dispensaryid;
    public $datestamp;
    public $createdBy;
    public $company;
    public $storeID;
    public $name;
    public $address;
    public $address2;
    public $address3;
    public $city;
    public $state;
    public $postalCode;
    public $territory;
    public $openDate;
    public $deleted;
    public $deletedBy;
    public $deleteDate;
    public $rent;
    public $utilities;
    public $description;
    public $addDescription;
    public $phone;
    public $fax;
    public $websiteUrl;
    public $email;
    public $lat;
    public $lng;
    public $salesTax;
    public $googleID;
    public $googleReference;
    public $formattedAddress;
    public $googleHTMLAddress;
    public $active;
    public $allowUpdate;
    public $lastUpdate;
    
    function __construct() {
        parent::__construct();
    }

    public function getLocationById($id = null) { 
    	if(is_null($id) || !is_numeric($id))
    	    return null;
    	     
    	$info = $this->grabGeoIP();
    	
    	if(!is_null($id))
    	    $query = $this->db->query('select * from locations as l 
    	                              where l.id = '.$id
    	                              );
    	
    	if($query->num_rows() > 0)
    	{
    		$rows = array(); 
    	    foreach($query->result() as $row) {
    			$row->distance = $this->getDistance($info->zipcode, $row->postalCode);
    			  		
    			$rows[]=$row;
    		} 
    		return $rows;   	
    	}
    	return null;
    } 
    
    public function getLocations() {  
    	
    	$query = $this->db->query('select * from locations');
    	
    	if($query->num_rows() > 0)
    	    return( $query->result() ); 

    	return null;
    } 
    
    public function getMyLocations($userid) {  	
    	$query = $this->db->query("select r.*, l.*, u.profileimg from locationReviews as r 
                                   join locations as l on(l.id = r.location)
                                   join users as u on(r.userid = u.id)
                                   where r.comment IS NOT NULL
                                   and u.id = $userid;");
    	if($query->num_rows() > 0){  
    		var_dump($query->result()); 
    	}
    	
    	return null;
    } 
    
    public function save($params) {
    	$params = $this->cleanseParams($params);
    	
    	if(!empty($params['id'])) {
    		$deals = $this->getLocationById($params['id']);
    	
    		if(count($deals) > 0){
    	    	$this->db->where('id', $params['id']);
            	$this->db->update('locations', $params);
    		}
    	}
    	else {
    		$this->db->insert('locations', $params);
    	}
    	
    	return true;
    }
}