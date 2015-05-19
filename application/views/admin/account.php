
<div class="admin-menu-container container" style="background:#fff;">
	<?php echo $admin_menu;?>
</div>
<div  style="border-bottom:2px solid #0a6e8e;border-top:2px solid #0a6e8e;background:#f4f4f4;margin-top: 20px;padding-top: 16px;">
    <h2 class="admin-heading">My Account</h2>
</div>

<style>
.container { background:#fff;  }
.main-container { line-height: 28px; font-size: 13px;border:0px solid;font-family:arial;max-width:800px;letter-spacing:1px; }
.uline-count { text-decoration:underline;font-weight:bold; }
.stats-headline { font-weight:bold; } 
.right-container { border:0px solid; }
.stats { margin-top:20px;margin-bottom:20px; }
.notification { margin:10px;font-weight:bold;padding-right:20px; }
.notifications_container { height:100px;border:1px solid;overflow-y: scroll;overflow-x: hidden; }
</style>
<!--container start-->
<div style="background:#e9f3f7;">
	<div class="container" style="background:#fff;">
	    <div class="right-container col-lg-2 col-md-2 pull-right">
    		<img src="/user/profileimg/100/<?=$this->session->userdata('user_id')?>/<?php echo $user->profileimg; ?>">
    	</div>
    	<div class="main-container col-lg-10 col-md-10 pull-left">
        
        	<div class="col-lg-4">NAME: <?php echo $user->firstName;?> <?php echo $user->lastName;?></div> 
        
        	<div class="col-lg-4">USERNAME: <?php echo $user->username;?></div>                
        
        	<div class="col-lg-4">EMAIL: <?php echo $user->email;?></div>         
    
    		<div class="stats col-lg-12">
            	<div class="stats-headline" style="margin-bottom:-10px;">YOUR MESSAGES:</div>
            	<div class="notifications_container">
            	<?php if($notifications):?>
            	<?php foreach($notifications as $notification):?>
                	<div class="notification"><?php echo $notification->notification;?><button class="btn btn-danger" onclick="notifications.archive(<?php echo $notification->notification_id;?>);">Archive</button></div>
            	<?php endforeach;?>
            	<?php else:?>
            	No New Messages.
            	<?php endif;?>
            	</div>
    		</div>
        	<div class="stats col-lg-6">
        		<div class="stats-headline">PRODUCTS AND LISTINGS:</div>
        
        		<div>You currently have <span class="uline-count"><?php echo count($products);?></span> products Entered in the system.</div>
            	<div>You currently have <span class="uline-count"><?php echo count($listings);?></span> listings Entered in the system.</div>
    		</div>
    		<div class="stats col-lg-6">
    			<div class="stats-headline">THIS MONTH:</div>
        		<!-- <a class="btn btn-default" href="/admin/products"> -->
        		<div>You have made <span class="uline-count"><?php echo count($purchases);?></span> purchases.</div> 
            	<div>You have sold <span class="uline-count"><?php echo count($sales);?></span> item(s).</div>
    		</div>
    		<div class="stats col-lg-12">            
            	<div>BALANCE IN YOUR AD ACCOUNT: <span class="uline-count">$<?php echo number_format($account_balance,2);?></span></div>  
    		</div>
    		<div class="stats col-lg-6"> 		
        		<div>YOU ARE WATCHING <span class="uline-count"><?php echo count($watching);?></span> ITEM(S).</div>           
    		</div>
    		<div class="stats col-lg-6">
        		<div>YOU ARE BIDDING ON <span class="uline-count"><?php echo $bid_count;?></span> ITEMS.</div>
    		</div>
    	</div>
	</div>
</div>
<?php //var_dump($user,$products,$listings); ?>