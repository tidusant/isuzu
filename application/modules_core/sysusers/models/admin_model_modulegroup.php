<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Model_ModuleGroup extends MY_Model {
	
	public $users = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'module_group';
	}
	
	public function get_module_by_group($group_id)
	{
		$this->db->select('module_id');
		$this->db->from($this->table_name);
		if($group_id !== NULL) $this->db->where('group_id', $group_id);
		
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	/* void */
	public function save($group_id, $module_id) {
		
		$db_array = array(
			'module_id'		=>	$module_id,
			'group_id'		=>	$group_id
		);
		
		$this->db->insert($this->table_name, $db_array);
		
	}
	
	/* save with post data */
	public function save_post_data($module_select_data, $group_id) {
		if($module_select_data !== NULL or $module_select_data != 0) {
			foreach($module_select_data as $item)
				$this->save($group_id, $item);
		}
	}
	
}