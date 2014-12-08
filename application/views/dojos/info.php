<script>
$(document).ready(function(){
	
	search.infoInit(<?php echo $lat;?>, <?php echo $lng;?>);
	$('#mapWell .well').css('width', '100%');
	search.renderLocationImgs;
});
</script>
<input type='hidden' name='eventLocation' id='eventLocation' value='<?= $id ?>'>
<input type='hidden' name='month' id='month' value='<?= $month ?>'>
<input type='hidden' name='year' id='year' value='<?= $year ?>'>

<div class='container page-content'>

    <div class='info-row'>
        <div class='col-md-8 info-header'>

            <?php
            $imgsrc = "/public/images/no_dojo_profilepic.png";

            if (!empty($defaultImg))
                $imgsrc = "/public/uploads/locationImages/{$id}/{$defaultImg}";
            ?>
            <input type='hidden' id='display-img-src' value="<?= $imgsrc ?>">

            <div id='displayImg' class='display-img'></div>
            <h1 class='profileName'><?= $info->name ?></h1>
        </div> <!-- /.col-8 -->

        <div class="col-md-4 hidden-xs hidden-sm">
            <h4 class='reviews' style='float:right;padding-right: 30px;'><?= count($reviews) ?> REVIEW<?= (count($reviews) == 1) ? null : 'S' ?></h4>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-8 col-bg  info-content">

        <?php
        $tabActive[$tab] = 'active';
        ?>

        <!-- Nav tabs -->
        <div class="col-lg-12" style="padding-top: 5px;z-index: 2;">           
            
        </div>
        <div class="tab-content">
            <div class="tab-pane <?= $tabActive[0] ?>" id="reviews">
                <h4 class='reviews'><?= count($reviews) ?> REVIEW<?= (count($reviews) == 1) ? null : 'S' ?></h4>
                <?php
                if (empty($reviews)) {
                    echo $this->alerts->info("There are currently no reviews.");
                } else {
                    foreach ($reviews as $r) {

                        // gets users avatar
                        // $avatar = get_avatar('comment_author_email');
                        // $rating = 0;

                        try {
                            $username = (empty($r->userid)) ? $r->name : $this->functions->getUserName($r->userid);
                        } catch (Exception $e) {
                            $this->functions->sendStackTrace($e);
                            continue;
                        }

                        $bodyRating['avg'] = $r->rating;
                        $bodyRating['largeStar'] = true;
                        $ratingHtml = $this->load->view('dojos/listavgrating', $bodyRating, true);




                        echo <<< EOS


                <div class='well comment-well'>
                
                    

                    <span class='comment-author'>{$username}</span><br>
                    <div class='comment-rating'>
                    {$ratingHtml}
                    </div>

                    {$r->comment}

                    <div class='clearfix'></div>

                </div> <!-- /.commment-well -->
EOS;
                    }
                }
                ?>

                <h4 class='reviews'>WRITE A REVIEW</h4>

                <div id='reviewAlert'></div>

                <!-- <form role='form' class='reviewForm'> -->

                <?php
                $attr = array
                    (
                    'id' => 'reviewForm'
                );

                echo form_open('#', $attr);

                $disabled = ($this->session->userdata('logged_in') == true) ? "disabled='disabled'" : null;
                ?>

                <input type='hidden' name='rating' id='rating' value='0'>

                <input type='hidden' name='location' id='location' value='<?= $id ?>'>

                <div class='row name-email-review'>
                    <div class='col-md-6'>
                        <div class="form-group">
                            <label for='reviewName'>NAME*:</label>
                            <input type='text' class='form-control' id='reviewName' name='reviewName' <?= $disabled ?> value="<?= ($this->session->userdata('logged_in') == true) ? "{$this->session->userdata('firstName')} {$this->session->userdata('lastName')}" : null ?>">
                        </div> <!-- .form-group -->
                    </div>

                    <div class='col-md-6'>

                        <div class="form-group">
                            <label for='reviewEmail'>E-MAIL*:</label>
                            <input type='text' class='form-control' id='reviewEmail' name='reviewEmail' <?= $disabled ?> value="<?= ($this->session->userdata('logged_in') == true) ? $this->session->userdata('email') : null ?>">
                        </div> <!-- .form-group -->

                    </div>
                </div> <!-- row -->

                <div class="form-group">
                    <label for='ratings'>RATING:</label>

                    <div id='reviewStars' class='reviewStars'>
                        <i class='fa fa-star' id='rating_star_1' value='1'></i>
                        <i class='fa fa-star' id='rating_star_2' value='2'></i>
                        <i class='fa fa-star' id='rating_star_3' value='3'></i>
                        <i class='fa fa-star' id='rating_star_4' value='4'></i>
                        <i class='fa fa-star' id='rating_star_5' value='5'></i>
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group">
                    <label  for='reviewDesc'>DESCRIPTION:</label>
                    <textarea class='form-control' name='reviewDesc' id='reviewDesc' rows='5'></textarea>
                </div> <!-- .form-group -->

                <div class='review-row'>

                    <a id='write_review'></a>
                    <img class="googlelogo" src="/public/images/powered-by-google-on-white.png">
                    

                </div>

                </form>
            </div> <!-- reviews-results -->

            <div class="tab-pane <?= $tabActive[1] ?>" id="photos">
                <h4 class='reviews'>Photos</h4>


