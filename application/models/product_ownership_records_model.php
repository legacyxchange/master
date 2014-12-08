<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class product_ownership_records_model extends abstract_model {

    protected $table = 'product_ownership_records';
    protected $primary_key = 'product_ownership_record_id';
    public $product_ownership_record_id;
    public $product_id;
    public $userid; // owner 
    public $transfered;
    
    function __construct() {
        parent::__construct();
    }
}