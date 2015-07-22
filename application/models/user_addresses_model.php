<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class user_addresses_model extends abstract_model {

    protected $table = 'user_addresses';
    protected $primary_key = 'user_address_id';
    public $user_address_id;
    public $user_id;    
    public $address_type_id;
    public $firstName;
    public $lastName;
    public $addressLine1;
    public $addressLine2;
    public $city;
    public $state;
    public $postalCode;
    public $email;   
    public $phone;    
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    } 

    public function save($where = null){ 
    	foreach($_POST as $key=>$val){
    		if (strstr ( $key, 'ShipTo' ) || strstr ( $key, 'ShipFrom' )) {
				if (strstr ( $key, 'ShipTo' )) {
					$_POST [str_replace ( 'ShipTo', '', $key )] = $val;
				unset ( $_POST [$key] );
				$_POST ['address_type_id'] = 3;
				}
				
				if (strstr ( $key, 'ShipFrom' )) {
					$_POST [str_replace ( 'ShipFrom', '', $key )] = $val;
				unset ( $_POST [$key] );
				$_POST ['address_type_id'] = 4;
				}				
			}
			if (strstr ( $key, 'Billing' )) {
				$_POST [str_replace ( 'Billing', '', $key )] = $val;
				unset ( $_POST [$key] );
				$_POST ['address_type_id'] = 2;
			}
    	}
    	//var_dump($_POST); exit;
    	return parent::save();
    }
}