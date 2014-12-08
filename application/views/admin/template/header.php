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
    <div id="header" class="headerbg">
        <div class="container" style="margin-top-40px;height:80px;">
        	<?php $logoLink = ($this->session->userdata('logged_in')) ? '/' : '/'; ?>
            <div id="logo" class="col-lg-1 col-md-4 col-xs-12">
                <a href="<?php echo $logoLink;?>">			
                    <img style="margin-top:-10px;margin-bottom:-10px;margin-left:-20px;" src="/public/images/double_helix.png" width="260" height="82" />
                </a>
            </div>
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
            <button style="margin-top: 14px;height:42px;margin-left:2px;" class='btn btn-default pull-right' id='loginXSBtn'><i class='fa fa-sign-in'> Login </i></button>
            <?php endif;?>              
            <div class="landing_page_top_seach col-lg-2 col-md-4 col-xs-12">
                <div class="form-search">
                	<?php echo form_open('/search/index', false); ?>
                    <input type="text" class="input-text" placeholder="Search products, listings, etc." name="q" value="<?php echo $q; ?>" id="serch" autocomplete="on">
                    <input type="hidden" name="location" id="loc" value="<?php echo $this->uri->segment(1);?>">
                    <button class="button" title="Search" type="submit"><i class="fa fa-search"></i></button>
                    <?php echo form_close(); ?>
                </div>
                <div style="text-align: right;cursor:pointer;background:#ccc;" id="advanced_search_hide_show_button" class="advanced_search_hide_show" onclick="advanced_search.hideShow();">ADVANCED SEARCH <i class="fa fa-caret-down icon_color"></i></div>
            </div>
            
       </div>     
       <div class="container-top">
           
           <div class=" top_menu dropdown col-lg-8 col-lg-offset-2 col-md-6 col-xs-12">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Sports
                    <i class="fa fa-caret-down icon_color"></i>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="/user">Baseball</a></li>
                    <li><a href="/profile">Football</a></li>
                    <li><a href="/profile">Basketball</a></li>
                    <li><a href="/profile">Soccer</a></li>
                    <li><a href="/welcome/logout">Hockey</a></li>
                </ul>
                <a href="#">Hot Now</a>&nbsp;&nbsp;
                <a href="/deals">Deals</a>&nbsp;&nbsp;
                <a href="/deals">Celebrities</a>&nbsp;&nbsp;
                <a href="/deals">Entertainment</a>&nbsp;&nbsp;
                <a href="/info">Info</a>&nbsp;&nbsp;
               	<a href="/contact">Contact</a>                   
            </div>
        </div>     
    </div>
    <!--header end-->
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