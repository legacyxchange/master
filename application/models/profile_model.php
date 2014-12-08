<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'abstract_model.php';

class profile_model extends abstract_model
{
    /**
     * TODO: short description.
     *
     */
    function __construct ()
    {
        parent::__construct();
    }
    
	public function getUserAssignedLocations ($userid)
	{
		$userid = intval($userid);
		
        if (empty($userid)) throw new Exception("User ID is empty!");

        $mtag = "userLocationIDs-{$userid}";

        $data = $this->cache->memcached->get($mtag);

        //if (!$data)
        if (true)
        {
            $this->db->select('location');
            $this->db->from('userLocations');
            $this->db->where('userid', $userid);

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }
        
        //print_r($data);
        
        $locationIDs = array();
        
        if (empty($data)) return false;
        
        foreach ($data as $r)
        {
        	$locationCompany = $this->functions->getLocationCompany($r->location);
        	
        	// only adds locations that are assigned to the company
        	if ($locationCompany == $this->config->item('bmsCompanyID'))
			{
	        	$locationIDs[] = $r->location;
	        }
        }

        return $locationIDs;
	}
	

	

    /**
     * TODO: short description.
     *
     * @return TODO
     */
    public function getStyles()
    {
        $mtag = "karateStyles";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->db->select('term_id, name');
            $this->db->from('wp_terms');
            $this->db->order_by('name', 'asc');

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }

    /**
     * TODO: short description.
     *
     * @param mixed $id 
     *
     * @return TODO
     */
    public function getAssignedStyles ($id)
    {
        if (empty($id)) throw new Exception("ID is empty");

        $mtag = "assignedKarateStyles-{$id}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->db->select('term_taxonomy_id');
            $this->db->from('wp_term_relationships');
            $this->db->where('object_id', $id);

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }
    
    public function insertLocationCode ($location, $group, $code)
    {
    	$location = intval($location);
    	$group = intval($group);
    	$code = intval($code);
    	
    	if (empty($location)) throw new Exception("Location ID is empty!");
		if (empty($group)) throw new Exception("group is empty!");
		if (empty($code)) throw new Exception("code is empty!");
		
	    $data = array
	    (
	    	'locationid' => $location,
	    	'group' => $group,
	    	'code' => $code
	    );
	    
	    $this->db->insert('locationCodes', $data);
	    
	    return $this->db->insert_id();
    }

    public function insertUserCode ($userid, $group, $code)
    {
    	$userid = intval($userid);
    	$group = intval($group);
    	$code = intval($code);
    	
    	if (empty($userid)) throw new Exception("User ID is empty!");
		if (empty($group)) throw new Exception("group is empty!");
		if (empty($code)) throw new Exception("code is empty!");
		
	    $data = array
	    (
	    	'userid' => $userid,
	    	'group' => $group,
	    	'code' => $code
	    );
	    
	    $this->db->insert('userCodes', $data);
	    
	    return $this->db->insert_id();
    }
    
    /**
     * Deprecated
     */
     /*
    public function insertPost ($p)
    {
        $post_name = strtolower($p['businessName']);
        $post_name = str_replace(' ', '-', $post_name);

        $post_name = preg_replace("/[^a-zA-Z0-9]+/", "", $post_name);

		$guid = '';

        if ($p['post_type'] == 'place')
        {
            $guid = "http://{$_SERVER['SERVER_NAME']}/wordpress/city/{$post_name}";
        }
        elseif ($p['post_type'] == 'attachment')
        {
            $guid = "http://{$_SERVER['SERVER_NAME']}/wordpress/wp-content/uploads/" . date('Y') . "/" . date('m') . "/{$post_name}";
        }
        elseif ($p['post_type'] == 'video')
        {
        	$guid = $p['url'];
	        
        }
        
        $data = array
            (
                'post_author' => $p['user_id'],
                'post_date' => DATESTAMP,
                'post_date_gmt' => DATESTAMP,
                'post_content' => $p['description'],
                'post_title' => $p['post_title'],
                'post_excerpt' => '',
                'post_status' => $p['post_title'],
                'comment_status' => 'open',
                'ping_status' => 'open',
                'post_name' => $post_name,
                'to_ping' => '',
                'pinged' => '',
                'post_modified' => DATESTAMP,
                'post_modified_gmt' => DATESTAMP,
                'post_content_filtered' => '',
                'post_parent' => $p['post_parent'],
                'guid' => $guid,
                'menu_order' => 0,
                'post_type' => $p['post_type'],
                'post_mime_type' => $p['post_mime_type'],
                'comment_count' => 0
            );


        $this->db->insert('wp_posts', $data);

        return $this->db->insert_id();
    }
    */
    
