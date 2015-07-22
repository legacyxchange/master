<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class shipping_model extends abstract_model {

    protected $table = 'shipping';
    protected $primary_key = 'shipping_id';
    public $shipping_id;
    public $order_id;
    public $shipping_type_id;
    public $shipping_carrier_id;
    public $shipping_fee;
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    }
}