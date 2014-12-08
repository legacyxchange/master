<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class product_types_model extends abstract_model {

    protected $table = 'product_types';
    protected $primary_key = 'product_type_id';
    public $product_type;
    
    function __construct() {
        parent::__construct();
    }
}