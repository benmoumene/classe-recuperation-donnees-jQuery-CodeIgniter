<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template_test extends MX_Controller
{
	
	function master($data) {
		$this->load->view('master', $data);
	}

}

