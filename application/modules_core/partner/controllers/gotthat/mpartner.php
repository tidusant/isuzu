<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mpartner extends Admin_Controller {
	
	private $_push;
	
	public function __construct()
	{
		parent::__construct();
		$this->_post_handler();
		$this->load->model(array('admin_model_partner', 'admin_model_location'));
		$this->load->helper(array('isuzu_image', 'isuzu_date', 'text'));
		$this->load->language('partner');
		
	}
	
	public function index()
	{
		$which_page = $this->uri->segment(3);
		$content_render = '';
		
		switch($which_page) {
			case 'location':
				switch($this->uri->segment(4)) {
					case 'form':
						$content_render = $this->_manage_location();
						break;
					case 'delete':
						$content_render = $this->_delete_location();
						break;
					default:
						$content_render = $this->_list_location(); // just list the group;
				}
				
				break;
				
			case 'form':
				$content_render = $this->_manager_partner();// add or edit
				break;
			case 'delete':
				$this->_delete_partner();// delete
			default:
				$content_render = $this->_list_partner(); // just list user
		}
		
		if($content_render!='') return $content_render;
		else show_404();
	}
	
	private function _list_partner() {
		
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);

		$this->_push['partners'] = $this->admin_model_partner->get($params);

		return $this->load->view('admin/partner/list', $this->_push);
	}
	
	private function _manager_partner() {
		
		$this->_push['action_type'] = $this->lang->line('editing_action');
		
		$this->load->helper('isuzu_js');
		
		$this->_push['location_list'] = $this->admin_model_location->get_location_list();
		
		$this->_push['tinymce_init'] = load_tinymce_plugin();
		
		$pa_id = uri_assoc('pa_id');

		if ($this->admin_model_partner->validate()) {

			$this->admin_model_partner->save();

			$pa_id = ($pa_id) ? $pa_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('pa_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('partner_module'), $log_action_type, $this->lang->line('partner_name').': '.$this->admin_model_partner->form_value('partner_name').' at '.format_date(time()));
			
			redirect($this->uri->segment(1).'/partners/index');

		}

		else {
			
			if (!$_POST AND $pa_id) $this->admin_model_partner->prep_validation($pa_id);
			else $this->_push['action_type'] = $this->lang->line('adding_action');
			
			// get lang
			$this->_push['partnerobj_en'] = $this->admin_model_partner->get_partner_lang($pa_id);
			
			return $this->load->view('admin/partner/form', $this->_push);

		}

	}
	
	private function _delete_partner() {

		$pa_id = uri_assoc('pa_id');

		if ($pa_id) {

			$this->admin_model_partner->delete($pa_id);
			
			$pa_name = $this->admin_model_partner->get_partner_name($pa_id);
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('partner_module'), 'Deleted', $this->lang->line('partner_name').': '.$pa_name.'-'.' at '.format_date(time()));
			
		}

		$this->redir->redirect($this->uri->segment(1).'/partners/index');
	}
	
	/* location */
	public function _list_location() {
		
		$this->load->helper('text');
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);

		$this->_push['location'] = $this->admin_model_location->get($params);

		return $this->load->view('admin/location/list', $this->_push);
	}
	
	public function _manage_location() {
		
		$this->load->model('admin_model_location');
		
		$this->_push['action_type'] = $this->lang->line('editing_action');
		
		$this->_push['location_list'] = $this->admin_model_location->get_location_list();
		
		$l_id = uri_assoc('l_id');

		if ($this->admin_model_location->validate()) {

			$this->admin_model_location->save();

			$l_id = ($l_id) ? $l_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('l_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('partner_module'), $log_action_type, $this->lang->line('partner_name').': '.$this->admin_model_location->form_value('partner_name').' at '.format_date(time()));
			
			redirect($this->uri->segment(1).'/partners/location');

		}

		else {
			
			if (!$_POST AND $l_id) {
				
				$this->admin_model_location->prep_validation($l_id);
				
			} else $this->_push['action_type'] = $this->lang->line('adding_action');
			
			return $this->load->view('admin/location/form', $this->_push);

		}

	}
	
	private function _delete_location() {

		$l_id = uri_assoc('l_id');

		if ($l_id) {

			$this->admin_model_location->delete($l_id);
			
			$pa_name = $this->admin_model_location->get_location_name($l_id);
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('location_module'), 'Deleted', $this->lang->line('partner_location').': '.$pa_name.'-'.' at '.format_date(time()));
			
		}

		$this->redir->redirect($this->uri->segment(1).'/partners/location');
	}
	
	function _post_handler() {

		if ($this->input->post('btn_cancel')) {

			redirect($this->session->userdata('last_index'));

		}

	}
}