<?php
if (empty($images)) {
    $this->alerts->info("No images have been uploaded.");
} else {
    foreach ($images as $r) {

        echo <<< EOS
			<a href="/public/uploads/locationImages/{$id}/{$r->fileName}" data-toggle="lightbox" data-gallery="multiimages" class="col-sm-4 dojoPhoto">
                <img src="/public/uploads/locationImages/{$id}/{$r->fileName}" class="img-responsive" height='235' width='235'>
            </a>
EOS;
    }
}
?>


                <div class='clearfix'></div>

            </div> <!-- #photos -->

            <div class="tab-pane <?= $tabActive[2] ?>" id="videos">
                <h4 class='reviews'>Videos</h4>

                <?php
                if (empty($videos)) {
                    echo $this->alerts->info("No videos are available.");
                } else {
                    echo "<div class='videoThumbnailContainer'>" . PHP_EOL;

                    foreach ($videos as $r) {
                        $videoMeta = $title = null;

                        try {
                            // get meta data for each video
                            //$videoMeta = $this->dojos->getLocMetaData($r->ID);
                            //$title = $this->dojos->getPostTitle($r->ID);
                        } catch (Exception $e) {
                            $this->functions->sendStackTrace($e);
                            continue;
                        }

                        echo "<div class='videoThumbnail' id='videoThumb_{$r->id}' onclick='dojos.previewVideo(\"{$r->title}\", \"{$r->videoID}\");'>" . PHP_EOL;

                        //echo "<div class='videoThumbnail' id='videoThumb_{$r->ID}' onclick='dojos.previewVideo(\"{$title}\", \"{$videoMeta->videoID}\");'>" . PHP_EOL;

                        echo "<img src='{$r->thumbnail}'>";

                        echo "</div>" . PHP_EOL;
                    }

                    echo "</div> <!-- videoThumbnailContainer -->" . PHP_EOL;
                }
                ?>
            </div> <!-- videos-results -->
            <div class="tab-pane <?= $tabActive[3] ?>" id="schedule">

                <h4 class='reviews'><i class='fa fa-calendar'></i> Class Schedule</h4>


                <nav class="navbar navbar-default cal-nav" role="navigation">
                    <div class="container-fluid">
                        <ul class="nav navbar-nav pull-left">
                            <li><a href='/dojos/info/<?= $id ?>/<?= date("n/Y", mktime(0, 0, 0, ($month - 1), 1, $year)) ?>/3' name='prevBtn' id='prevBtn'><i class='fa fa-chevron-left'></i></a></li>
                            <li><a href='javascript:void(0);' class='calMY'><?= date("F Y", mktime(0, 0, 0, $month, 1, $year)) ?></a></li>
                            <li><a href='/dojos/info/<?= $id ?>/<?= date("n/Y", mktime(0, 0, 0, ($month + 1), 1, $year)) ?>/3' name='nextBtn' id='nextBtn'><i class='fa fa-chevron-right'></i></a></li>
                        </ul>
                    </div><!-- /.container-fluid -->
                </nav>


                <?php
                $displayed = 0; // holds count of events that actually get displayed

                $first = date("w", mktime(0, 0, 0, $month, 1, $year));

