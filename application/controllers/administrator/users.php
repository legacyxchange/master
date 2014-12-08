<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'third_party' . DS . 'bms' . DS . 'index.php';

class Users extends CI_Controller {

	function Users() {
    	
        parent::__construct();

        $this->load->driver('cache');

        $this->load->model('user_model', 'user', true);
        
        $this->load->model('profile_model', 'profile', true);
        
        $this->load->library('library');
        
        $this->load->library('pagination');
    }

    public function index($user_id = null, $page = 0) {
    	if ($this->session->userdata('logged_in') == false || $this->session->userdata['permissions'] < 1){
        	header('Location: /'); exit;
        }

        $pagination_config['base_url'] = '/administrator/users/index/'.$page; 
        $pagination_config['total_rows'] = $this->user->countAll();
        $pagination_config['per_page'] = 5;
        $pagination_config['cur_page'] = $page;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($pagination_config);
        
        $header['headscript'] = $this->functions->jsScript('jquery-1.6.min.js jquery.reveal.js user.js');
        
        $body['users'] = $this->user->fetchAll(array('orderby' => 'user_id DESC', 'limit' => $pagination_config['per_page'], 'offset' => $page));
        
        if(is_null($id)){
        	try {        		        		
        		$body['followersCnt'] = $this->user->getFollowersCnt($user_id);
        		$body['followingCnt'] = $this->user->getFollowingCnt($user_id);
        	
        		$body['albums'] = $this->user->getAlbums($id);
        	
        		if ((int) $this->session->userdata('userid') !== $user_id) {
        			$body['following'] = $this->user->checkFollowingUser($user_id);
        		}
        	} catch (Exception $e) {
        		$this->functions->sendStackTrace($e);
        	}
        }
        $body['administrator_menu'] = $this->load->view('administrator/administrator_menu', null, true);
        $this->load->view('administrator/template/header', $header);
        $this->load->view('administrator/users', $body);
        $this->load->view('template/footer');
    }
    
    private function getTotalRows(){
    	$this->user->countAll();
    }
    
    public function add() {    	 
    	if (!empty($_POST)) {
    		$params = $_POST;
    		
    		try {

    		$_POST['passwd'] = !empty($_POST['passwd']) ? sha1($_POST['passwd']) : null;
    		
    		$user_id = $this->user->save();

    		if(!empty($_FILES['userfile']['name'])){
    			 
    			$ret = $this->doUpload($user_id);
    			if(!empty($ret['file_name'])){
    				$_POST['profileimg'] = $ret['file_name'];
    				$_POST['id'] = $userid;
    				$this->user->save('user_id = '.$user_id);
    			}
    		}
    		
    		$this->session->set_flashdata('SUCCESS', 'Your info has been updated!');
    
    		header('Location: /administrator/users/index'); exit;
    
    	    } catch (Exception $e) {
    			$this->functions->sendStackTrace($e);
    
    			$this->session->set_flashdata('FAILURE', $e->getMessage());
    		}
    	}
    	return $this->index();
    }
    
    public function edit($user_id) {
    	if(!$user_id)
    		header('Location: /administrator/users');
    
    	$body['user_id'] = $user_id;
    	
    	if (!empty($_POST)) {
    		$params = $_POST;
    		    		
    		if(!empty($_FILES['userfile']['name'])){
    			
    			$ret = $this->doUpload($user_id);
    			if(!empty($ret['file_name'])){
    				$_POST['profileimg'] = $ret['file_name'];
    				$_POST['user_id'] = $user_id;
    				$this->user->save('user_id = '.$user_id);
    			}
    		}
    		
    		try {
    			$where = 'user_id = "'.$user_id.'"';
    			 
    			$this->user->save($where);
    
    			$this->session->set_flashdata('SUCCESS', 'Your info has been updated!');
    
    			header('Location: /administrator/users/'); exit;
    
    		} catch (Exception $e) {
    			$this->functions->sendStackTrace($e);
    
    			$this->session->set_flashdata('FAILURE', $e->getMessage());
    		}
    	}    
    	$this->load->view('deals/edit', $body);
    }
    
