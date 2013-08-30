<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Musergroup extends Admin_Controller {

	private $_push;
	function __construct() {
		
		parent::__construct();
		$this->_post_handler();
		$this->load->helper('isuzu_date');
		$this->load->language('member');
		
		// menu render
		$this->_push = array(
			'menu_render' => $this->render_menu()
		);
	}
	
	function index() {
		
        $this->redir->set_last_index();
		
		$params = array(
			'order_by'	=>	'group_id desc'
		);
		
        $this->_push['admingroups'] = $this->admin_model_membergroup->get($params);
		
        $this->load->view('admin/group/list', $this->_push);

    }

    function form() {
		
		$this->load->model(array('admin_model_membergroup', 'admin_model_modulegroup'));
		
		$this->_push['action_type'] = 'Editing';
		
		$this->_push['module_list'] = $this->admin_model_membergroup->get_module_list();
		
		$group_id = uri_assoc('group_id');
		
		if ($this->admin_model_membergroup->validate()) {

			$this->admin_model_membergroup->save();

			$group_id = ($group_id) ? $group_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('group_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('group_module'), $log_action_type, $this->lang->line('group_name').': '.$this->admin_model_membergroup->form_value('group_name').' at '.format_date(time()));
			
			redirect('sysusers/gotthat/musergroup');

		}

		else {

			if (!$_POST AND $group_id) {

				$this->admin_model_membergroup->prep_validation($group_id);
				
			} else {
				
				$this->_push['action_type'] = $this->lang->line('adding_action');
			}

			$this->load->helper('text');

			$group_id = uri_assoc('group_id');

			$page_params = array(
				'where'	=>	array(
					'isuzu_systemusergroup.group_id'	=>	$group_id
				)
			);
			
			$this->_push['module_by_group'] = $this->admin_model_modulegroup->get_module_by_group($group_id);
			$this->load->view('admin/group/form', $this->_push);

		}

    }

    function delete() {
		
		$group_id = uri_assoc('group_id');
		
		$this->admin_model_membergroup->delete($group_id);
		
		$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('group_module'), 'Deleted', $this->lang->line('group_name').': '.$this->admin_model_membergroup->get_groupname($group_id).' at '.format_date(time()));
		
        $this->redir->redirect('sysusers/gotthat/musergroup');

    }
	
    function _post_handler() {

		if ($this->input->post('btn_cancel')) {

            redirect('sysusers/gotthat/musers/index');

        }

    }
	
}

/* End of file musers.php */
/* Location: ./application/controllers/welcome.php */