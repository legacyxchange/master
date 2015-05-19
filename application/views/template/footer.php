<?php if(!defined('BASEPATH')) die('Direct access not allowed');?>

<?php if($advertisements): ?>
<div class="section-header admeister-heading">
    SPECIAL ITEMS
</div>
<!-- advertisements -->
<section>
	<div class="container">							
		<?php foreach($advertisements as $ad): //var_dump($ad); exit;?>
		<div class="cont-6 product-container-border-6 col-lg-2 col-md-2 col-sm-4 col-xs-12" onclick="$('#advertisement_form<?php echo $ad->advertisement_id;?>').submit();">
			<div class="hover-img" style="width:153px;height:153px;">
			    <img src="/products/productimg/140/<?php echo $ad->product->product_id?>/<?php echo $ad->product->image?>" style="margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;" />
				<?php echo form_open($ad->link, array('method' => 'post', 'id' => 'advertisement_form'.$ad->advertisement_id, 'name' => 'advertisement_form'.$ad->advertisement_id));?>
				<input type="hidden" name="advertisement_id" value="<?php echo $ad->advertisement_id;?>" /> 
				<input type="hidden" name="click" value="1" /> 
				<input type="hidden" name="user_id" value="<?php echo $ad->user_id;?>" /> 
				<input type="hidden" name="ad_page_location" value="<?php echo $_SERVER['REQUEST_URI'];?>" />					    	
				<?php echo form_close();?>
				<div hover-info-id="<?php echo $ad->product_id;?>" class="hover-info">
						<div style="font-size:12px;" class="product-name"><?=$ad->product->name;?></div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
		
		<div class="product-container-border-6 col-lg-2 col-md-2 col-sm-4 col-xs-12" onclick="location.href='/about#advertising';">
			<div class="" style="width:153px;height:63px;margin-left:-15px;margin-top:10px;font-size:22px;cursor:pointer;color:#00698a;font-weight:bold;text-align:center;">
			   ADVERTISE YOUR PRODUCT HERE!
			</div>
		</div>			
	</div>
</section>
<?php endif; ?>	
<style>
.footer-menu li a, .footer-links-heading a{letter-spacing: 1px; font-family:arial; font-weight:normal; }
</style>
<!--footer start-->
<footer class="ptb25">
	<div class="container">
		<div class="row" style='padding-left:5%;'>
			<div class="col-lg-2 col-sm-4">
				<div class="footer-links-heading">
					<a href="/about">About</a>
				</div>
				<ul class="footer-menu">
					<li><a href="/about#why-legacyxchange">Our Site</a></li>
					<li><a href="/about#how-to-sell">Selling</a></li>
					<li><a href="/about#how-to-buy">Buying</a></li>
					
					<li style="line-height: 18px;"><a href="/about#stores">Store Fronts:</a><br/>
					<a href="/about#rates">Retailers</a><br/>
					<a href="/about#rates">Dealers</a><br/>
					<a href="/about#rates">Volume Sellers</a></li>					
				</ul>
			</div>
			<div class="col-lg-2 col-sm-4" style="margin:0;">
				<div class="footer-links-heading">
					<a href="/about">Partners</a>
				</div>
				<ul class="footer-menu" style="width:400px;">
					<li><a href="/athletes-celebrities-agents">Athletes, Celebrities</a></li>
					<li><a href="/manufacturers">Manufacturers</a></li>
				</ul>
			</div>
			<div class="col-lg-2 col-sm-4" style="padding-left:35px;">
				<div class="footer-links-heading">
					<a href="/legal">Legal</a>
				</div>
				<ul class="footer-menu">
					<li><a href="/terms-of-service">Terms</a></li>
					<li><a href="/disclaimers">Disclaimers</a></li>
					<li><a href="/privacy">Privacy</a></li>
				</ul>
			</div>
			<div class="col-lg-2 col-sm-4" style="padding-left:25px;">
				<div class="footer-links-heading">
					<a href="/help">Help</a>
				</div>
				<ul class="footer-menu">
					<li><a href="/contact">Contact Us</a></li>
					<li><a href="/faqs">FAQ's</a></li>
				</ul>
			</div>
			<div class="col-lg-2 col-sm-4">
				<div class="footer-links-heading">
					<a href="/corporate">Corporate</a>
				</div>
				<ul class="footer-menu">
					<li><a href="/careers">Careers</a></li>
					<li><a href="/press">Press Release</a></li>
					<li><a href="/press">Stock Quote</a></li>
				</ul>
			</div>
			<div class="col-lg-2 col-sm-4">
				<div class="footer-links-heading" style="margin-bottom:6px;">
					<a href="/follow-us">Follow Us</a>
				</div>
				<ul class="s-icon" style="list-style: none; padding: 0px;">
					<li><a href=""><img src="/public/images/fb-icon.png"></a></li>
					<li><a href=""><img src="/public/images/tw-icon.png"></a></li>
					<li><a href=""><img src="/public/images/yt-icon.png"></a></li>
					<li><a href=""><img src="/public/images/ista-icon.png"></a></li>
				</ul>
			</div>
		</div>
		<div style="text-align: center;color:#006a8a;font-size:11px;">&copy; 2015 <?php echo $this->site->getName();?></div>
	</div>
