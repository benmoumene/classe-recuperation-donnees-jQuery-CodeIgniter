<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Front extends MY_Controller 
{
	//Data types declaration.
	public $data = array();
	public $main_url = '';
	public $base_cont;
	public $remember = FALSE;

    function __construct ()
    {
        parent::__construct();
		
		//loading classes
        $this->load->helper('general');
        $this->load->model('users_model');

		$this->data['message'] = '';
		$this->data['remember'] = ''; //for session testing
		$this->data['user'] = '';
		$this->data['pass'] = '';
		$this->data['username'] = '';
		$this->data['title'] = 'AdminS9';
		$this->load->library('jaz_lib');

		//assigning values to variables.
		$this->main_url = base_url() . 'front/';		 
    }

	function index()
	{
		//check if user is login.
		if($this->jaz_lib->is_login())
		{
			$this->data['username'] = $this->session->userdata('username');			
		}
		else 
		{
			$this->data['username'] = '';			
		}
		
		//$this->data['header'] = $this->load->view('template/header', $this->data, TRUE);
		//$this->load->view('template/master', $this->data);

		$this->data['header'] = $this->load->view('jaz_auth_template/header', $this->data, TRUE);
		$this->load->view('jaz_auth_template/master', $this->data);

	}

	//main page
	function home_page()
	{
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['remember'] = $this->session->userdata('remember');
		$this->data['username'] = $this->session->userdata('username');
		$this->data['title'] = 'AdminS9';
		$this->data['header'] = $this->load->view('template/header', $this->data, TRUE);
		
		$this->load->view('template/master', $this->data);
	}

	//display register form	
	function register_form()
	{
		$this->data['body_content'] = $this->load->view('jaz/register_form', $this->data, TRUE);
		$this->home_page();
	}

	//Process the data from register form.
	function process_register()
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
		
		if($this->form_validation->run() == FALSE)
		{
			//If validation has error display form again with error messages.
			//$this->session->set_flashdata('message', 'The registration form has an error.');			
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
			
			//check for email validity first.
			if($this->jaz_lib->check_email_valid($data1['email'])) {
				//Email activation link.
				$this->jaz_lib->email_activation($data1['username'], $data1['email']);
				
			}
			else
			{
				$this->session->set_flashdata('message', 'Email activation is not sent, because email is not valid.');
				redirect('front/home_page');
								
			} 
		}
	}

	function login()
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
			$this->data['remember'] = $this->input->post('remember', TRUE);
			
			if($this->users_model->login($username, $password))
			{
				if($this->data['remember'] == 'accept')
				{
					//if remember-me is selected save to cookie.
					$this->jaz_lib->save_cookie($username, $password);
					
					//Save remember into session. 
					$this->session->set_userdata('remember', $this->data['remember']);
				}
				//redirect to front page.
				$this->session->set_flashdata('message', 'Welcome back! ');
				redirect('front/home_page');
			}
			else 
			{
				//If login failed display error message.
				$this->session->set_flashdata('message', 'Invalid username or password.');
				redirect('front/home_page');
			}
		}
	}

	//log the user out
	function logout()
	{
		$this->data['title'] = "Logout";

		//log the user out
		$logout = $this->jaz_lib->logout();

		//redirect them back to the page they came from
		redirect('front', 'refresh');
	}

	//Display forgot_password_form
	function forgot_password_form()
	{
		$this->data['body_content'] = $this->load->view('jaz/forgot_password_form', $this->data, TRUE);
		$this->home_page();		
	}

	//This will send the email to user the username and password.
	function forgot_password()
	{
		//Check for form validation
		//Check email validity
		//Email the username and password to user.
		
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		if ($this->form_validation->run() == false)
		{
			//If form validation has an error display form again along with the error message.
			//set any errors and display the form
			$this->forgot_password_form();
		}
		else
		{
			$email = $this->input->post('email', TRUE);
			
			//fetch username and password from DB.
			//if did not found match in the DB include a message.
			$email_exist = $this->jaz_model->select_by_email($email);
			//echo 'Data: '. $email_exist;
			
			if($email_exist)
			{
				//Email the link reset_password_form, In the link attached the email address.
				$email_sent = $this->jaz_lib->email_reset_password_form($email);				

				if($email_sent) 
				{
					$this->session->set_flashdata('message', 'We send you email, please check your email.');
					redirect('front/home_page');
				}
				else 
				{
					$this->session->set_flashdata('message', 'Sorry, sending the reset_password_form failed.');
					redirect('front/home_page');			
				}			
			}
			else
			{
				//Redirect to front page and display email failure message.
				$this->session->set_flashdata('message', 'Sorry your email address does not exist.');
				redirect('front/home_page');			
			}
			
		}
	}
	
	//reset password - final step for forgotten password
	function reset_password()
	{
		//Capture email address in the link.
		$email = $this->input->get('email');

		//get username
		$this->data['username'] = $this->jaz_model->get_username($email);
		
		//Dispaly reset_password_form
		$this->data['body_content'] = $this->load->view('jaz/reset_password_form', $this->data, TRUE);
		$this->home_page();
	}	

	//reset password - final step for forgotten password
	function process_reset_password()
	{
		$this->form_validation->set_rules('newpass', 'New Password', 'required');
		if ($this->form_validation->run() == false)
		{
			//If form validation has an error display form again along with the error message.
			$this->reset_password();
		}
		else 
		{
			$user = $this->input->post('username', TRUE);
			$pass = $this->input->post('newpass', TRUE);
	
			//update password
			if($this->jaz_model->reset_password($user, $pass))
			{
				//If update successful redirect to front page and dispaly success message.
				$this->session->set_flashdata('message', 'Password successfully changed, you can now login.');
				redirect('front/home_page');
			}
			else 
			{
				//else redirect to front page and display failure message
				$this->session->set_flashdata('message', 'Sorry password reset failed.');
				redirect('front/home_page');
			}
		}
	}
	
	//This will display Registration for new user.
	function create_user_form()
	{
		$this->data['header'] = $this->load->view('template/header', $this->data, TRUE);
		$this->data['body'] = $this->load->view('auth/create_user', $this->data, TRUE);
		$this->load->view('template/master', $this->data);
	}
	
	function create_user()
	{
		//capture data and validate form
		$this->form_validation->set_rules('firstname', 'Firstname', 'required');
		$this->form_validation->set_rules('lastname', 'Lastname', 'required');
		$this->form_validation->set_rules('company', 'Company', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
		//$this->form_validation->set_rules('email', 'Email', 'required|valid_email');		
		$this->form_validation->set_rules('phone', 'Phone', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[25]|is_unique[users.username]');
		//$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			//If validation has error display form again with error messages.			
			$this->create_user_form();
		}
		else
		{
			//If validation has no errors capture data and insert into database
			$username = $this->input->post('username', TRUE);
			$password = $this->input->post('password', TRUE);
			$email = $this->input->post('email', TRUE);
			$additional_data = array(
									'first_name' => $this->input->post('firstname', TRUE),
									'last_name' => $this->input->post('lastname', TRUE),
									);
			$group = array(); // Sets user to admin. No need for array('1', '2') as user is always set to member by default
			
			$this->ion_auth_model->register($username, $password, $email, $additional_data, $group);				
				
			//email userinfo to user and send activation email.
			$from = 'From: admin@'. base_url() . '.com'; 
			$to = $email; 
			$subject = 'Your account info at '. base_url(); 
			$body = 'username: ' .$username. ' password: ' .$password; 
				
			if (mail ($to, $subject, $body, $from)) { 
				//echo 'MAIL - OK'; 
			}else{
				echo 'MAIL - NOT OK';
				$this->home_page($message = '<br><br><br><br><br><br><br><br><br><b>Mail okay!</b>');
			}
			
			//display activation message
			$this->home_page($message = '<br><br><br><br><br><br><br><br><br><b>Please check your email to activate your account!</b>');
		}
	}

	//activate a newly registed account.
	public function activate()
	{
		//http://coder9.com/admins9b//jaz/activate/?email=iridion_us@yahoo.com		
		$email = $this->input->get('email');
		
		if($this->jaz_model->activate_account($email))
		{
			//redirect home_page
			$this->session->set_flashdata('message', 'We have activated your account, you can now login.');
			redirect('front/home_page'); 
		}
		else 
		{
			$this->session->set_flashdata('message', 'Activation failed.');
			redirect('front/home_page'); 
		}
	}

/*****************************************/
/*****************************************/
/**		BELOW ARE FOR TESTING ONLY		**/
/*****************************************/
/*****************************************/
	//set cookie
	function set_choco()
	{
		$cookie = array(
		    'name'   => 'username',
		    'value'  => 'arvin',
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
		$my_cookie = $this->input->cookie('username');
		
		echo '<pre>';
		print_r($my_cookie);
		echo '<pre>';
	}
	
	//delete cookie
	function del_choco()
	{
		//delete_cookie("user");
		//$this->input->set_cookie($name, $value, $expire, $domain, $path, $prefix, $secure);
		$this->input->set_cookie('username', '', '', '.coder9.com', '/', '', FALSE);
		echo 'Cookie deleted.';
	} 

	//fetch cookie.
	function fetch_choco()
	{
		$my_cookie = $this->input->cookie('user');
		$my_cookie .= $this->input->cookie('pass');
		
		echo '<pre>';
		print_r($my_cookie);
		echo '<pre>';
	}

	function change_password_form()
	{
		$this->data['body_content'] = $this->load->view('jaz/change_password_form', $this->data, TRUE);
		$this->home_page();		
	}

	function reset_password_form()
	{
		$this->data['body_content'] = $this->load->view('jaz/reset_password_form', $this->data, TRUE);
		$this->home_page();		
	}

	function show_session() {
		echo '<pre>';
		print_r($this->session->all_userdata());
		echo '</pre>';
	}

	function show_hashdb() {
		echo $this->ion_auth_model->hash_password_db('solidcodes@gmail.com', 'asdf1234');
	}
	
	function show_base()
	{	
		echo '<br>base url: ' . base_url();
	}
	
	//show cookie variable from jaz_config;
	function cookie_var() 
	{
		$this->jaz_lib->cookie_var();
	}
	
}
