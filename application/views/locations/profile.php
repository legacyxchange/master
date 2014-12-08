    <!--war_outer start-->
    	<div class="war_outer_2">
            <div class="container">
                <div class="banner_img_all"><img src="<img src='/dojos/img/{$location->id}/100'>" /></div>
                <div class="banner_text"><?php echo $location->name;?></div>
                <div class="banner_location">
                    <div class="icon"><i class="fa fa-map-marker fa-stack-1x"></i></div>
                    <?php echo $location->city;?>, <?php echo $location->state;?>
                </div>
                <div class="banner_review">
                	<img src="images/star-3.png" /><br /> 22 reviews
                </div>
                <div class="follow_btn"><a href="#">follow</a></div>
            </div>

        </div>
    <!--war_outer end-->
   		
    <!--middle_box start-->
        	<div class="middle_box">
            	<div class="container">
                	
                	<div class="col-md-8 box">
                        <div class="user_list">
                            <ul>
                                <li><a href="#">menu<span>58</span></a></li>
                                <li><a href="#">deals<span>12</span></a></li>
                                <li><a href="#">reviews<span>22</span></a></li>
                                <li><a href="#">uploads<span>42</span></a></li>
                                <li><a href="#">following<span>34</span></a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-md-4 box">
                        <div class="user_icon_list">
                            <ul>
                                <li><a href="#"><i class="fa fa-envelope fa-stack-2x icon_list"></i></a></li>
                                <li><a href="#" class="active"><i class="fa  fa-user fa-stack-2x icon_list"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
    <!--middle_box end-->
    
      <!--container start-->
        <div class="container">
              <div class="row">
            	<!--col-md-4 start-->
                    <div class="col-md-4">
                        <div class="war_bottom">
                     		<div class="user_addr">
                            	<span><?php echo $location->name;?></span><br /><?php echo $location->distance;?> mi away<br /><br /><?php echo $location->address;?><br /><?php echo $location->city;?>, <?php echo $location->state;?>, <?php echo $location->postalCode;?><br /><?php echo $location->phone;?>
                            </div>
                            <a href="#"><img src="images/map-2.png" /></a>
                         </div>
                    </div>
                <!--col-md-4 end-->
                
                 <!--col-md-8 start-->
                    <div class="col-md-8">
                        <div class="war">
                     		<h2>ABOUT US</h2>
                          <p><?php echo $location->description;?></p>
                          <h2>HOURS</h2>
                          <div class="hour_box">
                          		<div class="hour_day">Mon</div>
                                <div class="hour_time"><?php echo trim(date('h:i a', strtotime($hours->monday_opening_time)), 0);?> - <?php echo trim(date('h:i a', strtotime($hours->monday_closing_time)), 0);?></div>
                          </div>
                          <div class="hour_box">
                          		<div class="hour_day">Tue</div>
                                <div class="hour_time"><?php echo trim(date('h:i a', strtotime($hours->tuesday_opening_time)), 0);?> - <?php echo trim(date('h:i a', strtotime($hours->tuesday_closing_time)), 0);?></div>
                          </div>
                          <div class="hour_box">
                          		<div class="hour_day">Wed</div>
                                <div class="hour_time"><?php echo trim(date('h:i a', strtotime($hours->wednesday_opening_time)), 0);?> - <?php echo trim(date('h:i a', strtotime($hours->wednesday_closing_time)), 0);?></div>
                          </div>
                          <div class="hour_box">
                          		<div class="hour_day">Thu</div>
                                <div class="hour_time"><?php echo trim(date('h:i a', strtotime($hours->thursday_opening_time)), 0);?> - <?php echo trim(date('h:i a', strtotime($hours->thursday_closing_time)), 0);?></div>
                          </div>
                          <div class="hour_box">
                          		<div class="hour_day">Fri</div>
                                <div class="hour_time"><?php echo trim(date('h:i a', strtotime($hours->friday_opening_time)), 0);?> - <?php echo trim(date('h:i a', strtotime($hours->friday_closing_time)), 0);?></div>
                          </div>
                          <div class="hour_box">
                          		<div class="hour_day">Sat</div>
                                <div class="hour_time"><?php echo trim(date('h:i a', strtotime($hours->saturday_opening_time)), 0);?> - <?php echo trim(date('h:i a', strtotime($hours->saturday_closing_time)), 0);?></div>
                          </div>
                          <div class="hour_box">
                          		<div class="hour_day">Sun</div>
                                <div class="hour_time"><?php echo trim(date('h:i a', strtotime($hours->sunday_opening_time)), 0);?> - <?php echo trim(date('h:i a', strtotime($hours->sunday_closing_time)), 0);?></div>
                          </div>
                          
                          <p><br />
<br />
</p>
                          
                          <h2>LAST UPDATED</h2>
                          <div class="hour_box">
                                <div class="hour_time">6 days ago</div>
                          </div>
                            
                         </div>
                    </div>
                <!--col-md-8 end-->
            </div>
         </div>
     <!--container end-->
