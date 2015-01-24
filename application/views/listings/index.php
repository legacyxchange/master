<section id="original-item" class="dark-bg ptb25 top-border" style="padding-bottom:0px;">
	<div class="container product-page-container">
		<!-- original items -->
		<div class="container">
			<?php require_once "listings_menu.php";?>
			<div class="section-content">
			<?php if($listings):?>
				<div class="row">
					<div class="col-lg-12 available-item">
						<strong>CURRENTLY:</strong><a href="#"> <?php echo count($listings);?> Original Items Available</a>
					</div>
				</div>
				<div class="row">                     
    				<?php foreach($listings as $listing): //var_dump($listing->listing_id);?>
                	<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
						<div class="item-img">
							<div>
								<img src="/products/productimg/200/<?php echo $listing->product_id;?>/<?php echo $listing->product->image;?>" />
							</div>
							<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
								<div class="hover-content" style="text-align: center;color:#000;font-weight:bold;">
									<?php echo $listing->product->name?>						
								</div>
								<!-- // NOT USING THE DESCRIPTION NOW
								<div class="product-description">
									<p><?php echo html_entity_decode($listing->product->description);?></p>
									<p>
										<b>Item Type:</b> <span>Registered <?php echo ucfirst($listing->product->product_type->type);?></span>
									</p>
									<p>
										<b>Date Signed:</b> <span>7/14/14</span>
									</p>
									<p>
										<b>QTY: </b><span> <?php echo $listing->product->quantity;?></span>
									</p>
									<p>
										<b>TYPE of SALE:</b><span>AUCTION W/ BUY NOW</span>
									</p>
									<p>
										<b>CURRENT BID: </b><span>$<?php echo number_format($listing->bidding[count($listing->bidding)-1]->bid_amount,2);?></span>
									</p>
									<p>
										<b># OF TIMES PREVIOUSLY SOLD: </b><span> 0</span>
									</p>
									<div class="seller-detail row">
										<p>
											<a href="/seller/<?php echo $listing->product->user->username;?>"><b>Seller:</b><span><?php echo $listing->product->user->firstName.' '.$listing->product->user->lastName;?></span></a>
											<span class="pull-right"><i><a href="/stores">Go to <?php echo $listing->product->user->firstName.' '.$listing->product->user->lastName;?> Store</a></i></span>
										</p>
									</div>
									</div>
								 -->
							</div>
						</div>
		        	</div>
    				<?php endforeach;?>						
				</div>
				<!-- end row -->
				<div class="container" style="text-align: center;color:#006a8a;">
					<a href="" style="text-align: center;color:#006a8a;">&laquo; next &raquo;</a>
				</div>
				<div class="container">
				    <div style="font-size:12px;text-align:center;color:#006a8a;">Original Items are items that have been Scientifially Marked and Registered with LegacyXChange.  LegacyXChange Documents the Marking, and the Marking and Documentation are100% verifiable.
All Original Items are 100% Guaranteed Authentic.</div>
				</div>
			</div>
			<?php endif;?>
		</div>
	</div>
</section>
<!-- valued items -->
<div class="row" style="margin-top:55px;">
	<div class="col-lg-12" style="background: url('/public/images/lightblue_gradient_bar.gif');background-repeat:no-repeat;">
		<h3 class="subtitle" style="color:#ff0000;font-weight:bold;text-decoration:italisize;">ALSO CHECK OUT THESE GREAT ITEMS!</h3>
	</div>
</div>
<section id="intrested-item" class="ptb25">
	<div class="container">
			
			<div class="container">        
                <?php foreach($listings2 as $listing):?>
                <div class="ads-container col-lg-3 col-md-6 col-sm-6 col-xs-12" style="border: 0;margin:0 auto;">
					<div class="product-image item-img" style="width:204px;height:204px;border:1px solid #ccc;">
						<img style="margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;" src="/products/productimg/180/<?=$listing->product_id;?>/<?=$listing->image;?>" />
						<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
							<div class="product-name"><?=$listing->name;?></div>
						</div>
					</div>
				</div>
        		<?php endforeach;?>        
        	</div>
		
	</div>
</section>