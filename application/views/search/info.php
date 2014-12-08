    <!--war_outer start-->
    	<div class="war_outer_2">
            <div class="container">
                <?php
            	$imgsrc = "/public/images/gst_no_profile.jpg";

            	if (!empty($defaultImg))
                	$imgsrc = "/public/uploads/locationImages/{$id}/{$defaultImg}";
            	?>
            	<input type='hidden' id='display-img-src' value="<?= $imgsrc ?>">

            	<div class="banner_img_all"><img src="<?php echo $imgsrc;?>" /></div>
                <div class="banner_text"><?php echo $info->name;?></div>
                <div class="banner_location">
                    <div class="icon"><i class="fa fa-map-marker fa-stack-1x"></i></div>
                    <?php echo $info->city;?>, <?php echo $info->state;?>
                </div>
                <div class="banner_review">
                    <?php 
                    foreach ($reviews as $r) {
                	    $bodyRating['avg'] = $r->rating;
                        $bodyRating['largeStar'] = true;
                        $ratingHtml = $this->load->view('dojos/listavgrating', $bodyRating, true);
                    }
                    ?>
                    <?php echo $ratingHtml;?>
                    <br /> <?= count($reviews) ?> REVIEW<?= (count($reviews) == 1) ? null : 'S' ?>
                </div>
                <div class="follow_btn"><a class="followBtn" id="<?php echo $userid;?>" href="javascript:user.follow();">follow</a></div>
            </div>

        </div>
    <!--war_outer end-->
   		
    <!--middle_box start-->
        	<div class="middle_box">
            	<div class="container">
                	
                	<div class="col-md-8 box">
                        <div class="user_list">
                            <?php echo $menu_userlist; ?>
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
    
<div id="search_info_main_container">     
      <!--container start-->
        <div class="container">
              <div class="row" id="ajaxSwap">
            	<!--col-md-4 start-->
                    <div class="col-md-4">
                        <div class="war_bottom">
                     		<div class="user_addr">
                            	<span><?php echo $info->name;?></span><br /><?php echo $info->distance;?> mi away<br /><br /><?php echo $info->address;?><br /><?php echo $info->city;?>, <?php echo $info->state;?>, <?php echo $location->postalCode;?><br /><?php echo $location->phone;?>
                            </div>
				<div class='info-map-col'>
					<div class='well'>						
						<div id='previewMap'></div>

						<!-- saves all the markers to load onto the google map -->
						<div id='savedMarkers'>
							<input type='hidden' lat='<?= $info->lat ?>'
								lng='<?= $info->lng ?>'>
						</div>
					</div>
				</div>
				
				<!--col-md-4 end-->
                </div>
                </div>
                 <!--col-md-8 start-->
                    <div class="col-md-8">
                        <div class="war">
                     		<h2>ABOUT US</h2>
                          <p><?php echo $info->description;?></p>
                          <h2>HOURS</h2> 
                          <div class="hour_box">
                          		<div class="hour_day">Mon</div>
                                <div class="hour_time"><?php echo $hours->monday_opening_time;?> - <?php echo $hours->monday_closing_time;?><?php echo (date('l')=='Monday' && !is_null($open)) ? ' - '.$open : null; ?></div>
                          </div>
                          <div class="hour_box">
                          		<div class="hour_day">Tue</div>
                                <div class="hour_time"><?php echo $hours->tuesday_opening_time;?> - <?php echo $hours->tuesday_closing_time;?><?php echo (date('l')=='Tuesday' && !is_null($open)) ? ' - '.$open : null; ?></div>
                          </div>
                          <div class="hour_box">
                          		<div class="hour_day">Wed</div>
                                <div class="hour_time"><?php echo $hours->wednesday_opening_time;?> - <?php echo $hours->wednesday_closing_time;?><?php echo (date('l')=='Wednesday' && !is_null($open)) ? ' - '.$open : null; ?></div>
                          </div>
                          <div class="hour_box">
                          		<div class="hour_day">Thu</div>
                                <div class="hour_time"><?php echo $hours->thursday_opening_time;?> - <?php echo $hours->thursday_closing_time;?><?php echo (date('l')=='Thursday' && !is_null($open)) ? ' - '.$open : null; ?></div>
                          </div>
                          <div class="hour_box">
                          		<div class="hour_day">Fri</div>
                                <div class="hour_time"><?php echo $hours->friday_opening_time;?> - <?php echo $hours->friday_closing_time;?><?php echo (date('l')=='Friday' && !is_null($open)) ? ' - '.$open : null; ?></div>
                          </div>
                          <div class="hour_box">
                          		<div class="hour_day">Sat</div>
                                <div class="hour_time"><?php echo $hours->saturday_opening_time;?> - <?php echo $hours->saturday_closing_time;?><?php echo (date('l')=='Saturday' && !is_null($open)) ? ' - '.$open : null; ?></div>
                          </div>
                          <div class="hour_box">
                          		<div class="hour_day">Sun</div>
                                <div class="hour_time"><?php echo $hours->sunday_opening_time;?> - <?php echo $hours->sunday_closing_time;?><?php echo (date('l')=='Sunday' && !is_null($open)) ? ' - '.$open : null; ?></div>
                          </div>
                          
                          <p><br />
<br />
</p>
                          
                          <h2>LAST UPDATED</h2>
                          <div class="hour_box">
                          <?php 
                          $n = strtotime(date('Y-m-d h:i:s'));
                          
                          $l = strtotime($info->lastUpdated);
                          
                          $d = $n - $l;
                          
                          $lastUpdate = floor($d/60/60/24);
                         
                       
                          if($lastUpdate == 1){
                             $text = ' day ago'; 
                          }elseif($lastUpdate == 0){
                             $lastUpdate = null;
                             $text = ' today'; 
                          }else{
                            $text = 'days ago';
                          }
                          ?>
                                <div class="hour_time"><?php echo $lastUpdate;?> <?php echo $text;?></div>
                          </div>
                            
                         </div>
                    </div>
                <!--col-md-8 end-->
            </div>

         </div>
     <!--container end-->
     </div> <!-- end main_container -->
