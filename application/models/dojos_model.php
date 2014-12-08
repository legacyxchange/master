<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class dojos_model extends CI_Model {

    public $totalListings;

    /**
     * TODO: short description.
     *
     */
    function __construct() {
        parent::__construct();

        //$this->totalListings = 0;
    }

    public function getPlaces() {
        $mtag = "dojoPlaces";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('id, lat, lng');
            $this->db->from('locations');
            $this->db->where('company', $this->config->item('bmsCompanyID'));


            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout_extended'));
        }

        return $data;
    }

    public function getLocationInfo($location) {
        $location = intval($location);

        if (!isset($location))
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

    public function getLocationInfoByUserId($userid) {
        if (empty($userid))
            throw new Exception("userid is empty!");

        require_once 'search_model.php';
        $search = new search_model();
        
        $info = $search->grabGeoIP();
        
        $mtag = "locationinfobyuser-{$userid}";

        $data = null; //$this->cache->memcached->get($mtag);
        $sql = "select l.* from locations as l
                join userLocations as ul on(l.id = ul.location)
                join users as u on(ul.userid = u.id)
                where u.id = $userid"; 
        if (!$data) {
            $query = $this->db->query(
                $sql
            );
       
            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }
        
        $rows = array();
        foreach($data as $row){
        	$row->distance = $search->getDistance($info->zipcode, $row->postalCode);
        	$rows[] = $row;
        }
        
        return($rows); exit;
    }
    
    public function getLocationCodes($location, $group = 0) {
        $location = intval($location);
        $group = intval($group);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        $mtag = "locationCodes-{$location}-{$group}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('group, code');
            $this->db->from('locationCodes');
            $this->db->where('locationid', $location);

            if (!empty($group))
                $this->db->where('group', $group);

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function getUserCodes($user, $group = 0) {
        $user = intval($user);
        $group = intval($group);

        if (empty($user))
            throw new Exception("User ID is empty!");

        $mtag = "locationCodes-{$user}-{$group}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('group, code');
            $this->db->from('userCodes');
            $this->db->where('userid', $user);

            if (!empty($group))
                $this->db->where('group', $group);

            $query = $this->db->get();

            $data = $query->result();

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

	public function getFollowers($id) {
        $id = intval($id);

        if (empty($id))
            throw new Exception('Location ID is empty!');

        $mtag = "getFollowers-{$id}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
            $query_str = "
                SELECT
                        uf.userid
                    ,   uf.followingUser
                    ,   u.firstName
                    ,   u.lastName
                FROM userFollow uf
                INNER JOIN locations AS u ON (u.id = uf.userid)
                WHERE active = 1
                    AND uf.followingUser = $id
            ";
            $query = $this->db->query($query_str);
            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }
    
	public function getFollowing($id) {
        $id = intval($id);

        if (empty($id))
            throw new Exception('Location ID is empty!');

        $mtag = "getFollowing-{$id}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
            $query_str = "
                SELECT
                        uf.userid
                    ,   uf.followingUser
                    ,   u.firstName
                    ,   u.lastName
                FROM userFollow uf
                INNER JOIN locations AS u ON (u.id = uf.userid)
                WHERE active = 1
                    AND uf.followingUser = $id
            ";
            $query = $this->db->query($query_str);
            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
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

            $data = $results[0]->fileName;

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
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

    // DEPRECATED
    /*
      public function getPosts ($type = 'place', $post_parent = 0)
      {
      //if (empty($user_id)) throw new Exception("User ID is empty!");

      $mtag = "dojoPots-{$type}-{$post_parent}";

      $data = $this->cache->memcached->get($mtag);

      if (!$data)
      {
      $this->db->select('ID');
      $this->db->from('wp_posts');
      $this->db->where('post_type', $type);

      if (!empty(post_parent)) $this->db->where('post_parent', $post_parent);

      $this->db->order_by('post_title', 'asc');

      $query = $this->db->get();

      $data = $query->result();

      $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
      }

      return $data;
      }
     */

    /**
     * TODO: short description.
     *
     * @param mixed $id 
     *
     * @return TODO
     */
    public function getLocationLatLng($id) {
        if (empty($id))
            throw new Exception("Place ID is empty!");

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

        $ll = new stdClass();
        
        $ll->lat = $data[0]->lat;
        $ll->lng = $data[0]->lng;

        return $ll;
    }

    /**
     * TODO: short description.
     *
     * @param mixed $lat 
     * @param mixed $lng 
     * @param mixed $q   Optional, defaults to null. 
     *
     * @return TODO
     */
    public function locateListings($lat, $lng, $q = null, $tail = 0) {
        //$mtag = "listingIDs:{$lat}:{$lng}:{q}";
        // error_log("lat: {$lat} | lng: {$lng} | q: {$q} | tail: {$tail}"); // for debugging

        $getLL = false;

        if (empty($q)) {
            // get list of all places
            $places = $this->getPlaces();
        } else {
            $getLL = true;

            $results = $this->sphinxsearch->Query($q, 'listings');

            // print_r($results);

            foreach ($results['matches'] as $r) {

                // check location company
                $locationCompany = $this->functions->getLocationCompany($r['id']);

                // only adds locations that are assigned to the company
                if ($locationCompany == $this->config->item('bmsCompanyID')) {
                    $places[]->id = $r['id'];
                }
            }
        }

        //print_r($places);

        $this->totalListings = count($places);

        $cnt = 0;

        $tailHit = (empty($tail)) ? true : false;


        //error_log("tailHit Init:{$tailHit}");

        foreach ($places as $r) {

            if ($getLL == true) {
                $ll = $this->getLocationLatLng($r->id);

                $r->lat = $ll->lat;
                $r->lng = $ll->lng;
            }

            $distance = $this->functions->distance($lat, $lng, $r->lat, $r->lng);


            // if within radius will add to results
            $listings[$r->id]->distance = $distance;

            $listings[$r->id]->lat = $r->lat;
            $listings[$r->id]->lng = $r->lng;

            //$cnt++;
        }

        asort($listings);

        //print_r($listings);

        foreach ($listings as $k => $r) {
            if ($tailHit == false) {
                if ((int) $tail == (int) $k) {
                    $tailHit = true;
                }
            }

            //error_log("Checking: {$k} | tailHit:{$tailHit}");
            // skips row until it hits the tail and loads the next set of data
            if ($tailHit == false)
                continue;

            if ($tail == $k)
                continue;

            $finalListings[$k] = $r;

            $cnt++;

            //error_log("cnt:{$cnt} | {$this->config->item('listingsPerPage')}");
            //once it has gathered the amount of listings per page, breaks loop
            if ($cnt >= (int) $this->config->item('listingsPerPage'))
                break;
        }

        //print_r($finalListings);
        // $listings = asort($listings);

        return $finalListings;
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

    public function insertComment($p) {
        if (empty($p['location']))
            throw new Exception("Location ID is empty!");

        $datestamp = (empty($p['datestamp'])) ? DATESTAMP : $p['datestamp'];

        $data = array(
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

    public function getCreatedBy($locationid)
    {
        $locationid = intval($locationid);

        if (empty($locationid))
            throw new Exception('Location ID is empty!');

        $mtag = "location-created-by-{$locationid}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('createdBy');
            $this->db->from('locations');
            $this->db->where('id', $locationid);

            $query = $this->db->get();

            $data = $query->first_row()->createdBy;

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }
    
    public function getLocationNameById($locationid)
    {
        $locationid = intval($locationid);

        if (empty($locationid))
            throw new Exception('Location ID is empty!');

        $mtag = "location-name-{$locationid}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('name');
            $this->db->from('locations');
            $this->db->where('id', $locationid);

            $query = $this->db->get();

            $data = $query->first_row()->name;

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }
    
    public function getReviews($location) {
        $location = intval($location);

        if (empty($location))
            throw new Exception('Location ID is empty!');

        $mtag = "reviews-{$location}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('userid, datestamp, name, email, comment, rating');
            $this->db->from('locationReviews');
            $this->db->where('location', $location);
            $this->db->order_by('datestamp', 'desc');

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
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

    public function getFormattedAddress($location) {
        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        $mtag = "googleIDLocation-{$location}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('formattedAddress');
            $this->db->from('locations');
            $this->db->where('id', $location);

            $query = $this->db->get();

            $results = $query->result();

            $data = $results[0]->formattedAddress;

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

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

    /**
     * Finds associated styles and assigns them to the location
     */
    public function styleFind($location, $clearStyles = true) {
        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        $info = $this->getLocationInfo($location);

        $styles = $this->functions->getCodes(26, $this->config->item('bmsCompanyID'));

        // clers previously assigned styles if $clearStyles is true
        if ($clearStyles)
            $this->profile->clearLocationCodes($location, 26);

        //echo "Name: {$info->name}" . PHP_EOL;

        if (!empty($styles)) {
            foreach ($styles as $r) {
                $match = null;


                $display = str_replace(' ', '\s', $r->display);
                $display = str_replace('-', '\s', $display);

                $pattern = '#' . $display . '#i';

                //echo $pattern . PHP_EOL;

                $match = preg_match($pattern, $info->name);

                //print_r($match); echo PHP_EOL;
                if ($match === false)
                    throw new Exception("Error in matching: {$pattern} - {$info->name}");


                if (!empty($match)) {
                    $this->profile->insertLocationCode($location, 26, $r->code);
                    continue;
                }

                $match = null; //resets $match variable
                // next will check description
                $match = preg_match($pattern, $info->description);

                if (!empty($match)) {
                    $this->profile->insertLocationCode($location, 26, $r->code);
                    continue;
                }


                //var_dump($match); echo PHP_EOL;
            }
        }
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

    public function determineAddress($addrObject) {
        if (empty($addrObject))
            throw new Exception("Google Address object is empty!");

        (object) $results;

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

        //print_r($results);

        return $results;
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

}
