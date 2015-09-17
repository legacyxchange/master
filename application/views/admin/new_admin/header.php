<?php
if (!defined('BASEPATH'))
    die('Direct access not allowed');

include_once 'headinclude.php';
?>

<?php if(!empty($_SESSION['showLogin']) && $_SESSION['showLogin'] == true): ?>
<?php endif;?>

<!-- ======== @Region: body ======== -->
<body<?= (empty($onload)) ? null : " onload=\"{$onload}\"" ?> class="page">
    
    <!-- ======== @Region: #navigation ======== -->
    <div id="navigatio" class="wrpper">
        <div class="">
        
        	
        	<!--Header upper region-->
        	<div class="header-upper">
          		<div class="header-upper-inner container" style="background:black;">
            		<div class="row">
              			<div class="col-xs-8 col-xs-push-4">               
                			<!--Show/hide trigger for #hidden-header -->
                			
                			<!--social media icons-->
                			<div class="social-media">
                  				<!--@todo: replace with company social media details-->
                  				<a href="#"> <i class="fa fa-twitter-square"></i> </a>
                  				<a href="#"> <i class="fa fa-facebook-square"></i> </a>
                  				<a href="#"> <i class="fa fa-linkedin-square"></i> </a>
                  				<a href="#"> <i class="fa fa-google-plus-square"></i> </a>
                			</div>
              			</div>
              			<div class="col-xs-4 col-xs-pull-8">               
                  			<!--user menu-->
              	  			<div class="btn-group user-menu">                    			
                  				<?php if($this->session->userdata['logged_in']):?>                  			
                  				<a href="/logout" class="btn btn-link login">Logout</a>                  	    	
                 				<a href="/admin/account" class="btn btn-link login">My Account</a> 
                  				<?php else:?>
                  				<a href="#signup-modal" class="btn btn-link login-mobile" data-toggle="modal"><i class="fa fa-user"></i></a>
                  				<a href="#signup-modal" class="btn btn-link signup" data-toggle="modal">Sign Up</a>
                  				<a href="#signup-modal" class="btn btn-link login" data-toggle="modal">Login</a>                  	
                  				<?php endif;?>                  			              				
                			</div>
            			</div>
          			</div>
        		</div>
      		</div>
        
      		<!--Header & Branding region-->
      		<div class="header" data-toggle="clingify">
        		<div class="header-inner container">
          			<div class="navbar">
            			<div class="pull-left">
              				<!--branding/logo-->
              				<a class="navbar-brand animated-panel zoomIn" href="/" title="Home" style="animation-delay: 1.6s;"><img src="/public/images/<?php echo $this->site->getLogo();?>" /></a>             
            			</div>
            
            			
          				<!-- mobile collapse menu button - data-toggle="toggle" = default BS menu - data-toggle="jpanel-menu" = jPanel Menu -->
          				<a href="#top" class="navbar-btn" data-toggle="collapse" data-target=".navbar-collapse" data-direction="right"><i class="fa fa-bars"></i></a>
          
          				<!--everything within this div is collapsed on mobile-->
          				<div class="navbar-collapse collapse">
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
      			</div>
    		</div>
  		</div>
	</div>

	<div class="header_line_image" style="background:url('/public/images/header_line.png') repeat-x;padding:0;border:0;margin:0;">&nbsp;</div>
	
 <?php require_once 'application/views/partials/flash_messages.php';?>