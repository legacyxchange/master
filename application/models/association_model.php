<?php 
class association_model extends abstract_model {
	protected $query;
	protected $results;
	
	public function __construct($main_table, $where = null){
		$this->db->from($main_table);
		if(!is_null($where)){
			$this->db->where($where);
		}
		$this->query = $this->db->get();
		
		$this->results = $this->query->result();
		
		return $this;
	}
	
	public function associate($table, $where, $last = false){
		
		if($last){
			foreach($this->results as $result){
				foreach($result->$last as $r){
					$this->db->where($where.' = '.$r->$where);
					$query = $this->db->get($table);
					$r->$table = $query->result();
				}
			}
		}else{
		foreach($this->results as $result){ 
			$this->db->where($where);
			$query = $this->db->get($table);
			
			$result->$table = $query->result(); 
		}
		
		}
		return $this;
	}
	
	public function show(){
		var_dump($this->results); exit;
	}
}
