<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mpart extends Admin_Controller {
	
	private $_push;
	
	public function __construct()
	{
		parent::__construct();
		$this->_post_handler();
		$this->load->model(array('admin_model_part', 'admin_model_category'));
		$this->load->helper(array('isuzu_image', 'isuzu_date', 'text', 'myhelp_helper'));
		$this->load->language('product');
	}
	
	public function index() { // list
		
		
		$which_page = $this->uri->segment(3);
		$content_render = '';
		
		switch($which_page) {
			case 'form':
				$content_render = $this->_manage_part();// add or edit
				break;
			case 'delete':
				$this->_delete_part();// delete
				break;
			default:
				$content_render = $this->_list_part(); // just list user
		}
		
		if($content_render!='') return $content_render;
		else show_404();
		
	}
	
	private function _list_part()
	{
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);
		

		$this->_push['parts'] = $this->admin_model_part->get($params);

		return $this->load->view('admin/part/list', $this->_push);
	}
	
	private function _manage_part() {
		
		$this->load->helper('isuzu_js');
		
		$this->load->model('admin_model_category');
		
		$this->_push['action_type'] = $this->lang->line('editing_action');
		
		$this->_push['tinymce_init'] = load_tinymce_plugin();
		
		$this->_push['category_list'] = $this->admin_model_category->get_list_categories();
		
		$pa_id = uri_assoc('pa_id');

		if ($this->admin_model_part->validate()) {

			$this->admin_model_part->save();

			$pa_id = ($pa_id) ? $pa_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('pa_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('part_module'), $log_action_type, $this->lang->line('part_name').': '.$this->admin_model_part->form_value('part_name').' at '.format_date(time()));
			
			redirect($this->uri->segment(1).'/parts/index');

		}

		else {
		
			if (!$_POST AND $pa_id) {

				$this->admin_model_part->prep_validation($pa_id);
				
			} else {
				
				$this->_push['action_type'] = $this->lang->line('adding_action');
			}
			
			// get lang
			$this->_push['partobj_en'] = $this->admin_model_part->get_part_lang($pa_id);
			
			return $this->load->view('admin/part/form', $this->_push);

		}

	}

	public function _delete_part() {

		$pa_id = uri_assoc('pa_id');

		if ($pa_id) {

			$this->admin_model_part->delete($pa_id);
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('part_module'), 'Deleted', $this->lang->line('part_name').': '.$this->admin_model_part->get_part_name($pa_id).' at '.format_date(time()));
			
		}

		$this->redir->redirect($this->uri->segment(1).'/parts/index');
	}

	function _post_handler() {

		if ($this->input->post('btn_cancel')) {

			redirect($this->session->userdata('last_index'));

		}

	}
	
}