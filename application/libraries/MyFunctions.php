<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Functions 
{
	private $ci;
    
    public function __construct() {
        $this->ci = & get_instance();
        
        $args = array
            (
            'min_version' => $this->ci->config->item('min_version'),
            'min_debug' => $this->ci->config->item('min_debug')
        );
    }
    
    public function redirectWithMessage($redirect_url = null, $message = null, $message_type = 'NOTICE'){
    	//var_dump($this->session->set_flashdata()); exit;
    	$this->session->set_flashdata('NOTICE', $message);
    	header("Location: $redirect_url"); exit;
    }
    
    public function checkLoggedIn($loginRedirect = true) {
    	$ci = $this->ci;
    
    	if (!is_null($ci->session) && $ci->session->userdata('logged_in') === true) {
    		if(!empty($_SESSION['post'])){
    			$_POST = $_SESSION['post'];
    			unset($_SESSION['post']);
    		}
    		return true;
    	} else {
    		$_SESSION['redirectUri'] = $_SERVER['REQUEST_URI'];
    		$ci->session->set_flashdata('NOTICE', 'You must login first');
    		$_SESSION['showLogin'] = true;
    		$_SESSION['post'] = !empty($_POST) ? $_POST : null;
    		header("Location: /login");
    		exit;
    	}
    }
    
    public function checkSudoLoggedIn() {
    	$ci = $this->ci;
    
    	if($ci->session->userdata('logged_in') != true){
    		$_SESSION['redirectUri'] = $_SERVER['REQUEST_URI'];
    		$ci->session->set_flashdata('NOTICE', 'You must be logged in to enter that area.');
    		$_SESSION['showLogin'] = true;
    		$_SESSION['post'] = !empty($_POST) ? $_POST : null;
    		header("Location: /login");
    		exit;
    	}
    	elseif($ci->session->userdata('logged_in') === true && $ci->session->userdata('permissions') > 0) {
    		if(!empty($_SESSION['post'])){
    			$_POST = $_SESSION['post'];
    			unset($_SESSION['post']);
    		}
    		return true;
    	}
    	elseif($ci->session->userdata('logged_in') === true && $ci->session->userdata('permissions') < 1) {
    		$_SESSION['redirectUri'] = $_SERVER['REQUEST_URI'];
    		$ci->session->set_flashdata('FAILURE', 'You do not have the correct permissions to enter that area.');
    		$_SESSION['showLogin'] = true;
    		$_SESSION['post'] = !empty($_POST) ? $_POST : null;
    		header("Location: /login");
    		exit;
    	}else{
    		var_dump('who knows'); exit;
    	}
    }
    
    public function grabGeoIP()
    {
    	$user_ip = !empty($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '127.0.0.1' ? $_SERVER['REMOTE_ADDR'] : '172.56.15.13';
    
    	if(is_null($user_ip)){
    		$obj = new stdClass();
    		$obj->ip = '199.241.138.201';
    		$obj->country_code = 'US';
    		$obj->country_name = "United States";
    		$obj->region_code = 'NV';
    		$obj->region_name = 'Nevada';
    		$obj->city = 'Las Vegas';
    		$obj->latitude = '36.216971';
    		$obj->longitude = '-115.274276';
    		$obj->metro_code = '518';
    		$obj->area_code = '702';
    		return $obj;
    	}
    
    	$url1 = 'http://freegeoip.net/json/' . $user_ip;
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url1);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	$result = curl_exec($ch);
    
    	if ($result)
    	{
    		return json_decode($result);
    		curl_close($ch);
    	}
    	else
    	{
    		$url = 'http://www.telize.com/geoip/' . $user_ip;
    		curl_setopt($ch, CURLOPT_URL, $url);
    		$result = curl_exec($ch);
    		curl_close($ch);
    		if(!$result){
    			var_dump('NOT CONNECTING TO '.$url1.' or '.$url	); exit;
    		}
    		return json_decode($result);
    	}
    }
    
    public function getGeoData($address)
    {    	
    	$key = 'Fmjtd%7Cluur2h0rnq%2C8g%3Do5-9wblhu';
    	$address = urlencode($address);
    	$ch = curl_init('http://open.mapquestapi.com/geocoding/v1/address?key=' . $key . '&outFormat=json&location=' . $address);
    	
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_POST, false);
    	$results = curl_exec($ch);
    	$json = json_decode($results);
    	
    	$data = new stdClass();
    	foreach($json as $result){
    		if(is_array($result)){
    			foreach($result[0]->locations as $loc){   			
    				if($loc->adminArea1 == 'US'){   				
    					$data->county = $loc->adminArea4;
    					$data->city = $loc->adminArea5;
    					$data->state = $loc->adminArea3;
    					$data->country = $loc->adminArea1;
    					$data->zipcode = $loc->postalCode;
    					$data->lat = $loc->displayLatLng->lat;
    					$data->lng = $loc->displayLatLng->lng;
    				}
    			}
    		}
    	}
    	
    	return $data; 
    }
   
    public function getDistance($address1, $address2){
    
    	$key = 'Fmjtd%7Cluur2h0rnq%2C8g%3Do5-9wblhu';
    	$str = json_encode(array('locations' => array(urlencode($address1), urlencode($address2)), 'options' => array('allToAll' => false)));
    	$url = 'http://www.mapquestapi.com/directions/v2/routematrix?key='.$key.'&outFormat=json&json='.$str;
    	$ch = curl_init();
    
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_POST, false);
    
    	$results = curl_exec($ch);
    	return(json_decode($results)->distance[1]);
    }
    
    public function jsScripts($scriptStr){
    	$scripts = explode(' ', $scriptStr);
    	foreach($scripts as $script){
    		$headScripts [] = '<script src="/public/js/'.$script.'" type="text/javascript"></script>';
    	}
    	
    	return $headScripts;
    }
}