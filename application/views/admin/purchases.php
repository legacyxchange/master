<div class="admin-menu-container container ">
	<?php echo $admin_menu;?>
</div>
<div  style="border-bottom:2px solid #0a6e8e;border-top:2px solid #0a6e8e;background:#f4f4f4;margin-top: 20px;padding-top: 16px;">
    <h2 class="admin-heading">My Purchases</h2>	
</div>
    
<div class="middle-container">
	<div class="container" style="background:#fff;">
		<div class="container">                               
            <table class="table table-condensed table-hover products-headings" data-toggle="table"> 
                <tr style="background:#ccc;">
                	<th>Date</th>                
                    <th>Legacy Number</th>
                    <th>Amount</th>
                    <th>Payment Type</th>
                    <th>Transaction Id</th>
                    <th>Seller</th>                    
                    <th>&nbsp;</th>
                </tr>                                       
                <?php foreach($orders as $o): ?>                                            
                <tr>
                	<td class="rec-text"><?php echo $o->created;?></td>                    
                    <td class="rec-text"><?php echo $o->order_id;?></td>
                    <td class="rec-text"><?php echo $o->amount;?></td>
                    <td class="rec-text"><?php echo $o->payment_type;?></td>                   
                    <td class="rec-text"><?php echo $o->transaction_id;?></td>
                    <td class="rec-text"><?php echo $this->session->userdata['username'];?></td>
                    
                    <td valign="middle" align="right" class="icon edit-delete-buttons">                                            
						<a href="/admin/products/edit/<?=$o->product_id;?>" id="<?=$o->order_id;?>" class="admin_edit_butt"><img src="/public/images/edit-admin.png" /></a> 
						<a class="delete_button" data-toggle="modal" data-target="#modalConfirm" href="/admin/products/delete/<?php echo $o->order_id;?>"><img src="/public/images/delete.png" /> </a> 
					</td>
                </tr>                                       
                <?php endforeach;?> 
            </table>            
        </div>
	
                <?php echo form_open('/admin/purchases', array('id' => 'sorting', 'name' => 'sorting', 'class' => 'form'));?>
            	<div class="form-group" style="float:right;">            	
            	<input type="text" name="transaction_id" placeholder="Transaction Id" />
            	<input type="text" name="order_id" placeholder="Legacy Number" />
            	<input type="text" name="amount" placeholder="Amount" />
            	<label for="payment_type">Choose Payment Type</label>
            	<select id="payment_types" name="payment_type" onchange="this.form.submit();">
            		<option value="">CHOOSE</option>
            		<option value="1">AMERICAN EXPRESS</option>
            	    <option value="2">VISA</option>
            	    <option value="3">MASTERCARD</option>
            	    <option value="4">DISCOVER</option>
            	    <option value="5">MY ACCOUNT</option>
            	</select>
            	</div>
            	<div class="form-group">
            	<label for="start_date">Start Date</label>
            	<input type="date" value="<?php echo empty($_POST['start_date']) ? null : $_POST['start_date'];?>" name="start_date" id="start_date" class="date" />
            	</div>
            	<div class="form-group">
            	<label for="end_date">End Date</label>
            	<input type="date" value="<?php echo empty($_POST['end_date']) ? null : $_POST['end_date'];?>" name="end_date" id="end_date" class="date" />
            	</div>
            	<input type="submit" value="Search" class="submit btn btn-default" />
            	<?php echo form_close();?>
            	<div class="col-lg-12" style="text-align: center;">
            	<a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-blue">Show All</a>
            	</div>
     </div>
</div> 
<div id="modalConfirm" class="modal fade" tabindex="-2" role="dialog" aria-labelledby="modalConfirm" aria-hidden="true">
	<div class="modal-dialog" style="background: #fff;">
     	<div class="modal-header" style="text-align: right;">
            <button type="button" data-dismiss="modal">&times;</button>           
        </div>     
        <div class="content" style="background: #fff;">                      
            <h4>Are you sure you want to delete this listing?</h4>
            <a id="confirm_yes" class="btn btn-default" style="font-size: 14px; font-weight: normal; position:relative; top:0; left:0;color:#fff;padding:13px;" data-dismiss="modal" aria-hidden="true">Yes</a>  <a class="btn btn-default close-reveal-modal" style="font-size: 14px; font-weight: normal; position:relative; top:0; left:0;color:#fff;padding:13px;" data-dismiss="modal" aria-hidden="true" id="confirm_no">No</a>           
            <div class="modal-footer">
                <div class='row'>             	    
                    <div class='col-xs-3 col-sm-6'>
                        <!-- <button type="button" class="btn btn-red" id='submitSignupBtn'>SAVE</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    