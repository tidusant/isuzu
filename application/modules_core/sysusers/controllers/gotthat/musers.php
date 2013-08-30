<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Musers extends Admin_Controller {

	private $_push;
	function __construct() {
		
		parent::__construct();
		$this->_post_handler();
		$this->load->helper('isuzu_date');
		$this->load->language('member');
		
	//	$this->admin_model_member->restrict('');
	}
	
	public function index()
	{
		$which_page = $this->uri->segment(3);
		$content_render = '';
		
		switch($which_page) {
			case 'groups':
				switch($this->uri->segment(4)) {
					case 'form':
						$content_render = $this->_manage_group();
						break;
					case 'delete':
						$content_render = $this->_delete_group();
						break;
					default:
						$content_render = $this->_list_usergroup(); // just list the group;
				}
				
				break;
			case 'form':
				$content_render = $this->_manage_users();// add or edit
				break;
			case 'delete':
				$this->_delete_user();// delete
			default:
				$content_render = $this->_list_user(); // just list user
		}
		
		if($content_render!='') return $content_render;
		else show_404();
	}
	
	private function _list_user() {

        $this->redir->set_last_index();

        $params = array(
            'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
            'paginate'	=>	TRUE,
            'page'		=>	uri_assoc('page'),
            'order_by'	=>	'su_email',
            'where'     =>  array(
                'isuzu_systemusers.active'   =>  '1'
            )
        );
		
		$show = uri_assoc('show');
		
		if ($show == 'active') {
			
			$params['where']['isuzu_systemusers.active'] = 1;
			
		}
		
		elseif ($show == 'inactive') {
			
			$params['where']['isuzu_systemusers.active'] = 0;
			
		}
		
        $this->_push['members'] = $this->admin_model_member->get($params);
		
        return $this->load->view('admin/user/list', $this->_push);

    }

    private function _manage_users() {
		
		$this->_push['action_type'] = 'Edit';
		
		$member_id = uri_assoc('member_id');
		
		$this->_push['members_level'] = $this->admin_model_member->get_group_list();
		
		$this->_push['extended_js'] = $this->_load_js(); // password checking strength js plugin
		
        if (!$this->admin_model_member->validate()) {
			
            if (!$_POST AND $member_id) {
                $this->admin_model_member->prep_validation($member_id);
            } else {
				$this->_push['action_type'] = 'Add';
			}
			
            return $this->load->view('admin/user/form', $this->_push);
        }

        else {
			
            $member_id = $this->admin_model_member->save($this->admin_model_member->db_array(), $member_id);
			
			$log_action_type = (!uri_assoc('member_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('member_module'), $log_action_type, $this->lang->line('member_name').': '.$this->admin_model_member->form_value('su_fullname').' at '.format_date(time()));
			
            $this->redir->redirect($this->uri->segment(1).'/system_users/index'); // back to list

        }

    }

    private function _delete_user() {
		
		$member_id = uri_assoc('member_id');
		
		$this->admin_model_member->delete($member_id);
		
		$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('member_module'), 'Deleted', $this->lang->line('member_name').': '.$this->admin_model_member->get_username($member_id).' at '.format_date(time()));
		
        $this->redir->redirect($this->uri->segment(1).'/system_users/index');

    }
	
    private function _user_change_password() {

		$member_id = uri_assoc('member_id');

        if (!$this->admin_model_member->validate_change_password() and $member_id) {

            return $this->load->view('sysusers/change_password');

        }

        else {

            $this->admin_model_member->save_change_password($member_id);

            $this->redir->redirect($this->uri->segment(1).'/system_users/index');

        }

    }

    function _post_handler() {

       if ($this->input->post('btn_cancel')) {

            redirect($this->uri->segment(1).'/system_users/index');

        }

    }
	
	/* user group */
	private function _list_usergroup()
	{
		$this->redir->set_last_index();
		
		$params = array(
			'order_by'	=>	'group_id desc'
		);
		
        $this->_push['admingroups'] = $this->admin_model_membergroup->get($params);
		
        return $this->load->view('admin/group/list', $this->_push);
	}
	
	private function _manage_group() {
		
		$this->load->model(array('admin_model_membergroup', 'admin_model_modulegroup'));
		
		$this->_push['action_type'] = 'Editing';
		
		$this->_push['module_list'] = $this->admin_model_membergroup->get_module_list();
		
		$group_id = uri_assoc('group_id');
		
		if ($this->admin_model_membergroup->validate()) {

			$this->admin_model_membergroup->save();

			$group_id = ($group_id) ? $group_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('group_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('group_module'), $log_action_type, $this->lang->line('group_name').': '.$this->admin_model_membergroup->form_value('group_name').' at '.format_date(time()));
			
			redirect($this->uri->segment(1).'/system_users/groups');
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
			
			return $this->load->view('admin/group/form', $this->_push);

		}

    }

    private function _delete_group() {
		
		$group_id = uri_assoc('group_id');
		
		$this->admin_model_membergroup->delete($group_id);
		
		$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('group_module'), 'Deleted', $this->lang->line('group_name').': '.$this->admin_model_membergroup->get_groupname($group_id).' at '.format_date(time()));
		
        $this->redir->redirect($this->uri->segment(1).'/system_users/groups');

    }
	
	private function _load_js()
	{
		$js_addon = '<script type="text/javascript" src="'.base_url().'assets/admin/js/jquery.pwstrength.min.js"></script>';
		
		$js_addon .= '<script type="text/javascript">
			jQuery(function($) { 
				$(\'#password_field\').pwstrength(); 
			});
		</script>';
		
		return $js_addon;
	}
	
}

/* End of file musers.php */
/* Location: ./application/controllers/welcome.php */