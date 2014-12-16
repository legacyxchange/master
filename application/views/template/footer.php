<?php if(!defined('BASEPATH')) die('Direct access not allowed');?>
    </div> <!-- main-content --> 
</div> <!-- /.contentbg -->
    
<!--footer start-->
<<<<<<< HEAD

<!-- FOOTER -->
      <footer class="ptb25">
=======
<footer class="ptb25">
>>>>>>> 9031e268c73353b1509f094d5fa975748c0430d3
	   <div class="container">
        <div class="row">
		<div class="col-lg-3">
			<ul class="footer-menu">
<<<<<<< HEAD
			<li><a href="/help">Help / Customer Service</a></li>
			<li><a href="/contact">Contact Us</a></li>
			<li><a href="/about">About Us</a></li>
			<li><a href="/terms-of-service">Terms of Service</a></li>
			<li><a href="/disclaimers">Disclaimers</a></li>
			<li> <a href="/privacy">Privacy Policy</a></li>
=======
			<li><a href="">About</a></li>
			<li><a href="">Terms &amp; Privacy</a></li>
			<li><a href="">Contact</a></li>
			
>>>>>>> 9031e268c73353b1509f094d5fa975748c0430d3
			</ul>
		</div>
		<div class="col-lg-3">
			<ul class="footer-menu">
<<<<<<< HEAD
			<li><a href="/rates">Rates</a></li>
			<li><a href="/how-to-sell">How to Sell</a></li>
			<li><a href="/how-to-buy">Now to Buy</a></li>
			<li><a href="/how-site-works">How Site Works</a></li>
			<li><a href="/mark-item">Mark Items</a></li>
			<li><a href="/faqs">FAQ's</a></li>
=======
			<li><a href="">Selling on LegacyXChange</a></li>
			<li><a href="">Buying on LegacyXChange</a></li>
			<li><a href="">Dealers</a></li>
			
>>>>>>> 9031e268c73353b1509f094d5fa975748c0430d3
			</ul>
		</div>
		<div class="col-lg-3">
			<ul class="footer-menu">
<<<<<<< HEAD
			<li><a href="/athletes-celebrities-agents">Athletes | Celebrities | Agents</a></li>
			<li> <a href="/dealers">Dealers</a></li>
			<li><a href="/manufacturers">Manufacturers</a></li>
			<li><a href="/news">News</a></li>
=======
			<li><a href="">Athletes, Celebrities &amp; Agents</a></li>
			<li><a href="">Manufacturers</a></li>
>>>>>>> 9031e268c73353b1509f094d5fa975748c0430d3
		
			</ul>
		</div>
		<div class="col-lg-3">
<<<<<<< HEAD
		<div class="copyright">
		 <p><span>&copy;</span> <?php echo $this->functions->getSiteName();?> 2014</p>
=======
		<div class="social-icon">
		<b>Follow Us</b>
		<ul class="s-icon list-inline">
		<li><a href=""><img src="/public/images/fb-icon.png"></a></li>
		<li><a href=""><img src="/public/images/tw-icon.png"></a></li>
		<li><a href=""><img src="/public/images/yt-icon.png"></a></li>
		<li><a href=""><img src="/public/images/ista-icon.png"></a></li>
		</ul>
>>>>>>> 9031e268c73353b1509f094d5fa975748c0430d3
		</div>
		
		</div>
		</div>
<<<<<<< HEAD
      </footer>





=======
      </div>
</footer>
>>>>>>> 9031e268c73353b1509f094d5fa975748c0430d3
<!--footer end-->  

<div class="modal fade" id="myLegacy" tabindex="-1" role="dialog" aria-labelledby="myLegacyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                <span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">LegacyXchange</h4>
            </div>
            <div class="modal-body">
            	<div class="row">
	            	<div class="col-lg-6">
			        	<?php echo form_open('#', array('name' => 'loginform', 'id' => 'loginform'));?>
			        	<div id='loginAlert'></div> 
				    	<p id='forgotPWText' style='display:none'>Please enter your E-Mail address associated with your account.</p>
                    	<div class="form-group  login-form">
				        	<label for="inputEmail">Email</label>
                        	<input type='text' class='form-control' name='user_email' id='user_email' value="" placeholder='E-MAIL ADDRESS'>
                    	</div> <!-- .form-group -->
                    	<div class="form-group" id='passwordFormGroup'>
				        	<label for="inputPassword">Password</label>
                        	<input type='password' class='form-control' name='user_pass' id='user_pass' value="" placeholder='PASSWORD'>
                    	</div> <!-- .form-group -->	    
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
							<label for="fname">First Name</label>
            				<input type='text' class='form-control' name='firstName' id='firstName' value="" placeholder='FIRST NAME' onchange="global.checkFirstName();" />
            				<div class="alert alert-danger" style="display:none;"></div>
        				</div> <!-- .form-group -->
        				<div class="form-group">
							<label for="lname">Last Name</label>
            				<input type='text' class='form-control' name='lastName' id='lastName' value="" placeholder='LAST NAME' onchange="global.checkLastName();" />
            				<div class="alert alert-danger" style="display:none;"></div>
        				</div> <!-- .form-group -->  
        				<div class="form-group">
		    				<label for="uname">User Name</label>
            				<input type='text' class='form-control' name='username' id='username' value="" placeholder='USER NAME' onchange="global.checkUsername();" />
            				<div class="alert alert-danger" style="display:none;"></div>
        				</div> <!-- .form-group -->
        				<div class="form-group">
	        				<label for="Email">Email Address</label>
            				<input type='text' class='form-control' name='email' id='email' value="" placeholder='EMAIL ADDRESS' onchange="global.checkEmail();" />
            				<div class="alert alert-danger" style="display:none;"></div>
        				</div> <!-- .form-group -->
        				<div class="form-group">
	    					<label for="Password">Password</label>
            				<input type='password' class='form-control' name='passwd' id='passwd' value="" placeholder='PASSWORD' onchange="global.checkPassword();" />
            				<div class="alert alert-danger" style="display:none;"></div>
        				</div> <!-- .form-group -->  
        				<div class="form-group">
	        				<label for="CPassword">Confirm Password</label>
            				<input type='password' class='form-control' name='passwd_confirm' id='passwd_confirm' value="" placeholder='CONFIRM PASSWORD' onchange="global.checkPasswordConfirm();" />
            				<div class="alert alert-danger" style="display:none;"></div>
        				</div> <!-- .form-group -->
        				<div class="form-group">
							<b>By clicking "Save" you agree that:</b>
							<ul class="terms">
								<li>You accept our <a href="/terms-of-service">Terms</a> and <a target="_blank" href="/privacy">Privacy Policy</a></li>
								<li>You may receive communications from LegacyXChange</li>
								<li>You are at least 18 years of age </li>				
							</ul>
						</div>												  
        				<?php echo form_close();?>
        				<div class="form-action">
	        				<button type="button" class="btn btn-primary btn-sm" id='submitSignupBtn'>SAVE</button>
        				</div>
    				</div>
				</div>
			</div>
			<div class="modal-footer">  
    			<button type='button' id='modalFBbtn' class='input-block-level btn  btn-social btn-facebook'><i class="fa fa-facebook"></i>LOG IN WITH FACEBOOK</button>   
			</div>
    	</div>
  	</div>
