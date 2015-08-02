<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Jaz extends MY_Controller
{
	//Data types declaration.
	public $data = array();
	public $main_url = '';
	public $base_cont;
	public $remember = FALSE;
	
    function __construct()
    {
        parent::__construct();
		
		//loading classes
        $this->load->helper('general');
		$this->load->helper('url');
		$this->load->helper('cookie');
        $this->load->model('users_model');
		$this->load->library('email');
		
		//assining values to variables.
		$this->main_url = base_url() . 'jaz/';
		
		//Create an object with MY_Controller class
		$this->base_cont = new MY_Controller;

     }
	
	public function index()
	{
		//check if user is already login.
		$this->load->view('jaz/login_form');
	}
	
	public function process_login() 
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			//If validation has error display form again with error messages.			
			$this->index();
		}
		else
		{
			//If form validation has no error catch $username and $password
			//Call login method
			$username = $this->input->post('username', TRUE);
			$password = $this->input->post('password', TRUE);
			$this->remember = $this->input->post('remember', TRUE);
			
			if($this->users_model->login($username, $password))
			{
				//If login successful.
				//display welcome and username.	
				echo '<br><br>Welcome back '. $username;
				echo '<br>';
				echo anchor('jaz/logout', 'Logout', 'title="logout"');
				echo '<br><br>';
				echo 'Remember: '. $this->remember;
				
				//if remember-me is selected save to cookie.
				$this->jaz_lib->save_cookie($username, $password);
				
			}
			else 
			{
				//If login failed
				//Display error message and redirect back to login page.
				echo 'Ivalid username or password.';
			}
		}
	}

	public function register_form()
	{
		$this->load->view('jaz/register_form');
	}

	public function process_register()
	{
		//capture data and validate form
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[25]|is_unique[users.username]');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[confirm_pass]');
		$this->form_validation->set_rules('confirm_pass', 'Password Confirmation', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');

		$this->form_validation->set_rules('first_name', 'Firstname', 'required');
		$this->form_validation->set_rules('last_name', 'Lastname', 'required');
		$this->form_validation->set_rules('company', 'Company', 'required');
		$this->form_validation->set_rules('contact_number', 'Contact number', 'required');		
		$this->form_validation->set_rules('country', 'Country', 'required');
		$this->form_validation->set_rules('website', 'Website', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			//If validation has error display form again with error messages.			
			$this->register_form();
		}
		else
		{
			//If validation has no errors capture data and insert into database
			$password = $this->input->post('password', TRUE);
			$password = sha1($password);

			$data1 = array(
							'group_id' => 2,
							'ip_address' => $_SERVER['REMOTE_ADDR'],
							'created_on' => date("mdy"),
							'last_login' => date("mdy"),
							'username' => $this->input->post('username', TRUE),
							'password' => $password,
							'email' => $this->input->post('email', TRUE), 
						);
			
			$data2 = array(
							'userid' => 0,
							'first_name' => $this->input->post('first_name', TRUE),
							'last_name' => $this->input->post('last_name', TRUE),
							'company' => $this->input->post('company', TRUE),
							'contact_number' => $this->input->post('contact_number', TRUE),
							'country' => $this->input->post('country', TRUE),
							'website' => $this->input->post('website', TRUE),
						);

			//Insert into database
			$id = $this->users_model->save($data1, $data2);
			//echo 'Data successfully saved.';
			
			//check for email validity first.
			if($this->jaz_lib->check_email_valid($data1['email'])) {
				//Email activation link.
				$this->jaz_lib->email_activation($data1['username'], $data1['email']);
				
			}
			else
			{
				echo 'Email activation is not sent, because email is not valid.';				
			} 
			
		}
	}

	//activate a newly registed account.
	public function activate()
	{
		//http://coder9.com/admins9b//jaz/activate/?email=iridion_us@yahoo.com		
		$email = $this->input->get('email');
		
		if($this->jaz_model->activate_account($email))
		{
			echo 'We have activated your account, you can now login.';
			echo '<br><br>';
			echo anchor($this->main_url, 'Click here to login', 'title="Click here"');
		}
		else 
		{
			echo 'Activation failed!';	
		}
	}

	public function logout()
	{
		$this->jaz_lib->logout();
		
		$this->index();
	}
	
/*************************************************************/
/*			Below are for testing purpose only  				 */ 
/*************************************************************/
	//fetch cookie.
	function fetch_choco()
	{
		$my_cookie = $this->input->cookie('user');
		$my_cookie .= $this->input->cookie('pass');
		
		echo '<pre>';
		print_r($my_cookie);
		echo '<pre>';
	}

	//accessing Cookie Config data
	function show_config2()
	{
		echo 'Cookie Life: ' . $this->base_cont->cookie_life;
		echo '<br>Cookie Dname: '. $this->base_cont->cookie_dname;
	}
	
	//set cookie
	function set_choco()
	{
		$cookie = array(
		    'name'   => 'user',
		    'value'  => 'anna16',
		    'expire' => '86500',
		    'domain' => '.coder9.com',
		    'path'   => '/',
		    'prefix' => '',
		    'secure' => FALSE
		);
		
		$this->input->set_cookie($cookie);
		echo 'Cookie is set.'; 
	}

	//get cookie
	function get_choco()
	{
		$my_cookie = $this->input->cookie('user');
		
		echo '<pre>';
		print_r($my_cookie);
		echo '<pre>';
	}
	
	//delete cookie
	function del_choco()
	{
		//delete_cookie("user");
		//$this->input->set_cookie($name, $value, $expire, $domain, $path, $prefix, $secure);
		$this->input->set_cookie('user', '', '', '.coder9.com', '/', '', FALSE);
		echo 'Cookie deleted.';
	} 

	function show_user_table()
	{
		$q = $this->db->select('username, email, active')
				 ->from('users')
				 ->where('username', 'coder9')
				 ->limit(1)
				 ->get();
				 
		if($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			
			echo 'user: ' . $data[0]->username;
			echo '<br>email: ' . $data[0]->email;
		}					 
	}
	
	function var_main_page()
	{
		$main_page = base_url() . 'jaz/';
		echo $main_page;
	}


	function email_test()
	{
		$this->email->from('contact@coder9.com', 'Admin');
		$this->email->to('iridion_us@yahoo.com');		
		$this->email->subject('jazAuth');		
		$this->email->message('<b>It is working. Great!</b>');
		
		//$path = $this->config->item('server_root');
		//$file = $path . '/ci_day3/attachments/yourInfo.txt';
		//$this->email->attach($file);
		
		if($this->email->send())
		{
			echo 'Your email was sent, fool.';
		}
		else
		{
			show_error($this->email->print_debugger());
		}
	}

	function check_email_valid()
	{
		if (valid_email('email@somesite.com'))
		{
		    echo 'email is valid';
		}
		else
		{
		    echo 'email is not valid';
		}		
	}

	function show_user() 
	{ 
		echo '<br><br>Welcome back '. $this->session->userdata('username');
	} 
 
 	function show_error()
	{
		show_404();
	}
 	
 	function test()
	{
		echo 'test.';
	}
}