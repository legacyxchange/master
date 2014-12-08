<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class timer_model extends abstract_model {

    protected $table = 'timer';
    protected $primary_key = 'timer_id';
    public $listing_id;
    public $product_id;
    public $start_time;
    public $end_time;
    public $recurring;
    public $buynow_price;
    public $reserve_price;
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    }
}