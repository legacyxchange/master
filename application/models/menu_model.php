<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    require_once 'abstract_model.php';

class menu_model extends abstract_model {

	public $menuid;
	public $locationid;
	public $strainid;
	public $userid;
	public $item_type;
	public $description;
	public $per_g;
	public $per_eighth;
	public $per_quarter;
	public $per_half;
	public $per_oz;
	public $per_each;
	public $active;
	public $created;
	
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Grabs menu item types from db and returns them in an array
     * @param null
     * @return array key = item type id, val = item type title
     */
    
    public function getMenuOptions()
    {
        $mtag = "menu_item_types";
        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->from('item_types');
            $query = $this->db->get();
            $data = $query->result();
            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }
        
        $result = array();
        
        foreach ($data as $row)
        {
            $result[$row->itemid] = $row->title;
        }
        
        return $result;
    }
    
    /*
     * Saves menu to DB
     * @param $items, multi dimensional array containing post data to be inserted/updated
     * @return void
     */
    public function saveMenuOLD($items)
    {
    	var_dump($items); exit;
        $insert = array();
        $update = array();
        foreach ($items as $item)
        {
            if (intval($item['menuid']) == 0 && $item['description'] != '')
            {
                $insert[] = $item;
            }
            else
            {
                $update[] = $item;
            }
        }
        if ($insert)
        {
            $this->db->insert_batch('item_menu', $insert);
        }
        if ($update)
        {
            $this->db->update_batch('item_menu', $update, 'menuid');
        }
    }
    
    public function save($params) {
    	
    	$params = $this->cleanseParams($params);
    	
    	if(is_null($params))
    	    return null;
    	    
    	if(!empty($params['menuid'])) {
    		$deals = $this->getDealById($params['menuid']);
    	
    		if(count($deals) > 0){ 
    	    	$this->db->where('menuid', $params['menuid']);
            	$this->db->update('item_menu', $params);
    		}
    		else { 
    			unset($params['menuid']);
    			$this->db->insert('item_menu', $params);
    		}
    	}
    	else {
    		$this->db->insert('item_menu', $params);
    	}
    	
    	return true;
    }
    
    /*
     * Reads menu from DB for given userid
     * @param $userid, $userid of menu to return
     * @return multi dimensional array representing entire menu for user
     */
    
    public function getMenu($locationid)
    {
        $this->db->from('item_menu');
        $this->db->where('locationid', $locationid);
        $this->db->where('active', 1);
        $this->db->order_by('item_type ASC');
        $query = $this->db->get();
        return $query->result();
    }
    
    protected function cleanseParams($params){
    	$params = parent::cleanseParams($params);
    	if(is_null($params['item_type']))
    	    return null;
    	    
    	return $params;
    }
}