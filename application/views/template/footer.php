<?php if(!defined('BASEPATH')) die('Direct access not allowed');?>
    </div> <!-- main-content --> 
</div> <!-- /.contentbg -->
    
<!--footer start-->
<div class="footer">
    <div class="col-md-4 col-xs-12 col-lg-3">
        <a href="/help">Help / Customer Service</a>
        <br />
        <a href="/contact">Contact Us</a>
        <br />
        <a href="/about">About Us</a>
        <br />
        <a href="/terms-of-service">Terms of Service</a>
        <br />
        <a href="/disclaimers">Disclaimers</a>
        <br />
        <a href="/privacy">Privacy Policy</a>
    </div>
    <div class="col-md-4 col-xs-12 col-lg-3">
        <a href="/rates">Rates</a>
        <br />
        <a href="/how-to-sell">How to Sell</a>
        <br />
        <a href="/how-to-buy">Now to Buy</a>
        <br />
        <a href="/how-site-works">How Site Works</a>
        <br />
        <a href="/mark-item">Mark Items</a>
        <br />
        <a href="/faqs">FAQ's</a>
    </div>
    <div class="col-md-4 col-xs-12 col-lg-3">
        <a href="/athletes-celebrities-agents">Athletes | Celebrities | Agents</a>
        <br />
        <a href="/dealers">Dealers</a>
        <br />
        <a href="/manufacturers">Manufacturers</a>
        <br />
        <a href="/news">News</a>
    </div>
    <span>&copy;</span> <?php echo $this->functions->getSiteName();?> 2014
</div>
<!--footer end-->  

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
                        <button type="button" class="btn btn-red" id='submitSignupBtn'>SAVE</button>
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