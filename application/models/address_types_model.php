<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class address_types_model extends abstract_model {

    protected $table = 'address_types';
    protected $primary_key = 'adress_type_id';
    public $address_type_id;
    public $address_type;
    
    function __construct() {
        parent::__construct();
    }
}