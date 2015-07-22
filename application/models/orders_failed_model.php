<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class orders_failed_model extends abstract_model {

    protected $table = 'orders_failed';
    protected $primary_key = 'order_id';
    protected $foreign_key = array('user_id', 'product_id', 'payment_type_id');
    
    public $order_id;
    public $user_id;
    public $product_id; // 999 if add_funds
    public $transaction_id; // authorize.net or null
    public $authorization_code; // authorize.net or null
    public $status;
    public $payment_type_id;
    public $amount;
    public $notes;    
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    }
}