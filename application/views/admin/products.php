
<div class="admin-menu-container container ">
	<?php echo $admin_menu;?>
</div>
<div  style="border-bottom:2px solid #0a6e8e;border-top:2px solid #0a6e8e;background:#f4f4f4;margin-top: 20px;padding-top: 16px;">
    <h2 class="admin-heading">My Products</h2>
</div>
<!--container start-->
    <div class="container content">
    <style>
    .left-stats { float:left; letter-spacing:1px;}
    .left-stats-heading{font-weight:bold;font-family:arial;}
    .products-headings tr th{text-align:center;}
    .edit-view{width:108px;}
    .edit-delete-buttons{width:58px;}
    .sort-select-box{margin-right:0px;margin-bottom:60px;}
    .sortby{float:right;}
    .add-button{
        border:1px solid #006989;
    	height: 30px;
    	padding:0px;
    	line-height:20px;
    	background: -webkit-linear-gradient(#fff, #006989,#000); /* For Safari 5.1 to 6.0 */
    	background: -o-linear-gradient(#fff, #006989,#000); /* For Opera 11.1 to 12.0 */
    	background: -moz-linear-gradient(#fff, #006989,#000); /* For Firefox 3.6 to 15 */
    	background: linear-gradient(#fff, #006989,#000); /* Standard syntax (must be last) */ 
    	letter-spacing:1px;
    	font-family:arial;
    }
    th, td{ border:1px solid #aaa;text-align:center; }
    .modal-dialog{background:#fff;}
    .btn{letter-spacing:1px;padding:2px;padding-left:5px;padding-right:5px;}
.btn-blue {
color: #fff;
background-color: #006989;
border-color: #006989;
}
.btn-red {
color: #fff;
background-color: #ff0000;
border-color: #ff0000;
}
.btn-green {
color: #fff;
background-color: #008000;
border-color: #008000;
}
.btn:hover{color:#000;}
    </style>
        <div class="left-stats">
			<div class="left-stats-heading">You currently have:</div>
			<div class="left-stats-numproducts"><span style="text-decoration:underline;"><?php echo count($products);?></span> Products Entered in the System</div>
			<div class="left-stats-numproducts"><span style="text-decoration:underline;"><?php echo $listings_count;?></span> Products Listed for Sale</div>
		</div>
        <div class="admin_add_new_butt">
			<!-- <a href="#" class="products-big-link" data-toggle="modal" data-target="#productsModal"><span class="add_new_plus">+</span> add new</a> -->
			<a href="#" class="add-button" data-toggle="modal" data-target="#productsModal" style="color:#fff;padding:5px;padding-top:8px;">Add Product</a>
		</div>
        <div>                               
            <table class="table table-condensed table-hover products-headings" data-toggle="table"> 
                <tr style="background:#ccc;">
                	<th>Name / Description</th>
                    <th>Product Number</th>
                    <th>Product Type</th>
                    <th>Product Listing</th>
                    <th>Sale Type</th>
                    <th>Reserve Price</th>
                    <th>Current Bid</th>
                    <th>Sale Ends</th>
                    <th>Image</th>
                    <th>&nbsp;</th>
                </tr>                        
                <?php if($products):?>
                <?php foreach($products as $product): //var_dump($product); ?>                                            
                <tr>
                	<td class="rec-text"><?php echo $product->name;?> / <?php echo $product->description;?></td>
                    <td class="rec-text"><?php echo $product->product_id;?></td>
                    <td class="rec-text"><?php echo $product->product_type;?></td>
                    <?php if($listings_count > 0):?> 
                    <td class="rec-text edit-view">
                    <a class="btn btn-blue" target="_blank" href="/listings/product/<?php echo $product->product_id;?>">View</a>
                    <a href="#" id="<?=$product->listing_id;?>" class="admin_edit_button btn btn-red" data-toggle="modal" data-target="#listingsModal">Edit</a>
                    <?php if($product->listing->advertisements->advertisement_id):?>
                    	<a href="/admin/advertisements/edit/<?=$product->listing->advertisements->advertisement_id;?>" id="<?=$product->listing->advertisements->advertisement_id;?>" style="width:84px;margin-top:5px;" class="btn btn-green">Advertise</a>
                    <?php else:?>
                    	<a href="/admin/advertisements/add/<?=$product->listing_id;?>" id="<?=$product->listing_id;?>" style="width:84px;margin-top:5px;" class="btn btn-green">Advertise</a>
                    <?php endif;?>
                    </td>
                    <?php else:?>
                    <td class="rec-text"><a href="#" id="" rel="<?=$product->product_id;?>" class="admin_edit_button" data-toggle="modal" data-target="#listingsModal">List Product</a></td>
                    <?php endif;?>
                    <td class="rec-text"><?php echo $product->listing_type; ?></td>   
                    <td class="rec-text">$<?php echo number_format($product->reserve_price,2); ?></td>
                    <td class="rec-text">$<?php echo number_format($product->current_bid,2); ?></td>
                    <td class="rec-text"><?php echo date('Y-m-d h:i a', strtotime($product->expires)); ?></td>
                    <td class="rec-text"><img src="/products/productimg/50/<?php echo $product->product_id;?>/<?php echo $product->image;?>" /></td>
                    <td valign="middle" align="right" class="icon edit-delete-buttons">                                            
						<a href="#" id="<?=$product->product_id;?>" class="admin_edit_button" data-toggle="modal" data-target="#productsModal"><img src="/public/images/edit-admin.png" /> </a> 
						<a class="delete_button" data-toggle="modal" data-target="#modalConfirm" href="/admin/products/delete/<?php echo $product->product_id;?>"><img src="/public/images/delete.png" /> </a> 
					</td>
                </tr>                                       
                <?php endforeach;?> 
            </table>
            <div class="sort-select-box col-lg-3 col-md-3 pull-right">
            	<select name="sortby" id="sortby" class="sortby">
            		<option value="">Sort</option>
            		<option value="1">Listed</option>
            		<option value="2">Not Listed</option>
            		<option value="3">LegacyXChange</option>
            		<option value="4">S2BXChange</option>
            		<option value="5">S2BPlus</option>
            	</select>
            </div>
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