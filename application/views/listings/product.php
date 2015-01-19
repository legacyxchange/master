<?php if($listing):?> 	
<section id="original-item" class="ptb25 top-border ">
	<div class="container product-page-container">
	<?php require_once "listings_menu.php";?>
		<!-- content section -->
		<div class="section-content">
			<div class="col-lg-6">
				<div class="border-item mg ">
					<div class="product-image product-big-img parent_div" style="height:422px;">
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
						<div class="row">
							<div class="time-left">
								<p>
									Time Left: <span class="timer" id="<?php echo $listing->listing_id;?>"></span>
								</p>
								<p>Auction Ends: <?php echo $listing->end_time;?></p>
							</div>
						</div>
						<div class="row">
							<div class="current-bid">
								<div class="product-prices">
									<p>
										Current Bid Price: <span>$<?php echo number_format($listing->bidding[count($listing->bidding)-1]->bid_amount,2);?></span>
									</p>
	                                <?php if(isset($listing->buynow_price)):?>
	                                <p>
										Buy Now Price: <span>$<?php echo number_format($listing->buynow_price,2);?></span>
										<span class="pull-right">
											<button class="btn btn-primary btn-sm" token_name="<?php echo $this->security->get_csrf_token_name();?>" token_value="<?php echo $this->security->get_csrf_hash();?>" id="listing-buynow-button" value="<?php echo $listing->listing_id;?>">
												Buy
											</button>
										</span>
									</p>
	                                <?php endif;?>
	                            </div>
							</div>
							<div class="new-bid row">
								<?php echo form_open('/listings/bid', array('method' => 'post', 'class' => 'form-horizontal'));?>
									<div class="form-group">
										<label for="newbid" class="control-label col-sm-6">Enter New Bid <span class="desc">(Must be $390 or more)</span></label>
										<div class="col-sm-6">
											<input type="text" name="bid" class="form-control" />
										</div>
									</div>
									<input type="hidden" name="listing_id" value="<?php echo $listing->listing_id;?>" />
									<div class="form-action">
										<span class="pull-right"><button class="btn btn-primary btn-sm" id="bidBtn">Bid</button></span>
									</div>
								</form>
							</div>
							<div class="track-bid">Track bidding on this item</div>
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
						<p>
							<b>Item Type:</b> <span>Registered <?php echo ucfirst($listing->product->product_type->type);?></span>
						</p>
						<p>
							<b>Date Signed:</b> <span><?php echo date('m-d-Y', strtotime($listing->end_time)).' '.ltrim(date('h:i a', strtotime($listing->end_time)), '0')?></span>
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
							<p>(Shipping / Payment information)</p>
						</div>
					</div>					
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
					<strong>OTHER ITEMS FOR:</strong><a href="#"> KOBE BRYANT</a>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3">
					<div class="item-img border-item">
						<img src="">
					</div>

				</div>
				<div class="col-lg-3">
					<div class="item-img border-item">
						<img src="">
					</div>

				</div>
				<div class="col-lg-3">
					<div class="item-img border-item">
						<img src="">
					</div>
				</div>
				<div class="col-lg-3">
					<div class="item-img border-item">
						<img src="">
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
					<strong>OTHER ITEMS FROM THIS SELLER: </strong><a href="#"> JOE JAMES </a> <span class="pull-right"><a href=""><i>Go to Joe James' Store</i></a></span>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3">
					<div class="item-img border-item">
						<img src="">
					</div>
				</div>
				<div class="col-lg-3">
					<div class="item-img border-item">
						<img src="">
					</div>
				</div>
				<div class="col-lg-3">
					<div class="item-img border-item">
						<img src="">
					</div>
				</div>
				<div class="col-lg-3">
					<div class="item-img border-item">
						<img src="">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>