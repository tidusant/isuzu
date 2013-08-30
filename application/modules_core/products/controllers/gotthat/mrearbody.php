<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mrearbody extends Admin_Controller {
	
	private $_push;
	
	public function __construct()
	{
		parent::__construct();
		$this->_post_handler();
		$this->load->model('admin_model_rearbody');
		$this->load->helper(array('isuzu_image', 'isuzu_date', 'text', 'myhelp_helper'));
		$this->load->language('product');
	}
	
	public function index() { // list
		
		$which_page = $this->uri->segment(3);
		$content_render = '';
		
		switch($which_page) {
			case 'form':
				$content_render = $this->_manage_rearbody();// add or edit
				break;
			case 'delete':
				$content_render = $this->_delete_rearbody();// delete
				break;
			default:
				$content_render = $this->_list_rearbody(); // just list user
		}
		
		if($content_render!='') return $content_render;
		else show_404();
		
	}
	
	private function _list_rearbody()
	{
		$this->redir->set_last_index();
		
		$show = uri_assoc('show');
		
		$params['order_by'] = 'rearbody.updated_on DESC';

		$this->_push['rearbody'] = $this->admin_model_rearbody->get($params);

		return $this->load->view('admin/rearbody/list', $this->_push);
	}
	
	public function _manage_rearbody() {
		
		$this->load->helper('isuzu_js');
		
		$this->_push['action_type'] = $this->lang->line('editing_action');
		
		$this->_push['tinymce_init'] = load_tinymce_plugin();
		
		$r_id = uri_assoc('r_id');

		if ($this->admin_model_rearbody->validate()) {

			$this->admin_model_rearbody->save();

			$r_id = ($r_id) ? $r_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('r_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('rearbody_module'), $log_action_type, $this->lang->line('accessory_name').': '.$this->admin_model_rearbody->form_value('accessory_name').' at '.format_date(time()));
			
			redirect($this->uri->segment(1).'/rearbody/index');

		}

		else {
		
			if (!$_POST AND $r_id) {

				$this->admin_model_rearbody->prep_validation($r_id);
				
			} else {
				
				$this->_push['action_type'] = $this->lang->line('adding_action');
			}
			
			$this->_push['rearobj_en'] = $this->admin_model_rearbody->get_rearbody_lang($r_id);
			
			return $this->load->view('admin/rearbody/form', $this->_push);

		}

	}

	public function _delete_rearbody() {

		$r_id = uri_assoc('r_id');

		if ($r_id) {

			$this->admin_model_rearbody->delete($r_id);
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('rearbody_module'), 'Deleted', $this->lang->line('accessory_name').': '.$this->admin_model_rearbody->get_rearbody_name($r_id).' at '.format_date(time()));
			
		}

		$this->redir->redirect($this->uri->segment(1).'/rearbody/index');
	}

	function _post_handler() {

		if ($this->input->post('btn_cancel')) {

			redirect($this->session->userdata('last_index'));

		}

	}
	
}