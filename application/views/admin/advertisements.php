<div class="admin-menu-container container ">
	<?php echo $admin_menu;?>
</div>
<div  style="border-bottom:2px solid #0a6e8e;border-top:2px solid #0a6e8e;background:#f4f4f4;margin-top: 20px;padding-top: 16px;">
    <h2 class="admin-heading">Advertising</h2>
</div>
<section>
	<div class="container">
		<div class="top-text-box" style="background:#fff;border:1px solid #000;padding:20px;padding-top:3px;padding-bottom:3px;margin:20px;font-family:arial;font-size:14px;">
			Advertising (pay-per-click) for Original & Marketplace Products
		</div>    
		<div class="heading-box" style="border:2px solid #000;padding:10px;">
		Listings are placed on pages in the order of the sales ending first.  By advertising your product you can increase 
the number of people who view it, increasing your sales.  You pay only when your ad is clicked on.
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
    		<div class="col-lg-6">
    		f you want to advertise this product, enter the total amount of ad dollars
you want to spend and maximum amount per click you want to spend for 
this product.  (There must be money in your Ad  Dollar Account.)
    		</div>
    		<div style="padding:20px;" class="row col-lg-3 col-md-3">
    				
    					<label for="ad_total_amount">Total Advertising for this listing</label><br />
    					<input type="text" name="ad_total_amount" value="<?php echo number_format($ad_total_amount,2);?>" />
    		</div>
    		<div style="padding:20px;" class="row col-lg-3 col-md-3">   				
    				<label for="per_click_amount">Max you want to spend per click</label>
    				$<input type="text" name="per_click_amount" value="<?php echo number_format($per_click_amount,2)?>" />
    		</div>
    		<?php echo form_submit(array('name' => 'submit', 'value' => 'Save', 'class' => 'sign_save')); ?>
    		
    		<?php echo form_close();?>
		</div>
	</div>
</section>