
<div class="container">
	<?php echo $admin_menu;?>
</div>
<div class="admin-heading-container">
    <h3 class="admin-heading"><?php echo $title;?></h3>
</div>

<style>
.container { background:#fff;  }
.main-container { line-height: 28px; font-size: 13px;border:0px solid;font-family:arial;max-width:800px;letter-spacing:1px; }
.uline-count { text-decoration:underline;font-weight:bold;  }
.stats-headline { font-weight:bold; } 
.right-container { border:0px solid; }
.stats { margin-top:20px;margin-bottom:20px; }
.notification { margin:10px;padding-right:20px; line-height:17px; }
.notifications_container { height:100px;border:1px solid;overflow-y: scroll;overflow-x: hidden; }
.text11 { font-size:11px; }
</style>
<!--container start-->
<div class="middle-container">
	<div class="container" style="background:#fff;">
	    <div class="right-container col-lg-3 col-md-3 pull-right" style="padding-left:50px;"><br />
    		<img src="/user/profileimg/140/<?=$this->session->userdata('user_id')?>/<?php echo isset($user->profileimg) ? $user->profileimg : 0; ?>">
    		<div style="font-size:12px;">ACCOUNT TYPE: <?php echo $account_type;?></div>
    		<a href="/admin/settings" class="btn btn-blue btn-xs pull-right">Change</a>
    	</div>
    	<div class="main-content main-container col-lg-9 col-md-9 pull-right">
        
        	<div class="col-lg-4">NAME: <?php echo $user->firstName;?> <?php echo $user->lastName;?></div> 
        
            <div class="col-lg-4">EMAIL: <span class="text11"><?php echo $user->email;?></span></div>     
            
        	<div class="col-lg-4">USER NAME: <?php echo $user->username;?></div>                               	    
    
    		<div class="stats col-lg-12">
            	<div class="stats-headline">YOUR MESSAGES:</div>
            	<div class="notifications_container">
            	<?php if($notifications):?>
            	<?php foreach($notifications as $notification):?>
                	<div class="notification"><?php echo $notification->notification;?> <button class="btn btn-blue btn-xs" onclick="notifications.archive(<?php echo $notification->notification_id;?>);">Archive</button></div>
            	<?php endforeach;?>
            	<?php else:?>
            	No New Messages.
            	<?php endif;?>
            	</div>
    		</div>
        	<div class="stats col-lg-6">
        		<div class="stats-headline">LISTINGS AND DRAFTS:</div>
        
        		<a href="/admin/products/Listed"><div>You have <span class="uline-count"><?php echo count($listings);?></span> Active Listing(s).</div></a>
            	<a href="/admin/products/Drafts"><div>You have <span class="uline-count"><?php echo count($products);?></span> Listing Draft(s).</div></a>
    		</div>
    		<div class="stats col-lg-6">
    			<div class="stats-headline">THIS CALENDAR MONTH:</div>
        		<!-- <a class="btn btn-default" href="/admin/products"> -->
        		<a href="/admin/purchases"><div>You have made <span class="uline-count"><?php echo count($purchases);?></span> Purchase(s).</div></a>
            	<a href="/admin/sales"><div>You have Sold <span class="uline-count"><?php echo count($sales);?></span> item(s).</div></a>
            	<div>You have used <span class="uline-count"><?php echo count($free_listings_left);?></span> of your 50 Free Listing(s).</div>
    		</div>
    		<div class="stats col-lg-12">            
            	<div class="stats-headline">BIDDING</div>            		        			            			
        			<a href="/admin/bids"><div>You are Bidding on <span class="uline-count"><?php echo $bid_count;?></span> item(s).</div></a>
    			    <div>You are Watching <span class="uline-count"><?php echo count($watching);?></span> item(s).</div>  
    		</div>
    	</div>
    	<div class="stats col-lg-12">
    		    <a href="#feedbackModal" data-toggle="modal"><div class="stats col-lg-3">MY FEEDBACK ON SELLERS</div></a>
    		    <div class="stats col-lg-3">FEEDBACK FROM BUYERS</div>
    			<div class="stats col-lg-3">BALANCE IN YOUR ACCOUNT: <br />(AVAILABLE AD DOLLARS)</div>
    			<div class="stats col-lg-2">
    				<span class="uline-count" style="text-decoration:none;border:1px solid #ccc;padding:5px;padding-left:24px;padding-right:24px;margin-bottom:0px;">$<?php echo number_format($user_account->balance,2);?></span><br />
    				<a href="/admin/addfunds" class="btn btn-xs btn-silver add-money-button" style="margin-top:10px;">Add Funds</a>
    			</div> 
    	</div>
	</div>
</div>
<style>
.feedbackModal { border:1px solid #00689a;padding:0px;background:#fff;max-height:400px; }
.fbmHeading { background:#f4f4f4;color:#00689a;font-weight:bold;font-size:18px;padding-left:10px; }
.fbmContent { background:#fff;color:#000;padding:10px; min-height:100px; }
</style>
<div class="col-lg-6 col-lg-offset-3 col-xs-12 col-sm-12 feedbackModal modal fade in" role="dialog" tabindex="-1" id='feedbackModal' aria-hidden="true">
    <div class="fbmHeading">
    My Feedback From Sellers
    <button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
					<span class="sr-only">Close</span>
				</button>
    </div>
    <div class="fbmContent">This will be the content area for this modal.</div>
</div>