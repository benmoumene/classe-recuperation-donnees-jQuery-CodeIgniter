<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Jaz_lib
{
	public $data = array(
                   '' => '',
				);
	
	public $cookie_life = 0;
	public $cookie_dname = '';
	
	var $CI;
	var $site_name = 'coder9.com';
				
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('session');
		$this->CI->load->library('email');
		$this->CI->load->model('jaz_model');		
		$this->CI->load->helper('email');
		
		//fetching data from config
		$this->cookie_life = $this->CI->config->item('cookie_life');
		$this->cookie_dname = $this->CI->config->item('cookie_dname');
	}

	//save username and password to cookie	
	public function save_cookie($username, $password)
	{
		$password = sha1($password);		
		
		// 'expire' => $this->cookie_life,
		// 'domain' => $this->cookie_dname,
		// 'expire' => '86500',
		//'domain' => '.coder9.com',
				
		$cookie = array(
		    'name'   => 'user',
		    'value'  => $username,
		    'expire' => '86500',
		    'domain' => '.coder9.com',
		    'path'   => '/',
		    'prefix' => '',
		    'secure' => FALSE
		);

		$cookie2 = array(
		    'name'   => 'pass',
		    'value'  => $password,
		    'expire' => '86500',
		    'domain' => '.coder9.com',
		    'path'   => '/',
		    'prefix' => '',
		    'secure' => FALSE
		);
		
		//must distinguish if it is save properly.
		$this->CI->input->set_cookie($cookie); //save info to cookie
		$this->CI->input->set_cookie($cookie2); //save info to cookie
		
		return TRUE;
	}

	//save username and password to cookie	
	public function fetch_cookie()
	{
		
	}

	
	//send email activation for a newly registered user.
	//email link for user activation
	public function email_activation($user, $email) 
	{
		//If email is valid then continue sending the email.
		$e_address = 'contact@'. $this->site_name;
		$link_activate = base_url() . 'jaz_auth_front/activate/?email=' . $email; 
		$message = 'Hi '. $user .',';
		$message .= '<br><br>Please click the link below to activate your account.';
		$message .= '<br><a href="'. $link_activate .'">Click here</a>';
		
		//http://www.domain.com/index.php?variable1Name=theFirstValue&variable2Name=theSecondValue
				
		$this->CI->email->from($e_address, 'Admin');
		$this->CI->email->to($email);		
		$this->CI->email->subject('jazAuth');		
		$this->CI->email->message($message);
		
		//$path = $this->config->item('server_root');
		//$file = $path . '/ci_day3/attachments/yourInfo.txt';
		//$this->email->attach($file);
		
		if($this->CI->email->send())
		{
			//Display message and redirect to home page.
			$this->CI->session->set_flashdata('message', 'We sent you an email to activate your account, please check your inbox.');
			redirect('jaz_auth_front/home_page');
		}
		else
		{
			show_error($this->CI->email->print_debugger());
		}
	}
	
	//check for email validity
	public function check_email_valid($email)
	{
		if (valid_email($email))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}		
	} 

	//send user his username and password
	public function email_reset_password_form($email) 
	{
		//If email is valid then continue sending the email.
		$e_address = 'contact@'. $this->site_name;
		$link_activate = base_url() . 'jaz_auth_front/reset_password/?email=' . $email; 
		$message = 'Hi, ';
		$message .= '<br><br>Please click the link below to reset your password.';
		$message .= '<br><a href="'. $link_activate .'">Click here</a>';
		
		//http://www.domain.com/index.php?variable1Name=theFirstValue&variable2Name=theSecondValue
				
		$this->CI->email->from($e_address, 'Admin');
		$this->CI->email->to($email);		
		$this->CI->email->subject('Reset your password');		
		$this->CI->email->message($message);
		
		//$path = $this->config->item('server_root');
		//$file = $path . '/ci_day3/attachments/yourInfo.txt';
		//$this->email->attach($file);
		
		return $this->CI->email->send();
	}	

	//send user his username and password
	public function send_msg($user, $chkbox, $msg) 
	{
        if(empty($user) && $chkbox == FALSE) 
        {
            return FALSE;
        }
		
		if(empty($msg))
		{
			return FALSE;	
		}  
		
		//get member email(s)
		$email = $this->CI->jaz_model->get_user_email($user, $chkbox);
		
		//Sample of accessing $email array		
		//$email[0]->email;
		
		//If email is valid then continue sending the email.
		$e_address = 'admin@'. $this->site_name;
				
		//foreach ($variable as $key => $value) {
			$this->CI->email->from($e_address, 'Admin');
			$this->CI->email->to($email[0]->email);		
			$this->CI->email->subject('Important Message from Admin');		
			$this->CI->email->message($msg);
				
			//$path = $this->config->item('server_root');
			//$file = $path . '/ci_day3/attachments/yourInfo.txt';
			//$this->email->attach($file);
			return $this->CI->email->send();
		//}
	}	

	//Check to see if a user is login
	public function is_login()
	{
		//check session first		
		$user = $this->CI->session->userdata('username');
		$pass = $this->CI->session->userdata('password');
		if(isset($user) && isset($pass))
		{
			return TRUE;
		}

		//unset variable user and pass
		unset($user);
		unset($pass);

		//second is check the cookie
		$user = $this->CI->input->cookie('user');
		$pass = $this->CI->input->cookie('pass');
		if(isset($user) && isset($pass))
		{
			//assign to session.
			$this->CI->session->set_userdata('username', $user);
			$this->CI->session->set_userdata('password', $pass);
			
			return TRUE;
		}
		else 
		{
			return FALSE;
		}		
	}
		
	//logout the user
	public function logout()
	{
		//Destroy session
		$this->CI->session->sess_destroy();
		
		//Delete coockie
		$this->CI->input->set_cookie('user', '', '', '.coder9.com', '/', '', FALSE);
		$this->CI->input->set_cookie('pass', '', '', '.coder9.com', '/', '', FALSE);
		
		return TRUE;		
	}	
    
/*************************************************************/
/*				Below are for testing purpose only 			 */
/*************************************************************/

	function cookie_var() 
	{
		echo 'life: '. $this->cookie_life;
		echo '<br> dname: '. $this->cookie_dname;
	}

}