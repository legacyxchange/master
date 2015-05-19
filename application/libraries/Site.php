<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//$site->setName('newname.com');
//$site->getName();
class Site {
	protected $name;
	protected $logo;
	protected $contactEmail;
	protected $contactPhone;
	protected $contactAddress1;
	protected $contactAddress2;
	protected $contactCity;
	protected $contactState;
	protected $contactZipcode;
	protected $contactFax;
	protected $domain;
	
	public function __construct(){
		$config = $this->config =& get_config();
	
		$this->name = $config['site']->name;
		$this->logo = $config['site']->logo;
		$this->contactEmail = $config['site']->contactEmail;
		$this->contactPhone = $config['site']->contactPhone;
		$this->contactAddress1 = $config['site']->contactAddress1;
		$this->contactAddress2 = $config['site']->contactAddress2;
		$this->contactCity = $config['site']->contactCity;
		$this->contactState = $config['site']->contactState;
		$this->contactZipcode = $config['site']->contactZipcode;
		$this->contactFax = $config['site']->contactFax;
		$this->domain = $config['site']->domain;
	}
	
	public function __call($method, $property = null){
		if(stristr($method, 'get')){
			$property = lcfirst(str_replace('get', '', $method));
			if(property_exists($this, $property)){
				return $this->$property;
			}
		}
		
		if(stristr($method, 'set')){
			$prop = lcfirst(str_replace('set', '', $method));
			if(property_exists($this, $prop)){
				$this->$prop = $property;
			}
			return $this;
		}		
	}
}