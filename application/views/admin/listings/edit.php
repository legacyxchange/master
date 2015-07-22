<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>

<div class="admin-menu-container container ">
	<?php echo $admin_menu;?>
</div>
<div  style="border-bottom:2px solid #0a6e8e;border-top:2px solid #0a6e8e;background:#f4f4f4;margin-top: 20px;padding-top: 16px;">
    <h2 class="admin-heading">List Product</h2>
</div>
<div class='row main-content'>
    <div class='col-md-8 col-md-offset-2' style="background: #fff;">
    	<div class='col-bg'>        
			<div class="container content">   
			    <div class="col-lg-6 pull-right">	
					<?php echo form_open('/admin/listings/edit/'.$listing->listing_id, array('name' => 'listingform', 'id' => 'listingform'));?>									
			    </div>	
				<div class='col-lg-6 tab-pane active form-horizontal pull-left' id='settings'>				
									
					<input type="hidden" name="product_id" value="<?php echo $listing->product_id;?>" />
					<input type="hidden" name="listing_id" value="<?php echo $listing->listing_id;?>" />
					<div class="form-group">
					    <label for="name" class="col-sm-3 control-label">Listing Type</label>
						<div class="col-sm-9">
							<select name="listing_type_id">
						    <?php foreach($listing_types as $listing_type):?>
						        <?php if($listing->listing_type_id == $listing_type->listing_type_id):?>
						    	<option selected value='<?php echo $listing_type->listing_type_id;?>'><?php echo $listing_type->listing_type;?></option>
						        <?php else:?>
						        <option value='<?php echo $listing_type->listing_type_id;?>'><?php echo $listing_type->listing_type;?></option>
						        <?php endif;?>
						    <?php endforeach;?>
						    </select>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
                		<div class='input-group'>
                		    <label for="start_date">Start Date</label>
                    		<input type="date" min="03/04/2014" name="start_date" value="03/18/2015" />                   			
                		</div>
            		</div>
					
					<div class="form-group">
                		<div class='input-group'>
                		    <label for="end_date">End Date</label>
                    		<input type='date' name="end_date" value="<?=$listing->end_time;?>" />                    			
                		</div>
            		</div>
					
					<div class="form-group">
						<label for="recurring" class="col-sm-3">Recurring</label> 
						<div class="col-sm-9">
							<select name="recurring">							
						        <?php if($listing->recurring < 1):?>
						    	<option selected value='0'>False</option>
						    	<option value='1'>True</option>
						        <?php else:?>
						        <option value='0'>False</option>
						        <option selected value='1'>True</option>
						        <?php endif;?>						    
						    </select>
					    </div>
					</div>
					<!-- .form-group -->
					<div class="form-group">
						<label for="buynow_price" class="col-sm-3 control-label">Buy Now Price</label> 
						<div class="col-sm-9">
							<input type='text' class='form-control' name='buynow_price' id='buynow_price' value="<?=$listing->buynow_price;?>" placeholder='Buy Now Price' />
							<div class="alert-danger"></div>
						</div>
					</div>
						
					<div class="form-group">
						<label for="reserve_price" class="col-sm-3 control-label">Reserve Price</label> 
						<div class="col-sm-9">
							<input type='text' class='form-control' name='reserve_price' id='reserve_price' value="<?=$listing->reserve_price;?>" placeholder='Reserve Price' />
							<div class="alert-danger"></div>
						</div>
					</div>
					
					<div class="form-group">
					    <label for="minimum_bid" class="col-sm-3 control-label">Minimum Bid</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='minimum_bid' id='minimum_bid' value="<?=$listing->minimum_bid;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->									
				</div>											
				
				    <div class="col-lg-12 col-md-12">
				    	<input type='submit' class='btn btn-primary pull-right formbtn' id='saveSettingsBtn' value="Save" />
				    </div>
				    <?php echo form_close();?>
				</div>
			</div>
		</div> <!-- /.col-bg -->
	</div> <!-- col8 -->
