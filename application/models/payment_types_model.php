<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class payment_types_model extends abstract_model {

    protected $table = 'payment_types';
    protected $primary_key = 'payment_type_id';
    public $payment_type_id;
    public $payment_type;
    
    function __construct() {
        parent::__construct();
    }
}