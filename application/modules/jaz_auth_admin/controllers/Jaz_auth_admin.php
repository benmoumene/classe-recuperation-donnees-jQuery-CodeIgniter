<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jaz_auth_admin extends MX_Controller
{
	public $data = array();
	
    function __construct ()
    {
        parent::__construct();
  
        $this->load->model('users_model');  
		$this->load->model('jaz_model');

		$this->load->library('jaz_lib');		
        $this->load->library('form_validation');
        $this->form_validation->CI =& $this;			
        
		$this->data['message'] = '';
		$this->data['title'] = 'jazAuth Admin Panel';

    }
    
    function index(){
		$this->data['password_header'] = $this->load->view('password_header', $this->data, TRUE);
		$this->load->view('password', $this->data);		
    }
	
	//main page
	function home_page()
	{
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['password_header'] = $this->load->view('password_header', $this->data, TRUE);
		$this->load->view('password', $this->data);
	}	

    function login(){
		//validate form
		//capture data
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
			
			if($this->users_model->login($username, $password))
			{
				//Check username and password in DB as Administrator User.
				if($this->users_model->is_admin($username, $password))
				{
					//If everything is okay redirect to Admin Conrol Panel.
					$this->data['admin_header'] = $this->load->view('admin_header', $this->data, TRUE);
					$this->load->view('adminpanel', $this->data);
				}
				else 
				{
					//If login failed display error message.
					$this->session->set_flashdata('message', 'Sorry you are not an admin.');
					redirect('jaz_auth_admin/home_page');					
				}
				
			}
			else 
			{
				//If login failed display error message.
				$this->session->set_flashdata('message', 'Invalid username or password.');
				redirect('jaz_auth_admin/home_page');
			}
			
		}
    }

	function email_user()
	{
		//Display reset password form.
		$this->data['mid_sec'] = $this->load->view('jaz_auth_admin/email_user_form', $this->data, TRUE);
		$this->load->view('jaz_auth_admin/adminpanel', $this->data);		
	}

	function email_user_process()
	{
		//Validate form.
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('msg', 'Message', 'required');
		
		if($this->form_validation->run($this) == FALSE)
		{
			//If validation has error display form again with error messages.			
			$this->email_user();
		}
		else
		{
			//capture data
			$user = $this->input->post('username', TRUE);
			$chkbox = FALSE;
			$msg = $this->input->post('msg', TRUE);
					
			//Check username if record exist.
			if(!$this->jaz_model->check_username($user))
			{
				//Display reset password form.
				$this->data['mid_sec'] = "<b>Sorry username doesn\'t exist.</b>";
				$this->load->view('jaz_auth_admin/adminpanel', $this->data);				
			}
			else 
			{
				//If validation form has no error, update password in the database.
				if($this->jaz_lib->send_msg($user, $chkbox, $msg))
				{
				//Display reset password form.
				$this->data['mid_sec'] = "<b>Message sent.</b>";
				$this->load->view('jaz_auth_admin/adminpanel', $this->data);					
				}
				else 
				{
					//Display reset password form.
					$this->data['mid_sec'] = "<b>Sending message failed.</b>";
					$this->load->view('jaz_auth_admin/adminpanel', $this->data);					
				}
			}
		}
	}
	
	function password_reset()
	{
		//Display reset password form.
		$this->data['mid_sec'] = $this->load->view('jaz_auth_admin/password_reset_form', $this->data, TRUE);
		$this->load->view('jaz_auth_admin/adminpanel', $this->data);					
	}

	function password_reset_process()
	{
		//Validate form.
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			//If validation has error display form again with error messages.			
			$this->password_reset();
		}
		else
		{
			//capture data
			$user = $this->input->post('username', TRUE);
			$pass = $this->input->post('password', TRUE);
						
			//If validation form has no error, update password in the database.
			if($this->jaz_model->reset_password($user, $pass))
			{
				
				$this->data['mid_sec'] = '<b>Reset password successful.</b>';
				$this->load->view('jaz_auth_admin/adminpanel', $this->data);					
			}
			else 
			{
				
				$this->data['mid_sec'] = '<b>Sorry password reset failed.</b>';
				$this->load->view('jaz_auth_admin/adminpanel', $this->data);	
			}
		}
	}

	//iFrame page for category extra, link1
	function stats()
	{
		//Initialize variables
		$this->data['total_admins'] = 0;
		$this->data['total_mods']   = 0;
		$this->data['total_users']  = 0;
		
		//Get count total number of Admins, Mods and Users from DB
		$q = $this->jaz_model->total_number();
		
		$this->data['total_admins'] = $q['admin_cnt'];
		$this->data['total_mods']   = 0; //reserved
		$this->data['total_users']  = $q['user_cnt'];		
		
		$this->data['mid_sec'] = $this->load->view('jaz_auth_admin/stats', $this->data, TRUE);
		$this->load->view('jaz_auth_admin/adminpanel', $this->data);			
	}
	
	//iFrame page for category extra, link2
	function history()
	{
		$this->data['mid_sec'] = $this->load->view('jaz_auth_admin/history', $this->data, TRUE);
		$this->load->view('jaz_auth_admin/adminpanel', $this->data);			
	}

	function delete_user()
	{
		//Display reset password form.
		$this->data['mid_sec'] = $this->load->view('jaz_auth_admin/delete_user_form', $this->data, TRUE);
		$this->load->view('jaz_auth_admin/adminpanel', $this->data);				
	}

	function delete_user_process()
	{
		//Validate form.
		$this->form_validation->set_rules('username', 'Username', 'required');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			//If validation has error display form again with error messages.			
			$this->delete_user();
		}
		else
		{
			//capture data
			$user = $this->input->post('username', TRUE);
						
			//If validation form has no error, update password in the database.
			if($this->jaz_model->delete_user($user))
			{
				
				$this->data['mid_sec'] = '<b>User account successfully deleted.</b>';
				$this->load->view('jaz_auth_admin/adminpanel', $this->data);					
			}
			else 
			{
				
				$this->data['mid_sec'] = '<b>Sorry user account deletion failed.</b>';
				$this->load->view('jaz_auth_admin/adminpanel', $this->data);					
			}
		}
	}
	
	//iFrame page for category extra, link2
	function viewedit_user()
	{
		$this->data['mid_sec'] = $this->load->view('jaz_auth_admin/view_edit_user_form', $this->data, TRUE);
		$this->load->view('jaz_auth_admin/adminpanel', $this->data);				
	}

	function viewedit_user_process()
	{		//Validate form.
		$this->form_validation->set_rules('username', 'Username', 'required');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			//If validation has error display form again with error messages.			
			$this->view_edit_user();
		}
		else
		{
			//capture data
			$user = $this->input->post('username', TRUE);
						
			//If validation form has no error, update password in the database.
			if($this->jaz_model->delete_user($user))
			{
				
				$this->data['mid_sec'] = '<b>User account successfully deleted.</b>';
				$this->load->view('jaz_auth_admin/adminpanel', $this->data);					
			}
			else 
			{
				
				$this->data['mid_sec'] = '<b>Sorry user account deletion failed.</b>';
				$this->load->view('jaz_auth_admin/adminpanel', $this->data);					
			}
		}
	}

	//iFrame page for category extra, link2
	function ban_user()
	{
		$this->data['mid_sec'] = $this->load->view('jaz_auth_admin/ban_user_form', $this->data, TRUE);
		$this->load->view('jaz_auth_admin/adminpanel', $this->data);		
	}

	function ban_user_process()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('reason', 'Reason', 'required');
		
		if ($this->form_validation->run($this) == FALSE)
		{
			//If validation has error display form again with error messages.			
			$this->ban_user();
		}
		else
		{
			//capture data
			$user = $this->input->post('username', TRUE);
			$reason = $this->input->post('reason', TRUE);

			//If the ban button is pressed execute the codes below.
			if(isset($_POST['ban']))
			{
				//Check first if username is already banned or if the username record is in the ban table.
				//If already in the table then the username is already banned just return false with message.
				if($this->jaz_model->is_ban($user))
				{
					
					$this->data['mid_sec'] = '<b>FYI, this username is already banned.';
					$this->load->view('jaz_auth_admin/adminpanel', $this->data);						
				}
				else 
				{
					//Check first the username if it is a valid member.
					if($this->jaz_model->is_member($user)) 
					{				
						//If validation form has no error, update password in the database.
						if($this->jaz_model->ban_user($user, $reason))
						{
							$this->data['mid_sec'] = '<b>User account successfully banned.</b>';
							$this->load->view('jaz_auth_admin/adminpanel', $this->data);								
						}
						else 
						{
							$this->data['mid_sec'] = '<b>Sorry ban failed.</b>';
							$this->load->view('jaz_auth_admin/adminpanel', $this->data);								
						}
					}
					else 
					{
						$this->data['mid_sec'] = '<b>Sorry the username is not in the member record list.</b>';	
						$this->load->view('jaz_auth_admin/adminpanel', $this->data);							
					}
				}
			}			
			
			//If the unban button is pressed execute the codes below.
			if(isset($_POST['unban']))
			{
				if($this->jaz_model->is_ban($user)) //Will return TRUE if it is in the ban table.
				{
					//Continue deleting the user in the ban table.
					if($this->jaz_model->unban_user($user))
					{
						$this->data['mid_sec'] = 'User account successfully unban/delete from ban table.';	
						$this->load->view('jaz_auth_admin/adminpanel', $this->data);							
					}
					else 
					{
						
						$this->data['mid_sec'] = 'Unban failed.';
						$this->load->view('jaz_auth_admin/adminpanel', $this->data);							
					}
				}
				else 
				{
					//else echo message, username is in not in the ban list table.
					
					$this->data['mid_sec'] = 'Sorry this username account is not banned.';
					$this->load->view('jaz_auth_admin/adminpanel', $this->data);						
				}				
			}			
		}
	}	

	function self_check()
	{
		echo Modules::run('self_check');			
	}

	//log the user out
	function logout()
	{
		$this->data['title'] = "Logout";

		//log the user out
		$logout = $this->jaz_lib->logout();

		//redirect them back to the page they came from
		redirect('jaz_auth_admin', 'refresh');
	}

