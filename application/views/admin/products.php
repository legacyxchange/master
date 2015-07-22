<script src="/public/js/products.js" type="text/javascript"></script>
<div class="admin-menu-container container">
	<?php echo $admin_menu;?>
</div>
<div  style="border-bottom:2px solid #0a6e8e;border-top:2px solid #0a6e8e;background:#f4f4f4;margin-top: 20px;padding-top: 16px;">
    <h2 class="admin-heading">My Products</h2>
</div>
<!--container start-->
<div class="container main-content">
<div class="col-lg-12 col-md-12">
<div class="col-lg-9">SHOWING: <?php echo $sortby;?></div>
<div class="col-lg-3">
<a href="/admin/products/add" class="btn btn-blue pull-right">Add Product</a>
</div>
</div>   

        <div class="left-stats">
			<div class="left-stats-heading">You currently have:</div>
			<div class="left-stats-numproducts"><span style="text-decoration:underline;"><?php echo count($products);?></span> Products Entered in the System</div>
			<div class="left-stats-numproducts"><span style="text-decoration:underline;"><?php echo $listings_count;?></span> Products Listed for Sale</div>
		</div>        
        <div class="container">                               
            <table class="table table-condensed table-hover products-headings" data-toggle="table"> 
                <tr style="background:#ccc;">
                	<th>Name / Description</th>
                    <th>Legacy Number</th>
                    <th>Type</th>
                    <th>Listed</th>
                    <th>Sale Type</th>
                    <th>Reserve Price</th>
                    <th>Sale Price</th>
                    <th>Current Bid</th>
                    <th>Sale Ends</th>
                    <th>Image</th>
                    <th>Advertising Used</th>
                    <th>&nbsp;</th>
                </tr>                        
                <?php if($products):?>
                <?php foreach($products as $product): ?>                                            
                <tr>
                	<td class="rec-text"><?php echo $product->name;?> / <?php echo $product->description;?></td>
                    <td class="rec-text"><?php echo $product->product_id;?></td>
                    <td class="rec-text"><?php echo $product->product_type;?></td>
                    <td class="rec-text edit-view">
                    <?php if($listings_count > 0):?>                     
                    <a class="btn btn-blue" target="_blank" href="/listings/product/<?php echo $product->product_id;?>">View</a>
                    <a href="/admin/products/edit/<?=$product->product_id;?>" class="admin_edit_butt btn btn-red">Edit</a>
                    <?php if($product->listing->advertisements->advertisement_id):?>
                    	<a href="/admin/advertisements/edit/<?=$product->listing->advertisements->advertisement_id;?>" id="<?=$product->listing->advertisements->advertisement_id;?>" style="width:84px;margin-top:5px;" class="btn btn-green">Advertise</a>
                    <?php else:?>
                    	<a href="/admin/advertisements/add/<?=$product->listing_id;?>" id="<?=$product->listing_id;?>" style="width:84px;margin-top:5px;" class="btn btn-green">Advertise</a>
                    <?php endif;?>
                    <a href="/admin/listings/edit/<?=$product->product_id;?>" id="<?=$product->product_id;?>" class="admin_list_button btn btn-blue">List</a>
                    </td>
                    <?php else:?>
                    <td class="rec-text">
                    <a href="/admin/listings/add" id="" rel="<?=$product->product_id;?>" class="btn btn-xs btn-silver">List</a></td>
                    <?php endif;?>
                    <td class="rec-text"><?php echo $product->listing_type; ?></td>   
                    <td class="rec-text">$<?php echo number_format($product->reserve_price,2); ?></td>
                    <td class="rec-text">$<?php echo number_format($product->current_bid,2); ?></td>
                    
                    <td class="rec-text"><?php echo date('Y-m-d h:i a', strtotime($product->expires)); ?></td>
                    <td class="rec-text"><img src="/products/productimg/50/<?php echo $product->product_id;?>/<?php echo $product->image;?>" /></td>
                    <td class="rec-text">
                    <?php if($product->listing->advertisements->advertisement_id):?> 
                    <a href="/admin/advertisements/edit/<?=$product->listing->advertisements->advertisement_id;?>" id="<?=$product->listing->advertisements->advertisement_id;?>" class="btn btn-silver">Edit</a>
                    <?php else:?>
                    <a href="/admin/advertisements/add/<?=$product->listing_id;?>" id="<?=$product->listing_id;?>" style="width:84px;margin-top:5px;" class="btn btn-silver">Advertise</a>
                    <?php endif;?>
                    </td>
                    <td valign="middle" align="right" class="icon edit-delete-buttons">                                            
						<a href="/admin/products/edit/<?=$product->product_id;?>" id="<?=$product->product_id;?>" class="admin_edit_butt"><img src="/public/images/edit-admin.png" /></a> 
						<a class="delete_button" data-toggle="modal" data-target="#modalConfirm" href="/admin/products/delete/<?php echo $product->product_id;?>"><img src="/public/images/delete.png" /> </a> 
					</td>
                </tr>                                       
                <?php endforeach;?> 
            </table>
            <div class="sort-select-box col-lg-3 col-md-3 pull-right">
                <?php echo form_open('/admin/products', array('id' => 'sorting', 'name' => 'sorting'));?>
            	<select name="sortby" id="sortby" class="sortby" onchange="$('#sorting').submit();">
            		<option value="">Sort</option>
            		<option value="Listed">Listed</option>
            		<option value="Drafts">Drafts</option>
            		<option value="Original Items">Original Items</option>
            		<option value="Marketplace Items">Marketplace Items</option>
            		<option value="Legacy X Plus">Legacy X Plus</option>
            	</select>
            	<?php echo form_close();?>
            </div>
            <?php if($this->pagination):?>
            <div class="pagination">
        		<?php echo $this->pagination->create_links(); ?>
    		</div>  
    		<?php endif; ?>             
            <?php else: ?>
            <h3 class="alert alert-warning" style="margin-bottom:40px;">Sorry there are no products matching that criteria.</h3>
            <div class="sort-select-box col-lg-12 col-md-12 pull-right">
                <?php echo form_open('/admin/products', array('id' => 'sorting', 'name' => 'sorting'));?>
            	<select name="sortby" id="sortby" class="sortby" onchange="$('#sorting').submit();">
            		<option value="">Sort</option>
            		<option value="Listed">Listed</option>
            		<option value="Drafts">Drafts</option>
            		<option value="Original Items">Original Items</option>
            		<option value="Marketplace Items">Marketplace Items</option>
            		<option value="Legacy X Plus">Legacy X Plus</option>
            	</select>
            	<?php echo form_close();?>
            </div>
            <?php endif; ?>
        </div>
