<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>

<?php if($this->session->flashdata('SUCCESS')): ?>
        <div class='row'>
        <h3 class="alert alert-success"><?php echo $this->session->flashdata('SUCCESS'); ?></h3>
        </div>
        <?php elseif($this->session->flashdata('FAILURE')): ?>
        <div class='row'>
        <h3 class="alert alert-danger"><?php echo $this->session->flashdata('FAILURE'); ?></h3>
        </div>
        <?php elseif($this->session->flashdata('NOTICE')): ?>
        <div class='row'>
        <h3 class="alert alert-notice"><?php echo $this->session->flashdata('NOTICE'); ?></h3>
    <?php endif;?>

    <div class='row main-content'>
        <div class='col-md-8 col-md-offset-2'>
        	<div class='col-bg'>
            <h1><i class='fa fa-gears'></i> My Account</h1>
            
<?php
	$tabActive[$tab] = 'active';
?>

<!-- Nav tabs -->
<ul class="nav nav-pills">
  <li class='<?=$tabActive[0]?>'><a href="#home" data-toggle="tab"><i class='fa fa-list'></i> My Account</a></li>
  <li class='<?=$tabActive[1]?>'><a href="#settings" data-toggle="tab"><i class='fa fa-cog'></i> My Settings</a></li>
  <li class='<?=$tabActive[2]?>'><a href="#avatar" data-toggle="tab"><i class='fa fa-user'></i> My Avatar</a></li>
  <li class='<?=$tabActive[3]?>'><a href="#facebook" data-toggle="tab"><i class='fa fa-facebook-square'></i> My Facebook</a></li>
  <li class='<?=$tabActive[4]?>'><a href="/admin/dashboard" data-toggle="ta"><i class='fa fa-list'></i> My Dashboard</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane <?=$tabActive[0]?>" id="home">
      <h3>Here you can change your profile settings, add or change your profile image, maintain your facebook account, or go to your Dashboard.</h3>
      <h3>Your Dashboard is where you can maintain your products, listings, deals, etc...</h3>
  </div>

	<div class='tab-pane <?=$tabActive[1]?> form-horizontal' id='settings'>
	
	<?php
	$attr = array
	(
		'name' => 'userForm',
		'id' => 'userForm'
	);
	
	echo form_open('#', $attr);
	?>
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
						<select name='weightType' id='weightType' class='form-control'>
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
        
	</form>
	
	</div> <!-- #settings -->

	<div class='tab-pane <?=$tabActive[2]?>' id='avatar'>
	
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


        
	</form>
	
	</div> <!-- avatar -->

    <div class="tab-pane <?=$tabActive[3]?>" id="facebook">
        <h3>Facebook</h3>
<?php if (empty($facebookID)) : ?>
    <p>Your account is <strong>not</strong> linked with facebook.</p>
    
    <button class='btn btn-lg btn-primary' id='connectFBbtn'>Connect Facebook Account</button>
<?php else: ?>
    <p>Your account is linked with Facebook.</p>

    <button class='btn btn-lg btn-danger' id='unlinkFBbtn'>Unlink Facebook Account</button>

<?php endif; ?>

    </div>
</div> <!-- tab-content -->

	</div> <!-- /.col-bg -->
        </div> <!-- col8 -->

    </div> <!-- row -->