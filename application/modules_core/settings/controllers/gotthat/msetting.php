<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msetting extends Admin_Controller {

	private $_push;
	
	public function __construct() {
		parent::__construct();
		$this->_post_handler();
		$this->load->helper(array('isuzu_image', 'isuzu_date'));
		$this->load->language('setting');
		
	}
	
	function index() {
		
		$page = $this->uri->segment(3);
		$content_render = '';
		
		if($page=='save') {
			$this->_save_setting();
		} else $content_render = $this->_show_setting();
		
		if($content_render!='') return $content_render;
		else show_404();
		
	}
	
	private function _show_setting()
	{
		return $this->load->view('admin/list', $this->_push);
	}
	
	private function _save_setting() {
		
		// general setting
		$this->isuzu_setting_data->save('default_date_format', $this->input->post('default_date_format', TRUE));
		
		$this->isuzu_setting_data->save('results_per_page', $this->input->post('results_per_page', TRUE));

        $this->isuzu_setting_data->save('application_title', $this->input->post('application_title', TRUE));
		
		$this->isuzu_setting_data->save('setting_contact_footer', $this->input->post('setting_contact_footer', TRUE));
		
		$this->isuzu_setting_data->save('setting_intro_above_drive_1', $this->input->post('setting_intro_above_drive_1', TRUE));
		
		$this->isuzu_setting_data->save('setting_intro_above_drive_2', $this->input->post('setting_intro_above_drive_2', TRUE));
		
		// social setting
		$this->isuzu_setting_data->save('setting_facebook_script', $this->input->post('setting_facebook_script', TRUE));
		
		$this->isuzu_setting_data->save('setting_twitter_script', $this->input->post('setting_twitter_script', TRUE));
		
		$this->isuzu_setting_data->save('setting_gplus_script', $this->input->post('setting_gplus_script', TRUE));
		
		// other setting
		$this->isuzu_setting_data->save('home_show_promotion', $this->input->post('setting_home_show_promotion', TRUE));
		
		$this->isuzu_setting_data->save('home_show_news', $this->input->post('setting_home_show_news', TRUE));
		
		$this->isuzu_setting_data->save('home_show_product', $this->input->post('setting_home_show_product', TRUE));
		
		$this->isuzu_setting_data->save('sidebar_show_news', $this->input->post('setting_sidebar_show_news', TRUE));
		
		$this->isuzu_setting_data->save('faq_sidebar_show', $this->input->post('setting_sidebar_show_faq', TRUE));
		
		// save to lang
		$this->isuzu_setting_data->save_lang('setting_contact_footer', $this->input->post('setting_contact_footer_en', TRUE));
		
		$this->isuzu_setting_data->save_lang('setting_intro_above_drive_1', $this->input->post('setting_intro_above_drive_1_en', TRUE));
		
		$this->isuzu_setting_data->save_lang('setting_intro_above_drive_2', $this->input->post('setting_intro_above_drive_2_en', TRUE));
		
		redirect($this->uri->segment(1).'/settings/index');
	}
	
	function _post_handler() {
		
		if ($this->input->post('btn_cancel')) {

			redirect($this->session->userdata('last_index'));

		}

	}
	
}

/* End of file authors.php */
/* Location: ./application/controllers/authors.php */