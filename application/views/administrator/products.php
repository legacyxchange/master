<!--container start-->
        <div class="container main-content">
        
        <?php echo $administrator_menu; ?>
        <div class="add_new_butt admin_add_new_butt">
			<a href="#" class="products-big-link" data-reveal-id="productsModal"><span class="add_new_plus">+</span> add new</a>
		</div>
        	<div class="war">
            	<h2>PRODUCTS</h2>
                                
                <table class="table table-condensed">
                    <tr>
                        <th>Product Id</th>
                        <th>Product Type</th>
                        <th>User Id</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>&nbsp;</th>
                    </tr>                        
                    <?php if($products):?>
                    <?php foreach($products as $product):?>                                            
                    <tr>
                        <td class="rec-text"><?php echo $product->product_id;?></td>
                        <td class="rec-text"><?php echo $product->product_type;?></td>
                        <td class="rec-text"><?php echo $product->user_id;?></td>
                        <td class="rec-text"><?php echo $product->name;?></td>
                        <td class="rec-text"><img src="/admin/products/productimg/50/<?php echo $product->product_id;?>/<?php echo $product->image;?>" /></td>
                        <td valign="middle" align="right" class="icon">                                            
						<a href="#" id="<?=$product->product_id;?>" class="admin_edit_button" data-reveal-id="productsModal"><img src="/public/images/edit-admin.png" /> </a> 
						<a class="delete_button" data-reveal-id="modalConfirm" href="/admin/products/delete/<?php echo $product->product_id;?>"><img src="/public/images/delete.png" /> </a> 
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
     <div id="productsModal" class="reveal-modal"> 
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
            <h4>Are you sure you want to delete this product?</h4>
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