
<div class="col-lg-12">
			    <div class="col-lg-2">
			        <label for="listing_type">Listing Format</label> 
					<select name="listing_type">
					    <option value="">List As</option>
					    <?php foreach($listing_types as $val): ?>
					    <option value="<?php echo $val->listing_type_id; ?>"><?php echo $val->listing_type; ?></option>
					    <?php endforeach;?>					                
					</select>
				</div>			
				<div class="col-lg-3" style="padding-left:38px;">
				    <label for="retail_price">Starting / Asking Price</label> 
					<input type="text" name="retail_price" value="<?php echo $product->retail_price;?>" placeholder="Asking Price" />
				</div>			
				<div class="col-lg-3">
					<label for="retail_price" class="pull-left">Min. Bid Increment</label> 
					<input type="text" name="minimum_bid" value="<?php echo $listing->minimum_bid;?>" placeholder="Min. Bid Increment" />
					<br />
					<div style="margin-left:30px;">(Auctions Only) </div>           
				</div>			
			    <div class="col-lg-2">
			        <label for="reserve_price">Reserve Price</label> 
					<input type="text" size="10" name="reserve_price" value="<?php echo $listing->reserve_price;?>" placeholder="Reserve Price" />
			    </div>
			    <div class="col-lg-2">
			        <label>List will run until: <?php print($listings->end_time);?></label> 					
			    </div>
			    </div>
			    <div class="col-lg-12">
			    <div class="col-lg-2">
			        <label for="listing_type">Accepted Payments</label> 
					<select name="listing_type">
					    <option value="">Choose</option>
					    <?php foreach($payment_types as $val): ?>
					    <option value="<?php echo $val->payment_type_id; ?>"><?php echo $val->payment_type; ?></option>
					    <?php endforeach;?>					                
					</select>
				</div>			
				<div class="col-lg-2" style="padding-left:38px;">
				    <label for="listing_type">Shipping</label> <br />
					<select name="shipping">
					    <option value="">Choose</option>
					    <?php foreach($shipping_types as $val): ?>
					    <option value="<?php echo $val->shipping_type_id; ?>"><?php echo $val->shipping_type; ?></option>
					    <?php endforeach;?>					                
					</select>
				</div>
				<?php //var_dump(date('Y-m-d H:i:s', strtotime($listings->start_time))); exit;?>	
				<div class="col-lg-3" style="padding-left:18px;">
					
					<?php if(is_null($listings->end_time) || is_null($listings->end_time)):?> 
					<label for="start_time">Start Date</label>
					<input type="date" value="<?php echo date('Y-m-d', strtotime('NOW'));?>" name="start_time" /> 
					<?php echo !empty($errors["start_time"]) ? $errors["start_time"] : null; ?> 
					<br />
					<label for="end_time">End Date</label> <br />
					<input type="date" name="end_time" onchange="validator.validate(this);" />
					<?php echo !empty($errors["end_time"]) ? $errors["end_time"] : null; ?> 
					<?php else: ?>
					<label for="start_time">Start Date</label>
					<input type="date" value="<?php echo date('Y-m-d', strtotime($listings->start_time));?>" name="start_time" />
					<?php echo !empty($errors["start_time"]) ? $errors["start_time"] : null; ?> 
					<br />
					<label for="end_time">End Date</label> <br />
					<input type="date" value="<?php echo date('Y-m-d', strtotime($listings->end_time));?>" name="end_time" onchange="testAjax(this);" /> 
					<?php echo !empty($errors["end_time"]) ? $errors["end_time"] : null; ?> 			
					<?php endif;?>    
				</div>	
				<!-- <div class="col-lg-3" style="padding-left:18px;">
					<label for="listing_type">Estimated Weight (w/pkg.)</label> 
					<select name="shipping" style="width:150px;">
					    <option value="">Estimated Weight</option>
					    <option value="1">0-1 lbs.</option>
					    <option value="1">1-2 lbs.</option>
					    <option value="1">2-3 lbs.</option>
					    <option value="1">3-4 lbs.</option>
					    <option value="1">4-5 lbs.</option>	                
					</select>        
				</div> -->		
					
			    <div class="col-lg-2">
			        <label for="retail_price">Actual Weight</label> <br />
					<input type="text" size="4" name="weight_pounds" value="" placeholder="  lbs." /> <input size="4" type="text" name="weight_ounces" value="" placeholder="  oz." />
					<br />
					<label for="retail_price">Dimensions (Inches)</label> <br />
					<input type="text" size="1" name="length" placeholder="  L" value="" /> <input placeholder="  W" type="text" size="1" name="width" value="" /> <input placeholder="  H" size="1" type="text" name="height" value="" />
			    </div>
			    <div class="col-lg-3">
			        <label style="width:220px;">Fixed Shipping Fee <span style="cursor:help;color:#00689a;font-size:14px;" title="If you set this field, you must use the Flat Rate option" class="fa fa-question-circle"></span></label> <br />
					<input size="12" type="text" name="flat_rate" placeholder="  Flat Rate" />
					<br />
					<label>Estimated Shipping</label> <br />
					<input size="12" type="text" name="estimated_shipping" placeholder="  Estimated Shipping" />
					<br /><br />
			    </div>
			    
			    </div>				