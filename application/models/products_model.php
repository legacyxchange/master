<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class products_model extends abstract_model {

    protected $table = 'products';
    protected $primary_key = 'product_id';
    public $product_id;
    public $product_type_id;
    public $product_condition_type_id;
    public $user_id;
    public $name;
    public $description;
    public $details;
    public $weight;
    public $cost;
    public $retail_price;
    public $quantity;
    public $active;
    public $model;
    public $legacy_number;
    public $original_passcode; // if original product else null
    public $image;
    public $keywords;
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    }
}