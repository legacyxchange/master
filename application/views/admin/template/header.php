<?php
if (!defined('BASEPATH'))
    die('Direct access not allowed');

include_once 'headinclude.php';
?>

<?php if(!empty($_SESSION['showLogin']) && $_SESSION['showLogin'] == true): ?>
<?php endif;?>

<!-- ======== @Region: body ======== -->
<body<?= (empty($onload)) ? null : " onload=\"{$onload}\"" ?> class="page page-slider-revolution-boxed">
    <a href="#content" class="sr-only">Skip to content</a>  
    
    <!-- ======== @Region: #navigation ======== -->
    <div id="navigation" class="wrapper">
        <div class="navbar-static-top">
        
        	<!--Hidden Header Region-->
        	<div class="header-hidden" style="background:#fff; color:#000;">
          		<div class="header-hidden-inner container">
            		<div class="row">
              			<div class="col-sm-4 col-md-4">
                			<h3>About Us</h3>
                			<p>The best place for buying and selling Sports Memorabilia.</p>
                			<a href="/about" class="btn btn-sm btn-primary">Find out more</a> 
              			</div>
              			<div class="col-sm-4 col-md-4">
                			<!--@todo: replace with company contact details-->
                			<h3>Contact Us</h3>
                			<address>
                  				<p>
                    				<abbr title="Phone"><i class="fa fa-phone"></i></abbr>
                    				<?php echo $this->site->getContactPhone();?>
                  				</p>
                  				<p>
                    				<abbr title="Email"><i class="fa fa-envelope"></i></abbr>
                    				<?php echo $this->site->getContactEmail();?>
                  				</p>
                  				<p>
                    				<abbr title="Address"><i class="fa fa-home"></i></abbr>
                    				<?php echo $this->site->getContactAddress1();?> <?php echo $this->site->getContactAddress2();?>, <?php echo $this->site->getContactCity();?>. <?php echo $this->site->getContactState();?> <?php echo $this->site->getContactZipcode();?>.
                  				</p>
                			</address>
              			</div>             			
            		</div>
          		</div>
        	</div>      
        	<!--Header upper region-->
        	<div class="header-upper">
          		<div class="header-upper-inner container" style="background:black;">
            		<div class="row">
              			<div class="col-xs-8 col-xs-push-4">               
                			<!--Show/hide trigger for #hidden-header -->
                			<div id="header-hidden-link">
                  				<a onclick="if($('.header-hidden').css('height')=='200px'){$('.header-hidden').css('height', '0px')}else{$('.header-hidden').css('height', '200px');}" href="#" title="Click me you'll get a surprise" class="show-hide" data-callback="searchFormFocus"><i></i>Open</a>
                			</div> 
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
                  				<a href="#en" class="btn btn-link dropdown-toggle" data-toggle="dropdown"><span class="fa fa-language"></span></a>
                  				<ul class="dropdown-menu dropdown-menu-mini dropdown-menu-primary">
                        			<li>
                      					<a href="#es" class="lang-es"><span class="flag-icon flag-icon-es"></span> Spanish</a>
                    				</li>
                    				<li>
                      					<a href="#pt" class="lang-pt"><span class="flag-icon flag-icon-pt"></span> Portguese</a>
                    				</li>
                    				<li>
                      					<a href="#cn" class="lang-cn"><span class="flag-icon flag-icon-cn"></span> Chinese</a>
                    				</li>
                    				<li>
                      					<a href="#se" class="lang-se"><span class="flag-icon flag-icon-se"></span> Swedish</a>
                    				</li>
                  				</ul>
                			</div>
            			</div>
          			</div>
        		</div>
      		</div>
        
      		<!--Header search region - hidden by default -->
      		<div class="header-search">
        		<form class="search-form" id="searching-form" action="/search">
          			<input type="text" style="color:#000;" name="search" class="form-control search" value="" placeholder="Search">
          			<button onclick="$('#searching-form').submit();" type="button" class="btn btn-link"><span class="sr-only">Search </span><i class="fa fa-search fa-flip-horizontal search-icon"></i></button>
          			<button onclick="$('.header-search').css('height', '0');" type="button" class="btn btn-link close-btn" data-toggle="search-form-close"><span class="sr-only">Close </span><i class="fa fa-times search-icon"></i></button>
        		</form>
      		</div>
      
      		<!--Header & Branding region-->
      		<div class="header" data-toggle="clingify">
        		<div class="header-inner container">
          			<div class="navbar">
            			<div class="pull-left">
              				<!--branding/logo-->
              				<a class="navbar-brand" href="/" title="Home"><img src="/public/images/<?php echo $this->site->getLogo();?>" /></a>             
            			</div>
            
            			<!--Search trigger -->
            			<a  onclick="$('.header-search').css('height', '60px');"href="#search" class="search-form-tigger" data-toggle="search-form" data-target=".header-search">
            				<i class="fa fa-search fa-flip-horizontal search-icon"></i>
          				</a>
          
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
	<div id="content">
    	<?php require_once 'application/views/partials/flash_messages.php';?>