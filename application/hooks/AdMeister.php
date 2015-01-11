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
		if(!empty($_POST['advertisement_id'])){
			$this->chargeUserForClick();
		}
		 
		$page = new ad_pages_model();
		
		$this->db = $page->db;
		$pages = $page->fetchAll();
		
		$limit = 4; // for testing
		
		foreach($pages as $r){
			$patternPaginated = $r->ad_page.'/'.$limit.'/\d';
			
			if($r->ad_page == $_SERVER['REQUEST_URI']){ // if match perfectly is a level 1 advertisement
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
		$ads = new advertisements_model();
	    
		$limit = 4;
	    
		if($level > 1){ 
			$arr = array('where' => 'advertisement_id IS NOT NULL', 'orderby' => 'per_view_amount DESC, created ASC', 'limit' => $limit, 'offset' => ($limit * ($level-1)));
			//$arr = array('orderby' => 'per_view_amount DESC, created ASC', 'limit' => $limit);
			$obj = $ads->fetchAll($arr);	
				
		}else{    
			$obj = $ads->fetchAll(array('orderby' => 'per_view_amount DESC, created ASC', 'limit' => $limit));			
		}
			
		$body['advertisements'] = $obj;
		foreach($obj as $res){ 
			$this->chargeUserForView($res, $level);
		}
		//var_dump('testing'); exit;
		//var_dump($body); exi	t;
		$this->CI->load->view('/listings/index', $body, true); 
		//$this->CI->load->view('/listings/index', $body, true); // insignificant, can be any valid view
	}
	
	private function chargeUserForView($ad, $level){
		require_once APPPATH.'models/ad_metrics_model.php';
		$_POST['ad_page_location'] = $_SERVER['REQUEST_URI'];
		$_POST['advertisement_id'] = $ad->advertisement_id;
		$_POST['view'] = 1;
		$_POST['ad_link'] = $ad->link;
		$_POST['user_id'] = $ad->user_id;
				
		$metrics = new ad_metrics_model();
		
		$metrics->save(); 
	}
	
	private function chargeUserForClick(){
		require_once APPPATH.'models/ad_metrics_model.php';
		$metrics = new ad_metrics_model();
		
		$metrics->save();
	}
}