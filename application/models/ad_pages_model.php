<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class ad_pages_model extends abstract_model {

    protected $table = 'ad_pages';
    protected $primary_key = 'ad_pages_id';
    public $ad_page;
    public $level;
    
    function __construct() {
        parent::__construct();
    }
}