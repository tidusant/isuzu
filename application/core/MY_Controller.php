<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller {

	function __construct($var_required = NULL) {

		parent::__construct();

		$this->load->database();
		
		$this->load->helper('url');
		
		$this->load->helper('language');
		
		$this->load->helper('isuzu_image');
		
		$this->load->config('custom');
		
		$site_lang = $this->session->userdata('site_lang');
        if ($site_lang) {
            $this->lang->load('isuzu',$this->session->userdata('site_lang'));
        } else {
            $this->lang->load('isuzu','vietnamese');
        }
		
	}

}

?>