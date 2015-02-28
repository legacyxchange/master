<?php
if (!defined('BASEPATH'))
    die('Direct access not allowed');

$a[$nav] = 'active';

include_once 'headinclude.php';
?>

<?= $headscript ?>
<?php //var_dump($_SESSION); ?>
<?php if(!empty($_SESSION['showLogin']) && $_SESSION['showLogin'] == true): ?>
<script>
$(document).ready(function(e){
	$('#myLegacy').modal('show');
});
</script>
<?php $_SESSION['showLogin'] = null; ?>	
<?php endif; ?>
<style>
.followBtn{display:none;} 
li a { letter-spacing:1px; }
</style>
</head>

<body<?= (empty($onload)) ? null : " onload=\"{$onload}\"" ?> class="landing">
    <!--header start-->
    <!-- INGINES -->
    <nav role="navigation" class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="/" class="navbar-brand"><?php echo $this->functions->getSiteName();?></a>
        </div>
       <div class="navbar-collapse collapse" id="navbar" aria-expanded="false" style="height: 1px;">
           <?php if ($this->session->userdata('logged_in') && $this->session->userdata['permissions'] > 0) : ?> 
            <div class="user_right dropdown col-lg-2 col-md-4 col-xs-12">
               	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="fa-stack fa-2x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa  fa-user fa-stack-1x fa-inverse"></i>
                    </span> 
                    <i class="fa fa-caret-down icon_color"></i>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="/administrator/dashboard">Dashboard</a></li>                        
                    <li><a href="/welcome/logout">Logout</a></li>
                </ul>
            </div>              
            <?php elseif ($this->session->userdata('logged_in') && $this->session->userdata['permissions'] == 0) : ?> 
            <div class="user_right dropdown col-lg-2 col-md-4 col-xs-12">
              	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="fa-stack fa-2x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa  fa-user fa-stack-1x fa-inverse"></i>
                        </span> 
                        <i class="fa fa-caret-down icon_color"></i>
                </a>
                <ul class="dropdown-menu" role="menu">                   
                    <li><a href="/profile">My Account</a></li>
                    <li><a href="/admin/dashboard">My Dashboard</a></li>
                    <li><a href="/welcome/logout">Logout</a></li>
                </ul>
            </div>
            <?php else:?>
            <!-- <ul class="nav navbar-nav">
                 <li class=""><a href="#" data-toggle="modal" data-target="#myLegacy">My Account</a></li>
            </ul> -->
            <?php endif;?>   
          
<style>
.nav-li{margin-left:8px;}
</style>
          <ul class="nav navbar-nav navbar-right inline" style="margin-right:0px;">
          <?php if (!$this->session->userdata('logged_in')): ?>
            <li class="nav-li"><a href="#" data-toggle="modal" data-target="#myLegacy">My Account</a></li>
          <?php endif;?>           
			<li class="nav-li" style="height:54px;max-width:190px;">			
			        <?php echo form_open('/listings/search', false); ?>
                    <div class="input-group stylish-input-group" style="max-width:140px;">
                    <input style="height:34px;width:140px;float:right;" type="text" class="input-text form-control" placeholder="Search" name="q" value="<?php echo $q; ?>" id="serch" autocomplete="on">
                    <input type="hidden" name="location" id="loc" value="<?php echo $this->uri->segment(1);?>">
					  <span class="input-group-addon">
                    <button class="button" title="Search" type="submit" style="max-height:20px;width:20px;"><i class="fa fa-search"></i></button>
					</span>
					</div>
                    <?php echo form_close(); ?>	
                    <!-- <div class="label pull-right advance-search" data-toggle="modal" data-target="#advancedSearchModal">Advanced</i></div>	 -->	
			</li>
            
            <li class="nav-li"><a href="/news">News</a></li>
			<li class="nav-li"><a href="/help">Help</a></li>
			
			<?php if ($this->session->userdata('logged_in')) : ?> 
			<li class="nav-li">
			    <a href="/shopping-cart">
			        <i style="font-size:20px;" class="fa fa-shopping-cart"></i>
			        <div id="cart-items" style="position:relative;top:-8px;left:-3px;font-size:11px;"></div>			
			    </a>
			</li>	
			<?php else:?>
			<li class="nav-li" style="text-align:center;margin-top:0px;"><a href="#" data-toggle="modal" data-target="#myLegacy">Register</a></li>
			<li class="nav-li"><a href="/shopping-cart" ><i class="fa fa-shopping-cart"></i></a></li>
			<?php endif;?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div style="background:#ccc;height:3px;width:100%;">&nbsp;</div>
    <div class="container">
    <?php include APPPATH.'/views/partials/listings_menu.php'; ?>
    </div>
    <?php require_once 'application/views/partials/flash_messages.php';?>