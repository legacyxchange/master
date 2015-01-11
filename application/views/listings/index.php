<section id="original-item" class="dark-bg ptb25 top-border ">
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
                	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 product-container">
						<div class="item-img">
							<div class="product-image">
								<img src="/products/productimg/200/<?php echo $listing->product_id;?>/<?php echo $listing->product->image;?>" />
							</div>
							<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
								<div class="hover-content">
									<b><?php echo $listing->product->name?><b>							
								</div>
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
							</div>
						</div>
		        	</div>
    				<?php endforeach;?>						
				</div>
				<!-- end row -->
				<div class="ptb25 pager">
					<a href="">&laquo; next &raquo;</a>
				</div>
			</div>
			<?php endif;?>
		</div>
	</div>
</section>
<!-- valued items -->
<section id="intrested-item" class="ptb25">
	<div class="container">
		<div class="section-content">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="subtitle">May also be of interest to you.</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 available-item">
					<strong>SECONDARY ITEMS:</strong><a href="#"></a>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3">
					<div class="item-img border-item">
						<img src="images/sec-items/pro-sec-item1.png">
					</div>
				</div>
				<div class="col-lg-3">
					<div class="item-img border-item">
						<img src="images/sec-items/pro-sec-item2.png">
					</div>
				</div>
				<div class="col-lg-3">
					<div class="item-img border-item">
						<img src="images/sec-items/pro-sec-item3.png">
					</div>
				</div>
				<div class="col-lg-3">
					<div class="item-img border-item">
						<img src="images/sec-items/pro-sec-item4.png">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>