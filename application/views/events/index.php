<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>

<input type='hidden' name='eventLocation' id='eventLocation' value='<?=$location?>'>
<input type='hidden' name='month' id='month' value='<?=$month?>'>
<input type='hidden' name='year' id='year' value='<?=$year?>'>

<div class='container page-content'>

	
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
 
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

		 <ul class="nav navbar-nav pull-left">
			<li><a href='/events/index/<?=$location?>/<?=date("n/Y", mktime(0, 0, 0, ($month - 1), 1, $year))?>' name='prevBtn' id='prevBtn'><i class='fa fa-chevron-left'></i></a></li>
			<li><a href='#'><?=date("F Y", mktime(0, 0, 0, $month, 1, $year))?></a></li>
			<li><a href='/events/index/<?=$location?>/<?=date("n/Y", mktime(0, 0, 0, ($month + 1), 1, $year))?>' name='nextBtn' id='nextBtn'><i class='fa fa-chevron-right'></i></a></li>
        </ul>

		<button type='button' class='btn btn-primary pull-right navbar-btn' id='createEventBtn'><i class='fa fa-plus-circle'></i> Create</button>
   
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
		

	<div class='row cal-row'>
		<div class='col-md-12 col-bg'>
		
		

<div id='calendar' class='calendar '>

<div class='row'>
	<div class='dayHeader'>Sunday</div>
	<div class='dayHeader'>Monday</div>
	<div class='dayHeader'>Tuesday</div>
	<div class='dayHeader'>Wednesday</div>
	<div class='dayHeader'>Thursday</div>
	<div class='dayHeader'>Friday</div>
	<div class='dayHeader'>Saturday</div>
</div>

<?php

$first = date("w", mktime(0, 0, 0, $month, 1, $year));

// for the current month gets Unix time for first day of month
$fdom = date("U", mktime(0, 0, 0, $month, 1, $year));

// gets the first day of the year
$fdoy = date("U", mktime(0, 0, 0, 1, 1, $year));

// echo "FIRST:{$first}<BR>";

//echo "First Display Day: {$firstDisplay}";

$startDate = mktime(0, 0, 0, $month, (1 - $first), $year);

$endDate = mktime(0, 0, 0, ($month + 1), (1-1), $year);

$end = date('n', $endDate);

// echo date("m/d/Y l | N | z", $startDate) . "<BR>";
// echo date("m/d/Y l | N | z", $endDate) . "<BR>";

$diff =  (int) date("z", $endDate) - (int) date("z", $startDate);
// echo $diff;

    if ($diff < 0) $diff += 365;

$extend = 7 - (int) date("N", $endDate);

// echo "EXTEND: {$extend}<BR>";

$rcnt = 1;
$cnt = 0;

$weekEventCont = array();
$repeat = array();
$repeatID = array(); // array holds IDs of repeat events
$repeatFinish = array();
$initDisplayed = array(); // holds array of ID's that have been displayed

$total = $diff + $extend;