    public function  insertLocation ($p)
    {
	    $data = array
	    (
	    	'datestamp' => DATESTAMP,
	    	'createdBy' => $this->session->userdata('userid'),
	    	'company' => $this->config->item('bmsCompanyID'),
	    	'name' => $p['name'],
	    	'address' => $p['address'],
	    	'city' => $p['city'],
	    	'state' => $p['state'],
	    	'postalCode' => $p['postalCode'],
	    	'phone' => $p['phone'],
	    	'websiteUrl' => $p['website'],
	    	'email' => $p['email'],
	    	'description' => $p['description'],
	    	'lat' => $p['lat'],
	    	'lng' => $p['lng'],
	    	'googleID' => $p['googleID'],
            'googleReference' => $p['googleReference'],
			'lastUpdated' => DATESTAMP
	    );
	    
	    if (!empty($p['formattedAddress'])) $data['formattedAddress'] = $p['formattedAddress'];
	    if (!empty($p['googleHTMLAddress'])) $data['googleHTMLAddress'] = $p['googleHTMLAddress'];
	     
	    $this->db->replace('locations', $data);
	    
	    return $this->db->insert_id();
    }
    
    public function updateLocation ($p)
    {
		$p['id'] = intval($p['id']);
		
		if (empty($p['id'])) throw new Exception("Location ID is empty!");

	   	$data = array
	    (
	    	'name' => $p['name'],
	    	'address' => $p['address'],
	    	'city' => $p['city'],
	    	'state' => $p['state'],
	    	'postalCode' => $p['postalCode'],
	    	'phone' => $p['phone'],
	    	'websiteUrl' => $p['website'],
	    	'email' => $p['email'],
	    	'description' => $p['description'],
	    	'lat' => $p['lat'],
	    	'lng' => $p['lng'],
	    	'lastUpdated' => DATESTAMP
	    );
	    
	    if (!empty($p['googleID'])) $data['googleID'] = $p['googleID'];
	    if (!empty($p['googleReference'])) $data['googleReference'] = $p['googleReference'];
	  
	    
		if (!empty($p['formattedAddress'])) $data['formattedAddress'] = $p['formattedAddress'];
	    if (!empty($p['googleHTMLAddress'])) $data['googleHTMLAddress'] = $p['googleHTMLAddress'];
	    
	    $this->db->where('id', $p['id']);
	    $this->db->update('locations', $data);
	    
	    return true;
    }
    
    public function setLocationDeleted ($location)
    {
    	$location = intval($location);
    	
    	if (empty($location)) throw new Exception("Location ID is empty!");
    
        $data = array
	    (
	    	'deleted' => 1,
	    	'deletedBy' => $this->session->userdata('userid'),
	    	'deleteDate' => DATESTAMP
	    );
	    
	    $this->db->where('id', $location);
	    $this->db->update('locations', $data);
	    
	    return true;
    }
    
    public function setGoogleReference ($location, $p)
    {
    	$location = intval($location);
    	
    	if (empty($location)) throw new Exception("Location ID is empty!");
    

        // add location to google places
        $data = array
            (
                'lat' => $p['lat'],
                'lng' => $p['lng'],
                'name' => $p['name']
            );

        $googleData = $this->places->addPlace($data);

        if ($googleData->status !== 'OK') throw new Exception ("Unable to add location to Google Places: {$googleData->status}");
	
        $data = array
            (
                'googleID' => $googleData->id,
                'googleReference' => $googleData->reference
            );

        $this->db->where('id', $location);
        $this->db->update('locations', $data);

        return true;
    }


	public function insertUserLocation($userid, $location, $homeLocation = 0)
	{
		$userid = intval($userid);
		$loation = intval($location);
		
		
		if (empty($userid)) throw new Exception("User ID is empty!");
		if (empty($location)) throw new Exception("Location ID is empty!");
	
		$data = array
		(
			'location' => $location,
			'userid' => $userid,
			'homeLocation' => $homeLocation
		);
		
		$this->db->insert('userLocations', $data);
		
		return $this->db->insert_id();
	}
	
	public function clearLocationCodes ($location, $group = 0)
	{
		$loation = intval($location);
		$group = intval($group);

		if (empty($location)) throw new Exception("Location ID is empty!");

		if (!empty($group)) $this->db->where('group', $group); // deletes only a certain group if specified
		
		$this->db->where('locationid', $location);
		$this->db->delete('locationCodes');

		return true;
	}
	
