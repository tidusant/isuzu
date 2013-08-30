<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mbanners extends Admin_Controller {

	private $_push;
	function __construct() {

		parent::__construct();
		$this->_post_handler();
		$this->load->model(array('admin_model_banner', 'admin_model_bannerposition'));
		$this->load->helper(array('isuzu_image', 'isuzu_date', 'text'));
		$this->load->language('banner');
		
	}
	
	public function index() { // list
		
		$which_page = $this->uri->segment(3);
		$content_render = '';
		
		switch($which_page) {
			case 'position':
				switch($this->uri->segment(4)) {
					case 'delete':
						$content_render = $this->_delete_position();
						break;
					case 'form';
						$content_render = $this->_manage_position();
						break;
					default:
						$content_render = $this->_list_position();
				}
				break;
			case 'form':
				$content_render = $this->_manage_banner();// add or edit
				break;
			case 'delete':
				$this->_delete_banner();// delete
			default:
				$content_render = $this->_list_banner(); // just list user
		}
		
		if($content_render!='') return $content_render;
		else show_404();
		
	}
	
	private function _list_banner()
	{
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);

		$this->_push['banners']	= $this->admin_model_banner->get($params);

		return $this->load->view('admin/list', $this->_push);
	}
	
	private function _manage_banner() {
		
		$this->load->helper('isuzu_js');
		
		$this->_push['action_type'] = $this->lang->line('editing_action');
		
		$this->_push['extended_js'] = load_tinymce_plugin();
		
		$this->_push['bannerposition_list'] = $this->admin_model_bannerposition->get_list();
		
		$banner_id = uri_assoc('banner_id');

		if ($this->admin_model_banner->validate()) {

			$this->admin_model_banner->save();

			$banner_id = ($banner_id) ? $banner_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('banner_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('banner_module'), $log_action_type, $this->lang->line('banner_title').': '.$this->admin_model_banner->form_value('Title').' at '.format_date(time()));
			
			redirect($this->uri->segment(1).'/banners/index');
			
		}

		else {

			if (!$_POST AND $banner_id) {

				$this->admin_model_banner->prep_validation($banner_id);
				
			} else {
				
				$this->_push['action_type'] = $this->lang->line('adding_action');
				
			}
			
			return $this->load->view('admin/form', $this->_push);

		}

	}

	private function _delete_banner() {

		$banner_id = uri_assoc('banner_id');

		if ($banner_id) {

			$this->admin_model_banner->delete($banner_id);
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('banner_module'), 'Deleted', $this->lang->line('banner_title').': '.$banner_id.' at '.format_date(time()));
			
		}

		$this->redir->redirect($this->uri->segment(1).'/banners/index');
	}
	
	
	/* position */
	private function _list_position()
	{
		$this->redir->set_last_index();
		
		$this->_push['bannerposition'] = $this->admin_model_bannerposition->get();

		return $this->load->view('admin/bp/list', $this->_push);
	}
	
	private function _manage_position() {
		
		$this->_push['action_type'] = 'Edit';
		
		$bp_id = uri_assoc('bp_id');

		if ($this->admin_model_bannerposition->validate()) {

			$this->admin_model_bannerposition->save();

			$bp_id = ($bp_id) ? $bp_id : $this->db->insert_id();

			redirect($this->uri->segment(1).'/banners/position');

		}

		else {

			if (!$_POST AND $bp_id) {

				$this->admin_model_bannerposition->prep_validation($bp_id);
				
			} else {
				
				$this->_push['action_type'] = 'Add';
				
			}

			$this->load->helper('text');
			
			return $this->load->view('admin/bp/form', $this->_push);

		}

	}

	private function _delete_position() {

		$bp_id = uri_assoc('bp_id');

		if ($bp_id) {

			$this->admin_model_bannerposition->delete($bp_id);

		}

		$this->redir->redirect($this->uri->segment(1).'/banners/position');
	}
	
	function _post_handler() {

		if ($this->input->post('btn_cancel')) {

				redirect($this->session->userdata('last_index'));

		}

	}
}

/* End of file Mbanners.php */
/* Location: ./application/controllers/Mbanners.php */