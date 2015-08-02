<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jaz_auth_front extends MX_Controller
{
	public $data = array();
	public $main_url = '';
	public $base_cont;
	public $remember = FALSE;	

	function __construct() {
		parent::__construct();
	
		//loading classes
        $this->load->helper('general');
        $this->load->model('users_model');
		$this->load->library('jaz_lib');
        $this->load->library('form_validation');
        $this->form_validation->CI =& $this;		
	
		$this->data['message'] = '';
		$this->data['remember'] = ''; //for session testing
		$this->data['user'] = '';
		$this->data['pass'] = '';
		$this->data['username'] = '';
		$this->data['title'] = 'jazAuth';
		$this->data['module'] = 'jaz_auth_template';
		$this->data['mid_sec'] = '';
		
		//assigning values to variables.
		$this->main_url = base_url() . 'jaz_auth_front/';			
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

		$this->data['header'] = Modules::run('jaz_auth_template/header_sec', $this->data, TRUE);
		echo Modules::run('jaz_auth_template/master_sec', $this->data);
			
 	}
	
	//main page
	function home_page()
	{
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['remember'] = $this->session->userdata('remember');
		$this->data['username'] = $this->session->userdata('username');

		$this->data['header'] = Modules::run('jaz_auth_template/header_sec', $this->data, TRUE);
		echo Modules::run('jaz_auth_template/master_sec', $this->data);
	}	

	//main page
	function member_page()
	{
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['remember'] = $this->session->userdata('remember');
		$this->data['username'] = $this->session->userdata('username');

		$this->data['header'] = Modules::run('jaz_auth_template/header_member', $this->data, TRUE);
		echo Modules::run('jaz_auth_template/master_sec', $this->data);
	}	
	
	//display account registration form
	function register_form()
	{
		$this->data['header'] = Modules::run('jaz_auth_template/header_sec', $this->data, TRUE);
		$this->data['mid_sec'] = $this->load->view('register_form', $this->data, TRUE);
		echo Modules::run('jaz_auth_template/master_sec', $this->data);
	}


	//save new user account information
	function process_register_form()
	{
		//capture data and validate form
		//$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[25]|is_unique[users.username]');
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[25]');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[confirm_pass]');
		$this->form_validation->set_rules('confirm_pass', 'Password Confirmation', 'required');
		//$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		$this->form_validation->set_rules('first_name', 'Firstname', 'required');
		$this->form_validation->set_rules('last_name', 'Lastname', 'required');
		$this->form_validation->set_rules('company', 'Company', 'required');
		$this->form_validation->set_rules('contact_number', 'Contact number', 'required');		
		$this->form_validation->set_rules('country', 'Country', 'required');
		$this->form_validation->set_rules('website', 'Website', 'required');
		
		if($this->form_validation->run($this) == FALSE)
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
				redirect('jaz_auth_front/home_page');
								
			} 
		}
	}

	function login()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run($this) == FALSE)
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
				//redirect to member page.
				$this->session->set_flashdata('message', 'Welcome back! ');
				redirect('jaz_auth_front/member_page');
			}
			else 
			{
				//If login failed display error message.
				$this->session->set_flashdata('message', 'Invalid username or password.');
				redirect('jaz_auth_front/home_page');
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
		redirect('jaz_auth_front', 'refresh');
	}
	
	//display forgot_password_form
	function forgot_password_form()
	{
		$this->data['header'] = Modules::run('jaz_auth_template/header_sec', $this->data, TRUE);
		$this->data['mid_sec'] = $this->load->view('forgot_password_form', $this->data, TRUE);
		echo Modules::run('jaz_auth_template/master_sec', $this->data);
	}

	//This will send the email to user the username and password.
	function forgot_password()
	{
		//Check for form validation
		//Check email validity
		//Email the username and password to user.
		
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		if ($this->form_validation->run($this) == false)
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
					redirect('jaz_auth_front/home_page');
				}
				else 
				{
					$this->session->set_flashdata('message', 'Sorry, sending the reset_password_form failed.');
					redirect('jaz_auth_front/home_page');			
				}			
			}
			else
			{
				//Redirect to front page and display email failure message.
				$this->session->set_flashdata('message', 'Sorry your email address does not exist.');
				redirect('jaz_auth_front/home_page');			
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
		$this->data['mid_sec'] = $this->load->view('reset_password_form', $this->data, TRUE);
		
		$this->home_page();
	}	

	//reset password - final step for forgotten password
	function process_reset_password()
	{
		$this->form_validation->set_rules('newpass', 'New Password', 'required');
		if ($this->form_validation->run($this) == false)
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
				redirect('jaz_auth_front/home_page');
			}
			else 
			{
				//else redirect to front page and display failure message
				$this->session->set_flashdata('message', 'Sorry password reset failed.');
				redirect('jaz_auth_front/home_page');
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
			//redirect home_page
			$this->session->set_flashdata('message', 'We have activated your account, you can now login.');
			redirect('jaz_auth_front/home_page'); 
		}
		else 
		{
			$this->session->set_flashdata('message', 'Activation failed.');
			redirect('jaz_auth_front/home_page'); 
		}
	}

/******************************************************
 * Tests Methods
 *****************************************************/
	function show_header_member() 
	{
		$data['username'] = 'xeon9';
		echo Modules::run('jaz_auth_template/header_member', $this->data);
	}
	
	function show_phpinfo()
	{
		phpinfo();
	}
	
	public function test_composer()
	  {
	    $excel = new \SimpleExcel\SimpleExcel('xml'); // instantiate new object (will automatically construct the parser & writer type as XML)
	 
	    $excel->writer->setData(
	      array
	      (
	        array('ID', 'Name', 'Kode' ),
	        array('1', 'Kab. Bogor', '1' ),
	        array('2', 'Kab. Cianjur', '1' ),
	        array('3', 'Kab. Sukabumi', '1' ),
	        array('4', 'Kab. Tasikmalaya', '2' )
	      )
	    ); // add some data to the writer
	    $excel->writer->saveFile('example'); // save the file with specified name (example.xml)
	    // and specified target (default to browser)
	  }	

}

