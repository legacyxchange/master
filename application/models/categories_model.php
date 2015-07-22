<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class categories_model extends abstract_model {

    protected $table = 'categories';
    protected $primary_key = 'category_id';
    public $category_name;   
    
    function __construct() {
        parent::__construct();
    }
}