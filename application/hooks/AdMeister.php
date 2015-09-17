<?php 
require_once APPPATH.'models/ad_pages_model.php';

class AdMeister {
	private $db;
	private $CI;
	
	public function __construct(){ 
		$this->CI = & get_instance();
	}
	
	/**
	 * Todo: Add create new db table for each day
	 *       to make the data manageable.
	 */
	public function run(){ 
		if(!empty($_POST['advertisement_id'])){ //if and ad is clicked // not in use now
			//var_dump($_POST); exit;
			$this->chargeUserForClick();
		}
		$page = new ad_pages_model();
		//var_dump($page); exit;
		$this->db = $page->db;
		$pages = $page->fetchAll();
		
		$limit = 3; // for testing
		
		foreach($pages as $r){ 
			$patternPaginated = $r->ad_page.'/'.$limit.'/\d';
			
			if(stristr($_SERVER['REQUEST_URI'], $r->ad_page)){ // if match perfectly is a level 1 advertisement
				//var_dump($r->ad_page); exit;
				return $this->placeAds($r, 1);
			}elseif(preg_match("~^$patternPaginated$~", $_SERVER['REQUEST_URI'], $matches)){ //paginated pages get level 2 and higher charges
				$level = explode('/', $_SERVER['REQUEST_URI'])[4];
				return $this->placeAds($r, $level);
			}
		}
	}
	
	/**
	 * This function places the ads on the page on the fly and charges the views
	 * @param object $ad_page gstdev.ad_pages
	 */
	private function placeAds($ad_page, $level){
		require_once APPPATH."models/advertisements_model.php";
		require_once APPPATH."models/products_model.php";
		$ads = new advertisements_model();
	    $product = new products_model();
	    
		$limit = 6;
	    
		if($level > 1){ 
			$arr = array('where' => 'advertisement_id IS NOT NULL', 'orderby' => 'per_view_amount DESC, created ASC', 'limit' => $limit, 'offset' => ($limit * ($level-1)));
			
			$obj = $ads->fetchAll($arr);	
				
		}else{    
			$obj = $ads->fetchAll(array('orderby' => 'per_view_amount DESC, created ASC', 'limit' => $limit));			
		}

		foreach($obj as $ad){ 
			$ad->product = $product->fetchAll(array('where' => 'product_id = '.$ad->listing_id))[0];
			//$this->chargeUserForView($ad, $level); // not charging for views at this point
		}
		
		$body['advertisements'] = $obj;
		
		$this->CI->load->view('/listings/index', $body, true); 		
	}
	
	private function chargeUserForView($ad, $level){
		require_once APPPATH.'models/ad_metrics_model.php';
		$_POST['ad_page_location'] = $_SERVER['REQUEST_URI'];
		$_POST['advertisement_id'] = $ad->advertisement_id;
		$_POST['view'] = 1;
		$_POST['ad_link'] = $ad->link;
		$_POST['user_id'] = $ad->user_id;
		$_POST['click'] = 0;		
		$metrics = new ad_metrics_model();
		//var_dump($_POST); exit;
		$metrics->save(); 
	}
	
	private function chargeUserForClick(){
		require_once APPPATH.'models/ad_metrics_model.php';
		$metrics = new ad_metrics_model();
		
		$metrics->save();
	}
}