<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Langloader extends MX_Controller {
	
	function __construct() {

		parent::__construct();
        $this->load->helper('url');
	}
	
	public function index()
	{
			$this->output->set_header("HTTP/1.0 200 OK");
			$this->output->set_header("HTTP/1.1 200 OK");
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
			$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache");
		$switch_url = $this->uri->segment(1);
		$to_url = $this->uri->segment(2);
		$switch_to_lang = $this->uri->segment(3);
		// check 3 parameter
		if($switch_url=='language' && $to_url=='to' && $switch_to_lang!='') $this->_switchlang($switch_to_lang);
		else show_404();
	}
	
	private function _switchlang($language="")
	{
		$language = ($language != "") ? $language : "vietnamese"; // default is vietnamese
        $this->session->set_userdata('site_lang', $language);
		$this->config->set_item('language',$language);

		$tempUrl = $this->input->server('HTTP_REFERER');
        redirect(substr($tempUrl, 0, strpos($tempUrl,'?') > 0 ? strpos($tempUrl,'?') : strlen($tempUrl)).'?lang='.$language);
	}
}

/* End of file langloader.php */
/* Location: ./application/controllers/langloader.php */