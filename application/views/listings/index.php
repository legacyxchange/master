<div class="section-header" style="margin-top: 0px;background:#f4f4f4;padding-top:5px;padding-bottom:10px;border-bottom:3px outset #aaa;">
    <?php if($product_type):?>   
	<div style="text-align: center; color: #000; font-family: georgia regular; font-size: 36px; font-weight: normal;">
		<?php echo $product_type_heading; ?>
	</div>	
	<?php endif;?>
</div>
<section class="products-container-no-border">
	<div class="container"> 
	    <div class="container num_prod_heading" style="margin-top: 20px;margin-bottom: 20px;">
    		<span style="color:#000;font-weight:bold;"> CURRENTLY: &nbsp;</span><span style="color:#00698a;"><?php echo count($listings);?> <?php echo ucfirst($product_type);?> Items Available</span>
		</div>    
        <?php foreach($listings as $listing):?>
        <div class="listings-4 product-container-border-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="hover-img">
				<img class="centered-img" src="/products/productimg/218/<?=$listing->product_id;?>/<?=$listing->image;?>" />
				<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
					<div class="product-name"><?=$listing->name;?></div>
				</div>
			</div>
		</div>
        <?php endforeach;?>  
    </div>       
</section>
<div class="paginator-container container" style="height:100px;">
<?php if($paginator):?>

<?php endif;?>
</div>
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