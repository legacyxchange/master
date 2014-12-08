
<script type='text/javascript' src='/public/js/deals.js'></script>  
<div class="container">
<div class="add_new_butt">
	<a href="#" class="big-link" data-reveal-id="myModa2"><span class="add_new_plus">+</span> add new</a>
</div>
<div class="war">
	<table border="0" class="table table-condensed">
		<tr>
			<th valign="middle" align="left" width="7.5%">
				<div class="deals-check">
					<p>
						<input class="checkbox1" name="" type="checkbox" value="" /><label>check</label>
					</p>
				</div>
			</th>
			<th valign="middle" align="left" width="38.5%">Title</th>
			<th valign="middle" align="left" width="22.5%">In Stock</th>
			<th valign="middle" align="left" width="17.5%">Price</th>
			<th valign="middle" align="right" width="14%">&nbsp;</th>
		</tr>
		<?php foreach($deals as $r):?>
		
		<tr>
			<td valign="middle" align="left">
				<div class="deals-check">
					<p>
						<input name="" type="checkbox" value="" /><label>check</label>
					</p>
				</div>
			</td>
			<td valign="middle" align="left"><img src="/deals/dealimg/50/<?php echo $userid;?>" /><span><?php echo $r->deal_name;?></span></td>
			<td valign="middle" align="left"><?php echo $r->quantity; ?></td>
			<td valign="middle" align="left">$<?php echo number_format($r->discount_price,2); ?></td>
			<td valign="middle" align="right" class="icon">
			<a href="#" onclick="return confirm('Are you sure you want to delete this?');"><img src="/public/images/delete.png" /> </a> 
			<a href="#" class="big-link edit_button" data-reveal-id="myModa2"><img src="/public/images/edit-admin.png" /> </a> 
			<?php if($r->featured < 1):?>
				<a href="#" class="fa fa-star pull-right featured" id="<?= $r->dealid;?>" style="color: black;"></a> 
			<?php else:?> 
				<a href="#" class="fa fa-star pull-right featured" id="<?= $r->dealid;?>" style="color: gold;"></a> 
			<?php endif;?>
			</td>
		</tr>
		<?php endforeach;?>
	</table>
</div>
</div>
<div id="myModal" class="reveal-modal medium">
                	<div role="form">
                	<?php $r = null;?>
                    <?php echo form_open_multipart('/administrator/deals/add/'.$r->dealid.'/'.$location_id); ?>   
                        <div class="form-group">
	                        <?php echo form_hidden('dealid', $r->dealid);?>
	                        <?php echo form_hidden('id', $r->location_id);?>
	                    </div>    
                        <div class="form-group">
	                        <?php echo form_input(array('name' => 'deal_name', 'placeholder' => 'Title', 'value' => $r->deal_name));?>
	                    </div>
                        <div class="form-group">
	                        <?php echo form_textarea(array('name' => 'deal_description', 'placeholder' => 'Description', 'value' => $r->deal_description));?>
	                    </div>
	                    <div class="form-group">
	                        <div class="mylabel">Retail Price: </div>$<?php echo form_input(array('name' => 'retail_price', 'placeholder' => 'Retail Price', 'value' => number_format($r->retail_price,2)));?>
	                    </div>
	                    <div class="form-group">
	                        <div class="mylabel">Discount Price: </div>$<?php echo form_input(array('name' => 'discount_price', 'placeholder' => 'Discount Price', 'value' => number_format($r->discount_price,2)));?>
	                    </div>
	                    <div class="form-group">
	                        <div class="mylabel"> Quantity: </div><?php echo form_input(array('name' => 'quantity', 'placeholder' => 'Quantity', 'value' => 1));?>
	                    </div>
                        <div class="form-group">
	                        <div class="mylabel">Start Date: </div>&nbsp;<?php echo form_input(array('name' => 'start_date', 'value' => $r->start_date, 'type' => 'date', 'min' => date('Y-m-d')));?>
	                    </div>
	                    <div class="form-group">
	                        <?php $date = date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))));?>
	                        <div class="mylabel">End Date: </div>&nbsp;<?php echo form_input(array('name' => 'end_date', 'value' => $r->end_date, 'type' => 'date', 'min' => "$date"));?>
	                    </div>
	                    <div class="form-group">
	                        <div class="mylabel">Repeat:</div>&nbsp; 
	                        <select name="repeat">
	                        	<option <?php echo $r->repeat == 'weekly' ? 'selected' : null;?> value="weekly">Weekly</option>
	                        	<option <?php echo $r->repeat == 'monthly' ? 'selected' : null;?> value="monthly">Monthly</option>
	                        	<option <?php echo $r->repeat == 'yearly' ? 'selected' : null;?> value="yearly">Yearly</option>
	                        </select>
						</div>
						<div class="form-group">
							<div class="mylabel">Expiration Date: </div>&nbsp;<?php echo form_input(array('name' => 'expiration_date', 'value' => $r->expiration_date, 'type' => 'date', 'min' => date('Y-m-d')));?>
						</div>
						<div class="form-group">
	    					<input type="file" name="userfile" size="20" /> 
	    					<?php if(isset($r->deal_image)):?>
	        				Current Image: <img src="<?=base_url();?>deals/dealimg/100/<?=$userid;?>/<?=$r->deal_image;?>" />
	    				    <?php endif;?>
						</div>
						
                    	<input type="button" class="sign_cancel" onclick="$('#myModal').slideUp('slow');location.href='/administrator/deals';" value="Cancel" />
					    <?php echo form_submit(array('name' => 'submit', 'value' => 'Save', 'class' => 'sign_save'));?>
					</form>
                    </div>
                </div>  

