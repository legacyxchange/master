<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class user_addresses_model extends abstract_model {

    protected $table = 'user_addresses';
    protected $primary_key = 'user_addresses_id';
    public $user_addresses_id;
    public $user_id;
    public $companyname;
    public $firstName;
    public $lastName;
    public $addressLine1;
    public $addressLine2;
    public $city;
    public $state;
    public $postalcode;
    public $email;   
    public $phone;
    public $address_type_id;
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    }   
}