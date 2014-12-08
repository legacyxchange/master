<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'Library.php';

class Users extends Library
{

    public function __construct()
    {
        parent::__construct();

        $this->tableName = 'users';
    }


    /**
     * Gets a users name
     *
     * @param mixed $id 
     *
     * @return String - "[firstName] [lastName]"
     */
    public function getName ($id)
    {
        if (empty($id)) throw new Exception('user id is empty!');

        $mtag = "usersName-{$id}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data)
        {
			$this->ci->load->database();
			
            $this->ci->db->select('firstName, lastName');
            $this->ci->db->from('users');
            $this->ci->db->where('deleted', 0);
            $this->ci->db->where('id', $id);

            $query = $this->ci->db->get();

            $results = $query->result();

            $data =  "{$results[0]->firstName} {$results[0]->lastName}";

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));

        }
        
        
        return $data;
    }


    /**
     * Gets the users timezone
     *
     * @param INT $id - userid
     *
     * @return String - users timezone
     */
    public function getTimezone ($id)
    {

        if (empty($id)) throw new Exception('user id is empty!');

        $ci =& get_instance();

        $ci->load->driver('cache');

        $mtag = "userTimezone-{$id}";

        $data = $ci->cache->memcached->get($mtag);

        if (empty($data))
        {
            $ci->db->select('timezone');
            $ci->db->from('users');
            $ci->db->where('deleted', 0);
            $ci->db->where('id', $id);

            $query = $ci->db->get();

            $results = $query->result();

            $data =  $results[0]->timezone;

            $ci->cache->memcached->save($mtag, $data, $ci->config->item('cache_timeout'));
        }
		
        return $data;
    }


    /**
     * TODO: short description.
     *
     * @param mixed $id 
     * @param mixed $inputDate - Date in UTC time
     *
     * @return TODO
     */
    public function convertTimezone ($user, $inputDate, $returnFormat = "Y-m-d G:i:s")
    {
        if (empty($user)) return date($returnFormat, strtotime($inputDate));
        
        if (empty($inputDate)) throw new Exception('please enter an input date to convert');

        $timezone = $this->getTimezone($user);

		if (is_numeric($inputDate))
		{
			$datetime = new DateTime();
			$datetime->setTimestamp($inputDate);
		}
		else
		{
			 $datetime = new DateTime($inputDate);
		}
       

        $convertTime = new DateTimeZone($timezone);

        $datetime->SetTimezone($convertTime);

        return $datetime->format($returnFormat);
    }

    /**
     * Converts a datestamp entered by a user back to UTC timezone
     *
     * @param mixed $user 
     * @param mixed $date 
     *
     * @return TODO
     */
    public function convertTimeBacktoUTC ($user, $date, $returnFormat = "Y-m-d H:i:s")
    {
        if (empty($user)) throw new Exception('User ID is empty!');
        if (empty($date)) throw new Exception('please enter an input date to convert');

        // first gets the users time zone - for example America/Los Angelas -8 UTC
        $timezone = $this->getTimezone($user);

        $datetime = new DateTime($date, new DateTimeZone($timezone));

        // convertTime which should be back to UTC
        $convertTime = new DateTimeZone(date_default_timezone_get());

        $datetime->SetTimezone($convertTime);

        return $datetime->format($returnFormat);
    }


    /**
     * Checks if an emamil is available
     *
     * @return boolean
     */
    public function checkEmailAvailable ($email)
    {
        if (empty($email)) throw new Exception('email is empty');

        $this->ci->db->from('users');
        $this->ci->db->where('email', $email);
        $this->ci->db->where('deleted', 0);

        if ($this->ci->db->count_all_results() == 0) return true;

        return false;
    }

    /**
     * Gets ID and Name of every user in company
     *
     * @param mixed $company Optional, defaults to 0. 
     *
     * @return array->object
     */
    public function getUsers($company = 0)
    {
        if (empty($company)) $company = $this->ci->session->userdata('company');

        $mtag = "userList-{$company}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->ci->db->select("id, firstName, lastName");
            $this->ci->db->from('users');
            $this->ci->db->where('status', 1);
            $this->ci->db->where('deleted', 0);
            $this->ci->db->order_by('firstName, lastName', 'asc');

            $query = $this->ci->db->get();

            $data = $query->result();

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        return $data;
    }

    /**
     * checks if user is user is an admin of the site. ****This is full access to everything!!!****
     *
     * @param mixed $userid Optional, defaults to 0. 
     *
     * @return boolean - true if admin
     */
    public function isAdmin ($userid = 0)
    {
        if (empty($userid))
        {
            // checks session if user is admin if no userid is passed
            if ($this->ci->session->userdata('admin') == true) return true;
        }
        else
        {
            // checks the userID that is passed whether they are an admin or not

            $userid = intval($userid);

            if (empty($userid)) throw new Exception("User ID is empty!");

            $admin = $this->getTableValue('admin', $userid);

            if ($admin > 0) return true;
        }

        return false;
    }

    /**
     * Checks if a user is a company admin (that is different from a site admin!)
     *
     * @param mixed $user    
     * @param mixed $company 
     *
     * @return boolean - true if they are a company admin
     */
    public function isCompanyAdmin ($user, $company)
    {
        if (empty($user)) throw new Exception("User ID is empty!");
        if (empty($company)) throw new Exception("Company ID is empty!");

        $mtag = "isCompanyAdmin-{$user}-{$company}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data)
        {
        	$this->ci->load->database();
        	
            $this->ci->db->from('companyAdmins');
            $this->ci->db->where('userid', $user);
            $this->ci->db->where('company', $company);

            $data = $this->ci->db->count_all_results();

			$this->ci->db->close();


            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        // checks if overall admin
        $sudoAdmin = $this->isAdmin($user);

        if ($sudoAdmin == true) return true;

        if ($data > 0) return true;

        return false;
    }

    /**
     * TODO: short description.
     *
     * @param mixed $user    
     * @param mixed $company 
     *
     * @return TODO
     */
    public function isCompanyEditor ($user, $company)
    {
        if (empty($user)) throw new Exception("User ID is empty!");
        if (empty($company)) throw new Exception("Company ID is empty!");

        $mtag = "isCompanyEditor-{$user}-{$company}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->ci->db->from('companyEditors');
            $this->ci->db->where('userId', $user);
            $this->ci->db->where('company', $company);

            $data = $this->ci->db->count_all_results();

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }


        if ($data > 0) return true;

        return false;

    }

    /**
     * Gets a user ID based upon the e-mail address
     *
     * @param mixed $email 
     *
     * @return INT - userid
     */
    public function getIDFromEmail ($email)
    {
        if (empty($email)) throw new Exception("Email is empty!");


        $mtag = "UserIDFromEmail-{$email}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->ci->db->select('id');
            $this->ci->db->from('users');
            $this->ci->db->where('deleted', 0);
            $this->ci->db->where('email', $email);

            $query = $this->ci->db->get();

            $results = $query->result();

            $data = $results[0]->id;

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));

        }

        if (empty($data)) return false;

        return $data;
    }

    /**
     * gets a users position for a paticular company
     *
     * @return int
     */
    public function getPosition ($user = 0, $company = 0)
    {
        if (empty($user)) $user = $this->ci->session->userdata('userid');

        if (empty($company)) $company = $this->ci->session->userdata('company');

        $mtag = "usercompposition-{$user}-{$company}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->ci->db->select("position");
            $this->ci->db->from('userCompanyPositions');
            $this->ci->db->where('userid', $user);
            $this->ci->db->where('company', $company);

            $query = $this->ci->db->get();

            $results = $query->result();

            $data = $results[0]->position;

            if (empty($data)) return false;

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        return $data;
    }

    /**
     * gets a users department for a paticular company
     *
     * @return int
     */
    public function getDepartment ($user = 0, $company = 0)
    {
        if (empty($user)) $user = $this->ci->session->userdata('userid');

        if (empty($company)) $company = $this->ci->session->userdata('company');

        $mtag = "userCompDep-{$user}-{$company}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->ci->db->select("department");
            $this->ci->db->from('userCompanyDepartments');
            $this->ci->db->where('userid', $user);
            $this->ci->db->where('company', $company);

            $query = $this->ci->db->get();

            $results = $query->result();

            $data = $results[0]->department;

            if (empty($data)) return false;

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        return $data;
    }


    /**
     * TODO: short description.
     *
     * @param mixed $user    
     * @param mixed $company 
     *
     * @return TODO
     */
    public function checkClockedIn ($user = 0, $company = 0)
    {
        if (empty($user)) $user = $this->ci->session->userdata('userid');
        if (empty($company)) $company = $this->ci->session->userdata('company');

        if (empty($user)) throw new Exception("Userid is empty!");
        if (empty($company)) throw new Exception("company ID is empty!");

        $mtag = "userCompClockIn-{$user}-{$company}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->ci->db->from('userTimePunch');
            $this->ci->db->where('userid', $user);
            $this->ci->db->where('company', $company);

            $data = $this->ci->db->count_all_results();
        }

            return ($data % 2) ? true : false;


        return false;
    }

    /**
     * Checks if the user is clocked in to any companys
     *
     * @return boolean
     */
    public function checkAllClockedIn ($user = 0)
    {
        if (empty($user)) $user = $this->ci->session->userdata('userid');
        if (empty($user)) throw new Exception("Userid is empty!");

        $user = intval($user);

        // $companies = $this->ci->companies->getCompanies($user);
        $companies = $this->ci->companies->getUserAssignedCompanies($user);

        if (!empty($companies))
        {

            $clockedInComp = 0;

            foreach ($companies as $r)
            {
                $clockedIn = $this->checkClockedIn($user, $r->company);

                if ($clockedIn == true)
                {
                    // user is clocked in to that company
                    $clockedInComp = $r->company;
                    break;
                }
            }

            if (!empty($clockedInComp)) return $clockedInComp;
        }

        return false;
    }

    /**
     * TODO: short description.
     *
     * @return TODO
     */
    public function getYouTubeVideos ($user = 0, $company = 0)
    {
        if (empty($user)) $user = $this->ci->session->userdata('userid');
        if (empty($company)) $company = $this->ci->session->userdata('company');

        $mtag = "userYouTubeVideos-{$user}-{$company}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->ci->db->select("id, url");
            $this->ci->db->from('userYouTubeVideos');
            $this->ci->db->where('userid', $user);
            $this->ci->db->where('company', $company);
            $this->ci->db->order_by('videoOrder', 'ASC');

            $query = $this->ci->db->get();

            $data = $query->result();

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        return $data;
    }

    /**
     * checks if the user being passed is in the logged in users downline
     * basically are they "underneath" them within the organization
     *
     * @param int $user 
     *
     * @return boolean - TRUE if they are in downline
     */
    public function inDownline ($user)
    {
        $user = intval($user);

        if (empty($user)) throw new Exception("User ID for user being check in downline is empty!");

        $position = $this->getPosition($this->ci->session->userdata('userid'), $this->ci->session->userdata('company'));

        $usersPosition = $this->getPosition($user, $this->ci->session->userdata('company'));

        // gets logged in users child positions
        $childPositions = $this->ci->positions->getChildPositions($position);

        $isChild = false;

        if (!empty($childPositions))
        {
            foreach ($childPositions as $r)
            {

                // they are a child position;
                if ((int) $usersPosition == (int) $r->childPosition)
                {
                    $isChild = true;
                    break;
                }
            }
        }


        if ($isChild) return true;

        return false;
    }

    /**
     * updates the user col to set the braintree customer ID
     *
     * @param mixed $BTCustomerID 
     * @param mixed $user         
     *
     * @return TODO
     */
    public function updateBTCustomerID ($BTCustomerID, $user)
    {
        if (empty($BTCustomerID)) throw new Exception("BrainTree Customer ID is empty");
        if (empty($user)) throw new Exception("User ID is empty!");

        $data = array('BrainTreeCustomerID' => $BTCustomerID);

        $this->ci->db->where('id', $user);
        $this->ci->db->update('users', $data);


        return true;
    }

    public function saveCCToken ($user, $number, $token)
    {
        if (empty($user)) throw new Exception("User ID is empty!");
        if (empty($number)) throw new Exception("Card number is empty!");
        if (empty($token)) throw new Exception("BrainTree Credit Card Token is empty!");


        $cardType = (int) substr($number, 0, 1);
        $lastFour = (int) substr($number, -4);

        if (empty($cardType)) throw new Exception("Card Type is empty!");
        if (empty($lastFour)) throw new Exception("last four digits of card is empty!");

        $data = array
            (
                'userid' => $user,
                'cardType' => $cardType,
                'lastFour' => $lastFour,
                'token' => $token,
            );

        $this->ci->db->insert('userTokens', $data);

        return $this->ci->db->insert_id();
    }

    /**
     * TODO: short description.
     *
     * @param mixed $user  
     * @param mixed $subId 
     * @param mixed $price Optional, defaults to 0. 
     *
     * @return TODO
     */
    public function updateSubscriptionInfo ($user, $subId, $price = 0)
    {
        if (empty($user)) throw new Exception("User ID is empty!");
        // if (empty($subId)) throw new Exception("Subscription ID is empty!");


        $data = array('BrainTreeSubscriptionID' => $subId);

        // if (!empty($price)) $data['subscriptionPrice'] = $price;
        $data['subscriptionPrice'] = $price;

        $this->ci->db->where('id', $user);
        $this->ci->db->update('users', $data);

        return true;
    }

    public function getCardTokenByUserID ($id)
    {
        if (empty($id)) throw new Exception("Card ID for token is empty!");

        // $mtag = "userCardTokenByUserID-{$id}";

        // $data = $this->ci->cache->memcached->get($mtag);

        // if (!$data)
        // {
            $this->ci->db->select('token');
            $this->ci->db->from('userTokens');
            $this->ci->db->where('userid', $id);

            $query = $this->ci->db->get();

            $results = $query->result();

            // $data = $results->token;

            // $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));

        // }

        return $results;
    }

    /**
     * Check if a users password is valid
     *
     * @param mixed $user
     * @param mixed $password 
     *
     * @return boolean - true if valid, else false
     */
    public function checkPassword ($user, $password)
    {
        if (empty($user)) throw new Exception("User ID is empty!");
        if (empty($password)) throw new Exception("Password is empty!");

        $dbPassword = $this->getTableValue('passwd', $user);

        if (sha1($password) == $dbPassword) return true;

        return false;
    }

    public function deleteCCfromDB($token)
    {
        if (empty($token)) throw new Exception("Card ID is missing!");

        $this->ci->db->where('token', $token);
        $this->ci->db->delete('userTokens');

        return 'SUCCESS';
    }

    /**
     * TODO: short description.
     *
     * @param mixed $facebookID 
     *
     * @return TODO
     */
    public function getUserIDFromFacebookID ($facebookID)
    {
        if (empty($facebookID)) throw new Exception("Facebook ID is empty!");

        $mtag = "userIDFromFacebookID-{$facebookID}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->ci->db->select('id, status, admin');
            $this->ci->db->from('users');
            $this->ci->db->where('facebookID', $facebookID);
            $this->ci->db->where('deleted', 0);
            $this->ci->db->where_in('status', array(1,3));

            $query = $this->ci->db->get();

            $results = $query->result();

            $data = $results[0];

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        if (empty($data)) return false;

        return $data;
    }

    /**
     * Checks if a facebookid has been linked to a user account
     *
     * @param mixed $facebookID 
     *
     * @return boolean - true if already linked
     */
    public function checkFacebookIDLinked ($facebookID)
    {
        if (empty($facebookID)) throw new Exception("Facebook ID is empty!");

        $mtag = "fbIDLinked-{$facebookID}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->ci->db->from('users');
            $this->ci->db->where('deleted', 0);
            $this->ci->db->where('facebookID', $facebookID);

            $data = $this->ci->db->count_all_results();

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        if ((int) $data > 0) return true;


        return false;
    }

}
