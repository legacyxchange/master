<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>
<style>
.navbar{ display: none !important;}
body {padding-top: 0px;}
.container
{padding-top:0px !important;}
</style>


<div class="container-fluid toplogocontainer">
	<div class="container">
		<img class="landing-logo img-responsive" src="/public/images/blue_logo_big.png">
	</div> <!-- container-end-->
</div> <!-- container-fluid-end-->

<div class="container-fluid firstlandingcontainer">
	<div class="container ">
		<div class="row">
			
			<div class="col-md-6 col-md-push-6">
				<img class="img-responsive" src="/public/images/KA_search_browser.png">
			</div><!--end second half-->
			
			<div class="col-md-6 col-md-pull-6">
				<h1 class="firstlandingcontainer">Get Connected to Local Dojos and Instructors</h1>
				<button type="button" class="btn bluelandingnobgbtn btn-default btn-lg" onclick="global.loadSignup(true);">sign up</button>
				<button type="button" class="btn btn-default btn-lg" style="margin-left:35px;" onclick="$('#loginModal').modal('show');">login</button>
			</div><!--end first half-->
			
		</div><!-- row-end-->
	</div><!-- container-end-->
</div> <!-- container-fluid-end-->

<div class="container-fluid thirdlandingcontainer">
	<div class="container">
		<img class="img-responsive thirdlandingimg" src="/public/images/icon_1.png">
		<h1 class="thirdlandingtitle">Find Class Schedules</h1>
		<button type="button" class="btn bluelandingbtn btn-default btn-lg center-block" onclick="welcome.getStarted();">lets get started</button>
	</div><!-- container-end-->
</div> <!-- container-fluid-end-->

<div class="container-fluid secondlandingcontainer">
	<div class="container ">
		<div class="row">
			
			<div class="col-md-6 col-md-push-6">
				<img class="img-responsive" src="/public/images/KA_reviews_browser.png">
			</div><!--end second half-->
			
			<div class="col-md-6 col-md-pull-6">
				<h1 class="fourthlandingcontainer">Share your experience, rate and review</h1>
				<button type="button" class="btn btn-default btn-lg" onclick="welcome.getStarted();">lets get started</button>
			</div><!--end first half-->
			
		</div><!-- row-end-->
	</div><!-- container-end-->
</div> <!-- container-fluid-end-->

<div class="container-fluid fifthlandingcontainer">
	<div class="container">
		<img class="img-responsive thirdlandingimg center-block" src="/public/images/icon_2.png">
		<h1 class="thirdlandingtitle">Master Your Style</h1>
		<button type="button" class="btn bluelandingbtn btn-default btn-lg center-block" onclick="welcome.getStarted();">lets get started</button>
	</div><!-- container-end-->
</div> <!-- container-fluid-end-->

<div class="container-fluid sixthlandingcontainer">
	<div class="container ">
		<div class="row">
			
			<div class="col-md-6">
				<img class="img-responsive" src="/public/images/blue_logo_medium.png">
			</div><!--end second half-->
			
			<div class="col-md-6">
				<h1 class="secondlandingcontainer">Lets get started!</h1>
				<button type="button" class="btn bluelandingnobgbtn btn-default btn-lg" onclick="global.loadSignup(true);">sign up</button>
				<button type="button" class="btn btn-default btn-lg" style="margin-left:35px;" onclick="$('#loginModal').modal('show');">login</button>
			</div><!--end first half-->
			
		</div><!-- row-end-->
		<button type="button" class="btn btn-link center-block" onclick="welcome.getStarted();">Click here to continue</button>
	</div><!-- container-end-->
</div> <!-- container-fluid-end-->
