<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends CI_Controller
{

    function Events ()
    {
        parent::__construct();
        
        $this->load->driver('cache');
        
        $this->functions->checkLoggedIn();
        
        
        $this->load->model('events_model', 'events', true);
		$this->load->model('profile_model', 'profile', true);
		$this->load->model('dojos_model', 'dojos', true);

    }
    
    public function index ($location, $month = null, $year = null)
    {
    	$header['headscript'] = $this->functions->jsScript('events.js');
    	//$header['ckeditor'] = true;
    	$header['timeentry'] = true;
    	$header['googleMaps'] = true;
        $header['onload'] = "events.indexInit();";
    
    	try
    	{
    		$body['location'] = $location;
    		
    		$body['month'] = $month = (empty($month)) ? date("n") : $month;
            $body['year'] = $year = (empty($year)) ? date("Y") : $year;

            //$body['navbarBrand'] = "<a href='#' class='navbar-brand'>" . date("F Y", mktime(0, 0, 0, $month, 1, $year)) . "</a>";
			$body['listings'] = $this->profile->getUserAssignedLocations($this->session->userdata('userid'));    		

			$body['events'] = $this->events->getEvents($location);
    	}
    	catch (Exception $e)
    	{
    		$this->functions->sendStackTrace($e);
    	}
    
	    $this->load->view('template/header', $header);
        $this->load->view('events/index', $body);
        $this->load->view('template/footer');
    }
    
    public function edit ($location, $month, $year, $id = 0)
    {
    	$header['headscript'] = $this->functions->jsScript('events.js');
    	$header['ckeditor'] = true;
    	$header['timeentry'] = true;
        $header['onload'] = "events.editInit();";
        
        $body['location'] = $location;
        $body['month'] = $month;
        $body['year'] = $year;
        $body['id'] = $id;
        
        try
        {
        	$body['locations'] = $this->profile->getUserAssignedLocations($this->session->userdata('userid'));
        	
        	$body['repeatTypes'] = $this->functions->getCodes(30, 0, 'code');
        	$body['expLvls'] = $this->functions->getCodes(31, 0, 'code');
        	       
        	if (!empty($id))
        	{
	        	$body['info'] = $info = $this->events->getEventInfo($id);
	        	
	        	$body['videos'] = $this->events->getEventVideos($id);
	        	$body['files'] = $this->events->getEventFiles($id);
	        	
	        	$body['fromDate'] = $this->functions->convertTimezone($this->session->userdata('userid'), $info->fromDate, "Y-m-d");
	        	$body['fromTime'] = $this->functions->convertTimezone($this->session->userdata('userid'), $info->fromDate, "h:i:A");
				
	        	$body['toDate'] = $this->functions->convertTimezone($this->session->userdata('userid'), $info->toDate, "Y-m-d");
	        	$body['toTime'] = $this->functions->convertTimezone($this->session->userdata('userid'), $info->toDate, "h:i:A");
	        	
        	}
        }
        catch (Exception $e)
        {
        	$this->functions->sendStackTrace($e);
        }
    
	   	$this->load->view('template/header', $header);
        $this->load->view('events/edit', $body);
        $this->load->view('template/footer'); 
    }
    

	public function save ()
	{
		if ($_POST)
		{
			try
			{
				if (empty($_POST['id']))
				{
					$event = $this->events->insertEvent($_POST);
				}
				else
				{
					$event = $_POST['id'];
					
					$this->events->updateEvent($_POST);
					
					// clear out previous saved videos
					$this->events->clearVideos($event);
				}			
			}
			catch (Exception $e)
			{
				$this->functions->sendStackTrace($e);
				header("Location: /events/index/{$_POST['eventLocation']}/{$_POST['month']}/{$_POST['year']}?site-error=" . urlencode('Database error saving event!'));
				exit;
			}
			
			// saves uploaded files
			if ($_FILES)
			{
				try
				{
					$path = 'public' . DS . 'uploads' . DS . 'events' . DS . $event . DS; 
	
	                // ensures company uploads directory has been created
	                $this->functions->createDir($path);
	
	                $config['upload_path'] = './' . $path;
	                $config['allowed_types'] = "gif|jpg|png|xls|xlsx|doc|docx|pdf|csv|txt";
	                $config['max_size'] = "5120";
	                $config['encrypt_name'] = true;
	
	                // loads upload library
	                $this->load->library('upload', $config);
	                
                    foreach ($_FILES['file']['name'] as $k => $file)
                    {
                        //$imgPostID = 0;
						//error_log("Image Name: {$k}:{$img}");

                        if (!empty($file))
                        {
                        	$_FILES['userfile']['name'] = $_FILES['file']['name'][$k];
					        $_FILES['userfile']['type'] = $_FILES['file']['type'][$k];
					        $_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'][$k];
					        $_FILES['userfile']['error'] = $_FILES['file']['error'][$k];
					        $_FILES['userfile']['size'] = $_FILES['file']['size'][$k];
                        
                            if (!$this->upload->do_upload('userfile'))
                            {
                                throw new Exception("Unable to upload file!" . $this->upload->display_errors());
                            }

                            $uploadData = $this->upload->data();
 
							$fileID = $this->events->insertFile($event, $uploadData['file_name'], $_FILES['file']['name'][$k]);
							
							$this->events->sendFileToBMS($event, $path, $uploadData['file_name']);
                        }
                    }
	                
				}
				catch (Exception $e)
				{
					$this->functions->sendStackTrace($e);
				}
			}
			
			// will now upload videos
			if (!empty($_POST['videoUrl']))
			{
				foreach ($_POST['videoUrl'] as $k => $v)
				{
					if (!empty($v))
					{
						try
						{
							$this->events->insertVideo($event, $v);
						}
						catch (Exception $e)
						{
							$this->functions->sendStackTrace($e);
						}	
					}
				}
			}
			

			header("Location: /events/index/{$_POST['eventLocation']}/{$_POST['month']}/{$_POST['year']}?site-success=" . urlencode('Event has been saved!'));
			exit;
		}
	}
	
    /**
     * TODO: short description.
     *
     * @return TODO
     */
    public function event_modal ($id, $eventLocation, $month, $year)
    {
        $body['id'] = $id;

		$body['eventLocation'] = $eventLocation;
		$body['month'] = $month;
		$body['year'] = $year;

        try
        {
            $body['info'] = $info = $this->events->getEventInfo($id);
            //$body['editPerm'] = $this->modules->checkPermission($this->router->fetch_class(), 1); // permission to edit events

            if (empty($info->location))
            {
                $body['location'] = $info->otherLocation;

                $body['lat'] = $info->lat;
                $body['lng'] = $info->lng;
            }
            else
            {
                $body['location'] = $this->functions->getLocationName($info->location);

				$locLL = $this->functions->getLocLatLng($info->location);

                // gets lat/lng from location
                $body['lat'] = $locLL->lat;
                $body['lng'] = $locLL->lng;
            }

            if ($info->allDay == 1)
            {
            	$body['from'] = date("m/d/Y", strtotime($info->fromDate));
            	$body['to'] = date("m/d/Y", strtotime($info->toDate));
                //$body['from'] = $this->functions->convertTimezone($this->session->userdata('userid'), $info->fromDate, "m/d/Y") . ' All day';
                //$body['to'] = $this->functions->convertTimezone($this->session->userdata('userid'), $info->toDate, "m/d/Y") . ' All day';
            }
            else
            {
                $body['from'] = $this->functions->convertTimezone($this->session->userdata('userid'), $info->fromDate, "m/d/Y g:i A");
                $body['to'] = $this->functions->convertTimezone($this->session->userdata('userid'), $info->toDate, "m/d/Y g:i A");
            }

            $body['createdBy'] = $this->functions->getUserName($info->userid);
            
            if ($info->repeat == 1)
            {
	            $body['repeatSummary'] = $this->events->repeatSummary($id);
            }
            
        }
        catch (Exception $e)
        {
            $this->functions->sendStackTrace($e);
        }

        $this->load->view('events/event_modal', $body);
    }
    
    public function deletefile ()
    {
	    if ($_POST)
	    {
		    try
		    {
		    	$this->events->deleteFile($_POST['id'], $_POST['event']);
		    	
		    	$this->functions->jsonReturn('SUCCESS', 'File has been deleted!');
		    }
		    catch (Exception $e)
		    {
		    	$this->functions->sendStackTrace($e);
		    	$this->functions->jsonReturn('ERROR', $e->getMessage());
		    }
	    }
    }
    
    public function deletevideo ()
    {
	    if ($_POST)
	    {
		    try
		    {
		    	$this->events->clearVideoByID($_POST['id']);
		    
		    	$this->functions->jsonReturn('SUCCESS', 'Video has been deleted!');
		    }
		    catch (Exception $e)
		    {
		    	$this->functions->sendStackTrace($e);
		    	$this->functions->jsonReturn('ERROR', $e->getMessage());
		    }
	    }
    }
    
    public function deleteevent ()
    {
	    if ($_POST)
	    {
		    try
		    {
		    	$this->events->deleteEvent($_POST['id']);
		    	
		    	$this->functions->jsonReturn('SUCCESS', 'Event has been deleted!');
		    }
		    catch (Exception $e)
		    {
		  	 	$this->functions->sendStackTrace($e);
		    	$this->functions->jsonReturn('ERROR', $e->getMessage());
		    }
	    }
    }

}