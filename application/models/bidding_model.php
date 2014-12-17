<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class bidding_model extends abstract_model {

    protected $table = 'bidding';
    protected $primary_key = 'bidding_id';
    public $bidding_id;
    public $user_id;
    public $listing_id;
    public $bid_amount;
    public $created;
    
    function __construct() {
        parent::__construct();
    }
}