<div id="myModa2" class="reveal-modal medium">
                	<div role="form">
                	<?php $r = $deals[0];?>
                    <?php echo form_open_multipart('/admin/deals/edit/'.$r->dealid.'/'.$location_id); ?>   
                        <div class="form-group">
	                        <?php echo form_hidden('dealid', $r->dealid);?>
	                        <?php echo form_hidden('id', $r->location_id);?>
	                    </div>    
                        <div class="form-group">
	                        <?php echo form_input(array('name' => 'deal_name', 'placeholder' => 'Title', 'value' => $r->deal_name));?>
	                    </div>
                        <div class="form-group">
	                        <?php echo form_textarea(array('name' => 'deal_description', 'placeholder' => 'Description', 'value' => $r->deal_description));?>
	                    </div>
	                    <div class="form-group">
	                        <div class="mylabel">Retail Price: </div>$<?php echo form_input(array('name' => 'retail_price', 'placeholder' => 'Retail Price', 'value' => number_format($r->retail_price,2)));?>
	                    </div>
	                    <div class="form-group">
	                        <div class="mylabel">Discount Price: </div>$<?php echo form_input(array('name' => 'discount_price', 'placeholder' => 'Discount Price', 'value' => number_format($r->discount_price,2)));?>
	                    </div>
	                    <div class="form-group">
	                        <div class="mylabel"> Quantity: </div><?php echo form_input(array('name' => 'quantity', 'placeholder' => 'Quantity', 'value' => $r->quantity));?>
	                    </div>
                        <div class="form-group">
	                        <div class="mylabel">Start Date: </div>&nbsp;<?php echo form_input(array('name' => 'start_date', 'value' => $r->start_date, 'type' => 'date', 'min' => date('Y-m-d')));?>
	                    </div>
	                    <div class="form-group">
	                        <?php $date = date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))));?>
	                        <div class="mylabel">End Date: </div>&nbsp;<?php echo form_input(array('name' => 'end_date', 'value' => $r->end_date, 'type' => 'date', 'min' => "$date"));?>
	                    </div>
	                    <div class="form-group">
	                        <div class="mylabel">Repeat:</div>&nbsp; 
	                        <select name="repeat">
	                        	<option <?php echo $r->repeat == 'weekly' ? 'selected' : null;?> value="weekly">Weekly</option>
	                        	<option <?php echo $r->repeat == 'monthly' ? 'selected' : null;?> value="monthly">Monthly</option>
	                        	<option <?php echo $r->repeat == 'yearly' ? 'selected' : null;?> value="yearly">Yearly</option>
	                        </select>
						</div>
						<div class="form-group">
							<div class="mylabel">Expiration Date: </div>&nbsp;<?php echo form_input(array('name' => 'expiration_date', 'value' => $r->expiration_date, 'type' => 'date', 'min' => date('Y-m-d')));?>
						</div>
						<div class="form-group">
	    					<input type="file" name="userfile" size="20" /> 
	    					<?php if(isset($r->deal_image)):?>
	        				Current Image: <img src="<?=base_url();?>deals/dealimg/100/<?=$userid;?>/<?=$r->deal_image;?>" />
	    				    <?php endif;?>
						</div>
						
                    	<input type="button" class="sign_cancel" onclick="$('#myModa2').hide('slow');location.href='/administrator/deals';" value="Cancel" />
					    <?php echo form_submit(array('name' => 'submit', 'value' => 'Save', 'class' => 'sign_save'));?>
					</form>
                    </div>
                </div>    
