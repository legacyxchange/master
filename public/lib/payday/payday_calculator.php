<?php
date_default_timezone_set('America/Los_Angeles');
ini_set('display_errors', 1);
error_reporting(E_ALL);
/**
 * 
 * @author Nick
 * Calculates the next payday based on the first payday ever entered.
 */
class PaydayCalculator{
	
	protected $firstPayDay;
	protected $interval_type = 'weekly';
	protected $interval;
	public $landedOnSat;
	public $landedOnSun;
	
	public function __construct($firstPayDay, $interval_type = 'weekly'){
		$this->firstPayDay = $firstPayDay;
		$this->interval_type = $interval_type;
	}
	
	public function calculateNextPayday(){
		switch($this->interval_type){
			case 'weekly':
				$this->interval = '7 day';
			break;
			case 'bi-weekly':
				$this->interval = '14 day';
			break;
			case 'semi-monthly':
				$this->interval = '15 day';
			break;
			case 'monthly':
				$this->interval = '1 month';
			break;
			default:
				$this->interval = '7 day';
			break;
		}
		
		return $this->calcDate();
	}
	
	private function calcDate(){
		$today = date('Y-m-d', strtotime(date('Y-m-d')));
	
		$npd = $this->firstPayDay;
	    
		do {
			$npd = date('Y-m-d', strtotime($npd.' + '.$this->interval));
		} while($npd <= $today);
		
		// calculate for weekends
		if(date('D', strtotime($npd)) == 'Sat'){ echo '<h2>Sat</h2>';
			$npd = date('Y-m-d', strtotime($npd.' - 1 day'));
			$this->landedOnSat = 1;
		}
		if(date('D', strtotime($npd)) == 'Sun'){ echo '<h2>Sun</h2>';
			$npd = date('Y-m-d', strtotime($npd.' + 1 day'));
			$this->landedOnSun = 1;
		}
		return ($npd);
	}
}

if (! empty ( $_POST )) {
	$firstPayDay = ! empty ( $_POST ['paydate'] ) ? $_POST ['paydate'] : '2015-03-06';
	$interval_type = ! empty ( $_POST ['payday_interval'] ) ? $_POST ['payday_interval'] : 'weekly';
	$firstPayDayDay = date ( 'D', strtotime ( $firstPayDay ) );
	// params: first pay date, interval type(weekly, bi-weekly, semi-monthly, monthly)
	$pdc = new PaydayCalculator ( $firstPayDay, $interval_type );
	
	$nextPayDay = $pdc->calculateNextPayday ();
	$nextPayDayDay = date ( 'D', strtotime ( $nextPayDay ) );
	
	echo 'Interval Type: ' . $interval_type;
	echo '<br />';
	echo 'First Pay Date: ';
	echo $firstPayDay . '(' . $firstPayDayDay . ')';
	echo '<br />';
	echo "Next Pay Date: " . $nextPayDay . '(' . $nextPayDayDay . ')';
	if ($pdc->landedOnSat || $pdc->landedOnSun) {
		echo isset ( $pdc->landedOnSat ) ? " Landed on a Sat. - Pushed back a day" : " Landed on a Sun. - Pushed forward a day";
	}
}
require_once 'index.php';