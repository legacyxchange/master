<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>
<script src="/public/js/validate.js"></script>

<div class="admin-menu-container container ">
	<?php echo $admin_menu;?>
</div>
<div  style="border-bottom:2px solid #0a6e8e;border-top:2px solid #0a6e8e;background:#f4f4f4;margin-top: 20px;padding-top: 16px;">
    <h2 class="admin-heading">Add Product</h2>
</div>
<div class='row main-content'>
    <div class='col-md-8 col-md-offset-2' style="background: #fff;">
    	<div class='col-bg'>        
			<div class="container content">
			    <div class="col-lg-12 center">
			        <div><br/>MY ACCOUNT</div>
		<div class="stats col-lg-1">BALANCE :</div> 
    	<div class="stats col-lg-4">
    		<span class="uline-count" style="text-decoration:none;border:1px solid #ccc;padding:5px;padding-left:24px;padding-right:24px;margin-bottom:0px;">$<?php echo number_format($user_account->balance,2);?></span>
    		<a href="/admin/addfunds" class="btn btn-xs btn-silver add-money-button" style="margin-top:0px;">Add Funds</a>
    	</div> 
    	<?php echo form_open_multipart('/admin/products/add/', array('name' => 'productform','id' => 'productform'));?>	
			        <input type="hidden" name="product_id" value="<?php echo $product->product_id;?>" />
			        <input type="hidden" id="order_index" name="order_index" value="" />
			        <input type="hidden" id="product_image_id" name="product_image_id" value="" />
			        <input type="hidden" id="product_video_id" name="product_video_id" value="" />
			        <input type="hidden" name="user_id" value="<?php echo $product->user_id;?>" />
			        <div>You have used <span class="uline-count"><?php echo count($free_listings_left);?></span> of your 50 Free Listing(s).</div>
			        <div class="form-group">
					    <label for="name" class="col-sm-12 col-lg-12 pull-left control-label">Product Name</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='name' id='name' value="<?=$product->name;?>">
							<?php echo !empty($errors["name"]) ? $errors['name'] : null; ?> 
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
			        <div class="form-group">
					    <label for="description" class="col-sm-12 col-lg-12 pull-left control-label">Product Description</label>
						<div class="col-sm-12">
							<textarea class='form-control' rows="3" cols="20" name='description' id='description'><?=$product->description;?></textarea>
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
			    </div> 
			    
			    <div class="col-lg-12">			    
			    	<div class="form-group col-lg-4">
						<label for="name" class="col-lg-6 control-label" style="line-height:17px;">
						Product Category<br/>
						<span style="font-size:11px;font-weight:normal;">*Select up to 3 categories per product</span>
						</label>
						<?php //var_dump($categories); exit;?>						
						<select name="cid[]" multiple>
							<option value="">Choose Category</option>
							<?php foreach($categories as $key=>$category): ?>
							<?php if(in_array($categories[$key]->category_id, $pCatArray)): ?>
							<option selected value="<?=$category->category_id;?>"><?php echo $category->category_name;?></option>
							<?php else:?>
							<option value="<?=$category->category_id;?>"><?php echo $category->category_name;?></option>
							<?php endif;?>
							<?php endforeach;?>
						</select>
						<div class="alert-danger"></div>				    
					</div> <!-- .form-group -->  
					
					<div class="form-group col-lg-4">
						<label for="name" class="col-lg-6 control-label">Product Condition</label>						
						<select name="product_condition_type_id">
							<option value="">Condition</option>
							<?php foreach($product_condition_types as $condition_type): ?>
							<?php if($condition_type->product_condition_type_id == $product->product_condition_type_id):?>
							<option selected value="<?=$condition_type->product_condition_type_id;?>"><?php echo $condition_type->product_condition;?></option>
							<?php else:?>
							<option value="<?=$condition_type->product_condition_type_id;?>"><?php echo $condition_type->product_condition;?></option>
							<?php endif;?>
							<?php endforeach;?>
						</select>
						<div class="alert-danger"></div>				    
					</div> <!-- .form-group -->  
				
					<div class="form-group col-lg-4">
						<label for="name" class="col-lg-6 control-label">Product Type</label>						
						<select name="product_type_id" onchange="doOriginal(this);">
							<option value="">Type</option>
							<?php foreach($product_types as $ptype): ?>
							<?php if($product->product_type_id == $ptype->product_type_id):?>
							<option selected value="<?=$ptype->product_type_id;?>"><?php echo $ptype->type;?></option>
							<?php else:?>
							<option value="<?=$ptype->product_type_id;?>"><?php echo $ptype->type;?></option>
							<?php endif;?>
							<?php endforeach;?>
						</select>
						<div class="alert-danger"></div>
						<div id="originalOption" class="originalOption">						    
						    <select name="sale_type" onchange="doOriginalPasscode(this);">
						        <option value="">-Type of Sale-</option>
						        <option value="First Sale">First Sale</option>
						        <option value="Re-Sell">Re-Sell</option>
						    </select>
						    <div style="padding-left:60px;width:260px;font-size:11px;line-height:12px;">Original is only for Items that have been marked with our tracer material.<br />
						    All other items are Marketplace.</div>
						</div>
						<div class="firstSaleOption" id="firstSaleOption">
						    <label for="original_passcode">Enter Passcode for Original Listing</label>
						    <input style="padding-left:5px;" type="password" name="original_passcode" id="original_passcode" placeholder="Original Passcode" onchange="validate.originalPasscode(this);" />
						    <div class="alert alert-danger" style="padding:2px;display: none;"></div>
						</div>
						<div class="resellOption" id="resellOption">
						    <label for="legacy_number">Enter Legacy Number</label>
						    <input style="padding-left:5px;" type="text" name="legacy_number" id="legacy_number" placeholder="Legacy Number" onchange="validate.legacyNumber(this);" />
						    <div class="alert alert-danger" style="padding:2px;display: none;"></div>
						</div>					    
					</div> <!-- .form-group -->  
					
					<div class="form-group">
					    <label for="details" class="col-sm-12 col-lg-12 pull-left control-label">Details</label>
						<div class="col-sm-12">
							<textarea class='form-control' rows="3" cols="20" name='details' id='details'><?=$product->details;?></textarea>
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="description" class="col-sm-12 col-lg-12 pull-left control-label">Images</label>
						<div class="col-sm-12">
							Add up to 6 images at no cost. Image size should be 300px X 300px or larger in .jpg, jpeg, .png, or .gif only.<br />
							<?php for($i = 0; $i < 6; $i++):?>
							<div class="col-lg-2">
								<label class="btn btn-blue">
  								Image <?php echo $i+1;?> 
  								<?php $oi = (!empty($product_images[$i])) ? $product_images[$i]->order_index : '0'; ?>
  								<?php $piid = (!is_null($product_images[$i]->product_image_id)) ? $product_images[$i]->product_image_id : 'undefined'; ?>
  								<input type="file" name="userfile<?php echo $i+1;?>" id="userfile<?php echo $i+1;?>" style="display: none" 
  									onchange="updateHiddenFields(<?php echo $oi; ?>, <?php echo $piid; ?>);"/>
								</label>
								<div class="image-container" style="float:left;border:1px solid #00689a;height:120px;width:120px;">					    	    	
					    	    	<?php if($product_images[$i])?>					    	    	
					    	    	<img src='/products/productimg/100/<?=$product_images[$i]->product_id;?>/<?php echo $product_images[$i]->product_image; ?>' class='img-responsive'>
					        	</div>
					        </div>
					        <?php endfor;?>											
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->	
					
					<div class="form-group">
					    <label for="description" class="col-sm-12 col-lg-12 pull-left control-label">Videos</label>
						<div class="col-sm-12">
							
							<div class="col-lg-2">
							<div id="onetimefee" class="onetimefee">
								 There is a One Time Fee of $2.00 to add a video to your listing. 
								 In order to proceed please <a href="/admin/addfunds" class="btn btn-xs btn-silver add-money-button" style="margin-top:0px;">Add Funds</a> to your account.
								</div>
								
								<label id="videoupload_button" class="btn btn-blue">
  								<?php echo $add_change = is_null($product_videos[0]->product_id) ? 'Add' : 'Change'; ?> Video   																
  								<input type="file" name="userfile<?php echo $i+1;?>" id="userfile<?php echo $i+1;?>" style="display: none" 
  									onchange="$('#product_video_id').val(<?php echo $product_video[0]->product_video_id;?>);$('#productform').submit();"/>
								</label>
								<div class="video-container">					    	    	
					    	    	<?php if($product_videos):?>				    	    	
					    	    	<video width="200" controls id="video_showing">
  										<source src="/public/uploads/products/<?php echo $product_videos[0]->product_id;?>/<?php echo $product_videos[0]->product_video;?>" type="video/mp4">
  										<source src="/public/uploads/products/<?php echo $product_videos[0]->product_id;?>/<?php echo $product_videos[0]->product_video;?>" type="video/ogg">
  											Your browser does not support HTML5 video.
									</video>

									<p>
									<?php //echo $product_videos[0]->product_video_text;?>
									</p>
									<?php endif;?>
					        	</div>
					        	
					        </div>
					        						
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->							
			    </div>
			    <div class="col-lg-12" style="height:60px;">&nbsp;</div>
			    <?php echo $add_edit_listing_area; ?>										
				<div class="col-lg-12 col-md-12">
				    	<input type='submit' class='btn btn-primary pull-right formbtn' id='saveSettingsBtn' value="Add Product" />
				</div>
			<?php echo form_close();?>
			</div>
			</div>
		</div> <!-- /.col-bg -->
	</div> <!-- col8 -->
