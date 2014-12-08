<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OLDchat_model extends CI_Model
{
    /**
     * TODO: short description.
     *
     */
    function __construct ()
    {
        parent::__construct();
    }
    
    
    
	public function insertMsg ($userid, $from, $company, $msg)
	{
		if (empty($userid)) throw new Exception("User ID is empty!");
		if (empty($from)) throw new Exception("From User ID is empty!");
		if (empty($company)) throw new Exception("Company ID is empty!");

		$data = array
		(
			'datestamp' => DATESTAMP,
			'userid' => $userid,
			'from' => $from,
			'company' => $company,
			'body' => $msg
		);
		
		$this->db->insert('chat', $data);
		
		return $this->db->insert_id();
	}
	
	public function getMsgs ($users, $from, $company)
	{
		if (empty($users)) throw new Exception("No users to get messages for");
		
		$mtag = "getMsgs-{$from}-{$company}" . implode('-', $users);
		
		$data = $this->bms->checkCacheData($mtag);
		
		if ($data === false)
		{
			$this->db->select($col);
			$this->db->from('chat');
			$this->db->where_in('userid', $users);
			$this->db->where('from', $from);
			$this->db->where('company', $company);
				
			$query = $this->db->get();
	
	        $data = $query->result();
		}
		
		$this->bms->saveCacheData($mtag, $data);
		
		return $data;
	}
	

	/*
	protected function createChatTables ()
	{
		$fields = array
		(
			'id' => array
			(
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true
			),
		);
	}
	*/
}