<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//$ci =& get_instance();

trait ChatOLD
{

    public function set_chat_user_session ($userid)
    {	
		$chatting = $this->session->userdata('chatting');
    	
    	if (empty($chatting)) $chatting = array();
    	
    	//$this->load->model('chat_model', 'chat', true);
    	
    	if (!in_array($userid, $chatting)) $chatting[] = $userid;
    	
    	$this->session->set_userdata('chatting', $chatting);
    	
		PHPFunctions::jsonReturn('SUCCESS', "Now chatting with {$userid}");
    }
    
    

	public function end_chat_session ($userid)
	{
		$chatting = $this->session->userdata('chatting');
		
		if (!empty($chatting))
		{
			foreach ($chatting as $k => $user)
			{
				if ($userid == $user)
				{
					unset($chatting[$k]);
					break;
				}
			}
		}

    	$this->session->set_userdata('chatting', $chatting);

		PHPFunctions::jsonReturn('SUCCESS', "No longer chatting with {$userid}");
	}
	
	public function get_csrf_token ()
	{
		try
		{
			$token = $this->security->get_csrf_hash();		
		}
		catch (Exception $e)
		{
			
		}

	
		PHPFunctions::jsonReturn('SUCCESS', $token);
	}
	
	public function send_chat_msg ()
	{
		$this->load->model('chat_model', 'chat', true);
		
		if ($_POST)
		{
			try
			{
				$id = $this->chat->insertMsg($_POST['userid'], $this->session->userdata('userid'), $this->config->item('bmsCompanyID'), $_POST['msg']);
			}
			catch (Exception $e)
			{
				PHPFunctions::sendStackTrace($e);
				PHPFunctions::jsonReturn('ERROR', $e->getMessage());
			}
			
				PHPFunctions::jsonReturn('SUCCESS', "Message sent", true, $id);
		}
	}
	
	public function get_chat_content ()
	{
		$this->load->model('chat_model', 'chat', true);
			
		try
		{
			$body['msgs'] = $this->chat->getMsgs($_POST['users'], $this->session->userdata('userid'), $this->config->item('bmsCompanyID'));
		}
		catch (Exception $e)
		{
			PHPFunctions::sendStackTrace($e);
		}
		
		$this->load->view('chat/chat_content.php', $body);
	}

	
	public function getusersname ($userid)
	{
		try
		{
			$name = $this->bms_users->getname($userid);
			PHPFunctions::jsonReturn('SUCCESS', $name);
		}
		catch (Exception $e)
		{
			PHPFunctions::sendStackTrace($e);
			PHPFunctions::jsonReturn('ERROR', $e->getMessage());
		}
	}
}