	public function clearUserCodes ($userid, $group = 0)
	{
		$userid = intval($userid);
		$group = intval($group);

		if (empty($userid)) throw new Exception("User ID is empty!");

		if (!empty($group)) $this->db->where('group', $group); // deletes only a certain group if specified
		
		$this->db->where('userid', $userid);
		$this->db->delete('userCodes');

		return true;
	}
	
	public function insertLocationVideo ($p)
	{
		$p['location'] = intval($p['location']);
		
		if (empty($p['location'])) throw new Exception("Location ID is empty!");
		
		$data = array
		(
			'userid' => $this->session->userdata('userid'),
			'locationid' => $p['location'],
			'company' => $this->config->item('bmsCompanyID'),
			'datestamp' => DATESTAMP,
			'url' => $p['url'],
			'videoOrder' => $p['order'],
			'title' => $p['title'],
			'thumbnail' => $p['thumbnail'],
			'description' => $p['description'],
			'videoID' => $p['videoID']
		);
		
		$this->db->insert('locationYouTubeVideos', $data);
		
		return $this->db->insert_id();
	}
	
	public function clearLocationImage ($location, $id = 0)
	{
		$location = intval($location);
		$id = intval($id);
		
		if (empty($location)) throw new Exception ('Location ID is empty!');
		
		$this->db->where('locationid', $location);
		
		if (!empty($id)) $this->db->where('id', $id); // to delete a specific image for a location - else deletes all images
		
		$this->db->delete('locationImages');
	}
	
	public function insertLocationImage ($p)
	{
		$p['location'] = intval($p['location']);
		
		if (empty($p['location'])) throw new Exception("Location ID is empty!");

		$data = array
		(
			'locationid' => $p['location'],
			'userid' => $this->session->userdata('userid'),
			'company' => $this->config->item('bmsCompanyID'),
			'datestamp' => DATESTAMP,
			'fileName' => $p['fileName'],
			'imgOrder' => $p['order']
		);

		$this->db->insert('locationImages', $data);
		
		return $this->db->insert_id();
	}
	
	
	public function clearLocationReviews ($location, $autoImportedOnly = false)
	{
		$location = intval($location);

		if (empty($location)) throw new Exception ('Location ID is empty!');
		
		
		if ($autoImportedOnly) $this->db->where('autoImported', 1);
	
		$this->db->where('location', $location);
		$this->db->delete('locationReviews');
	}
	
	/**
	* Gets next cnt order for adding images
	*/
	public function getNextImgOrder ($location)
	{
		$location = intval($location);
		
		if (empty($location)) throw new Exception("Location ID is empty!");
		
		$mtag = "nextImgOrder-{$location}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->db->select_max('imgOrder');
            $this->db->from('locationImages');
            $this->db->where('locationid', $location);

            $query = $this->db->get();

			$results = $query->result();

            $data = (int) $results[0]->imgOrder;

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }
        
        if (empty($data)) return 0; // if no images have been uploaded - starts at 0

