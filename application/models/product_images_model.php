<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class product_images_model extends abstract_model {

    protected $table = 'product_images';
    protected $primary_key = 'product_image_id';
    public $product_image_id;
    public $product_id;
    public $product_image;
    public $order_index;
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    }
}