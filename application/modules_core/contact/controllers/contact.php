<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends MY_Controller {
	
	var $_render_data;
	
	public function __construct() {

		parent::__construct();
		$this->load->model('settings/isuzu_setting_data');
		$this->load->library('form_validation');
	}
	
	public function index() {
		
		$content_render = '';
		$content_render = $this->_contact_form();
		
		if($content_render!='') return $content_render;
		else show_404();
		
	}
	
	private function _contact_form() {
		
		$this->form_validation->set_rules('fullname', $this->lang->line('contact_fullname_field'), 'required|htmlspecialchars|addslashes');
		$this->form_validation->set_rules('email', $this->lang->line('email_field'), 'required|valid_email|htmlspecialchars|addslashes');
		$this->form_validation->set_rules('phone', $this->lang->line('contact_phone_field'), 'required|numeric|htmlspecialchars|addslashes');
		$this->form_validation->set_rules('fax', $this->lang->line('contact_phone_field'), 'numeric|htmlspecialchars|addslashes');
		$this->form_validation->set_rules('subject', $this->lang->line('contact_subject_field'), 'required|htmlspecialchars|addslashes');
		$this->form_validation->set_rules('content', $this->lang->line('comment_content_field'), 'required|max_length[500]|addslashes');

		if ($this->form_validation->run() !== FALSE) {
			
			if($this->input->post()) {
				
				$fullname = trim(htmlspecialchars($this->input->post('fullname')));
				$email = trim(htmlspecialchars($this->input->post('email')));
				$phone = trim(htmlspecialchars($this->input->post('phone')));
				$fax = trim(htmlspecialchars($this->input->post('fax')));
				$address = trim(htmlspecialchars($this->input->post('address')));
				$company = trim(htmlspecialchars($this->input->post('company')));
				$subject = trim(htmlspecialchars($this->input->post('subject')));
				$content = trim($this->input->post('content'));
				$date_received = intval(time());
				
				// saving
				$contact_id = $this->isuzu_setting_data->save_contacter($fullname, $email, $phone, $fax, $address, $company, $subject, $content, $date_received);
				
				if($contact_id > 0) $this->session->set_flashdata('success_comment', $this->lang->line('success_save_reg_form'));
				
			} else {
				$this->session->set_flashdata('failure_comment', $this->lang->line('failure_save_reg_form'));
			}
			
			redirect($this->uri->uri_string());
		}
		
		return $this->load->view('contact/main/index', $this->_render_data);
	}
	
}

/* End of file contact.php */
/* Location: ./application/controllers/contact.php */