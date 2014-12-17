<section id="original-item" class="dark-bg ptb25 top-border ">
	<div class="container product-page-container">
   
            <!--<pre><?php //var_dump($listings);?></pre>-->
			
			<!-- original items -->

	  <div class="container">
	
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
		</span>
	  </div>
	 </div>
	 </div>
	  
	   
	 <div class="section-content">
	 <div class="row">
	 <div class="col-lg-12 available-item">
	 <strong>CURRENTLY:</strong><a href="#"> 15 Original Items Available</a>
	 </div>
	 </div>
	 
	<div class="row">
        
<?php if($listings):?>
    <?php foreach($listings as $listing):?>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 product-container">
			<div class="item-img">
				<div class="product-image">
					<img src="/products/productimg/200/<?php echo $listing->product_id;?>/<?php echo $listing->product->image;?>" />
				</div>
		        <div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">                       
                    <div class="hover-content">
                        <b><?php echo $listing->product->name?><b>  
                    </div>
                    <div class="product-description"><p><?php echo html_entity_decode($listing->product->description);?></p>					 
						<p><b>Item Type:</b> <span>Registered <?php echo ucfirst($listing->product->product_type->type);?></span></p>
						<p><b>Date Signed:</b> <span>7/14/14</span></p>
						<p><b>QTY: </b><span> <?php echo $listing->product->quantity;?></span></p>
						<p><b>TYPE of SALE:</b><span>AUCTION W/ BUY NOW</span></p>
						<p><b>CURRENT BID: </b><span>$<?php echo number_format($listing->bidding[count($listing->bidding)-1]->bid_amount,2);?></span></p>
						<p><b># OF TIMES PREVIOUSLY SOLD: </b><span> 0</span></p>
						<div class="seller-detail row"><p><a href="/seller/<?php echo $listing->product->user->username;?>"><b>Seller:</b><span><?php echo $listing->product->user->firstName.' '.$listing->product->user->lastName;?></span></a>
							<span class="pull-right"><i><a href="/stores">Go to <?php echo $listing->product->user->firstName.' '.$listing->product->user->lastName;?> Store</a></i></span></p>		
                    	</div>								
					</div>		
				</div>
			</div>
		</div>
    <?php endforeach;?>		
<?php endif;?>

	</div><!-- end row -->
		
		<div class="ptb25 pager">
		<a href="">&laquo; next &raquo;</a>
		</div>
		</div>
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
		 <strong>SECONDARY ITEMS:</strong><a href="#"> FIRST TIME BEING SOLD</a> 
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
		 <strong>SECONDARY ITEMS:</strong><a href="#"> FIRST TIME BEING SOLD</a> 
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