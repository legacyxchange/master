<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings extends CI_Controller {

    function Settings() {
        parent::__construct();

        $this->load->driver('cache');
        $this->load->model('profile_model', 'profile', true);      
        $this->load->model('user_model', 'user', true);
        $this->load->model('user_accounts_model', 'user_accounts', true);
        $this->load->model('user_addresses_model', 'user_addresses', true);
        $this->load->model('products_model', 'product', true);
        
        $this->functions->checkLoggedIn();
    }

    public function index($tab = 0) {
        $header['headscript'] = $this->functions->jsScript('settings.js validate.js');
        
        $body['userinfo'] = $userinfo = $this->user->fetchAll(array('where' => 'user_id = '.$this->session->userdata('user_id')))[0];
        $body['usershipto'] = $usershipto = $this->user_addresses->fetchAll(array('where' => 'user_id = '.$this->session->userdata('user_id').' AND address_type_id = 3'))[0];
        if(is_null($usershipto)){
        	$body['usershipto'] = $usershipto = $userinfo;
        }
        $body['usershipfrom'] = $usershipfrom = $this->user_addresses->fetchAll(array('where' => 'user_id = '.$this->session->userdata('user_id').' AND address_type_id = 4'))[0];        
        if(is_null($usershipfrom)){
        	$body['usershipfrom'] = $usershipfrom = $userinfo;
        }
        $body['products'] = $products = $this->product->fetchAll(array('where' => 'user_id = '.$this->session->userdata('user_id')));
        $body['user_account'] = $this->user_accounts->fetchAll(array('where' => 'user_id = '.$this->session->userdata['user_id']))[0];
        $menu['menu_settings'] = 1;
        $body['admin_menu'] = $this->load->view('admin/admin_menu', $menu, true);
              
        $this->layout->load('admin/settings', $body, 'admin');
    }
    
    public function save() { 
    	
    	if (!empty($_POST)) {   	
    		try {
    			$_POST['user_id'] = $this->session->userdata['user_id'];
    		
    			$this->user->save();
    		
    			if(!empty($_FILES['avatar']['name'])){ 
    				$imageDetails = $this->upload_image();
    		        
    				$_POST['profileimg'] = $imageDetails['file_name'];
    				
    				$this->user->save();     				
    			}
    		   		
    			$this->session->set_flashdata('SUCCESS', 'Your info has been updated!');
    
    			header('Location: /admin/settings'); exit;
    
    	    } catch (Exception $e) {
    			
    			$this->session->set_flashdata('FAILURE', $e->getMessage());
    			header('Location: /admin/settings/'); exit;
    		}
    	}
    }

    public function upload_image(){
    	$path = 'public' . DS . 'uploads' . DS . 'avatars' . DS . $this->session->userdata['user_id'] . DS;
    	
    	$this->functions->createDir($path);
    	
    	$config['upload_path'] = './' . $path;
    	$config['allowed_types'] = "gif|jpg|png";
    	$config['max_size'] = "5120";
    	$config['encrypt_name'] = true;
    	
    	$this->load->library('upload', $config);
    	//var_dump($_FILES); exit;    	
    	
    	if (!$this->upload->do_upload('avatar')) {
    		throw new Exception("Unable to upload profile image!" . $this->upload->display_errors());
    	}
    	
    	$uploadData = $this->upload->data();
    			
    	return $uploadData;
    }
    
    public function connectfb() {
        try {
            $this->profile->updateFacebookID($this->session->userdata('user_id'), $_POST['facebookID']);
            $this->functions->jsonReturn('SUCCESS', 'Facebook account has been linked!');
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
            $this->functions->jsonReturn('ERROR', $e->getMessage());
        }
    }

    public function disconnectfb() {
        try {
            $this->profile->clearFacebookID($this->session->userdata('user_id'));
            $this->functions->jsonReturn('SUCCESS', 'Facebook account has been unlinked!');
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
            $this->functions->jsonReturn('ERROR', $e->getMessage());
        }
    }

    public function deletevideo() {
        if ($_POST) {
            try {

                $this->profile->deleteVideo($_POST['location'], $_POST['id']);

                $this->functions->jsonReturn('SUCCESS', 'Video has been deleted!');
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

    public function deleteimg() {
        if ($_POST) {
            try {
                // gets fileName
                $fileName = $this->dojos->getImageByID($_POST['location'], $_POST['id']);

                $this->profile->deleteImage($_POST['location'], $_POST['id'], $fileName);

                $this->functions->jsonReturn('SUCCESS', 'Image has been deleted!');
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

    public function uploadavatar() {
        if ($_FILES) {

            try {
                // check andor create upload directory
                $path = 'public' . DS . 'uploads' . DS . 'avatars' . DS . $this->session->userdata('user_id') . DS;
  
                // ensures company uploads directory has been created
                $this->functions->createDir($path);

                $config['upload_path'] = './' . $path;
                $config['allowed_types'] = "gif|jpg|png";
                $config['max_size'] = "5120";
                $config['encrypt_name'] = true;

                // loads upload library
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('avatar')) {
                    throw new Exception("Unable to upload profile image!" . $this->upload->display_errors());
                }

                $uploadData = $this->upload->data();

                //$this->profile->sendAvatarToBMS($path, $uploadData['file_name']);
                
                $this->user->updateProfileImg($this->session->userdata('user_id'), $uploadData['file_name']);
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->session->set_flashdata('FAILURE', 'Sorry...Unable to upload your image at this time.');
                header("Location: /admin/settings");
                exit;
            }
            $this->session->set_flashdata('SUCCESS', 'You successfully uploaded your new image!');
            header("Location: /admin/settings");
            exit;
        }
    }

    public function saveusersettings() {
        if ($_POST) {
        	
            try {
                $_POST['companyWebsiteUrl'] = !empty($_POST['website']) ? $_POST['website'] : null;
                $emailChange = false;

                // checks if e-mail has changed 
                if (strtoupper($this->session->userdata('email')) !== strtoupper($_POST['email'])) {
                    // if changed, checks if email is available
                    $emailAvailable = $this->profile->checkEmailAvailable($_POST['email']);

                    if ($emailAvailable == false) {
                        $this->functions->jsonReturn('ALERT', 'E-mail Address is already in use!');
                    }

                    $emailChange == true;
                }

                $_POST['user_id'] = $this->session->userdata('user_id');

                // update user info
                $this->user->save('user_id = '.$this->session->userdata('user_id'));

                // clear previously saved user styles
                $this->profile->clearUserCodes($this->session->userdata('user_id'), 26);


                if (!empty($_POST['styles'])) {
                    foreach ($_POST['styles'] as $code) {
                        $this->profile->insertUserCode($this->session->userdata('user_id'), 26, $code);
                    }
                }

                // updates email session data
                if ($emailChange == true) {
                    $this->session->set_userdata('email', $_POST['email']);
                }

                $this->session->set_userdata('firstName', $_POST['firstName']);
                $this->session->set_userdata('lastName', $_POST['lastName']);

                $this->functions->jsonReturn('SUCCESS', 'User settings have been saved!');
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

    public function savefbphoto() {
        try {
            $filename = $this->profile->downloadfbphoto($this->session->userdata('user_id'), $_POST['url']);

            // check andor create upload directory
            $path = 'public' . DS . 'uploads' . DS . 'avatars' . DS . $this->session->userdata('user_id') . DS;

            $this->profile->sendAvatarToBMS($path, $filename);

            $this->functions->jsonReturn('SUCCESS', 'Facebook photo has been saved!');
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
            $this->functions->jsonReturn('ERROR', $e->getMessage());
        }
    }
}