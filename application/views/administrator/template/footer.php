<?php if(!defined('BASEPATH')) die('Direct access not allowed');?>
	<?php /*
    </div> <!-- .container -->
	*/ ?>
    </div> <!-- main-content -->
    
    </div> <!-- /.contentbg -->
    
    <!--footer start-->
    <div class="footer">
        <span>&copy;</span> <?php echo $this->functions->getSiteName();?> 2014
    </div>
     <!--footer end-->  

<?php
// wp_login_form();

$attr = array
    (
        'id' => 'loginform',
        'name' => 'loginform'
    );

echo form_open('#', $attr);
?>

<div class="modal fade" id='loginModal'>
  <div class="modal-dialog">
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
            <a href="javascript:global.loadForgotPassword();">FORGOT YOUR PASSWORD?</a><br>
            <a href="javascript:global.loadSignup();">SIGN UP NOW</a>
            </div>

            <div class='col-xs-3 col-sm-6'>
                <button type="button" class="btn btn-red" id='submitLoginBtn'>LOG IN</button>
            </div>
        </div>

      </div> <!-- modal-footer -->



    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

    </form>
    
    
    
    <div class="modal fade" id='getStartedModal'>
  <div class="modal-dialog">
    <div class="modal-content">
    	<div class="modal-body bluespa-modal">
    	
    	<div id='getStartedAlert'></div>
    	
    	<form id='modalSearch' method='get' action='/dojos'>
		
		    	
    	<input type='hidden' name='lat' id='lat' value='0'>
    	<input type='hidden' name='lng' id='lng' value='0'>
    	
    	<input type='hidden' name='location' id='location' value=''>
    	
		
		<h2><i class='fa fa-globe'></i> Finding Your Location</h2>
		
		<p id='unableTxt' style='display:none;'>We were unable to find your location. Please enter your location below.</p>
		
			<div class='locator'>
				<i id='locatorIcon' class='fa fa-spinner fa-spin'></i>

				<input type='text' class='form-control' name='location' id='location' value='' placeholder="Your Zipcode, City, State..." style="display:none;">
			</div> <!-- .locator -->
			
			
			
			
			<button type='button' class='btn btn-default btn-lg searchBtn' disabled='disabled' onclick="welcome.bluespaModalSubmit(this);" style="display:none;"><i class='fa fa-search'></i> Lets Go</button>
			
    	</form>
    	</div> <!-- modal-body -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    

	<script type="text/javascript" src="/public/js/retina-1.3.min.js"></script>
	
</body>

</html>
