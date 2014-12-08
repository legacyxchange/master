<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>

<style type='text/css'>
.modal-backdrop
{
	background-color: #FFF;
}

</style>

<?php

$attr = array
    (
        'id' => 'repeatEventForm',
        'name' => 'repeatEventForm'
    );

echo form_open_multipart('/events/save', $attr);
?>

<input type='hidden' name='eventLocation' id='eventLocation' value='<?=$location?>'>
<input type='hidden' name='month' id='month' value='<?=$month?>'>
<input type='hidden' name='year' id='year' value='<?=$year?>'>

<input type='hidden' name='id' id='id' value='<?=$id?>'>

<div class='container page-content'>
	<div class='row'>
		<div class='col-md-12 col-bg'>
			
			
			<div class='row'>
				<div class='col-xs-12 col-sm-12 col-md-6'>
					<h1><?=(empty($id)) ? 'Create' : 'Edit'?> Event</h1>
				
					<input type='text' class='form-control' name='title' id='title' value="<?=$info->name?>" placeholder="Event Title">
					
					<div class='row'>
		  
						  <div class='col-md-12 timedash'>-</div>
						  
						  <div class='col-md-3'><input type='text' class='form-control' name='startDate' id='startDate' value="<?=$fromDate?>" placeholder='<?=date("Y-m-d")?>'></div>
						  <div class='col-md-3'><input type='text' class='form-control' name='startTime' id='startTime' value="<?=$fromTime?>" placeholder='10:00AM'></div>
						  

						  <div class='col-md-3'><input type='text' class='form-control' name='endTime' id='endTime' value="<?=$toTime?>" placeholder='5:30PM'></div>
						  <div class='col-md-3'><input type='text' class='form-control' name='endDate' id='endDate' value="<?=$toDate?>" placeholder='<?=date("Y-m-d")?>'></div>
						  
					</div> <!-- /.row -->

					<div class='row'>
						<div class='col-md-12 eventCheckboxes'>
							<div class='checkbox'>
								<label>
									<input type='hidden' name='allDay' value='0'>
									<?php
									$allDayChecked = (!empty($info->allDay)) ? "checked='checked'" : null;
									?>
									<input type='checkbox' name='allDay' id='allDay' value='1' <?=$allDayChecked?>> All Day
								</label>
							</div>
							
							<input type='hidden' name='repeatEvent' value='0'>
							
							<div class='checkbox'>
								<label>
								<?php
								$repeatChecked = (!empty($info->repeat)) ? "checked='checked'" : null;
								?>
									<input type='checkbox' name='repeatEvent' id='repeatEvent' value='1' <?=$repeatChecked?>> 
								</label>
								
								<span id='repeatCheck'>Repeat...</span>
							</div>

							
						</div>
					</div>



					<h3>Upload Attachments</h3>
		  
				  <div class='row eventInputMargin'>
				  	<div class='col-md-12'>
				  		<button type='button' class='btn btn-link' id='videoUploadBtn'><i class='fa fa-plus'></i> Videos</button>
				  		<button type='button' class='btn btn-link' id='photoUploadBtn'><i class='fa fa-plus'></i> Photos</button>
				  		<button type='button' class='btn btn-link' id='fileUploadBtn'><i class='fa fa-plus'></i> Attachments</button>
				  	</div>
				  </div>
		
				  
				  <div id='uploadContainer'>
					  <?php
					  	if (!empty($videos))
					  	{
					  		//print_r($videos);
					  	
						  	foreach ($videos as $r)
						  	{
						  		$body = array();
						  		
						  		$body['url'] = $r->url;
						  		$body['id'] = $r->id;
						  		
							  	$this->load->view('events/video_upload', $body);
						  	}
					  	}
					  	
					  	if (!empty($files))
					  	{
					  		foreach ($files as $r)
					  		{
						  		$path = "/public/uploads/events/{$id}/";


							  	echo <<< EOS
							  	<div class='fileUploadContainer'>
								  	<div class='row eventInputMargin'>
								  		<div class='col-md-6'>
								  			<a href='{$path}{$r->fileName}' target='_blank'>{$r->orgFileName}</a>
								  		</div> <!-- /.col-md-6 -->
								  		
								  		<div class='col-md-6'>
								  			<button type='button' class='btn btn-danger pull-right' onclick="events.removeFileUploaded(this, {$id}, {$r->id});"><i class='fa fa-trash-o'></i></button>
								  		</div> <!-- /.col-md-6 -->
								  	</div> <!-- /.row -->
							  	</div> <!-- /.fileUploadContainer -->
EOS;
							}
					  	}
					  ?>
				  </div>
		
		<?php if (empty($location)) : ?>
				  <div class='row eventInputMargin'>
				  	<div class='col-md-12'>
				  		<select class='form-control' id='eventLocationSel' name='eventLocationSel'>
				  			<option value=''>SELECT A LOCATION</option>
				  			<?php
				  			if (!empty($locations))
				  			{
					  			foreach ($locations as $location)
					  			{
					  				try
					  				{
					  					$locName = $this->dojos->getLocationCol($location, 'name');
					  				}
					  				catch (Exception $e)
					  				{
					  					$this->functions->sendStackTrace($e);
					  					continue;
					  				}
					  			
						  			echo "<option value='{$location}'>{$locName}</option>" . PHP_EOL;
					  			}
				  			}
				  			?>
				  			<option value='OTHER'>OTHER LOCATION</option>
				  		</select>
				  	</div> <!-- /.col-12 -->
				  </div> <!-- /.row -->
		
				  <div class='row eventInputMargin' id='otherLocRow' style='display:none;'>
				  	<div class='col-md-12'>
				  		<input type='text' class='form-control' name='otherLocation' id='otherLocation' value="" placeholder="Location">
				  	</div> <!-- /.col-12 -->
				  </div> <!-- /.row -->
		
		<?php endif; ?>
					
				  <div class='row eventInputMargin'>
				  	<div class='col-md-12'>
				  		<select class='form-control' name='expLvl' id='expLvl'>
				  			<option value=''>EXPERIENCE LEVEL</option>
				  			<?php
				  			if (!empty($expLvls))
				  			{
					  			foreach ($expLvls as $r)
					  			{
					  				$sel = ($info->expLvl == $r->code) ? "selected='selected'" : null;
					  			
						  			echo "<option {$sel} value='{$r->code}'>{$r->display}</option>" . PHP_EOL;
					  			}
				  			}
				  			?>
				  		</select>
				  	</div> <!-- /.col-12 -->
				  </div> <!-- /.row -->
		
				  <div class='row eventInputMargin'>
				  	<div class='col-md-12'>
				  		<div class="input-group">
						  <span class="input-group-addon"><i class='fa fa-dollar'></i></span>
						  <input type="text" class="form-control" name='price' id-'price' value="<?=$info->price?>" placeholder="PRICE OF EVENT">
						  <span class="input-group-addon">.00</span>
						</div>
				  	</div> <!-- /.col-12 -->
				  </div> <!-- /.row -->
		
					
				</div> <!-- /.col-md-6 -->
			
				<div class='col-xs-12 col-sm-12 col-md-6'>
					 <h3>Description</h3>
					 
					 <textarea class='form-control' name='description' id='description' rows='5'><?=$info->description?></textarea>
				</div> <!-- /.col-md-6 -->
			
			</div> <!-- /.row -->
			
			<div class='row'>
				<div class='col-md-12'>
					<hr>
				
					<?php if (!empty($id)) : ?>
						<button type='button' class='btn btn-danger' name='deleteBtn' id='deleteBtn'><i class='fa fa-trash-o'></i></button>
					<?php endif; ?>
				
					<button type='button' id='saveBtn' class='btn btn-primary pull-right' style="margin-left:15px;"><i class='fa fa-save'></i> Save</button>
					<button type='button' id='cancelBtn' class='btn btn-default pull-right'><i class='fa fa-times-circle'></i> Cancel</button>
				</div>
			</div> <!-- /.row -->
			
			
			
		</div> <!-- /.col-md-12 -->
	</div> <!-- /.row -->
</div> <!-- /.container /.page-content -->

<?php
	$body = array();
	$body['repeatTypes'] = $repeatTypes;
	$body['location'] = $location;
	$body['info'] = $info;
	$body['id'] = $id;
	
	$this->load->view('events/repeat_modal', $body);
?>


</form>

<div id='videoUploadHtml' class='hide'>
<?php
	$body = array();
	$body['url'] = '';
	$this->load->view('events/video_upload', $body);
?>
</div> <!-- /#videoUploadHtml -->

<div id='fileUploadHtml' class='hide'>
	<div class='fileUploadContainer'>
		<div class='row eventInputMargin'>
			<div class='col-md-6'>
				<input type='file' name='file[]'>
			</div> <!-- /.col-md-6 -->
			<div class='col-md-6'>
				<button type='button' class='btn btn-danger pull-right' onclick="events.removeFileUpload(this);"><i class='fa fa-trash-o'></i></button>
			</div> <!-- /.col-md-6 -->
			
		</div> <!-- /.row -->
	</div> <!-- /.fileUploadContainer -->
</div> <!-- /#fileUploadHtml -->