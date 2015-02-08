<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    
// runs from crontab - dev site now
// /var/www/ndev.greenstandardtechnologies.com/html clideals init
class Clideals extends CI_Controller {

	protected $db;
	protected $today;
	
	public function init()
	{
		if(!$this->input->is_cli_request()) {
			redirect('/');
		    exit;
		}

		$this->setDb();
			
		$this->today = date('Y-m-d');
		
		$this->runDeals();
		
		$this->stopDeals();
	}
	
	/**
     * 
     * This is for clideals
     */
    public function runDeals() { 	
    	
    	$stmt = $this->db->query('select * from deals where "'.$this->today.'" BETWEEN start_date and end_date and is_running < 1');
    	
    	while($result = $stmt->fetch(PDO::FETCH_OBJ))
    	{
    		$rows []= $result;
    	}
    	    
    	if(count($rows) > 0) {
    		foreach($rows as $row){
    			//var_dump($row); // do logic to run the deals here
    			$this->updateDeals('update deals set is_running = 1 where dealid = '.$row->dealid);
    		}
    	}
    }
    
    /**
     * 
     * This is for clideals
     */
    public function stopDeals() { 
    		
    	$sql = 'select * from deals where "'.$this->today.'" > end_date || '.$this->today.' > expiration_date and is_running = 1';
    	
    	$stmt = $this->db->query($sql);
    	
    	while($result = $stmt->fetch(PDO::FETCH_OBJ))
    	{
    		$rows []= $result;
    	}
    	
    	if(count($rows) > 0) {
    		foreach($rows as $row){
    			//var_dump($row->dealid); // do logic to run the deals here
    			$this->updateDeals('update deals set is_running = 0 where dealid = '.$row->dealid);
    			$this->updateRepeat($row);    			
    		}
    	}
    }
    
    protected function updateRepeat($row){
    	switch($row->repeat){
    		case 'weekly':
    			$start = date('Y-m-d', strtotime("+1 week", strtotime($row->start_date)));
    			$end = date('Y-m-d', strtotime("+1 week", strtotime($row->end_date)));   			
    	    break;
    	    case 'monthly':
    			$start = date('Y-m-d', strtotime("+1 month", strtotime($row->start_date)));
    			$end = date('Y-m-d', strtotime("+1 month", strtotime($row->end_date)));    			
    	    break;
    	    case 'yearly':
    			$start = date('Y-m-d', strtotime("+1 year", strtotime($row->start_date)));
    			$end = date('Y-m-d', strtotime("+1 year", strtotime($row->end_date)));
    	    break;
    	}
    	
    	echo $sql = 'update deals set start_date = "'.$start.'" where dealid = '.$row->dealid;
    	$this->updateDeals($sql);
    	echo "\n";
    	echo $sql = 'update deals set end_date = "'.$end.'" where dealid = '.$row->dealid;
    	echo "\n\n";
    	$this->updateDeals($sql);
    }
    
    protected function updateDeals($sql){
    	$stmt = $this->db->query($sql);
    	$stmt->execute();
    }
    
	protected function setDb(){
		
		$hostname = 'localhost';
    	$username = 'root';
    	$password = '';
        $database = 'gstdev';
		try {
			if(!isset($this->db))
    		    $this->db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);

    	}
		catch(PDOException $e)
    	{
    		echo $e->getMessage();
    	}
	}
}
?>