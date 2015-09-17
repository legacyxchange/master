<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class vtracker_model extends abstract_model {

    protected $table = 'vtracker';
    protected $primary_key = 'vtracker_id';
    
    public $vtracker_id;
    public $ip_address;
    public $session_count;
    public $session;
    public $referrer;
    public $user_id;
    public $created;
    
    function __construct() {
        parent::__construct();
    }
}