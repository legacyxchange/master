<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class orders_model extends abstract_model {

    protected $table = 'orders';
    protected $primary_key = 'order_id';
    public $order_id;
    public $user_id;
    public $status;
    public $payment_type_id;
    public $user_id;
    public $notes;
    
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    }
}