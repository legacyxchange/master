<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class products_model extends abstract_model {

    protected $table = 'products';
    protected $primary_key = 'product_id';
    public $product_id;
    public $product_type_id;
    public $product_condition_type_id;
    public $user_id;
    public $name;
    public $description;
    public $details;
    public $weight;
    public $cost;
    public $retail_price;
    public $quantity;
    public $active;
    public $model;
    public $legacy_number;
    public $original_passcode; // if original product else null
    public $image;
    public $keywords;
    public $created;
    public $modified;
    
    function __construct() {
        parent::__construct();
    }
    
    //$productType = sortby
    public function getProductsByUserId($user_id, $productTypeId = 1){
    	return $this->db->from('products')
    	                ->join('listings', 'listings.product_id = products.product_id')
    	                ->where('user_id = '.$user_id.' AND products.product_type_id = "'.$productTypeId.'"')->get()->result();
    }
    
    public function getProductListingObject($product_id){
    	$product = $this->fetchAll(array('where' => 'product_id = '.$product_id));
    	foreach($product as $p){
    		$p->images = $this->product_images->fetchAll(array('where' => 'product_id = '.$p->product_id));
    		$p->listing = $this->listings->fetchAll(array('where' => 'product_id = '.$p->product_id))[0];
    		$p->advertisements = $this->advertisements->fetchAll(array('where' => 'listing_id = '.$p->listing->listing_id));
    	}
    	return $product;
    }
}