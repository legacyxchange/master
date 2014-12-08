 <script>
 var page_class = '<?php echo $content_info['content_page']?>';
 var page = '<?php echo $content_info['content_uri']?>';
 deals.content(page, page_class);
 </script> 
      <!--container start-->
        <div class="container">
        	<div class="row">
            	<!--col-md-4 start-->
                    <div class="col-md-4">
                        <div class="war_bottom">                       
                     		<h2>SETTINGS</h2>                           
                            <div class="left_list">
                            	<ul>
                                	<li><a id="deals" class="menu_link" href="/admin/deals/deal/<?php echo $location_id;?>"><span>Deals</span></a></li>
                                    <li><a id="menu" class="menu_link" href="#"><span>Menu</span></a></li>
                                    <li><a id="profile" class="menu_link" href="/profile/locationedit/<?php echo $location_id;?>"><span>Profile</span></a></li>
                                    <li><a id="images" class="menu_link" href="/dojos/info/<?=$location_id;?>"><span>Images</span></a></li>
                                    <li><a id="videos" class="menu_link" href="#"><span>Videos</span></a></li>
                                </ul>
                            </div>
                         </div>
                    </div>
                <!--col-md-4 end-->
                
                <div id="myModal" class="reveal-modal medium">
                	<div role="form">
                	<?php $r = null;?>
                    <?php echo form_open_multipart('/admin/deals/add/'.$r->dealid.'/'.$location_id); ?>   
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
						
                    	<input type="button" class="sign_cancel" value="Cancel" />
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
						
                    	<input type="button" class="sign_cancel" value="Cancel" />
					    <?php echo form_submit(array('name' => 'submit', 'value' => 'Save', 'class' => 'sign_save'));?>
					</form>
                    </div>
                </div>    
                <!--col-md-8 start-->
                <div class="col-md-8" id="ajax-container">
                    	
                </div>
                <!--col-md-8 end-->
                 
            </div>       	
        </div>
        <!--container end-->