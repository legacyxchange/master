<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bms_users
{
	private $ci;
	
	function __construct ()
	{
		$this->ci =& get_instance();
	}
	
	 /**
	 * Gets a users name
	 *
	 * @param mixed $id 
	 *
	 * @return String - "[firstName] [lastName]"
	 */
	public function getName ($id)
	{
		$id = intval($id);
		
	    if (empty($id)) throw new Exception('user id is empty!');
	
	    $mtag = "usersName{$id}";
		
		$data = $this->ci->bms->checkCacheData($mtag);
		
		if ($data === false)
		{
	        $this->ci->db->select('firstName, lastName');
	        $this->ci->db->from('users');
	        $this->ci->db->where('deleted', 0);
	        $this->ci->db->where('id', $id);
	
	        $query = $this->ci->db->get();
	
	        $results = $query->result();
	
	        $data =  "{$results[0]->firstName} {$results[0]->lastName}";
		}
		
		$this->ci->bms->saveCacheData($mtag, $data);
	
	    return $data;
	
	}
		
}