<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class sales_model extends abstract_model {

    protected $table = 'sales';
    protected $primary_key = 'sale_id';
    public $sale_id;
    public $user_id;
    public $soldto_user_id;
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    }
}