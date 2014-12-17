<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'third_party' . DS . 'bms' . DS . 'index.php';

class User extends CI_Controller {

    //if (trait_exists('Chat')) use Chat;
    //use chat;

    function User() {
    	
        parent::__construct();

        $this->load->driver('cache');

        $this->load->model('user_model', 'user', true);
       
        //$this->load->model('profile_model', 'profile', true);
        $this->load->model('users_model', 'user', true);
        $this->load->model('products_model', 'product', true);
        $this->load->model('listings_model', 'listing', true);
        //$this->load->model('association_model', 'association', true);
        //$this->load->model('wall_model', 'wall', true);
        //$this->load->library('library');
    }

    // could accept user_id or username
    public function index($uid = 0) {
    	if(is_string($uid)) { 
            $user = $this->user->fetchAll(array('where' => 'username = "'.$uid.'"'))[0];
            $user_id = $user->user_id;
            
        }else if(is_numeric($uid)){ 
        	$user = $this->user->fetchAll(array('where' => 'user_id = '.$uid))[0];
        	$user_id = $uid;
        }
        
        $user->products = $this->product->fetchAll(array('where' => 'user_id = '.$user_id));
        foreach($user->products as $product){
        	$product->listing = $this->listing->fetchAll(array('where' => 'product_id = '.$product->product_id))[0]; 	 		
        }
        
        $body['user'] = $user;
        //$body['title'] = 'User '.$user_id;
        $this->load->view('template/header');
        $this->load->view('user/index', $body);
        $this->load->view('template/footer');
    } 

    /*
    public function index($user_id = 0) {
    	require_once 'application/models/association_model.php';
        $association = new association_model('users', 'user_id ='. $user_id);
        $association->associate('products', 'user_id  = '.$user_id);
        $association->associate('product_types', 'product_type_id', 'products');
        $association->associate('listings', 'product_id', 'products');
        $association->show();
        //$association->associate('listings', 'product_id = '.$p_id);
        exit;
    	
    	$body['user'] = $user;
    	$body['title'] = 'User '.$user_id;
    	$this->load->view('template/header');
    	$this->load->view('user/index', $body);
    	$this->load->view('template/footer');
    }
    */
    public function followers($id){
    	$header['headscript'] = $this->functions->jsScript('user.js');
        $body['info'] = $this->functions->getUserInfo($id);
        
        $body['followers'] = $this->user->getFollowers($user_id);
        $body['followings'] = $this->user->getFollowing($user_id);
        $body['followersCnt'] = $this->user->getFollowersCnt($user_id);
        $body['followingCnt'] = $this->user->getFollowingCnt($user_id);
        $body['menu_userlist'] = $this->load->view('partials/menu_userlist', $body, true);
        $this->load->view('template/header', $header);
        $this->load->view('user/followers', $body);
        $this->load->view('template/footer');
    }
    
