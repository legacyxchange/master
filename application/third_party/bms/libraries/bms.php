<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bms
{
	private $ci;
	
	function __construct ()
	{
		$this->ci =& get_instance();
	
		$this->ci->load->driver('cache');
	}


	public function checkCacheData ($mtag)
	{
		if ($this->ci->cache->memcached->is_supported())
		{
			$data = $this->ci->cache->memcached->get($mtag);
			
			if (!$data) return false;
			
			return $data;
		}
		
		return false;
	}
	
	public function saveCacheData ($mtag, $data)
	{
		if ($this->ci->cache->memcached->is_supported())
		{
			$this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
			
			return true;
		}
		
		return false;
	}
		
}