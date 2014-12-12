<div class="container product-page-container">
<?php if($listing):?>
    
            <div class="product-heading col-lg-12">
    	        <h2><?php echo $listing->product->name; ?></h2>
    	    </div>
        
            <div class="product-image col-lg-4">
    	    	<img src="/products/productimg/300/<?php echo $listing->product_id;?>/<?php echo $listing->product->image;?>" />
    	    </div>
    	    <div class="col-lg-2">
    	    </div>
    	    <div class="product-details col-lg-6">
    	        <div class="product-description"><?php echo html_entity_decode($listing->product->description);?></div>
    	        <div class="product-prices">
    	        Retail Price: $<?php echo number_format($listing->product->retail_price,2);?>
    	        <?php if(isset($listing->buynow_price)):?>
    	         | Buy Now Price: <button token_name="<?php echo $this->security->get_csrf_token_name();?>" token_value="<?php echo $this->security->get_csrf_hash();?>" id="listing-buynow-button" value="<?php echo $listing->listing_id;?>">$<?php echo number_format($listing->buynow_price,2);?></button>
    	        <?php endif;?>
    	        </div>
	        </div>
	        
<?php endif;?>
</div>


<!-- <pre>
<?php 
//var_dump($listing);
?>
</pre> -->