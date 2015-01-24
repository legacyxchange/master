<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<img style="width: 100%; margin-top: 0px;" class="img-responsive"
	src="/public/images/b1.jpg" />
<!--container start-->
<section class="dark-bg ptb25">
	<div class="container">
		<div class="section-header" style="margin-top: -20px;">
			<div
				style="text-align: center; color: #000; font-family: georgia regular; font-size: 44px; font-weight: normal;">
				Original Items</div>
			<div class="subtitle"
				style="margin-top: -18px; text-align: center; color: #000; font-family: georgia regular; font-size: 34px; font-weight: normal;">Documented
				Authenticity - Scientifically Marked &amp; Registered</div>
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
            <div class="product-container col-lg-3 col-md-3 col-sm-6 col-xs-12" style="border: 0;">
				<div class="product-image item-img">
					<img style="margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;" src="/products/productimg/218/<?=$listing->product_id;?>/<?=$listing->image;?>" />
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
<section style="height: 68px; width: 100%; background: #fff;">
	<div class="container">&nbsp;</div>
</section>
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
            <div class="product-container col-lg-3 col-md-3 col-sm-6 col-xs-12" style="border: 1px solid #ccc;margin-right:10px;">
				<div class="hover-img">
					<img style="border:0px solid #ccc; margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;" src="/products/productimg/210/<?=$listing->product_id;?>/<?=$listing->image;?>" />
					<div hover-info-id="<?php echo $listing->product_id;?>"
						class="hover-info">
						<!-- <div class="timer" id="<?php echo $listing->listing_id;?>"></div> -->
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
					style="border: 2px solid #000; min-height: 265px; background: #fff;">
					<h1 style="text-align: center;"><?php echo $flash_listings; ?></h1>
				</div>
			</div>
       		<?php else: ?> 
        	<div class="col-lg-12" style="width:100%;border: 2px solid #056c8c;margin:0 auto; min-height: 265px; background: #fff; padding: 20px; padding-bottom: 0px;">     
        		<?php foreach($flash_listings as $listing): ?>
        	<div style="width:218px;float:left;">
        	<div class="hover-img">
            	<div class="product-container col-lg-3 col-md-3 col-sm-6 col-xs-12">					
					<img style="margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; border: 0px solid #aaa;" src="/products/productimg/180/<?=$listing->product_id;?>/<?=$listing->image;?>" />
					<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
						<div class="product-name"><?=$listing->product->name;?></div>
					</div>										
				</div>
			</div>
				<div style="margin-top: -19px; padding: 5px; width: 100%; background: #fff;" class="item-sale-info">
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
<section
	style="background-color: #f4f4f4; height: auto; width: 100%; font-family: Georgia; margin-top: 100px; margin-bottom: 40px;">
	<img src="/public/images/sports_image_bg.gif" width="100%" />
</section>
<section style="height: 0px; width: 100%; background: #fff;">
	<div class="container">&nbsp;</div>
</section>
<section id="stores">
	<div class="container" style="max-width: 1018px;">
		<div class="section-header" style="margin-top: -20px;">
			<div
				style="text-align: center; color: #000; font-family: Georgia Bold Italic; font-size: 28px; color: #056c8c; font-weight: bold;">
				<i>Find More of What You're Looking For<br />at These LegacyXChange
					Stores
				</i>
			</div>
		</div>
<style>
@media screen and (max-width: 320px) {
    .stores-area {
        margin-left:18%;
    }
}
</style>
		<div class="container stores-area" style="max-width: 1008px;">
        <?php if(!is_array($stores)):?>
		    <div class="row">
				<div class="col-lg-12"
					style="margin: 0 auto; border: 4px solid #056c8c; min-height: 153px; background: #fff;">
					<h1 style="text-align: center;"><?php echo $stores; ?></h1>
				</div>
			</div>
        <?php else: ?> 
        <?php foreach($stores as $store): ?>
        <div style="float: left;">
				<div class="item-container col-lg-4 col-md-2 col-sm-2 col-xs-12"
					style="width: 153px; height: 153px; margin-bottom: 10px; border: 3px solid #056c8c; border-radius: 5px; margin-right: 10px; overflow: hidden;">
					<div class=""
						style="width: 153px; height: 153px; margin-right: 10px;">
						<img
							style="margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; border: 1px solid #aaa;"
							src="/locations/locationimg/140/<?=$store->id;?>/<?=$store->fileName;?>" />
					</div>

				</div>
				<div
					style="font-family: arial; font-size: 15px; font-weight: bold; margin-top: 0px; padding: 5px; width: 153px; background: #fff; text-align: center;"
					class="item-sale-info">
					<?php echo $store->name; ?>
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