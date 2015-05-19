<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class user_addresses_model extends abstract_model {

    protected $table = 'user_addresses';
    protected $primary_key = 'user_address_id';
    public $user_address_id;
    public $user_id;    
    public $firstName;
    public $lastName;
    public $addressLine1;
    public $addressLine2;
    public $city;
    public $state;
    public $postalCode;
    public $email;   
    public $phone;
    public $address_type_id;
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    } 

    public function save($where = null){ 
    	
    	foreach($_POST as $key=>$val){
    		if (strstr ( $key, 'ShipTo' ) || strstr ( $key, 'ShipFrom' )) {
				if (strstr ( $key, 'ShipTo' )) {
					//echo $key . ' - ' . $val . ' | ';
					$p1 [str_replace ( 'ShipTo', '', $key )] = $val;
					unset ( $_POST [$key] );
					$p1 ['address_type_id'] = 3;
				}
				
				if (strstr ( $key, 'ShipFrom' )) {
					$p2 [str_replace ( 'ShipFrom', '', $key )] = $val;
					unset ( $_POST [$key] );
					$p2 ['address_type_id'] = 4;
				}
			}
    	}
    	//if(!array_key_exists('username', $_POST)){
    	foreach($p1 as $key => $val){
    		$_POST[$key] = $val;
    	} 
    	//var_dump($p1, $p2); exit;
    	//var_dump('Select * from user_addresses where user_id = '.$this->session->userdata['user_id'].' AND address_type_id = '.$p1['address_type_id']); exit;
    	//$query = $this->db->query('Select * from user_addresses where user_id = '.$this->session->userdata['user_id'].' AND address_type_id = 3');
    	//if ($query->result ()) {
				 //var_dump($p1, $p2); exit;
			if (! empty ( $p1 ['address_type_id'] )) {
				$good = parent::save ( 'user_id = ' . $this->session->userdata ['user_id'] . ' AND address_type_id = 3' );
				if(is_null($good)){
					$good = parent::save ();
				}
			} else {
				$good = parent::save ();
			}
			foreach ( $p2 as $key => $val ) {
				$_POST [$key] = $val;
			}
			if (! empty ( $p2 ['address_type_id'] )) {
				$good = parent::save ( 'user_id = ' . $this->session->userdata ['user_id'] . ' AND address_type_id = 4' );
				if(is_null($good)){
					$good = parent::save ();
				}
			} else {
				$good = parent::save ();
			}
			return $good; // bool
		//}else{
			//return null;
		//}
    }
}