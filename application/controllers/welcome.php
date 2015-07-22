<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function Welcome() {
        parent::__construct();
        $this->load->driver('cache');
        $this->load->model('welcome_model', 'welcome', true);
        $this->load->model('user_model', 'user', true);
        $this->load->model('search_model', 'search', true);
        $this->load->model('notifications_model', 'notifications', true);
        $this->load->model('user_model', 'users', true);
    }

    public function index() {
    	header('Location: /');
    }

    public function setRedirectUri(){ 
    	if(empty($_SESSION)){
    		session_start();
    	}
    	$this->session->set_flashdata('NOTICE', 'You must login first.');
    	$_SESSION['redirectUri'] = $_POST['uri'];
    	
    	echo json_encode(array('status' => 'SUCCESS', 'uri' => $_SESSION['redirectUri']));
    	exit;
    }
    
    public function login() {
    	if(empty($_SESSION)){
    		session_start();
    	} 
    	
        $check = $this->welcome->checkLogin($_POST['user_email'], $_POST['user_pass']);
        
        if (empty($check)){        	
            $this->functions->jsonReturn('ERROR', 'Invalid Username and/or Password'); exit;
        }elseif($check->permissions > 0){
        	$this->functions->setLoginSession($check->user_id);
        	 
        	if(!empty($_SESSION['redirectUri'])){
        		$redirect = $_SESSION['redirectUri'];
        		$_SESSION['redirectUri'] = null;
        	}
        	$this->session->set_flashdata('SUCCESS', 'You are now logged in');
        	
        	echo json_encode(array('status' => 'SUCCESS','permissions' => $check->permissions, 'redirect' => $redirect));         	
        	exit;
        }else{ 
            $this->functions->setLoginSession($check->user_id);

        	if(!empty($_SESSION['redirectUri'])){
        		$redirect = $_SESSION['redirectUri'];
        		$_SESSION['redirectUri'] = null;
        	}
        	$this->session->set_flashdata('SUCCESS', 'You are now logged in as an Administrator');
            echo json_encode(array('status' => 'SUCCESS', 'redirect' => $redirect));
            exit;
        }
    }

    public function logout() {       
       
    	$this->session->sess_destroy();
    	
        $this->session->sess_create();
        
        $this->session->set_flashdata('SUCCESS', 'You have successfully logged out.');
        
        header("Location: /");
        exit;
    }

    public function signup() {
        $this->load->view('welcome/signup', $body);
    }

    public function checkUsername(){ 
    	$usernameAvail = $this->functions->checkUsernameAvailable($_POST['username']);
    	
    	if ($usernameAvail !== true) {
    		echo json_encode(array('status' => 'FAILURE', 'id' => 'username', 'msg' => 'Username is already in use!')); exit;
    	}else{
    		echo json_encode(array('status' => 'SUCCESS')); exit;
    	}
    }
    
    public function checkEmail($email = null){
    	if(is_null($email))
    	    $email = htmlentities($_POST['email'], ENT_QUOTES);
    	
    	$emailAvail = $this->functions->checkEmailAvailable($email);
    	if ($emailAvail !== true) {
    		echo json_encode(array('status' => 'FAILURE', 'id' => 'email', 'msg' => 'Email is already in use!')); exit;
    	}else if (!preg_match('/\..{2,4}$/', $email)) {            
            echo json_encode(array('status' => 'FAILURE', 'id' => 'email', 'msg' => 'You must supply a valid email!')); exit;
        }
    	else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {            
            echo json_encode(array('status' => 'FAILURE', 'id' => 'email', 'msg' => 'You must supply a valid email!')); exit;
        }
        else{
    		echo json_encode(array('status' => 'SUCCESS')); exit;
    	}
    }
    
    public function register() {
    	if (!empty($_POST)) {  
    		      	
            try {           	
                $emailAvail = $this->functions->checkEmailAvailable($_POST['email']);
                $usernameAvail = $this->functions->checkUsernameAvailable($_POST['username']);
                
                if ($emailAvail === true && $usernameAvail === true) { 
                	
                    $user_id = $this->user->create();

                    $this->functions->setLoginSession($user_id);
                    
                    $firstName = $_POST['firstName']; 
                     
                    $notification = "Hi $firstName , thank you for registering with LegacyXChange.com. This is your account area. Here you can add products, listings, update personal info., and much more. \n
                    		         if you have any questions or comments, please send us a message from our contact page.\n Please continue to fill out your personal information on the My Settings page.";
                    
                    $email_notification = 'Hi '.$firstName.', thank you for registering with LegacyXChange.com. Login and go to your account area. There you can add products, listings, update personal info., and much more.
                    		               <br />Please continue to fill out your personal information on the My Settings page.<br />
                    		               if you have any questions or comments, please send us a message from our <a href="http://legacyxchange.com/contact">contact page</a>.<br />support@legacyxchange.com';
                    
                    $this->notifications->fromSystem($user_id, $notification, $subject = 'Welcome to LegacyXChange.com', $importance_level = 1, $email_notification);

                    $this->session->set_flashdata('SUCCESS', 'Account has been created!');
                    
                    $this->functions->jsonReturn('SUCCESS', 'Account has been created!');
                                   
                } elseif(!$usernameAvail && $emailAvail) {
                    echo json_encode(array('status' => 'FAILURE', 'id' => 'username', 'msg' => 'Username is already in use!')); exit;
                } elseif($usernameAvail && !$emailAvail) {
                	echo json_encode(array('status' => 'FAILURE', 'id' => 'email', 'msg' => 'Email is already in use!')); exit;
                }
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        }
    }

    public function fbreg() {
        try {
            $userid = $this->welcome->getFacebookID($_POST['data']['id']);

            if (!empty($userid)) {
                $companyAssigned = $this->functions->checkUserAssignedToCompany($userid);

                if ($companyAssigned == false) {                   
                    $this->welcome->assignUserToCompany($userid);
                }
               
                $this->functions->setLoginSession($userid);

                $this->functions->jsonReturn('SUCCESS', 'You are logged in');
            }
            
            $passwd = uniqid($_POST['data']['email'], true);

            $emailAvail = $this->functions->checkEmailAvailable($_POST['data']['email']);

            if ($emailAvail === true) {
                $data = array
                    (
                    'email' => $_POST['data']['email'],
                    'firstName' => $_POST['data']['first_name'],
                    'lastName' => $_POST['data']['last_name'],
                    'user_pass' => $passwd,
                    'facebookID' => $_POST['data']['id']
                );

                $userid = $this->welcome->createUser($data);

                $this->functions->setLoginSession($userid);
                
                $this->functions->jsonReturn('SUCCESS', 'Account has been created!');
            } else {
                $this->functions->jsonReturn('ALERT', 'Username or email is already in use!');
            }
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
            $this->functions->jsonReturn('ERROR', $e->getMessage());
        }
    }

    public function forgotpassword() {
        if ($_POST) {
            try {
                // get user ID from email address
                $user = $this->users->fetchAll(array('where' => 'email = "'.$_POST['user_email'].'"'))[0];
//var_dump($user); exit;
                if ($user !== false && !is_null($user)) {
                    $tempPass = $this->welcome->updateUserPass($user);

                    $subject = "Password Reset";

                    $msg = '<h1>New Temporary Password: '.$tempPass.'</h1><p><a href="http://' . $_SERVER['HTTP_HOST'] . '/login">Click Here to Login with your temporary password.</a></p>';

                    $this->load->library('Mailer', 'mailer', true);
                    //var_dump($tempPass, $this->mailer); exit;
                    $sent = $this->mailer->send($user->email, $subject, $msg, $user->firstName.' '.$user->lastName, 'service@legacyxchange.com', 'legacyxchange.com');
                    
                    if(!$sent){
                    	$this->session->set_flashdata('FAILURE', 'You must supply a valid email.');
                    	header('Location: /welcome/forgotpassword'); exit;
                    }else{
                    	$this->session->set_flashdata('SUCCESS', 'We just sent you an email with your new TEMPORARY PASSWORD.');
                    	header('Location: /login'); exit;
                    }
                }

                $this->functions->jsonReturn('SUCCESS', "An e-mail will be sent to <strong>{$_POST['email']}</strong> with instructions on how to reset the password if there is an account associated with that e-mail address.", $requestID);
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
                $this->functions->jsonReturn('ERROR', $e->getMessage());
            }
        } else {
        	$this->layout->load('welcome/forgotpassword', $data);
        }
    }

    public function resetpassword() {
        
    }

    public function phpinfo() {
        phpinfo();
    }

    public function geotargetlocation() {
        try {
            $loc = $this->functions->geoCodeAddress(urldecode($_GET['lat'] . ',' . urldecode($_GET['lng'])));

            $loc = json_decode($loc);

            $this->functions->jsonReturn('SUCCESS', $loc->results[1]->formatted_address);
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
            $this->functions->jsonReturn('ERROR', $e->getMessage());
        }
    }
}