<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class purchases_model extends abstract_model {

    protected $table = 'purchases';
    protected $primary_key = 'purchase_id';
    public $purchase_id;
    public $user_id;
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    }
}