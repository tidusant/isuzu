<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Model_Module extends MY_Model {
	
	public $users = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'isuzu_modules';
		$this->primary_key = 'isuzu_modules.module_id';
		$this->order_by = 'isuzu_modules.module_name ASC';
	}
	
	public function validate() {
		
		$this->form_validation->set_rules('module_name', $this->lang->line('module_name'), 'required|trim|xss_clean|callback_modulename_check');
		$this->form_validation->set_rules('display_order', $this->lang->line('member_priority'));
		$this->form_validation->set_rules('active', $this->lang->line('member_active'));
		
		return parent::validate($this);

	}

	public function modulename_check($modulename) {

		$this->db->where('module_name', $modulename);

		if (uri_assoc('m_id')) {

			$this->db->where('module_id <>', uri_assoc('m_id'));

		}

		$query = $this->db->get($this->table_name);

		if ($query->num_rows()) {

			$this->form_validation->set_message('modulename_check', $this->lang->line('modulename_already_exist'));

			return FALSE;

		}

		return TRUE;

	}

	public function save($db_array = NULL) {
		
		if (!$db_array) $db_array = parent::db_array();
		
		if (!$this->input->post('active') and !isset($db_array['active'])) {
			$db_array['active'] = 0;
		}

		parent::save($db_array, uri_assoc('m_id'));

	}
	
	public function get_modulename($m_id) {

		$this->db->select('module_name');

		$this->db->where('module_id', $m_id);
		
		$query = $this->db->get($this->table_name)->row();
		
		if(count($query) > 0) return $query->module_name;
		else return 'None';

	}

	public function delete($m_id) {

		parent::delete(array('module_id'=>$m_id));

	}
	
}