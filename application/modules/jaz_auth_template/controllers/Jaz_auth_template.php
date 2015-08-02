<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jaz_auth_template extends MX_Controller
{
/*****************************************************
 * Miscellaneous methods
 *****************************************************/
 	function __construct() {
		 parent::__construct();
	 }
 
	function header_sec($data) {
		$this->load->view('header', $data);
	}
	
	function master_sec($data) {
		$this->load->view('master', $data);
	}

	function header_member($data) {
		$this->load->view('header_member', $data);
	}

}

