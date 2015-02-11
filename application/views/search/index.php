<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<section class="dark-bg ptb25">
	<div class="container">
		<div class="section-header" style="margin-top: -20px;">
		    
			<div style="text-align: center; color: #000; font-family: georgia regular; font-size: 44px; font-weight: normal;">
			<img src="/public/images/logo.gif" style="height:35px;text-align:center;"><br />
				Original Items
			</div>
			<div class="subtitle" style="margin-top: -18px; text-align: center; color: #000; font-family: georgia regular; font-size: 34px; font-weight: normal;">
			    Documented Authenticity - Scientifically Marked &amp; Registered
			</div>
		</div>
		<div class="container">
        <?php if(!is_array($listings['original'])):?>
		    <div class="row">
				<div class="col-lg-12">
					<h1 style="text-align: center;">Sorry...There are no listings matching that criteria.</h1>
				</div>
			</div>
        <?php else: ?>      
        <?php foreach($listings['original'] as $listing):?>
            <div class="cont-4 product-container-border-4 col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="hover-img" style="width:218px;height:218px;">
					<img class="centered-img" src="/products/productimg/218/<?=$listing->product_id;?>/<?=$listing->image;?>" />
					<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
						<div class="product-name"><?=$listing->name;?></div>
					</div>
				</div>
			</div>
        <?php endforeach;?>
        <?php endif; ?>
        </div>
        <div style="font-size:16px;color:#333;position:relative;z-index:1001;margin: 20px auto; margin-bottom:30px; padding-top:10px;padding-bottom:10px; background:#fff;text-align:center;display:block;" class="container">
            <i>Original Items have been marked with tracer materials that can be scientifically verified.  They are supplied to the originator 
               (owner/seller) solely for the purpose of creating items that can be guaranteed as 100% authentic.</i>
		</div>
	</div>
</section>

<img class="img-responsive" src='/public/images/game-slide.gif' />

<!--container start-->

<section style="height: 68px; width: 100%; background: #fff;">
	<div class="container">&nbsp;</div>
</section>
<div style="background:#f4f4f4;height:40px;text-align:center;padding-top:5px;padding-bottom:5px;" class=""><img src="/public/images/s2blogo.gif" /></div>
<img style="width: 100%; margin-top: 0px; max-height: 180px;" class="img-responsive" src="/public/images/b2.jpg" />
<section style="background: #f4f4f4; height: auto; width: 100%; font-family: Georgia;">
	<div class="container-min" style="max-width: 966px; margin: 0 auto;">
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="padding-left: 5px; padding-right: 5%;">
			<div class="listing_product_heading">
				Selling<br />Your Legacy
			</div>
			<p style="font-family: Georgia;">We mark every
				item the first time it is sold on our site, you list it for sale,
				sell it, ship it to us, we mark it and send it directly to the
				buyer.</p>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="padding-left: 10px; padding-right: 5%;">
			<div class="listing_product_heading">
				Buying<br />Your Legacy
			</div>
			<p style="font-family: Georgia;">Every item
				purchased has been scientifically marked. This mark provides the
				ability to track ownership and product authenticity for the life
				of the item.</p>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="padding-left: 10px; padding-right: 10px;">
			<div class="listing_product_heading">
				Profiting From<br />Your Legacy
			</div>
			<p style="font-family: Georgia;">The seller of
				any item that is sold for the first time on the site, and the buyer
				that purchases an item the first time it is sold on the site, will
				continue to receive a percentage of all future sales of that same
				item if sold on the site.</p>
		</div>
	</div>
</section>
<section style="background: #fff;">
	<div class="container">
		<div class="section-header" style="margin-top: 30px;">
			<div style="text-align: center; color: #000; font-family: georgia regular; font-size: 44px; font-weight: normal;">Secondary Items</div>
			<div class="subtitle" style="margin-top: -8px; text-align: center; color: #000; font-family: georgia regular; font-size: 34px; font-weight: normal;">
				Scientifically Marked & Registered<br style="line-height: 10px;" />Trending
				Now
			</div>
		</div>
		<div class="container">
        <?php if(!is_array($listings['secondary'])):?>
		    <div class="row">
				<div class="col-lg-12">
					<h1 style="text-align: center;">Sorry...There are no listings matching that criteria.</h1>
				</div>
			</div>
        <?php else: ?>      
        <?php foreach($listings['secondary'] as $listing):?>
            <div class="cont-4 product-container-border-4 col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="hover-img" style="width:218px;height:218px;">
					<img class="centered-img" src="/products/productimg/210/<?=$listing->product_id;?>/<?=$listing->image;?>" />
					<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
						<div class="product-name"><?=$listing->name;?></div>
					</div>
				</div>
			</div>
        <?php endforeach;?>
        <?php endif; ?>
        </div>
	</div>
