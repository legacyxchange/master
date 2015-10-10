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
ul {list-style:none; padding:0px; }
.footer-menu li { margin-left:-20px; }
li h3 { font-family:arial; }
</style>
<!-- FOOTER -->

<!-- ======== @Region: #footer ======== -->
<footer id="footer">
  <div class="container">
		<div class="row" style='padding-left:5%;'>
			<div class="col-lg-2 col-sm-4">				
				<ul class="footer-menu">
				    <li><h3>About</h3></li>
					<li><a href="/about">Our Site</a></li>
					<li><a href="/about#how-to-sell">Selling</a></li>
					<li><a href="/about#how-to-buy">Buying</a></li>
					
					<li style="line-height: 18px;"><a href="/about#storefronts">Store Fronts:</a><br/>
					<a href="/about#storefronts">Retailers</a><br/>
					<a href="/about#storefronts">Dealers</a><br/>
					<a href="/about#storefronts">Volume Sellers</a></li>					
				</ul> 
			</div>
			<div class="col-lg-2 col-sm-4">
				<ul class="footer-menu">
				    <li><h3>Partners</h3></li>
					<li><a href="/about#athlets-and-celebrities">Athletes, Celebrities</a></li>
					<li><a href="/about#manufacturers">Manufacturers</a></li>
				</ul>
			</div>
			<div class="col-lg-2 col-sm-4" style="padding-left:35px;">
				<ul class="footer-menu">
				    <li><h3>Legal</h3></li>
					<li><a href="/terms-of-service">Terms</a></li>
					<li><a href="/disclaimers">Disclaimers</a></li>
					<li><a href="/privacy">Privacy</a></li>
				</ul>
			</div>
			<div class="col-lg-2 col-sm-4" style="padding-left:25px;">
				<ul class="footer-menu">
				    <li><h3>Help</h3></li>
					<li><a href="/contact">Contact Us</a></li>
					<li><a href="/faqs">FAQ's</a></li>
				</ul>
			</div>
			<div class="col-lg-2 col-sm-4">
				<ul class="footer-menu">
				    <li><h3>Corporate</h3></li>
					<li><a href="http://legacyxchange.com/news.php">News</a></li>
					<li><a href="http://legacyxchange.com/investors.php">Investor Relations</a></li>				
				</ul>
			</div>
			<div class="col-lg-2 col-sm-4">
				<ul class="footer-menu">
				    <li><h3>Follow Us</h3></li>
					<li><a href=""><img src="/public/images/fb-icon.png"></a></li>
					<li><a href=""><img src="/public/images/tw-icon.png"></a></li>
					<li><a href=""><img src="/public/images/yt-icon.png"></a></li>
					<li><a href=""><img src="/public/images/ista-icon.png"></a></li>
				</ul>
			</div>
		</div>
	</div>
  
</footer>
<!--Hidden elements - excluded from jPanel Menu on mobile-->
<div class="hidden-elements jpanel-menu-exclude">
  <!--@modal - signup modal-->
  <div class="modal fade" id="signup-modal" tabindex="-1" role="dialog" aria-hidden="true">
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
							<label for="user_email">Email</label> <input type='text'
								class='form-control' name='user_email' id='user_email' value=""
								placeholder='E-MAIL ADDRESS'>
						</div>
						<!-- .form-group -->
						<div class="form-group" id='passwordFormGroup'>
							<label for="user_pass">Password</label> <input
								type='password' class='form-control' name='user_pass'
								id='user_pass' value="" placeholder='PASSWORD'>
						</div>
						<!-- .form-group -->
						<div class="form-link">
							<a href="/welcome/forgotpassword" id="forgotButton">FORGOT YOUR PASSWORD?</a>
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
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  
  <!--@modal - login modal-->
  <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">
            Login
          </h4>
        </div>
        <div class="modal-body">
          <form action="login.htm" role="form">
            <div class="form-group">
              <label class="sr-only" for="login-email">Email</label>
              <input type="email" id="login-email" class="form-control email" placeholder="Email">
            </div>
            <div class="form-group">
              <label class="sr-only" for="login-password">Password</label>
              <input type="password" id="login-password" class="form-control password" placeholder="Password">
            </div>
            <button type="button" class="btn btn-primary">Login</button>
          </form>
        </div>
        <div class="modal-footer">
          <small>Not a member? <a href="#" class="signup">Sign up now!</a></small>
          <br />
          <small><a href="/welcome/forgotpassword">Forgot password?</a></small>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
</div>

</body>
</html>