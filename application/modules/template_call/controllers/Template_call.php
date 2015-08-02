<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template_call extends MX_Controller
{
	
	
/******************************************************
 * Utility Methods
 *****************************************************/
	function index()
	{
		$data['header_content'] = '<center>This is the Header</center>';
		//$data['header'] = Module::run('header', $data, TRUE)
		$data['mid_content'] = '<center>This is the Middle content</center>';
		$data['footer_content'] = '<center>This is the Footer</center>';
		//$data['footer'] = Module::run('footer', $data, TRUE)
		
		$data['module'] = "template_test";
		echo Modules::run('template_test/master', $data);
		
	}
	
}
