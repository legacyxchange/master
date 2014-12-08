<!--container start-->
        <div class="container">
        <?php if($this->session->flashdata('SUCCESS')): ?>
        <div class='row'>
        <h3 class="alert alert-success"><?php echo $this->session->flashdata('SUCCESS'); ?></h3>
        </div>
        <?php elseif($this->session->flashdata('FAILURE')): ?>
        <div class='row'>
        <h3 class="alert alert-danger"><?php echo $this->session->flashdata('FAILURE'); ?></h3>
        </div>
        <?php elseif($this->session->flashdata('NOTICE')): ?>
        <div class='row'>
        <h3 class="alert alert-notice"><?php echo $this->session->flashdata('NOTICE'); ?></h3>
        </div>
        <?php endif; ?> 
        	<div class="war">
            	<h2>RECENT ACTIVITY</h2>
                
                <!--border_box start-->
                    <div class="border_box">
                        <div class="icon_box-1">
                           <span class="fa-stack fa-2x">
                               <i class="fa fa-circle fa-stack-2x text-primary"></i>
                               <i class="fa  fa-user fa-stack-1x fa-inverse"></i>
                            </span> 
                        </div>
                        <div class="recnt_box">
                            <div class="share">
                            <input name="" type="text" class="share_input" value="Share an update..." />
                            <input type="button" class="add" />
                            <input type="button" class="edit" />
                            </div>
                        </div>
                    </div>
                <!--border_box end-->
                
                <!--border_box start-->
                    <div class="border_box">
                        
                        <?php if($reviews):?>
                        <?php foreach($reviews as $r):?>
                        
                        <div class="recnt_box">
                            <h4 class="recnt-text"><?php echo $r->firstName;?> <?php echo $r->lastName;?> <span>reviewed</span> <?php echo $r->name;?></h4>
                            <div class="star"><img src="/user/profileimg/100/<?php echo $r->id;?>/<?php echo $r->profileimg;?>" /></div>
                            <p><?php echo $r->comment; ?></p>
                        </div>
                    </div>
                <!--border_box end-->
                
                <?php endforeach;?>               
                <?php else: ?>
                <h3 class="alert alert-warning">You have no Reviews.</h3>
                <?php endif; ?>
            </div>
        </div>
     <!--container end-->
     
      <!--container start-->
        <div class="container">
        	<div class="war">
                 <h2>DEALS <span class="view"><a href="#">view all</a></span></h2>
                 <div class="clear"></div>
                 <?php if($deals):?>
                 <?php foreach($deals as $r):?>
                  <div class="col-md-3 col-sm-6" style="cursor:pointer;" onclick="location.href='/search/info/<?php echo $r->location_id; ?>';">
                  		<div class="deals_inner">
                        	<div class="deals_offer"><span>save</span><br />$<?php echo number_format($r->retail_price - $r->discount_price, 0); ?></div>
                        	<div class="deals_img"><img src="/deals/dealimg/300/<?php echo $r->userid; ?>/<?php echo $r->deal_image; ?>" /></div>
                            <h4 class="deals_title"><a href="#"><?php echo $r->deal_name; ?></a></h4>
                            <div class="deals_ends"><a href="#"><?php echo $r->distance; ?> mi away</a> | ends in 5hrs</div>
                            <p><?php echo $r->description; ?></p>
                        </div>
                  </div>
                  <?php endforeach;?>
                  <?php else: ?>
                  <h3 class="alert alert-warning">You have no Deals.</h3>
                  <?php endif; ?>
            </div>
         </div>
         <!--container end-->
     
     
         <!--container start-->
         <div class="container">
        	<div class="war_bottom">
            	<h2>LOCATIONS</h2>
                <div class="row">
                    <div class="war_landing">
                    	<div class="col-md-8 box" id="mapWell">
                       		<div id='previewMap' class="map" style="height:600px;"></div>
                    	</div>
                    	<div class="col-md-4 box" style="overflow:auto;max-height:560px;">
                    	<div id="listContent">
                    	<?php foreach($places as $key=>$r): ?>                   
                        	<div class="map_addr" onclick="location.href='/search/info/<?php echo $r->id;?>';">       
       			        		<div class="addr_title"><?php echo $r->name;?><br /><span><?php echo $r->distance;?> mi. away</span></div>
       			        		<div class="addr_reviews"><?php echo $ratingHtml[$key];?></a><br /><?php echo $num_reviews[$key];?> reviews</div>
       			        		<div class="clear"></div>
       			        		<div class="addr"><?php echo $r->phone;?><p><?php echo $r->address;?><br/><?php echo $r->city;?>, <?php echo $r->state;?> <?php echo $r->postalCode;?></p></div>
       			        		<input type='hidden' name='listingID' value='<?php echo $r->id;?>' />
       			        		<input type="hidden" id="numReviews-<?php echo $r->id;?>" value="<?php echo $num_reviews[$key];?>" />       			            			           	                     
	       						<?php 
        						$markerName = "<h5><a href='/search/info/{$r->id}?lat={$r->lat}&lng={$r->lng}&q=Marijuana&location=" . urldecode($r->city.', '.$r->state)."'>{$r->name}</a></h5>";
        						?>                   
                    			<input type='hidden' class='gmMarker' lat='<?php echo $r->lat; ?>' lng='<?php echo $r->lng; ?>' title="<?php echo $r->name; ?>" contentString="<?php echo $markerName;?><?php echo $websiteDisplay;?><?php echo $r->phone;?><p><?php echo $r->address;?><br/><?php echo $r->city;?>, <?php echo $r->state;?></p>" loaded='0' />                   
                    		</div>     
                    	<?php endforeach;?> 
                    	</div>                   	
                		</div>
                	</div>
            	</div>
        	</div>
    	</div>
      <!--container end-->