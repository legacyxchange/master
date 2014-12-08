<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>

<div class='comment-new-container'>
	<img class='img-responsive comment-img' src='<?=$this->config->item('bmsUrl')?>user/profileimg/40/<?=$this->session->userdata('userid')?>'>
	<div class='ct-container'>
		<textarea rows='1' class='form-control' placeholder="Write a comment" postID='<?=$postID?>'></textarea>
	</div>
	
</div> <!-- /.comment-new-container -->
