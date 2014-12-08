<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id='chat-html' style='display:none'>
	<div class='chat-container' style="opacity:0;">
		<div class='chat-header'>

			<button type='button' class='close' aria-hidden="true">&times;</button>

			<button type='button' class='close' aria-hidden="true">&#8599;</button>
			
			<button type='button' class='close' aria-hidden="true">&dash;</button>

			<span>Firstname Lastname</span>
		</div> <!-- /.chat-header -->
	
		<div class='chat-min-container'>
	
			<div class='chat-body'></div> <!-- /.chat-body -->
			
			<div class='chat-text'>
				<textarea name='msg' id='msg'></textarea>
			</div> <!-- /.chat-text -->
		
		</div> <!-- /.chat-min-container -->
		
	</div> <!-- /.chat-container -->

</div> <!-- /#chat-html -->


<div id='chat-from-html' style='display:none'>

	<div class='chat-msg'>
		
	</div> <!-- /.chat-msg -->
	
</div> <!-- /#chat-from-html -->