        return $data + 1;
	}
	
	public function deleteImage ($location, $id, $fileName)
	{
		$location = intval($location);
		$id = intval($id);
		
		if (empty($location)) throw new Exception ('Location ID is empty!');
		if (empty($id)) throw new Exception('Image row ID is empty!');
		if (empty($fileName)) throw new Exception('File name is empty!');
		
		$path = $_SERVER['DOCUMENT_ROOT'] . "public/uploads/locationImages/{$location}/";
		
		
		if (file_exists($path . $fileName))
		{
			$del = unlink($path . $fileName);
			
			if ($del === false) throw new Exception("Unable to delete image ({$path}{$fileName})");
		}
		
		// removes row for DB
		$this->db->where('id', $id);
		$this->db->where('locationid', $location);
		$this->db->delete('locationImages');
		
		return true;
	}

	// deprecated
	/*
    public function updatePost ($p)
    {
        if (empty($p['id'])) throw new Exception("POST ID is empty");

        $post_name = strtolower($p['businessName']);
        $post_name = str_replace(' ', '-', $post_name);

        $post_name = preg_replace("/[^a-zA-Z0-9]+/", "", $post_name);
		
		$guid = '';

        if ($p['post_type'] == 'place')
        {
            $guid = "http://{$_SERVER['SERVER_NAME']}/wordpress/city/{$post_name}";
        }
        elseif ($p['post_type'] == 'attachment')
        {
            $guid = "http://{$_SERVER['SERVER_NAME']}/wordpress/wp-content/uploads/" . date('Y') . "/" . date('m') . "/{$post_name}";
        }
        elseif ($p['post_type'] == 'video')
        {
        	$guid = $p['url'];
	        
        }

        $data = array
            (
                'post_author' => $p['user_id'],
                'post_content' => $p['description'],
                'post_title' => $p['post_title'],
                'post_excerpt' => '',
                'post_status' => $p['post_status'],
                'comment_status' => 'open',
                'ping_status' => 'open',
                'post_name' => $post_name,
                'to_ping' => '',
                'pinged' => '',
                'post_modified' => DATESTAMP,
                'post_modified_gmt' => DATESTAMP,
                'post_content_filtered' => '',
                'post_parent' => $p['post_parent'],
                'guid' => $guid,
                'menu_order' => 0,
                'post_type' => $p['post_type'],
                'post_mime_type' => $p['post_mime_type'],
                'comment_count' => 0
            );


        $this->db->where('ID', $p['id']);
        $this->db->update('wp_posts', $data);

        return true;
    }
    */

    /**
	* deprecated
     */
     /*
    public function savePostMeta ($post_id, $key, $value)
    {
        // check if row exists
        $check = $this->checkPostMetaRow($post_id, $key);

        if ($check === true)
        {
            // update row
            $this->updatePostMeta($post_id, $key, $value);
        }
        else
        {
            // insert row
            $this->insertPostMeta($post_id, $key, $value);
        }

        return true;
    }
	*/
	
    /**
     * Deprecated - Inserts a new row into postmeta table
     */
     /*
    public function insertPostMeta ($post_id, $key, $value)
    {
        $data = array
            (
                'post_id' => $post_id,
                'meta_key' => $key,
                'meta_value' => $value
            );

        $this->db->insert('wp_postmeta', $data);

        $this->db->insert_id();
    }
	*/
    /**
     * TODO: short description.
     *
     * @param mixed $post_id 
     * @param mixed $key     
     * @param mixed $value   
     *
     * @return TODO
     */
    public function updatePostMeta ($post_id, $key, $value)
    {
        $data = array('meta_value' => $value);

        $this->db->where('meta_key', $key);
        $this->db->where('post_id', $post_id);
        $this->db->update('wp_postmeta', $data);

        return true;
    }

    /**
     * DEPRECATED - checks if a metakey exists in postmeta
     */
     /*
    private function checkPostMetaRow ($post_id, $key)
    {
        $mtag = "postMetaRow-{$post_id}-{$key}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->db->from('wp_postmeta');
            $this->db->where('post_id', $post_id);
            $this->db->where('meta_key', $key);

            $data = $this->db->count_all_results();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        if ($data > 0) return true;

        return false;
    }
	*/
	
    /**
     * DEPRECATED
     */
     /*
    public function insertPostTerm ($post_id, $term_id)
    {
        $data = array
            (
                'object_id' => $post_id,
                'term_taxonomy_id' => $term_id,
                'term_order' => 0
            );

        $this->db->insert('wp_term_relationships', $data);

        return true;
    }
    */

    /**
     * DEPRECATED clears styles related to a location
     */
     /*
    public function clearPostTerms ($post_id)
    {
        $this->db->where('object_id', $post_id);
        $this->db->delete('wp_term_relationships');

        return true;
    }
    */

    /**
     * DEPRECATED
     */
     /*
    public function getPostAttachements ($post_id)
    {
        if (empty($post_id)) throw new Exception("Post ID is empty!");

        $mtag = "listingAttachments-{$post_id}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->db->select('ID');
            $this->db->from('wp_posts');
            $this->db->where('post_type', 'attachment');
            $this->db->where('post_parent', $post_id);

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        return $data;
    }
    */
    /**
    * removes Video from database
    */
    public function deleteVideo ($location, $id)
    {
    	$location = intval($location);
	    $id = intval($id);
	    
	    if (empty($location)) throw new Exception("Location ID is empty!");
	    if (empty($id)) throw new Exception("Video ROW ID is empty!");
	    
	    $this->db->where('locationid', $location); // can only delete videos for given location
	    $this->db->where('id', $id);
	    $this->db->delete('locationYouTubeVideos');
	    
	    return true;
    }
    
    public function clearFacebookID ($userid)
    {
    	$userid = intval($userid);
    	
    	if (empty($userid)) throw new Exception("UserID is empty!");
    
	    $data = array('facebookID', 0);
	    
	    $this->db->where('id', $userid);
	    $this->db->update('users', $data);
	    
	    return true;
    }
    
    public function updateFacebookID ($userid, $facebookID)
    {
        $userid = intval($userid);
    	
    	if (empty($userid)) throw new Exception("UserID is empty!");
    
	    $data = array('facebookID' => $facebookID);
	    
	    $this->db->where('id', $userid);
	    $this->db->update('users', $data);
	    
	    return true;
    }
    
    public function updateImgOrder ($location, $id, $order = 0)
    {
	    $location = intval($location);
	    $id = intval($id);
	    $order = intval($order);
	    
	    if (empty($location)) throw new Exception("Location ID is empty!");
	    if (empty($id)) throw new Exception("Image row ID is empty!");
	    
	    $data = array('imgOrder' => $order);
	    
	    $this->db->where('id', $id);
	    $this->db->where('locationid' , $location);
	    $this->db->update('locationImages', $data);
	    
	    return true;
    }
    
    /**
    * checks if an email address is already in use in the BMS system
    */
    public function checkEmailAvailable ($email)
    {
	    if (empty($email)) throw new Exception('Email Address is empty!');
	    
	    $mtag = "checkEmailAvailable-{$email}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
        	$this->db->from('users');
        	$this->db->where('email', $email);
        	
        	$data = $this->db->count_all_results();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }
	    
	    if ((int) $data > 0) return false; // email is already in use
	    
	    return true;
    }
    
    public function updateUserInfo ($p)
    {
    	$p['user_id'] = intval($p['user_id']);
    	$p['heightFeet'] = intval($p['heightFeet']);
    	$p['heightInches'] = intval($p['heightInches']);
    	$p['weight'] = intval($p['weight']);
    
    	if (empty($p['user_id'])) throw new Exception('User ID is empty!');
    
	    $data = array
	    (
	    	'firstName' => $p['firstName'],
	    	'lastName' => $p['lastName'],
	    	'email' => $p['email'],
	    	'timezone' => $p['timezone'],
	    	'companyWebsiteUrl' => $p['website'],
	    	'bio' => $p['bio'],
	    	'dob' => $dob,
	    	'gender' => $p['gender'],
	    	'heightFeet' => $p['heightFeet'],
	    	'heightInches' => $p['heightInches'],
	    	'weight' => $p['weight'],
	    	'weightType' => $p['weightType']
	    	
	    );
	    
	    $this->db->where('user_id', $p['user_id']);
	    $this->db->update('users', $data);
	    
	    return true;
    }
    
    /**
    * uploads file to BMS
    */ 
    public function sendAvatarToBMS ($path, $fileName)
    {
    	$data = array
    	(
            'userid' => $this->session->userdata('userid'),
            'file' => "@./{$path}{$fileName}"
    	);
    
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->config->item('bmsUrl') . "user/externalimgupload");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);

        curl_close($ch);
    }
    
     /**
     * Downloads main image from facebook
     *
     * @param mixed $url 
     *
     * @return TODO
     */
    public function downloadfbphoto ($user, $url)
    {
        $user = intval($user);

        if (empty($user)) throw new Exception("User ID is empty!");

        if (empty($url)) throw new Exception("URL is empty, nothing to download!");

        //$path = 'public' . DS . 'uploads' . DS . 'profileimgs' . DS;
		$path = 'public' . DS . 'uploads' . DS . 'avatars' . DS . $this->session->userdata('userid') . DS; 

        // ensures company uploads directory has been created
        $this->functions->createDir($path);


        $path = $_SERVER['DOCUMENT_ROOT'] . 'public' . DS . 'uploads' . DS . 'avatars' . DS . $this->session->userdata('userid') . DS; 

        $ext = PHPFunctions::getFileExt($url);

        $filename = uniqid() . '_' . date("YmdGis") . '.' . $ext;

        $getContents = file_get_contents($url);

        if ($getContents === false) throw new Exception("Unable to get file content from: {$url}");

        $put = file_put_contents(($path.$filename), $getContents);

        if ($put === false) throw new Exception("Unable to save contents of ({$url}) to: {$path}{$filename}");

		//$this->updateProfileImg($user, $filename);

		/*
        $data = array('profileimg' => $filename);

        $this->db->where('id', $user);
        $this->db->update('users', $data);
		*/

        return $filename;

    }
}
