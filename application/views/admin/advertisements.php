<div class="admin-menu-container container ">
	<?php echo $admin_menu;?>
</div>
<div  style="border-bottom:2px solid #0a6e8e;border-top:2px solid #0a6e8e;background:#f4f4f4;margin-top: 20px;padding-top: 16px;">
    <h2 class="admin-heading">Advertising</h2>
</div>
<section>
	<div class="container">
		<div class="top-text-box" style="background:#fff;border:1px solid #000;padding:20px;padding-top:3px;padding-bottom:3px;margin:20px;font-family:arial;font-size:14px;">
			Listings are placed on pages in the order of when they are ending. By advertising your product you can increase the number of people who view it - increasing your ability to sell and shortening your sales cycle.  You pay only when your product is viewed.
		</div>    				
		<div role="form">
    		<?php echo form_open('/admin/advertisements/save/', array('name' => 'ads_form', 'id' => 'ads_form'));?>
    		<input type="hidden" name="advertisement_id" value="<?php echo $advertisement_id;?>" />
    		<input type="hidden" name="listing_id" value="<?php echo $listings->listing_id;?>" />
    		<input type="hidden" name="user_id" value="<?php echo $user_id;?>" />
    		<div style="margin-bottom:20px;" class="row col-lg-12 col-md-12">
        	    Please enter the total amount of ad dollars you want to spend and maximum amount per view you want to spend for this product listing <b>(<?php echo $listings->name; ?>)</b>:
    			<h4>Advertising Account</h4>
    			<label for="account_balance">Account Balance</label><br />
    			<input type="text" disabled="disabled" name="account_balance" value="<?php echo number_format($user_account->balance,2);?>" />
    				<div class="btn btn-blue admin_payments_button" data-target="#paymentsModal">Add Funds</div>
    		</div>
    		<div style="margin-bottom:20px;" class="row col-lg-12 col-md-12">
    				Total Advertising for this listing?<br />
    					<label for="ad_total_amount">Total Amount</label><br />
    					<input type="text" name="ad_total_amount" value="<?php echo number_format($ad_total_amount,2);?>" />
    		</div>
    		<div style="margin-bottom:20px;" class="row col-lg-12 col-md-12">
    				Max Per Click Spend for this listing?<br />
    				<label for="per_click_amount">Per Click Amount</label><br />
    				$<input type="text" name="per_click_amount" value="<?php echo number_format($per_click_amount,2)?>" />
    		</div>
    		<?php echo form_submit(array('name' => 'submit', 'value' => 'Save', 'class' => 'sign_save')); ?>
    		
    		<?php echo form_close();?>
		</div>
	</div>
</section>