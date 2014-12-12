<?php
if (!defined('BASEPATH'))
    die('Direct access not allowed');

$a[$nav] = 'active';

include_once 'headinclude.php';
?>

<?= $headscript ?>

<style>
.followBtn{display:none;}
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
          <a href="/" class="navbar-brand">LegacyXchange</a>
        </div>
       <div class="navbar-collapse collapse" id="navbar" aria-expanded="false" style="height: 1px;">
           <?php if ($this->session->userdata('logged_in') && $this->session->userdata['permissions'] > 0) : ?> 
		   <ul class="nav navbar-nav navbar-right">
		   <li>	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="fa-stack fa-2x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa  fa-user fa-stack-1x fa-inverse"></i>
                    </span> 
                    <i class="fa fa-caret-down icon_color"></i>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="/administrator/dashboard">Dashboard</a></li>                        
                    <li><a href="/welcome/logout">Logout</a></li>
                </ul></li>
		   </ul>
		            
            <?php elseif ($this->session->userdata('logged_in') && $this->session->userdata['permissions'] == 0) : ?> 
			<ul class="nav navbar-nav navbar-right">
			<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">
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
				
				</li>
			
			</ul>
			
            <?php else:?>
            <ul class="nav navbar-nav">
                <li class=""><a href="#" id='loginXSBtn'>My Legacy</a></li>
            </ul>
            <?php endif;?>   
          

          <ul class="nav navbar-nav navbar-right inline">
            <li><span class="no-link">
               
                    <select class="form-control">
			            <option>Explore</option>			
			        </select>
					</span>
								
			</li>
			<li>  <span class="no-link">			
			        <?php echo form_open('/search/index', false); ?>
					<div class="input-group stylish-input-group">
                    <input type="text" class="input-text form-control" placeholder="Find Items, Shops" name="q" value="<?php echo $q; ?>" id="serch" autocomplete="on">
                    <input type="hidden" name="location" id="loc" value="<?php echo $this->uri->segment(1);?>">
					  <span class="input-group-addon">
                    <button class="button" title="Search" type="submit"><i class="fa fa-search"></i></button>
					</span>
					</div>
                    <?php echo form_close(); ?>
						    
			    <div class="label pull-right advance-search" onclick="advanced_search.hideShow();">ADVANCED SEARCH <i class="fa fa-caret-down icon_color"></i></div>	
				</span>				
			</li>
           
            <li class=""><a href="/mark-item">Mark Item</a></li>
			<li class=""><a href="/how-to-sell" class="combo-link">Sell /</a><a href="/how-to-buy" class="combo-down-link">Buy</a></li>
			<li class=""><a href="/help">Help</a></li>
			<li class=""><a class="sign big-link" href="#" id="signupBigButton">Free Registration</a></li>
			<?php if ($this->session->userdata('logged_in')) : ?> 
			<li><a href="/shopping-cart"><i class="fa fa-shopping-cart"></i>
			<div id="cart-items"></div>			
			</a>
			</li>
			<?php else:?>
			<li><a href="#"><i id="headerLoginBtn" class="fa fa-shopping-cart"></i></a>
			</li>
			<?php endif;?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div id="advanced_search_container">		
	    <div id="advanced_search">
	        <?php echo form_open('/search/advanced');?>
	            <select name="category">
	                <?php foreach($categories as $category):?>
	                    <option value="<?php echo $category->category_id;?>"><?php echo $category;?></option>
	                <?php endforeach; ?>
	            </select>
	        <?php echo form_close();?>
	    </div>
    </div>
    <?php include_once 'alert.php'; ?>
    <?php require_once 'application/views/partials/flash_messages.php';?>