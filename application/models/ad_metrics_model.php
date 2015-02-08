<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class ad_metrics_model extends abstract_model {

    protected $table = 'ad_metrics';
    protected $primary_key = 'ad_metrics_id';
    public $ad_metrics_id;
    public $advertisement_id;
    public $view;
    public $click;
    public $ad_page_location;
    public $user_id;
    public $created;
    
    function __construct() {
        parent::__construct();
    }
}