    public function userform($user_id = null){    	
    	$out = null;
    	if(!is_null($user_id)){
    		$users = $this->user->fetchAll(array('where' => 'user_id = '.$user_id, 'orderby' => 'user_id DESC'));
    		foreach($users as $r){ 
    			$out .= '
    			<div class="modal-header">
                <h3 class="modal-title">'.$r->firstName.' '.$r->lastName.'</h3>
                </div> <!-- modal-header -->
                <div class="modal-body">
    			';
    			$out .= '<div role="form">';    	        
    			$out .= form_open_multipart('/administrator/users/edit/'.$r->user_id);     			
        		$out .= form_hidden('user_id', $r->user_id);	                        
        		$out .= form_hidden('status', 1);
    			$out .= '<div class="form-group">';
    			$out .= '<label for="firstName">First Name</label><br />';
    			$out .= form_input(array('name' => 'firstName', 'placeholder' => 'First Name', 'value' => $r->firstName));
    			$out .= '</div>';   	
    			$out .= '<div class="form-group">';
    			$out .= '<label for="lastName">Last Name</label><br />';
    			$out .= form_input(array('name' => 'lastName', 'placeholder' => 'Last Name', 'value' => $r->lastName));
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			$out .= '<label for="email">Email</label><br />';
    			$out .= form_input(array('name' => 'email', 'placeholder' => 'Email', 'value' => $r->email));
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			$out .= '<label for="password">Password</label><br />';
    			$out .= form_input(array('type' => 'password', 'name' => 'passwd', 'placeholder' => 'Password', 'value' => $r->passwd));
    			$out .= '</div>'; 
    			$out .= '<div class="form-group">';
    			$out .= '<label for="permissions">Permissions</label><br />';
    			$out .= form_input(array('type' => 'text', 'name' => 'permissions', 'placeholder' => 'Permisssions', 'value' => $r->permissions > 0 ? $r->permissions : 0));
    			$out .= '</div>';
    			$out .= '<div class="form-group">';
    			$out .= '<input type="file" name="userfile" size="20" />'; 
    			if(isset($r->profileimg)){
    				$out .= 'Current Image: <img src="/user/profileimg/100/'.$user_id.'/'.$r->profileimg.'" />';
    			}
    			$out .= '</div>';   							
    			//$out .= '<input type="button" class="sign_cancel" value="Cancel" />';
    			$out .= form_submit(array('name' => 'submit', 'value' => 'Save', 'class' => 'sign_save'));
    			$out .= '</form>';
    			$out .= '</div>';
    		}   
    	} else { 
    		$out .= '<div role="form">';
    		$out .= form_open_multipart('/administrator/users/add');    			                        
        	$out .= form_hidden('status', 1);
    		$out .= '<div class="form-group">';
    		$out .= form_input(array('name' => 'firstName', 'placeholder' => 'First Name', 'value' => $r->firstName));
    		$out .= '</div>';
    		$out .= '<div class="form-group">';
    		$out .= form_input(array('name' => 'lastName', 'placeholder' => 'Last Name', 'value' => $r->lastName));
    		$out .= '</div>';
    		$out .= '<div class="form-group">';
    		$out .= form_input(array('name' => 'email', 'placeholder' => 'Email', 'value' => $r->email));
    		$out .= '</div>';
    		$out .= '<div class="form-group">';
    		$out .= form_input(array('type' => 'password', 'name' => 'passwd', 'placeholder' => 'Password', 'value' => $r->passwd));
    		$out .= '</div>';
    		$out .= '<div class="form-group">';
    		$date = date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))));
    		$out .= '<div class="mylabel">End Date: </div>&nbsp;'.form_input(array('name' => 'end_date', 'value' => $r->end_date, 'type' => 'date', 'min' => "$date"));
    		$out .= '</div>';
    		$out .= '<div class="form-group">';
    		$out .= '<input type="file" name="userfile" size="20" />';
    		if(isset($r->profileimg)){
    			$out .= 'Current Image: <img src="/user/profileimg/100/'.$userid.'/'.$r->profileimg.'" />';
    		}
    		$out .= '</div>';
    		$out .= '<input type="button" class="sign_cancel" onclick="$(\'#myModa2\').hide(\'slow\');location.href=\'/administrator/users\';" value="Cancel" />';
    		$out .= form_submit(array('name' => 'submit', 'value' => 'Save', 'class' => 'sign_save'));
    		$out .= '</form>';
    		$out .= '</div>';
    	}                
        echo $out; exit;
    }
    
    public function delete($user_id){
    	if ($this->session->userdata('logged_in') == false || $this->session->userdata['permissions'] < 1){
    		header('Location: /'); exit;
    	}
    	
    	$this->user->delete('user_id', $user_id);
    	
    	$this->session->set_flashdata('SUCCESS', 'Your data has been updated.');
    	return $this->index();
    }

    public function followers($user_id){
    	$header['headscript'] = $this->functions->jsScript('user.js');
        $body['info'] = $this->functions->getUserInfo($user_id);
        
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

    /**
     * TODO: short description.
     *
     * @return TODO
     */
    public function profileimg($size = 50, $user_id = 0, $file = null) {
    	if (empty($user_id))
            $user_id = $this->session->userdata('user_id');

        $path = $_SERVER["DOCUMENT_ROOT"] . 'public' . DS . 'uploads' . DS . 'avatars' . DS . $user_id . DS;

        if (!empty($file))
            $file = urlencode($file);

        try {

            if (!empty($user_id)){
                $user = $this->user->fetchAll(array('where' => 'user_id = '.$user_id));
                //var_dump($user[0]->profileimg); exit;
            }

            if (!empty($file))
                $img = $file;

            // checks if file exists
            if (!file_exists($path . $img))
                $img = null;

            // no profile image is set - loads no profile img
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

            $leftBuffer = $leftBuffer * 0;
            $topBuffer = $topBuffer * 0;

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
                $followID = $this->user->followUser($this->session->userdata('user_id'), $_POST['user_id']);
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
                $this->user->unfollowUser($this->session->userdata('user_id'), $_POST['user_id']);
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
                $albumID = $this->user->createPhotoAlbum($this->session->userdata('user_id'), $_POST['albumName']);
                $this->functions->jsonReturn('SUCCESS', $albumID);
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

    public function viewalbum($album, $user_id) {
        $body['album'] = $album;
        $body['user_id'] = $userid;
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

            $tzUserid = ($this->session->userdata('logged_in') == true) ? $this->session->userdata('user_id') : $info->uploadedBy;

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

    private function doUpload($user_id)
    {
    	$path = 'public' . DS . 'uploads' . DS . 'avatars' . DS . $user_id . DS;
    
    	$this->functions->createDir($path);
    
    	$config['upload_path'] = './' . $path;
    	$config['allowed_types'] = "gif|jpg|png";
    	$config['max_size'] = "5120";
    	$config['encrypt_name'] = true;
    
    	$this->load->library('upload', $config);
    
    	if ( ! $this->upload->do_upload())
    	{
    		return $this->upload->display_errors();
    	}
    	else
    	{
    		$data = array('upload_data' => $this->upload->data());
    
    		return($data['upload_data']);
    	}
    }
    
    public function uploadimgs() {
        $logged_in = $this->functions->checkLoggedIn(false);

        if (!$logged_in)
            $this->functions->jsonReturn('ERROR', "You are not logged in!");

        if ($_FILES) {
            try {
                $path = 'public' . DS . 'uploads' . DS . 'userimgs' . DS . $_POST['user_id'] . DS;

                $this->functions->createDir($path);
                $config['upload_path'] = './' . $path;
                $config['allowed_types'] = "gif|jpg|png";
                $config['max_size'] = "5120";
                $config['encrypt_name'] = true;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('file')) {
                    throw new Exception("Unable to upload profile image!" . $this->upload->display_errors());
                }

                $uploadData = $this->upload->data();

                $streamAlbumCheck = $this->user->checkAlbumType($_POST['userid'], 'stream');

                if (!$streamAlbumCheck) {
                    $streamAlbum = $this->user->createPhotoAlbum($_POST['userid'], 'Stream Photos', 1);
                } else {
                    $streamAlbum = $this->user->getAlbumTypeID($_POST['userid'], 'stream');
                }
            
                $this->user->insertAlbumPhoto($_POST['user_id'], $streamAlbum, $uploadData['file_name']);

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
    }

    public function chat($method) {
        $args = func_get_args();

        unset($args[0]);

        $this->chat->$method($args);
    }
}