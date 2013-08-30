<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_pattern extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'pattern_tech';
		$this->primary_key = 'pattern_tech.id';
		$this->order_by = 'pattern_tech.display_order asc';
		
	}
	
	public function validate() {
		$this->form_validation->set_rules('product_cate_pc_id', 'Catalog', 'trim');
		$this->form_validation->set_rules('pattern_group_id', 'Pattern Group', 'required');
		$this->form_validation->set_rules('pattern_name', 'Pattern Name', 'trim|required|htmlspecialchars|xss_clean');
		$this->form_validation->set_rules('pattern_unit', 'Pattern Unit', 'trim|htmlspecialchars|xss_clean');
		$this->form_validation->set_rules('display_order', 'Ordering', 'trim|htmlspecialchars|xss_clean');
		
		return parent::validate($this);

	}
	
	public function delete($pt_id) {
		parent::delete(array('id'=>$pt_id));
	}

	public function save($db_array = NULL) {
		
		if (!$db_array) {

			$db_array = parent::db_array();

		}
		
		$pat_id = 0;
		$pat_id = parent::save_return_id($db_array, uri_assoc('pat_id'));
		
		// save language
		unset($db_array);
		$db_array = array('pattern_tech_id'=>$pat_id,
						'lang'=>'ENG',
						'pattern_name'=>trim(htmlspecialchars($this->input->post('pattern_name_en'))),
						'pattern_unit' => trim(htmlspecialchars($this->input->post('pattern_unit_en')))
						);
		
		$this->_set_pattern_lang($db_array);
		
	}
	
	public function get_category_name($cate_id)
	{
		$this->db->select('pc_name');
		$this->db->where('pc_id', $cate_id);
		$query = $this->db->get('product_cate');
		if($query->num_rows() > 0) return $query->row()->pc_name;
		else return false;
	}
	
	public function get_group_name($group_id)
	{
		$this->db->select('group_name');
		$this->db->where('id', $group_id);
		$query = $this->db->get('pattern_group');
		if($query->num_rows() > 0) return $query->row()->group_name;
		else return false;
	}
	
	//#################### language
	
	private function _set_pattern_lang($db_array) {
		if($this->check_lang_exist('pattern_tech','pattern_tech_id',uri_assoc('pat_id'))) {
			$this->db->set('pattern_name',$db_array['pattern_name']);
			$this->db->where(array('pattern_tech_id'=>$db_array['pattern_tech_id'], 'lang'=>'ENG'));
			$this->db->update('pattern_tech_lang');
		}
		else {
			$this->db->set('pattern_tech_id',$db_array['pattern_tech_id']);
			$this->db->set('lang',$db_array['lang']);
			$this->db->set('pattern_name',$db_array['pattern_name']);
			$this->db->insert('pattern_tech_lang');
		}
	}
	
	public function get_pattern_lang($pattern_tech_id) {
		$this->db->select('pattern_name, pattern_unit');
		$this->db->from('pattern_tech_lang');
		$this->db->where(array('lang'=>'ENG','pattern_tech_id'=>$pattern_tech_id));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
}