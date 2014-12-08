<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
  
<div class='container page-content'>
    
    <div class='col-md-8 blog-content-container' id='blogContentCol'>
        
        <div class='row'>
        	<div class='col-md-12 blogTitle'>
        		<h1>Hyper-local Deals!</h1>        		
        	</div> <!-- col-md-12 -->
               
        </div> <!-- .row -->
       
<?php foreach ($deals as $r): ?>

	    <div class='row blog-row' style="font-weight:bold;padding-left:20px;cursor:pointer;" onclick="location.href='/search/info/<?php echo $r->location_id; ?>';">
       
            <p style="background-color:silver;">
			    <h2><?php echo $name; ?></h2>
			    <?php //var_dump($r); exit;?>
			    <img src="/deals/dealimg/50/<?php echo $r->userid; ?>/<?php echo $r->deal_image;?>" align="left" />
			    
				<h3><?php echo $r->deal_name; ?></h3>

				<p><?php echo $r->deal_description ?></p>
			
				Retail Price: $<?php echo number_format($r->retail_price,2); ?> - Discount Price: $<?php echo number_format($r->discount_price,2); ?>

                <p>Distance: <?php echo $r->distance; ?></p>
            </p>  
       </div>
<?php endforeach; ?>

    </div>        

</div>