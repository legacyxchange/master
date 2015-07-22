<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class listing_types_model extends abstract_model {

    protected $table = 'listing_types';
    protected $primary_key = 'listing_type_id';
    public $listing_type_id;
    public $listing_type;    
    
    function __construct() {
        parent::__construct();
    }
}