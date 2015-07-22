<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class product_videos_model extends abstract_model {

    protected $table = 'product_videos';
    protected $primary_key = 'product_video_id';
    public $product_video_id;
    public $product_id;
    public $product_video;
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    }
}