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
        <div u="navigator" class="jssorb21" style="position: absolute; bottom: 8px; left: 6px;">
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
		            <h2>New Original Items</h2>
		            <div class="subtitle">Never Before Sold - DNA Marked, Registered</div>
		        </div>
		       <div class="section-content">
        <?php if(!is_array($listings)):?>
		<div class="row">
        	<div class="col-lg-12"><h1 style="text-align:center;"><?php echo $listings; ?></h1></div>
		</div>
        <?php else: ?>
        
        <?php foreach($listings as $listing):?>
            <div class="product-container col-lg-3">
                <div class="product-image item-img"> 
                	<img style="margin: auto;position: absolute;top: 0; left: 0; bottom: 0; right: 0;" src="/products/productimg/200/<?=$listing->product_id;?>/<?=$listing->product->image;?>" />
                </div>
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
        <?php endforeach;?>
        <?php endif; ?>
        </div>
        </div>
        </section>
     <!--container end-->  