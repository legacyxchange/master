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
        <div style="font-size:16px;color:#333;position:relative;z-index:1001;margin: 20px auto; margin-bottom:-27px; padding-top:10px;padding-bottom:10px; background:#fff;text-align:center;display:block;" class="container">
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
<div style="background:#f4f4f4;height:49px;text-align:center;padding-top:5px;padding-bottom:5px;" class=""><img src="/public/images/s2blogo.gif" /></div>
<section style="height: 220px; width: 100%; background: #00698a;border-top:3px outset #f4f4f4;border-bottom:4px inset #333;">
	<div class="s2bheading" style="font-family:geargia;font-size:48px;color:#fff;text-align:center;">
	   Sellers 2 Buyers
    </div>
    <div class="s2bsubheading" style="margin-top:20px;font-family:geargia;font-size:38px;color:#fff;text-align:center;">
	   General Merchandise - Deal Direct<br/>
	   <i>Free Listings - No Commissions</i>
    </div>
</section>

<style>
.cat-list a{ margin-left:-20px; color:#545454; text-decoration:none;}
.store-img { width:174px;height:174px;border:3px solid #000;border-radius:5px;overflow:hidden; }
.store-text { width:174px;text-align:center;font-size:18px;font-weight:bold;margin-bottom:30px;font-style:italic; }
</style>
<section style="background: #fff; height: auto; width: 100%; font-family: Georgia;">
	<div class="container cat-list">
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="padding-left: 5px; padding-right: 5%;">
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
			
			<div style="width:174px;height:174px;">&nbsp;</div>
			
			<div class="store-img">
				<img src="/public/images/rsampson.gif" width="174" />
			</div>
			<div class="store-text">store or image name</div>
			
			<div class="store-img">
				<img src="/public/images/furniture-store.gif" width="174" />
			</div>
			<div class="store-text">store or image name</div>
			
			<div class="store-img">
				<img src="/public/images/bgrich.gif" width="174" />
			</div>
			<div class="store-text">store or image name</div>
		</div>
		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12" style="padding-left: 10px; padding-right: 5%;">
			<img src="/public/images/watches.gif" />
		</div>
		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12" style="padding-left: 10px; padding-right: 10px;">
			<img src="/public/images/sneakers.gif" />
		</div>
		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12" style="padding-left: 10px; padding-right: 10px;">
			<img src="/public/images/jewelery.gif" />
		</div>
		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12" style="padding-left: 10px; padding-right: 10px;">
			<img src="/public/images/electronics.gif" />
		</div>
	</div>
</section>

<style>
#flash-sale-items  {
    height:700px;
    background: -webkit-linear-gradient(#016a8a, #f4f4f4); /* For Safari 5.1 to 6.0 */
    background: -o-linear-gradient(#016a80, #f4f4f4); /* For Opera 11.1 to 12.0 */
    background: -moz-linear-gradient(#016a8a, #f4f4f4); /* For Firefox 3.6 to 15 */
    background: linear-gradient(#026a8b, #f4f4f4); /* Standard syntax (must be last) */
}
@media screen and (max-width: 340px) {
    #flash-sale-items {
        border:0;
        background-color:gold;
    }
}
</style>

<section style="height: 85px; width: 100%; background: #fff;">
	<div class="container">&nbsp;</div>
</section>

<section id="flash-sale-items" style="padding-top: 20px; padding-bottom: 20px;">
<div class="section-header" style="margin-top: -20px;text-align:center;background:#29809c;">
			<img src="/public/images/s2bpluslogo.gif" class="img-responsive" />
		</div>
	<div class="container">
		
		<div class="contner" id="grad1" style="margin:0">
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

<div class="clear"></div>
<div class="clear"></div>
<!--container end-->