<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class advertisements_model extends abstract_model {

    protected $table = 'advertisements';
    protected $primary_key = 'advertisement_id';
    public $advertisement_id;
    public $user_id;
    public $title;
    public $description;
    public $link; 
    public $per_click_amount;
    public $per_view_amount;
    public $total_amount;
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    }
}