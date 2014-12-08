<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class chat_model extends abstract_model {

    protected $table = 'chat';
    protected $primary_key = 'chat_id';
    public $chat_id;
    public $user_id;
    public $username;
    public $message;
    public $created;
    
    function __construct() {
        parent::__construct();
    }
}