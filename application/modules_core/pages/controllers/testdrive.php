<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testdrive extends MY_Controller {
	
	var $_render_data;
	var $_cur_lang;
	public function __construct() {

		parent::__construct();
		$this->load->model(array('model_page', 'banners/model_banner', 'products/model_product', 'products/model_category','pages/model_page', 'settings/isuzu_setting_data'));
		$this->load->library('pagination');
		$this->load->helper('text');
	}
	
	function index($lang='') {
		$this->_cur_lang = $lang;
		$content_render = '';
		$content_render = $this->_render_content($lang);
		
		if($content_render!='') return $content_render;
		else show_404();
		
	}
	
	private function _render_content($lang='') {
		
		$this->_render_data['intro_above_form_1'] = $this->isuzu_setting_data->get_setting_front_end('setting_intro_above_drive_1', $lang);
		
		$this->_render_data['intro_above_form_2'] = $this->isuzu_setting_data->get_setting_front_end('setting_intro_above_drive_2', $lang);
		
		// list city
		$this->load->helper('myhelp');
		// form
		$this->_render_data['selectbox_catalog_list'] = $this->model_category->get_category_menu($lang);
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('fullname', $this->lang->line('testdriveform_fullname'), 'required');
		//$this->form_validation->set_rules('email', $this->lang->line('email_field'), 'valid_email');
		$this->form_validation->set_rules('phone', $this->lang->line('testdriveform_phone'), 'required');
		$this->form_validation->set_rules('birthdate', $this->lang->line('testdriveform_birthdate'), 'required');
		$this->form_validation->set_rules('model_select', $this->lang->line('testdriveform_item_registered'), 'required');
		
		$this->form_validation->set_message('required', $this->lang->line('form_message_required'));
		
		$this->form_validation->set_message('valid_email', $this->lang->line('form_message_validemail'));
		
		if ($this->form_validation->run() !== FALSE) {
			
			if($this->input->post()) {
				
				$full_name = trim(htmlspecialchars($this->input->post('fullname')));
				$gender = trim(htmlspecialchars($this->input->post('gender')));
				$birthdate = trim(htmlspecialchars($this->input->post('birthdate')));
				$company = trim(htmlspecialchars($this->input->post('company')));
				$form_email = trim(htmlspecialchars($this->input->post('email')));
				$phone = trim(htmlspecialchars($this->input->post('phone')));
				$address = trim(htmlspecialchars($this->input->post('address')));
				$city = trim(htmlspecialchars($this->input->post('city').' - '.$this->input->post('country')));
				$item_owner = trim(htmlspecialchars($this->input->post('model_owning')));
				$item_registered = trim(htmlspecialchars($this->input->post('model_select')));
				$date_received = time();
				
				// database saving
				$this->model_page->save_test_drive_regform($full_name, $gender, $birthdate, $company, $form_email, $phone, $address, $city, $item_owner, $item_registered, $date_received);
				$this->session->set_flashdata('success_comment', $this->lang->line('success_save_reg_form'));
				/// and sendmail
				
			} else {
				$this->session->set_flashdata('failure_comment', $this->lang->line('failure_save_reg_form'));
			}
			
			redirect($this->uri->uri_string());
		}
		
		return $this->load->view('testdrivereg/index', $this->_render_data);
		
	}
	
}

/* End of file authors.php */
/* Location: ./application/controllers/authors.php */