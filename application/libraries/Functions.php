<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once './application/third_party/phpfunctions/libraries/PHPFunctions.php';

/**
 * TODO: short description.
 *
 * TODO: long description.
 *
 */
class Functions extends PHPFunctions {

    private $ci;
    private $site_name = 'legacyXchange';
    public $useImage = TRUE;
    private $site_logo = '<img src="/public/images/logo.png" />';

    public function __construct() {
        $this->ci = & get_instance();

        // $this->ci->load->library('session');
        // if connect to DB
        if (class_exists('CI_DB')) {
            
        }

        $args = array
            (
            'min_version' => $this->ci->config->item('min_version'),
            'min_debug' => $this->ci->config->item('min_debug')
        );

        parent::__construct($args);
    }

    /**
     *      * Saves stack trace error in error log
     */
    /*
      public function sendStackTrace($e)
      {
      $ci =& get_instance();

      $body = "Stack Trace Error:\n\n";
      $body .= "URL: {$_SERVER["SERVER_NAME"]}{$_SERVER["REQUEST_URI"]}\n";
      $body .= "Referer: {$_SERVER['HTTP_REFERER']}\n";
      $body .= "User ID: {$ci->session->userdata('userid')}\n\n";
      $body .= "Message: " . $e->getMessage() . "\n\n";
      $body .= $e;

      error_log($body);
      }
     */

    /**
     * TODO: short description.
     *
     * @param mixed $address 
     *
     * @return TODO
     */
    public function getAddressLatLng($address) {
        $results = $this->geoCodeAddress($address);

        $results = json_decode($results);

        return $results->results[0]->geometry->location;
    }

    /**
     * TODO: short description.
     *
     * @param mixed $address 
     *
     * @return TODO
     */
    public function geoCodeAddress($address) {
        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&sensor=true";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, false);

        $results = curl_exec($ch);

        if ($results === false)
            throw new Exception("Unable to Curl Address ({$url})! " . curl_error($ch));

        curl_close($ch);

        return $results;
    }

    /**
     * TODO: short description.
     *
     * @param mixed $lat1 
     * @param mixed $lon1 
     * @param mixed $lat2 
     * @param mixed $lon2 
     * @param mixed $unit 
     *
     * @return TODO
     */
    public function distance($lat1, $lon1, $lat2, $lon2, $unit = null) {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } elseif ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    /**
     * TODO: short description.
     *
     * @param mixed $status 
     * @param mixed $msg    
     * @param mixed $id     Optional, defaults to 0. 
     * @param mixed $html   Optional, defaults to null. 
     *
     * @return TODO
     */
    /*
      public function jsonReturn ($status, $msg, $id = 0, $html = null, $additionalParams = array())
      {
      $return['status'] = $status;
      $return['msg'] = $msg;

      if (!empty($id)) $return['id'] = $id;

      if (!empty($html)) $return['html'] = $html;

      echo json_encode($return);

      exit;
      }
     */

    /**
     * TODO: short description.
     *
     * @return TODO
     */
    public function getCountryList() {
        $this->ci->load->driver('cache');

        $mtag = 'countryList';

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data) {
            $this->ci->db->select('iso2, short_name');
            $this->ci->db->from('countries');
            $this->ci->db->order_by('short_name', 'asc');

            $query = $this->ci->db->get();

            $data = $query->result();

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        return $data;
    }

    public function getUserInfo($user_id) {
        $userid = intval($user_id);

        if (empty($user_id))
            throw new Exception("User id is empty!");

        $this->ci->load->driver('cache');

        $mtag = "userInfo-{$user_id}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data) {
            $this->ci->db->from('users');
            $this->ci->db->where('user_id', $userid);

            $query = $this->ci->db->get();

            $results = $query->result();

            $data = $results[0];

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }
        
