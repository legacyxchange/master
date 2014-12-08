<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class search_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * gets a locations row form DB
     */
    public function getLocationInfo($location) {
        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        $mtag = "locationInfo-{$location}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->from('locations');
            $this->db->where('id', $location);
            $this->db->where('deleted', 0);

            $query = $this->db->get();

            $results = $query->result();

            $data = $results[0];

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function grabGeoIP()
    {
        $user_ip = !empty($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '127.0.0.1' ? $_SERVER['REMOTE_ADDR'] : '172.56.15.13';
        
        if(is_null($user_ip)){
        	$obj = new stdClass();
        	$obj->ip = '199.241.138.201';
        	$obj->country_code = 'US';
        	$obj->country_name = "United States";
        	$obj->region_code = 'NV';
        	$obj->region_name = 'Nevada';
        	$obj->city = 'Las Vegas';
        	$obj->latitude = '36.216971';
        	$obj->longitude = '-115.274276';
        	$obj->metro_code = '518';
        	$obj->area_code = '702';
        	return $obj;
        }
        	
        $url1 = 'http://freegeoip.net/json/' . $user_ip;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
       
        if ($result)
        {    	
            return json_decode($result);
            curl_close($ch);
        }
        else
        {       
            $url = 'http://www.telize.com/geoip/' . $user_ip;
            curl_setopt($ch, CURLOPT_URL, $url);
            $result = curl_exec($ch);
            curl_close($ch);
            if(!$result){
            	var_dump('NOT CONNECTING TO '.$url1.' or '.$url	); exit;
            }
            return json_decode($result);
        }
    }
    
    public function mapQuestGeoCode($address)
    {
        $key = 'Fmjtd%7Cluur2h0rnq%2C8g%3Do5-9wblhu';
        $address = urlencode($address);
        $json = substr(file_get_contents('http://open.mapquestapi.com/geocoding/v1/address?key=' . $key . '&location=' . $address . '&callback=renderGeocode&outFormat=json'), 14, -2);
        $json = json_decode($json);
        
        $lat = isset($json->results[0]->locations[0]->latLng->lat) ? $json->results[0]->locations[0]->latLng->lat : false;
        $lng = isset($json->results[0]->locations[0]->latLng->lng) ? $json->results[0]->locations[0]->latLng->lng : false;
        return ($lat && $lng) ? array('lat' => $lat, 'lng' => $lng) : false;
    }
    
    public function getDistance($address1, $address2){
    	
    	$key = 'Fmjtd%7Cluur2h0rnq%2C8g%3Do5-9wblhu';
    	$str = json_encode(array('locations' => array(urlencode($address1), urlencode($address2)), 'options' => array('allToAll' => false)));
    	$url = 'http://www.mapquestapi.com/directions/v2/routematrix?key='.$key.'&outFormat=json&json='.$str;
    	$ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, false);

        $results = curl_exec($ch);
    	return(json_decode($results)->distance[1]);
    }
     
    // checks if there is a location assigned to the Google ID
    public function checkGoogleLocationExists($googleID) {
        if (empty($googleID))
            throw new Exception("Google Location ID is empty!");

        
        // first gets post ID related to post
        $mtag = "googleIDLocation-{$googleID}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {  
            $this->db->select('id');
            $this->db->from('locations');
            $this->db->where('googleID', $googleID);

            $query = $this->db->get();

            $results = $query->result();

            $data = $results[0]->id;

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        if (empty($data))
            return false;

        return $data;
    }

    public function determineAddress($addrObject) {
        if (empty($addrObject))
            throw new Exception("Google Address object is empty!");

        $results = new stdClass();

        // will go through each state until it finds which key is the state
        // this will help determine city and postal code
        foreach ($addrObject as $k => $v) {
        	
            if ($v->types[0] == 'post_box')
                $results->pobox = $v->short_name;

            if ($v->types[0] == 'street_number')
                $results->streetNumber = $v->short_name;

            if ($v->types[0] == 'route')
                $results->route = $v->short_name;

            if ($v->types[0] == 'locality')
                $results->city = $v->short_name;

            if ($v->types[0] == 'administrative_area_level_2')
                $results->county = $v->short_name;

            if ($v->types[0] == 'administrative_area_level_1')
                $results->state = $v->short_name;

            if ($v->types[0] == 'postal_code')
                $results->postalCode = $v->short_name;

            if ($v->types[0] == 'country')
                $results->country = $v->short_name;
        }

        if(!is_array($results))
        	$result[0] = $results;
        else 
        	$result = $results;
              
        return $result;
    }

    public function saveGoogleReviews($location, $reviews, $autoImported = 1) {
        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        if (empty($reviews))
            return false;

        foreach ($reviews as $r) {

            $unix_date = new DateTime();

            $unix_date = DateTime::createFromFormat('U', $r->time);

            $datestamp = $unix_date->format('Y-m-d G:i:s');

            $data = array
                (
                'location' => $location,
                'datestamp' => $datestamp,
                'reviewDesc' => $r->text,
                'rating' => $r->aspects[0]->rating,
                'reviewName' => $r->author_name,
                'autoImported' => $autoImported
            );

            try {
                $this->insertComment($data);
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                continue;
            }
        }

        return true;
    }

    /**
     * checks if enough time has passed where location needs updating from google places
     * time in seconds between updates in config
     */
    public function checkLocationNeedUpdating($location) {
        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        $lastUpdated = $this->getLocationCol($location, 'lastUpdated');

        $lastUpdatedUT = (int) strtotime($lastUpdated);

        $nowUT = (int) strtotime("now");

        $diff = $nowUT - $lastUpdatedUT;

        if ($diff >= $this->config->item('locationUpdateTime'))
            return true;

        return false;
    }

    public function getLocationCol($location, $col) {
        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");
        if (empty($col))
            throw new Exception('Gets a particular column from locations table');

        $mtag = "locationCol-{$location}-{$col}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select($col);
            $this->db->from('locations');
            $this->db->where('id', $location);

            $query = $this->db->get();

            $results = $query->result();

            $data = $results[0]->{$col};

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function updateLocationFromGooglePlaces($location) {
        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        // checks if location is claimed
        $assigned = $this->checkLocationAssigned($location);

        // returns false for updating if already assigned - so users info doesn't get overwritten
        if ($assigned)
            return false;

        // gets google place reference
        $locaitonRef = $this->getLocationCol($location, 'googleReference');

        // returns false if there is no google reference
        if (empty($locaitonRef))
            return false;

        $details = $this->places->details($locaitonRef);
        //print_r(json_encode($details));
        $address = $this->determineAddress($details->result->address_components);

        //print_r($address);

        $data = array
            (
            'id' => $location,
            'name' => $details->result->name,
            'city' => $address->city,
            'state' => $address->state,
            'postalCode' => $address->postalCode,
            'phone' => $details->result->formatted_phone_number,
            'website' => $details->result->website,
            'lat' => $details->result->geometry->location->lat,
            'lng' => $details->result->geometry->location->lng,
            'formattedAddress' => $details->result->formatted_address,
            'googleHTMLAddress' => $details->result->adr_address
        );

        if (empty($address->pobox)) {
            $data['address'] = $address->streetNumber . ' ' . $address->route;
        } else {
            $data['address'] = "PO Box " . $address->pobox;
            $data['address2'] = $address->streetNumber . ' ' . $address->route;
        }

        //print_r($data);
        $this->profile->updateLocation($data);

        // will now donwload images
        // clears previous images from database
        $this->profile->clearLocationImage($location);


        $path = $_SERVER['DOCUMENT_ROOT'] . 'public/uploads/locationImages/' . $location . '/';

        if (is_dir($path)) {
            $this->clearImages($path);

            $delImgFolder = rmdir($path);

            if ($delImgFolder === false)
                throw new Exception("Unable to clear location images folder");
        }

        if (!empty($details->result->photos)) {
            foreach ($details->result->photos as $k => $v) {
                $this->places->photoRequest($v->photo_reference, $location);
            }
        }

        // clear out imported reviews and insert new ones
        $this->profile->clearLocationReviews($location, true);

        $this->saveGoogleReviews($location, $details->result->reviews);
    }

    public function checkLocationAssigned($location) {
        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        // gets ratings
        $mtag = "locationAssigned-{$location}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->from('userLocations');
            $this->db->where('location', $location);

            $data = $this->db->count_all_results();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        if ((int) $data > 0)
            return true;


        return false;
    }

    // checks if a location is active or not
    public function checkLocationActive($location) {
        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        $mtag = "checkLocationActive-{$location}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('active');
            $this->db->from('locations');
            $this->db->where('id', $location);

            $query = $this->db->get();

            $results = $query->result();

            $data = $results[0]->active;

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        if ((bool) $data == true)
            return true;

        return false;
    }

    public function insertComment($p) {
        if (empty($p['location']))
            throw new Exception("Location ID is empty!");

        $datestamp = (empty($p['datestamp'])) ? DATESTAMP : $p['datestamp'];

        $data = array
            (
            'location' => $p['location'],
            'datestamp' => $datestamp,
            'comment' => $p['reviewDesc'],
            'rating' => $p['rating']
        );

        if ($this->session->userdata('logged_in') && empty($p['reviewName'])) {
            $data['userid'] = $this->session->userdata('userid');
        } else {
            $data['name'] = $p['reviewName'];
            $data['email'] = $p['reviewEmail'];
        }

        $this->db->insert('locationReviews', $data);

        return $this->db->insert_id();
    }

    public function getLocationMainImage($location) {
        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        $mtag = "locationMainImg-{$location}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('fileName');
            $this->db->from('locationImages');
            $this->db->where('locationid', $location);
            $this->db->where('imgOrder', 0); // gets picture in position 1

            $query = $this->db->get();

            $results = $query->result();

            if(count($results) > 0)
                $data = $results[0]->fileName;
            else 
                $data = array();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function getLocationVideos($location) {
        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        $mtag = "locationVideos-{$location}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('id, datestamp, url, videoOrder, title, thumbnail, videoID, description');
            $this->db->from('locationYouTubeVideos');
            $this->db->where('locationid', $location);
            $this->db->order_by('videoOrder', 'asc');

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function getReviews($location = null, $limit = null) {
        $location = intval($location);

        //if (empty($location))
            //throw new Exception('Location ID is empty!');

        $mtag = "reviews-{$location}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('userid, datestamp, name, email, comment, rating');
            $this->db->from('locationReviews');
            if(!is_null($location))
            	$this->db->where('location', $location);
            
            $this->db->where('comment <> ""');
            $this->db->order_by('datestamp', 'desc');
            if(!is_null($limit)){
            	$this->db->limit($limit);
            }

            $query = $this->db->get();

            $data = $query->result();
            
            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }
    
    public function getNumReviews($location) {
        $location = intval($location);

        if (empty($location))
            throw new Exception('Location ID is empty!');

        $mtag = "review-num-{$location}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $query = $this->db->query("SELECT COUNT(*) AS numreviews FROM locationReviews WHERE location = $location");
            $data = $query->row(1)->numreviews;
            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function getLocationImages($location, $IDsonly = false) {
        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        $mtag = "locationImages-{$location}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('id, fileName');
            $this->db->from('locationImages');
            $this->db->where('locationid', $location);
            $this->db->order_by('imgOrder', 'asc');

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        if (empty($data))
            return false;

        if ($IDsonly) {
            $IDs = array();

            foreach ($data as $r) {
                $IDs[] = $r->id;
            }

            return $IDs;
        }

        return $data;
    }

    public function getImageByID($location, $id) {
        $location = intval($location);
        $id = intval($id);

        if (empty($location))
            throw new Exception("Location ID is empty!");
        if (empty($id))
            throw new Exception("Image ID is empty!");

        $mtag = "locationImgByID-{$location}-{$id}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('fileName');
            $this->db->from('locationImages');
            $this->db->where('locationid', $location);
            $this->db->where('id', $id);

            $query = $this->db->get();

            $results = $query->result();

            $data = $results[0]->fileName;

            //error_log($this->db->last_query());

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        //error_log($data);

        return $data;
    }

    /**
     * TODO: short description.
     *
     * @param mixed $listing 
     *
     * @return TODO
     */
    public function avgReviews($location) {

        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        // gets ratings
        $mtag = "avgReviews-{$location}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('rating');
            $this->db->from('locationReviews');
            $this->db->where('location', $location);
            $this->db->where('rating >', 0);

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        if (empty($data))
            return 0;

        // total number of ratings
        $cnt = count($data);

        $total = 0;

        foreach ($data as $r) {
            $total += (int) $r->rating;
        }

        return round($total / $cnt);
    }

    public function deactivateLocation($location) {
        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        $data = array
            (
            'active' => 0,
            'lastUpdated' => DATESTAMP
        );

        $this->db->where('company', $this->config->item('bmsCompanyID'));
        $this->db->where('id', $location);
        $this->db->update('locations', $data);

        return true;
    }

    /**
     * TODO: short description.
     *
     * @param mixed $p 
     *
     * @return TODO
     */
    public function insertclaim($p) {
        if (empty($p['id']))
            throw new Exception("Location ID is empty!");

        $data = array
            (
            'datestamp' => DATESTAMP,
            'location' => $p['id'],
            'userid' => $this->session->userdata('userid'),
            'IP' => $_SERVER['REMOTE_ADDR'],
            'name' => $p['name'],
            'phone' => $p['phone'],
            'positionInBusiness' => $p['position'],
            'comment' => $p['comments']
        );

        $this->db->insert('locationClaims', $data);

        return $this->db->insert_id();
    }

    /*
     * goes through a locations image directory and deletes each image
     */

    private function clearImages($path) {
        $files = scandir($path);

        foreach ($files as $img) {
            if ($img !== '.' && $img !== '..') {
                $del = unlink($path . $img);

                if (!$del)
                    throw new Exception("Unable to delete image: {$path}{$file}");
            }
        }
    }

    // if site is restricted by state, checks listings from allowed states
    public function allowedState($address_components) {
        $allowed = false;

        if (!empty($address_components)) {
            foreach ($address_components as $k => $v) {
                if (in_array($v->short_name, $this->config->item('allowed_states'))) {
                    $allowed = true;
                    break;
                }
            }
        }

        if ($allowed == true)
            return true;

        return false;
    }

    public function prep($q) {
        if ($this->config->item('bmsCompanyID') == 40) {
            if (empty($q))
                $q = 'Baseball';
            else {
                $q = "Baseball " . $q;
            }
        }

        // canna
        if ($this->config->item('bmsCompanyID') == 41) {

            if (stripos('Dispensaries', $q) !== false) {
                return 'Marijuana ' . $q;
            }

            if (stripos('Doctors', $q) !== false) {
                return 'Marijuana ' . $q;
            }
        }

        return $q;
    }

    /**
     * checks if a location is set to deleted
     */
    public function checkLocationDeleted($location) {
        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        $mtag = "checkLocationDeleted-{$location}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('deleted');
            $this->db->from('locations');
            $this->db->where('id', $location);

            $query = $this->db->get();

            $results = $query->result();

            $data = $results[0]->deleted;

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        if ((bool) $data == true)
            return true;

        return false;
    }

    /**
     * TODO: short description.
     *
     * @param mixed $id 
     *
     * @return TODO
     */
    public function getLocationLatLng($id) {
        if (empty($id))
            throw new Exception("Location ID is empty!");

        $mtag = "dojoPlacesLatLng-{$id}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {

            $this->db->select('lat, lng');
            $this->db->from('locations');
            $this->db->where('id', $id);

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        if (empty($data)) {
            throw new Exception("Unable to find latitude and longitude for this location");
        }

        $ll = null;

        $ll->lat = $data[0]->lat;
        $ll->lng = $data[0]->lng;

        return $ll;
    }

    /**
     * Gets number of active reviews for a location
     *
     * @param mixed $id 
     *
     * @return INT
     */
    public function getReviewCnt($location) {
        if (empty($location))
            throw new Exception("Location ID is empty!");

        // first gets post ID related to post
        $mtag = "locationReviewCnt-{$location}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->from('locationReviews');
            $this->db->where('location', $location);
            $this->db->where('rating >', 0);

            $data = $this->db->count_all_results();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return (int) $data;
    }

}
