<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dojos extends CI_Controller {

    function Dojos() {
        parent::__construct();

        $this->load->driver('cache');

        $this->load->model('dojos_model', 'dojos', true);
        $this->load->model('profile_model', 'profile', true);
        $this->load->model('events_model', 'events', true);
        $this->load->model('wall_model', 'wall', true);
        
        $this->load->model('deals_model', 'deals', true);
        $this->load->model('menu_model', 'menu', true);
        
        $this->load->model('locations_model', 'locations', true);
        $this->load->model('reviews_model', 'reviews', true);
        $this->load->model('search_model', 'search', true);

        $config = array
            (
            'server' => $this->config->item('server'),
            'connect_timeout' => $this->config->item('connect_timeout'),
            'array_result' => $this->config->item('array_result')
        );

        $this->load->library('sphinxsearch', $config);

        //$this->load->library('places');
    }

    /**
     * TODO: short description.
     *
     * @return TODO
     */
    public function index() {
        $header['headscript'] = $this->functions->jsScript('dojos.js');
        $header['googleMaps'] = true;

        try {
            //$allowedState = false;

            if (!empty($_GET['location'])) {
                $locationInfo = $this->functions->geoCodeAddress($_GET['location']);
                $locationInfo = json_decode($locationInfo);

                //print_r($locationInfo);
                //$allowedState = $this->dojos->allowedState($locationInfo->results[0]->address_components);
                //$state = $body['state'] = $locationInfo->results[0]->address_components[3]->short_name;
                //print_r($state);
            }

            // basically no location was entered
            if (!empty($_GET['location']) && (empty($_GET['lat']) && empty($_GET['lng']))) {
                $ll = $this->functions->getAddressLatLng(urldecode($_GET['location']));

                $_GET['lat'] = $ll->lat;
                $_GET['lng'] = $ll->lng;
            }

            if ($_GET['location'] !== $_GET['lastLoc']) {
                $ll = $this->functions->getAddressLatLng(urldecode($_GET['location']));

                $_GET['lat'] = $ll->lat;
                $_GET['lng'] = $ll->lng;
            }

            // search sphinx to find matches based upon text searched
            /*
              $q = urldecode($_GET['q']);

              if (empty($q))
              {
              $locations = $this->dojos->getPlaces();
              }
              else
              {
              $results = $this->sphinxsearch->Query($q, 'listings');
              }
             */

            //$bodyListings['listings'] = $this->dojos->locateListings(urldecode($_GET['lat']), urldecode($_GET['lng']), urldecode($_GET['q']), 0);


            $places = $this->places->search(urldecode($_GET['lat']), urldecode($_GET['lng']), urldecode($_GET['q']));

            $bodyListings['places'] = $body['places'] = $places;

            $bodyListings['lat'] = urldecode($_GET['lat']);
            $bodyListings['lng'] = urldecode($_GET['lng']);

            $body['initListings'] = $this->load->view('dojos/listings', $bodyListings, true);


            $body['allowedState'] = $allowedState;
            //$body['places'] = json_decode($places);
            //echo "Listings Total: " . $this->dojos->totalListings;
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }


        $header['onload'] = "dojos.indexInit({$_GET['lat']}, {$_GET['lng']});";

        //$body['next_page_token'] = $places->next_page_token;


        $this->load->view('template/header', $header);
        $this->load->view('dojos/index', $body);
        $this->load->view('template/footer');
    }

    public function listings($tail = 0) {
        try {
            $places = $this->places->getNextPage(urldecode($_GET['next_page_token']));

            $body['lat'] = urldecode($_GET['lat']);
            $body['lng'] = urldecode($_GET['lng']);

            $body['places'] = $places;

            //$body['listings'] = $this->dojos->locateListings(urldecode($_GET['lat']), urldecode($_GET['lng']), urldecode($_GET['q']), $tail);
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $this->load->view('dojos/listings', $body);
    }

    public function info($id, $month = null, $year = null, $tab = 0) {
        $header['headscript'] = $this->functions->jsScript('dojos.js search.js');
        $header['googleMaps'] = true;
        $header['lightbox'] = true;
        $header['backstretch'] = true;
        $header['canonical'] = "/dojos/info/{$id}";

        $location_id = $id;
        try {
            $body['month'] = $month = (empty($month)) ? date("n") : $month;
            $body['year'] = $year = (empty($year)) ? date("Y") : $year;

            $body['id'] = $id;

            $body['tab'] = $tab;

            $body['info'] = $info = $this->dojos->getLocationInfo($id);
            $ll = $this->search->mapQuestGeoCode($info->postalCode);
            $body['lat'] = $ll['lat'];
            $body['lng'] = $ll['lng'];
            
            $body['defaultImg'] = $this->dojos->getLocationMainImage($id);

            $header['title'] = $info->name;

            //get videos
            //$body['videos'] = $this->dojos->getLocationVideos($id);

            //$body['reviews'] = $this->dojos->getReviews($id);

            //$body['assigned'] = $this->dojos->checkLocationAssigned($id);

            //$body['images'] = $this->dojos->getLocationImages($id);

            $body['events'] = $this->events->getEvents($id);
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $header['onload'] = "dojos.infoInit({$info->lat}, {$info->lng}, 15);";

        $videoBody['showDelete'] = false;

        $body['videoModal'] = $this->load->view('profile/videomodal', $videoBody, true);

        $body['reviews'] = $reviews = $this->reviews->getReviewsByLocationId($location_id);
    	$body['location_id'] = $location_id;
        $body['info'] = $info = $this->locations->getLocationById($location_id)[0];
        $body['menu'] = $this->menu->getMenu($location_id);
        $body['menuOptions'] = $this->menu->getMenuOptions();
        $body['deals'] = $this->deals->getDealsByLocation($location_id);
            
        $body['assigned'] = $this->search->checkLocationAssigned($location_id);
        $body['images'] = $this->search->getLocationImages($location_id);
        
        //$body['menu_userlist'] = $this->load->view('partials/menu_userlist', $body, true);
        //$this->load->view('template/header', $header);
        $this->load->view('dojos/info', $body);
        //$this->load->view('template/footer', $footer);
    }

    /**
     * TODO: short description.
     *
     * @return TODO
     */
    public function savereview() {
        if ($_POST) {
            try {
                // saves comment
                $this->dojos->insertComment($_POST);
                $_POST['location'] = intval($_POST['location']);
                $_POST['rating'] = intval($_POST['rating']);
                $reviewinfo = $_POST;
                $reviewinfo['username'] = $this->functions->getUserName($this->session->userdata('userid'));
                $reviewinfo['location_name'] = $this->dojos->getLocationNameById($_POST['location']);
                $this->wall->insertPost(array(
                    'postingUser'   => $this->session->userdata('userid'),
                    'userid'        => $this->dojos->getCreatedBy($_POST['location']),
                    'parentPost'    => 0,
                    'post'          => $this->load->view('dojos/reviewpost', $reviewinfo, true)
                ));
                $this->functions->jsonReturn('SUCCESS', 'Comment has been submitted!');
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

    /**
     * TODO: short description.
     *
     * @return TODO
     */
    public function saveclaim() {
        if ($_POST) {
            try {
                $id = $this->dojos->insertclaim($_POST);
                $this->functions->jsonReturn('SUCCESS', 'Claim has been submitted!');
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

    public function upatefromgoogle($location) {
        try {
            $this->dojos->updateLocationFromGooglePlaces($location);

            $this->functions->jsonReturn('SUCCESS', 'Location Updated from Google Places!');
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
            $this->functions->jsonReturn('ERROR', $e->getMessage());
        }
    }

    /**
     * For testing sphinx search
     */
    /*
      public function sphinx ()
      {
      $q = "test";

      echo "{$q}<hr>";

      $results = $this->sphinxsearch->Query($q, 'listings');

      print_r($results);
      echo "<Hr>";

      print_r($this->sphinxsearch->GetLastError());

      }
     */

    public function img($location, $size = 50, $id = 0) {

        $path = $_SERVER["DOCUMENT_ROOT"] . 'public' . DS . 'uploads' . DS . 'locationImages' . DS . $location . DS;

        try {
            if (empty($location))
                throw new Exception("Location ID is empty");

            if (empty($id))
                $img = $this->dojos->getLocationMainImage($location);
            else
                $img = $this->dojos->getImageByID($location, $id);

            //$img = $this->users->getTableValue('profileimg', $userid);
            // no profile image is set - loads no profile img
            if (empty($img)) {
                $path = $_SERVER["DOCUMENT_ROOT"] . DS . 'public' . DS . 'images' . DS;
                $img = 'gst_no_profile.jpg';
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
            $topBuffer = $topBuffer * -1;

            if ($ext == "JPG")
                $srcImg = imagecreatefromjpeg($path . $img);
            if ($ext == "GIF")
                $srcImg = imagecreatefromgif($path . $img);
            if ($ext == "PNG")
                $srcImg = imagecreatefrompng($path . $img);

            $destImg = imagecreatetruecolor($size, $size); // new image
            #imagecopyresized($destImg, $srcImg, 0, 0, $leftBuffer, $topBuffer, $nw, $nh, $width, $height);
            imagecopyresized($destImg, $srcImg, $leftBuffer, $topBuffer, 0, 0, $nw, $nh, $width, $height);
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }


        #echo "NW: {$nw} | NH: {$nh} | Scale: {$scale} | ";
        #echo "topBuffer: {$topBuffer}";
        #echo "leftBuffer: {$leftBuffer}";
        header('Content-Type: image/jpg');
        imagejpeg($destImg);

        imagedestroy($destImg);
        imagedestroy($srcImg);
    }

    public function imgresize($location) {
        try {
            $config['image_library'] = 'gd2';
            $config['source_image'] = $_SERVER['DOCUMENT_ROOT'] . 'public' . DS . 'uploads' . DS . 'locationImages' . DS . $location . DS . urldecode($_GET['fileName']);
            //$config['create_thumb'] = true;
            $config['maintain_ratio'] = true;
            $config['width'] = 730;
            $config['dynamic_output'] = true;
            $config['height'] = 300;

            $this->load->library('image_lib', $config);

            $this->image_lib->resize();
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }
    }

    public function deactiveLocation() {
        if ($_POST) {
            try {
                if (!$this->session->userdata('admin'))
                    throw new Exception("Action not allowed!");

                $this->dojos->deactivateLocation($_POST['location']);

                $this->functions->jsonReturn('SUCCESS', 'Location has been deactivated!');
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

    public function event_modal($id, $location, $month, $year) {
        $body['id'] = $id;

        $body['eventLocation'] = $location;
        $body['month'] = $month;
        $body['year'] = $year;

        try {
            $body['info'] = $info = $this->events->getEventInfo($id);
            //$body['editPerm'] = $this->modules->checkPermission($this->router->fetch_class(), 1); // permission to edit events

            if (empty($info->location)) {
                $body['location'] = $info->otherLocation;

                $body['lat'] = $info->lat;
                $body['lng'] = $info->lng;
            } else {
                $body['location'] = $this->functions->getLocationName($info->location);

                $locLL = $this->functions->getLocLatLng($info->location);

                // gets lat/lng from location
                $body['lat'] = $locLL->lat;
                $body['lng'] = $locLL->lng;
            }

            if (isset($_GET['time']))
                $body['time'] = urldecode($_GET['time']);

            $body['createdBy'] = $this->functions->getUserName($info->userid);

            if ($info->repeat == 1) {
                $body['repeatSummary'] = $this->events->repeatSummary($id);
            }
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        $this->load->view('events/event_modal', $body);
    }

    public function attendevent() {
        if ($_POST) {
            try {
                // first check if they are logged as only logged in users can attend events
                $loggedIn = $this->functions->checkLoggedIn(false);

                if ($loggedIn === false)
                    $this->functions->jsonReturn('ERROR', "You must be logged in to attend events!");

                // insert attend row
                $this->events->insertEventAttend($_POST);

                $this->functions->jsonReturn('SUCCESS', 'You are attending the event!');
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

    public function unattendevent() {
        if ($_POST) {
            try {
                // first check if they are logged as only logged in users can attend events
                $loggedIn = $this->functions->checkLoggedIn(false);

                if ($loggedIn === false)
                    $this->functions->jsonReturn('ERROR', "You must be logged in to attend events!");

                $this->events->deleteEventAttend($_POST);

                $this->functions->jsonReturn('SUCCESS', 'You are no longer attending the event!');
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

}