// for the current month gets Unix time for first day of month
                $fdom = date("U", mktime(0, 0, 0, $month, 1, $year));

// gets the first day of the year
                $fdoy = date("U", mktime(0, 0, 0, 1, 1, $year));

                $startDate = mktime(0, 0, 0, $month, 1, $year);

                $endDate = mktime(0, 0, 0, ($month + 1), (1 - 1), $year);

                $end = date('n', $endDate);

                $diff = (int) date("z", $endDate) - (int) date("z", $startDate);

                if ($diff < 0)
                    $diff += 365;

//$extend = 7 - (int) date("N", $endDate);


                $weekEventCont = array();
                $repeat = array();
                $repeatID = array(); // array holds IDs of repeat events
                $repeatFinish = array();
                $initDisplayed = array(); // holds array of ID's that have been displayed

                $total = $diff + 1;

                for ($i = 1; $i <= $total; $i++) {
                    $utDay = $startDate + (($i - 1) * 86400);

                    // gets day of the week
                    $dayOfWeek = date("w", $utDay);
                    $day = date("d", $utDay);



                    //echo $day . "<BR>";



                    if (!empty($events)) {
                        echo "<div class='devent-container'>" . PHP_EOL;

                        foreach ($events as $r) {
                            $fdut = $tdui = $color = $eventInfo = $timezone = $displayTZ = $attendBtn = $hour = $min = $displayTZ = null;

                            $displayEventStart = $displayEventEnd = $eventTimeDisplay = null;

                            $tomorrow = $utDay + 86400;

                            $display = $attending = false;

                            $attendCnt = 0;

                            try {
                                // gets event info
                                $eventInfo = $this->events->getEventInfo($r->id);

                                // if not logged in gets timezone of user who created event
                                if ($this->session->userdata('logged_in') !== true) {
                                    $timezone = $this->functions->getTimezone($eventInfo->userid);

                                    $displayTZ = $this->functions->determineTimezoneAbb($timezone);
                                }
                            } catch (Exception $e) {
                                $this->functions->sendStackTrace($e);
                                continue;
                            }

                            $userid = ($this->session->userdata('logged_in') == true) ? $this->session->userdata('userid') : $eventInfo->userid;

                            if ($r->repeat == 1) {
                                // checks if event is in repeat array
                                if (!in_array($r->id, $repeatID)) {
                                    // not in repeat array - adds it to it
                                    $repeat[$r->id]['startsOn'] = $eventInfo->startsOn;
                                    $repeat[$r->id]['repeatType'] = $eventInfo->repeatType;
                                    $repeat[$r->id]['repeatEvery'] = $eventInfo->repeatEvery;
                                    $repeat[$r->id]['ends'] = $eventInfo->ends;
                                    $repeat[$r->id]['occurrences'] = $eventInfo->occurrences;
                                    $repeat[$r->id]['endsOnDate'] = $eventInfo->endsOnDate;

                                    $repeat[$r->id]['repeatSun'] = $eventInfo->repeatSun;
                                    $repeat[$r->id]['repeatMon'] = $eventInfo->repeatMon;
                                    $repeat[$r->id]['repeatTue'] = $eventInfo->repeatTue;
                                    $repeat[$r->id]['repeatWed'] = $eventInfo->repeatWed;
                                    $repeat[$r->id]['repeatThu'] = $eventInfo->repeatThu;
                                    $repeat[$r->id]['repeatFri'] = $eventInfo->repeatFri;
                                    $repeat[$r->id]['repeatSat'] = $eventInfo->repeatSat;
                                    $repeat[$r->id]['daysSinceDisplay'] = 0;
                                    $repeat[$r->id]['accOcc'] = 0; // number of actual occurances


                                    $repeatID[] = $r->id;
                                    //print_r($repeatID);
                                }
                            }

                            // gets UTC time of event
                            $hour = date("H", strtotime($r->fromDate));
                            $min = date("i", strtotime($r->fromDate));

                            $fdut = $this->functions->convertTimezone($userid, $r->fromDate, "U");
                            $tdut = $this->functions->convertTimezone($userid, $r->toDate, "U");

                            $diffStart = $fdut - $utDay;

                            $days = $this->events->eventDays($fdut, $tdut);

                            if ($utDay <= $fdut && $fdut <= $tomorrow && $r->allDay)
                                $display = true;
                            //echo "<BR>DISPLAY 1: {$display}<BR>";
                            if (in_array($r->id, $weekEventCont) && $dayOfWeek == 0)
                                $display = true;
                            //echo "<BR>DISPLAY 2: {$display} | DOW: {$dayOfWeek}<BR>";
                            if (in_array($r->id, $repeatID) && $diffStart <= 86400)
                                $display = true;

                            if ($display) {
                                if ($display === false)
                                    continue;

                                $attendEventTime = date("Y-m-d H:i:s", mktime($hour, $min, 0, $month, $day, $year));

                                try {
                                    if ($this->session->userdata('logged_in') == true) {
                                        // checks if user is attending event
                                        $attending = $this->events->checkedUserAttend($this->session->userdata('userid'), $r->id, $attendEventTime);
                                    }

                                    $attendCnt = $this->events->getNumAttending($r->id, $attendEventTime);
                                } catch (Exception $e) {
                                    $this->functions->sendStackTrace($e);
                                    continue;
                                }


                                if ($r->repeat == 1) {
                                    $repeatDisplay = $this->events->checkRepeatDisplay($utDay, $fdut, $r->id, $repeat[$r->id], $fdom, $fdoy);

                                    if (!$repeatDisplay)
                                        continue;
                                }

                                if (in_array($r->id, $weekEventCont))
                                    $days = $eventRemainingDays[$r->id];

                                if ($r->allDay == 1) {
                                    $displayEventStart = date("l, F j, Y", mktime(0, 0, 0, $month, $day, $year));
                                    $displayEventEnd = date("l, F j, Y", mktime(0, 0, 0, $month, ($day + $days), $year));

                                    $eventTimeDisplay = "{$displayEventStart}";
                                } else {

                                    $displayEventStart = date("l, F j, Y", mktime(0, 0, 0, $month, $day, $year));
                                    $displayEventEnd = date("l, F j, Y", mktime(0, 0, 0, $month, ($day + $days) - 1, $year));

                                    $eventTimeDisplay = "{$displayEventStart} " . $this->functions->convertTimezone($userid, $r->fromDate, "g:iA");

                                    if ($days > 1) {
                                        $eventTimeDisplay .= " &dash; {$displayEventEnd} " . $this->functions->convertTimezone($userid, $r->toDate, "g:iA");
                                    } else {
                                        $eventTimeDisplay .= " &dash; " . $this->functions->convertTimezone($userid, $r->toDate, "g:iA");
                                    }
                                }

                                if ($this->session->userdata('logged_in') == true) {
                                    if ($attending) {
                                        $attendBtn = "<button type='button' class='btn btn-danger btn-xs pull-right' onclick=\"dojos.unattendEvent(this, {$r->id}, '{$attendEventTime}', {$displayed})\"><i class='fa fa-minus'></i> Unattend Event</button>";
                                    } else {
                                        $attendBtn = "<button type='button' class='btn btn-default btn-xs pull-right' onclick=\"dojos.attendEvent(this, {$r->id}, '{$attendEventTime}', {$displayed})\"><i class='fa fa-plus'></i> Attend Event</button>";
                                    }
                                } else {
                                    $eventTimeDisplay .= " <span class='timezone text-muted'>({$displayTZ})</span>";
                                }


                                $urlTime = str_replace('&dash;', '-', $eventTimeDisplay);
                                $urlTime = str_replace("'", "\'", $urlTime);

                                echo <<< EOS
				<div class='row'>
					<div class='col-md-12'>
						<div class='event-content'>
							
							<input type='hidden' id='attendCnt_{$displayed}' value='{$attendCnt}'>
							
							<div id='eventAlert{$displayed}'></div>
						
						<div class='cal-icon-container'>
							<i class='fa fa-calendar-o'></i> <span class='cal-day-txt'>{$day}</span>
						</div> <!-- /.cal-icon-container -->
					
							<a href="javascript:dojos.loadEventModal($r->id, '{$urlTime}');">{$r->name}</a>
							<div class='event-time'><i class='fa fa-clock-o'></i> {$eventTimeDisplay}</div>
							<div class='event-desc'>{$eventInfo->description}</div>
							
							
							<div class='event-attend'><span class='label label-primary' id='attendCntDisplay_{$displayed}'>{$attendCnt} Attending</span>{$attendBtn}</div>
						
							<div class='clearfix'></div>
						</div> <!-- /.event-content -->
					</div> <!-- /.col-md-12 -->
				</div> <!-- .row -->
EOS;

                                if ($r->repeat == 1) {
                                    $repeat[$r->id]['lastDisplayedDateUT'] = $utDay;
                                    $repeat[$r->id]['accOcc'] ++;
                                }

                                if (!in_array($r->id, $initDisplayed))
                                    $initDisplayed[] = $r->id;

                                $displayed++;
                            }
                        }

                        echo "</div> <!-- /.devent-container -->" . PHP_EOL;
                    }
                }




                if (empty($displayed))
                    echo $this->alerts->info("There are no scheduled classes or events for " . date("F Y", mktime(0, 0, 0, $month, 1, $year)) . '.');
                ?>

            </div><!-- schedule-results -->
            <div class="tab-pane <?= $tabActive[4] ?>" id="about">
                <h4 class='reviews'><i class='fa fa-info-circle'></i> About</h4>
                <?php
                if (empty($info->description))
                    echo $this->alerts->info("Description not available");
                else
                    echo "<p>{$info->description}</p>";
                ?>


            </div> <!-- about-results -->

        </div> <!-- tab-content -->



        <!-- <h4 class='reviews'>RELATED LISTINGS</h4> -->


    </div> <!-- .col-8 -->



    <div class='col-xs-12 col-sm-12 col-md-4 info-map-col'>
        <div class='well'>

            <div class='row mapReview hidden-xs hidden-sm'>
                <div class='col-md-6'>

                <?php
                if ($assigned == false) {
                    echo "<button class='btn btn-link' id='claimBtn'>Claim Listing</button>" . PHP_EOL;
                }
                ?>

                </div> <!-- col-6 -->

                <div class='col-md-6'><!-- 
                    <a rel="/dojos/info/<?php //echo $info->id;?>" href='/dojos/info/<?php //echo $info->id;?>' class='btn btn-primary inverse pull-right' id='reviewBtn'>WRITE A REVIEW</a>
                 --></div> <!-- col-6 -->
            </div> <!-- .row -->

            <div id='previewMap'></div>

            <!-- saves all the markers to load onto the google map -->
            <div id='savedMarkers'>
                <input type='hidden' lat='<?= $info->lat ?>' lng='<?= $info->lng ?>'>
            </div>

            <form>
                <?php
                /*
                  <div class='input-group'>
                  <input type='text' class='form-control' placeholder='Enter your location'>

                  <span class='input-group-btn'>
                  <button type='button' class='btn btn-primary inverse'>Get Directions</button>
                  </span>
                  </div> <!-- .input-group -->
                 */
                ?>
            </form>

            <p class='profileAddress'>

                <strong>ADDRESS:</strong><br>
                <!--
                <span><?= $info->address ?> <?= $info->city ?>, <?= $info->state ?> <?= $info->postalCode ?></span>
                -->
