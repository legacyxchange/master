<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class='static-content'>

<div class='row'>
	<div class='col-md-12'>
		<img class='img-responsive post-img' src='<?=$this->config->item('bmsUrl')?>user/profileimg/40/<?=$info->uploadedBy?>'>
		
		<div class='wallpost-name'><a href='/user/index/<?=$info->uploadedBy?>'><?=$usersname?></a></div> <!-- /.wallpost-name -->
	
		<div class='wallpost-time text-muted'><?=$date?></div>
	</div>
</div> <!-- /.row -->


<div id='photo-alert'></div>
<?php

if (empty($likes)) $displayLikes = "display:none;";
		
if (!empty($info->caption)) echo "<div class='photo-caption'>" . nl2br($info->caption) . "</div> <!-- /.photo-caption -->" . PHP_EOL;




echo <<< EOS
			<div class='like-container' style="{$displayLikes}">
			{$likeTxt}
			</div> <!-- /.like-container -->
EOS;


	if ($this->session->userdata('logged_in') == true)
	{

		if (!$liked) $likeBtn = "<button type='button' class='btn btn-link' onclick=\"wall.likePhoto(this, {$r->id});\"><i class='fa fa-thumbs-o-up'></i></button>";
		else $likeBtn = "<button type='button' class='btn btn-link' onclick=\"wall.unlikePhoto(this, {$r->id});\"><i class='fa fa-thumbs-o-down'></i></button>";
		
		echo <<< EOS
				<div class='wallpost-actions'>
					{$likeBtn}
					<button type='button' class='btn btn-link'><i class='fa fa-share-alt'></i></button>
				</div>
EOS;

	$attr = array
	(
		'name' => 'photoCommentForm',
		'id' => 'photoCommentForm' 
	);
	echo form_open('#', $attr);
	
	echo "<input type='hidden' name='photoID' value='{$photoID}'>" . PHP_EOL;
	
	echo <<< EOS
	<div class='comment-new-container'>
		<img class='img-responsive photo-img' src='{$this->config->item('bmsUrl')}user/profileimg/40/{$this->session->userdata('userid')}'>
		
		<div class='ct-container'>
			<textarea rows='1' class='form-control' placeholder="Leave a comment..." name='post' id='caption'></textarea>
			
		</div>
		<div class='clearfix'></div>
	</div>
EOS;

	echo "</form>";
	}
	

	echo "</div> <!-- /.static-content -->" . PHP_EOL;
	echo "<div class='' id='photo-scroll'>" . PHP_EOL;

	// comments here
	
	if (!empty($comments))
	{
		foreach ($comments as $r)
		{
			try
			{
				$r->body = nl2br($r->body);
				
				$usersName = $this->functions->getUserName($r->userid);
				
				$tzUserid = ($this->session->userdata('logged_in') == true) ? $this->session->userdata('userid') : $r->userid;
				
				$date = $this->functions->convertTimezone($tzUserid, $r->datestamp, "F j Y g:iA");
			}
			catch (Exception $e)
			{
				$this->functions->sendStackTrace($e);
				continue;
			}
		
			echo <<< EOS
			<div class='comment-container'>
				<img class='img-responsive post-img' src='{$this->config->item('bmsUrl')}user/profileimg/40/{$r->userid}'>
				
				<div class='wallpost-name'><a href='/user/index/{$cr->userid}'>{$usersName}</a></div> <!-- /.wallpost-name -->
			
				<div class='wallpost-time text-muted'>{$date}</div>
				
				<div class='comment-body'>{$r->body}</div>
			</div>				
EOS;
		}
	}	

echo "</div> <!-- /.#slimscroll -->" . PHP_EOL;

