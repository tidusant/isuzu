<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mpagetree extends Admin_Controller {

	private $_push;
	
	public function __construct() {
		parent::__construct();
		$this->_post_handler();
		$this->load->model('admin_model_pagetree');
		$this->load->helper(array('isuzu_image', 'isuzu_date', 'text', 'myhelp_helper'));
		$this->load->language('page');
		
	}
	
	public function index() {
		
		$which_page = $this->uri->segment(3);
		$content_render = '';
		
		switch($which_page) {
			case 'form':
				$content_render = $this->_manage_pagetree();// add or edit
				break;
			case 'delete':
				$this->_delete_pagetree();// delete
			default:
				$content_render = $this->_list_pagetree(); // just list user
		}
		
		if($content_render!='') return $content_render;
		else show_404();
		
	}
	
	private function _list_pagetree()
	{
		
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);
		
		$show = uri_assoc('show');
		
		$params['order_by'] = 'page_tree.pt_id asc';
		
		if ($show == 'active') {
			
			$params['where']['page_tree.active'] = 1;
			
		}
		
		elseif ($show == 'inactive') {
			
			$params['where']['page_tree.active'] = 0;
			
		}

		$this->_push['pagetrees'] =	$this->admin_model_pagetree->get($params);

		return $this->load->view('admin/pagetree/list', $this->_push);
	}
	
	public function _manage_pagetree() {
		
		$this->load->helper('isuzu_js');
		
		$this->_push['action_type'] = $this->lang->line('editing_action');
		
		$this->_push['extended_js'] = load_extended_js('pt_name'); // generate slug
		
		$pt_id = uri_assoc('pt_id');

		if ($this->admin_model_pagetree->validate()) {
			
			$this->admin_model_pagetree->save();

			$pt_id = ($pt_id) ? $pt_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('pt_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('pagetree_module'), $log_action_type, $this->lang->line('pagetree_name').': '.$this->admin_model_pagetree->form_value('pt_name').' at '.format_date(time()));
			
			redirect($this->uri->segment(1).'/pagetree/index');

		}

		else {

			if (!$_POST AND $pt_id) {

				$this->admin_model_pagetree->prep_validation($pt_id);
				
			} else {
				
				$this->_push['action_type'] = $this->lang->line('adding_action');
			}

			$this->load->helper('text');

			$pt_id = uri_assoc('pt_id');

			$page_params = array(
				'where'	=>	array(
					'pagetree.pt_id'	=>	$pt_id
				)
			);
			
			return $this->load->view('admin/pagetree/form', $this->_push);

		}

	}

	private function _delete_pagetree() {

		$pt_id = uri_assoc('pt_id');

		if ($pt_id) {
			
			$this->admin_model_pagetree->delete($pt_id);
			
			$pagetree_name = $this->admin_model_pagetree->get_pagetree_name($pt_id);
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('pagetree_module'), 'Deleted', $this->lang->line('page_title').': '.$page_name.' at '.format_date(time()));
			
		}

		$this->redir->redirect($this->uri->segment(1).'/pagetree/index');
	}

	function _post_handler() {
		
		if ($this->input->post('btn_cancel')) {

			redirect($this->session->userdata('last_index'));

		}

	}
	
}

/* End of file mpage.php */
/* Location: ./application/controllers/pages.php */