<?php
if (empty($info->googleHTMLAddress)) {
    echo "{$info->address} {$info->city}, {$info->state} {$info->postalCode}" . PHP_EOL;
} else {
    echo $info->googleHTMLAddress;
}
?>
            </p>

                    <?php if (!empty($info->phone)) : ?>
                <p class='profileContactData'><i class='fa fa-phone'></i> <?= $info->phone ?></p>
<?php endif; ?>

<?php if (!empty($info->email)) : ?>
                <p class='profileContactData'><i class='fa fa-envelope'></i> <a href='mailto:<?= $info->email ?>'><?= $info->email ?></a></p>
<?php endif; ?>

<?php if (!empty($info->websiteUrl)) : ?>
                <p class='profileContactData'><i class='fa fa-globe'></i> <a href='<?= $info->websiteUrl ?>' target='_blank'><?= $info->websiteUrl ?></a></p>
<?php endif; ?>

<?php
if ($this->session->userdata('admin') == true && $assigned == false) {
    echo "<hr>";
    echo "<button type='button' class='btn btn-info' id='googleRefreshBtn'><i class='fa fa-refresh'></i></button>" . PHP_EOL;
}
?>

        </div> <!-- .well -->
    </div> <!-- .col-4 -->
</div> <!-- .row -->
</div> <!-- .container -->
</div>

