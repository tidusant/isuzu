<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends MY_Controller {
	
	var $_render_data;
	
	public function __construct() {
		parent::__construct();
		$this->load->model(array('model_faq','settings/isuzu_setting_data'));
		$this->load->helper('text');
		$this->load->library('form_validation');
	}
	
	public function index($lang='') {
		
		$content_render = '';
		$content_render = $this->_render_content($lang);
		
		if($content_render!='') return $content_render;
		else show_404();
	}
	
	private function _render_content($lang='')
	{
		$sidebar_faq_limit = $this->isuzu_setting_data->get('faq_sidebar_show');
		$this->_render_data['faq_list'] = $this->model_faq->get_faq_list(0, 20, $lang);
		$this->_render_data['get_sidebar_faq'] = $this->model_faq->get_latest_faq($sidebar_faq_limit, $lang);
		
		// ask the question form
		$this->form_validation->set_rules('full_name', $this->lang->line('fullname_field'), 'required');
		$this->form_validation->set_rules('email', $this->lang->line('email_field'), 'required|valid_email');
		$this->form_validation->set_rules('phone', $this->lang->line('phone_field'), 'numeric');
		$this->form_validation->set_rules('content', $this->lang->line('comment_content_field'), 'required');
		
		$this->form_validation->set_message('required', $this->lang->line('form_message_required'));
		
		$this->form_validation->set_message('valid_email', $this->lang->line('form_message_validemail'));
		
		$this->form_validation->set_message('numeric', $this->lang->line('form_message_numeric'));
		
		if ($this->form_validation->run() !== FALSE) {
		
			if($this->input->post()) {
				
				$faq_question = trim(htmlspecialchars($this->input->post('content')));
				$ask_fullname = trim(htmlspecialchars($this->input->post('full_name')));
				$ask_phone = trim(htmlspecialchars($this->input->post('phone')));
				$ask_email = trim(htmlspecialchars($this->input->post('email')));
				$created_on = time() + (7*3600);
				$display_order = 9;
				$enable = '0'; // not active
				
				// saving
				$this->model_faq->save_faq_ask($faq_question, $ask_fullname, $ask_phone, $ask_email, $created_on, $display_order, $enable);
				$this->session->set_flashdata('success_comment', $this->lang->line('success_save_faq_form'));
				
			} else {
				$this->session->set_flashdata('failure_comment', $this->lang->line('failure_save_faq_form'));
			}
			
			redirect($this->uri->segment(1));
		}
		
		// loading effect sticky
		$this->_render_data['news_sticky_js'] = $this->_load_script_sticky('sidebar_ads');
		
		return $this->load->view('main/index', $this->_render_data);
	}
	
	private function _load_script_sticky($element_id='')
	{
		$element_sidebar_id = 'sidebar_sticky';
		if($element_id!='') $element_sidebar_id = $element_id;
		$js_script = '';
		$js_script = '
			<script src="'.base_url().'assets/js/jquery.easing.1.3.js"></script>
			<script src="'.base_url().'assets/js/stickysidebar.jquery.min.js"></script>
			<script type="text/javascript">
			  $(function () {
				$("#'.$element_sidebar_id.'").stickySidebar({
					timer: 300,
					easing: "easeInOutBack"
				});
			  });
			</script>
			';
		return $js_script;
	}
}