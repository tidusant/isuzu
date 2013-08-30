<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mpage extends Admin_Controller {

	private $_push;
	
	public function __construct() {
		parent::__construct();
		$this->_post_handler();
		$this->load->model('admin_model_page');
		$this->load->helper(array('isuzu_image', 'isuzu_date', 'text', 'myhelp_helper'));
		$this->load->language('page');
	}
	
	public function index()
	{
		$which_page = $this->uri->segment(3);
		$content_render = '';
		
		switch($which_page) {
			case 'form':
				$content_render = $this->_manage_page();// add or edit
				break;
			case 'delete':
				$this->_delete_page();// delete
			default:
				$content_render = $this->_list_pages(); // just list user
		}
		
		if($content_render!='') return $content_render;
		else show_404();
	}
	
	private function _list_pages()
	{
		$this->redir->set_last_index();
		
		/*$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page'),
			'order_by'	=> 'pages.updated_on asc'
		);*/
		
		$this->_push['pages'] = $this->admin_model_page->get_list_page_index();

		return $this->load->view('admin/page/list', $this->_push);
	}
	
	public function _manage_page() {
		
		$this->load->model(array('admin_model_pagetree', 'admin_model_menu'));
		
		$this->load->helper('isuzu_js');
		
		$this->_push['action_type'] = $this->lang->line('editing_action');
		
		$this->_push['extended_js'] = load_extended_js('page_name'); // generate slug
		
		$this->_push['tinymce_init'] = load_tinymce_plugin();
		
		$this->_push['pagetree_list'] = $this->admin_model_pagetree->get_list_page_tree();
		
		$this->_push['pagemenu_list'] = $this->admin_model_menu->get_root_list_menu();
		
		$page_id = uri_assoc('page_id');

		if ($this->admin_model_page->validate()) {

			$this->admin_model_page->save();

			$page_id = ($page_id) ? $page_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('page_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('page_module'), $log_action_type, $this->lang->line('page_name').': '.$this->admin_model_page->form_value('page_title').' at '.format_date(time()));
			
			redirect($this->uri->segment(1).'/pages/index');

		}

		else {

			if (!$_POST AND $page_id) {

				$this->admin_model_page->prep_validation($page_id);
				
			} else {
				
				$this->_push['action_type'] = $this->lang->line('adding_action');
			}

			$this->load->helper('text');

			$page_id = uri_assoc('page_id');
			
			$this->_push['page_lang_obj'] = $this->admin_model_page->get_page_lang($page_id);
			
			return $this->load->view('admin/page/form', $this->_push);

		}

	}

	public function _delete_page() {

		$page_id = uri_assoc('page_id');

		if ($page_id) {
			
			$this->admin_model_page->delete($page_id);
			
			$page_name = $this->admin_model_page->get_page_title($page_id);
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('page_module'), 'Deleted', $this->lang->line('page_title').': '.$page_name.' at '.format_date(time()));
			
		}

		$this->redir->redirect($this->uri->segment(1).'/pages/index');
	}
	
	
	function _post_handler() {

		if ($this->input->post('btn_cancel')) {

			redirect($this->session->userdata('last_index'));

		}

	}
	
}

/* End of file mpage.php */
/* Location: ./application/controllers/pages.php */