<?php
namespace chatsocket;

date_default_timezone_set('UTC');


if (PHP_SAPI == 'cli')
{
	$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(dirname(dirname(__dir__))));
	
	$_SERVER['DOCUMENT_ROOT'] = rtrim($_SERVER['DOCUMENT_ROOT'], '/').'/';
	
}

ob_start();
$system_path = $_SERVER['DOCUMENT_ROOT'] . 'system';

$application_folder = $_SERVER['DOCUMENT_ROOT'] . 'application';

include_once $_SERVER['DOCUMENT_ROOT'] . 'index.php';
ob_end_clean();







use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;
use Exception;

class Chat implements MessageComponentInterface
{
	protected $clients, $ci, $users;
	
	function __construct()
	{
		$this->clients = new \SplObjectStorage;
		$this->ci =& \get_instance();
		$this->users = array();
		
	}
	
    public function onOpen(ConnectionInterface $conn)
    {
    	try
    	{
			$this->clients->attach($conn);
	  	
		  	$cookies = $conn->WebSocket->request->getCookies();
		  	
		  	$userid = self::getUserID($cookies);
    	
		  	if ($userid === false) throw new Exception("Unable to connect, you must be logged in!");
    	
		  	$this->users[$userid][] = $conn->resourceId;
		  	
  			echo "New Connection {$userid}:{$conn->resourceId}" . PHP_EOL;
    	}
    	catch (Exception $e)
    	{
    		PHPFunctions::sendStackTrace($e);
    		
    		echo "ERROR: " . $e->getMessage() . PHP_EOL;
    		//$this->clients->detach($conn);
    	}



    }

    public function onMessage(ConnectionInterface $from, $msg) 
    {
    	$json = self::isJson($msg);

		if ($json)
		{
			$data = json_decode($msg, true);
			
			//echo "RAW DATA: " . print_r($data, true);

			$data['msg'] = nl2br($data['msg']);
			
			$data['msg'] = strip_tags($data['msg'], '<br><a>');

		
			// message being sent to someone
			if (!empty($data['to']))
			{
				// gets all resourceIDs for the UserID
				$res = $this->_getUserIDResources($data['to']);
				
				// sends the message to everyone connected to that user
				if (!empty($res))
				{
					$sendData = $this->_prepareSend($data['to'], $data['from'], $data['msg']);
					echo "Send Msg " . print_r($sendData, true);
					
					foreach ($res as $k => $rid)
					{
						
						$to = $this->_getConn($rid);
						
						if ($to === false)
						{
							continue;	
						} 


						$to->send($sendData);			
					}
				}
				
				// will now send to other clients logged in as the user
				
				$res = $this->_getUserIDResources($data['from']);
				
				if (!empty($res))
				{
					$sendData = $this->_prepareSend($data['to'], $data['from'], $data['msg'], array('type' => 'ping'));
					echo "Send Ping " . print_r($sendData, true);
					
								
					foreach ($res as $k => $rid)
					{
						if ($rid == $from->resourceId) continue;
						
						$to = $this->_getConn($rid);
						
						if ($to === false)
						{
							continue;	
						} 


						$to->send($sendData);			
					}
				}
			
			}
		}

    }

    public function onClose(ConnectionInterface $conn)
    {
    	$userid = $this->_getResourceUserID($conn);
    	
		$this->clients->detach($conn);
		
		if (!empty($this->users))
		{
			foreach ($this->users as $k => $rid)
			{
				if ($rid == $conn->resourceId)
				{
					unset($this->users[$userid][$k]);
					break;
							
				}
			}
		}
		


        echo "Connection {$userid}:{$conn->resourceId} has disconnected" . PHP_EOL;
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
    
    private function _getConn ($resourceId)
    {
	    if (empty($this->clients)) return false;
	    
	    $c = '';

	    foreach ($this->clients as $conn)
	    {		
	    	if ((int) $conn->resourceId == (int) $resourceId)
	    	{
				//echo "MATCH: {$conn->resourceId}:{$resourceId}" . PHP_EOL;
		    	return $conn;
		    	//break;
	    	}   
	    }
	    
	    return false;
    }
    
    private function _getResourceUserID (ConnectionInterface $conn)
    {
	    if (empty($this->users)) return false;
	    
	    $user = 0;

		$resource = $conn->resourceId;
	    
	    //echo "Users array: " . print_r($this->users, true). PHP_EOL;
	    
	    foreach ($this->users as $userid => $rarray)
	    {

	    
	    	//echo "Checking: {$resource} | {$rid}" . PHP_EOL;
		    if (in_array($resource, $rarray))
		    {
			    $user = $userid;
			    break;
		    }
	    }
	    
	    return $user;
    }
    
    /**
    * gets array of resource ID's that are connected to the user
    */
    private function _getUserIDResources ($userid)
    {
	    if (empty($userid)) throw new Exception("User ID is empty!");
	    
		if (empty($this->users)) return false;
		
		//echo "_getUserIDResources: {$userid}" . PHP_EOL;
		
		$res = array();
		
		$resourceId = 0;
		
		foreach ($this->users as $k => $v)
		{
			if ($userid == $k)
			{
				$res = array_merge($res, $v);
			}
		}
		
		return $res;
    }
    
    
    private function _prepareSend ($to, $from, $msg, $attr = null)
    {
	    $data = array();
	    
	    $data['to'] = $to;
	    $data['msg'] = $msg;
	    $data['from'] = $from;
	    
	    //$data['from'] = $this->_getResourceUserID($from);
	    	    
	    if (!empty($attr) && is_array($attr))
	    {
		    foreach ($attr as $k => $v)
		    {
			    $data[$k] = $v;
		    }
	    }
	    
	    return json_encode($data);
    }

	public static function isJson ($string)
	{
		return is_object(json_decode($string));
	}

	/**
	* goes through CI session and gets the userid
	*/
	private static function getUserID ($cookies)
	{
		$cis = $cookies['ci_session'];
		
		$cis = urldecode($cis);
		
		$chunks = explode(';', $cis);

		if (!empty($chunks))
		{
			foreach ($chunks as $k => $v)
			{
				if ($pv == 's:6:"userid"')
				{
					
					$id = intval(substr($v, 2));
					break;
				}
				
				$pv = $v;
			}
		}
		
		
		if (empty($id)) return false;
		
		return $id;
	}
}