</section>

<section style="height: 85px; width: 100%; background: #fff;">
	<div class="container">&nbsp;</div>
</section>

<style>
@media screen and (max-width: 1240px) {
    .flash-sale-items {
        border:0;
        background-color:gold;
    }
}
</style>
<section id="flash-sale-items" class="dark-bg ptb25" style="padding-top: 20px; padding-bottom: 20px;">
	<div class="container">
		<div class="section-header" style="margin-top: -20px;">
			<div
				style="text-align: center; color: #000; font-family: georgia regular; font-size: 44px; color: #ff0000; font-weight: normal;">
				Legacy Flash Items</div>
		</div>
		<div class="container" style="margin:0">
        	<?php if(!isset($flash_listings)):?>
		    <div class="row">
				<div class="col-lg-12"
					style="border: 2px solid #000; min-height: 297px; background: #fff;">
					<h1 style="text-align: center;"><?php echo $flash_listings; ?></h1>
				</div>
			</div>
       		<?php else: ?> 
        	<div class="col-lg-12 flash-sale-items flash-cont" style="width:966px;border: 2px solid #056c8c;margin:0 auto; height: 100%; background: #fff; padding: 20px; padding-bottom: 0px;">     
        		<?php foreach($flash_listings as $listing): ?>
        	<div style="width:218px;float:left;">
        	<div class="cont-4 product-container-border-flash col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="hover-img" style="width:218px;height:218px;">
					<img class="centered-img" src="/products/productimg/210/<?=$listing->product_id;?>/<?=$listing->image;?>" />
					<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
						<div class="product-name"><?=$listing->name;?></div>
					</div>
				</div>
			</div>
			<div style="margin-top: -19px; padding: 16px; width: 228px; background: #fff;" class="item-sale-info">
				<div style="font-weight: bold;">
					Was: <span style="background: url('/public/images/xout.gif'); background-repeat: no-repeat; background-position: center;">$<?php echo number_format($listing->retail_price,2); ?></span>
				</div>
				<div style="font-weight: bold; text-align: right;">
					Now: <span style="color: #ff0000;">$<?php echo number_format($listing->sale_price,2); ?></span>
				</div>
				</div>
			</div>
        		<?php endforeach;?>
        	<?php endif; ?>
        	</div>
		</div>
	</div>
</section>
<section style="background-color: #f4f4f4; height: auto; width: 100%; font-family: Georgia; margin-top: 100px; margin-bottom: 40px;">
	<img src="/public/images/sports_image_bg.gif" width="100%" />
</section>
<section style="height: 0px; width: 100%; background: #fff;">
	<div class="container">&nbsp;</div>
</section>

<style>
@media screen and (max-width: 320px) {
    .stores-area {
        margin-left:18%;
    }
}
</style>
<section id="stores">
	<div class="container" style="max-width: 1018px;">
		<div class="section-header" style="margin-top: -20px;">
			<div style="text-align: center; color: #000; font-family: Georgia Bold Italic; font-size: 28px; color: #056c8c; font-weight: bold;">
				<i>Find More of What You're Looking For<br />at These LegacyXChange Stores</i>
			</div>
		</div>
		<div class="container stores-area" style="max-width: 1008px;">
        	<?php if(!is_array($stores)):?>
		    <div class="row">
				<div class="col-lg-12" style="margin: 0 auto; border: 4px solid #056c8c; min-height: 153px; background: #fff;">
					<h1 style="text-align: center;"><?php echo $stores; ?></h1>
				</div>
			</div>
        	<?php else: ?> 
        	<?php foreach($stores as $listing): ?>
        	<div class="cont-6 product-container-border-6 col-lg-2 col-md-2 col-sm-4 col-xs-12" style="border: 3px solid #056c8c; border-radius: 5px;"">
				<div class="hover-img" style="width:153px;height:153px;">
					<img class="centered-img" src="/products/productimg/140/<?=$listing->product_id;?>/<?=$listing->image;?>" />
					<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
						<div class="product-name" style="font-size:12px;"><?=$listing->name;?></div>
					</div>
				</div>
			</div>
        	<?php endforeach;?>
        	<?php endif; ?>
        </div>
	</div>
</section>
<div class="clear"></div>
<div class="clear"></div>
<!--container end-->