<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class events_model extends CI_Model
{

    function __construct ()
    {
        parent::__construct();
        
    }

	public function insertEvent ($p)
	{
	
		if ($p['allDay'] == 1)
		{
			$fromDate = "{$p['startDate']} 00:00:00";
			
			if (empty($p['endDate']))
			{
				$toDate = "{$p['startDate']} 00:00:00";
			}
			else
			{
				$toDate = "{$p['endDate']} 00:00:00";
			}
		}
		else
		{
			$fromDate = "{$p['startDate']} {$p['startTime']}";
			
			$fromDate = $this->functions->convertTimeBacktoUTC($this->session->userdata('userid'), $fromDate);

			if (empty($p['endDate']))
			{
				$toDate = "{$p['startDate']} {$p['endTime']}";
			}
			else
			{
				$toDate = "{$p['endDate']} {$p['endTime']}";
			}
			
			$toDate = $this->functions->convertTimeBacktoUTC($this->session->userdata('userid'), $toDate);
		}
	
		$data = array
		(
			'datestamp' => DATESTAMP,
			'userid' => $this->session->userdata('userid'),
			'company' => $this->config->item('bmsCompanyID'),
			'name' => $p['title'],
			'location' => $p['eventLocation'],
			'fromDate' => $fromDate,
			'toDate' => $toDate,
			'allDay' => $p['allDay'],
			'repeat' => $p['repeatEvent'],
			'description' => $p['description'],
			'color' => $this->config->item('defaultEventColor'),
			'expLvl' => $p['expLvl'],
			'price' => $p['price']			
		);
		
		if ($p['repeatEvent'] == 1)
		{
			$data['repeatType'] = $p['repeatType'];
			$data['repeatEvery'] = $p['repeatEvery'];
			$data['startsOn'] = $p['startsOn'];
			$data['ends'] = $p['ends'];
			$data['occurrences'] = $p['occurrences'];
			
			if (!empty($p['endsOnDate'])) $data['endsOnDate'] = $p['endsOnDate'];
			
			$data['repeatSun'] = $p['repeatOn'][0];
			$data['repeatMon'] = $p['repeatOn'][1];
			$data['repeatTue'] = $p['repeatOn'][2];
			$data['repeatWed'] = $p['repeatOn'][3];
			$data['repeatThu'] = $p['repeatOn'][4];
			$data['repeatFri'] = $p['repeatOn'][5];
			$data['repeatSat'] = $p['repeatOn'][6];
		}
		
		$this->db->insert('calendarEvents', $data);
		
		return $this->db->insert_id();
	}
	
	public function updateEvent ($p)
	{
		$p['id'] = intval($p['id']);
		
		if (empty($p['id'])) throw new Exception('Event ID is empty!');
		
		if ($p['allDay'] == 1)
		{
			$fromDate = "{$p['startDate']} 00:00:00";
			
			if (empty($p['endDate']))
			{
				$toDate = "{$p['startDate']} 00:00:00";
			}
			else
			{
				$toDate = "{$p['endDate']} 00:00:00";
			}
		}
		else
		{
			$fromDate = "{$p['startDate']} {$p['startTime']}";
			
			$fromDate = $this->functions->convertTimeBacktoUTC($this->session->userdata('userid'), $fromDate);

			if (empty($p['endDate']))
			{
				$toDate = "{$p['startDate']} {$p['endTime']}";
			}
			else
			{
				$toDate = "{$p['endDate']} {$p['endTime']}";
			}
			
			$toDate = $this->functions->convertTimeBacktoUTC($this->session->userdata('userid'), $toDate);
		}
	
		$data = array
		(
			'datestamp' => DATESTAMP,
			'userid' => $this->session->userdata('userid'),
			'name' => $p['title'],
			'location' => $p['eventLocation'],
			'fromDate' => $fromDate,
			'toDate' => $toDate,
			'allDay' => $p['allDay'],
			'repeat' => $p['repeatEvent'],
			'description' => $p['description'],
			'color' => $this->config->item('defaultEventColor'),
			'expLvl' => $p['expLvl'],
			'price' => $p['price']			
		);
		
		if ($p['repeatEvent'] == 1)
		{
			$data['repeatType'] = $p['repeatType'];
			$data['repeatEvery'] = $p['repeatEvery'];
			$data['startsOn'] = $p['startsOn'];
			$data['ends'] = $p['ends'];
			$data['occurrences'] = $p['occurrences'];
			
			if (!empty($p['endsOnDate'])) $data['endsOnDate'] = $p['endsOnDate'];
			
			$data['repeatSun'] = $p['repeatOn'][0];
			$data['repeatMon'] = $p['repeatOn'][1];
			$data['repeatTue'] = $p['repeatOn'][2];
			$data['repeatWed'] = $p['repeatOn'][3];
			$data['repeatThu'] = $p['repeatOn'][4];
			$data['repeatFri'] = $p['repeatOn'][5];
			$data['repeatSat'] = $p['repeatOn'][6];
		}
		
		$this->db->where('id', $p['id']);
		$this->db->update('calendarEvents', $data);
		
		return true;
	}

	public function insertVideo ($event, $url)
	{
		$event = intval($event);
		
		if (empty($event)) throw new Exception("Event ID is empty!");
		if (empty($url)) throw new Exception('Video URL is empty!');
	
		// get youtube video data
		$videoID = $this->functions->getYouTubeVideoID($url);
		
		$vdata = $this->functions->getYoutudeVideoData($videoID);

		$data = array
		(
			'event' => $event,
			'datestamp' => DATESTAMP,
			'url' => $url,
			'title' => $vdata->entry->title->{'$t'},
			'thumbnail' => $vdata->entry->{'media$group'}->{'media$thumbnail'}[0]->url,
			'description' => $vdata->entry->{'media$group'}->{'media$description'}->{'$t'},
			'videoID' => $videoID,
			'videoOrder' => 0
		);
		
		$this->db->insert('calendarEventVideos', $data);
		
		return $this->db->insert_id();
	}
	
	public function clearVideos ($event)
	{
		$event = intval($event);
		
		if (empty($event)) throw new Exception("Event ID is empty!");
	
		$this->db->where('event', $event);
		$this->db->delete('calendarEventVideos');
		
		return true;
	}
	
	public function clearVideoByID ($id)
	{
		$id = intval($id);
		
		if (empty($id)) throw new Exception("Video ID is empty!");
	
		$this->db->where('id', $id);
		$this->db->delete('calendarEventVideos');
		
		return true;
	}
	
	public function insertFile ($event, $file, $orgFileName = null, $order = 0)
	{
		$event = intval($event);
		
		if (empty($event)) throw new Exception("Event ID is empty!");

		if (empty($file)) throw new Exception("File name is empty!");
		
		$order = intval($order);
		
		// if no orginial file name, sets it it to uploaded file name
		if (empty($orgFileName)) $orgFileName = $file;
		
		$data = array
			(
				'event' => $event,
				'datestamp' => DATESTAMP,
				'fileName' => $file,
				'orgFileName' => $orgFileName,
				'fileOrder' => $order
			);
			
		$this->db->insert('calendarEventFiles', $data);
		
		return $this->db->insert_id();
	}
	
	/**
	* sends uploaded files/attachments to BMS
	*/
	public function sendFileToBMS ($event, $path, $fileName)
	{
		$data = array
    	(
    		'event' => $event,
    		'file' => "@./{$path}{$fileName}"
    	);
    
		$url = $this->config->item('bmsUrl') . "calendar/externalfileupload";
    
	    $ch = curl_init();
	    
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		
		$response = curl_exec($ch);
		
		curl_close($ch);
	}

    /**
     * TODO: short description.
     *
     * @param unix timestamp - $startDate
     * @param unix timestamp - $endDate
     *
     * @return TODO
     */
    public function getEvents ($location = 0)
    {
    	$location = intval($location);
    
        //if (empty($startDate)) throw new Exception("Start Date is empty!");
        //if (empty($endDate)) throw new Exception("End Date is empty!");

        //if (empty($company)) $company = $this->session->userdata('company');

        //if (empty($company)) throw new Exception("Company ID is empty!");

		$company = $this->config->item('bmsCompanyID');

        $mtag = "calendarEvents-{$company}-{$location}";

        //$startDateFormatted = date("Y-m-d H:i:s", $startDate);
        //$endDateFormatted = date("Y-m-d H:i:s", $endDate);

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->db->select("id, userid, name, location, otherLocation, fromDate, toDate, allDay, repeat, color");
            $this->db->from('calendarEvents');
            $this->db->where('company', $company);
            
            if (!empty($location)) $this->db->where('location', $location);
            
            //$this->db->where('fromDate >=', $startDateFormatted);
            // $this->db->where('toDate <=', $endDateFormatted);
            $this->db->order_by('fromDate', 'asc');

            $query = $this->db->get();

            $data = $query->result();

            // error_log($this->db->last_query()); // uncomment for debugging

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    /**
     * TODO: short description.
     *
     * @param mixed $id 
     *
     * @return TODO
     */
    public function getEventInfo ($event)
    {
        if (empty($event)) throw new Exception("Event ID is empty!");

        $mtag = "eventInfo-{$event}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->db->from('calendarEvents');
            $this->db->where('id', $event);
            $this->db->where('company', $this->config->item('bmsCompanyID')); // can only pull their company event data

            $query = $this->db->get();

            $results = $query->result();

            $data = $results[0];

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        if (empty($data)) return false;

        return $data;
    }

    /**
    * gets the difference in days for how long an event will last
    */
    public function eventDays ($from, $to)
    {
	    $diff = $to - $from;
	    
	    $diff = ceil($diff / 86400); 
	    
	    return $diff;
    }
    
    public function clearContEvent($weekEventCont, $id)
    {
	    if (!empty($weekEventCont))
	    {
		    foreach ($weekEventCont as $k => $v)
		    {
			    if ($v == $id)
			    {
				    unset($weekEventCont[$k]);
			    }
		    }
	    }
	    
	    return $weekEventCont;
    }
    
    public function getEventVideos ($event)
    {
    	$event = intval($event);
    
        if (empty($event)) throw new Exception("Event ID is empty!");

        $mtag = "eventVideos-{$event}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->db->from('calendarEventVideos');
            $this->db->where('event', $event);
            $this->db->order_by('videoOrder', 'asc');

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

	public function getEventFiles ($event)
	{
    	$event = intval($event);
    
        if (empty($event)) throw new Exception("Event ID is empty!");

        $mtag = "eventFiles-{$event}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->db->from('calendarEventFiles');
            $this->db->where('event', $event);
            $this->db->order_by('fileOrder', 'asc');

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
	}
	
	public function getFileNameByID ($id)
	{
    	$id = intval($id);
    
        if (empty($id)) throw new Exception("File ID is empty!");

        $mtag = "eventFileName-{$id}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
        	$this->db->select('fileName');
            $this->db->from('calendarEventFiles');
            $this->db->where('id', $id);

            $query = $this->db->get();

            $results = $query->result();

			$data = $results[0]->fileName;

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
	}
	
	public function deleteFile ($id, $event)
	{
		// first gets file name to delete from server
		$fileName = $this->getFileNameByID($id);
		
		$path = 'public' . DS . 'uploads' . DS . 'events' . DS . $event . DS;
		
		@unlink($path . $fileName);
		
		$this->db->where('id', $id);
		$this->db->delete('calendarEventFiles');
		
		return true;
	}

	public function checkRepeatDisplay ($utDay, $fdut, $event, &$rdata, $fdom, $fdoy)
	{
		/*
		if ($rdata['daysSinceDisplay'] == 0)
		{
			//echo "{$event} HERE: {$rdata['daysSinceDisplay']}<BR>";
		
			if ($utDay >= $fdut) return true;
		}
		*/
		// gets day of week
		// 0 = Sunday, 6 = Sat
		$dow = date("w", $utDay);
		
		// day of month 1 - 31
		$dom = date("j", $utDay);
		
		// day of year 0 - 365
		$doy = date("z", $utDay);

		// converts repeat startOnDate to UnixTime
		$startsOn = strtotime($rdata['startsOn']);

		
		$startDate = $fdut;
		
		$repeatDaysBlank = (empty($rdata['repeatSun']) && empty($rdata['repeatMon']) && empty($rdata['repeatTue']) && empty($rdata['repeatWed']) && empty($rdata['repeatThu']) && empty($rdata['repeatFri']) && empty($rdata['repeatSat'])) ? true : false;
		
		
		$diffM = $this->functions->dateDiff(($startDate - 86400), $utDay, 3);
		$diffY = $this->functions->dateDiff(($startDate - 86400), $utDay, 4);
		//echo "{$evebt} DIFF MONTH: " . (int) $diffM . "<br>";
		
		//$fdiffM = $this->functions->dateDiff(($startDate - 86400), $utDay, 3);
		
		/*
		if ($startsOn > $utDay)
		{
			// TODO : convert to proper user timezone
			$startDate = $startsOn;
			
			
			//return false;
		}
		*/
		$startDate = $this->functions->convertTimezone($this->session->userdata('userid'), $startDate, "Y-m-d h:iA");
		
		$startDate = strtotime($startDate);
		
				// checks repeat interval
		if ($rdata['repeatType'] == 2) // weekly
		{
			// get diff between start date of event and beginning of the month it starts
			

			
			
			$diffDays = $this->functions->dateDiff($fdut, $utDay, 3);
		
			if ($utDay < $fdoy) return false;
		}
		
		if ($rdata['repeatType'] == 3) // monthly
		{
			$esMonth = date("m", $fdut);
			$esYear = date("Y", $fdut);
			
			$firstMonthofEvent = mktime(0, 0, 0, $esMonth, 1, $esYear);
			
			$diffInDays = ceil(($fdut - $firstMonthofEvent) / 86400);
			
			//$diffInDays = $this->functions->dateDiff($firstMonthofEvent, $fdut);
			
			//echo "DIFF IN DAYS: {$diffInDays} | {$dom}<BR>";
			
			//echo "ES M: {$esMonth} Y: {$esYear}<BR>";
			
			$daysPassed = false;
		
			if ($diffInDays == $dom) $daysPassed = true;
			
			//if ($utDay < $fdom && $daysPassed == false) return false;
			
			if (!$daysPassed) return false;
			
			if ($utDay < $fdom) return false;


			if ($daysPassed) return true;
		
			if ($rdata['accOcc'] > 0) return false;

		}

		if ($rdata['repeatType'] == 4) // Yearly
		{
			//$esMonth = date("m", $fdut);
			$esYear = date("Y", $fdut);
			
			$firstYearofEvent = mktime(0, 0, 0, 1, 1, $esYear);
			
			$diffInDays = ceil(($fdut - $firstYearofEvent) / 86400);

			if ($utDay < $fdoy) return false;

			$daysPassed = false;
		
			if ($diffInDays == $doy) $daysPassed = true;

			
			if (!$daysPassed) return false;
			
			if ($utDay < $fdoy) return false;

			if ($daysPassed) return true;
		}
		
		
		//echo "{$event} UT: {$utDay} " . date("Y-m-d h:iA", $utDay)  . "<BR><BR>" . PHP_EOL;
		//echo "{$r->event} Start Date: {$startDate} " . date("Y-m-d h:iA", $startDate)  . "<BR><HR>" . PHP_EOL;
	
		//echo "<BR>DOW: {$dow}<BR>";
		//echo "REPEAT: {$rdata['repeatFri']}<BR>";
		

		
		if ($repeatDaysBlank == false)
		{			
			//echo "{$event} checking days<BR>";
			if ($dow == 0 && empty($rdata['repeatSun'])) return false;
			if ($dow == 1 && empty($rdata['repeatMon'])) return false;
			if ($dow == 2 && empty($rdata['repeatTue'])) return false;
			if ($dow == 3 && empty($rdata['repeatWed'])) return false;
			if ($dow == 4 && empty($rdata['repeatThu'])) return false;
			if ($dow == 5 && empty($rdata['repeatFri'])) return false;
			if ($dow == 6 && empty($rdata['repeatSat'])) return false;
		}
		//echo "{$event} passed day check<BR>";
		
		//if ($rdata['startsOn']);
		

		
		if ($rdata['accOcc'] > 0)
		{
			if ($startsOn > $utDay) return false;
		}
			
		if ($rdata['ends'] == 2) // ends after so many occurances
		{
			// number of occurances have passed
			if ($rdata['accOcc'] >= $rdata['occurrences']) return false;
		}
		
		if ($rdata['ends'] == 3) // ends after a given date
		{
			// converts repeats endsOnDate to UnixTime
			$endsOnDate = strtotime($rdata['endsOnDate']);
			
			//echo "CHECK END DATE";
			
			if ($utDay > $endsOnDate) return false;
		}
	
		
		if ($rdata['accOcc'] == 0) // event has not occurred on calendar yet
		{
			if (($utDay >= ($startDate - 86400)))
			{
				return true;
			}

		}
		// checks if repeats on a paticular day
		//if ($rdata['daysSinceDisplay'] == 0) return true;
		
		//echo "{$event}NO FALSE<BR>";
		
		return true;
	}
	
	public function deleteEvent ($event)
	{
    	$event = intval($event);
    
        if (empty($event)) throw new Exception("Event ID is empty!");
		
		// clears videos
		$this->clearVideos($event);
		
		// clears files
		$files = $this->getEventFiles($event);
		
		if (!empty($files))
		{
			foreach ($files as $r)
			{
				$this->deleteFile($r->id, $event);
			}
		}
		
		$this->db->where('id', $event);
		$this->db->delete('calendarEvents');

		return true;
	}
	
	public function repeatSummary ($event)
	{
		$event = intval($event);
    
        if (empty($event)) throw new Exception("Event ID is empty!");
        
		$info = $this->getEventInfo($event);
		
		if ($info->repeat == 0)
		{
			return 'Event does not reepat.';
		}
		else
		{
			//$txt;
			
			// get repeatType
			$type = $this->functions->codeDisplay(30, $info->repeatType);
			
			if ($info->repeatType == 1) $typeDisplay = "day";
			else if ($info->repeatType == 2) $typeDisplay = "week";
			else if ($info->repeatType == 3) $typeDisplay = "month";
			else if ($info->repeatType == 4) $typeDisplay = 'year'; 
			
			if ($info->repeatEvery !== '1') $typeDisplay .= 's';
			
			$startOnDisplay = date("m/d/Y", strtotime($info->startsOn));
			
			$txt .= "Every {$info->repeatEvery} {$typeDisplay} starting on {$startOnDisplay}";
			
			$repeatDaysBlank = (empty($info->repeatSun) && empty($info->repeatMon) && empty($info->repeatTue) && empty($info->repeatWed) && empty($info->repeatThu) && empty($info->repeatFri) && empty($info->repeatSat)) ? true : false;
			
			if ($repeatDaysBlank === false)
			{
				$txt .= " on";
				
				$days = array();
				
				if ($info->repeatSun == '1') $days[] = 'Sun';
				if ($info->repeatMon == '1') $days[] = 'Mon';
				if ($info->repeatTue == '1') $days[] = 'Tue';
				if ($info->repeatWed == '1') $days[] = 'Wed';
				if ($info->repeatThu == '1') $days[] = 'Thu';
				if ($info->repeatFri == '1') $days[] = 'Fri';
				if ($info->repeatSat == '1') $days[] = 'Sat';
				
				$weekDays = ($info->repeatMon == 1 && $info->repeatTue == 1 && $info->repeatWed == 1 && $info->repeatThu == 1 && $info->repeatFri == 1 && empty($info->repeatSat) && empty($info->repeatSun)) ? true : false;
				
				$txt .= ' ' . implode(', ', $days);
			}
			
			
			return $txt;
		}
	}
	
	public function insertEventAttend ($p)
	{
		$data = array
		(
			'event' => $p['event'],
			'datestamp' => DATESTAMP,
			'userid' => $this->session->userdata('userid'),
			'dateAttending' => $p['eventTime']
		);
		
		$this->db->insert('calendarEventUserAttend', $data);

		return $this->db->insert_id();
	}
	
	public function deleteEventAttend ($p)
	{
		$this->db->where('userid', $this->session->userdata('userid'));
		$this->db->where('dateAttending', $p['eventTime']);
		$this->db->delete('calendarEventUserAttend');
		
		return true;
	}
	
	/**
	* checks if user is attending a calendar event
	* event time is in UTC and is virtual for repeating events (event may not exist in DB at that time, but is schedule for it)
	*/
	public function checkedUserAttend ($user, $event, $eventTime)
	{
		$user = intval($user);
		$event = intval($event);
	
		if (empty($user)) throw new Exception("User ID is empty!");
        if (empty($event)) throw new Exception("Event ID is empty!");
        if (empty($eventTime)) throw new Exception("Event time is empty!");

        $mtag = "userEventAttend-{$user}-{$event}-{$eventTime}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->db->from('calendarEventUserAttend');
            $this->db->where('event', $event);
            $this->db->where('userid', $user);
            $this->db->where('dateAttending', $eventTime);

            $data = $this->db->count_all_results();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        if (empty($data)) return false;

        return true;
	}
	
	/**
	* gets the number of users attending an event
	*/
	public function getNumAttending ($event, $eventTime)
	{
		$event = intval($event);

        if (empty($event)) throw new Exception("Event ID is empty!");
        if (empty($eventTime)) throw new Exception("Event time is empty!");
        
        $mtag = "numAttendingCnt-{$event}-{$eventTime}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->db->from('calendarEventUserAttend');
            $this->db->where('event', $event);
            $this->db->where('dateAttending', $eventTime);

            $data = $this->db->count_all_results();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }
        
        return $data;
	}
}