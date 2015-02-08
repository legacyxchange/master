<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class bid_tracking_model extends abstract_model {

    protected $table = 'bid_tracking';
    protected $primary_key = 'bid_tracking_id';
    public $bid_tracking_id;
    public $user_id;
    public $listing_id;
    public $created;
    
    function __construct() {
        parent::__construct();
    }
}