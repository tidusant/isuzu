<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Maccessory extends Admin_Controller {
	
	private $_push;
	
	public function __construct()
	{
		parent::__construct();
		$this->_post_handler();
		$this->load->model('admin_model_accessory');
		$this->load->helper(array('isuzu_image', 'isuzu_date', 'text', 'myhelp_helper'));
		$this->load->language('product');
	}
	
	public function index() { // list
		
		$which_page = $this->uri->segment(3);
		$content_render = '';
		
		switch($which_page) {
			case 'form':
				$content_render = $this->_manage_accessory();// add or edit
				break;
			case 'delete':
				$content_render = $this->_delete_accesssory();// delete
				break;
			default:
				$content_render = $this->_list_accessories(); // just list user
		}
		
		if($content_render!='') return $content_render;
		else show_404();
		
	}
	
	private function _list_accessories()
	{
		$this->redir->set_last_index();
		
		$show = uri_assoc('show');
		
		$params['order_by'] = 'accessories.updated_on DESC';

		$this->_push['accessories'] = $this->admin_model_accessory->get($params);

		return $this->load->view('admin/accessory/list', $this->_push);
	}
	
	private function _manage_accessory() {
		
		$this->load->helper('isuzu_js');
		
		$this->_push['action_type'] = $this->lang->line('editing_action');
		
		$this->_push['tinymce_init'] = load_tinymce_plugin();
		
		$a_id = uri_assoc('a_id');

		if ($this->admin_model_accessory->validate()) {

			$this->admin_model_accessory->save();

			$a_id = ($a_id) ? $a_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('a_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('accessory_module'), $log_action_type, $this->lang->line('accessory_name').': '.$this->admin_model_accessory->form_value('accessory_name').' at '.format_date(time()));
			
			redirect($this->uri->segment(1).'/accessories/index');

		}

		else {
		
			if (!$_POST AND $a_id) {

				$this->admin_model_accessory->prep_validation($a_id);
				
			} else {
				
				$this->_push['action_type'] = $this->lang->line('adding_action');
			}
			
			$this->_push['accessoryobj_en'] = $this->admin_model_accessory->get_accessory_lang($a_id);
			
			return $this->load->view('admin/accessory/form', $this->_push);

		}

	}

	private function _delete_accesssory() {

		$a_id = uri_assoc('a_id');

		if ($a_id) {

			$this->admin_model_accessory->delete($a_id);
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('accessory_module'), 'Deleted', $this->lang->line('accessory_name').': '.$this->admin_model_accessory->get_accessory_name($a_id).' at '.format_date(time()));
			
		}

		$this->redir->redirect($this->uri->segment(1).'/accessories/index');
	}

	function _post_handler() {

		if ($this->input->post('btn_cancel')) {

			redirect($this->session->userdata('last_index'));

		}

	}
	
}