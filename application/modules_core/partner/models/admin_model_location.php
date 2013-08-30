<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_location extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'location_list';
		$this->primary_key = 'location_list.ll_id';
	}
	
	/* admin */
	
	public function get_location_list()
	{
		$this->db->select('ll_id, location');
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function get_location_name($l_id) {

		$this->db->select('location');
		$this->db->where('ll_id', $l_id);

		return $this->db->get($this->table_name)->row()->location;

	}
	
	public function validate() {
		
		$this->form_validation->set_rules('location', $this->lang->line('partner_location'), 'trim|required|xss_clean|htmlspecialchars');
		
		$this->form_validation->set_rules('location_en', $this->lang->line('partner_location'), 'trim|xss_clean|htmlspecialchars');
		
		return parent::validate($this);

	}

	public function delete($l_id) {
		
		parent::delete(array('ll_id'=>$l_id));
	}

	public function save($db_array = NULL) {

		if (!$db_array) {

			$db_array = parent::db_array();

		}
		
		parent::save($db_array, uri_assoc('l_id'));
		
	}
}