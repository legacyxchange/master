<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>

  <!--@modal - signup modal-->
  <div class="container main-content" id="forgotpassword">
    <div class="dialog">
      <div class="content">						
			<div class="body">
				<div class="row">
					<div class="col-lg-12">
			        	<?php echo form_open('/welcome/forgotpassword', array('name' => 'forgotpasswordform', 'id' => 'forgotpasswordform'));?>
			        	<div id='loginAlert'></div>
						<p style="font-size:14px;">Please enter the
							E-Mail address you used when you signed up. We will send a temporary password to the email you enter if valid.</p>
						<div class="form-group  form">
							<label for="inputEmail">Email</label> <input type='text'
								class='form-control' name='user_email' id='user_email' value=""
								placeholder='E-MAIL ADDRESS'>
						</div>
						<!-- .form-group -->
						
						<div class="form-action">
							<input type="submit" class="btn btn-primary btn-sm" id='submitBtn' value="SUBMIT" />
						</div>				
						<?php echo form_close();?>
	   				</div>										          			
				</div>
			</div>
			
		</div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->