<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fuck extends MX_Controller {
	
	function __construct() {

		parent::__construct();
		
		$this->load->database();
		$this->load->library('session');
	}
	
	public function _remap()
	{
		$nhanbiet_url = $this->uri->segment(1);		
		$html = $nhanbiet_url == 'cmsmanage'?$this->admin():$this->front();
		$this->output->set_output($html);
	}
	function admin()
	{
		return modules::run('administration');
	}
	function front()
	{
		return modules::run('home/index');
	}
}

/* End of file fuck.php */
/* Location: ./application/controllers/fuck.php */