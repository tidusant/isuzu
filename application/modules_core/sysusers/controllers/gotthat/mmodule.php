<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mmodule extends Admin_Controller {

	private $_push;
	function __construct() {
		
		parent::__construct();
		$this->load->model('admin_model_module');
		$this->_post_handler();
		$this->load->helper('isuzu_date');
		$this->load->language('member');
		
		// menu render
		$this->_push = array(
			'menu_render' => $this->render_menu()
		);
	}
	
	function index() {
		
		$this->load->model('admin_model_membergroup');
		
        $this->redir->set_last_index();
		
        $this->_push['module_list']	 = $this->admin_model_membergroup->get_module_list();
		
        $this->load->view('admin/module/list', $this->_push);

    }

    function form() {
		
		$this->_push['action_type'] = 'Editing';
		
		$m_id = uri_assoc('m_id');
		
		if ($this->admin_model_module->validate()) {

			$this->admin_model_module->save();

			$m_id = ($m_id) ? $m_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('m_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), 'Module', $log_action_type, $this->lang->line('module_name').': '.$this->admin_model_module->form_value('module_name').' at '.format_date(time()));
			
			redirect('sysusers/gotthat/mmodule');

		}

		else {

			if (!$_POST AND $m_id) {

				$this->admin_model_module->prep_validation($m_id);
				
			} else {
				
				$this->_push['action_type'] = $this->lang->line('adding_action');
			}

			$this->load->helper('text');

			$m_id = uri_assoc('m_id');

			$page_params = array(
				'where'	=>	array(
					'isuzu_modules.module_id'	=>	$m_id
				)
			);
			
			$this->load->view('admin/module/form', $this->_push);

		}

    }

    function delete() {
		
		$m_id = uri_assoc('m_id');
		
		$this->admin_model_module->delete($m_id);
		
		$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), 'Module', 'Deleted', $this->lang->line('group_name').': '.$this->admin_model_module->get_modulename($m_id).' at '.format_date(time()));
		
        $this->redir->redirect('sysusers/gotthat/mmodule');

    }
	
    function _post_handler() {

		if ($this->input->post('btn_cancel')) {

            redirect('users/gotthat/musers/index');

        }

    }
	
}

/* End of file musers.php */
/* Location: ./application/controllers/welcome.php */