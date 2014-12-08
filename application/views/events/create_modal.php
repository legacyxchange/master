<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="modal fade" id='createEventModal'>
  <div class="modal-dialog">
    <div class="modal-content">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title">Create New Event</h3>
      </div> <!-- modal-header -->
<?php

$attr = array
    (
        'id' => 'createEventForm',
        'name' => 'createEventForm'
    );

echo form_open('#', $attr);
?>
      <div class="modal-body">
		  <div id='createAlert'></div>

		  <div class='row'>
		  	<div class='col-md-12'>
			  	<input type='text' class='form-control' name='title' id='title' placeholder="Event Title">
		  	</div>
		  </div>
		  
		  <div class='row'>
		  
		  <div class='col-md-12 timedash'>-</div>
		  
		  <div class='col-md-3'><input type='text' class='form-control' name='startDate' id='startDate' placeholder='<?=date("m/d/Y")?>'></div>
		  <div class='col-md-3'><input type='text' class='form-control' name='startTime' id='startTime' placeholder='10:00AM'></div>
		  
		  <div class='col-md-3'><input type='text' class='form-control' name='endDate' id='endDate' placeholder='<?=date("m/d/Y")?>'></div>
		  <div class='col-md-3'><input type='text' class='form-control' name='endTime' id='endTime' placeholder='5:30PM'></div>
		  </div> <!-- /.row -->

		  
		  <h5>Repeat Event</h5>
		  
		  <div class='row'>
		  	<div class='col-md-3'><div class='checkbox'><label><input type='checkbox'> Every Day</label></div></div>
		  	<div class='col-md-3'><div class='checkbox'><label><input type='checkbox'> Mondays</label></div></div>
		  	<div class='col-md-3'><div class='checkbox'><label><input type='checkbox'> Tuesdays</label></div></div>
		  	<div class='col-md-3'><div class='checkbox'><label><input type='checkbox'> Wednesdays</label></div></div>
		  </div> <!-- /.row -->


		  <div class='row'>
		  	<div class='col-md-3'><div class='checkbox'><label><input type='checkbox'> Thursdays</label></div></div>
		  	<div class='col-md-3'><div class='checkbox'><label><input type='checkbox'> Fridays</label></div></div>
		  	<div class='col-md-3'><div class='checkbox'><label><input type='checkbox'> Saturdays</label></div></div>
		  	<div class='col-md-3'><div class='checkbox'><label><input type='checkbox'> Sundays</label></div></div>
		  </div> <!-- /.row -->

		  <h5>Upload Attachments</h5>
		  
		  <div class='row'>
		  	<div class='col-md-12'>
		  		<button type='button' class='btn btn-link'><i class='fa fa-plus'></i> Videos</button>
		  		<button type='button' class='btn btn-link'><i class='fa fa-plus'></i> Photos</button>
		  		<button type='button' class='btn btn-link'><i class='fa fa-plus'></i> Attachments</button>
		  	</div>
		  </div>


		  <div class='row'>
		  	<div class='col-md-12'>
		  		<select class='form-control' id='eventLocation' name='eventLocation'>
		  			<option value=''>SELECT A LOCATION</option>
		  			<option value='OTHER'>OTHER LOCATION</option>
		  		</select>
		  	</div> <!-- /.col-12 -->
		  </div> <!-- /.row -->

		  <div class='row' id='otherLocRow' style='display:none;'>
		  	<div class='col-md-12'>
		  		<input type='text' class='form-control' name='otherLocation' id='otherLocation' value="" placeholder="Location">
		  	</div> <!-- /.col-12 -->
		  </div> <!-- /.row -->
		  

		  <div class='row'>
		  	<div class='col-md-12'>
		  		<select class='form-control'>
		  			<option value=''>EXPERIENCE LEVEL</option>
		  		</select>
		  	</div> <!-- /.col-12 -->
		  </div> <!-- /.row -->

		  <div class='row'>
		  	<div class='col-md-12'>
		  		<div class="input-group">
				  <span class="input-group-addon"><i class='fa fa-dollar'></i></span>
				  <input type="text" class="form-control" name='price' id-'price' placeholder="PRICE OF EVENT">
				  <span class="input-group-addon">.00</span>
				</div>
		  	</div> <!-- /.col-12 -->
		  </div> <!-- /.row -->


		  <h5>Description</h5>

		  <div class='row'>
		  	<div class='col-md-12'>
		  		<textarea class='form-control' name='description' id='description' rows='5'></textarea>
		  	</div> <!-- /.col-12 -->
		  </div> <!-- /.row -->
		  
		  

      </div> <!-- /.model-body -->
      
      <div class="modal-footer">
        <div class='row'>
            <div class='col-md-6 login-options'>
           
            </div>

            <div class='col-md-6'>
                <button type="button" class="btn btn-red" id='submitLoginBtn' onclick="global.userlogin(this);">Save</button>
            </div>
        </div>

      </div> <!-- modal-footer -->

    </form>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->