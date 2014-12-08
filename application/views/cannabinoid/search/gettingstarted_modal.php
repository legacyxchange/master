<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="modal fade" id='getStartedModal'>
  <div class="modal-dialog">
    <div class="modal-content">
    	<div class="modal-body bluespa-modal">
    	
    	<div id='getStartedAlert'></div>
    	
    	<form id='modalSearch' method='get' action='/search'>
		
		<input type='hidden' name='q' id='q' value='Dispensaries'>
		    	
    	<input type='hidden' name='lat' id='lat' value='0'>
    	<input type='hidden' name='lng' id='lng' value='0'>
    	
    	<input type='hidden' name='location' id='location' value=''>
    	
		
		<h2><i class='fa fa-globe'></i> Finding Your Location</h2>
		
		<p id='unableTxt' style='display:none;'>We were unable to find your location. Please enter your location below.</p>
		
			<div class='locator'>
				<i id='locatorIcon' class='fa fa-spinner fa-spin'></i>

				<input type='text' class='form-control' name='location' id='location' value='' placeholder="Your Zipcode, City, State..." style="display:none;">
			</div> <!-- .locator -->
			
			
			
			
			<button type='button' class='btn btn-default btn-lg searchBtn' disabled='disabled' onclick="welcome.bluespaModalSubmit(this);" style="display:none;"><i class='fa fa-search'></i> Lets Go</button>
			
    	</form>
    	</div> <!-- modal-body -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->