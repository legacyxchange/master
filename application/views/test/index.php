<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>


<!-- listings / products container 4 across w/bgcolor and no border on product or container -->
<section class="products-container-border">
	<div class="container products-bgcolor">        
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
</section>

<!-- listings / products container 4 across w/o bgcolor and with border on products and container -->
<section class="products-container-border">
	<div class="container">         
        <?php foreach($listings as $listing):?>
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

<!-- listings / products container 5 across w/bgcolor and no border on products or container -->
<section class="products-container-border products-bgcolor">
	<div class="container">       
        <?php foreach($listings as $listing):?>
            <div class="cont-5 product-container-border-5 col-lg-2 col-md-2 col-sm-4 col-xs-12">
				<div class="hover-img" style="width:180px;height:180px;">
					<img class="centered-img" src="/products/productimg/170/<?=$listing->product_id;?>/<?=$listing->image;?>" />
					<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
						<div class="product-name"><?=$listing->name;?></div>
					</div>
				</div>
			</div>
        <?php endforeach;?>      
	</div>
</section>

<!-- listings / products container 5 across w/bgcolor w/ border on products and container -->
<section class="products-container-border">
	<div class="container">     
        <?php foreach($listings as $listing):?>
            <div class="cont-5 product-container-border-5 col-lg-2 col-md-2 col-sm-4 col-xs-12">
				<div class="hover-img" style="width:180px;height:180px;">
					<img class="centered-img" src="/products/productimg/170/<?=$listing->product_id;?>/<?=$listing->image;?>" />
					<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
						<div class="product-name"><?=$listing->name;?></div>
					</div>
				</div>
			</div>
        <?php endforeach;?>        
	</div>
</section>

<!-- listings / products container 6 across w bgcolor w/o border on products and container -->
<section class="products-bgcolor">
	
      <div class="container">      
        <?php foreach($listings as $listing):?>
            <div class="cont-6 product-container-border-6 col-lg-2 col-md-2 col-sm-4 col-xs-12">
				<div class="hover-img" style="width:153px;height:153px;">
					<img class="centered-img" src="/products/productimg/140/<?=$listing->product_id;?>/<?=$listing->image;?>" />
					<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
						<div class="product-name"><?=$listing->name;?></div>
					</div>
				</div>
			</div>
        <?php endforeach;?> 
       </div> 
	
</section>

<!-- listings / products container 6 across w/o bgcolor w/ border on products and container -->
<section class="products-container-border">
	   <div class="container">    
        <?php foreach($listings as $listing):?>
            <div class="cont-6 product-container-border-6 col-lg-2 col-md-2 col-sm-4 col-xs-12">
				<div class="hover-img" style="width:153px;height:153px;">
					<img class="centered-img" src="/products/productimg/140/<?=$listing->product_id;?>/<?=$listing->image;?>" />
					<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
						<div class="product-name"><?=$listing->name;?></div>
					</div>
				</div>
			</div>
        <?php endforeach;?>
       </div> 
</section>
