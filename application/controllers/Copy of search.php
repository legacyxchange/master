<?php 
//testswt
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends CI_Controller {

    function Search() { 
        parent::__construct(); 

        $this->load->driver('cache');
        $this->load->model('search_model', 'search', true);      
        $this->load->model('user_model', 'user', true);         
        $this->load->model('products_model', 'product', true);
        $this->load->model('product_types_model', 'product_type', true);
        $this->load->model('listings_model', 'listing', true);
    }

    public function index($word = null, $location = null) {    	
    	if(!empty($_POST['q'])){
    	    $q = $_POST['q'];
    	    
    	    $header['q'] = $q;
    	    
    		$this->load->file('application/vendor/sphinxapi.php', true);
    		
    		$cl = new SphinxClient(); 
    		
    		$cl->SetServer( "localhost", 9312 );
    		
    		$cl->SetMatchMode( SPH_MATCH_ANY  );
    		
        	$cl->SetRankingMode ( SPH_SORT_RELEVANCE );

        	$searchresults = $cl->Query($q, 'ads');
        	//var_dump($q, $cl->getLastError(), $searchresults['matches']); exit;
            $iStr = null;
            
        	if(!empty($searchresults['matches'])){ 
        	    
        		foreach($searchresults['matches'] as $key=>$val){
        			$lid = $val['attrs']['listing_id'];
        			$iStr .= $lid.', ';
        		}
        		
            	$iStr = ' and listing_id in('.trim($iStr,', ').')';
            }
            else{
            	$iStr = 'no matches';
            }
            
    	}else{
    		$iStr = '';
    	}
    	
        $header['headscript'] = $this->functions->jsScript('search.js welcome.js timer.js');
        
        if($iStr !== 'no matches'){ 
        	$query = $this->db->query('SELECT * from listings join products using(product_id) where start_time <= NOW() AND end_time >= NOW()'.$iStr.' order by end_time ASC LIMIT 4');
        	$listings = $query->result();      
        } 
        //var_dump($listings[1]); exit;
        $body['stores'] = $this->getStores(); 
                          
        $body['flash_listings'] = $this->getFlashListings();
        
        $body['listings'] = $listings;
        
        $body['left_menu'] = $this->load->view('partials/left_menu', $body, true);
        $this->load->view('template/header', $header);
        $this->load->view('search/index', $body);
        $this->load->view('template/footer');
    }
    
    public function getdescription(){
    	
    	if($this->input->post('product_id')){
            //$this->functions->dump($this->input->post()); exit;
            $product = $this->product->fetchAll(array('product_id = '.$this->input->post('product_id')))[0];
            
            if($product){
            	$desc = html_entity_decode($product->description);
            	echo json_encode(array('status' => 'SUCCESS', 'results' => $desc));
            	exit;
            }
    	}
    }
    
    public function getprice(){
    	
    	if(($listing_id = $this->input->post('listing_id'))){
    		$this->db->select('*');
    		$this->db->from('listings l');
    		$this->db->join('products p', 'p.product_id = l.product_id');
    		$this->db->join('flash_sale_listings fsl', 'fsl.listing_id = l.listing_id');
    		$this->db->where('l.listing_id = '.$listing_id);
    		
    		$listing = $this->db->get()->result()[0];
    		//echo $this->db->last_query(); exit;
    		if($listing){
    			$message = $this->formatPrice($listing);
    			echo json_encode(array('status' => 'SUCCESS', 'message' => $message));
    			exit;
    		}
    	}
    }
    
    public function getChat(){
    	
    }
    
    public function getMoreImages(){
    	
    }
    
    public function getReviews(){
    	
    }
    
    public function purchaseItem(){
    	
    }
    
    public function getvideo(){
    	 
    	if(($listing_id = $this->input->post('listing_id'))){
    		$this->db->select('*');
    		$this->db->from('listings l');
    		$this->db->join('products p', 'p.product_id = l.product_id');
    		$this->db->join('flash_sale_listings fsl', 'fsl.listing_id = l.listing_id');
    		$this->db->where('l.listing_id = '.$listing_id);
    
    		$listing = $this->db->get()->result()[0];
    		//echo $this->db->last_query(); exit;
    		if($listing){
    			$message = $this->formatPrice($listing);
    			echo json_encode(array('status' => 'SUCCESS', 'message' => $message));
    			exit;
    		}
    	}
    }
    
    private function formatPrice($listing){
    	$out = '<div id="desc<?php echo $key+1;?>">';
    	$save = $listing->retail_price - $listing->sale_price;
    	$out .= '<div style="height:100px;">';
    	$out .= '<div style="font-weight: bold;">';								
    	$out .= 'WAS:&nbsp;&nbsp; <span style="">$'.number_format($listing->retail_price,2).'</span>';
    	$out .= '</div>';
    	$out .= '<div style="font-weight: bold; text-align:left;">';
    	$out .= 'NOW: <span style="color: #000;">$'.number_format($listing->sale_price,2).'</span>';
    	$out .= '</div>';
    	$out .= '<div class="save">';
    	$out .= '<i style="color: #ff0000;">SAVE: $'.number_format($save,2).'</i>';
    	$out .= '</div>
    	</div>
    	</div>';
    	return $out;
    }
    
    protected function getStores($limit = 6){
    	$query = $this->db->query('
        		select * from locations as l join locationimages as li on l.id = li.locationid group by l.id order by l.id DESC limit '.$limit.';
        ');
    	if(count($query->result()) > 0){
    		$stores = array();
    		foreach($query->result() as $key=>$store){
    			$stores []= $store;
    		}
    	}else{
    		$stores = 'Sorry...There are no Stores Available.';
    	}
    	
    	return $stores;
    }
    
    protected function getFlashListings($limit = 4){
    	$query = $this->db->query('
        		select * from flash_sale_listings as fsl
				join listings as l using(listing_id)
				join products as p using(product_id)
				where NOW() BETWEEN l.start_time AND l.end_time limit '.$limit.';
        ');
    	
    	if(count($query->result()) > 0){
    		$flash_listings = array();
    		foreach($query->result() as $key=>$flash_listing){
    			$flash_listings []= $flash_listing;
    		}
    	}else{
    		$flash_listings = 'Sorry...There are no Flash Sales Today.';
    	}
    	
    	return $flash_listings;
    }
    
    /* public function search_keywords(){
    	$partialWord = 'foo';
    	
    	$query = $this->db->query('select l.keywords, p.description from listings as l join products as p using(product_id)');
    	
    	foreach($query->result() as $r){ var_dump(explode(' ', $r->description)); exit;var_dump($this->getWords($partialWord, $r->description)); exit;
    		if(!is_null($r->keywords))
    			$words []= $this->getWords($partialWord, $r->keywords, ',');  		
    	}
    	
    	
    	var_dump(array_unique($words));	
    	exit;
    }
    
    private function getWords($pWord, $words, $delimiter = ' '){
    	
    	
    		$array = explode($delimiter,$words);
    		$a = array_unique($array);
    		
    		foreach($a as $keyword){
    			if(stristr($keyword, $pWord))
    				return $keyword;
    		}
    	
    
    }
    
    public function ajax_timer($listing_id){
    	$listings = $this->listing->fetchAll(array('where' => 'listing_id = '.$listing_id));
    	
    	foreach($listings as $listing){
    		$_seconds = (strtotime($listing->end_time) - time());
    		 
    		$days = $_seconds / 3600 / 24;
    		 
    		$listing->days = floor($_seconds / 3600 / 24);
    		
    		$hours = ($days - $listing->days) * 24 - 2;
    		 
    		$listing->hours = floor(($days - $listing->days) * 24 - 2);
    		
    		$minutes = ($hours - $listing->hours) * 60;
    		 
    		$listing->minutes = floor(($hours - $listing->hours) * 60);
    		
    		$seconds = ($minutes - $listing->minutes) * 60;
    		 
    		$listing->seconds = floor(($minutes - $listing->minutes) * 60);
    	}
    	
    	if($listing->days == 0  && $listing->hours == 0 && $listing->minutes == 0 && $listing->seconds < 1){
    		$this->expireListing($listing_id);
    		echo 'Time Left: Expired!'; exit;
    	}
    	if($listing->days < 2) { $_days = 'day'; } else { $_days = 'days'; }
    	$days = $listing->days > 0 ? $listing->days.' '.$_days.' ' : null;
    	echo 'Time Left: '.$days.' '.str_pad($listing->hours, 2, 0, STR_PAD_LEFT).':'.str_pad($listing->minutes, 2, 0, STR_PAD_LEFT).':'.str_pad($listing->seconds, 2, 0, STR_PAD_LEFT);
    	exit;
    } 
    */
}