<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class listings_model extends abstract_model {

    protected $table = 'listings';
    protected $primary_key = 'listing_id';
    public $listing_id;
    public $product_id;
    public $start_time;
    public $end_time;
    public $recurring;
    public $buynow_price;
    public $reserve_price;
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    }
    
    public function setPostStartAndEndTimes(){
    	if(!empty($_POST['start_date']) && !empty($_POST['start_time']) && !empty($_POST['end_date']) && !empty($_POST['end_time'])){
    		$_POST['start_time'] = date("Y-m-d H:i:s", strtotime($_POST['start_date'].' '.$_POST['start_time']));
    		$_POST['end_time'] = date("Y-m-d H:i:s", strtotime($_POST['end_date'].' '.$_POST['end_time']));
    	}
    	return;	
    }
}