</div>

<div class="modal fade" id='loginModal'>
    <div class="modal-dialog">
    <?php echo form_open('#', array('name' => 'loginform', 'id' => 'loginform', 'onsubmit' => 'global.userlogin();'));?>
        <div class="modal-content">
        
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">LOG IN</h3>
            </div> <!-- modal-header -->
            <div class="modal-body">
                <div id='loginAlert'></div>
	            <p id='forgotPWText' style='display:none'>Please enter your E-Mail address associated with your account.</p>
                <div class="form-group">
                    <input type='text' class='form-control' name='user_email' id='user_email' value="" placeholder='E-MAIL ADDRESS'>
                </div> <!-- .form-group -->
                <div class="form-group" id='passwordFormGroup'>
                    <input type='password' class='form-control' name='user_pass' id='user_pass' value="" placeholder='PASSWORD'>
                </div> <!-- .form-group -->
                <hr>
                <div class='form-group' id='fbLoginFormGroup'>
                    <button type='button' id='modalFBbtn' class='input-block-level btn btn-primary loginBtn'>LOG IN WITH FACEBOOK</button>
                </div>
            </div>
            
            <div class="modal-footer">
                <div class='row'>
                    <div class='col-xs-9 col-sm-6 login-options'>
                        <a href="#" id="forgotPasswordButton">FORGOT YOUR PASSWORD?</a><br>
                        <a href="javascript:global.loadSignup();">SIGN UP NOW</a>
                    </div>
                    <div class='col-xs-3 col-sm-6'>
                        <button type="button" class="btn btn-red" id='submitLoginBtn'>LOG IN</button>
                    </div>
                </div>
            </div> <!-- modal-footer -->
            <?php echo form_close();?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    
<div class="modal fade" id='signupModal'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Sign Up</h3>
            </div> <!-- modal-header -->
            <div class="modal-body"></div>
            <div class="modal-footer">
                <div class='row'>
              	    <div class='col-xs-9 col-sm-6 login-options'>
                	    <a href="javascript:global.loadForgotPassword();">FORGOT YOUR PASSWORD?</a><br>
                        <a href="javascript:global.loadSignup();">SIGN UP NOW</a>
                    </div>
                    <div class='col-xs-3 col-sm-6'>
                        <button type="button" class="btn btn-red" id='submitSignupBtnOK'>SAVE</button>
                    </div>
                </div>
            </div> <!-- modal-footer -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->   

<div class="modal fade" id='forgotPasswordModal'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Forgot Password</h3>
            </div> <!-- modal-header -->
            <div class="modal-body">
            <p id='forgotPWText'>Please enter your E-Mail address associated with your account.</p>
                <div class="form-group">
                    <input type='text' class='form-control' name='user_email' id='user_email' value="" placeholder='E-MAIL ADDRESS'>
                </div> <!-- .form-group -->
            </div>
            <div class="modal-footer">
                
            </div> <!-- modal-footer -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->   

<div class="modal fade" id='largeImageModal'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Product Name</h3>
            </div> <!-- modal-header -->
            <div class="modal-body"></div>
            <div class="modal-footer">
                <div class='row'>             	    
                    <div class='col-xs-3 col-sm-6'>
                        <!-- <button type="button" class="btn btn-red" id='submitSignupBtn'>SAVE</button> -->
                    </div>
                </div>
            </div> <!-- modal-footer -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->   

<div class="modal fade" id='getStartedModal'>
    <div class="modal-dialog">
        <div class="modal-content">
    	    <div class="modal-body bluespa-modal">   	    	
    	    </div> <!-- modal-body -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    
<script type="text/javascript" src="/public/js/retina-1.3.min.js"></script>
<!-- 
<script type="text/javascript" src="/public/js/chat.js"></script>

<div id="chat_container">
<div id="chat_hide_show_button" class="chat_hide_show" onclick="chat.hideShow();">SHOW CHAT</div>
<div id="chat" style="display:none;">
    
</div>
</div> -->
</body>

</html>