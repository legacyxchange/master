<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class product_condition_types_model extends abstract_model {

    protected $table = 'product_condition_types';
    protected $primary_key = 'product_condition_type_id';
    public $products_condition_type_id;
    public $products_condition_type;    
    
    function __construct() {
        parent::__construct();
    }
}