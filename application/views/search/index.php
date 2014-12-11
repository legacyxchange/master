<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?> 
    <!-- jsissor Start --> 
    <div id="slider1_container" style="position: relative; margin: 0 auto;
        top: 0px; left: 0px; width: 1300px; height: 300px; overflow: hidden;">
        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block;
                top: 0px; left: 0px; width: 100%; height: 100%;">
            </div>
            <div style="position: absolute; display: block; background: url(/public/img/loading.gif) no-repeat center center;
                top: 0px; left: 0px; width: 100%; height: 100%;">
            </div>
        </div>
        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1300px; height: 300px; overflow: hidden;">
            <div>
                <img u="image" src="/public/images/banner1.png" />                
            </div>
            <div>
                <img u="image" src="/public/images/banner2.png" />               
            </div>
            <div>
                <img u="image" src="/public/images/banner3.png" />               
            </div>             
        </div>                
        <div u="navigator" class="jssorb21" style="position: absolute; bottom: 26px; left: 6px;">
            <!-- bullet navigator item prototype -->
            <div u="prototype" style="POSITION: absolute; WIDTH: 19px; HEIGHT: 19px; text-align:center; line-height:19px; color:White; font-size:12px;"></div>
        </div>        
        <span u="arrowleft" class="jssora21l" style="width: 55px; height: 55px; top: 123px; left: 8px;">
        </span>        
        <span u="arrowright" class="jssora21r" style="width: 55px; height: 55px; top: 123px; right: 8px">
        </span>              
    </div>
    <!-- Jssor Slider End -->    	   	  
    <!--container start-->
        <section id="original-item" class="dark-bg ptb25">
	        <div class="container">
	            <div class="section-header">
		            <h2 style="text-align: center;">New Original Items</h2>
		            <div class="subtitle">Never Before Sold - DNA Marked, Registered</div>
		        </div>
        <?php if(!is_array($listings)):?>
        	<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12"><h1 style="text-align:center;"><?php echo $listings; ?></h1></div>
        <?php else: ?>
        <?php foreach($listings as $listing):?>
            <div class="product-container col-md-4 col-xs-4 col-sm-6 col-lg-3" style="width:280px;min-height:380px;border: 1px solid #aaa;border-radius:10px;margin:2px;padding:5px;">
                <div class="product-image" style="text-align:center;"><img src="/products/productimg/160/<?=$listing->product_id;?>/<?=$listing->product->image;?>" /></div>
                <div class="large-img" product_name="<?php echo $listing->product->name;?>">Click for larger image.</div>
                <div class="timer" id="<?php echo $listing->listing_id;?>"></div>
                               
                <div class="row" style="width:240px;">
                	<div class="product-price" style="margin-left:20px;">Price: $<?=number_format($listing->product->retail_price, 2);?><a style="float:right;" href="/listings/product/<?php echo $listing->product_id;?>">Buy Now</a></div>                              	
                </div>
                <div class="product-name" style="font-size:16px;font-weight:bold;text-align:center;"><?=$listing->product->name;?></div>
                <div class="product-description" style="width:240px;"><?php echo html_entity_decode($listing->product->description);?></div>
            </div>
        <?php endforeach;?>
        <?php endif; ?>
        </div>
        </section>
     <!--container end-->  
     <!--container start-->
     <!-- 
        <div class="container">
        	<h1 class="big_title">Autograph Authenticators</h1>
            <h4 class="listed">Are you a Sports Memorabilia Autograph Authenticator? 
            <br />
            <a href="javascript:global.loadSignup();">Sign up to get listed!</a></h4>
        	<div class="war_landing">
                    <div class="col-md-8 box" id="mapWell">
                       <div id='previewMap' class="map" style="height:600px;"></div>
                    </div>
                    <?php ?>
                    <div class="col-md-4 box" style="overflow:auto;max-height:560px;">
                        <?php echo $initListings;?>
                    </div>
            </div>           
        </div>
         -->
      <!--container end-->
