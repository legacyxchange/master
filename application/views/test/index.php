<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- left menu ---- listings / products container 3 across w/o bgcolor and border on product or container -->
<section class="products-container-border">
	<div class="container"> 
	    <div class="left-menu col-lg-3 col-md-3">
	        <div class="category_heading" style="font-weight:bold;font-size:20px;">
				Categories<br /><br />
			</div>
			<ul style="color:#9e9e9e;font-weight:bold; list-style-type:none;">
			    <li><a href="">Sports</a><br /><br /></li>
			    <li><a href="">Collectables</a><br /><br /></li>
			    <li><a href="">Electronics</a><br /><br /></li>
			    <li><a href="">Fashion</a><br /><br /></li>
			    <li><a href="">Home</a><br /><br /></li>
			    <li><a href="">Hobbies</a><br /><br /></li>
			    <li><a href="">Motors</a><br /><br /></li>
			    <li><a href="">All</a></li>
			</ul> 
			
			<div style="width:174px;height:74px;">&nbsp;</div>
			
			<div class="store-img">
				<img class="img-responsive" src="/public/images/rsampson.gif" width="174" />
			</div>
			<div class="store-text">Ralph Sampson Super Store</div>
			
			<div class="store-img">
				<img class="img-responsive" src="/public/images/furniture-store.gif" width="174" />
			</div>
			<div class="store-text">The Vintage Mark Store</div>
			
			<div class="store-img">
				<img class="img-responsive" src="/public/images/bgrich.gif" width="174" />
			</div>
			<div class="store-text">Bobby Grich Player's Stop</div>
	    </div>
	    <div class="col-lg-9">    
        	<?php foreach($listings as $listing):?>
            <div class="cont-3 product-container-border-3 col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="hover-img">
					<img class="centered-img" src="/products/productimg/218/<?=$listing->product_id;?>/<?=$listing->image;?>" />
					<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
						<div class="product-name"><?=$listing->name;?></div>
					</div>
				</div>
			</div>
            <?php endforeach;?>  
        </div>       
	</div>
</section>

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
