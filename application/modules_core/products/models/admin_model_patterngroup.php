<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_patterngroup extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'pattern_group';
		$this->primary_key = 'pattern_group.id';
		
	}
	
	public function validate() {
		$this->form_validation->set_rules('group_name', 'Group Name', 'trim|required|htmlspecialchars|xss_clean');
		return parent::validate($this);

	}
	
	public function delete($pt_id) {
		parent::delete(array('id'=>$pt_id));
	}

	public function save($db_array = NULL) {
		
		if (!$db_array) {

			$db_array = parent::db_array();

		}
		
		
		$group_id = 0;
		$group_id = parent::save_return_id($db_array, uri_assoc('group_id'));
		
		// save language
		unset($db_array);
		$db_array = array('group_id'=>$group_id,
						'lang'=>'ENG',
						'group_name'=>trim(htmlspecialchars($this->input->post('group_name_en')))
						);
		
		$this->_set_group_lang($db_array);
		
	}
	
	private function _set_group_lang($db_array) {
		if($this->check_lang_exist('pattern_group','group_id',uri_assoc('group_id'))) {
			$this->db->set('group_name',$db_array['group_name']);
			$this->db->where(array('group_id'=>$db_array['group_id'], 'lang'=>'ENG'));
			$this->db->update('pattern_group_lang');
		}
		else {
			$this->db->set('group_id',$db_array['group_id']);
			$this->db->set('lang',$db_array['lang']);
			$this->db->set('group_name',$db_array['group_name']);
			$this->db->insert('pattern_group_lang');
		}
	}
	
	public function get_group_lang($group_id) {
		$this->db->select('group_name');
		$this->db->from('pattern_group_lang');
		$this->db->where(array('lang'=>'ENG','group_id'=>$group_id));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row()->group_name;
		else return false;
	}
	
}
