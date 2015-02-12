<?php if($listing):?> 	
<section id="original-item" class="">
	<div class="container product-page-container">
	<?php //require_once "listings_menu.php";?>
		<!-- content section -->
		<div class="section-content">
			<div class="col-lg-6">
				<div class="border-item mg ">
					<div class="product-image product-big-img parent_div" style="height:380px;">
						<img class="parent_thumb" src="/products/productimg/300/<?php echo $listing->product_id;?>/<?php echo $listing->product->image;?>" />
					</div>
					<div class="product-thumbnail" style="overflow: scroll-x;padding:4px;width:100%;height:100px;">
						<img src="/products/productimg/100/<?php echo $listing->product_id;?>/<?php echo $listing->product->image;?>"class="child_thumb"> 
					<?php if(!empty($listing->product->product_images)):?>
					<?php foreach($listing->product->product_images as $i):?>					    					
						<img src="/products/productimg/100/<?php echo $listing->product_id;?>/<?php echo $i->image;?>"class="child_thumb">
					<?php endforeach;?>
					<?php else:?>
					    <img src="/products/productimg/100/<?php echo $listing->product_id;?>/<?php echo $i->image;?>"class="child_thumb">
					    <img src="/products/productimg/100/<?php echo $listing->product_id;?>/<?php echo $i->image;?>"class="child_thumb">
					<?php endif;?>
					</div>
					<div class="bid-desc">
						<div class="row" style="margin-bottom: 20px;">
						    <div class="type_of_sale" style="font-weight:bold;float:left;">
						        Type of Sale: <span style="color:#227593;">Auction w/Reserve</span>
						    </div>
							<div class="time-left">
								<p>
									Time Left: <span class="timer" id="<?php echo $listing->listing_id;?>"></span>
									<br />
								    Sale Ends: <?php echo date('M. d, Y \\a\\t g:i:a', strtotime($listing->end_time));?>
								</p>
							</div>
						</div>
						<div class="row">
							<div class="current-bid">
								<div class="product-prices">
									
										Current Bid Price: <span>$<?php echo number_format($listing->bidding[count($listing->bidding)-1]->bid_amount,2);?></span>
										<?php echo form_open('/listings/bid/'.$listing->listing_id, array('method' => 'post', 'class' => 'form-horizontal'));?>
										<input type="hidden" name="listing_id" value="<?php echo $listing->listing_id;?>" />
										<div class="form-group">
											<label for="newbid" class="control-label col-sm-5">Enter New Bid <span class="desc">(Must be $<?php echo number_format($listing->minimum_bid, 2); ?> or more)</span></label>
											<div class="col-sm-7">
												<input type="text" style="width:140px;float:left;margin-right:10px;" name="bid" class="form-control" />
												<button class="btn btn-primary btn-sm" id="bidBtn">Bid</button>
											</div>
										    
										</div>
										<?php echo form_close();?>
									
	                                <?php if(isset($listing->buynow_price)):?>
	                                <div style="text-align:center;margin-top:20px;">
										Buy Now Price: <span style="margin-right:10px;">$<?php echo number_format($listing->buynow_price,2);?></span>										
										<button class="btn btn-primary btn-sm" token_name="<?php echo $this->security->get_csrf_token_name();?>" token_value="<?php echo $this->security->get_csrf_hash();?>" id="listing-buynow-button" value="<?php echo $listing->listing_id;?>">Buy</button>										
									    <div id="buy_now_message">&nbsp;</div>
									</div>
	                                <?php endif;?>
	                            </div>
							</div>
							<div class="new-bid row">
								
							</div>
							<div class="track-bid"><a href="/listings/track_bidding/<?php echo $listing->listing_id;?>">Track bidding on this item</a></div>
						</div>
					</div>
				</div>
			</div>
			<div class="product-details col-lg-6">
				<div class="">
					<div class="product-heading">
						<h4>Item Name: <?php echo ucfirst($listing->product->name);?></h4>
					</div>
					<div class="product-description">
						<p><strong>Item Description:</strong> <?php echo html_entity_decode($listing->product->description);?></p>
						<p>
							<b>Item Type:</b> <span>Registered <?php echo ucfirst($listing->product->product_type->type);?></span>
						</p>
						
						<p>
							<b>Qty: </b><span> <?php echo $listing->product->quantity;?></span>
						</p>
						<p>
							<b>Type of Sale:</b><span>AUCTION W/ BUY NOW</span>
						</p>
						<p>
							<b>Current Bid: </b><span>$<?php echo number_format($listing->bidding[count($listing->bidding)-1]->bid_amount,2);?></span>
						</p>
						<p>
							<b>Number of Times Previously Sold on LXC: </b><span> 0</span>
						</p>
						<div class="seller-detail row">
							<p>
								<a href="/seller/<?php echo $listing->product->user->username;?>"><b>Seller:</b><span><?php echo $listing->product->user->firstName.' '.$listing->product->user->lastName;?></span></a>
								<span class="pull-right"><i><a href="/stores">Go to <?php echo $listing->product->user->firstName.' '.$listing->product->user->lastName;?> Store</a></i></span>
							</p>
							<hr />
						    <div class="shipping_estimate_container" style="text-align: center;">	
								<div>
									<strong>Payments Accepted Through:</strong><br />
									<img src="/public/images/credit_cards.gif" />
								</div>
							
								<strong>Shipping and Estimated Delivery:</strong><br />
								<div class="shipping_estimate" style="margin:0 auto;width:340px;height:140px;border:1px solid #ccc;">
							
								</div>							
							</div>
						</div>
					</div>					
				</div>
			</div>
		</div>	        
	<?php endif;?>
	</div>
</section>


<!-- Also Intrest  -->
<section id="intrested-item"> 
<div class="row" style="margin-top:55px;">
				<div class="col-lg-12" style="background: url('/public/images/lightblue_gradient_bar.gif');background-repeat:no-repeat;">
					<h3 class="subtitle" style="color:#ff0000;font-weight:bold;text-decoration:italisize;">ALSO CHECK OUT THESE GREAT ITEMS!</h3>
				</div>
			</div>
	<div class="container">	
			<section class="products-container-no-border">
	   <div class="container">    
        <?php foreach($listings_other as $listing):?>
            <div class="cont-6 product-container-border-6 col-lg-2 col-md-2 col-sm-4 col-xs-12">
				<div class="hover-img" style="width:153px;height:153px;">
					<img class="centered-img" src="/products/productimg/140/<?=$listing->product_id;?>/<?=$listing->image;?>" />
					<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
						<div class="product-name" style="font-size:12px;"><?=$listing->name;?></div>
					</div>
				</div>
			</div>
        <?php endforeach;?>
       </div> 
</section>
		</div>
	</div>
</section>