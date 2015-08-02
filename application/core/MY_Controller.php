<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public $data = array(
                   'username' => '',
                   'message' => '',
                   'member_menu' => '',
				);
				
	public $cookie_life = '';
	public $cookie_dname = '';
	
    function __construct ()
    {
        parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');		
		$this->load->library('jaz_lib');
		$this->load->model('jaz_model');
		$this->config->load('jaz_config');

		//fetching data from config
		$this->cookie_life = $this->config->item('cookie_life');
		$this->cookie_dname = $this->config->item('cookie_dname');
    }


/**************************************************************
 * Below are for tesing purpose only.
 **************************************************************/
	function show_config()
	{
		echo ':MY_Controller:';
		echo '<br>Cookie Life: ' . $this->cookie_life;
		echo '<br>Cookie Dname: '. $this->cookie_dname;
	}
	
}