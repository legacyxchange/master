<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>

<div class="admin-menu-container container ">
	<?php echo $admin_menu;?>
</div>
<div  style="border-bottom:2px solid #0a6e8e;border-top:2px solid #0a6e8e;background:#f4f4f4;margin-top: 20px;padding-top: 16px;">
    <h2 class="admin-heading">List Products</h2>
</div>
<div class='row main-content'>
    <div class='col-md-8 col-md-offset-2' style="background: #fff;">
    	<div class='col-bg'>        
			<div class="container content">   
			    <div class="col-lg-6 pull-right">	
					<?php echo form_open_multipart('/admin/products/list/'.$product->product_id, array('name' => 'productform', 'id' => 'productform'));?>
					<div class='row'>
						<div class='col-md-6'>
							<img src='/products/productimg/300/<?=$product->product_id?>/<?php echo $product->image; ?>' class='img-thumbnail avatar'>
						</div>
						<div class='col-md-6'>
							<p> 	
							Click to browse your computer for the image, then simply click the Upload button. The image size should be 300 X 300 pixels or larger in .jpg, .gif or .png file formats only. 
							</p>					
							<input type='file' name='productimg' id='productimg' style="width:232px;" />			        
				    		
				    		  
						</div> 
					</div> 						
			    </div>	
				<div class='col-lg-6 tab-pane active form-horizontal pull-left' id='settings'>				
									
					<input type="hidden" name="product_id" value="<?php echo $product->product_id;?>" />
					<input type="hidden" name="user_id" value="<?php echo $product->user_id;?>" />
					<div class="form-group">
					    <label for="name" class="col-sm-3 control-label">Product Name</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='name' id='name' value="<?=$product->name;?>">
							<div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="description" class="col-sm-3 control-label">Product Description</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='description' id='description' value="<?=$product->description;?>">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
					    <label for="retail_price" class="col-sm-3 control-label">Retail Price</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='retail_price' id='retail_price' value="<?=$product->retail_price;?>" placeholder="Retail Price" onchange="validate.checkUsername(this);">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->
					
					<div class="form-group">
						<label for="quantity" class="col-sm-3 control-label">Quantity</label> 
						<div class="col-sm-9">
							<input type='quantity' class='form-control' name='quantity' id='passwd' value="<?=$product->quantity;?>" placeholder='Quantity' onchange="validate.checkPassword(this);" />
							<div class="alert-danger"></div>
					    </div>
					</div>
					<!-- .form-group -->
					<div class="form-group">
						<label for="active" class="col-sm-3 control-label">Active</label> 
						<div class="col-sm-9">
							<input type='active' class='form-control' name='active' id='active' value="<?=$product->active;?>" placeholder='Active' onchange="validate.checkPasswordConfirm(this);" />
							<div class="alert-danger"></div>
						</div>
					</div>
						
					<div class="form-group">
					    <label for="keywords" class="col-sm-3 control-label">Keywords</label>
						<div class="col-sm-9">
							<input type='text' class='form-control' name='keywords' id='keywords' value="<?=$product->keywords;?>" onchange="validate.checkAddress(this);">
					        <div class="alert-danger"></div>
					    </div> <!-- col-9 -->
					</div> <!-- .form-group -->								
				</div>											
				
				    <div class="col-lg-12 col-md-12">
				    	<input type='submit' class='btn btn-primary pull-right formbtn' id='saveSettingsBtn' value="Save" />
				    </div>
				    <?php echo form_close();?>
				</div>
			</div>
		</div> <!-- /.col-bg -->
	</div> <!-- col8 -->