</footer>
<!--footer end-->

<div class="modal fade" id="myLegacy" tabindex="-1" role="dialog"
	aria-labelledby="myLegacyLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">LegacyXChange</h4>
			</div>
			<div class="alerts">
            <?php require 'application/views/partials/flash_messages.php';?>
            </div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6">
			        	<?php echo form_open('#', array('name' => 'loginform', 'id' => 'loginform'));?>
			        	<div id='loginAlert'></div>
						<p id='forgotPWText' style='display: none'>Please enter your
							E-Mail address associated with your account.</p>
						<div class="form-group  login-form">
							<label for="inputEmail">Email</label> <input type='text'
								class='form-control' name='user_email' id='user_email' value=""
								placeholder='E-MAIL ADDRESS'>
						</div>
						<!-- .form-group -->
						<div class="form-group" id='passwordFormGroup'>
							<label for="inputPassword">Password</label> <input
								type='password' class='form-control' name='user_pass'
								id='user_pass' value="" placeholder='PASSWORD'>
						</div>
						<!-- .form-group -->
						<div class="form-link">
							<a href="#" id="forgotPasswordButton">FORGOT YOUR PASSWORD?</a>
							<!--<a href="#" data-toggle="modal" data-target="#resetPassword">Forgot Password?</a>-->
						</div>
						<div class="form-action">
							<button type="button" class="btn btn-primary btn-sm" id='submitLoginBtn'>LOG IN</button>
						</div>				
						<?php echo form_close();?>
	   				</div>
					<div class="col-lg-6 ">
						<div class="reg-title">
							<h4>Not Registered Yet?</h4>
							<h5>It's free and quick!</h5>
						</div>
						<?php echo form_open('#', array('name' => 'signupform', 'id' => 'signupform'))?>
        				    
        				<div class="form-group">
							<label for="fname">First Name</label> <input type='text'
								class='form-control' name='firstName' id='firstName' value=""
								placeholder='FIRST NAME' onchange="global.checkFirstName();" />
							<div class="alert alert-danger" style="display: none;"></div>
						</div>
						<!-- .form-group -->
						<div class="form-group">
							<label for="lname">Last Name</label> <input type='text'
								class='form-control' name='lastName' id='lastName' value=""
								placeholder='LAST NAME' onchange="global.checkLastName();" />
							<div class="alert alert-danger" style="display: none;"></div>
						</div>
						<!-- .form-group -->
						<div class="form-group">
							<label for="uname">User Name</label> <input type='text'
								class='form-control' name='username' id='username' value=""
								placeholder='USER NAME' onchange="global.checkUsername();" />
							<div class="alert alert-danger" style="display: none;"></div>
						</div>
						<!-- .form-group -->
						<div class="form-group">
							<label for="Email">Email Address</label> <input type='text'
								class='form-control' name='email' id='email' value=""
								placeholder='EMAIL ADDRESS' onchange="global.checkEmail();" />
							<div class="alert alert-danger" style="display: none;"></div>
						</div>
						<!-- .form-group -->
						<div class="form-group">
							<label for="Password">Password</label> <input type='password'
								class='form-control' name='passwd' id='passwd' value=""
								placeholder='PASSWORD' onchange="global.checkPassword();" />
							<div class="alert alert-danger" style="display: none;"></div>
						</div>
						<!-- .form-group -->
						<div class="form-group">
							<label for="CPassword">Confirm Password</label> <input
								type='password' class='form-control' name='passwd_confirm'
								id='passwd_confirm' value="" placeholder='CONFIRM PASSWORD'
								onchange="global.checkPasswordConfirm();" />
							<div class="alert alert-danger" style="display: none;"></div>
						</div>
						<!-- .form-group -->
						<div class="form-group">
							<b>By clicking "Save" you agree that:</b>
							<ul class="terms">
								<li>You accept our <a href="/terms-of-service">Terms</a> and <a
									target="_blank" href="/privacy">Privacy Policy</a></li>
								<li>You may receive communications from LegacyXChange</li>
								<li>You are at least 18 years of age</li>
							</ul>
						</div>												  
        				<?php echo form_close();?>
        				<div class="form-action">
							<button type="button" class="btn btn-primary btn-sm"
								id='submitSignupBtn'>SAVE</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type='button' id='modalFBbtn'
					class='input-block-level btn  btn-social btn-facebook'>
					<i class="fa fa-facebook"></i>LOG IN WITH FACEBOOK
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog"
	aria-labelledby="paymentModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">LegacyXchange Payment</h4>
			</div>
			<div class="alerts">
            <?php require 'application/views/partials/flash_messages.php';?>
            </div>
			<div class="modal-body">
				<div class="row">
					
					<div class="col-lg-12">
						<div class="reg-title">
							<h4>Checkout</h4>							
						</div>
						<?php echo form_open('#', array('name' => 'paymentform', 'id' => 'paymentform'))?>
        				    
        				<div class="form-group">
							<label for="fname">First Name</label> <input type='text'
								class='form-control' name='firstName' id='firstName' value=""
								placeholder='FIRST NAME' onchange="global.checkFirstName();" />
							<div class="alert alert-danger" style="display: none;"></div>
						</div>
						
						<div class="form-group">
							<label for="lname">Last Name</label> <input type='text'
								class='form-control' name='lastName' id='lastName' value=""
								placeholder='LAST NAME' onchange="global.checkLastName();" />
							<div class="alert alert-danger" style="display: none;"></div>
						</div>
						
						<div class="form-group">
							<label for="lname">Credit Card Number</label> 
							<input type='text' class='form-control' name='credit_card_number' id='credit_card_number' value="" placeholder='Credit Card Number' onchange="global.checkCreditCardNumber();" />
							<div class="alert alert-danger" style="display: none;"></div>
						</div>
						
						<div class="form-group">
							<b>By clicking "Save" you agree that:</b>
							<ul class="terms">
								<li>You accept our <a href="/terms-of-service">Terms</a> and <a
									target="_blank" href="/privacy">Privacy Policy</a></li>
								<li>You may receive communications from LegacyXChange</li>
								<li>You are at least 18 years of age</li>
							</ul>
						</div>												  
        				<?php echo form_close();?>
        				<div class="form-action">
							<button type="button" class="btn btn-primary btn-sm"
								id='submitPaymentBtn'>Continue</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="advancedSearchModal" tabindex="-1"
	role="dialog" aria-labelledby="advancedSearchLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Advanced Search</h4>
			</div>
			<div class="alerts">
            <?php require 'application/views/partials/flash_messages.php';?>
            </div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6">
			        	<?php echo form_open('#', array('name' => 'searchform', 'id' => 'searchform'));?>
			        	<div id='loginAlert'></div>
						<div class="dropdown">
							<button class="btn btn-default my-btn dropdown-toggle"
								type="button" id="dropdownMenu1" data-toggle="dropdown"
								aria-expanded="true" style="max-width: 80px;">
								Explore <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu"
								aria-labelledby="dropdownMenu1">
								<li role="presentation"><a role="menuitem" tabindex="-1"
									href="/listings/original " class="menu_custom_item">Original
										Items</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1"
									href="/listings/secondary" class="menu_custom_item">Secondary
										Items</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1"
									href="#" class="menu_custom_item">Stores</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1"
									href="#" class="menu_custom_item">How to Sell</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1"
									href="#" class="menu_custom_item">How to Buy</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1"
									href="#" class="menu_custom_item">Rates</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1"
									href="#" class="menu_custom_item">How to Profit</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1"
									href="#" class="menu_custom_item">Promotions</a></li>
							</ul>
						</div>
						<?php echo form_close();?>
	   				</div>
					<div class="col-lg-6 ">
						<div class="reg-title">
							<h4>More search stuff?</h4>
							<h5>search this</h5>
						</div>
						<?php echo form_open('#', array('name' => 'signupform', 'id' => 'signupform'))?>
        				    
        											  
        				<?php echo form_close();?>
        				<div class="form-action">
							<button type="button" class="btn btn-primary btn-sm"
								id='submitSignupBtn'>SEARCH</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id='loginModal'>
	<div class="modal-dialog">
    <?php echo form_open('#', array('name' => 'loginform', 'id' => 'loginform', 'onsubmit' => 'global.userlogin();'));?>
        <div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h3 class="modal-title">LOG IN</h3>
			</div>
			<!-- modal-header -->
			<div class="modal-body">
				<div id='loginAlert'></div>
				<p id='forgotPWText' style='display: none'>Please enter your E-Mail
					address associated with your account.</p>
				<div class="form-group">
					<input type='text' class='form-control' name='user_email'
						id='user_email' value="" placeholder='E-MAIL ADDRESS'>
				</div>
				<!-- .form-group -->
				<div class="form-group" id='passwordFormGroup'>
					<input type='password' class='form-control' name='user_pass'
						id='user_pass' value="" placeholder='PASSWORD'>
				</div>
				<!-- .form-group -->
				<hr>
				<div class='form-group' id='fbLoginFormGroup'>
					<button type='button' id='modalFBbtn'
						class='input-block-level btn btn-primary loginBtn'>LOG IN WITH
						FACEBOOK</button>
				</div>
			</div>

			<div class="modal-footer">
				<div class='row'>
					<div class='col-xs-9 col-sm-6 login-options'>
						<a href="#" id="forgotPasswordButton">FORGOT YOUR PASSWORD?</a><br>
						<a href="javascript:global.loadSignup();">SIGN UP NOW</a>
					</div>
					<div class='col-xs-3 col-sm-6'>
						<button type="button" class="btn btn-red" id='submitLoginBtn'>LOG
							IN</button>
					</div>
				</div>
			</div>
			<!-- modal-footer -->
            <?php echo form_close();?>
        </div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id='signupModal'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h3 class="modal-title">Sign Up</h3>
			</div>
			<!-- modal-header -->
			<div class="modal-body"></div>
			<div class="modal-footer">
				<div class='row'>
					<div class='col-xs-9 col-sm-6 login-options'>
						<a href="javascript:global.loadForgotPassword();">FORGOT YOUR
							PASSWORD?</a><br> <a href="javascript:global.loadSignup();">SIGN
							UP NOW</a>
					</div>
					<div class='col-xs-3 col-sm-6'>
						<button type="button" class="btn btn-red" id='submitSignupBtnOK'>SAVE</button>
					</div>
				</div>
			</div>
			<!-- modal-footer -->
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id='forgotPasswordModal'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h3 class="modal-title">Forgot Password</h3>
			</div>
			<!-- modal-header -->
			<div class="modal-body">
				<p id='forgotPWText'>Please enter your E-Mail address associated
					with your account.</p>
				<div class="form-group">
					<input type='text' class='form-control' name='user_email'
						id='user_email' value="" placeholder='E-MAIL ADDRESS'>
				</div>
				<!-- .form-group -->
			</div>
			<div class="modal-footer"></div>
			<!-- modal-footer -->
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id='advancedSearchModal'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h3 class="modal-title">Advanced Search</h3>
			</div>
			<!-- modal-header -->
			<div class="modal-body">
				<p id='forgotPWText'>Please enter your E-Mail address associated
					with your account.</p>
				<div class="form-group">
					<input type='text' class='form-control' name='user_email'
						id='user_email' value="" placeholder='E-MAIL ADDRESS'>
				</div>
				<!-- .form-group -->
			</div>
			<div class="modal-footer"></div>
			<!-- modal-footer -->
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id='largeImageModal'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h3 class="modal-title">Product Name</h3>
			</div>
			<!-- modal-header -->
			<div class="modal-body"></div>
			<div class="modal-footer">
				<div class='row'>
					<div class='col-xs-3 col-sm-6'>
						<!-- <button type="button" class="btn btn-red" id='submitSignupBtn'>SAVE</button> -->
					</div>
				</div>
			</div>
			<!-- modal-footer -->
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id='getStartedModal'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body bluespa-modal"></div>
			<!-- modal-body -->
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript" src="/public/js/retina-1.3.min.js"></script>

</body>
</html>