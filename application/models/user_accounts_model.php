<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class user_accounts_model extends abstract_model {

    protected $table = 'user_accounts';
    protected $primary_key = 'user_account_id';
    public $user_account_id;
    public $user_id;
    public $user_account_type_id;
    public $balance;
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    }
}