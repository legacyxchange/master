<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class stores_model extends abstract_model {

    protected $table = 'stores';
    protected $primary_key = 'store_id';
    public $store_id;
    public $user_id;
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    }
}