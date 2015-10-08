<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class product_validator_model {
    
	public $errors = array();
		
    public function validate($fields){
    	var_dump($this); exit;
    	foreach($fields as $field => $value){
    		if(method_exists($this, $field)){
    			var_dump($field);
    			//$this->$field();
    		}
    	}
    	exit;
    	$this->format();
        return $this->errors;	
    }
    
    protected function name(){
    	if($_POST['name'] == ''){ 
    		$this->errors['name'] = 'You must enter a product name';
    	}else{
    		unset($this->errors['name']);
    	}
    	return $this;
    }
    
    protected function end_time(){
    	if($_POST['end_time'] == ''){
    		$this->errors['end_time'] = 'You must select a valid date';    		
    	}else{
    		unset($this->errors['end_time']);
    	}    	
    	return $this;
    }
    
    private function format(){
    	foreach($this->errors as $key=>$err){
    		$this->errors[$key] = '<div class="alert alert-danger">'.$err.'</div>';
    	}
    }
}