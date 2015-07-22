
			<div class="container">
				<?php echo $admin_menu;?>
			</div>
			<div class="admin-heading-container">
    			<h3 class="admin-heading"><?php echo $title;?></h3>
			</div>
			<div class="container">
				<div class="row">					
					<div class="col-lg-12">
						<div class="reg-title">
						<?php 
						if(!$user_account) {
							$balance = number_format(0, 2);
						}else{
							$balance = number_format($user_account->balance, 2);
						}
						?>
							Account Balance: $<input type="text" name="balance" disabled="true" placeholder="Balance" value="<?php echo $balance;?>" />						
						</div>
						<?php echo form_open('/admin/addfunds/add', array('name' => 'paymentform', 'id' => 'paymentform'))?>
        				   
        				
        				<div class="col-lg-12 col-md-12">
				    <div class="form-group">
					    	<label for="amount" class="col-sm-3 control-label">Amount</label>
							<div class="col-sm-10">
							    <input type='text' class='form-control' name='amount' id='amount' value="20.00" placeholder="Amount">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
				    <div class="col-lg-6 col-md-6 tab-pane active form-horizontal">
				    		<br /><br />
				    						    									       				       				        
				        <div class="form-group">
					    	<label for="firstName" class="col-sm-3 control-label">First Name</label>
							<div class="col-sm-9">
								<?=$user->firstName;?>
					    	    
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="lastName" class="col-sm-3 control-label">Last Name</label>
							<div class="col-sm-9">
								<div><?=$user->lastName;?></div>
					    	    
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="email" class="col-sm-3 control-label">Email</label>
							<div class="col-sm-9">
								<?=$user->email;?>
					    	    
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
						
						<div class="form-group">
					    	<label for="addressLine1" class="col-sm-3 control-label">Address</label>
							<div class="col-sm-9">
								<?=$user->addressLine1;?>
					    	   
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="addressLine2" class="col-sm-3 control-label">Address 2</label>
							<div class="col-sm-9">
								<?=$user->addressLine2;?>
					    	    
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="city" class="col-sm-3 control-label">City</label>
							<div class="col-sm-9">
								<?=$user->city;?>
					    	    
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="state" class="col-sm-3 control-label">State</label>
							<div class="col-sm-9">
								<?=$user->state;?>
					    	    
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="phone" class="col-sm-3 control-label">Phone</label>
							<div class="col-sm-9">
								<?=$user->phone;?>
					    	    
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="postalCode" class="col-sm-3 control-label">Zipcode</label>
							<div class="col-sm-9">
								<?=$user->postalCode;?>
					    	    
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
				    	
				    </div>
				    <div class="col-lg-6 col-md-6 tab-pane active form-horizontal">
				    
				        <div style="font-size:14px;margin-bottom:25px;">BILLING NAME AND ADDRESS (if different)</div>
				        <input type="hidden" name="address_type_idBilling" value="2" />
				        <input type="hidden" name="user_address_idBilling" value="<?php echo $user_addresses->user_address_id;?>" />
				        <input type="hidden" name="user_id" value="<?php echo $user_id;?>" /> 
				        <div class="form-group">
					    	<label for="firstNameBilling" class="col-sm-3 control-label">First Name</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='firstNameBilling' id='firstNameBilling' value="<?=$user_addresses->firstName;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="lastNameBilling" class="col-sm-3 control-label">Last Name</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='lastNameBilling' id='lastNameBilling' value="<?=$user_addresses->lastName;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->								
					
						<div class="form-group">
					    	<label for="emailBilling" class="col-sm-3 control-label">Email</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='emailBilling' id='emailBilling' value="<?=$user_addresses->email;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
						
						<div class="form-group">
					    	<label for="addressLine1Billing" class="col-sm-3 control-label">Address</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='addressLine1Billing' id='addressLine1Billing' value="<?=$user_addresses->addressLine1;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="addressLine2Billing" class="col-sm-3 control-label">Address 2</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='addressLine2Billing' id='addressLine2Billing' value="<?=$user_addresses->addressLine2;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="cityBilling" class="col-sm-3 control-label">City</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='cityBilling' id='cityBilling' value="<?=$user_addresses->city;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="stateBilling" class="col-sm-3 control-label">State</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='stateBilling' id='stateBilling' value="<?=$user_addresses->state;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="phoneBilling" class="col-sm-3 control-label">Phone</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='phoneBilling' id='phoneBilling' value="<?=$user_addresses->phone;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
					
						<div class="form-group">
					    	<label for="postalCodeBilling" class="col-sm-3 control-label">Zipcode</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='postalCodeBilling' id='postalCodeBilling' value="<?=$user_addresses->postalCode;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
				        				 
				    </div>
				    
				    
				    
				    <div class="col-lg-12 col-md-12 pull-right">
				        <h5 style="font-family:arial;">PAYMENT METHOD:</h5>
				    	<div class="col-lg-6 col-md-6 tab-pane active form-horizontal">
				    	<div class="form-group">
					    	<label for="ccnum" class="col-sm-3 control-label">Credit Card #</label>
							<div class="col-sm-9">
								<input type='text' class='form-control' name='ccnum' id='ccnum' value="<?=$user_billing->ccnum;?>">
					    	    <div class="alert-danger"></div>
					    	</div> <!-- col-9 -->
						</div> <!-- .form-group -->
						<div class="form-group">
        <label class="col-sm-3 col-lg-6 control-label" for="expiry-month">Expiration Date</label>
        <div class="col-lg-12">
          <div class="row">
            <div class="col-xs-3">
              <select class="form-control col-sm-2" name="expiry-month" id="expiry-month">
                <option>Month</option>
                <option value="01">Jan (01)</option>
                <option value="02">Feb (02)</option>
                <option value="03">Mar (03)</option>
                <option value="04">Apr (04)</option>
                <option value="05">May (05)</option>
                <option value="06">June (06)</option>
                <option value="07">July (07)</option>
                <option value="08">Aug (08)</option>
                <option value="09">Sep (09)</option>
                <option value="10">Oct (10)</option>
                <option value="11">Nov (11)</option>
                <option value="12">Dec (12)</option>
              </select>
            </div>
            <div class="col-xs-4">
              <select class="form-control" name="expiry-year">
                <option value="13">2013</option>
                <option value="14">2014</option>
                <option value="15">2015</option>
                <option value="16">2016</option>
                <option value="17">2017</option>
                <option value="18">2018</option>
                <option value="19">2019</option>
                <option value="20">2020</option>
                <option value="21">2021</option>
                <option value="22">2022</option>
                <option value="23">2023</option>
              </select>
            </div>
            <div class="form-group">
        
        <div class="col-sm-3 col-lg-4">
          <input type="text" class="form-control" name="cvv" id="cvv" placeholder="CCV Code">
        </div>
      </div>
          </div>
        </div>
      </div>
      </div>
				    </div>
				    	<input type='submit' class='btn btn-primary pull-right formbtn' id='saveSettingsBtn' value="Add Funds" />
				    </div>
				    <?php echo form_close();?>
				</div>
			
		</div> <!-- /.col-bg -->
        		
	</div>
