<?php
if (!defined('BASEPATH'))
    die('Direct access not allowed');

include_once 'headinclude.php';
?>

<?php if(!empty($_SESSION['showLogin']) && $_SESSION['showLogin'] == true): ?>
<?php endif;?>

<!-- ======== @Region: body ======== -->
<body<?= (empty($onload)) ? null : " onload=\"{$onload}\"" ?> class="page page-slider-revolution-boxed" style="background:#fff;">         	
        
          			<div class="col-lg-12 col-md-12" style="padding-top:8px;">
              			<!--branding/logo-->
              			<a class="navbar-brand" href="/" title="Home" style="margin-top:-14px;">
              				<img src="/public/images/<?php echo $this->site->getLogo();?>" />
              			</a>
              			<div style="float:left;margin-top:5px;">             
            			<?php if($this->session->userdata['logged_in']):?>                  			
                  				<a href="/logout" class="btn btn-link login">Logout</a>                  	    	
                 				<a href="/ecommerce/account" class="btn btn-link login">My Account</a> 
                  				<?php else:?>
                  				<a href="#signup-modal" class="btn btn-link signup" data-toggle="modal">Sign Up</a>
                  				<a href="#signup-modal" class="btn btn-link login" data-toggle="modal">Login</a>                  	
                  				<?php endif;?>   
                  		</div>
            <style>.alternate-link{color:#000;font-weight:bold;}</style>
          				<!--everything within this div is collapsed on mobile-->
          				<div class="navbar-collapse collapse" >
            				<!--main navigation-->
            				<ul class="nav navbar-nav">              
              					<li class="link">
                					<a href="/about#how-to-sell" class="alternate-link">Sell</a>
              					</li>
              					<li class="link">
                					<a href="/news" class="alternate-link">News</a>
              					</li>
              					<li class="link">
                					<a href="/help" class="alternate-link">Help</a>
              					</li>                           
              					<li class="nav-li"><a href="/shopping-cart"><i class="fa fa-shopping-cart" style="font-size: 30px;margin-top: -10px;"></i></a></li>
            				</ul>
          				</div>
        	
  		</div>

	<div class=" col-lg-12 col-md-12 header_line_image" style="background:url('/public/images/header_line.png') repeat-x;padding:0;border:0;margin:0;">&nbsp;</div>
	
    	
<?php echo $admin_menu; ?>

<?php require_once 'application/views/partials/flash_messages.php';?>