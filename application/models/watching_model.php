<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class watching_model extends abstract_model {

    protected $table = 'watching';
    protected $primary_key = 'watching_id';
    public $watching_id;
    public $user_id;
    public $listing_id;
    public $active;
    public $created;
    
    function __construct() {
        parent::__construct();
    }
}		