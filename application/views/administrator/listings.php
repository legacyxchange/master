<!--container start-->
        <div class="container main-content">       
        <?php echo $administrator_menu;?>
        <div class="add_new_butt">
			<a href="#" class="listings-add-link" data-toggle="modal" data-target="#listingsModal"><span class="add_new_plus">+</span> add new</a>
		</div>
        	<div class="war">
            	<h2>Listings</h2>                               
                <table class="table table-condensed">
                    <tr>
                    	<th>Listing Id</th>
                    	<th>Product Id</th>
                    	<th>Product Image</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Recurring</th>
                        <th>Buy Now Price</th>
                        <th>Reserve Price</th>
                        <th>&nbsp;</th>
                    </tr>                        
                    <?php if($listings):?>
                    <?php foreach($listings as $listing):?>                                            
                    <tr>
                        <td class="rec-text"><?php echo $listing->listing_id;?></td>                        
                        <td class="rec-text"><?php echo $listing->product_id;?></td>
                        <td class="rec-text"><img src="/products/productimg/50/<?php echo $listing->product->product_id;?>/<?php echo $listing->product->image;?>" /></td>
                        <td class="rec-text"><?php echo $listing->start_time;?></td>
                        <td class="rec-text"><?php echo $listing->end_time;?></td>
                        <td class="rec-text"><?php echo $listing->recurring;?></td>
                        <td class="rec-text">$<?php echo number_format($listing->buynow_price,2);?></td>
                        <td class="rec-text">$<?php echo number_format($listing->reserve_price,2);?></td>
                        <td valign="middle" align="right" class="icon">                                            
						<a href="#" id="<?=$listing->listing_id;?>" class="edit_button" data-toggle="modal" data-target="#listingsModal"><img src="/public/images/edit-admin.png" /> </a> 
						<a class="delete_button" data-toggle="modal" data-target="#modalConfirm" href="/administrator/listings/delete/<?php echo $listing->listing_id;?>"><img src="/public/images/delete.png" /> </a> 
						</td>
                    </tr>                                       
                <?php endforeach;?> 
                </table>              
                <?php else: ?>
                <h3 class="alert alert-warning">Sorry there are no listings.</h3>
                <?php endif; ?>
            </div>
        </div>
     <!--container end--> 
     
     <div id="listingsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="listingsModal" aria-hidden="true"> 
         <div class="modal-dialog">
            <div class="modal-header" style="text-align: right;">
                <button type="button" data-dismiss="modal">&times;</button>           
        	</div> <!-- modal-header -->         
        	<div class="modal-content">
            
        	</div><!-- /.modal-content -->
     	</div>    
     </div>    
     
     <div id="modalConfirm" class="modal fade" tabindex="-2" role="dialog" aria-labelledby="modalConfirm" aria-hidden="true">
        <div class="modal-dialog" style="background: #fff;">
     		<div class="modal-header" style="text-align: right;">
                <button type="button" data-dismiss="modal">&times;</button>           
        	</div> <!-- modal-header -->       
         	<div class="content" style="background: #fff;">                      
            	<h4>Are you sure you want to delete this listing?</h4>
            	<a id="confirm_yes" class="btn btn-default" style="font-size: 14px; font-weight: normal; position:relative; top:0; left:0;color:#fff;padding:13px;" data-dismiss="modal" aria-hidden="true">Yes</a>  <a class="btn btn-default close-reveal-modal" style="font-size: 14px; font-weight: normal; position:relative; top:0; left:0;color:#fff;padding:13px;" data-dismiss="modal" aria-hidden="true" id="confirm_no">No</a>           
            	<div class="modal-footer">
                	<div class='row'>             	    
                    	<div class='col-xs-3 col-sm-6'>
                        	<!-- <button type="button" class="btn btn-red" id='submitSignupBtn'>SAVE</button> -->
                    	</div>
                	</div>
            	</div> <!-- modal-footer -->
        	</div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>    