        return $data;
    }

    /**
     * gets a users name. Ex: William Gallios
     */
    public function getUserName($userid) {
        $userid = intval($userid);

        if (empty($userid))
            throw new Exception("User id is empty!");

        $mtag = "userName-{$userid}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data) {
            $this->ci->db->select('firstName, lastName');
            $this->ci->db->from('users');
            $this->ci->db->where('id', $userid);

            $query = $this->ci->db->get();

            $results = $query->result();

            $data = $results[0]->firstName . ' ' . $results[0]->lastName;

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        return $data;
    }

    public function checkLoggedIn($loginRedirect = true) {
        $ci = & get_instance();
        
        if ($ci->session->userdata('logged_in') === true) {
        	return true;
        } else {
        	$_SESSION['redirectUri'] = $_SERVER['REQUEST_URI'];
        	$ci->session->set_flashdata('NOTICE', 'You must login first');
        	$_SESSION['showLogin'] = true;
        	header("Location: /");
        	exit;
        }
    }

    public function checkSudoLoggedIn() {
    	$ci = & get_instance();
        
        if ($ci->session->userdata('logged_in') === true && $ci->session->userdata('permissions') > 0) {
        	return true;
        } else {
        	$_SESSION['redirectUri'] = $_SERVER['REQUEST_URI'];
        	$ci->session->set_flashdata('NOTICE', 'You must login first');
        	$_SESSION['showLogin'] = true;
        	header("Location: /");
        	exit;
        }
    }
    
    public function getFacebookID($user_id) {
        if (empty($user_id))
            throw new Exception("User ID is empty!");

        $mtag = "userFBID-{$user_id}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data) {
            $this->ci->db->select('facebookID');
            $this->ci->db->from('users');
            $this->ci->db->where('user_id', $user_id);

            $query = $this->ci->db->get();

            $results = $query->result();

            $data = $results[0]->facebookID;

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }
        return $data;
    }

    public function setLoginSession($user_id) {
        $user_id = intval($user_id);

        if (empty($user_id))
            throw new Exception("User id is empty!");

        $info = $this->getUserInfo($user_id);

        $admin = $this->isAdmin($user_id);

        $data = array
            (
            'user_id' => $user_id,
            'email' => $info->email,
            'firstName' => $info->firstName,
            'lastName' => $info->lastName,
            'username' => $info->username,
            'logged_in' => true,
            'admin' => $admin,
            'permissions' => $info->permissions
        );

        $this->ci->session->set_userdata($data);

        //$this->checkCompanyAdmin($user_id);

        return true;
    }

    public function checkCompanyAdmin($user_id) {
        $user_id = intval($user_id);

        if (empty($user_id))
            throw new Exception("User id is empty!");
    }

    public function getCodes($group, $company = 0, $orderCol = 'display', $orderType = 'asc') {
        $tag = "codes{$group}-{$company}-{$orderCol}-{$orderType}";

        $ci = & get_instance();

        $data = $ci->cache->memcached->get($tag);

        if (empty($data)) {
            $ci->db->from('codes');
            $ci->db->where('group', $group);
            $ci->db->where('code <>', 0);
            $ci->db->where('active', 1);
            $companyArray = array('0');

            if (!empty($company))
                $companyArray[] = $company;

            $ci->db->where_in('company', $companyArray);

            if (empty($orderCol))
                $ci->db->order_by('display', 'asc');
            else
                $ci->db->order_by($orderCol, $orderType);

            $query = $ci->db->get();

            $data = $query->result();

            $ci->cache->memcached->save($tag, $data, $ci->config->item('cache_timeout'));
        }

        return $data;
    }

    public function codeDisplay($group, $code) {
        if (empty($group))
            throw new Exception("Group is empty!");
        if (empty($code))
            throw new Exception("code is empty!");


        $ci = & get_instance();

        $mtag = "code-$group-$code";

        $data = $ci->cache->memcached->get($mtag);

        if (empty($data)) {
            $ci->db->select('display');
            $ci->db->from('codes');
            $ci->db->where('group', $group);
            $ci->db->where('code', $code);

            $query = $ci->db->get();

            $results = $query->result();

            $data = $results[0]->display;

            $ci->cache->memcached->save($mtag, $data, $ci->config->item('cache_timeout'));
        }

        return $data;
    }

    public function checkEmailAvailable($email) {
        if (empty($email))
            throw new Exception('email is empty');

        $this->ci->db->from('users');
        $this->ci->db->where('email', $email);
        $this->ci->db->where('deleted', 0);

        if ($this->ci->db->count_all_results() < 1)
            return true;

        return false;
    }

    public function checkUsernameAvailable($username) {
    	if (empty($username))
    		throw new Exception('Username is empty');
    
    	$this->ci->db->from('users');
    	$this->ci->db->where('username', $username);
    	$this->ci->db->where('deleted', 0);
    
    	if ($this->ci->db->count_all_results() < 1)
    		return true;
    
    	return false;
    }
    
    public function getDefaultPosition() {
        $mtag = "defaultPosition";

        //$data = $this->ci->cache->memcached->get($mtag);
$data = false;
        if (!$data) {
            $this->ci->db->select('id');
            $this->ci->db->from('positions');
            $this->ci->db->where('company', $this->ci->config->item('bmsCompanyID'));
            $this->ci->db->where('active', 1);
            $this->ci->db->where('default', 1);

            $query = $this->ci->db->get();

            $results = $query->result();

            $data = $results[0]->id;

            $this->ci->cache->memcached->save($tag, $data, $this->ci->config->item('cache_timeout'));
        }

        if (empty($data))
            throw new Exception($this->ci->config->item('bmsCompanyID'));

        return $data;
    }

    public function getDefaultDepartment() {
        $mtag = "defaultDepartment";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data) {
            $this->ci->db->select('id');
            $this->ci->db->from('departments');
            $this->ci->db->where('company', $this->ci->config->item('bmsCompanyID'));
            $this->ci->db->where('active', 1);
            $this->ci->db->where('default', 1);

            $query = $this->ci->db->get();

            $results = $query->result();

            $data = $results[0]->id;

            $this->ci->cache->memcached->save($tag, $data, $this->ci->config->item('cache_timeout'));
        }

        if (empty($data))
            throw new Exception("Default department has not bee assigned!");

        return $data;
    }

    public function checkUserAssignedToCompany($userid) {
        $mtag = "userAssignedToCompany-{$userid}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data) {
            $this->ci->db->from('userCompanies');
            $this->ci->db->where('userid', $userid);
            $this->ci->db->where('company', $this->ci->config->item('bmsCompanyID'));

            $data = $this->ci->db->count_all_results();

            $this->ci->cache->memcached->save($tag, $data, $this->ci->config->item('cache_timeout'));
        }

        // user is assigned to the company
        if ((int) $data > 0)
            return true;

        return false;
    }

    /*
      public function getStates()
      {
      $state_list = array(
      'AL'=>"Alabama",
      'AK'=>"Alaska",
      'AZ'=>"Arizona",
      'AR'=>"Arkansas",
      'CA'=>"California",
      'CO'=>"Colorado",
      'CT'=>"Connecticut",
      'DE'=>"Delaware",
      'DC'=>"District Of Columbia",
      'FL'=>"Florida",
      'GA'=>"Georgia",
      'HI'=>"Hawaii",
      'ID'=>"Idaho",
      'IL'=>"Illinois",
      'IN'=>"Indiana",
      'IA'=>"Iowa",
      'KS'=>"Kansas",
      'KY'=>"Kentucky",
      'LA'=>"Louisiana",
      'ME'=>"Maine",
      'MD'=>"Maryland",
      'MA'=>"Massachusetts",
      'MI'=>"Michigan",
      'MN'=>"Minnesota",
      'MS'=>"Mississippi",
      'MO'=>"Missouri",
      'MT'=>"Montana",
      'NE'=>"Nebraska",
      'NV'=>"Nevada",
      'NH'=>"New Hampshire",
      'NJ'=>"New Jersey",
      'NM'=>"New Mexico",
      'NY'=>"New York",
      'NC'=>"North Carolina",
      'ND'=>"North Dakota",
      'OH'=>"Ohio",
      'OK'=>"Oklahoma",
      'OR'=>"Oregon",
      'PA'=>"Pennsylvania",
      'RI'=>"Rhode Island",
      'SC'=>"South Carolina",
      'SD'=>"South Dakota",
      'TN'=>"Tennessee",
      'TX'=>"Texas",
      'UT'=>"Utah",
      'VT'=>"Vermont",
      'VA'=>"Virginia",
      'WA'=>"Washington",
      'WV'=>"West Virginia",
      'WI'=>"Wisconsin",
      'WY'=>"Wyoming"
      );

      return $state_list;
      }
     */

    /**
     * gets the extension of a given file, Example: some_image.test.JPG
     *
     * @param string $file - filename
     *
     * @return string. E.g.: jpg
     */
    /*
      public function getFileExt($file)
      {
      $ld = strrpos($file, '.');

      // gets file extension
      $ext = strtolower(substr($file, $ld + 1, (strlen($file) - $ld)));

      return $ext;
      }
     */

    public function getLocationCompany($location) {
        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        $mtag = "locationCompany-{$location}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data) {
            $this->ci->db->select('company');
            $this->ci->db->from('locations');
            $this->ci->db->where('id', $location);

            $query = $this->ci->db->get();

            $results = $query->result();

            $data = $results[0]->company;

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        return $data;
    }

    public function getLocationName($location) {
        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        $mtag = "locationName-{$location}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data) {
            $this->ci->db->select('name');
            $this->ci->db->from('locations');
            $this->ci->db->where('id', $location);

            $query = $this->ci->db->get();

            $results = $query->result();

            $data = $results[0]->name;

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        return $data;
    }

    public function getLocLatLng($location) {
        $location = intval($location);

        if (empty($location))
            throw new Exception("Location ID is empty!");

        $mtag = "locationLL-{$location}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data) {
            $this->ci->db->select('lat,lng');
            $this->ci->db->from('locations');
            $this->ci->db->where('id', $location);

            $query = $this->ci->db->get();

            $results = $query->result();

            $data = $results[0];

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        return $data;
    }

    /**
     * TODO: short description.
     *
     * @param mixed $from    
     * @param mixed $subject 
     * @param mixed $message
     * @param mixed $to      
     * @param mixed $cc      
     * @param mixed $bcc     
     * @param array $config - array with alternate config settings
     *
     * @return TODO
     */
    public function sendEmail($subject, $message, $to, $from = 'noreply@karate.com', $fromName = 'Karate', $cc = null, $bcc = null, $config = null) {
        // if no config params were defined for sending the message
        // will use localhost relay
        if (empty($config)) {
            $config['protocol'] = 'sendmail';
            //$config['mailpath'] = '/usr/sbin/sendmail';
            // $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = false;
            $config['mailtype'] = 'html';
        }

        $this->ci->email->initialize($config);

        $this->ci->email->from($from, $fromName);

        if ($this->ci->config->item('live') == true) {
            // Adds To
            if (is_array($to)) {
                foreach ($to as $t) {
                    $this->ci->email->to($t);
                }
            } else {
                $this->ci->email->to($to);
            }

            // Adds CC
            if (is_array($cc)) {
                foreach ($cc as $c) {
                    $this->ci->email->cc($c);
                }
            } else {
                $this->ci->email->cc($cc);
            }

            // adds BCC
            if (is_array($bcc)) {
                foreach ($bcc as $b) {
                    $this->ci->email->bcc($b);
                }
            } else {
                $this->ci->email->bcc($bcc);
            }
        } else {
            // not on live site, will send to dev email address
            $this->ci->email->to($this->ci->config->item('devEmail'));
        }
        $this->ci->email->subject($subject);
        $this->ci->email->message($message);

        $this->ci->email->send();

        // $this->ci->email->print_debugger();
    }

    public function isAdmin($user_id = 0) {
    	
    		$this->ci->db->from('users');
    		$query = $this->ci->db->where('user_id = '.$user_id.' and (admin > 0 or permissions > 0)');
    		                      
    		//$query = $this->ci->db->get(); 
    		   //echo $this->ci->db->last_query();	exit;	   		
    	    if($this->ci->db->count_all_results() > 0)
    	    	return true; 

    	    return false;
    }
    
    public function isAdminOLD($user = 0) {
        $mtag = "BMSadmin-{$user}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data) {
            $this->ci->db->select('admin');
            $this->ci->db->from('users');
            $this->ci->db->where('id', $user);

            $data = $this->ci->db->count_all_results();

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        // they are an overall BMS admin, therefor they get acces
        if ($data > 0)
            return true;

        $mtag = "isCompanyAdmin-{$user}-" . $this->ci->config->item('bmsCompanyID');

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data) {
            $this->ci->db->from('companyAdmins');
            $this->ci->db->where('user_id', $user);
            $this->ci->db->where('company', $this->ci->config->item('bmsCompanyID'));

            $data = $this->ci->db->count_all_results();

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        if ($data > 0)
            return true;

        return false;
    }

    /**
     * Gets the users timezone
     *
     * @param INT $user - userid
     *
     * @return String - users timezone
     */
    public function getTimezone($user) {
        if (empty($user))
            throw new Exception('user id is empty!');

        //$ci->load->driver('cache');

        $mtag = "userTimezone-{$user}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data) {
            $this->ci->db->select('timezone');
            $this->ci->db->from('users');
            $this->ci->db->where('deleted', 0);
            $this->ci->db->where('id', $user);

            $query = $this->ci->db->get();

            $results = $query->result();

            $data = $results[0]->timezone;

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        return $data;
    }

    /**
     * TODO: short description.
     *
     * @param mixed $user
     * @param mixed $inputDate - Date in UTC time
     *
     * @return TODO
     */
    public function convertTimezone($user, $inputDate, $returnFormat = "Y-m-d G:i:s") {
        if (empty($user))
            return date($returnFormat, strtotime($inputDate));

        if (empty($inputDate))
            throw new Exception('please enter an input date to convert');

        $timezone = $this->getTimezone($user);

        if (is_numeric($inputDate)) {
            $datetime = new DateTime();
            $datetime->setTimestamp($inputDate);
        } else {
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
    public function convertTimeBacktoUTC($user, $date, $returnFormat = "Y-m-d H:i:s") {
        if (empty($user))
            throw new Exception('User ID is empty!');
        if (empty($date))
            throw new Exception('please enter an input date to convert');

        // first gets the users time zone - for example America/Los Angelas -8 UTC
        $timezone = $this->getTimezone($user);

        $datetime = new DateTime($date, new DateTimeZone($timezone));

        // convertTime which should be back to UTC
        $convertTime = new DateTimeZone(date_default_timezone_get());

        $datetime->SetTimezone($convertTime);

        return $datetime->format($returnFormat);
    }

    public function dateDiff($start, $end, $type = 1) {
        $dStart = new DateTime();
        $dStart->setTimestamp($start);

        $dEnd = new DateTime();
        $dEnd->setTimestamp($end);

        $diff = date_diff($dStart, $dEnd);

        //$dDiff = $dStart->diff($dEnd);

        if ($type == 3)
            return $diff->m; // use for point out relation: smaller/greater
        if ($type == 3)
            return $diff->m; // use for point out relation: smaller/greater

        return $dDiff->days;
    }

    /*
      public function getTimezonesAbb ()
      {

      $aTimeZones = array
      (
      'America/Puerto_Rico'=>'AST',
      'America/New_York'=>'EDT',
      'America/Chicago'=>'CDT',
      'America/Boise'=>'MDT',
      'America/Phoenix'=>'MST',
      'America/Los_Angeles'=>'PDT',
      'America/Juneau'=>'AKDT',
      'Pacific/Honolulu'=>'HST',
      'Pacific/Guam'=>'ChST',
      'Pacific/Samoa'=>'SST',
      'Pacific/Wake'=>'WAKT'
      );

      asort($aTimeZones);

      return $aTimeZones;
      }

      public function getTimezonesFull ()
      {

      $aTimeZones = array
      (
      'America/Puerto_Rico'=>'Atlantic Standard Time',
      'America/New_York'=>'Eastern Daylight Time',
      'America/Chicago'=>'Central Daylight Time',
      'America/Boise'=>'Mountain Daylight Time',
      'America/Phoenix'=>'Mountain Standard Time',
      'America/Los_Angeles'=>'Pacific Daylight Time',
      'America/Juneau'=>'Alaska Daylight Time',
      'Pacific/Honolulu'=>'Hawaii-Aleutian Standard Time',
      'Pacific/Guam'=>'Chamorro Standard Time',
      'Pacific/Samoa'=>'Samoa Standard Time',
      'Pacific/Wake'=>'Wake Island Time'
      );

      asort($aTimeZones);

      return $aTimeZones;

      }

      public function determineTimezoneAbb ($zone)
      {
      if (empty($zone)) throw new Exception("Timezone is empty!");

      $zones = $this->getTimezonesAbb();

      $return = null;

      if (!empty($zones))
      {
      foreach ($zones as $z => $dis)
      {
      if ($z == $zone)
      {
      $return = $dis;
      break;
      }
      }
      }

      return $return;
      }
     */
    public function getSiteName(){
    	if($this->useImage && isset($this->site_logo)){
    		return $this->site_logo;
    	}
    	return trim($this->site_name);
    }
}
