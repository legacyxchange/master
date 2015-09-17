<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>
<style>
.form-heading-main{font-size:18px;}
.form-heading{font-size:14px;}
</style>

<div class="admin-heading-container">
    <h2 class="admin-heading">My Settings</h2>
</div>
<div class='row' style="background:#e9f3f7;">
    <div class='col-md-8 col-md-offset-2 main-container' style="background: #fff;">
    	<div class='col-bg'>        
			<div class="container main-content">   
			    <div class="col-lg-6 pull-right">	
					<?php echo form_open_multipart('/admin/settings/save', array('name' => 'userform', 'id' => 'userform'));?>
					<div class='row'>
						<div class='col-md-6'>
							<img src='/user/profileimg/300/<?=$this->session->userdata('user_id')?>/<?php echo $userinfo->profileimg; ?>' class='img-thumbnail avatar'>
						</div>
						<div class='col-md-6'>
							<p> 	
							Click to browse your computer for the image, then simply click the Upload button. The image size should be 300 X 300 pixels or larger in .jpg, .gif or .png file formats only. 
							</p>					
							
							<label class="btn btn-blue">
  							Choose File
  							<input type="file" name="avatar" id="avatar" style="display: none" onchange="$('#userform').submit();">
							</label>
							        				    		
						</div> 
						
					</div>
					<br /><br />
					<script>
					function storePrompt(v){
                        if(v == 2){
					    	$('#sPrompt').show();
                        }else{
                        	$('#sPrompt').hide(); 
                        }
					}
					</script>
					<style>
					.sPrompt { width:300px;height:60px;border:1px solid #00689a; display:none;text-align:center }
					</style>
							<label for="account_type_id">ACCOUNT TYPE:</label>
							<select name="account_type_id" id="account_types" onchange="storePrompt(this.value);">
							    <option value="1">Individual</option>
							    <option value="2">Storefront</option>
							</select>	 
							<div id="sPrompt" class="sPrompt">
							   DO YOU WANT TO SETUP A STOREFRONT?
							   <br />
							   
							   <a style="color:#000;font-weight:bold;margin-right:80px;margin-left:0px;" href="#" onclick="$('#sPrompt').hide();$('#account_types').val(1);return false;">NO</a> 
							   <a style="color:#00689a;font-weight:bold;" href="/admin/store">YES</a> 
							</div>
					<?php //echo form_close();?>
					<?php if (empty($facebookID)) : ?>
			    	<div style="font-size:14px;margin-top:40px;">Set up a connection through your facebook account.		    
			    		<a href="#" class='pull-right btn btn-silver' style="margin-top:0px;" id='connectFBbtn'>Connect with Facebook</a>
			    	</div>
			    	
					<?php else: ?>
			    		<p>Your account is linked with Facebook.</p>			
			    		<button class='btn btn-lg btn-danger' id='unlinkFBbtn'>Unlink Facebook Account</button>		
					<?php endif; ?>			
			    </div>	
				<div class='col-lg-6 tab-pane active form-horizontal pull-left' id='settings'>				
									
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
						<div class="col-sm-9 col-lg-4">
							<input type='text' class='form-control' name='city' id='city' value="<?=$userinfo->city;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					
					    <label for="state" class="col-sm-2 control-label">State</label>
						<div class="col-sm-9 col-lg-2">
							<input type='text' class='form-control' name='state' id='state' value="<?=$userinfo->state;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="postalcode" class="col-sm-3 control-label">Phone</label>
						<div class="col-sm-9 col-lg-3">
							<input type='text' class='form-control' name='phone' id='phone' style="width:120px;" value="<?=$userinfo->phone;?>">
					        <div class="alert-danger"></div>
					    </div>
					
					    <label for="postalCode" class="col-sm-3 control-label">Postal Code</label>
						<div class="col-sm-9 col-lg-3">
							<input type='text' class='form-control' name='postalCode' id='postalCode' value="<?=$userinfo->postalCode;?>">
					        <div class="alert-danger"></div>
					    </div> 
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="email" class="col-sm-3 control-label">E-Mail</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='email' id='email' value="<?=$userinfo->email;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->  
					
						    			
				</div>	
		</div>
		<div class="col-lg-12 col-md-12 form-heading-main">	
		SHIPPING INFORMATION
		</div>
		<div class="col-lg-12 col-md-12">	
			<div class='col-lg-6 tab-pane active form-horizontal pull-left' id='settings2'>				
					<div class="form-heading">SHIP TO INFORMATION (if different)</div>				
					<input type="hidden" name="user_id" value="<?php echo $userinfo->user_id;?>" />
					<div class="form-group">
					    <label for="shipto_firstName" class="col-sm-3 control-label">First Name</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='shipto_firstName' id='shipto_firstName' value="<?=$shipto->firstName;?>" onchange="validate.checkFirstName(this);">
							<div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="shipto_lastName" class="col-sm-3 control-label">Last Name</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='shipto_lastName' id='shipto_lastName' value="<?=$shipto->lastName;?>" onchange="validate.checkLastName(this);">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="shipto_addressline1" class="col-sm-3 control-label">Address</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='shipto_addressLine1' id='shipto_addressLine1' value="<?=$shipto->addressLine1;?>" onchange="validate.checkAddress(this);">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="shipto_addressline2" class="col-sm-3 control-label">Address 2</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='shipto_addressLine2' id='shipto_addressLine2' value="<?=$shipto->addressLine2;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="shipto_city" class="col-sm-3 control-label">City</label>
						<div class="col-sm-9 col-lg-4">
							<input type='text' class='form-control' name='shipto_city' id='shipto_city' value="<?=$shipto->city;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					
					    <label for="shipto_state" class="col-sm-2 control-label">State</label>
						<div class="col-sm-9 col-lg-2">
							<input type='text' class='form-control' name='shipto_state' id='shipto_state' value="<?=$shipto->state;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="shipto_postalcode" class="col-sm-3 control-label">Phone</label>
						<div class="col-sm-9 col-lg-3">
							<input type='text' class='form-control' name='shipto_phone' id='shipto_phone' style="width:120px;" value="<?=$shipto->phone;?>">
					        <div class="alert-danger"></div>
					    </div>
					
					    <label for="shipto_postalCode" class="col-sm-3 control-label">Postal Code</label>
						<div class="col-sm-9 col-lg-3">
							<input type='text' class='form-control' name='shipto_postalCode' id='shipto_postalCode' value="<?=$shipto->postalCode;?>">
					        <div class="alert-danger"></div>
					    </div> 
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="shipto_email" class="col-sm-3 control-label">E-Mail</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='shipto_email' id='shipto_email' value="<?=$shipto->email;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->  
					
						    			
				</div>	
				
				<div class='col-lg-6 tab-pane active form-horizontal pull-right' id='settings3'>				
					<div class="form-heading">SHIP FROM INFORMATION (if different)</div>				
					<input type="hidden" name="user_id" value="<?php echo $userinfo->user_id;?>" />
					<div class="form-group">
					    <label for="shipfrom_firstName" class="col-sm-3 control-label">First Name</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='shipfrom_firstName' id='shipfrom_firstName' value="<?=$shipfrom->firstName;?>" onchange="validate.checkFirstName(this);">
							<div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="shipfrom_lastName" class="col-sm-3 control-label">Last Name</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='shipfrom_lastName' id='shipfrom_lastName' value="<?=$shipfrom->lastName;?>" onchange="validate.checkLastName(this);">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
										
					<div class="form-group">
					    <label for="shipfrom_addressline1" class="col-sm-3 control-label">Address</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='shipfrom_addressLine1' id='shipfrom_addressLine1' value="<?=$shipfrom->addressLine1;?>" onchange="validate.checkAddress(this);">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="shipfrom_addressline2" class="col-sm-3 control-label">Address 2</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='shipfrom_addressLine2' id='shipfrom_addressLine2' value="<?=$shipfrom->addressLine2;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="shipfrom_city" class="col-sm-3 control-label">City</label>
						<div class="col-sm-9 col-lg-4">
							<input type='text' class='form-control' name='shipfrom_city' id='shipfrom_city' value="<?=$shipfrom->city;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					
					    <label for="shipfrom_state" class="col-sm-2 control-label">State</label>
						<div class="col-sm-9 col-lg-2">
							<input type='text' class='form-control' name='shipfrom_state' id='shipfrom_state' value="<?=$shipfrom->state;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="shipfrom_postalcode" class="col-sm-3 control-label">Phone</label>
						<div class="col-sm-9 col-lg-3">
							<input type='text' class='form-control' name='shipfrom_phone' id='shipfrom_phone' style="width:120px;" value="<?=$shipfrom->phone;?>">
					        <div class="alert-danger"></div>
					    </div>
					
					    <label for="shipfrom_postalCode" class="col-sm-3 control-label">Postal Code</label>
						<div class="col-sm-9 col-lg-3">
							<input type='text' class='form-control' name='shipfrom_postalCode' id='shipfrom_postalCode' value="<?=$shipfrom->postalCode;?>">
					        <div class="alert-danger"></div>
					    </div> 
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="shipfrom_email" class="col-sm-3 control-label">E-Mail</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='shipfrom_email' id='shipfrom_email' value="<?=$shipfrom->email;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->  
					
						    			
				</div>	
				<input type='submit' class='btn btn-silver pull-right' id='savebutton' value="Save" />
			<?php echo form_close();?>										
			</div>	
				
			
		</div>	
		<div><br/>MY ACCOUNT</div>
		<div class="stats col-lg-1">BALANCE :</div>
    	<div class="stats col-lg-4">
    		<span class="uline-count" style="text-decoration:none;border:1px solid #ccc;padding:5px;padding-left:24px;padding-right:24px;margin-bottom:0px;">$<?php echo number_format($user_account->balance,2);?></span>
    		<a href="/admin/addfunds" class="btn btn-xs btn-silver add-money-button" style="margin-top:0px;">Add Funds</a>
    	</div> 
			
	</div> <!-- col8 -->
	
</div> <!-- row -->