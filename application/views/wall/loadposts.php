<?php if(!defined('BASEPATH')) die('Direct access not allowed'); 


require_once './application/third_party/timeago/timeago.inc.php';


if (!empty($posts))
{
	foreach ($posts as $r)
	{
			
		echo "<div class='wallpost-container' postID='{$r->id}'>" . PHP_EOL;
		
		$this->load->view('wall/post', array('r' => $r));

			echo PHP_EOL . "<div id='all_comments_{$r->id}'>" . PHP_EOL;
			
			try
			{
				$comments = $this->wall->getPosts($userid, $r->id, 0, 0, 0, 'ASC');
			}
			catch (Exception $e)
			{
				$this->functions->sendStackTrace($e);
				continue;
			}
		
			if (!empty($comments))
			{
				foreach ($comments as $cr)
				{

					$this->load->view('wall/comment', array('postID' => $r->id, 'r' => $cr));

				}
			}

			echo "</div> <!-- /#all_comments_{$r->id} -->" . PHP_EOL;

			if ($this->session->userdata('logged_in') == true) $this->load->view('wall/new_comment', array('postID' => $r->id));
		
		echo "</div> <!-- /.wallpost=container -->" . PHP_EOL;
	}
}