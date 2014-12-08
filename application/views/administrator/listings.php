<!--container start-->
        <div class="container main-content">
        <?php if($this->session->flashdata('SUCCESS')): ?>
        <div class='row'>
        <h3 class="alert alert-success"><?php echo $this->session->flashdata('SUCCESS'); ?></h3>
        </div>
        <?php elseif($this->session->flashdata('FAILURE')): ?>
        <div class='row'>
        <h3 class="alert alert-danger"><?php echo $this->session->flashdata('FAILURE'); ?></h3>
        </div>
        <?php elseif($this->session->flashdata('NOTICE')): ?>
        <div class='row'>
        <h3 class="alert alert-notice"><?php echo $this->session->flashdata('NOTICE'); ?></h3>
        </div>
        <?php endif; ?> 
        <?php echo $admin_menu;?>
        <div class="add_new_butt admin_add_new_butt">
			<a href="#" class="big-link" data-reveal-id="myModa2"><span class="add_new_plus">+</span> add new</a>
		</div>
        	<div class="war">
            	<h2>My Listings</h2>
                                
                <table class="table table-condensed">
                    <tr>
                    	<th>Listing Id</th>
                    	<th>Listing Name</th>
                        <th>Product Id</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Recurring</th>
                        <th>Buy Now Price</th>
                        <th>Reserve Price</th>
                        <th>&nbsp;</th>
                    </tr>                        
                    <?php if($listings):?>
                    <?php foreach($listings as $listing): ?>                                            
                    <tr>
                        <td class="rec-text"><?php echo $listing->listing_id;?></td>
                        <td class="rec-text"><?php echo $listing->listing_name;?></td>
                        <td class="rec-text"><?php echo $listing->product_id;?></td>
                        <td class="rec-text"><?php echo $listing->start_time;?></td>
                        <td class="rec-text"><?php echo $listing->end_time;?></td>
                        <td class="rec-text"><?php echo $listing->recurring;?></td>
                        <td class="rec-text"><?php echo $listing->buynow_price;?></td>
                        <td class="rec-text"><?php echo $listing->reserve_price;?></td>
                        <td valign="middle" align="right" class="icon">                                            
						<a href="#" listing_id="<?=$listing->listing_id;?>" class="big-link admin_edit_button" data-reveal-id="myModa2"><img src="/public/images/edit-admin.png" /> </a> 
						<a class="delete_button" data-reveal-id="modalConfirm" href="/admin/listings/delete/<?php echo $listing->listing_id;?>"><img src="/public/images/delete.png" /> </a> 
						</td>
                    </tr>                                       
                <?php endforeach;?> 
                </table> 
                <div class="pagination">
        	        <?php echo $this->pagination->create_links(); ?>
    	        </div>               
                <?php else: ?>
                <h3 class="alert alert-warning">Sorry there are no products.</h3>
                <?php endif; ?>
            </div>
        </div>
     <!--container end--> 
     
     <div id="myModa2" class="reveal-modal"> 
         <div class="modal-header">
            <button type="button" class="close-reveal-modal" data-dismiss="modal" aria-hidden="true">&times;</button>           
        </div> <!-- modal-header -->         
        <div class="modal-content">
            
        </div><!-- /.modal-content -->
     </div>    
     
     <div id="modalConfirm" class="reveal-modal">
     <div class="modal-header">
                <button type="button" class="close-reveal-modal" data-dismiss="modal" aria-hidden="true">&times;</button>
                
            </div> <!-- modal-header -->       
        <div class="modal-content">
            
            <div class="modal-body">
            <h4>Are you sure you want to delete this listing?</h4>
            <a id="confirm_yes" class="btn btn-default close-reveal-modal" style="font-size: 14px; font-weight: normal; position:relative; top:0; left:0;color:#fff;padding:13px;" data-dismiss="modal" aria-hidden="true">Yes</a> | <a class="btn btn-default close-reveal-modal" style="font-size: 14px; font-weight: normal; position:relative; top:0; left:0;color:#fff;padding:13px;" data-dismiss="modal" aria-hidden="true" id="confirm_no">No</a>
            </div>
            <div class="modal-footer">
                <div class='row'>             	    
                    <div class='col-xs-3 col-sm-6'>
                        <!-- <button type="button" class="btn btn-red" id='submitSignupBtn'>SAVE</button> -->
                    </div>
                </div>
            </div> <!-- modal-footer -->
        </div><!-- /.modal-content -->
     </div>     