<?php if(!defined('BASEPATH')) die('Direct access not allowed');?>

<script>
$(document).ready(function(){
	$('#modalFBbtn2').click(function (e) { 
    	fb.login($(this), true);
        
    });
});

</script>
<?php echo form_open('#', array('name' => 'signupform', 'id' => 'signupform'))?>
    <div id='loginAlert'></div>
           
    <div class="form-group">
            <input type='text' class='form-control' name='firstName' id='firstName' value="" placeholder='FIRST NAME'>
    </div> <!-- .form-group -->

    <div class="form-group">
            <input type='text' class='form-control' name='lastName' id='lastName' value="" placeholder='LAST NAME'>
    </div> <!-- .form-group -->
    
    <div class="form-group">
            <input type='text' class='form-control' name='username' id='username' value="" placeholder='USER NAME'>
    </div> <!-- .form-group -->

    <div class="form-group">
            <input type='text' class='form-control' name='email' id='email' value="" placeholder='EMAIL ADDRESS'>
    </div> <!-- .form-group -->

    <div class="form-group">
            <input type='password' class='form-control' name='passwd' id='passwd' value="" placeholder='PASSWORD'>
    </div> <!-- .form-group -->
    
    <div class="form-group">
            <input type='password' class='form-control' name='passwd_confirm' id='passwd_confirm' value="" placeholder='CONFIRM PASSWORD'>
    </div> <!-- .form-group -->
    
    <div class="form-group">
            <h4>By clicking Save you agree to our <a href="/terms-of-service">Terms</a> and <a target="_blank" href="/privacy">Privacy Policy</a>.
            <br />You also attest that you are at least 18 years of age.
            </h4>            
    </div> <!-- .form-group -->

    <hr>

    <div class='form-group'>
        <button type='button' id='modalFBbtn2' class='input-block-level btn btn-primary loginBtn'>LOG IN WITH FACEBOOK</button>
    </div>
<?php echo form_close();?>