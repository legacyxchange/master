
    <!--war_outer start-->
    	<div class="war_outer_3">
            <div class="container">
                <div class="banner_img_all"><img src="/dojos/img/<?php echo $info->id;?>/300" /> </div>
                <div class="banner_text"><?php echo $info->name;?></div>
                <div class="banner_location">
                    <div class="icon"><i class="fa fa-map-marker fa-stack-1x"></i></div>
                    <?php echo $info->city;?> <?php echo $info->state;?>
                </div>
                
                <div class="follow_btn" style="display:none;"><a href="javascript:user.follow();">follow</a></div>
            </div>

        </div>
    <!--war_outer end-->
   		
    <!--middle_box start-->
        	<div class="middle_box">
            	<div class="container">
                	
                	<div class="col-md-8 box">
                        <?php echo $menu_userlist;?>
                    </div>
                    
                    <div class="col-md-4 box">
                        <div class="user_icon_list">
                            <ul>
                                <li><a href="#"><i class="fa fa-envelope fa-stack-2x icon_list"></i></a></li>
                                <li><a href="#"><i class="fa  fa-user fa-stack-2x icon_list"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
    <!--middle_box end-->
    
      <!--container start-->
        <div class="container">
            	<div class="war_bottom">
                	<h2>FOLLOWERS</h2>
                    <div class="follower-border-top">
                    
                    <?php if($follewers): ?>
                    
                    	<div class="follower_list">
                        	
                        	<ul>
                        	    <?php foreach($followers as $r): var_dump($r); exit;?>
                            	<li>
                                	<div class="icon"><img src="/profileimg/50/<?php userid;?>" /></div>
                                	<span class="fa-stack fa-3x">
                                           <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                           <i class="fa  fa-user fa-stack-1x follow"></i>
                                    </span>
                                   <span> <?php echo $r->firstName;?> <?php echo $r->lastName;?></span>
                                </li>
                                <?php endforeach;?>                              
                            </ul>
                        </div>
                    <?php endif;?>
                    </div>
               
                </div>
         </div>
     <!--container end-->
