<div class="admin-menu-container container ">
	<?php echo $admin_menu;?>
</div>
<div  style="border-bottom:2px solid #0a6e8e;border-top:2px solid #0a6e8e;background:#f4f4f4;margin-top: 20px;padding-top: 16px;">
    <h2 style="color:#016889;">MY ACCOUNT</h2>
</div>

<style>
.main-container { line-height: 28px; font-size: 13px;border:0px solid;font-family:arial;max-width:800px; }
.uline-count { text-decoration:underline; }
.stats-headline { font-weight:bold; }
.right-container { border:0px solid; }
</style>
<!--container start-->
<div class="container">
    <div class="main-container col-lg-10 col-md-10 pull-left">
        
        <div class="col-lg-4">NAME: <?php echo $user->firstName;?> <?php echo $user->lastName;?></div>
        <div class="col-lg-4">USERNAME: <?php echo $user->username;?></div>
        <div class="col-lg-4">EMAIL: <?php echo $user->email;?></div>         
    
        <div class="stats col-lg-6">
        <div class="stats-headline">PRODUCTS AND LISTINGS:</div>
        
        <!-- <a class="btn btn-default" href="/admin/products"> -->
        	<div>You currently have <span class="uline-count"><?php echo count($products);?></span> products Entered in the system.</div>
            <div>You currently have <span class="uline-count"><?php echo count($listings);?></span> listings Entered in the system.</div>
    	</div>
    	<div class="stats col-lg-6">
    	<div class="stats-headline">THIS MONTH:</div>
        <!-- <a class="btn btn-default" href="/admin/products"> -->
        	<div>You currently have <span class="uline-count"><?php echo count($products);?></span> products Entered in the system.</div>
            <div>You currently have <span class="uline-count"><?php echo count($listings);?></span> listings Entered in the system.</div>
            <div>You currently have <span class="uline-count"><?php echo count($listings);?></span> listings Entered in the system.</div>
    	</div>
    </div>
    <div class="right-container col-lg-2 col-md-2 pull-right">
    	<img src="/user/profileimg/100/<?=$this->session->userdata('user_id')?>/<?php echo $user->profileimg; ?>">
    </div>
</div>
<?php //var_dump($user,$products,$listings); ?>