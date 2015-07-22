<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'abstract_model.php';

class user_model extends abstract_model {

    protected $table = 'users';
    protected $primary_key = 'user_id';
    protected $unique_key = 'username';
    public $user_id;
    public $email;
    public $passwd;
    public $firstName;
    public $lastName;
    public $username;
    public $status;
    public $permissions;
    public $timezone;
    public $deleted;
    public $profileimg;
    public $admin;
    public $addressLine1;
    public $addressLine2;
    public $addressLine3;
    public $city;
    public $state;
    public $postalCode;
    public $companyName;
    public $facebookUrl;
    public $twitterUrl;
    public $linkedInUrl;
    public $youtubeUrl;
    public $googlePlusUrl;
    public $companyWebsiteUrl;
    public $phone;
    public $mobile;
    public $fax;
    public $bio;
    public $lat;
    public $lng;
    public $facebookID;
    public $dob; 
    public $gender;
    public $heightFeet;
    public $heightInches;
    public $weight;
    public $weightType;
    public $relationshipStatus;
    
    function __construct() {
        parent::__construct();
    }
    
    public function save($where = null){
    	if(!empty($_POST['passwd']) && !empty($_POST['user_id'])){
    		$rows = $this->fetchAll(array('where' => 'user_id = "'.htmlentities($_POST['user_id'], ENT_QUOTES).'"'));
    		if(sizeof($rows) > 0){
    			$pass = $rows[0]->passwd;
    			if($_POST['passwd'] != $pass){    			
    				$_POST['passwd'] = sha1($_POST['passwd']);
    			}
    		}    		
    	} else {
    		unset($_POST['user_id']);
    		unset($_POST['passwd']);
    	}  
    	//var_dump($_POST); exit;
    	return parent::save($where);
    }
    
    public function create ()
    {
    	require_once 'search_model.php';
    	
    	if (empty($_POST['email'])) throw new Exception('E-mail Address is empty!');
    
    	$search = new search_model();
    	
    	$_POST['timezone'] = $search->grabGeoIP()->timezone;
    	$_POST['status'] = 1;
    	   	
    	if (!empty($_POST['facebookID'])) $data['facebookID'] = $_POST['facebookID'];
    	
    	$user_id = $this->save();
    	
    	return $user_id;
    }

