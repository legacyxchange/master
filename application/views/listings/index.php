<div class="section-header" style="margin-top: 0px;background:#f4f4f4;padding-top:5px;padding-bottom:10px;border-bottom:3px outset #aaa;">
    <?php if($product_type):?>   
	<div style="text-align: center; color: #000; font-family: georgia regular; font-size: 36px; font-weight: normal;">
		<?php echo $product_type_heading; ?>
	</div>	
	<?php endif;?>
</div>
<script>
function toggleVideo(obj){
	
	if($(obj).is(':hidden')){
		$(obj).show();
	}else if($(obj).is(':visible')){
		$(obj).hide();
	}
}
</script>

<section class="products-container-no-border">
	<div class="container"> 
	    <div class="container num_prod_heading" style="margin-top: 20px;margin-bottom: 20px;">
    		<span style="color:#000;font-weight:bold;"> CURRENTLY: &nbsp;</span><span style="color:#00698a;"><?php echo count($listings);?> <?php echo ucfirst($product_type);?> Items Available</span>
		</div> 
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		    <?php foreach($listings as $key=>$listing):?>		    
		    <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12" >
				<div class="team">
				    <a href="/listings/product/<?php echo $listing->product->product_id;?>">View</a>
					<a href="javascript:void(0);" class="img-team button-slide<?php echo ($key+1)?>">
						<img class="absolute-center" src="/products/productimg/196/<?=$listing->product_id;?>/<?=$listing->product->product_images[0]->product_image;?>" /> 
						<div class="details">
							<i class="fa fa-camera fa-2x"></i>
							<p style="color:#000;background:#ccc;padding:10px;"><?=$listing->name;?></p>
						</div>						
					</a>
					<div id="panel-detail<?php echo ($key+1);?>" class="dl-horizontal" style="background:#ccc;color:#000">
					<?php if($listing->product->product_videos[0]->product_video): ?>
					<video width="200" class="hidden" controls id="video_showing<?php echo ($key+1);?>">
  										<source src="/public/uploads/products/<?php echo $listing->product->product_videos[0]->product_id;?>/<?php echo $listing->product->product_videos[0]->product_video;?>" type="video/mp4">
  										<source src="/public/uploads/products/<?php echo $listing->product->product_videos[0]->product_id;?>/<?php echo $listing->product->product_videos[0]->product_video;?>" type="video/ogg">
  											Your browser does not support HTML5 video.
									</video>
					<?php endif;?>	
					</div>
					
					<div class="team-social">
						<ul>
							<li><a onclick="toggleVideo($('#video_showing<?php echo $key+1;?>'));$('#panel-detail<?php echo ($key+1);?>').html('');" class="video"><i style="font-size:42px;color:#000;" class="fa fa-youtube-play"></i></a></li>
							<li><a onclick="getprice('<?php echo $listing->listing_id;?>', 'panel-detail<?php echo ($key+1);?>', '<?php echo $this->security->get_csrf_hash(); ?>');" href="javascript:void(0);" class="price"><i style="font-size:40px;color:#000;" class="fa fa-money"></i></a></li>
							<li><a onclick="$('#panel-detail<?php echo ($key+1);?>').html('<?php echo $listing->description;?>')" href="javascript:void(0);" class="desc"><i style="font-size:34px;color:#000;" class="fa fa-image"></i></a></li>
						</ul>
					</div>
				</div>
			</div>			
        <?php endforeach;?>     	
    	</div>    
    </div>       
</section>
<div class="paginator-container container" style="height:100px;">
<?php if($paginator):?>

<?php endif;?>
</div>
<!-- valued items -->
<?php if($listings2):?>       
<div class="row" style="margin-top:55px;">
	<div class="col-lg-12" style="background: url('/public/images/lightblue_gradient_bar.gif');background-repeat:no-repeat;">
		<h3 class="subtitle" style="color:#ff0000;font-weight:bold;text-decoration:italisize;">ALSO CHECK OUT THESE GREAT ITEMS!</h3>
	</div>
</div>
<section class="products-container">
	<div class="container">	      
        <?php foreach($listings2 as $listing):?>
            <div class="cont-4 product-container-border-4 col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<div class="hover-img">
					<img class="centered-img" src="/products/productimg/210/<?=$listing->product_id;?>/<?=$listing->image;?>" />
					<div hover-info-id="<?php echo $listing->product_id;?>" class="hover-info">
						<div class="product-name"><?=$listing->name;?></div>
					</div>
				</div>
			</div>
        <?php endforeach;?>          
	</div>
</section>
<?php endif;?> 
<div style="margin:20px;height:200px;">&nbsp;</div>     