</div>

    <!--container end-->  
    
           <!-- ////////////////////////////////////////////////  START MODALS  ////////////////////////////////////////////////// -->    
    <div id="advertisementsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="advertisementsModal" aria-hidden="true"> 
         <div class="modal-dialog">
            
            <div class="modal-header" style="text-align: right;">
                <button type="button" data-dismiss="modal">&times;</button>           
        	</div> <!-- modal-header --> 
        	       
        	<div class="modal-content">
            	
        	</div><!-- /.modal-content -->
        	
     	</div>    
     </div>  
     
    <div id="paymentsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="paymentsModal" aria-hidden="true"> 
         <div class="modal-dialog">
            <div class="modal-header" style="text-align: right;">
                <button type="button" data-dismiss="modal">&times;</button>           
        	</div> <!-- modal-header --> 
        	<div class="top-text-box" style="background:#fff;border:1px solid #000;padding:20px;padding-top:3px;padding-bottom:3px;margin:20px;font-family:arial;font-size:14px;">
            	Add funds here.
            	</div>        
        	<div class="modal-content">
            	
        	</div><!-- /.modal-content -->
     	</div>    
     </div> 
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
     
     <div id="listingsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="listingsModal" aria-hidden="true"> 
         <div class="modal-dialog">
            <div class="modal-header" style="text-align: right;">
                <button type="button" data-dismiss="modal">&times;</button>           
        	</div> <!-- modal-header -->         
        	<div class="modal-content">
            
        	</div><!-- /.modal-content -->
     	</div>    
     </div>  
     
    <div style="padding:0;height:260px;" id="modalConfirm" class="modal fade" role="dialog" aria-labelledby="modalConfirm" aria-hidden="true">
        <div class="modal-dialog" style="background: #fff;">
     		<div class="modal-header" style="text-align: right;">
                <button style="width:30px;" type="button" data-dismiss="modal">&times;</button>           
        	</div> <!-- modal-header -->       
         	<div class="content" style="background: #fff;">                      
            	<h4>Are you sure you want to delete this product?</h4>
            	<a id="confirm_yes" class="btn btn-default" style="font-size: 14px; font-weight: normal; position:relative; top:0; left:0;color:#000;padding:13px;" data-dismiss="modal" aria-hidden="true">Yes</a>  <a class="btn btn-default close-reveal-modal" style="font-size: 14px; font-weight: normal; position:relative; top:0; left:0;color:#000;padding:13px;" data-dismiss="modal" aria-hidden="true" id="confirm_no">No</a>           
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