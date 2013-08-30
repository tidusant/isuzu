<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mfaq extends Admin_Controller {
	
	private $_push;
	
	public function __construct()
	{
		parent::__construct();
		$this->_post_handler();
		$this->load->model('admin_model_faq');
		$this->load->helper(array('isuzu_image', 'isuzu_date', 'text', 'myhelp_helper'));
		$this->load->language('faq');
		
	}
	
	public function index() { // list
		
		$which_page = $this->uri->segment(3);
		$content_render = '';
		
		switch($which_page) {
			case 'form':
				$content_render = $this->_manage_faq();// add or edit
				break;
			case 'delete':
				$this->_delete_faq();// delete
			default:
				$content_render = $this->_list_faq(); // just list user
		}
		
		if($content_render!='') return $content_render;
		else show_404();
		
	}
	
	private function _list_faq()
	{
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);

		$this->_push['faqs'] = $this->admin_model_faq->get($params);

		return $this->load->view('admin/list', $this->_push);
	}
	
	public function _manage_faq() {
		
		$this->load->helper('isuzu_js');
		
		$this->_push['action_type'] =  $this->lang->line('editing_action');
		
		$this->_push['tinymce_init'] = load_tinymce_plugin();
		
		$faq_id = uri_assoc('f_id');

		if ($this->admin_model_faq->validate()) {

			$this->admin_model_faq->save();

			$faq_id = ($faq_id) ? $faq_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('faq_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('faq_module'), $log_action_type, $this->lang->line('faq_question').': '.$this->admin_model_faq->form_value('faq_question').' at '.format_date(time()));
			
			redirect($this->uri->segment(1).'/faqs/index');

		}

		else {

			if (!$_POST AND $faq_id) {

				$this->admin_model_faq->prep_validation($faq_id);
				
			} else {
				
				$this->_push['action_type'] = $this->lang->line('adding_action');
				
			}
			
			if(uri_assoc('f_id')) {
				// get lang
				$this->_push['faqobj_en'] = $this->admin_model_faq->get_faq_lang($faq_id);
			}
			
			return $this->load->view('admin/form', $this->_push);

		}

	}

	private function _delete_faq() {

		$faq_id = uri_assoc('f_id');

		if ($faq_id) {

			$this->admin_model_faq->delete($faq_id);
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('faq_module'), 'Deleted', $this->lang->line('faq_question').': '.$this->admin_model_faq->get_faq_question($faq_id).' at '.format_date(time()));
			
		}

		$this->redir->redirect($this->uri->segment(1).'/faqs/index');
	}
	
	function _post_handler() {

		if ($this->input->post('btn_cancel')) {

			redirect($this->session->userdata('last_index'));

		}

	}
	
}