<!--container start-->
        <div class="container main-content">
        
        <?php echo $admin_menu; ?>
        <div class="admin_add_new_butt">
			<a href="#" class="products-big-link" data-toggle="modal" data-target="#productsModal"><span class="add_new_plus">+</span> add new</a>
		</div>
        	<div class="war">
            	<h2>My PRODUCTS</h2>
                                
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
                        <td class="rec-text"><img src="/products/productimg/50/<?php echo $product->product_id;?>/<?php echo $product->image;?>" /></td>
                        <td valign="middle" align="right" class="icon">                                            
						<a href="#" id="<?=$product->product_id;?>" class="admin_edit_button" data-toggle="modal" data-target="#productsModal"><img src="/public/images/edit-admin.png" /> </a> 
						<a class="delete_button" data-toggle="modal" data-target="#modalConfirm" href="/admin/products/delete/<?php echo $product->product_id;?>"><img src="/public/images/delete.png" /> </a> 
						</td>
                    </tr>                                       
                <?php endforeach;?> 
                </table>
                <?php if($this->pagination):?>
                <div class="pagination">
        			<?php echo $this->pagination->create_links(); ?>
    			</div>  
    			<?php endif; ?>             
                <?php else: ?>
                <h3 class="alert alert-warning">Sorry there are no products.</h3>
                <?php endif; ?>
            </div>
        </div>
     <!--container end-->  
     
    <!-- start productsModal --> 
    <div id="productsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="productsModal" aria-hidden="true"> 
        <div class="modal-dialog">
            <div class="modal-header" style="text-align: right;">
                <button type="button" data-dismiss="modal">&times;</button>           
        	</div> <!-- modal-header -->         
        	<div class="modal-content">
            
        	</div><!-- /.modal-content -->
     	</div>    
     </div>
     <!-- end productsModal -->
     
    <div id="modalConfirm" class="modal fade" tabindex="-2" role="dialog" aria-labelledby="modalConfirm" aria-hidden="true">
        <div class="modal-dialog" style="background: #fff;">
     		<div class="modal-header" style="text-align: right;">
                <button type="button" data-dismiss="modal">&times;</button>           
        	</div> <!-- modal-header -->       
         	<div class="content" style="background: #fff;">                      
            	<h4>Are you sure you want to delete this product?</h4>
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