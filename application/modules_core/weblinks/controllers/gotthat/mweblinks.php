<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mweblinks extends Admin_Controller {
	
	private $_push;
	
	public function __construct()
	{
		parent::__construct();
		$this->_post_handler();
		$this->load->model('admin_model_weblink');
		$this->load->helper(array('isuzu_image', 'isuzu_date', 'text', 'myhelp_helper'));
		$this->load->language('weblink');
		
	}
	
	public function index() { // list
		
		$which_page = $this->uri->segment(3);
		$content_render = '';
		
		switch($which_page) {
			case 'form':
				$content_render = $this->_manage_weblink();// add or edit
				break;
			case 'delete':
				$this->_delete_weblink();// delete
				break;
			default:
				$content_render = $this->_list_weblink(); // just list user
		}
		
		if($content_render!='') return $content_render;
		else show_404();
		
	}
	
	private function _list_weblink() {
		
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);

		$this->_push['weblinks'] = $this->admin_model_weblink->get($params);

		return $this->load->view('admin/list', $this->_push);
	}
	
	private function _manage_weblink() {
		
		$this->_push['action_type'] =  $this->lang->line('editing_action');
		
		$weblink_id = uri_assoc('weblink_id');

		if ($this->admin_model_weblink->validate()) {

			$this->admin_model_weblink->save();

			$weblink_id = ($weblink_id) ? $weblink_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('weblink_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('weblink_module'), $log_action_type, $this->lang->line('weblink_name').': '.$this->admin_model_weblink->form_value('title').' at '.format_date(time()));
			
			redirect($this->uri->segment(1).'/web-links/index');

		}

		else {

			if (!$_POST AND $weblink_id) $this->admin_model_weblink->prep_validation($weblink_id);
			else $this->_push['action_type'] = $this->lang->line('adding_action');
			
			return $this->load->view('admin/form', $this->_push);
		}

	}

	private function _delete_weblink() {

		$weblink_id = uri_assoc('weblink_id');

		if ($weblink_id) {

			$this->admin_model_weblink->delete($weblink_id);
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('weblink_module'), 'Deleted', $this->lang->line('weblink_name').': '.$this->admin_model_weblink->get_weblink_title($weblink_id).' at '.format_date(time()));
			
		}

		$this->redir->redirect($this->uri->segment(1).'/web-links/index');
	}
	 
	function _post_handler() {

		if ($this->input->post('btn_cancel')) {

			redirect($this->session->userdata('last_index'));

		}

	}
	
}