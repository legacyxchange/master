<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class products_model extends abstract_model {

    protected $table = 'products';
    protected $primary_key = 'product_id';
    public $product_id;
    public $product_type_id;
    public $user_id;
    public $name;
    public $description;
    public $short_description;
    public $cost;
    public $retail_price;
    public $active;
    public $brand;
    public $model;
    public $sku;
    public $image;
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    }
}