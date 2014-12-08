<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wall extends CI_Controller {

    function Wall() {
        parent::__construct();

        $this->load->driver('cache');

        $this->load->model('wall_model', 'wall', true);
    }

    // main stream view
    public function view($userid) {
        $body['userid'] = $userid;

        try {
            $body['posts'] = $this->wall->getWallPosts($userid);
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $this->load->view('wall/view', $body);
    }

    public function refresh() {
        $this->load->view('wall/refresh', $body);
    }

    public function savepost() {
        $logged_in = $this->functions->checkLoggedIn(false);

        if (!$logged_in)
            PHPFunctions::jsonReturn('ERROR', "You are not logged in!");

        if ($_POST) {
            try {
                $postID = $this->wall->insertPost($_POST);

                // will check if any images have been uploaded, will go through an activate each img
                if (!empty($_POST['img'])) {
                    foreach ($_POST['img'] as $k => $img) {
                        $this->wall->setPhotoActive($_POST['userid'], $img, $postID);
                    }
                }


                PHPFunctions::jsonReturn('SUCCESS', $postID);
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                PHPFunctions::jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

    public function loadpreviousposts($userid, $minPostID) {
        $body['userid'] = $userid;
        $body['minPostID'] = $minPostID;

        try {
            // gets the last previous 10 posts from the minPostID
            $body['posts'] = $this->wall->getPosts($userid, 0, 10, 0, $minPostID);
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $this->load->view('wall/loadpreviousposts', $body);
    }

    public function deletepost($delLikes = true, $delParentPosts = true) {
        if ($_POST) {
            try {

                if ((bool) $delLikes)
                    $this->wall->deleteWallLikes($_POST['postID']);
                if ((bool) $delParentPosts)
                    $this->wall->deletePostsByParentPost($_POST['postID']);

                $this->wall->deletePostByID($_POST['postID']);


                PHPFunctions::jsonReturn('SUCCESS', 'Post has been deleted!');
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                PHPFunctions::jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

    public function like() {
        $logged_in = $this->functions->checkLoggedIn(false);

        if (!$logged_in)
            PHPFunctions::jsonReturn('ERROR', "You are not logged in!");

        if ($_POST) {
            try {
                $likeID = $this->wall->likePost($_POST['postID']);

                PHPFunctions::jsonReturn('SUCCESS', $likeID);
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                PHPFunctions::jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

    public function unlike() {
        $logged_in = $this->functions->checkLoggedIn(false);

        if (!$logged_in)
            PHPFunctions::jsonReturn('ERROR', "You are not logged in!");

        if ($_POST) {
            try {
                $this->wall->unlikePost($_POST['postID']);

                PHPFunctions::jsonReturn('SUCCESS', "Post Unliked");
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                PHPFunctions::jsonReturn('ERROR', $e->getMessage());
            }
        }
    }
    
    public function single_post()
    {
        
    }
}