##################################################
#				S P Y D E R 
##################################################	
/*
	1. User enter URL (create form)
	2. sanitize url value.
	3. Spyder scrape all emails
	4. Spyder save every 100 emails
	5. Spyder scrape URLs
	6. Spyder save URLs when spyder save emails
	7. Spyder verify each valid email while spyder scrape emails
	8. Spyder veirfy each valid URL while spyder scrape emails
	9. If email is valid save to valid table
	10. If email is invalid save to invalid table
	11. If url is valid save to valid url table
	12. If url is invalid save to invalid url tablle.
	13. Spyder stop crawling when it reach 1000 emails.
	14. Spyder record last url/email
*/
	
	function crawl_email() {
		$this->data['mid_sec'] = $this->load->view('jaz_auth_admin/crawl_email_form', $this->data, TRUE);
		$this->load->view('jaz_auth_admin/adminpanel', $this->data);			
	}
	
	function crawl_email_process() {
		$url = $this->input->post('url', TRUE);
		
        $ch = curl_init();  // Initialising cURL
        curl_setopt($ch, CURLOPT_URL, $url);    // Setting cURL's URL option with the $url variable passed into the function
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Setting cURL's option to return the webpage data
        $this->data['curl'] = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
        curl_close($ch);    // Closing cURL
        //return $data;   // Returning the data from the function
 		
 		
 		//$this->data['mid_sec'] = $this->load->view('jaz_auth_admin/crawling_form', $this->data, TRUE);
 		$this->data['mid_sec'] = $this->data['curl'];
		$this->load->view('jaz_auth_admin/adminpanel', $this->data);	

	}	


}

