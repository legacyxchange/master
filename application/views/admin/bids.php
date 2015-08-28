<div class="admin-menu-container container ">
	<?php echo $admin_menu;?>
</div>
<div  style="border-bottom:2px solid #0a6e8e;border-top:2px solid #0a6e8e;background:#f4f4f4;margin-top: 20px;padding-top: 16px;">
    <h2 class="admin-heading">My Bids</h2>	
</div>
    
<div class="middle-container">
	<div class="container" style="background:#fff;">
		<div class="container">                               
            <table class="table table-condensed table-hover products-headings" data-toggle="table"> 
                <tr style="background:#ccc;">
                	<th>You are currently bidding on</th>
                    <th>Legacy Number</th>
                    <th>Current Bid</th>
                    <th>Last Bid</th>
                    <th>Auction / Sale Ends</th>
                    <th>Seller</th>                    
                    <th>View Product</th>
                </tr>                        
               
                <?php foreach($products as $product): ?>                                            
                <tr>
                	<td class="rec-text"><?php echo $product->name;?> / <?php echo $product->description;?></td>
                    <td class="rec-text"><?php echo $product->product_id;?></td>
                    <td class="rec-text"><?php echo $product->current_bid;?></td>
                    <td class="rec-text"><?php echo $product->last_bid;?></td>
                    <td class="rec-text"><?php echo $product->end_time;?></td>                   
                    <td class="rec-text"><?php echo $product->username;?></td>
                    
                    <td valign="middle" align="right" class="icon edit-delete-buttons">                                            
						<a href="/listings/product/<?php echo $product->product_id; ?>">View</a>
					</td>
                </tr>                                       
                <?php endforeach;?> 
            </table>            
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