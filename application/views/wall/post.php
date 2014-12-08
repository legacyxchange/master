<?php

if (!defined('BASEPATH'))
    die('Direct access not allowed');

// timeago not declared, loads module just in case
//if (!class_exists('TimeAgo')) require_once './application/third_party/timeago/timeago.inc.php';


$likes = 0;

if (!empty($r)) {
    try {
        $usersName = $this->functions->getUserName($r->postingUser);
        $body = $this->wall->getPostBody($r->id);
        $likes = $this->wall->getLikeCnt($r->id);



        $date = timeAgoInWords($r->datestamp, 'UTC');

        $photos = $this->wall->getPostPhotos($r->id);

        if ($this->session->userdata('logged_in'))
            $liked = $this->wall->checkPostLiked($this->session->userdata('userid'), $r->id);
    } catch (Exception $e) {
        $this->functions->sendStackTrace($e);
    }
    $body = nl2br($body);

    $setDim = 'false';

    $hideDeleteBtn = ($r->postingUser == (int) $this->session->userdata('userid')) ? false : true;

    // if user is viewing their own contents profile, allows them to delete
    if ((int) $this->session->userdata('userid') == (int) $userid)
        $hideDeleteBtn = false;
}





if (empty($likes))
    $displayLikes = "display:none;";

if (!$liked)
    $likeBtn = "<button type='button' class='btn btn-link' onclick=\"wall.like(this, {$r->id});\"><i class='fa fa-thumbs-o-up'></i></button>";
else
    $likeBtn = "<button type='button' class='btn btn-link' onclick=\"wall.unlike(this, {$r->id});\"><i class='fa fa-thumbs-o-down'></i></button>";


// no like button if they are not logged in
if (!$this->session->userdata('logged_in'))
    $likeBtn = null;


$s = ($likes == 1) ? 's' : null;

$likeTxt = "<a href='javascript:void(0);'><i class='fa fa-thumbs-up'></i> <span>{$likes}</span> " . (($likes == 1) ? 'person' : 'people') . "</a> like{$s} this";


echo "<input type='hidden' name='postID[]' value='{$r->id}'>" . PHP_EOL;

echo <<< EOS
	<div class='userTabContent wallpost'>
		<div class='row'>
			<div class='col-md-12'>
				<img class='img-responsive post-img' src='{$this->config->item('bmsUrl')}user/profileimg/40/{$r->postingUser}'>
				
				<div class='wallpost-name'><a href='/user/index/{$r->postingUser}'>{$usersName}</a></div> <!-- /.wallpost-name -->
			
				<div class='wallpost-time text-muted'>{$date} ago</div>
			</div>
		</div> <!-- /.row -->
		
		<div class='post-body'>{$body}</div>

EOS;



if (!empty($photos)) {
    $class = (count($photos) == 1) ? 'post-photo-container-single' : 'post-photo-container';

    if (count($photos) == 1)
        $setDim = 'true';

    echo "<div class='{$class}'>" . PHP_EOL;

    foreach ($photos as $pr) {
        echo "<a href=\"javascript:user.viewPhoto({$pr->id}, {$userid}, '{$pr->fileName}', {$setDim});\" id='img-preview-link-{$pr->id}'><img id='img-preview-{$pr->id}' src='{$this->config->item('bmsUrl')}user/albumphoto/{$userid}/{$pr->fileName}/300' class='img-responsive'></a>" . PHP_EOL;
    }

    echo "</div> <!-- /.post-photo-container -->" . PHP_EOL;
}




echo <<< EOS
		
		<div class='wallpost-actions'>
			{$likeBtn}
			<button type='button' class='btn btn-link'><i class='fa fa-share-alt'></i></button>
			
			<div class='deleteBtn'>
EOS;

if (!$hideDeleteBtn)
    echo "<button type='button' class='btn btn-link txt-danger' style=\"opacity:0;\" onclick=\"wall.deletePost(this);\"><i class='fa fa-trash-o'></i></button>";

echo <<< EOS
			</div> <!-- /.deleteBtn -->
		</div>
		
		<div class='clearfix'></div>
	</div> <!-- ./userTabContent -->
	
	<div class='like-container' style="{$displayLikes}">
	{$likeTxt}
	</div> <!-- /.like-container -->
EOS;

