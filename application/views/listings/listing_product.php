<section id="original-item" class="ptb25 top-border ">
	<div class="container product-page-container">
		<?php if($listing):?>
		<!-- page top menu -->
			<div class="page-menu">
				<div class="row">
					<div class="col-lg-6">
						<span class="page-item">
							<ul class="nav nav-tabs">
								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="#">Original Items<span class="caret"></span>
									</a>
									<ul class="dropdown-menu">
										<li><a href="#" id="origional_item">Original Items?</a>
											<div class="origional_item_container_main">	 
												<div class="origional_item_container" style="display:none;">
													<div class="origional_item_close"><i class="fa fa-times-circle"></i></div>
													<p>Origingal Items are items which have been DNA marked and Registered with LegacyXchange. Marking for original Items is done either at the point when the item is created (manufactured) or when it is signed or otherwise endorsed.</p>
													<p>LegacyXchange documents and follows strict chain-of-custody procedures for all Original items.the documentation, as well as the DNA mark, is 100% verifiable.</p>
													<p><b><i>All original items are Guaranteed 100% to be Authentic.</i></b></p>
												</div>
											</div>	  
										</li>
										<li class="divider"></li>
										<li><b>Show Me</b></li>
										<li class="divider"></li>
										<li><a href="#">All Original</a></li>
									    <li><a href="#">Sports Only</a>
											<ul class="submenu">
												<li><a href="#">Baseball</a></li>
												<li><a href="#">Football</a></li>
												<li><a href="#">Basketball</a></li>
												<li><a href="#">Hockey</a></li>
												<li><a href="#">Soccer</a></li>
												<li><a href="#">Golf</a></li>
												<li><a href="#">Auto Sports</a></li>
												<li><a href="#">Fighting Sports</a></li>
												<li><a href="#">Outdoor Sports</a></li>
												<li><a href="#">Other</a></li>
											</ul>
										</li>
										<li><a href="#">Jewelry</a>
											<ul class="submenu">
												<li><a href="#">Watches</a></li>
												<li><a href="#">Rings</a></li>
												<li><a href="#">Necklaces</a></li>
												<li><a href="#">Earrings</a></li>
											</ul>
										</li>
										<li><a href="#">Clothing</a>
											<ul class="submenu">
												<li><a href="#">Hats</a></li>
												<li><a href="#">Coats</a></li>
												<li><a href="#">Ties</a></li>
												<li><a href="#">Handbags</a></li>
												<li><a href="#">Other</a></li>
											</ul>
										</li>
									</ul>
								</li>
								<li><a href="#">SECONDARY ITEMS</a></li>
							</ul>
						</span>
				   	</div>
					<div class="col-lg-6 ">
						<div class="filter-item">
							<form>
								<span>
									<input type="text" class="form-control" placeholder="SELLER">
								</span>	
								<span class="sort-list">
									<ul class="nav nav-tabs">
										<li class="dropdown">
											<a class="dropdown-toggle" data-toggle="dropdown" href="#">Sort<span class="caret"></span>
											</a>
											<ul class="dropdown-menu">
												<li><a href="#">For Auction</a></li>
												<li><a href="#">For Sale</a></li>
												<li><a href="#">Newest Listings</a></li>
												<li><a href="#">Ending Soon</a></li>
												<li><a href="#">Bid Or Sale Price</a></li>
											</ul>
										</li>
									</ul>
								</span>			
							</form>
						</div>
					</div>
				</div>
			</div>
	<!-- End page top menu -->
	<!-- content section -->
			<div class="section-content">
				<div class="col-lg-6">
					<div class="border-item mg ">
						<div class="product-image product-big-img thumbnail_image">
							<img src="/products/productimg/300/<?php echo $listing->product_id;?>/<?php echo $listing->product->image;?>" />
						</div>
						<div class="product-thumbnail">
							<span><img src="/products/productimg/300/<?php echo $listing->product_id;?>/<?php echo $listing->product->image;?>" class="child_thumb"></span>
							<span><img src="/products/productimg/300/<?php echo $listing->product_id;?>/<?php echo $listing->product->image;?>" class="child_thumb"></span>
							<span><img src="/products/productimg/300/<?php echo $listing->product_id;?>/<?php echo $listing->product->image;?>" class="child_thumb"></span>
						</div>
						<div class="bid-desc">
							<div class="row">
								<div class="time-left">
									<p>Time Left: <span> 2D 4h 21s</span></p>
									<p>Auction Ends: 12/20/14  2:37p ES</p>
								</div>
							</div>
							<div class="row">
								<div class="current-bid">
									<div class="product-prices">
										<p>Current Bid Price:   <span>$<?php echo number_format($listing->product->retail_price,2);?></span></p>
										<?php if(isset($listing->buynow_price)):?>
											<p>Buy Now Price: <span>$<?php echo number_format($listing->buynow_price,2);?></span> <span class="pull-right"><button  class="btn btn-primary btn-sm" token_name="<?php echo $this->security->get_csrf_token_name();?>" token_value="<?php echo $this->security->get_csrf_hash();?>" id="listing-buynow-button" value="<?php echo $listing->listing_id;?>">Buy</button></span></p>
										<?php endif;?>
									</div>
								</div>
								<div class="new-bid row">
									<form class="form-horizontal">
										<div class="form-group">
											<label for="newbid" class="control-label col-sm-6">Enter New Bid<span class="desc">(Must be $390 or more)</span>
											</label>
											<div class="col-sm-6">
												<input type="text" class="form-control"/>
											</div>
										</div>
										<div class="form-action"><span class="pull-right"><button class="btn btn-primary btn-sm">Bid</button></span></div>
									</form>
								</div>
								<div class="track-bid">
									Track bidding on this item
								</div>
							</div>
						</div>
					</div>
				</div>
				 
				<div class="product-details col-lg-6">
					<div class="border-item mg pdr mh-400">
						<div class="product-heading">
							<h2><?php echo ucfirst($listing->product->name);?> - Listing #<?php echo $listing->listing_id;?></h2>
						</div>
						<div class="product-description">
							<p><?php echo html_entity_decode($listing->product->description);?></p>
							<p><b>Item Type:</b> <span>Registered <?php echo ucfirst($listing->product->product_type->type);?></span></p>
							<p><b>Date Signed:</b> <span>7/14/14</span></p>
							<p><b>QTY: </b><span> <?php echo $listing->product->quantity;?></span></p>
							<p><b>TYPE of SALE:</b><span>AUCTION W/ BUY NOW</span></p>
							<p><b>CURRENT BID: </b><span>$<?php echo number_format($listing->bidding[count($listing->bidding)-1]->bid_amount,2);?></span></p>
							<p><b># OF TIMES PREVIOUSLY SOLD: </b><span> 0</span></p>
							<div class="seller-detail row">
								<p><a href="/seller/<?php echo $listing->product->user->username;?>"><b>Seller:</b><span><?php echo $listing->product->user->firstName.' '.$listing->product->user->lastName;?></span></a>
								<span class="pull-right"><i><a href="/stores">Go to <?php echo $listing->product->user->firstName.' '.$listing->product->user->lastName;?> Store</a></i></span></p>
								<p>(Shipping / Payment information)</p>
							</div>
						</div>
						   <!-- <div class="product-prices">
							<p><b>Retail Price:<b><span> $<?php //echo number_format($listing->product->retail_price,2);?></span></p>
							<?php // if(isset($listing->buynow_price)):?>
							<p><b>Buy Now Price:<b><span> <button token_name="<?php //echo $this->security->get_csrf_token_name();?>" token_value="<?php // echo $this->security->get_csrf_hash();?>" id="listing-buynow-button" value="<?php // echo $listing->listing_id;?>">$<?php // echo number_format($listing->buynow_price,2);?></button></span></p>
							<?php // endif;?>
							</div>-->
					</div>
				</div>
			</div>
		<?php endif;?>
	</div>
</section>

<!-- Also Intrest  -->

<section id="intrested-item" class="dark-bg  ptb25">
	<div class="container">
	 	<div class="section-content">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="subtitle">May also be of interest to you.</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 available-item">
					<strong>OTHER ITEMS FOR:</strong><a href="#">  KOBE BRYANT</a> 
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
<section id="intrested-item" class="dark-bg">
	<div class="container">
		<div class="section-content">
			<div class="row">
				<div class="col-lg-12 available-item">
					<strong>OTHER ITEMS FROM THIS SELLER: </strong><a href="#">  JOE JAMES </a> 
					<span class="pull-right"><a href=""><i>Go to Joe James’ Store</i></a></span>
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
<!-- <pre>
<?php 
//var_dump($listing);
?>
</pre> -->