for ($i = 1; $i <= $total; $i++)
{

    $class = $tdClass = null;

    $utDay = $startDate + (($i - 1)  * 86400);
        
    //$uTConvert = $this->users->convertTimezone($this->session->userdata('userid'), date("Y-m-d g:i A", $utDay), "Y-m-d g:i A");

	//$utDay = strtotime($uTConvert);

	// gets day of the week
	$dayOfWeek = date("w", $utDay);
	
	$weekDaysRemaining = 6 - $dayOfWeek;
 
    $day = date("d", $utDay);
    //$day = date("m/d/Y g:i A", $utDay);
    
    $date = date("Y-m-d", $utDay);

    if ($i > $first && $i <= ($total - ($extend - 1))) $class = 'label-success';
    else $tdClass = 'unavail-day';

    if ($rcnt == 1) echo "<div class='row'>" . PHP_EOL;

	$tdClass .= ($utDay == mktime(0, 0, 0, date("m"), date("d"), date("Y"))) ? 'today' : null;

    echo "\t<div class='day-container {$tdClass}'>";
    // echo "<div class='label {$class} calDay'>{$day}</div>";

   // echo "<a href='/calendar/edit/?date=" . urlencode($date) . "&month={$month}&year={$year}' class='btn btn-xs calDay' title='{$date}'>{$day}</a>";
    echo "<span class='calDay'>{$day}</span>" . PHP_EOL;


    // goes through events of which ones to display

    // echo "UTDAY: {$utDay}";
    
    echo "<div class='eventContainer'>" . PHP_EOL;

    if (!empty($events))
    {
    	//print_r($events);
        foreach ($events as $r)
        {
            $fdut = $tdui = $color = $eventInfo = null;

            $tomorrow = $utDay + 86400;
            
            $display = false;

			if ($r->repeat == 1)
			{
				// checks if event is in repeat array
				if (!in_array($r->id, $repeatID))
				{
					try
					{
						// gets event info
						$eventInfo = $this->events->getEventInfo($r->id);
					}
					catch (Exception $e)
					{
						$this->functions->sendStackTrace($e);
						continue;
					}
				
					// not in repeat array - adds it to it
					$repeat[$r->id]['startsOn'] = $eventInfo->startsOn;
					$repeat[$r->id]['repeatType'] = $eventInfo->repeatType;
					$repeat[$r->id]['repeatEvery'] = $eventInfo->repeatEvery;
					$repeat[$r->id]['ends'] = $eventInfo->ends;
					$repeat[$r->id]['occurrences'] = $eventInfo->occurrences;
					$repeat[$r->id]['endsOnDate'] = $eventInfo->endsOnDate;
					
					$repeat[$r->id]['repeatSun'] = $eventInfo->repeatSun;
					$repeat[$r->id]['repeatMon'] = $eventInfo->repeatMon;
					$repeat[$r->id]['repeatTue'] = $eventInfo->repeatTue;
					$repeat[$r->id]['repeatWed'] = $eventInfo->repeatWed;
					$repeat[$r->id]['repeatThu'] = $eventInfo->repeatThu;
					$repeat[$r->id]['repeatFri'] = $eventInfo->repeatFri;
					$repeat[$r->id]['repeatSat'] = $eventInfo->repeatSat;
					$repeat[$r->id]['daysSinceDisplay'] = 0;
					$repeat[$r->id]['accOcc'] = 0; // number of actual occurances
					
					
					$repeatID[] = $r->id;
					//print_r($repeatID);
				}
			}

            //$fdut = strtotime($r->fromDate);
            //$tdut = strtotime($r->toDate);

            $fdut = $this->functions->convertTimezone($this->session->userdata('userid'), $r->fromDate, "U");
            $tdut = $this->functions->convertTimezone($this->session->userdata('userid'), $r->toDate, "U");

			$diffStart = $fdut - $utDay;
			//echo "<BR>({$fdut} - {$utDay}) {$r->id} DIFF = {$diffStart}<BR>\n";

			//if ($diffStart <= 86400) echo "DISPLAY*<BR>";
			//if (in_array($r->id, $repeatID)) echo "IN ARRAY*<BR>";

			$days = $this->events->eventDays($fdut, $tdut);
			
			

			if ($utDay <= $fdut && $fdut <= $tomorrow) $display = true;
			//echo "<BR>DISPLAY 1: {$display}<BR>";
			if (in_array($r->id, $weekEventCont) && $dayOfWeek == 0) $display = true;
			//echo "<BR>DISPLAY 2: {$display}<BR>";
			if (in_array($r->id, $repeatID) && $diffStart <= 86400) $display = true;
			//echo "<BR>DISPLAY 3: {$display}<BR>";
            // $color = "background-color:#" . (empty($r->color) ? 'F00' : $r->color );

            if (!empty($r->color)) $color = "background-color:#{$r->color};";
            
            //var_dump($display);
            //echo "RIGHT BEFORE: {$display}!!<BR>";
            if ($display);
            //if (($utDay <= $fdut && $fdut <= $tomorrow) || (in_array($r->id, $weekEventCont) && $dayOfWeek == 0) || (in_array($r->id, $repeatID) && $diffStart <= 86400))
            {
            	//echo "<b>EVENT ID: {$r->id}</b><BR>" . PHP_EOL;
            	if ($display === false) continue;
            	
            	
            	/*
            	if ($r->repeat == 1)
            	{
            		if ($utDay <= $fdut) continue;
            	}
				*/
            	//$marginTop = $cnt * 25;
            	
            	// only checks login after initial display
            	//if (in_array($r->id, $initDisplayed))
            	if ($r->repeat == 1)
            	{
            		//echo "CHECK REPEAT: {$r->id}<BR>";
            		// add repeat logic here
            		$repeatDisplay = $this->events->checkRepeatDisplay($utDay, $fdut, $r->id, $repeat[$r->id], $fdom, $fdoy);
            	
            		if (!$repeatDisplay) continue;
            	}
            	
            	if (in_array($r->id, $weekEventCont)) $days = $eventRemainingDays[$r->id];
            	
            	echo "<label class='label label-default calendarEvent' days='{$days}' weekDaysRemaining='{$weekDaysRemaining}'  onclick=\"events.loadEventModal({$r->id});\" style=\"{$color}width:100%;margin-top:{$marginTop}px;\">{$r->name}</label>" . PHP_EOL;
            	
            	if ($r->repeat == 1)
            	{
            		$repeat[$r->id]['lastDisplayedDateUT'] = $utDay;
	            	$repeat[$r->id]['accOcc']++;
            	}
            	
            	

            	
            	// once displayed, adds ID to initDisplayed array
            	// happens AFTER day count for repeat events
            	if (!in_array($r->id, $initDisplayed)) $initDisplayed[] = $r->id;
            	
            	if ($weekDaysRemaining < $days)
            	{
	            	$weekEventCont[] = $r->id;
	            	$eventRemainingDays[$r->id] = ($days - $weekDaysRemaining) - 1;
            	}
            	
            	// removes element from array
            	if (in_array($r->id, $weekEventCont) && $dayOfWeek == 0) 
            	{
	            	$weekEventCont = $this->events->clearContEvent($weekEventCont, $r->id);
            	}
            	
            	$cnt++;
			} // end of display IF

        	if (in_array($r->id, $initDisplayed) && $r->repeat == 1)
        	{
            	$repeat[$r->id]['daysSinceDisplay']++;
        	}
			
        }
    }
    
    echo "<div class='clearfix'></div>" . PHP_EOL;
    
    echo "</div> <!-- .eventContainer -->";
    
    //print_r($eventRemainingDays);
    //print_r($weekEventCont);
    //echo '<hr>';print_r($repeat);


    echo "</div>" . PHP_EOL;

    if ($rcnt >= 7)
    {
        echo "</div> <!-- /.row -->" . PHP_EOL;
        $rcnt = 1;
        $cnt = 0;
        //$weekEventCont = array();
    }
    else
    {
        $rcnt++;
    }
}


?>

</div> <!-- /#calendar -->

<div id='eventModal' class='modal fade'></div>

		
	
		</div> <!-- /.col-md-12 -->
	</div> <!-- /.row -->

</div>


<?php
	//$this->load->view('events/create_modal');
?>