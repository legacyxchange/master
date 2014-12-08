<?php if (!defined('BASEPATH')) die('Direct access not allowed'); ?>

<input type='hidden' name='id' id='id' value='<?= $id ?>'>
<input type='hidden' name='name' id='name' value="<?= $info->firstName ?> <?= $info->lastName ?>">
<input type='hidden' name='token' id="token" value='<?=$this->security->get_csrf_hash()?>'>

<div class='row profile-user-row'>

    <div class='col-xs-12 col-sm-12 col-md-3 profile-user'>


        <div class='visible-xs visible-sm profile-xs-info'>

            <h1 class='userNameHeader'><?= $info->firstName ?> <?= $info->lastName ?></h1>
        </div> <!-- /.visible-xs visible-sm -->
        
        <img class='img-responsive img-rounded profile-img' src='/user/profileimg/300/<?= $info->id ?>/<?php echo $info->profileimg;?>'>

        <div class='followers'>
            <a href="#followersTab" data-toggle="tab"><?= $followersCnt ?> Followers</a>
        </div>

        <div class='following'>
        	<a href="#followingTab" data-toggle="tab"><?= $followingCnt ?> Following</a>
        </div>

        <div class="panel panel-default profile-panel">
	            <div class="panel-heading">
	                <h3 class="panel-title">About</h3>
	                <?php
	                /* if ($this->session->userdata('logged_in') == true && (int) $this->session->userdata('userid') == $id) : ?>
	                  <a href='/profile/index/1'><i class='fa fa-pencil pull-right'></i></a>
	                  <?php endif;
	                 */
	                ?>
	            </div>
	            <div class="panel-body">
	                <dl class="dl-horizontal user-info-dl">
	                    <?php if (!empty($info->dob)) : ?>
	                        <dt>Age</dt>
	                        <dd><?= date_diff(date_create($info->dob), date_create('today'))->y ?></dd>
	                    <?php endif; ?>
	
	                    <?php
	                    if (!empty($info->gender)) :
	
	                        try {
	                            $gender = $this->functions->codeDisplay(34, $info->gender);
	                        } catch (Exception $e) {
	                            $this->functions->sendStackTrace($e);
	                        }
	                        ?>
	                        <dt>Gender</dt>
	                        <dd><?= $gender ?></dd>
	<?php endif; ?>
	
	                    <?php
	                    if (!empty($info->weight)) :
	
	                        try {
	                            $weightType = $this->functions->codeDisplay(33, $info->weightType);
	                        } catch (Exception $e) {
	                            $this->functions->sendStackTrace($e);
	                        }
	                        ?>
	                        <dt>Weight</dt>
	                        <dd><?= $info->weight ?> <?= $weightType ?></dd>
	                    <?php endif; ?>
	
	
	                    <?php if (!empty($info->heightFeet)) : ?>
	                        <dt>Height</dt>
	                        <dd><?= $info->heightFeet ?> Feet <?= $info->heightInches ?> Inches</dd>
	                    <?php endif; ?>
	
	<?php
	if (!empty($userStyles)) {
	    foreach ($userStyles as $k => $r) {
	        try {
	            $display = $this->functions->codeDisplay(26, $r->code);
	        } catch (Exception $e) {
	            $this->functions->sendStackTrace($e);
	            continue;
	        }
	
	        $styleTxt = ($k == 0) ? 'Styles' : '&nbsp';
	
	        echo "<dt>{$styleTxt}</dt>" . PHP_EOL;
	
	        echo "<dd>{$display}</dd>" . PHP_EOL;
	    }
	}
	?>
	                </dl>
	            </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->

    </div> <!-- col-md-3 -->

    <div class='col-md-9 profile-info'>
        <div class='row hidden-sm hidden-xs'>
            <div class='col-md-6'>
                <h1 class='userNameHeader'><?= $info->firstName ?> <?= $info->lastName ?></h1>			
            </div> <!-- /.col-md-6 -->

            <div class='col-md-6'>
