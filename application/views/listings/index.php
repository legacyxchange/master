<style>
.listings_form{
float: right;
margin-right: 20px;
}
</style>
<section id="original-item" class="dark-bg ptb25 top-border" style="padding-bottom:0px;">
	<div class="container product-page-container">
		<!-- original items -->
		<div class="container">
			<?php require "listings_menu.php";?>
			<div class="container">    
        				<?php echo form_open('/listings/search/'.$product_type, array('name' => 'search_form', 'method' => 'post', 'class' => 'listings_form')); ?>
  						<input type="text" placeholder="Search" name="q" id="q" />
  						
  						<!-- <input type="hidden" name="category_id" value="2" /> -->
  						<input type="submit" value="GO" class="form-submit" />
						<?php echo form_close(); ?>
    		</div>
			<div class="section-content">
			<?php if($listings): ?>
				<div class="row">
					<div class="col-lg-12 available-item">
						<strong>CURRENTLY:</strong> <?php echo count($listings);?> <?php echo ucfirst($product_type);?> Items Available
					</div>					
				</div>
				<div class="row">                     
    				<?php foreach($listings as $listing):?>
                	<div class="cont-4 product-container-border-4 col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<div class="hover-img">
							<img class="centered-img" src="/products/productimg/218/<?=$listing->product_id;?>/<?=$listing->image;?>" />
							<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
								<div class="product-name"><?=$listing->name;?></div>
							</div>
						</div>
				    </div>
    				<?php endforeach;?>						
				</div>
				<!-- end row -->
				<div class="container" style="text-align: center;color:#006a8a;">
					<a href="" style="text-align: center;color:#006a8a;">&laquo; next &raquo;</a>
				</div>
				<div class="container">
				    <div style="font-size:12px;text-align:center;color:#006a8a;">Original Items are items that have been Scientifially Marked and Registered with LegacyXChange.  LegacyXChange Documents the Marking, and the Marking and Documentation are100% verifiable.
All Original Items are 100% Guaranteed Authentic.</div>
				</div>
			</div>
			<?php endif;?>
		</div>
	</div>
</section>
<!-- valued items -->
<?php if($listings2):?>       
<div class="row" style="margin-top:55px;">
	<div class="col-lg-12" style="background: url('/public/images/lightblue_gradient_bar.gif');background-repeat:no-repeat;">
		<h3 class="subtitle" style="color:#ff0000;font-weight:bold;text-decoration:italisize;">ALSO CHECK OUT THESE GREAT ITEMS!</h3>
	</div>
</div>
<section class="products-container">
	<div class="container">
	      
        <?php foreach($listings2 as $listing):?>
            <div class="cont-4 product-container-border-4 col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="hover-img">
					<img class="centered-img" src="/products/productimg/210/<?=$listing->product_id;?>/<?=$listing->image;?>" />
					<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
						<div class="product-name"><?=$listing->name;?></div>
					</div>
				</div>
			</div>
        <?php endforeach;?> 
         
	</div>
</section>
<?php endif;?>      