<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>

<div class="admin-menu-container container ">
	<?php echo $admin_menu;?>
</div>
<div  style="border-bottom:2px solid #0a6e8e;border-top:2px solid #0a6e8e;background:#f4f4f4;margin-top: 20px;padding-top: 16px;">
    <h2 style="color:#016889;">MY SETTINGS</h2>
</div>
    <div class='row main-content'>
        <div class='col-md-8 col-md-offset-2'>
        	<div class='col-bg'>
            
            
<?php
	$tabActive[$tab] = 'active';
?>

<!-- Nav tabs -->

<!-- Tab panes -->
<div class="container content">
	<div class='col-lg-6 tab-pane active form-horizontal' id='settings'>
	
	<?php
	$attr = array
	(
		'name' => 'userForm',
		'id' => 'userForm'
	);
	
	echo form_open('#', $attr);
	?>
	<?php //var_dump($userinfo); exit;?>
	<input type="hidden" name="user_id" value="<?php echo $userinfo->user_id;?>" />
	<div class="form-group">
	    <label for="firstName" class="col-sm-3 control-label">First Name</label>
		<div class="col-sm-9">
			<input type='text' class='form-control' name='firstName' id='firstName' value="<?=$userinfo->firstName?>">
	    </div> <!-- col-9 -->
	</div> <!-- .form-group -->
	
	<div class="form-group">
	    <label for="lastName" class="col-sm-3 control-label">Last Name</label>
		<div class="col-sm-9">
			<input type='text' class='form-control' name='lastName' id='lastName' value="<?=$userinfo->lastName?>">
	    </div> <!-- col-9 -->
	</div> <!-- .form-group -->
	
	<div class="form-group">
	    <label for="username" class="col-sm-3 control-label">Username</label>
		<div class="col-sm-9">
			<input type='text' class='form-control' name='username' id='username' value="<?=$userinfo->username?>">
	    </div> <!-- col-9 -->
	</div> <!-- .form-group -->
	
	<div class="form-group">
	    <label for="addressline1" class="col-sm-3 control-label">Address</label>
		<div class="col-sm-9">
			<input type='text' class='form-control' name='addressLine1' id='addressLine1' value="<?=$userinfo->addressLine1?>">
	    </div> <!-- col-9 -->
	</div> <!-- .form-group -->
	
	<div class="form-group">
	    <label for="addressline2" class="col-sm-3 control-label">Address 2</label>
		<div class="col-sm-9">
			<input type='text' class='form-control' name='addressLine2' id='addressLine2' value="<?=$userinfo->addressLine2?>">
	    </div> <!-- col-9 -->
	</div> <!-- .form-group -->
	
	<div class="form-group">
	    <label for="city" class="col-sm-3 control-label">City</label>
		<div class="col-sm-9">
			<input type='text' class='form-control' name='city' id='city' value="<?=$userinfo->city?>">
	    </div> <!-- col-9 -->
	</div> <!-- .form-group -->
	
	<div class="form-group">
	    <label for="state" class="col-sm-3 control-label">State</label>
		<div class="col-sm-9">
			<input type='text' class='form-control' name='state' id='state' value="<?=$userinfo->state?>">
	    </div> <!-- col-9 -->
	</div> <!-- .form-group -->
	
	<div class="form-group">
	    <label for="postalcode" class="col-sm-3 control-label">Phone</label>
		<div class="col-sm-9">
			<input type='text' class='form-control' name='phone' id='phone' value="<?=$userinfo->phone?>">
	    </div> <!-- col-9 -->
	</div> <!-- .form-group -->
	
	<div class="form-group">
	    <label for="lastName" class="col-sm-3 control-label">Zipcode</label>
		<div class="col-sm-9">
			<input type='text' class='form-control' name='postalCode' id='postalCode' value="<?=$userinfo->postalCode?>">
	    </div> <!-- col-9 -->
	</div> <!-- .form-group -->
	
	<div class="form-group">
	    <label for="email" class="col-sm-3 control-label">E-Mail</label>
		<div class="col-sm-9">
			<input type='text' class='form-control' name='email' id='email' value="<?=$userinfo->email?>">
	    </div> <!-- col-9 -->
	</div> <!-- .form-group -->

	<div class="form-group">
	    <label for="" class="col-sm-3 control-label">DOB</label>
		<div class="col-sm-9">
			<div class='row'>
				<div class='col-md-5'>
				    <input type="date" name="dob" min='1940-01-01' value="<?php echo date('Y-m-d', strtotime($userinfo->dob));?>" />					
				</div> <!-- /.col-md-4 -->
			</div> <!-- /.row -->
	    </div> <!-- col-9 -->
	</div> <!-- .form-group -->
        <?php $selected[$userinfo->gender] = ($userinfo->gender) ? 'selected' : null; ?>
		<div class="form-group">
		    <label for="" class="col-sm-3 control-label">Gender</label>
			<div class="col-xs-12 col-sm-12 col-md-6">
				<select name='gender' id='gender' class='form-control'>
                    <option value=''></option>
                    <option <?php echo $selected['M']; ?> value='M'>Male</option>
                    <option <?php echo $selected['F']; ?> value='F'>Female</option>
                </select>
		    </div> <!-- col-9 -->
		</div> <!-- .form-group -->

		<div class="form-group">
		    <label for="" class="col-sm-3 control-label">Height</label>
			<div class="col-sm-9">
				<div class='row'>
					<div class='col-md-6'>
						<div class="input-group">
							<span class="input-group-addon">Feet</span>
							<input type='text' name='heightFeet' id='heightFeet' class='form-control' value="<?=$userinfo->heightFeet?>">
						</div> <!-- /.input-group -->
					</div> <!-- /.col-md-6 -->
					
					<div class='col-md-6'>
						<div class="input-group">
							<span class="input-group-addon">Inches</span>
								<input type='text' name='heightInches' id='heightInches' class='form-control' value="<?=$userinfo->heightInches?>">
						</div> <!-- /.input-group -->
					</div> <!-- /.col-md-6 -->
				</div> <!-- /.row -->
		    </div> <!-- col-9 -->
		</div> <!-- .form-group -->
		
		<div class="form-group">
		    <label for="" class="col-sm-3 control-label">Weight</label>
			<div class="col-sm-9">
				<div class='row'>
					<div class='col-md-3'>
						<input type='text' name='weight' id='weight' class='form-control' value="<?=$userinfo->weight?>">
					</div> <!-- /.col-md-8 -->
					
					<div class='col-md-3'>
						<select name='weightType' id='weightType' style="width:70px;" class='form-control'>
                            <option value='lbs'>lbs</option>
                            <option value="k">k</option>
                        </select>
					</div> <!-- /.col-md-4 -->
				</div> <!-- /.row -->			
		    </div> <!-- col-9 -->
		</div> <!-- .form-group -->

	<div class="form-group">
	    <label for="timezone" class="col-sm-3 control-label">Timezone</label>
		<div class="col-sm-9">
		<?php $selected[$userinfo->timezone] = ($userinfo->timezone) ? 'selected' : null; ?>
            <select id='timezone' name='timezone' class='form-control'>
                <option value=''></option>
            	<option <?php echo $selected['America/Los_Angeles']; ?> value='<?php echo $userinfo->timezone;?>'><?php echo $userinfo->timezone;?></option>
            </select>
	    </div> <!-- col-9 -->
	</div> <!-- .form-group -->

	
	<div class="form-group">
	    <label for="" class="col-sm-3 control-label">Website</label>
		<div class="col-sm-9">
			<input type='text' class='form-control' name='website' id='website' value="<?=$userinfo->companyWebsiteUrl?>">
	    </div> <!-- col-9 -->
	</div> <!-- .form-group -->
	
	<div class="form-group">
	    <label for="bio" class="col-sm-3 control-label">Bio</label>
		<div class="col-sm-9">
			<textarea class='form-control' name='bio' id='bio' rows='5'><?=$userinfo->bio?></textarea>
	    </div> <!-- col-9 -->
	</div> <!-- .form-group -->
	
	        <hr>
        
        <button type='button' class='btn btn-primary pull-right formbtn' id='saveSettingsBtn'><i class='fa fa-save'></i> Save</button>
        
	<?php echo form_close();?>
	
	</div>
	
	<div class="col-lg-6">
	<?php
		$attr = array
		(
			'name' => 'avatarUploadForm',
			'id' => 'avatarUploadForm'
		);
		
		echo form_open_multipart('/profile/uploadavatar', $attr);

	?>
	
	<div class='row'>
		<div class='col-md-6'>
			<img src='/user/profileimg/300/<?=$this->session->userdata('user_id')?>/<?php echo $userinfo->profileimg; ?>' class='img-thumbnail avatar'>
		</div>
		<div class='col-md-6'>
		<p>
		Click to browse your computer for the image, then simply click the Upload button. The image size should be 300 X 300 pixels or larger in .jpg, .gif or .png file formats only. 
		</p>
		
		<input type='file' name='avatar' id='avatar'>
	        
	    <button type='button' class='btn btn-primary' id='uploadImgBtn'><i class='fa fa-cloud-upload'></i> Upload Image</button>
	    
	    <?php if (!empty($facebookID)) : ?>
	    <!--
	    <hr>
	    <button type='button' class='btn btn-primary' id='facebookImgBtn' onclick="fb.syncPhoto(this);"><i class='fa fa-refresh'></i> Sync with Facebook</button>
	    -->
	    <?php endif; ?>
	    
		</div> <!-- .col6 -->
	</div> <!-- row -->
	<?php echo form_close();?>
	
<?php if (empty($facebookID)) : ?>
    <p style="font-size:14px;margin-top:20px;">Click here to connect through your facebook account.</p>
    
    <button class='pull-right btn btn-lg btn-primary' style="padding-top:6px;margin-top:-10px;" id='connectFBbtn'>Connect Using Facebook</button>
<?php else: ?>
    <p>Your account is linked with Facebook.</p>

    <button class='btn btn-lg btn-danger' id='unlinkFBbtn'>Unlink Facebook Account</button>

<?php endif; ?>

    </div>
</div> <!-- tab-content -->

	</div> <!-- /.col-bg -->
        </div> <!-- col8 -->

    </div> <!-- row -->