<?php if ($this->session->userdata('logged_in') == true) : ?>
    <?php
    $disabledBtn = ((int) $this->session->userdata('userid') == $id) ? "disabled='disabled'" : null;

    $followBtnClass = ($following) ? 'btn-success' : 'btn-default';
    $followBtnOnclick = ($following) ? "user.unfollow();" : "user.follow();";
    $followBtnTxt = ($following) ? "<i class='fa fa-check'></i> Following" : "<i class='fa fa-chevron-circle-right'></i> Follow";
    ?>
                    <button type='button' class='btn <?= $followBtnClass ?> pull-right' id='followBtn' onclick="<?= $followBtnOnclick ?>" <?= $disabledBtn ?>><?= $followBtnTxt ?></button>
                    <button type='button' class='btn btn-primary pull-right' id='msgBtn' style="margin-right:10px" <?= $disabledBtn ?>><i class='fa fa-envelope'></i></button>
                <?php endif; ?>
            </div>
        </div> <!-- /.row -->

        <div class='user-tab-container'>
                <?php
                $tabActive[$tab] = 'active';
                ?>

            <!-- Nav tabs -->
            <ul class="nav nav-pills">
                <li class="<?= $tabActive[0] ?>"><a href="#activityFeedTab" data-toggle="tab"><i class='fa fa-rss fa-rotate-270'></i> Activity Stream</a></li>
                <li class="<?= $tabActive[1] ?>"><a href="#aboutTab" data-toggle="tab"><i class='fa fa-info-circle'></i> Bio</a></li>
               <!--  <li class="<?= $tabActive[2] ?>"><a href="#blogTab" data-toggle="tab"><i class='fa fa-comment-o'></i> Blog</a></li> -->
                <li class="<?= $tabActive[3] ?>"><a href="#photosTab" data-toggle="tab"><i class='fa fa-picture-o'></i> Photos</a></li>
				<!-- <li class="<?= $tabActive[4] ?>"><a href="#scheduleTab" data-toggle="tab"><i class='fa fa-calendar'></i> Schedule</a></li> -->
				<li class="<?= $tabActive[5] ?>"><a href="#followingTab" data-toggle="tab"><?= $followingCnt ?></i> Following</a></li>
                <li class="<?= $tabActive[6] ?>"><a href="#followersTab" data-toggle="tab"><?= $followersCnt ?> Followers</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane  <?= $tabActive[0] ?>" id="activityFeedTab">

                    <div class="panel panel-default profile-blog-panel shadow">
                        <div class="panel-heading">

                            <ul class="nav nav-tabs feed-tabs">
                                <li class="active"><a href="#status" data-toggle="tab" onclick="user.prepareStatus();">Status</a></li>
                                <li><a href="#photos" data-toggle="tab" onclick="user.preparePhoto();">Photos</a></li>

                            </ul>

                        </div> <!-- /.panel-heading -->

                        <div class="panel-body postactions-container">
                            <div id='post-alert'></div>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="status">


<?php
$actDis = ($this->session->userdata('logged_in')) ? null : "disabled='disabled'";

$attr = array
    (
    'name' => 'wallPostForm',
    'id' => 'wallPostForm'
);

echo form_open('#', $attr);
?>

                                    <input type='hidden' name='parentPost' value='0'>
                                    <input type='hidden' name='user_id' value='<?= $user_id ?>'>
                                    <textarea class='form-control post' name='post' id='post' <?= $actDis ?>></textarea>

                                    </form>
                                    <div class='clearfix'></div>
                                </div> <!-- /#status -->
                                <div class="tab-pane" id="photos">

                                    <?php
                                    $attr = array
                                        (
                                        'name' => 'photoPostForm',
                                        'id' => 'photoPostForm'
                                    );

                                    echo form_open('#', $attr);
                                    ?>
                                    <input type='hidden' name='parentPost' value='0'>
                                    <input type='hidden' name='user_id' value='<?= $user_id ?>'>


                                    <div id='img-hidden-container'></div>

                                    <div id='uploadProgressContainer'></div>

                                    <div class='fileUploadContainer' id='fileUploadContainer'>
                                        <button type='button' class='btn btn-link' onclick="$('#photoFile').click();" <?= $actDis ?>>Upload Photo</button>

                                        <input type='file' name='photoFile' id='photoFile' class='hide' <?= $actDis ?>>
                                    </div>

                                    <div id='photo-post-container' style='display:none;'>
                                        <div class='row'>
                                            <div class='col-md-4 img-prev-col' id=''>
                                                <div id='imgPreviewContainer'></div>

                                            </div> <!-- /.col-md-4 -->

                                            <div class='col-md-8'>
                                                <textarea class='form-control' name='post' id='photoPost' placeholder="Caption..."></textarea>
                                            </div> <!-- /.col-md-8 -->
                                        </div> <!-- /.row -->
                                    </div> <!-- /#photo-post-container -->

                                    </form>

                                </div> <!-- /#photos -->  
                            </div> <!-- /.tab-content -->




                        </div> <!-- /.-panel-body -->

                        <div class='panel-footer'>
                            <button type='button' class='btn btn-default pull-right' id='postBtn' <?= $actDis ?>>Post</button>

                            <div class='clearfix'></div>
                        </div>
                    </div> <!-- /.panel -->

                    <div id='stream-display'></div>



                </div> <!-- /.activiyFeedtab -->
                <div class="tab-pane <?= $tabActive[1] ?>" id="aboutTab">
                    <div class='userTabContent shadow'>
                        <h2><i class='fa fa-info-circle'></i> Bio</h2>

                        <div class='bio-container'>
