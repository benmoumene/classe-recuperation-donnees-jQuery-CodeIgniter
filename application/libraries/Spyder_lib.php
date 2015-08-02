<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spyder_lib {
/*
	1. User enter URL (create form)
	1.b sanitize url value.
		sanitize_url()
	2. Spyder scrape the url with emails
		scrape_url()
	3. Spyder save every 100 emails
		save_100()
		Spyder save URLs when spyder save emails
	6. Spyder verify each valid email while spyder scrape emails
		verify_email()
		verify_url()
	7. Spyder verify each valid URL while spyder scrape emails
	8. If email is valid save to valid table
	9. If email is invalid save to invalid table
	10. If url is valid save to valid url table
	11. If url is invalid save to invalid url tablle
	13. Spyder record/get last url/email
*/	
	
	public $data = array(
                   '' => '',
				);
	
	protected $CI;
				
	public function __construct()
	{
		$this->CI =& get_instance();

	  /*
		$this->CI->load->helper('url');
		$this->CI->load->library('session');
		$this->CI->config->item('base_url');
	 */

	}

    public function sanitize_url($url)
    {
    	if() {
    		
    	}
    	
    }

    public function scrape_url()
    {
    	
    }
	
    public function save_100()
    {
    	
    }
	
    public function verify_email()
    {
    	
    }
	
    public function verify_url()
    {
    	
    }
	
    public function ()
    {
    	
    }				
	
#####################################################################
#	For Testing...
#####################################################################


	
		
}