    public function blog_feature_img($blog) {
        try {
            $logo = $this->companies->getTableValue('logo', $company);
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $path = $this->config->item('bmsUrl') . '/public/uploads/blog/';

        $config['image_library'] = 'gd2';
        $config['source_image'] = './' . $path . $logo;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 100;
        $config['height'] = 50;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();
    }

    public function profileimg($size = 50, $user_id = 0, $file = null) { 
    	
    	if (empty($user_id))
            $user_id = $this->session->userdata('user_id');

        $path = $_SERVER["DOCUMENT_ROOT"] . 'public' . DS . 'uploads' . DS . 'avatars' . DS . $user_id . DS;

        if (!empty($file))
            $file = urlencode($file);

        try {

            if (!empty($user_id)){
                $user = $this->user->fetchAll(array('where' => 'user_id = '.$user_id));               
            }

            if (!empty($file))
                $img = $file;

            if (!file_exists($path . $img))
                $img = null;

            if (empty($img)) {
                $path = $_SERVER["DOCUMENT_ROOT"] . DS . 'public' . DS . 'images' . DS;
                $img = 'dude.gif';
            }

            $is = getimagesize($path . $img);

            if ($is === false)
                throw new exception("Unable to get image size for ({$path}{$img})!");

            $ext = PHPFunctions::getFileExt($img); 

            list ($width, $height, $type, $attr) = $is;

            if ($width == $height) {
                $nw = $nh = $size;
            } elseif ($width > $height) {
                $scale = $size / $height;
                $nw = $width * $scale;
                $nh = $size;
                $leftBuffer = (($nw - $size) / 2);
            } else {
                $nw = $size;
                $scale = $size / $width;
                $nh = $height * $scale;
                $topBuffer = (($nh - $size) / 2);
            }

            $leftBuffer = $leftBuffer * -1;
            $topBuffer = $topBuffer * -0;

            if ($ext == "JPG")
                $srcImg = imagecreatefromjpeg($path . $img);
            if ($ext == "GIF")
                $srcImg = imagecreatefromgif($path . $img);
            if ($ext == "PNG")
                $srcImg = imagecreatefrompng($path . $img);

            $destImg = imagecreatetruecolor($nw, $nh); // new image
            imagecopyresized($destImg, $srcImg, $leftBuffer, $topBuffer, 0, 0, $nw, $nh, $width, $height);
        } catch (Exception $e) {
            PHPFunctions::sendStackTrace($e);
        }
        header('Content-Type: image/jpg');
        imagejpeg($destImg);

        imagedestroy($destImg);
        imagedestroy($srcImg);
    }

    public function viewblog($blog) {
        try {
            $body['info'] = $this->blog->getBlogInfo($blog);
            $body['comments'] = $this->blog->getComments($blog);
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $this->load->view('user/viewblog', $body);
    }

    public function follow() {
        if ($_POST) {  
            try { $this->functions->jsonReturn('SUCCESS', $followID);
                $followID = $this->user->followUser($this->session->userdata('userid'), $_POST['userid']);
                $this->functions->jsonReturn('SUCCESS', $followID);
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

    public function unfollow() {
        if ($_POST) {
            try {
                $this->user->unfollowUser($this->session->userdata('userid'), $_POST['userid']);
                $this->functions->jsonReturn('SUCCESS', "You are no longer following this user!");
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

    public function createalbum() {
        $logged_in = $this->functions->checkLoggedIn(false);

        if (!$logged_in)
            $this->functions->jsonReturn('ERROR', "You are not logged in!");

        if ($_POST) {
            try {
                $albumID = $this->user->createPhotoAlbum($this->session->userdata('userid'), $_POST['albumName']);
                $this->functions->jsonReturn('SUCCESS', $albumID);
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

    public function viewalbum($album, $userid) {
        $body['album'] = $album;
        $body['userid'] = $userid;
        try {
            $body['photos'] = $this->user->getAlbumPhotos($album);

            $body['info'] = $this->user->getAlbums($userid, $album);
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $this->load->view('user/viewalbum', $body);
    }

    public function photoinfo($photoID) {
        $body['photoID'] = $photoID;

        try {
            $body['info'] = $info = $this->wall->getPhotoInfo($photoID);

            // gets name of user who uploaded the photo
            $body['usersname'] = $this->functions->getUserName($info->uploadedBy);

            $tzUserid = ($this->session->userdata('logged_in') == true) ? $this->session->userdata('userid') : $info->uploadedBy;

            $body['date'] = $this->functions->convertTimezone($tzUserid, $info->datestamp, "F j Y g:iA");

            $body['comments'] = $this->user->getPhotoComments($photoID);
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $this->load->view('user/photo_modal_info', $body);
    }

    public function albumphoto ($user, $file, $size = 80)
    {

    	$file = str_replace('_t.', '.', $file);
    	$file = str_replace('_m.', '.', $file);    
    	$file = str_replace('_n.', '.', $file);
    	$file = str_replace('_z.', '.', $file);
    	$file = str_replace('_c.', '.', $file);
    	$file = str_replace('_b.', '.', $file);

        $path = $_SERVER['DOCUMENT_ROOT'] . 'public' . DS . 'uploads' . DS . 'userimgs' . DS . $user . DS;

        $config['image_library'] = 'gd2';
        $config['source_image']= $path . $file;
        //$config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['dynamic_output'] = true;
        $config['width'] = $size;
        $config['height'] = $size;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();
    }    
    
    public function uploadimgs() {
        $logged_in = $this->functions->checkLoggedIn(false);

        if (!$logged_in)
            $this->functions->jsonReturn('ERROR', "You are not logged in!");

        if ($_FILES) {
            try {


                $path = 'public' . DS . 'uploads' . DS . 'userimgs' . DS . $_POST['userid'] . DS;

                // ensures company uploads directory has been created
                $this->functions->createDir($path);
                $config['upload_path'] = './' . $path;
                $config['allowed_types'] = "gif|jpg|png";
                $config['max_size'] = "5120";
                $config['encrypt_name'] = true;

                // loads upload library
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('file')) {
                    throw new Exception("Unable to upload profile image!" . $this->upload->display_errors());
                }

                $uploadData = $this->upload->data();

                // will ensure stream folder is available
                $streamAlbumCheck = $this->user->checkAlbumType($_POST['userid'], 'stream');

                // create album if it does not exist
                if (!$streamAlbumCheck) {
                    $streamAlbum = $this->user->createPhotoAlbum($_POST['userid'], 'Stream Photos', 1);
                } else {
                    $streamAlbum = $this->user->getAlbumTypeID($_POST['userid'], 'stream');
                }

                // save user img
                $this->user->insertAlbumPhoto($_POST['userid'], $streamAlbum, $uploadData['file_name']);

                // now send image to BMS
                //$this->user->sendImgToBMS($path, $uploadData['file_name'], $_POST['userid']);

                $this->functions->jsonReturn('SUCCESS', $uploadData['file_name']);
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

    public function savephotocomment() {
        if ($_POST) {
            try {
                $commentID = $this->user->savePhotoComment($_POST);

                $this->functions->jsonReturn('SUCCESS', $commentID);
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
        //else show_404();
    }

    public function chat($method) {
        $args = func_get_args();

        unset($args[0]);

        $this->chat->$method($args);
    }

}
