<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mmenu extends Admin_Controller {

	private $_push;
	
	public function __construct() {
		parent::__construct();
		$this->_post_handler();
		$this->load->model('admin_model_menu');
		$this->load->helper(array('isuzu_image', 'isuzu_date', 'text', 'myhelp_helper'));
		$this->load->language('page');
	}
	
	public function index()
	{
		$which_page = $this->uri->segment(3);
		$content_render = '';
		
		switch($which_page) {
			case 'form':
				$content_render = $this->_manage_menu();// add or edit
				break;
			case 'delete':
				$this->_delete_menu();// delete
			default:
				$content_render = $this->_list_menu(); // just list user
		}
		
		if($content_render!='') return $content_render;
		else show_404();
	}
	
	private function _list_menu() {
		
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page'),
			'group_by'	=> 'isuzu_menu.id',
			'order_by'	=> 'isuzu_menu.seft_id, isuzu_menu.display_order'
		);
		
		$this->_push['menus'] =	$this->admin_model_menu->get($params);

		return $this->load->view('admin/menu/list', $this->_push);
		
	}
	
	private function _manage_menu() {
		
		$this->load->helper('isuzu_js');
		
		$this->_push['action_type'] = $this->lang->line('editing_action');
		
		$this->_push['extended_js'] = load_extended_js('menu_title'); // generate slug
		
		$this->_push['root_menu_list'] = $this->admin_model_menu->get_root_list_menu();
		
		$menu_id = uri_assoc('menu_id');

		if ($this->admin_model_menu->validate()) {

			$this->admin_model_menu->save();

			$menu_id = ($menu_id) ? $menu_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('menu_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('menu_module'), $log_action_type, $this->lang->line('menu_name').': '.$this->admin_model_menu->form_value('name').' at '.format_date(time()));
			
			redirect($this->uri->segment(1).'/menu/index');

		}

		else {

			if (!$_POST AND $menu_id) {

				$this->admin_model_menu->prep_validation($menu_id);
				
			} else {
				
				$this->_push['action_type'] = $this->lang->line('adding_action');
			}

			$this->load->helper('text');

			$menu_id = uri_assoc('menu_id');
			
			$this->_push['menuobj_en'] = $this->admin_model_menu->get_menu_lang($menu_id);
			
			return $this->load->view('admin/menu/form', $this->_push);

		}

	}

	private function _delete_menu() {

		$menu_id = uri_assoc('menu_id');

		if ($menu_id) {
			
			$this->admin_model_menu->delete($menu_id);
			
			$menu_name = $this->admin_model_menu->get_menu_name($menu_id);
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('menu_module'), 'Deleted', $this->lang->line('menu_name').': '.$menu_name.' at '.format_date(time()));
			
		}

		$this->redir->redirect($this->uri->segment(1).'/menu/index');
	}

	function _post_handler() {

		if ($this->input->post('btn_cancel')) {

			redirect($this->session->userdata('last_index'));

		}

	}
	
}

/* End of file mpage.php */
/* Location: ./application/controllers/pages.php */