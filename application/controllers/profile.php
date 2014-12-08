<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends CI_Controller {

    function Profile() {
        parent::__construct();

        $this->load->driver('cache');
        $this->load->model('profile_model', 'profile', true);
        $this->load->model('dojos_model', 'dojos', true);
        $this->load->model('menu_model', 'menu', true);
        $this->load->model('user_model', 'user', true);
        $this->load->model('products_model', 'product', true);
        $this->load->model('location_hours_model', 'location_hours', true);
        
        $this->functions->checkLoggedIn();
    }

    public function index($tab = 0) {
        $header['headscript'] = $this->functions->jsScript('profile.js');
        
        $header['ckeditor'] = true; //tinymce editor

        $body['tab'] = $tab;

        try {
            
            $body['userinfo'] = $userinfo = $this->user->fetchAll(array('where' => 'user_id = '.$this->session->userdata('user_id')))[0];

            $body['products'] = $products = $this->product->fetchAll(array('where' => 'user_id = '.$this->session->userdata('user_id')));
            
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $header['onload'] = "profile.indexInit(0,0);";

        $this->load->view('admin/template/header', $header);
        $this->load->view('profile/index', $body);
        $this->load->view('template/footer');
    }

    public function locationedit($id = 0) {
        $header['headscript'] = $this->functions->jsScript('profile.js');
        $header['googleMaps'] = true;
        $header['ckeditor'] = true;
        $header['onload'] = "profile.locationedit(0, 0);";
        $body['id'] = $id;
        $body['menu_options'] = $this->menu->getMenuOptions();
        
        $body['user_id'] = $this->session->userdata['user_id'];

        try {
            
            $body['menu_items'] = $this->menu->getMenu($id);

            $body['styles'] = $this->functions->getCodes(26, $this->config->item('bmsCompanyID'));
            $body['states'] = $this->functions->getStates();

            if (!empty($id)) {
                $body['info'] = $info = $this->dojos->getLocationInfo($id);
                $body['location_hours'] = $location_hours = $this->location_hours->getLocationHoursByLocationId($id);
                //var_dump($location_hours); exit;
                //$body['meta'] = $this->dojos->getLocMetaData($id);
                //$body['ll'] = $ll = $this->dojos->getLocationLatLng($id);
                $body['assignedStyles'] = $this->dojos->getLocationCodes($id, 26);

                //$body['defaultImg'] = $this->dojos->getLocationMainImage($id);

                $body['images'] = $this->dojos->getLocationImages($id, true);

                //get videos
                $body['videos'] = $this->dojos->getLocationVideos($id);

                $header['onload'] = "profile.locationedit({$info->lat}, {$info->lng});";
            } else {
                
            }
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $videoBody['showDelete'] = true;
        $body['videoModal'] = $this->load->view('profile/videomodal', $videoBody, true);
        $this->load->view('template/header', $header);
        $this->load->view('profile/locationedit', $body);
        $this->load->view('template/footer');
    }

    public function savelisting() {
        if (!empty($_POST)) {
        	
            set_time_limit(3600);
            try {
            	if(!empty($_POST['menu'])){
            		$count = count($_POST['menu']);
            		for($i = 0; $i < $count; $i++){
            			if(!empty($_POST['menu']['new'.$i])){            				
            				$this->menu->save($_POST['menu']['new'.$i]);            				
            			}
            		}           		
            	}
            	                   
                $address = "{$_POST['address']} {$_POST['city']}, {$_POST['state']} {$_POST['postalCode']}";

                // geolocate address
                $ll = $this->functions->getAddressLatLng($address);

                if(empty($_POST['lat']))
                    $_POST['lat'] = $ll->lat;
                if(empty($_POST['lng']))
                    $_POST['lng'] = $ll->lng;
                
                if (empty($_POST['id'])) {
                    // create listing
                    //$post_id = $this->profile->insertPost($_POST);
                    $location = $this->profile->insertLocation($_POST);

                    // assigns location to user
                    $this->profile->insertUserLocation($this->session->userdata('user_id'), $location);


                    // add google Places location
                    $this->profile->setGoogleReference($location, $_POST);

                    // save thumbnail ID
                } else {
                    $location = $_POST['id'];
                    $this->profile->updateLocation($_POST);

                    // clears saved styles
                    $this->profile->clearLocationCodes($_POST['id'], 26);
                }
                
                $params = $_POST;
                
                $params['location_id'] = isset($_POST['id']) ? $_POST['id'] : null;
                
                $this->location_hours->save($params); 

                // saves styles
                if (!empty($_POST['styles'])) {
                    foreach ($_POST['styles'] as $code) {
                        $this->profile->insertLocationCode($location, 26, $code);
                    }
                }

                if ($_FILES) {
                    //$path = 'wordpress' . DS . 'wp-content' . DS . 'uploads' . DS . date('Y') . DS . date('m') . DS;
                    
                    $path = 'public' . DS . 'uploads' . DS . 'locationImages' . DS . $location . DS;

                    // ensures company uploads directory has been created
                    $this->functions->createDir($path);

                    $config['upload_path'] = './' . $path;
                    $config['allowed_types'] = "gif|jpg|png";
                    $config['max_size'] = "5120";
                    $config['encrypt_name'] = true;

                    // loads upload library
                    $this->load->library('upload', $config);             

                    $imgOrder = $this->profile->getNextImgOrder($location);

                    //error_log("Images to upload!");

                    foreach ($_FILES['image']['name'] as $k => $img) {
                        $imgPostID = 0;
                        //error_log("Image Name: {$k}:{$img}");
                       
                        if (!empty($img)) {
                            $_FILES['userfile']['name'] = $_FILES['image']['name'][$k];
                            $_FILES['userfile']['type'] = $_FILES['image']['type'][$k];
                            $_FILES['userfile']['tmp_name'] = $_FILES['image']['tmp_name'][$k];
                            $_FILES['userfile']['error'] = $_FILES['image']['error'][$k];
                            $_FILES['userfile']['size'] = $_FILES['image']['size'][$k];

                            if (!$this->upload->do_upload('userfile')) {
                                throw new Exception("Unable to upload profile image!" . $this->upload->display_errors());
                            }

                            $uploadData = $this->upload->data();

                            // must now save post attachment
                            $imgData = array
                                (
                                'location' => $location,
                                'fileName' => $uploadData['file_name'],
                                'order' => $imgOrder
                            );

                            $imgID = $this->profile->insertLocationImage($imgData);

                            $imgOrder++;
                        }
                    }
                    /* */
                    //}
                }


                // upload videos
                if (!empty($_POST['videoUrl'])) {
                    $cnt = 0;
                    foreach ($_POST['videoUrl'] as $videoUrl) {
                        $videoData = array();

                        // skips video if empty
                        if (empty($videoUrl))
                            continue;

                        $videoData['url'] = $videoUrl;

                        $videoData['id'] = $this->functions->getYoutubeVideoID($videoUrl);


                        // gets youtube data about video
                        $youtubeData = $this->functions->getYoutudeVideoData($videoData['id'], false);
                        $data = json_decode($youtubeData);

                        $videoData['title'] = $data->entry->title->{'$t'};
                        $videoData['thumbnail'] = $data->entry->{'media$group'}->{'media$thumbnail'}[0]->url;
                        $videoData['description'] = $data->entry->{'media$group'}->{'media$description'}->{'$t'};

                        // insert video post
                        // must now save post attachment
                        $videoPostData = array
                            (
                            'location' => $location,
                            'url' => $videoData['url'],
                            'order' => $cnt,
                            'title' => $videoData['title'],
                            'thumbnail' => $videoData['thumbnail'],
                            'description' => $videoData['description'],
                            'videoID' => $videoData['id']
                        );

                        $videoID = $this->profile->insertLocationVideo($videoPostData);

                        $cnt++;
                    }
                }
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
            }

            header("Location: /profile?site-success=" . urlencode("Location has been saved!"));
            exit;
        }
    }

    public function deletelocation() {
        if ($_POST) {

            try {
                // get location info
                $info = $this->dojos->getLocationInfo($_POST['location']);

                if (!empty($info->googleReference)) {
                    // remove location from Google Places
                    $this->places->deleteLocation($info->googleReference);
                }

                $this->profile->setLocationDeleted($_POST['location']);

                $this->functions->jsonReturn('SUCCESS', 'Location has been deleted!');
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

    public function saveimgorder() {
        if ($_POST) {
            try {

                $cnt = 0;
                if (!empty($_POST['img'])) {
                    foreach ($_POST['img'] as $imgID) {
                        $this->profile->updateImgOrder($_POST['location'], $imgID, $cnt);
                        $cnt++;
                    }
                }
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
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
                header("Location: /profile?site-error=" . urlencode("Unable to upload Image!"));
                exit;
            }

            header("Location: /profile?site-success=" . urlencode("Avatar has been uploaded!"));
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