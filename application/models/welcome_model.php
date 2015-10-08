<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'search_model.php';

class welcome_model extends CI_Model
{
    /**
     * TODO: short description.
     *
     */
    function __construct ()
    {
        parent::__construct();
    }

    public function getFacebookID ($facebookID)
    {
        if (empty($facebookID)) throw new Exception("Facebook ID is empty!");

        $mtag = "fbUserCheck-{$facebookID}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->db->select('id');
            $this->db->from('users');
            $this->db->where('facebookID', $facebookID);

            $query = $this->db->get();

            $data = $query->result();

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }
    
        if (empty($data)) return false;

        return $data[0]->id;
    }

    public function checkLogin ($email, $passwd, $passwordHashed = false, $facebookID = 0)
    {
        if ($passwordHashed == false) $passwd = sha1($passwd);

        $this->db->select('user_id, status, admin, permissions');
        $this->db->from('users');
        $this->db->where_in('status', array(1,3));

        $this->db->where('email', $email);
        $this->db->where('passwd', $passwd);

        $query = $this->db->get();
        
        $results = $query->result();
//var_dump($this->db->last_query()); exit;
        if (empty($results)) return false;

        return $results[0];
    }
    
    public function createUser ()
    {
    	$p = $_POST;
    	
    	if (empty($p['email'])) throw new Exception('E-mail Address is empty!');
    
    	$search = new search_model();
    	
	    $data = array
	    (
	    	'email' => $p['email'],
	    	'passwd' => sha1($p['user_pass']),
	    	'firstName' => $p['firstName'],
	    	'lastName' => $p['lastName'],
	    	'username' => $p['username'],
	    	'timezone' => $search->grabGeoIP()->time_zone, 
	    	'status' => 1 	
	    );
	    if (!empty($p['facebookID'])) $data['facebookID'] = $p['facebookID'];
	    
	    require_once 'user_model.php';
	    $user = new user_model();
	    
	    $user_id = $user->save($data);
	    
		// assign user to company
		$this->assignUserToCompany($user_id);
		
		// insert default position
		$this->insertUserPosition($user_id);
		
		// insert default department
		$this->insertUserDepartment($user_id);
		
		return $user_id;
    }

	private function insertUserPosition ($userid)
	{
		$userid = intval($userid);
	    
	    if (empty($userid)) throw new Exception ("User id is empty!");
	
		$defaultPosition = $this->functions->getDefaultPosition();
		
		$data = array
	    (
	    	'userid' => $userid,
	    	'company' => $this->config->item('bmsCompanyID'),
	    	'position' => $defaultPosition	
	    );
	    
	    $this->db->insert('userCompanyPositions', $data);
	    
	    return $this->db->insert_id();
	}

	private function insertUserDepartment ($userid)
	{
		$userid = intval($userid);
	    
	    if (empty($userid)) throw new Exception ("User id is empty!");
	
		$defaultDepartment = $this->functions->getDefaultDepartment();
		
		$data = array
	    (
	    	'userid' => $userid,
	    	'company' => $this->config->item('bmsCompanyID'),
	    	'department' => $defaultDepartment	
	    );
	    
	    $this->db->insert('userCompanyDepartments', $data);
	    
	    return $this->db->insert_id();
	}
	
	public function assignUserToCompany ($userid)
	{
		$userid = intval($userid);
	    
	    if (empty($userid)) throw new Exception ("User id is empty!");
	    
		$data = array
		(
			'userid' => $userid,
			'company' => $this->config->item('bmsCompanyID'),
			'homeCompany' => 1
		);
		
		$this->db->insert('userCompanies', $data);
		
		return $this->db->insert_id();
	}
	
	 public function getIDFromEmail ($email)
    {
        if (empty($email)) throw new Exception("Email is empty!");

        $mtag = "UserIDFromEmail-{$email}";

        $data = $this->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->db->select('id');
            $this->db->from('users');
            $this->db->where('deleted', 0);
            $this->db->where('email', $email);

            $query = $this->db->get();

            $results = $query->result();

            $data = $results[0]->id;

            $this->cache->memcached->save($mtag, $data, $this->config->item('cache_timeout'));
        }

        if (empty($data)) return false;

        return $data;
    }

    public function updateUserPass ($user = null)
    {
        if (is_null($user)) throw new Exception("User ID is empty!");
        
        $tempPass = uniqid(null, false);

        $_POST['user_id'] = $user->user_id;
        $_POST['passwd'] = $tempPass;
        
        $this->users->save();

        return $tempPass;
    }
}