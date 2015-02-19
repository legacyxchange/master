<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>

.s2bheading{
    font-family:geargia;font-size:48px;color:#fff;text-align:center;
}
.s2bsubheading{
    margin-top:20px;font-family:geargia;font-size:38px;color:#fff;text-align:center;
}
@media screen and (max-width: 990px) {
   				 .slides {
       				margin-top:30px;
       				min-height:166px;
   				 }
   				 .s2bheading{ font-size:40px; }
   				 .s2bsubheading{ font-size:24px; }
			}
</style>

<section class="dark-bg ptb25">
	<div class="container">
		<div class="section-header" style="margin-top: -20px;">
		    
			<div style="text-align: center; color: #000; font-family: georgia regular; font-size: 44px; font-weight: normal;">
			<img class="img-responsiv" src="/public/images/logo.gif" style="height:35px;text-align:center;margin:0 auto;"><br />
				<a href="/listings/original">Original Items</a>
			</div>
			<div class="subtitle" style="margin-top: -18px; text-align: center; color: #000; font-family: georgia regular; font-size: 34px; font-weight: normal;">
			    Documented Authenticity - Scientifically Marked &amp; Registered
			</div>
		</div>
		<div class="container">
        <?php if(!is_array($listings)):?>
		    <div class="row">
				<div class="col-lg-12">
					<h1 style="text-align: center;">Sorry...There are no listings matching that criteria.</h1>
				</div>
			</div>
        <?php else:?>      
        <?php foreach($listings as $listing): //var_dump($listing->name); exit;?>
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
        <div style="font-size:14px;color:#555;position:relative;z-index:1001;margin: 20px auto; margin-bottom:-27px; padding:10px; padding-top:10px;padding-bottom:10px; background:#fff;text-align:center;display:block;" class="container">
            <i>Original Items have been marked with tracer materials that can be scientifically verified.</i>
		</div>
	</div>
</section>

<img class="img-responsive game-slide slides" src='/public/images/game-slide.gif' />

<!--container start-->

<section style="height: 68px; width: 100%; background: #fff;">
	<div class="container">&nbsp;</div>
</section>
<div style="margin:0 auto;background:#f4f4f4;height:49px;text-align:center;padding-top:5px;padding-bottom:5px;" class="">
<a href="/listings/sb2xchange"><img style="margin:0 auto;" class="img-responsive" src="/public/images/s2blogo.gif" /></a></div>
<section style="height: 220px; width: 100%; background: #00698a;border-top:3px outset #f4f4f4;border-bottom:4px inset #333;">
	<div class="s2bheading" style="">
	   <a href="/listings/sb2xchange">Sellers 2 Buyers</a>
    </div>
    <div class="s2bsubheading" style="">
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
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 collectables-list-center" style="padding-left: 5px; padding-right: 5%;">
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
		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12" style="padding-left: 10px; padding-right: 5%;">
			<img class="img-responsive" src="/public/images/watches.gif" />
		</div>
		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12" style="padding-left: 10px; padding-right: 10px;">
			<img class="img-responsive" src="/public/images/sneakers.gif" />
		</div>
		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12" style="padding-left: 10px; padding-right: 10px;">
			<img class="img-responsive" src="/public/images/jewelery.gif" />
		</div>
		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12" style="padding-left: 10px; padding-right: 10px;">
			<img class="img-responsive" src="/public/images/electronics.gif" />
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
			<img src="/public/images/s2bpluslogo.gif" class="img-responsive sb2pluslogo" />
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
        	<div class="col-lg-12 flash-sale-items flash-cont">     
        		<div class="inner-container" style="width:930px;height:300px;">
        		<?php foreach($flash_listings as $listing): ?> 
        		<div style="width:230px;float:left;">
        			<div class="cont-4 product-container-border-flash col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<div class="hover-img" style="width:100%;height:218px;">
							<img class="centered-img" src="/products/productimg/210/<?=$listing->product_id;?>/<?=$listing->image;?>" />
							<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
								<div class="product-name"><?=$listing->name;?></div>
							</div>
						</div>
					</div>
					<?php $save = $listing->retail_price - $listing->sale_price;?>
					<div style="margin-top: -19px; padding: 16px; width: 100%; background: #fff;" class="item-sale-info">
						<div style="font-weight: bold;">
							<!-- background: url('/public/images/xout.gif'); background-repeat: no-repeat; background-position: center; -->
							WAS:&nbsp;&nbsp; <span style="">$<?php echo number_format($listing->retail_price,2); ?></span>
						</div>
						<div style="font-weight: bold; text-align:left;">
							NOW: <span style="color: #000;">$<?php echo number_format($listing->sale_price,2); ?></span>
						</div>
						<div class="save"> 
							SAVE: <span style="color: #ff0000;">$<?php echo number_format($save,2); ?></span>
						</div>
					</div>
				</div>
        		<?php endforeach;?>
        	<?php endif; ?>
        	</div>
        	</div>
		</div>
	</div>
</section>
<section style="background-color: #f4f4f4; height: auto; width: 100%; font-family: Georgia; margin-top: 100px; margin-bottom: 40px;">
	<img class="img-responsive slides" src="/public/images/sports_image_bg.gif" width="100%" />
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