<?= $info->bio ?>
                        </div> <!-- /.bio-container -->

                    </div>
                </div> <!-- /#aboutTab -->
                <div class="tab-pane <?= $tabActive[2] ?>" id="blogTab">

                    <div id='blog-display'>

                    </div> <!-- #blog-display -->

                    <div id='blog-preview-display'>
                        <!-- <div class='userTabContent'>
                              <h2><i class='fa fa-comment-o'></i> Blog</h2>
                        </div> //--> <!-- /.userTabContent -->
<?php
if (empty($blogs)) {
    echo $this->alerts->info("No Blog Entries");
} else {
    foreach ($blogs as $r) {
        $excerpt = $featuredImg = $publishDisplay = null;
        $comments = 0;

        try {
            $excerpt = $this->blog->getBlogCol($r->id, 'excerpt');
            $featuredImg = $this->blog->getBlogCol($r->id, 'featuredImg');


            $publishDisplay = date("F n Y", strtotime($r->publishDate));

            $comments = $this->blog->getComments($r->id, true);
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
            continue;
        }
        echo <<< EOS
						<div class="panel panel-default profile-blog-panel shadow">
							<div class="panel-heading">
								<h3 class="panel-title">{$r->title}</h3>
							</div> <!-- /.panel-heading -->
							<div class="panel-body">
								<div class='blog-actions'>
									{$publishDisplay}
									
									<span class='pull-right'>
									<button type='button' class='btn btn-link share-btn'><i class='fa fa-share-alt'></i></button>
									{$comments} Comments
									</span>
								</div> <!-- /.blog-actions -->
								<div class='excerpt-container' onclick="user.viewblog({$r->id});">
									<div class='profile-blog-featuredImg' style="background:url('{$this->config->item('bmsUrl')}public/uploads/blog/{$featuredImg}');"></div>
									
									{$excerpt}
									<div class='clearfix'></div>
								</div> <!-- /.excerpt-container -->
							</div> <!-- /.-panel-body -->
						</div> <!-- /.panel -->
EOS;
    }
}
?>

                    </div> <!-- #blog-preview-display -->

                </div> <!-- #blogTab -->
                <div class="tab-pane <?= $tabActive[3] ?>" id="photosTab">
                    <div id='photos-display'></div>

                        <?php include_once 'albums.php'; ?>



                </div> <!-- #photosTab -->
                <div class="tab-pane <?= $tabActive[4] ?>" id="scheduleTab">
                        <?php
                        $body = array(); // resets body array
                        $body['id'] = $id;
                        $body['page'] = $page;
                        $body['month'] = $month;
                        $body['year'] = $year;

                        $this->load->view('user/schedule', $body);
                        ?>
                </div> <!-- #scheduleTab -->
                <div class="tab-pane <?= $tabActive[5] ?>" id="followingTab">
                <?php
                    $this->load->view('user/following', $followings);
                ?>
                </div> <!-- #followersTab -->
                <div class="tab-pane <?= $tabActive[6] ?>" id="followersTab">
                <?php
                    $this->load->view('user/followers', $followers);
                ?>
                </div> <!-- #followersTab -->
            </div>
        </div> <!-- /.user-tab-container -->

    </div> <!-- /.col-md-9 -->

</div>

<div class='hide' id='fileUploadProgressHtml'>
    <div class='fileProgressBar'>
        <div class='row'>
            <div class='col-md-3'><div class='fileNameTxt'></div></div>
            <div class='col-md-9'>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">0%</div> <!-- /.progress-bar -->
                </div> <!-- /.progress -->
            </div>
        </div> <!-- /.row -->
    </div> <!-- /.fileProgressBar -->
</div> <!-- /#fileUploadProgressHtml -->

                    <?php
                    echo "<div id='commentHtml'>" . PHP_EOL . $this->load->view('wall/comment', array('id' => 0), true) . PHP_EOL . "</div> <!-- /#commentHtml -->" . PHP_EOL . PHP_EOL;

                    $data = array
                        (
                        'id' => 0
                    );


                    echo "<div id='postHtml'>" . PHP_EOL . $this->load->view('wall/post', $data, true) . PHP_EOL . "</div> <!-- /#postHtml -->" . PHP_EOL . PHP_EOL;


                    echo "<div id='newCommentHtml'>" . PHP_EOL . $this->load->view('wall/new_comment', $data, true) . PHP_EOL . "</div> <!-- /#newCommentHtml -->" . PHP_EOL . PHP_EOL;


                    $body = array(); // resets body array
                    $body['info'] = $info;
                    $this->load->view('user/msg_modal', $body);

                    $body = array(); // resets body array

                    $body['id'] = $id;

                    $this->load->view('user/album_modal', $body);


                    $body = array(); // resets body array
                    $body['id'] = $id;

                    $this->load->view('user/photo_modal', $body);



                    $this->load->view('chat/widget', array());
                    ?>