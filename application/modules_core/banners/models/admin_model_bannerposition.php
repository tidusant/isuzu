<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_bannerposition extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'banner_position';

		$this->primary_key = 'banner_position.position_id';
	}
	
	public function get($params = NULL) {

		$bp = parent::get($params);

		return $bp;

	}
	
	public function get_position($bp_id)
	{
		$this->db->select('pos_name');
		if($bp_id !== NULL) $this->db->where('position_id', $bp_id);
		
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0) return $query->row()->pos_name;
		else return false;
	}
	
	public function get_list()
	{
		$this->db->select('position_id, pos_name');
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function validate() {
		$this->form_validation->set_rules('pos_name', 'Position', 'required|xss_clean|htmlspecialchars');
		return parent::validate($this);

	}

	public function delete($bp_id) {

		/* Delete the client record */
		parent::delete(array('position_id'=>$bp_id));
	}

	public function save($db_array = NULL) {

		if (!$db_array) {

			$db_array = parent::db_array();

		}
		
		if ($this->input->post('pos_name') and isset($db_array['pos_name'])) {

			$db_array['pos_name'] = $this->input->post('pos_name', TRUE);

		}
		
		parent::save($db_array, uri_assoc('bp_id'));

	}
	
}
