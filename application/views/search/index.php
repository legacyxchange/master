<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<img style="width: 100%; margin-top: 0px;" u="img-responsive"
	src="/public/images/b1.jpg" />
<!--container start-->
<section id="original-item" class="dark-bg ptb25">
	<div class="container">
		<div class="section-header">
			<h1>
				New Original Items
			</h1>
			<div class="subtitle">Never Before Sold - DNA Marked, Registered</div>
		</div>
	    <div class="section-content" style="margin-top: 30px;">
        <?php if(!is_array($listings)):?>
		    <div class="row">
				<div class="col-lg-12">
					<h1 style="text-align: center;"><?php echo $listings; ?></h1>
				</div>
			</div>
        <?php else: ?>      
        <?php foreach($listings as $listing): ?>
            <div class="product-container col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="product-image item-img">
					<img style="margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;" src="/products/productimg/200/<?=$listing->product_id;?>/<?=$listing->product->image;?>" />
					<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
						<div class="timer" id="<?php echo $listing->listing_id;?>"></div>
						<div class="row">
							<div class="product-price">Price: $<?=number_format($listing->product->retail_price, 2);?>
                		    	<a class="product-buynow-button" href="/listings/product/<?php echo $listing->product_id;?>">Buy Now</a>
							</div>
						</div>
						<div class="product-name"><?=$listing->product->name;?></div>
						<div class="product-description"><?php echo html_entity_decode($listing->product->description);?></div>
					</div>
				</div>
			</div>
        <?php endforeach;?>
        <?php endif; ?>
        </div>
	</div>
</section>
<section style="height: 100px; width: 100%; background: #fff;">
	<div class="container">&nbsp;</div>
</section>
<img style="width: 100%; margin-top: 0px;" u="img-responsive" src="/public/images/b2.jpg" />
<section style="background-color:#f4f4f4;height: auto; width: 100%;font-family:Georgia;">
	<div class="container">
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="padding-left:60px;padding-right:60px;">
			<div class="listing_product_heading">Selling<br/>Your Legacy</div>
			<p style="font-family:Georgia;text-align:justify;">
			    We DNA Mark Every item Sold on our site, list it for sale, sell
				it, ship it to us, we mark it and send directly to the Buyer. If you
				are an Originator of an item, contact us so we can assist you in
				marking the item when it is created or endorsed.
			</p>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="padding-left:60px;padding-right:60px;">
			<div class="listing_product_heading">Buying<br/>Your Legacy</div>
			<p style="font-family:Georgia;text-align:justify;">
			    We guarantee everything you purchase is marked by our plant- based
				DNA, assuring ownership can be tracked forever. Original items are
				100% guaranteed as authentic with the world's leading technology and
				the strictest protocols for ensuring chain of custody.
			</p>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="padding-left:60px;padding-right:60px;">
			<div class="listing_product_heading">Profiting From<br/>Your Legacy</div>
			<p style="font-family:Georgia;text-align:justify;">
			    The seller of any item that is sold for the first time on the site
				will continue to receive a percentage of all future sales of that
				same item if it ever sells again on the site. If a buyer purchases
				an item that is being sold for the first time, they also will
				receive a percentage of future sales of the item, if sold on the
				site, after they have sold the item.
			</p>
		</div>
	</div>
</section>
<section id="original-item">
	<div class="container">
		<div class="section-header" style="margin-top: 30px;">
			<h1>
				Secondary Items
			</h1>
		</div>
	    <div class="section-content">
        <?php if(!is_array($listings)):?>
		    <div class="row">
				<div class="col-lg-12">
					<h1 style="text-align: center;"><?php echo $listings; ?></h1>
				</div>
			</div>
        <?php else: ?>      
        <?php foreach($listings as $listing): ?>
            <div class="product-container product-container-listing col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="product-image item-img">
					<img style="margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;" src="/products/productimg/200/<?=$listing->product_id;?>/<?=$listing->product->image;?>" />
					<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
						<div class="timer" id="<?php echo $listing->listing_id;?>"></div>
						<div class="row">
							<div class="product-price">Price: $<?=number_format($listing->product->retail_price, 2);?>
                		    	<a class="product-buynow-button" href="/listings/product/<?php echo $listing->product_id;?>">Buy Now</a>
							</div>
						</div>
						<div class="product-name"><?=$listing->product->name;?></div>
						<div class="product-description"><?php echo html_entity_decode($listing->product->description);?></div>
					</div>
				</div>
			</div>
        <?php endforeach;?>
        <?php endif; ?>
        </div>
	</div>
</section>
<section style="background-color:#f4f4f4;height: auto; width: 100%;font-family:Georgia;margin-top:100px;margin-bottom:40px;">
	<img src="/public/images/jordan-collection.jpg" width="100%" />
</section>
<section class="container">
    <h1>Available Only at Best Sports Dealers Storefront</h1>
    <div class="section-content">
    <?php if(!is_array($listings)):?>
		<div class="row">
	        <div class="col-lg-12">
			    <h1 style="text-align: center;"><?php echo $listings; ?></h1>
			</div>
		</div>
    <?php else: ?>      
    <?php foreach($listings as $listing): ?>
        <div class="product-container product-container-listing col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="product-image item-img">
				<img style="margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;" src="/products/productimg/200/<?=$listing->product_id;?>/<?=$listing->product->image;?>" />
				<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
					<div class="timer" id="<?php echo $listing->listing_id;?>"></div>
					<div class="row">
						<div class="product-price">Price: $<?=number_format($listing->product->retail_price, 2);?>
                		    <a class="product-buynow-button" href="/listings/product/<?php echo $listing->product_id;?>">Buy Now</a>
						</div>
					</div>
					<div class="product-name"><?=$listing->product->name;?></div>
					<div class="product-description"><?php echo html_entity_decode($listing->product->description);?></div>
				</div>
			</div>
		</div>
        <?php endforeach;?>
        <?php endif; ?>
    </div>
</section>
<div class="clear"></div>
<!--container end-->