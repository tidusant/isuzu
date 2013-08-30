<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Model_Membergroup extends MY_Model {
	
	public $users = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'isuzu_systemusergroup';
		$this->primary_key = 'isuzu_systemusergroup.group_id';
		$this->order_by = 'isuzu_systemusergroup.group_id DESC';
	}
	
	public function check_module_user_permision($group_id)
	{	
		$this->db->select('module_id');
		$this->db->from('module_group');
		$this->db->where('group_id', $group_id);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$module_per = array();
			foreach($query->result() as $mp) {
				$module_per[$mp->module_id] = $mp->module_id;
			}
			return $module_per;
		} else return false;
	}
	
	public function get_groupid_by_slug($slug)
	{
		$this->db->select('group_id');
		$this->db->from('isuzu_systemusergroup');
		$this->db->where('group_slug', $slug);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row()->group_id;
		return false;
	}
	
	public function get_module_list()
	{
		$this->db->select('module_id, module_name, active');
		$this->db->from('isuzu_modules');
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query; 
		else return false;
	}
	
	public function validate() {
		
		$this->form_validation->set_rules('group_name', $this->lang->line('group_name'), 'required|trim|xss_clean|callback_groupname_check');
		$this->form_validation->set_rules('description', $this->lang->line('group_description'), 'trim|xss_clean');
		$this->form_validation->set_rules('active', $this->lang->line('member_active'));
		
		return parent::validate($this);

	}

	public function groupname_check($groupname) {

		$this->db->where('group_name', $groupname);

		if (uri_assoc('group_id')) {

			$this->db->where('group_id <>', uri_assoc('group_id'));

		}

		$query = $this->db->get($this->table_name);

		if ($query->num_rows()) {

			$this->form_validation->set_message('groupname_check', $this->lang->line('groupname_already_exist'));

			return FALSE;

		}

		return TRUE;

	}

	public function save($db_array = NULL) {
		
		if (!$db_array) $db_array = parent::db_array();
		
		if (!$this->input->post('active') and !isset($db_array['active'])) {
			$db_array['active'] = 0;
		}
		
		if(!uri_assoc('group_id')) { // add action
			$group_id = parent::save_return_id($db_array, uri_assoc('group_id'));
			$this->load->model('admin_model_modulegroup');
			// module
			$module_select = $this->input->post('module_col', TRUE);
			if($module_select !== NULL or $module_select != 0) {
				foreach($module_select as $item) {
					$this->admin_model_modulegroup->save($group_id, $item);
				}
			}
		} elseif(uri_assoc('group_id')) { // edit action
			$group_id =uri_assoc('group_id');
			$this->load->model('admin_model_modulegroup');
			// module
			$module_select = $this->input->post('module_col', TRUE);
			$delete_params = array('group_id' => $group_id);
			$this->admin_model_modulegroup->delete($delete_params, false); // turn off message
			// and save new values
			$this->admin_model_modulegroup->save_post_data($module_select, $group_id);
			parent::save($db_array, uri_assoc('group_id'));
		}
		

	}
	
	
	public function get_groupname($group_id) {

		$this->db->select('group_name');

		$this->db->where('group_id', $group_id);
		
		$query = $this->db->get($this->table_name)->row();
		
		if(count($query) > 0) return $query->group_name;
		else return 'None';

	}

	public function delete($group_id) {

		parent::delete(array('group_id'=>$group_id));

	}
	
}