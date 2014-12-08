<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    function Test() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('test_model', 'test', true);
        $this->load->model('listings_model', 'listing', true);
        $this->load->model('products_model', 'product', true);
        $this->load->helper('form');
        $this->load->helper('url');
    }
    
    // user that is not logged in will be redirected to this function
    public function index($location_id = 2296){
    	
    	try {
            $deals = $this->test->fetchAll(
            	array(
                	'where' => 'location_id = '.$location_id.' and featured = 1',
            		'join' => 'locations as l',
            		'on' => 'l.id = deals.location_id'
            	)
            );
            var_dump($deals); exit;
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }  
    }
    
    public function phpinfo(){
    	phpinfo();
    }
    
    public function sphinx(){
    	$this->load->file('/var/www/html/application/vendor/sphinxapi.php', true);
    	$cl = new SphinxClient();
    	$cl->SetServer( "localhost", 9312 );
    	//var_dump($cl);
    	$cl->SetMatchMode( SPH_MATCH_EXTENDED  );
        $cl->SetRankingMode ( SPH_RANK_SPH04 );

        $q = $_REQUEST['q']; 
        
        $searchresults = $cl->Query($q , 'my_new_search_index' );
        
        if(!empty($searchresults['matches'])){
        	
        	foreach($searchresults['matches'] as $key=>$val){
        		$iStr .= $key.', ';
        	}
            $iStr = trim($iStr,', ');
        
            $res = $this->listing->fetchAll(array('where' => 'product_id IN('.$iStr.')')); 
            foreach($res as $r){
            	$r->product = $this->product->fetchAll(array('where' => 'product_id = '.$r->product_id));
            }
            
            var_dump($res);
        }
        echo $cl->GetLastError();
        exit;
    }
}