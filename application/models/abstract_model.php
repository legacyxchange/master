<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

abstract class abstract_model extends CI_Model {
    
    public function fetchAll(array $preds = null){
    	if(!empty($preds['where']))
    		$this->db->where($preds['where']);
    	if(!empty($preds['join']) && !empty($preds['on']))
    		$this->db->join($preds['join'], $preds['on']);
    	if(!empty($preds['orderby'])){    		
    		$this->db->order_by($preds['orderby']);
    	}
    	if(!empty($preds['limit'])) {
    		$this->db->limit($preds['limit']);
    	}
    	if(!empty($preds['offset'])) {
    		$this->db->offset($preds['offset']);
    	}
    		  		
    	$this->db->from($this->table);
    	
    	$query = $this->db->get();
    	
    	/* if($preds['orderby'] == 'per_view_amount DESC, created ASC'){
    		var_dump($this->db->last_query()); exit;
   	 	} */
    	//file_put_contents('/var/www/html/public/logs/abstract.txt', "\n\n".$this->db->last_query(), FILE_APPEND);
    	
    	return $query->result();
    }
    
    public function countAll($where = null){
    	if(!is_null($where)){
    		$this->db->where($where);
    	}
    	return $this->db->get($this->table)->num_rows;
    }
    
    public function test(){
    	var_dump($this->cleanseParams($_POST), $this); exit;
    }
    
    public function save($where = null) {
    	
    	$params = $this->cleanseParams($_POST);
    	
    	if(!empty($where)) {
    		$data = $this->fetchAll(array('where' => $where));
    		
    		if(count($data) > 0){
    			$this->db->where($where);
    			$this->db->update($this->table, $params);
    			//echo $this->db->last_query(); exit; // write to log file or db 
    		}
    	}
    	else {    		
    		if(!empty($params[$this->primary_key]))
    			unset($params[$this->primary_key]);

    		$this->db->insert($this->table, $params);
    	}
        
    	//echo $this->db->last_query(); 
    	//file_put_contents('/var/www/html/public/logs/abstract.txt', "\n\n".$this->db->last_query(), FILE_APPEND);
    	return $this->db->insert_id();
    }
    
    public function delete($key, $id){
    	if(!$id){
    		$this->session->set_flashdata('FAILURE', 'You must supply a primary key when attempting to delete an item.');
    		return false;
    	}else{
    		$this->db->where($key, $id);
   			$this->db->delete($this->table); 
    	}
    	return $id;
    }
    
    protected function cleanseParams($params) {
    	
    	foreach($params as $key=>$val) {    		
    		if(!property_exists($this, $key)){    			
    			unset($params[$key]);
    		}elseif($params[$key] == ''){    			
    			$params[$key] = null;
    		}else{   			
    			$params[$key] = htmlentities($val, ENT_QUOTES); 
    		}
    	}
    	
    	return $params;
    }
    
    public function grabGeoIP()
    {
    	$user_ip = !empty($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '127.0.0.1' ? $_SERVER['REMOTE_ADDR'] : '172.56.15.13';
    
    	if(is_null($user_ip)){
    		$obj = new stdClass();
    		$obj->ip = '199.241.138.201';
    		$obj->country_code = 'US';
    		$obj->country_name = "United States";
    		$obj->region_code = 'NV';
    		$obj->region_name = 'Nevada';
    		$obj->city = 'Las Vegas';
    		$obj->latitude = '36.216971';
    		$obj->longitude = '-115.274276';
    		$obj->metro_code = '518';
    		$obj->area_code = '702';
    		return $obj;
    	}
    	 
    	$url1 = 'http://freegeoip.net/json/' . $user_ip;
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url1);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	$result = curl_exec($ch);
    
    	if ($result)
    	{
    		return json_decode($result);
    		curl_close($ch);
    	}
    	else
    	{
    		$url = 'http://www.telize.com/geoip/' . $user_ip;
    		curl_setopt($ch, CURLOPT_URL, $url);
    		$result = curl_exec($ch);
    		curl_close($ch);
    		if(!$result){
    			var_dump('NOT CONNECTING TO '.$url1.' or '.$url	); exit;
    		}
    		return json_decode($result);
    	}
    }
    
    public function mapQuestGeoCode($address)
    {
    	$key = 'Fmjtd%7Cluur2h0rnq%2C8g%3Do5-9wblhu';
    	$address = urlencode($address);
    	$json = substr(file_get_contents('http://open.mapquestapi.com/geocoding/v1/address?key=' . $key . '&location=' . $address . '&callback=renderGeocode&outFormat=json'), 14, -2);
    	$json = json_decode($json);
    
    	$lat = isset($json->results[0]->locations[0]->latLng->lat) ? $json->results[0]->locations[0]->latLng->lat : false;
    	$lng = isset($json->results[0]->locations[0]->latLng->lng) ? $json->results[0]->locations[0]->latLng->lng : false;
    	return ($lat && $lng) ? array('lat' => $lat, 'lng' => $lng) : false;
    }
    
    public function getDistance($address1, $address2){
    	 
    	$key = 'Fmjtd%7Cluur2h0rnq%2C8g%3Do5-9wblhu';
    	$str = json_encode(array('locations' => array(urlencode($address1), urlencode($address2)), 'options' => array('allToAll' => false)));
    	$url = 'http://www.mapquestapi.com/directions/v2/routematrix?key='.$key.'&outFormat=json&json='.$str;
    	$ch = curl_init();
    
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_POST, false);
    
    	$results = curl_exec($ch);
    	return(json_decode($results)->distance[1]);
    }
}