    public function getBlogs($user_id, $page = 1, $category = 0) {
        $user_id = intval($user_id);

        if (empty($user_id))
            throw new Exception('User ID is empty!');

        //$company = $this->config->item('bmsCompanyID');

        $mtag = "blogs-{$user_id}-{$page}-{$category}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $perPage = $this->config->item('blogsPerPage');

            $offset = ($page * $perPage) - $perPage;

            $this->db->select('id, publishDate, title, active');
            $this->db->from('blogs');
            $this->db->where('user_id', $user_id);
            $this->db->where('company', $company);
            $this->db->where('deleted', 0);
            $this->db->where('active', 1);

            if (!empty($category))
                $this->db->where('category', $category);

            $this->db->order_by('publishDate', 'DESC');
            $this->db->limit($perPage, $offset);

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function followUser($user_id, $followingUser) {
        $user_id = intval($user_id);
        $followingUser = intval($followingUser);

        if (empty($user_id))
            throw new Exception('User ID is empty!');
        if (empty($followingUser))
            throw new Exception('Following user ID is empty!');

        $data = array(
            'datestamp' => DATESTAMP,
            'user_id' => $user_id,
            'followingUser' => $followingUser,
            'active' => 1,
            'dateApproved' => DATESTAMP
        );

        $this->db->insert('userFollow', $data);

        return $this->db->insert_id();
    }

    public function unfollowUser($user_id, $followingUser) {
        $user_id = intval($user_id);
        $followingUser = intval($followingUser);

        if (empty($user_id))
            throw new Exception('User ID is empty!');
        if (empty($followingUser))
            throw new Exception('Following user ID is empty!');

        $this->db->where('user_id', $user_id);
        $this->db->where('followingUser', $followingUser);
        $this->db->delete('userFollow');

        return true;
    }

    public function checkFollowingUser($followingUser, $user_id = 0) {
        // defaults to current logged in user
        if (empty($user_id))
            $user_id = $this->session->userdata('user_id');


        $user_id = intval($user_id);
        $followingUser = intval($followingUser);

        if (empty($user_id))
            throw new Exception('User ID is empty!');
        if (empty($followingUser))
            throw new Exception('Following user ID is empty!');

        $mtag = "checkFollowingUser-{$followingUser}-{$user_id}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {

            $this->db->from('userFollow');
            $this->db->where('user_id', $user_id);
            $this->db->where('followingUser', $followingUser);

            $data = $this->db->count_all_results();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        if ((int) $data > 0)
            return true;

        return false;
    }

    public function getFollowersCnt($user_id) {
        $user_id = intval($user_id);

        if (empty($user_id))
            throw new Exception('User ID is empty!');

        $mtag = "getFollowersCnt-{$user_id}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {

            $this->db->from('userFollow');
            $this->db->where('followingUser', $user_id);
            $this->db->where('active', 1);

            $data = $this->db->count_all_results();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }
    
    public function getFollowers($user_id) {
        $user_id = intval($user_id);

        if (empty($user_id))
            throw new Exception('User ID is empty!');

        $mtag = "getFollowers-{$user_id}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
            $query_str = "
                SELECT
                        uf.user_id
                    ,   uf.followingUser
                    ,   u.firstName
                    ,   u.lastName
                FROM userFollow uf
                INNER JOIN users AS u ON (u.user_id = uf.user_id)
                WHERE active = 1
                    AND uf.followingUser = $user_id
            ";
            $query = $this->db->query($query_str);
            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }
    
    public function getFollowing($user_id) {
        $user_id = intval($user_id);

        if (empty($user_id))
            throw new Exception('User ID is empty!');

        $mtag = "getFollowing-{$user_id}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
            $query_str = "
                SELECT
                        uf.user_id
                    ,   uf.followingUser
                    ,   u.firstName
                    ,   u.lastName
                FROM userFollow uf
                INNER JOIN users AS u ON (u.user_id = uf.followingUser)
                WHERE active = 1
                    AND uf.user_id = $user_id
            ";
            $query = $this->db->query($query_str);
            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function getFollowingCnt($user_id) {
        $user_id = intval($user_id);

        if (empty($user_id))
            throw new Exception('User ID is empty!');

        $mtag = "getFollowingCnt-{$user_id}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {

            $this->db->from('userFollow');
            $this->db->where('user_id', $user_id);
            $this->db->where('active', 1);

            $data = $this->db->count_all_results();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function updateProfileImg($user_id, $filename) {
        $user_id = intval($user_id);

        if (empty($user_id))
            throw new Exception("User ID is empty!");

        $data = array('profileimg' => $filename);

        $this->db->where('user_id', $user_id);
        $this->db->update('users', $data);

        return true;
    }

    public function createPhotoAlbum($user_id, $name, $stream = 0, $mobile = 0) {
        $user_id = intval($user_id);

        if (empty($user_id))
            throw new Exception('User ID is empty!');
        if (empty($name))
            throw new Exception('Album name is empty!');

        $data = array
            (
            'datestamp' => DATESTAMP,
            'company' => $this->config->item('bmsCompanyID'),
            'user_id' => $user_id,
            'name' => $name,
            'stream' => $stream,
            'mobile' => $mobile
        );

        $this->db->insert('userPhotoAlbums', $data);

        return $this->db->insert_id();
    }

    public function getAlbums($user_id, $id = 0) {
        $user_id = intval($user_id);

        if (empty($user_id))
            throw new Exception('User ID is empty!');

        $company = $this->config->item('bmsCompanyID');


        $mtag = "userPhotoAlbums-{$user_id}-{$id}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('id, datestamp, name');
            $this->db->from('userPhotoAlbums');
            $this->db->where('user_id', $user_id);
            $this->db->where('company', $company);

            if (!empty($id))
                $this->db->where('id', $id);

            $this->db->order_by('name');

            $query = $this->db->get();

            $results = $query->result();

            if (!empty($id))
                $data = $results[0];
            else
                $data = $results;

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function getAlbumPhotos($album, $limit = false) {
        //$userid = intval($userid);
        $album = intval($album);

        //if (empty($userid)) throw new Exception('User ID is empty!');
        if (empty($album))
            throw new Exception('Album ID is empty!');

        $mtag = "getAlbumPhotos-{$album}-{$limit}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->select('id, datestamp, userid, fileName');
            $this->db->from('albumPhotos');
            $this->db->where('posted', 1);
            //$this->db->where('userid', $userid);
            $this->db->where('album', $album);

            if ($limit !== false)
                $this->db->limit($limit);

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function insertAlbumPhoto($user_id, $album, $fileName, $caption = null) {
        $data = array
            (
            'datestamp' => DATESTAMP,
            'user_id' => $user_id,
            'uploadedBy' => $this->session->userdata('user_id'),
            'album' => $album,
            'fileName' => $fileName,
            'posted' => 0
        );

        if (!empty($caption))
            $data['caption'] = $caption;

        $this->db->insert('albumPhotos', $data);

        return $this->db->insert_id();
    }

    public function checkAlbumType($user_id, $type = 'stream') {
        $user_id = intval($user_id);

        if (empty($user_id))
            throw new Exception('User ID is empty!');
        if (empty($type))
            throw new Exception('Column Type ID is empty!');

        $mtag = "checkStreamPhotoAlbum-{$user_id}-{$type}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {

            $this->db->from('userPhotoAlbums');
            $this->db->where('user_id', $user_id);
            $this->db->where($type, 1);

            $data = $this->db->count_all_results();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        if ((int) $data > 0)
            return true;

        return false;
    }

    public function getAlbumTypeID($user_id, $type = 'stream') {
        $user_id = intval($user_id);

        if (empty($user_id))
            throw new Exception('User ID is empty!');
        if (empty($type))
            throw new Exception('Column Type ID is empty!');

        $mtag = "getAlbumTypeID-{$user_id}-{$type}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {

            $this->db->select('id');
            $this->db->from('userPhotoAlbums');
            $this->db->where('user_id', $user_id);
            $this->db->where($type, 1);

            $query = $this->db->get();

            $results = $query->result();

            $data = $results[0]->id;

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    public function sendImgToBMS($path, $fileName, $user_id) {
        $data = array
            (
            'user_id' => $user_id,
            'file' => "@./{$path}{$fileName}"
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->config->item('bmsUrl') . "user/albumphotoupload");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);

        curl_close($ch);
    }

    public function savePhotoComment($p) {
        $data = array
            (
            'datestamp' => DATESTAMP,
            'user_id' => $this->session->userdata('user_id'),
            'photoID' => $p['photoID']
        );

        if (!empty($p['post']))
            $data['body'] = $p['post'];

        $this->db->insert('photoComments', $data);

        return $this->db->insert_id();
    }

    public function getPhotoComments($photoID) {
        $photoID = intval($photoID);

        if (empty($photoID))
            throw new Exception('Photo ID is empty!');

        $mtag = "photoComments-{$photoID}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data) {
            $this->db->from('photoComments');
            $this->db->where('photoID', $photoID);
            $this->db->order_by('datestamp', 'desc');

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }
}