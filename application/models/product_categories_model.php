<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class product_categories_model extends abstract_model {

    protected $table = 'product_categories';
    protected $primary_key = 'product_category_id';
    protected $foreign_key = array('product_id', 'category_id');
    public $product_category_id;  
    public $category_id;
    public $product_id; 
    
    function __construct() {
        parent::__construct();
    }
}