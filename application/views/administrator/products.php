<!--container start-->
<div class="container">
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
	<?php echo $administrator_menu; ?> 
	<div class="add_new_butt">
    	<a href="#" class="big-link" data-reveal-id="myModa2"><span class="add_new_plus">+</span> add new</a>
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
        	<?php foreach($products as $product): ?>                                            
        	<tr>
            	<td class="rec-text"><?php echo $product->product_id;?></td>
            	<td class="rec-text"><?php echo $product->product_type;?></td>
            	<td class="rec-text"><?php echo $product->user_id;?></td>
            	<td class="rec-text"><?php echo $product->name;?></td>
            	<td class="rec-text"><img src="/admin/products/productimg/100/<?php echo $product->product_id;?>/<?php echo $product->image;?>" /></td>
            	<td valign="middle" align="right" class="icon">                                            
					<a href="#" id="<?=$product->product_id;?>" class="big-link edit_button" data-reveal-id="myModa2"><img src="/public/images/edit-admin.png" /> </a> 
					<a href="/administrator/products/delete/<?php echo $product->product_id;?>" onclick="return confirm('Are you sure you want to delete this product?');"><img src="/public/images/delete.png" /> </a> 
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