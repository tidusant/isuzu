<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_log extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'isuzu_logs';

		$this->primary_key = 'isuzu_logs.Id';
		$this->order_by = 'isuzu_logs.DateUpdated DESC';
	}
	
	
	public function get($params = NULL) {

		$logs = parent::get($params);

		return $logs;

	}
	
	public function get_list_by_member($member_id) {
		$this->db->select('Id, Controller, Action, Description');
		$this->db->from($this->table_name);
		$this->db->where('User', $member_id);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		return false;
	}
}
