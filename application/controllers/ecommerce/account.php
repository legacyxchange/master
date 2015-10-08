<?php
error_reporting(E_ALL & ~E_NOTICE);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account extends CI_Controller {

    function Account() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('user_model', 'user', true);
        $this->load->model('user_accounts_model', 'user_accounts', true);
        $this->load->model('orders_model', 'orders', true);
        $this->load->model('products_model', 'products', true);
        $this->load->model('dashboard_model', 'dashboard', true);
        $this->load->model('listings_model', 'listings', true);
        $this->load->model('bidding_model', 'bidding', true);
        $this->load->model('notifications_model', 'notifications', true);
        $this->load->model('watching_model', 'watching', true);
        $this->load->model('advertisements_model', 'advertisements', true);
        $this->load->model('ad_metrics_model', 'ad_metrics', true);
        $this->functions->checkLoggedIn();
    }
    
	public function index() {
		$data['title'] = 'My Account';
        $header['headscript'] = $this->functions->jsScript('notifications.js');
        $menu['menu_account'] = 1;
        $data['account_type'] = 'Individual';
        $user_id = $this->session->userdata['user_id'];
        
        $data['user'] = $this->user->fetchAll(array('where' => 'user_id = '.$user_id))[0];
        
        $query = $products = $this->db->query('select count(distinct listing_id) as bid_count from bidding join listings using(listing_id) join products using(product_id) where products.user_id = '.$this->session->userdata('user_id'));
        $data['bid_count'] = $query->result()[0]->bid_count;
        
        $data['products'] = $products = $this->products->fetchAll(array('where' => 'user_id = '.$this->session->userdata('user_id')));
        $data['listings'] = $listings = $this->listings->fetchAll(array('join' => 'products', 'on' => 'products.product_id = listings.product_id', 'where' => 'products.user_id = '.$this->session->userdata('user_id')));
        $data['notifications'] = $notifications = $this->notifications->fetchAll(array('where' => 'user_id = '.$this->session->userdata('user_id').' AND status=1'));
        $data['watching'] = $watching = $this->watching->fetchAll(array('where' => 'user_id = '.$this->session->userdata('user_id')));
        $data['user_account'] = $this->user_accounts->fetchAll(array('where' => 'user_id = '.$this->session->userdata['user_id']))[0];
        $data['orders'] = $orders = $this->orders->fetchAll(array('where' => 'user_id = '.$user_id));
        $ts_orders = $this->orders->fetchAll(array('where' => 'user_id = '.$user_id.' order by amount DESC LIMIT 5'));
        foreach($ts_orders as $o){
        	$query = $this->db->query('select * from order_products where order_id = '.$o->order_id);
        	$o->order_products = $query->result();
        	foreach($o->order_products as $op){
        		$query = $this->db->query('select * from products where product_id = '.$op->product_id);
        		$o->products []= $query->result()[0];
        	}
        }
        
        $data['topsellers'] = $ts_orders;
        $data['num_visitors'] = 234;
        $data['pending_shipments'] = $this->orders->fetchAll(array('where' => 'user_id = '.$user_id.' AND status < 2'));
        
        $data['admin_menu'] = $this->load->view('admin/ecommerce/template/menu', $menu, true);
        $this->layout->load('admin/ecommerce/index', $data, 'ecommerce');
    }
    
	public function getrevenuepanel($interval = 'monthly', $month = null){
		
		$user_id = $this->session->userdata('user_id');
    	if($interval == 'monthly'){
    		$amount = array();  
    		$revenue = array();
    		for($i = 1; $i <= 12; $i++){	    		 
    			$mo = str_pad($i, 2, 0, STR_PAD_LEFT);   			
    			$ad_metrics = $this->ad_metrics->fetchAll(array('where' => 'user_id = '.$user_id.' AND created LIKE ("2015-'.$mo.'-%")'));    			
    			$am = 0;    			
    			foreach($ad_metrics as $adm){ 
    				$adm->advertisement = $this->advertisements->fetchAll(array('where' => 'user_id = '.$user_id.' AND advertisement_id = '.$adm->advertisement_id))[0];
    				//var_dump($adm->click, $adm->advertisement->per_click_amount); exit;    				
    				if($adm->click > 0){
    					$am = $am + $adm->advertisement->per_click_amount;    					
    				}if($adm->view > 0){
    					$am = $am + $adm->advertisement->per_view_amount;
    				}    				
    			} 
    			//if($i == 3){var_dump($ad_metrics, $this->db->last_query()); exit;}
    			array_push($amount, $am); // amount for this period  
    			$query = $this->db->query('select sum(amount) as sum_amount from orders where user_id = '.$user_id.' AND created LIKE("2015-'.$mo.'-%") group by user_id');
    			//var_dump($query->result(), $this->db->last_query()); 
    			array_push($revenue, (int)$query->result()[0]->sum_amount);
    			$query = $this->db->query('SELECT count(*) as c FROM listings join products using (product_id) where products.user_id = '.$user_id.' AND listings.created LIKE("2015-'.$mo.'-%") group by user_id');
    			$listings_counts[] = (int)$query->result()[0]->c;
    		}
    		  
    		$data['listings_count'] = json_encode($listings_counts);    		
    		$data['datacosts'] = json_encode($amount);    		
    		$data['categories'] = json_encode(array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'));
    		$data['interval'] = 'monthly';
    		$data['revenue_heading'] = date('Y');  
    		$data['datarevenue'] = json_encode($revenue);
    	}
    	elseif($interval == 'daily'){
    		$listing_counts = array();
    		$cats = array();
    		$amount = array();
    		$month = is_null($month) ? date('m') : $month;
    		$month = str_pad($month, 2, 0, STR_PAD_LEFT);
    		$revenue = array();
    		$daysThisMonth = cal_days_in_month(CAL_GREGORIAN, $month, 2003);
    		for($i = 1; $i <= $daysThisMonth; $i++){
    			$d = str_pad($i, 2, 0, STR_PAD_LEFT);
    			$ad_metrics = $this->ad_metrics->fetchAll(array('where' => 'user_id = '.$user_id.' AND created LIKE ("2015-'.$month.'-'.$d.'%")'));
    			//var_dump($this->db->last_query());
    			array_push($cats, $i);			
    			$am = 0; 			
    			foreach($ad_metrics as $adm){ 
    				$adm->advertisement = $this->advertisements->fetchAll(array('where' => 'user_id = '.$user_id.' AND advertisement_id = '.$adm->advertisement_id))[0];
    				//var_dump($adm->click, $adm->advertisement->per_click_amount, $this->db->last_query()); exit;
    				if($adm->click > 0){
    					$am = $am + $adm->advertisement->per_click_amount;   					
    				}if($adm->view > 0){
    					$am = $am + $adm->advertisement->per_view_amount;
    				}  				
    			}    			
    			array_push($amount, $am); // amount for this period  
    			$query = $this->db->query('select sum(amount) as sum_amount from orders where user_id = '.$user_id.' AND created LIKE("2015-'.$month.'-'.$d.'%") group by user_id');
    			
    			array_push($revenue, (int)$query->result()[0]->sum_amount);
    			$query = $this->db->query('SELECT count(*) as c FROM listings join products using (product_id) where products.user_id = '.$user_id.' AND listings.created LIKE("2015-'.$month.'-'.$d.'%") group by user_id');
    			$listings_counts[] = (int)$query->result()[0]->c;
    		} 
    		$data['datarevenue'] = json_encode($revenue);
    		$data['listings_count'] = json_encode($listings_counts);  
    		$data['datacosts'] = json_encode($amount);
    		$data['categories'] = json_encode($cats);
    		$data['interval'] = 'daily';
    		
    		$data['revenue_heading'] = date('M Y', strtotime('2015-'.$month));   		
    	}
    	$this->load->view('admin/ecommerce/revenue_panel', $data, false); 
    	
    }
}