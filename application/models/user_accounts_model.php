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
    
    public function save(){
    	$user_account = $this->fetchAll(array('where' => 'user_id ='.$_POST['user_id']))[0];
    	
    	$_POST['user_account_id'] = $user_account->user_account_id;
    	$_POST['balance'] = $user_account->balance + $_POST['amount'];
    	//var_dump($_POST); exit;
        return parent::save();
    }
}