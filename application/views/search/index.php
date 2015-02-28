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
   				 .s2bheading{ font-size:38px; }
   				 .s2bsubheading{ font-size:28px; }
			}
</style>

<div style="margin:0 auto;background:#f4f4f4;height:49px;text-align:center;padding-top:5px;padding-bottom:5px;" class="">
	<a href="/listings/s2bxchange"><img style="margin:0 auto;width:240px;" class="img-responsive" src="/public/images/s2bxchange.gif" /></a>
</div>
<section style="height: 160px; width: 100%; background: #00698a;border-top:3px outset #f4f4f4;border-bottom:4px inset #333;">
	<div class="s2bheading">
	   <a style="font-size:38px;color:#fff;text-decoration:none;font-family:georgia" href="/listings/s2bxchange">Sellers 2 Buyers</a>
    </div>
    <div class="s2bsubheading" style="font-size:28px;">   
	   <i>Free Listings - No Commissions</i>
    </div>
</section>

<section style="background: #fff; height: auto; width: 100%; font-family: arial;">
	<div class="container cat-list">
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 Collectibles-list-center" style="padding-left: 5px; padding-right: 5%;">
			<?php echo $left_menu;?>
			
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

<img class="img-responsive game-slide slides" src='/public/images/game-slide.gif' />

<section class="dark-bg ptb25">
	<div class="container">
		<div class="section-header" style="margin-top: -20px;">
		    
			<div style="text-align: center; color: #000; font-family: georgia regular; font-size: 44px; font-weight: normal;">
			<img class="img" src="/public/images/logo.gif" style="height:35px;text-align:center;margin:0 auto;"><br />
				<a href="/listings/original">Original Items</a>
			</div>
			<div class="subtitle" style="margin-top: -10px; text-align: center; color: #000; font-family: georgia regular; font-size: 34px; font-weight: normal;">
			    Guaranteed - Scientifically Marked
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
        <a href="/listings/original" style="text-align: right;float:right;color:#00698a;font-size:12px;font-weight:bold;" class="see-more">&lt;See More&gt;</a>
	</div>
	<div style="font-size:14px;color:#6d6d6d;position:relative;z-index:1001;margin: 20px auto; margin-bottom:-27px; padding:10px; padding-top:10px;padding-bottom:10px;text-align:center;display:block;" class="container">
            <i>Original Items have been marked with tracer materials that can be scientifically verified.</i>
		</div>
</section>

<style>

</style>


<script>
    jQuery(document).ready(function ($) {
        //var options = { $AutoPlay: false };
        //var jssor_slider1 = new $JssorSlider$('slider1_container', options);
        //$('#slider1_container').find('div').css('top', '');
        //$('#slider1_container').find('div').css('left', '');
        //$('#slider1_container').find('div').css('margin-top', '0');
    });
</script>

<section id="flash-sale-items" style="padding-top: 20px; padding-bottom: 20px;margin-bottom:60px;">
	<div class="section-header" style="margin-top: 60px;text-align:center;">
		<a style="margin:0 auto;width:240px;" href="/listings/s2bplus"><img src="/public/images/s2bpluslogo.gif" class="sb2pluslogo" /></a>
	</div>
	<div class="s2bplussubheading" style="font-family:georgia;width:100%;height:60px;font-size:38px;color:#000;text-align:center;font-weight:bold;">
		<i>ON SALE NOW</i>
	</div>
	<div class="container">         
        <?php foreach($flash_listings as $listing):?>
            <div class="cont-4 product-container-border-4 col-lg-3 col-md-3 col-sm-6 col-xs-12" style="margin-bottom:60px;heigth:218px;">
				<div class="hover-img">
					<img class="centered-img" src="/products/productimg/210/<?=$listing->product_id;?>/<?=$listing->image;?>" />
					<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
						<div class="product-name"><?=$listing->name;?></div>
					</div>
				</div>
				<?php $save = $listing->retail_price - $listing->sale_price;?>
				<div style="height:100px;">
					<div style="font-weight: bold;">								
						WAS:&nbsp;&nbsp; <span style="">$<?php echo number_format($listing->retail_price,2); ?></span>
					</div>
					<div style="font-weight: bold; text-align:left;">
						NOW: <span style="color: #000;">$<?php echo number_format($listing->sale_price,2); ?></span>
					</div>
					<div class="save"> 
						<i style="color: #ff0000;letter-spacing:1px;">SAVE: $<?php echo number_format($save,2); ?></i>
					</div>
				</div>
			</div>
        <?php endforeach;?>        
	</div>
</section>

<div class="clear"></div>
<div class="clear"></div>