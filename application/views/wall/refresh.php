<?php

if (!defined('BASEPATH'))
    die('Direct access not allowed');

require_once './application/third_party/timeago/timeago.inc.php';

//print_r($_POST);
//sleep(15);
$updates = array();

if (!empty($_POST['postID'])) {
    foreach ($_POST['postID'] as $k => $postID) {
        $info = $commentInfo = null;
        try {
            $info = $this->wall->getPostInfo($postID);

            // if there is no info, post has been deleted
            if (empty($info)) {
                $updates[$postID]['deleted'] = true;
                continue;
            }

            $likes = $this->wall->getLikeCnt($postID);

            $date = timeAgoInWords($info->datestamp, 'UTC');
            // first gets updated times for posts
            $updates[$postID]['time'] = $date;
            $updates[$postID]['likes'] = $likes;

            if ($this->session->userdata('logged_in')) {
                $liked = $this->wall->checkPostLiked($this->session->userdata('userid'), $postID);
                $updates[$postID]['youLike'] = $liked;
            }

            // checks if there are comment ID's for this post
            if (!empty($_POST['commentID'][$postID])) {
                foreach ($_POST['commentID'][$postID] as $ck => $commentID) {
                    // gets updated time for any comments
                    $commentInfo = $this->wall->getPostInfo($commentID);


                    if (empty($commentInfo)) {
                        $updates[$postID]['comments'][$commentID]['deleted'] = true;
                        continue;
                    }

                    $date = timeAgoInWords($commentInfo->datestamp, 'UTC');

                    // first gets updated times for posts
                    $updates[$postID]['comments'][$commentID]['time'] = $date;
                }
            }


            // ------------ now will check for new comments
            $commentIDs = $_POST['commentID'][$postID];

            $lastCommentID = max($commentIDs);

            if (empty($lastCommentID))
                $lastCommentID = 0;

            //error_log("LAST COMMENT ID FOR {$postID}: {$lastCommentID}");

            $newComments = $this->wall->getWallPosts($_POST['userid'], $postID, 0, $lastCommentID, 0, 'ASC');

            if (!empty($newComments)) {
                foreach ($newComments as $r) {
                    $updates[$postID]['new_comments'][$r->id]['time'] = timeAgoInWords($r->datestamp, 'UTC');
                    $updates[$postID]['new_comments'][$r->id]['body'] = $this->wall->getPostBody($r->id);
                    $updates[$postID]['new_comments'][$r->id]['postingUser'] = $r->postingUser;
                    $updates[$postID]['new_comments'][$r->id]['name'] = $this->functions->getUserName($r->postingUser);
                }

                //$updates[$postID]['total_new_comments'] = count($newComments);
            }


            // ----- checks now for new posts ----- //
            $lastPostID = max($_POST['postID']);

            $newPosts = $this->wall->getWallPosts($_POST['userid'], 0, 0, $lastPostID);

            if (!empty($newPosts)) {
                foreach ($newPosts as $r) {
                    $updates['new_posts'][$r->id]['time'] = timeAgoInWords($r->datestamp, 'UTC');
                    $updates['new_posts'][$r->id]['body'] = $this->wall->getPostBody($r->id);
                    $updates['new_posts'][$r->id]['postingUser'] = $r->postingUser;
                    $updates['new_posts'][$r->id]['name'] = $this->functions->getUserName($r->postingUser);

                    // get likes cnt
                    $updates['new_posts'][$r->id]['likes'] = $this->wall->getLikeCnt($r->id);

                    if ($this->session->userdata('logged_in')) {
                        $liked = $this->wall->checkPostLiked($this->session->userdata('userid'), $r->id);
                        $updates['new_posts'][$r->id]['youLike'] = $liked;
                    }

                    // check for comments for this post
                    $comments = $this->wall->getPosts($_POST['userid'], $r->id, 0, 0, 0, 'ASC');

                    if (!empty($comments)) {
                        foreach ($comments as $cr) {
                            $updates['new_posts'][$r->id]['comments'][$cr->id]['time'] = timeAgoInWords($cr->datestamp, 'UTC');
                            $updates['new_posts'][$r->id]['comments'][$cr->id]['body'] = $this->wall->getPostBody($cr->id);
                            $updates['new_posts'][$r->id]['comments'][$cr->id]['postingUser'] = $cr->postingUser;
                            $updates['new_posts'][$r->id]['comments'][$cr->id]['name'] = $this->functions->getUserName($cr->postingUser);
                        }
                    }

                    $body['photos'] = $this->wall->getPostPhotos($r->id);
                    $body['userid'] = intval($_POST['userid']);
                    
                    $updates['new_posts'][$r->id]['photo_html'] = (!empty($body['photos'])) ? $this->load->view('wall/single_post', $body, true) : false;
                }
            }
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
            continue;
        }
    }
}

// now checks for new posts

$updates['status'] = 'SUCCESS';

echo json_encode($updates);
