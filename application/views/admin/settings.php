<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>

<div class="admin-menu-container container ">
	<?php echo $admin_menu;?>
</div>
<div  style="border-bottom:2px solid #0a6e8e;border-top:2px solid #0a6e8e;background:#f4f4f4;margin-top: 20px;padding-top: 16px;">
    <h2 class="admin-heading">My Settings</h2>
</div>
<div class='row main-content'>
    <div class='col-md-8 col-md-offset-2' style="background: #fff;">
    	<div class='col-bg'>        
			<div class="container content">   
			    <div class="col-lg-6 pull-right">	
					<?php echo form_open_multipart('/admin/settings/imageupload', array('name' => 'imageUploadForm','id' => 'imageUploadForm'));?>	
					<div class='row'>
						<div class='col-md-6'>
							<img src='/user/profileimg/300/<?=$this->session->userdata('user_id')?>/<?php echo $userinfo->profileimg; ?>' class='img-thumbnail avatar'>
						</div>
						<div class='col-md-6'>
							<p> 	
							Click to browse your computer for the image, then simply click the Upload button. The image size should be 300 X 300 pixels or larger in .jpg, .gif or .png file formats only. 
							</p>					
							<input type='file' name='avatar' id='avatar' />			        
				    		<input type='submit' class='btn btn-primary' id='uploadImgBtn' value="Upload Image" />		    
						</div> 
					</div> 
					<?php //echo form_close();?>
					<?php if (empty($facebookID)) : ?>
			    	<div style="font-size:14px;margin-top:40px;">Set up a connection through your facebook account.			    
			    		<a href="#" class='pull-right' style="margin-top:-5px;" id='connectFBbtn'><img src="/public/images/facebook-button.gif"/></a>
			    	</div>
			    	<?php echo form_close();?>
					<?php else: ?>
			    		<p>Your account is linked with Facebook.</p>			
			    		<button class='btn btn-lg btn-danger' id='unlinkFBbtn'>Unlink Facebook Account</button>		
					<?php endif; ?>			
			    </div>	
				<div class='col-lg-6 tab-pane active form-horizontal pull-left' id='settings'>				
					<?php echo form_open('/admin/settings/save', array('name' => 'userform', 'id' => 'userform'));?>					
					<input type="hidden" name="user_id" value="<?php echo $userinfo->user_id;?>" />
					<div class="form-group">
					    <label for="firstName" class="col-sm-3 control-label">First Name</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='firstName' id='firstName' value="<?=$userinfo->firstName;?>" onchange="validate.checkFirstName(this);">
							<div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="lastName" class="col-sm-3 control-label">Last Name</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='lastName' id='lastName' value="<?=$userinfo->lastName;?>" onchange="validate.checkLastName(this);">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="username" class="col-sm-3 control-label">Username</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='username' id='username' value="<?=$userinfo->username;?>" onchange="validate.checkUsername(this);">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
						<label for="Password" class="col-sm-3 control-label">Password</label> 
						<div class="col-sm-9">
							<input type='password' class='form-control' name='passwd' id='passwd' value="<?=$userinfo->passwd;?>" placeholder='PASSWORD' onchange="validate.checkPassword(this);" />
							<div class="alert-danger"></div>
					    </div>
					</div>
					<!-- .form-group -->
					<div class="form-group">
						<label for="CPassword" class="col-sm-3 control-label">Confirm Password</label> 
						<div class="col-sm-9">
							<input type='password' class='form-control' name='passwd_confirm' id='passwd_confirm' value="<?=$userinfo->passwd;?>" placeholder='CONFIRM PASSWORD' onchange="validate.checkPasswordConfirm(this);" />
							<div class="alert-danger"></div>
						</div>
					</div>
						
					<div class="form-group">
					    <label for="addressline1" class="col-sm-3 control-label">Address</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='addressLine1' id='addressLine1' value="<?=$userinfo->addressLine1;?>" onchange="validate.checkAddress(this);">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="addressline2" class="col-sm-3 control-label">Address 2</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='addressLine2' id='addressLine2' value="<?=$userinfo->addressLine2;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="city" class="col-sm-3 control-label">City</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='city' id='city' value="<?=$userinfo->city;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="state" class="col-sm-3 control-label">State</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='state' id='state' value="<?=$userinfo->state;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="postalcode" class="col-sm-3 control-label">Phone</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='phone' id='phone' value="<?=$userinfo->phone;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="lastName" class="col-sm-3 control-label">Zipcode</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='postalCode' id='postalCode' value="<?=$userinfo->postalCode;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="email" class="col-sm-3 control-label">E-Mail</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='email' id='email' value="<?=$userinfo->email;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->      			
				</div>											
				<div class="col-lg-12 col-md-12">
				    <div class="col-lg-12 col-lg-12">
				    	<div style="font-weight:bold;font-size:16px;margin-bottom:20px;margin-top:20px;">Shipping Information</div>    	
				    </div>
				    <div class="col-lg-6 col-md-6 tab-pane active form-horizontal">
				    
				        <div style="font-size:14px;margin-bottom:10px;">Ship To Information: (If Different)</div>
				        
				        <input type="hidden" name="address_type_idShipto" value="3" />
				        <div class="form-group">
					    	<label for="firstNameShipTo" class="col-sm-3 control-label">First Name</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='firstNameShipTo' id='firstNameShipTo' value="<?=$usershipto->firstName;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="lastNameShipTo" class="col-sm-3 control-label">Last Name</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='lastNameShipTo' id='lastNameShipTo' value="<?=$usershipto->lastName;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="addressLine1ShipTo" class="col-sm-3 control-label">Address</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='addressLine1ShipTo' id='addressLine1ShipTo' value="<?=$usershipto->addressLine1;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="addressLine2ShipTo" class="col-sm-3 control-label">Address 2</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='addressLine2ShipTo' id='addressLine2ShipTo' value="<?=$usershipto->addressLine2;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="cityShipTo" class="col-sm-3 control-label">City</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='cityShipTo' id='cityShipTo' value="<?=$usershipto->city;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="stateShipTo" class="col-sm-3 control-label">State</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='stateShipTo' id='stateShipTo' value="<?=$usershipto->state;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="phoneShipTo" class="col-sm-3 control-label">Phone</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='phoneShipTo' id='phoneShipTo' value="<?=$usershipto->phone;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="postalCodeShipTo" class="col-sm-3 control-label">Zipcode</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='postalCodeShipTo' id='postalCodeShipTo' value="<?=$usershipto->postalCode;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
				    	
				    </div>
				    <div class="col-lg-6 col-md-6 tab-pane active form-horizontal">
				    
				        <div style="font-size:14px;margin-bottom:10px;">Ship From Information: (If Different)</div>
				        <input type="hidden" name="address_type_idShipfrom" value="4" />
				        <div class="form-group">
					    	<label for="firstNameShipFrom" class="col-sm-3 control-label">First Name</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='firstNameShipFrom' id='firstNameShipFrom' value="<?=$usershipfrom->firstName;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="lastNameShipFrom" class="col-sm-3 control-label">Last Name</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='lastNameShipFrom' id='lastNameShipFrom' value="<?=$usershipfrom->lastName;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->								
					
						<div class="form-group">
					    	<label for="addressLine1ShipFrom" class="col-sm-3 control-label">Address</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='addressLine1ShipFrom' id='addressLine1ShipFrom' value="<?=$usershipfrom->addressLine1;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="addressLine2ShipFrom" class="col-sm-3 control-label">Address 2</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='addressLine2ShipFrom' id='addressLine2ShipFrom' value="<?=$usershipfrom->addressLine2;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="cityShipFrom" class="col-sm-3 control-label">City</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='cityShipFrom' id='cityShipFrom' value="<?=$usershipfrom->city;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="stateShipFrom" class="col-sm-3 control-label">State</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='stateShipFrom' id='stateShipFrom' value="<?=$usershipfrom->state;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="phoneShipFrom" class="col-sm-3 control-label">Phone</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='phoneShipFrom' id='phoneShipFrom' value="<?=$usershipfrom->phone;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="postalCodeShipFrom" class="col-sm-3 control-label">Zipcode</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='postalCodeShipFrom' id='postalCodeShipFrom' value="<?=$usershipfrom->postalCode;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
				        				 
				    </div>
				    <div class="col-lg-12 col-md-12">
				    	<button type='button' onclick="$('#userform').submit();" class='btn btn-primary pull-right formbtn' id='saveSettingsBtn'><i class='fa fa-save'></i> Save</button>
				    </div>
				    <?php echo form_close();?>
				</div>
			</div>
		</div> <!-- /.col-bg -->
	</div> <!-- col8 -->
</div> <!-- row -->