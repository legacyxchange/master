<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class shipping_types_model extends abstract_model {

    protected $table = 'shipping_types';
    protected $primary_key = 'shipping_type_id';
    public $shipping_type_id;
    public $shipping_type;
    
    function __construct() {
        parent::__construct();
    }
}