<style>.dropdown-menu>li>a { margin-left:20px; }</style>
<div class="section-header" style="margin-top: 0px;background:#e9f3f7;height:160px;padding-top:10px;">
    <?php if($product_type == 'original'):?>   
	<div style="text-align: center; color: #000; font-family: georgia regular; font-size: 36px; font-weight: normal;">
		<img class="img" src="/public/images/logo.gif" style="height:35px;text-align:center;margin:0 auto;"><br />
		Original Items
	</div>
	<div class="subtitle" style="margin-top: -6px; text-align: center; color: #000; font-family: georgia; font-size: 26px; font-weight: normal;">
    Guaranteed - Scientifically Marked 
	</div>
	<?php elseif($product_type == 's2bxchange'):?>   
	<div style="text-align: center; color: #000; font-family: georgia regular; font-size: 36px; font-weight: normal;">
		<img class="img" src="/public/images/s2bxchange.gif" style="height:35px;text-align:center;margin:0 auto;"><br />
		Sellers 2 Buyers
	</div>
	<div class="subtitle" style="margin-top: -8px; text-align: center; color: #000; font-family: georgia; font-size: 26px; font-weight: normal;">
    Free Listings - No Commissions
	</div>
	<?php elseif($product_type == 's2bplus'):?>   
	<div style="text-align: center; color: #000; font-family: georgia regular; font-size: 36px; font-weight: normal;padding-top:10px;">
		<img class="img" src="/public/images/s2bpluslogo.gif" style="height:35px;text-align:center;margin:0 auto;"><br />
		<i>ON SALE NOW</i>
	</div>
	<div class="subtitle" style="margin-top: -8px; text-align: center; color: #000; font-family: georgia; font-size: 26px; font-weight: normal;">
    
	</div>
	<?php endif;?>
</div>

<style>
li a { letter-spacing:1px; }
li { margin-left: -20px; }
</style>
<section class="products-container-no-border">
	<div class="container"> 
	    <div class="left-menu col-lg-3 col-md-3">
	        <?php echo $left_menu; ?>
			<div style="margin-left:30px;">
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
	    </div>
	    <div class="col-lg-9">
	    <div class="container num_prod_heading">
    <span style="color:#000;font-weight:bold;"> CURRENTLY: &nbsp;</span><span style="color:#00698a;"><?php echo count($listings);?> Listings Available</span>
</div>    
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