<div class="modal fade"  id='claimModal'>
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Claim Listing - <?= $info->name ?></h4>
            </div> <!-- modal-header -->

            <div class="modal-body">
                <div id='claimAlert'></div>

                <?php
                $attr = array
                    (
                    'id' => 'claimForm',
                    'name' => 'claimForm',
                    'role' => 'form',
                    'class' => 'form-horizontal'
                );
                echo form_open('#', $attr);
                ?>

                <input type='hidden' name='id' id='id' value='<?= $id ?>'>
                <input type='hidden' name='title' id='title' value="<?= $info->name ?>">

                <div class="form-group">
                    <label class='col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label' for='name'>Full Name:</label>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 controls">
                        <input type='text' class='form-control' name='name' id='name' value="" placeholder='John Smith'>
                    </div> <!-- .controls -->
                </div> <!-- .form-group -->

                <div class="form-group">
                    <label class='col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label' for='phone'>Contact Number:</label>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 controls">
                        <input type='text' class='form-control' name='phone' id='phone' value="" placeholder='(888) 555-1212'>
                    </div> <!-- .controls -->
                </div> <!-- .form-group -->

                <div class="form-group">
                    <label class='col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label' for='position'>Position in Business:</label>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 controls">
                        <input type='text' class='form-control' name='position' id='position' value="" placeholder=''>
                    </div> <!-- .controls -->
                </div> <!-- .form-group -->

                <div class="form-group">
                    <label class='col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label' for='comments'>Comments:</label>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 controls">
                        <textarea class='form-control' name='comments' id='comments' rows='5'></textarea>
                    </div> <!-- .controls -->
                </div> <!-- .form-group -->


                </form>

            </div> <!-- modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id='submitClaim'>Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


                <?= $videoModal ?>

<div id='eventModal' class='modal fade'></div>
