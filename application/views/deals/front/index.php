<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
    
        <script type="text/javascript" src="/public/js/jquery-ui-1.9.0.custom.min.js" ></script>
        
        <script type="text/javascript" src="/public/js/jquery-ui-tabs-rotate.js" ></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#featured").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 5000, true);
            });
        </script>
        

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    <style>
    #featured {border-color:#eee;}
    </style>
    <!--container start-->
        <div class="container">
            
            	<div class="war_bottom">
                	<h2>FEATURED DEALS</h2>                   
                    <div id="featured" >
                        <ul class="ui-tabs-nav" style="border-color:#eee;overflow:hidden;">
                            <?php if($featured_deals):?>
                            <?php foreach($featured_deals as $key=>$r):?>
                            <li class="ui-tabs-nav-item" id="nav-fragment-<?php echo $key;?>" style="width:100%;">
                                <a href="#fragment-<?php echo $key;?>" style="width:100%;">
                                <div class="title">Save $<?php echo $r->retail_price - $r->discount_price; ?> on <?php echo $r->deal_name;?></div>
                                <div class="subtitle"><span><?php echo $r->distance;?> mi away</span><br/><?php echo $r->time_remaining;?></div>
                                <span><?php echo $r->deal_description;?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                            <?php endif;?>                   
                        </ul>
                        <?php if($featured_deals):?>
                        <?php foreach($featured_deals as $key=>$r):?>                     
                        <div id="fragment-<?php echo $key;?>" class="ui-tabs-panel">
                            <img src="/deals/dealimg/300/<?php echo $r->userid;?>/<?php echo $r->deal_image;?>" />
                            <div class="slider_sick"><span>save</span>$<?php echo $r->retail_price - $r->discount_price; ?></div>
                        </div>
                        <?php endforeach; ?>
                        <?php else:?>
                            <li class="align-center list-unstyled">
                                <div class="alert alert-warning" style="text-align:center">Sorry this company has no featured deals.</div>
                            </li>
                        <?php endif;?>                                           
                    </div>                                        
                </div>               
         </div>
     <!--container end-->
   
      <!--container start-->
        <div class="container">
            	<div class="war_bottom">
                	<h2>NEWEST DEALS</h2>                   
                        <?php if($newest_deals):?>
                        <div class="slider-border-top">
                        <div class="left-nav-btn-uploads" id="top-left-nav"></div>
                        <div id="carousel6" class='outerWrapper'>
                        <?php foreach($newest_deals as $r):?>  
                        <div class="deals_item">
                            <div class="deals_inner">
                                <div class="deals_offer"><span>save</span><br />$<?php echo $r->retail_price - $r->discount_price; ?></div>
                                <div class="deals_img"><a href="#"><img src="/deals/dealimg/300/<?php echo $r->userid;?>/<?php echo $r->deal_image;?>" /></a></div>
                                <h4 class="deals_title"><a href="#"><?php echo $r->deal_name;?></a></h4>
                                <div class="deals_ends"><a href="#"><?php echo $r->distance; ?> mi away</a><br/><?php echo $r->time_remaining;?></div>
                                <p><?php echo $r->deal_description;?></p>
                            </div>
                        </div> 
                        <?php endforeach;?>
                        </div> 
                        <div class="right-nav-btn-uploads" id="top-right-nav"></div>                                               
                    </div> 
                        <?php else:?>
                            <li class="align-center list-unstyled">
                                <div class="alert alert-warning" style="text-align:center">Sorry this company currently has no new deals.</div>
                            </li>
                        <?php endif;?> 
                        
                </div>              
         </div>
     <!--container end-->
     
     <!--container start-->
        <div class="container">
            	<div class="war_bottom">
                	<h2>MOST POPULAR</h2>
                    <div id="carouse2" class='dealsWrapper'>
                        <?php if($popular_deals):?>
                        <div class="slider-border-top">
                        <div class="left-nav-btn-uploads" id="top-left-nav"></div>
                        <div id="carousel7" class='outerWrapper'>
                        <?php foreach($popular_deals as $r):?>  
                        <div class="deals_item">
                            <div class="deals_inner">
                                <div class="deals_offer"><span>save</span><br />$<?php echo $r->retail_price - $r->discount_price; ?></div>
                                <div class="deals_img"><a href="#"><img src="/deals/dealimg/300/<?php echo $r->userid;?>/<?php echo $r->deal_image;?>" /></a></div>
                                <h4 class="deals_title"><a href="#"><?php echo $r->deal_name;?></a></h4>
                                <div class="deals_ends"><a href="#"><?php echo $r->distance; ?> mi away</a><br/><?php echo $r->time_remaining;?></div>
                                <p><?php echo $r->deal_description;?></p>
                            </div>
                        </div> 
                        <?php endforeach;?> 
                        </div> 
                        <div class="right-nav-btn-uploads" id="top-right-nav"></div>                                               
                    </div> 
                        <?php else:?>
                            <li class="align-center list-unstyled">
                                <div class="alert alert-warning" style="text-align:center">Sorry no popular deals.</div>
                            </li>
                        <?php endif;?>  
                    </div>
                </div>               
         </div>
     <!--container end-->
     
     
     <!--container start-->
        <div class="container">
            	<div class="war_bottom">
                	<h2>ENDING SOON</h2>
                    <div id="carouse3" class='dealsWrapper'>
                        <?php if($expiring_deals):?>
                        <div class="slider-border-top">
                        <div class="left-nav-btn-uploads" id="top-left-nav"></div>
                        <div id="carousel8" class='outerWrapper'>
                        <?php foreach($expiring_deals as $r):?>  
                        <div class="deals_item">
                            <div class="deals_inner">
                                <div class="deals_offer"><span>save</span><br />$<?php echo $r->retail_price - $r->discount_price; ?></div>
                                <div class="deals_img"><a href="#"><img src="/deals/dealimg/300/<?php echo $r->userid;?>/<?php echo $r->deal_image;?>" /></a></div>
                                <h4 class="deals_title"><a href="#"><?php echo $r->deal_name;?></a></h4>
                                <div class="deals_ends"><a href="#"><?php echo $r->distance; ?> mi away</a><br/><?php echo $r->time_remaining;?></div>
                                <p><?php echo $r->deal_description;?></p>
                            </div>
                        </div> 
                        <?php endforeach;?> 
                        </div> 
                        <div class="right-nav-btn-uploads" id="top-right-nav"></div>                                               
                    </div> 
                        <?php else:?>
                            <li class="align-center list-unstyled">
                                <div class="alert alert-warning" style="text-align:center">No deals are about to expire.</div>
                            </li>
                        <?php endif;?>  
                    </div>
                </div>             
         </div>
     <!--container end-->
    