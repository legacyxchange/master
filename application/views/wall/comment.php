<?php

if(!defined('BASEPATH')) die('Direct access not allowed');

	if (!empty($r))
	{
		try
		{
			$commentBody = $this->wall->getPostBody($r->id);
			$usersName = $this->functions->getUserName($r->postingUser);
			
			$date = timeAgoInWords($r->datestamp, 'UTC');
		}
		catch (Exception $e)
		{
			$this->functions->sendStackTrace($e);
		}
		
		$commentBody = nl2br($commentBody);
		
		$hideDeleteBtn = ($r->postingUser == (int) $this->session->userdata('userid')) ? false : true;
				
		// if user is viewing their own contents profile, allows them to delete
		if ((int) $this->session->userdata('userid') == (int) $userid) $hideDeleteBtn = false;
	}
	
echo <<< EOS
<div class='comment-container' commentID='{$r->id}'>
	<input type='hidden' name='commentID[{$postID}][]' value='{$r->id}'>
		<div class='deleteBtn'>
EOS;

	if (!$hideDeleteBtn) echo "<button type='button' class='close txt-danger' style=\"opacity:0\" onclick=\"wall.deleteComment(this);\"><i class='fa fa-trash-o'></i></button>";

echo <<< EOS
		</div>
	
	<img class='img-responsive post-img' src='{$this->config->item('bmsUrl')}user/profileimg/40/{$r->postingUser}'>
	
	<div class='wallpost-name'><a href='/user/index/{$r->postingUser}'>{$usersName}</a></div> <!-- /.wallpost-name -->

	<div class='wallpost-time text-muted'>{$date} ago</div>
	
	<div class='comment-body'>{$commentBody}</div>
</div> <!-- /.comment-container -->
EOS;


?>

