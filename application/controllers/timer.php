<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Timer extends CI_Controller {

    function Timer() {
        parent::__construct();
    }
    
    // user that is not logged in will be redirected to this function
    public function index($timer_id){
    	if (! is_null ( $timer_id )) {
			$timer = $this->listing->fetchAll(array('where' => 'timer_id = '.$timer_id));
		}
		var_dump($timer);
    }
}