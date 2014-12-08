<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>


<div class="modal fade" id='getStartedModal'>
  <div class="modal-dialog">
    <div class="modal-content">
    	<div class="modal-body">
    	
    	<div id='getStartedAlert'></div>
    	
    	<form id='modalSearch' method='get' action='/search' onsubmit="return welcome.cannaModalSubmit(false);">
    	
    	<input type='hidden' name='lat' id='lat' value='0'>
    	<input type='hidden' name='lng' id='lng' value='0'>
    	
    	<input type='hidden' name='location' id='location' value=''>
    	
    	
    	<h2><i class='fa fa-check-circle-o'></i> Getting Started</h2>
    
		<p>Please select an option or search.</p>
    
		<div class='input-group'>
			<input type='text' class='form-control' name='q' id='q' placeholder="Search" value="">
			<span class='input-group-btn'>
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
				<ul class="dropdown-menu">
		        <?php
		        try
				{
					$sports = $this->functions->getCodes(29, $this->config->item('bmsCompanyID'));
					
					if (!empty($sports))
					{
						foreach ($sports as $r)
						{
							echo " <li><a href='javascript:void(0);' onclick=\"welcome.styleSelectModal(this);\">{$r->display}</a></li>" . PHP_EOL;
						}
					}
				}
				catch (Exception $e)
				{
					$this->functions->sendStackTrace($e);
				}
		        ?>
		        </ul>
			</span>
		</div> <!-- /.input-group -->
		
		
		<hr>
		
		<h3><i class='fa fa-globe'></i> Finding Your Location ...</h3>
		
			<div class='locator'>
				<i class='fa fa-spinner fa-spin'></i>
			</div> <!-- .locator -->
			
			<button type='button' class='btn btn-default btn-lg searchBtn' onclick="welcome.cannaModalSubmit(true);"><i class='fa fa-search'></i> Search</button>
			
    	</form>
    	</div> <!-- modal-body -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
