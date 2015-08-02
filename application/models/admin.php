<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller
{
    function __construct ()
    {
        parent::__construct();
        
		$this->data['message'] = '';
		$this->data['title'] = 'AdminS9 Control Panel';
		
        $this->load->model('users_model');
    }
    
    function index(){
		$this->data['password_header'] = $this->load->view('admin/password_header', $this->data, TRUE);
		$this->load->view('admin/password', $this->data);		
    }
	
	//main page
	function home_page()
	{
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['password_header'] = $this->load->view('admin/password_header', $this->data, TRUE);

		$this->load->view('admin/password', $this->data);
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
		
		
		$this->data['total_admins'] = 0;
		$this->data['total_mods']   = 0;
		$this->data['total_users']  = 0;		
		
		$this->load->view('admin/stats', $this->data);		
	}
	
	//iFrame page for category extra, link2
	function extra_link2()
	{
		$this->load->view('admin/extra2', $this->data);		
	}
	
	//iFrame page for category extra, link3
	function extra_link3()
	{
		$this->load->view('admin/extra3', $this->data);		
	}		
	
    function login(){
		//validate form
		//capture data
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
			
			if($this->users_model->login($username, $password))
			{
				//Check username and password in DB as Administrator User.
				if($this->users_model->is_admin($username, $password))
				{
					//If everything is okay redirect to Admin Conrol Panel.
					$this->data['cpanel_header'] = $this->load->view('admin/cpanel_header', $this->data, TRUE);
					$this->load->view('admin/admincpanel', $this->data);
				}
				else 
				{
					//If login failed display error message.
					$this->session->set_flashdata('message', 'Sorry you are not an admin.');
					redirect('admin/admin/home_page');					
				}
				
			}
			else 
			{
				//If login failed display error message.
				$this->session->set_flashdata('message', 'Invalid username or password.');
				redirect('admin/admin/home_page');
			}
			
		}
    }

/********************************************************************
 * 				Below are for testing purpose only. 				*
 ********************************************************************/
	function show_total_number(){
		$total_number = $this->jaz_model->total_number(); 
		
		echo '<pre>';
		print_r($total_number);
		echo '</pre>';
		
		echo '<br>';
		echo 'user_cnt: '. $total_number['user_cnt'];
	}
 	
}