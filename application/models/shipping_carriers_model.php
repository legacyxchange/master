<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class shipping_carriers_model extends abstract_model {

    protected $table = 'shipping_carriers';
    protected $primary_key = 'shipping_carrier_id';
    public $shipping_carrier_id;
    public $shipping_carrier;
    
    function __construct() {
        parent::__construct();
    }
}