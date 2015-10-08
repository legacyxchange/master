<?php
if (!defined('BASEPATH'))
    die('Direct access not allowed');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title><?php echo $this->site->getSiteName();?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- @todo: fill with your company info or remove -->
    <meta name="description" content="">
    <meta name="author" content="Themelize.me">
    <!--Scripts -->
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Bootstrap JS -->
<script src="/public/assets/bootstrap.js"></script>


<!-- JS plugins required on all pages NOTE: Additional non-required plugins are loaded ondemand as of AppStrap 2.5 -->

<!--Custom scripts mainly used to trigger libraries/plugins -->
    <script src="/public/js/script.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- Plugins required on all pages NOTE: Additional non-required plugins are loaded ondemand as of AppStrap 2.5 -->
    <!-- Plugin: animate.css (animated effects) - http://daneden.github.io/animate.css/ -->
    <link href="/public/plugins/animate/animate.css" rel="stylesheet">
    <!-- @LINEBREAK -- <!-- Plugin: flag icons - http://lipis.github.io/flag-icon-css/ -->
    <link href="/public/plugins/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    
    <!-- Theme style -->
    <link href="/public/css/theme-style.min.css" rel="stylesheet">
    
    <!--Your custom colour override-->
    <link href="/public/css/colors.css" id="colour-scheme" rel="stylesheet">
    
    <!-- Your custom override -->
    <link href="/public/css/custom-style.css" rel="stylesheet">
    
    <!-- HTML5 shiv & respond.js for IE6-8 support of HTML5 elements & media queries -->
    <!--[if lt IE 9]>
    <script src="/public/plugins/html5shiv/dist/html5shiv.js"></script>
    <script src="/public/plugins/respond/respond.min.js"></script>
    <![endif]-->
    
    <!-- Le fav and touch icons - @todo: fill with your icons or remove -->
    <link rel="shortcut icon" href="img/icons/favicon.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/icons/114x114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/icons/72x72.png">
    <link rel="apple-touch-icon-precomposed" href="img/icons/default.png">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Rambla' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Calligraffitti' rel='stylesheet' type='text/css'>
    
    <!--Plugin: Retina.js (high def image replacement) - @see: http://retinajs.com/-->
    <script src="/public/plugins/retina/dist/retina.min.js"></script>
    <script src="/public/js/global.js"></script>
    
    <link href="/public/assets/main3.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" charset="UTF-8"src="/public/js/search.js"></script>
    <script type="text/javascript" src="/public/assets/uikit.min.js"></script>
	<script type="text/javascript" src="/public/assets/jquery.parallax-1.1.3.js"></script> 
    <script type="text/javascript" src="/public/assets/appear.js"></script>
	<script type="text/javascript" src="/public/assets/styleswitcher.js"></script> 
	<script type="text/javascript" src="/public/assets/color-picker.js"></script>
	<script type="text/javascript" src="/public/assets/main(1).js"></script>
	<script type="text/javascript" src="/public/assets/jquery.flexslider-min.js"></script> 
	<script type="text/javascript" src="/public/assets/jquery.touchswipe.min.js"></script>
	<script type="text/javascript" src="/public/assets/jquery.mixitup.min.js"></script> 
	<script type="text/javascript" src="/public/assets/jquery.magnific-popup.min.js"></script> 	
	<script type="text/javascript" src="/public/assets/jquery.backgroundvideo.min.js"></script>
	<script async="" src="/public/assets/fbds.js"></script>
  	
  	
	<script type="text/javascript" src="/public/assets/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="/public/assets/modernizr.min.js"></script>	
	
	<script type="text/javascript" src="/public/assets/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/public/assets/jquery.nav.js"></script> 
	<script type="text/javascript" src="/public/assets/jquery.scrollTo.js"></script> 
	<script type="text/javascript" src="/public/assets/sscr.js"></script> 
	<script type="text/javascript" src="/public/assets/navbar.js"></script> 	
	<script type="text/javascript" src="/public/assets/jquery.easypiechart.js"></script> 		 
	
	<?php //var_dump($_SESSION['showLogin']); exit;?>
    <?php if($_SESSION['showLogin'] === true):?>
    <script>
    $(document).ready(function(e){ 
    	$('#signup-modal').modal('show');
		$('#signup-modal .alerts').html('<div class="row"><h3 class="alert alert-notice" style="text-align:center;">You must login first.</h3></div>');
    });   
	</script>
	<?php unset($_SESSION['showLogin']); ?>
	<?php endif;?>
  </head>