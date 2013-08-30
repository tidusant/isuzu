<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_part extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'parts';
		$this->primary_key = 'parts.part_id';
		$this->order_by = 'parts.updated_on desc';
		
		$this->select_fields = "
		SQL_CALC_FOUND_ROWS
		parts.*, product_cate.pc_name AS category_name";
		
		$this->joins = array(
			'product_cate'	=>	array(
				'product_cate.pc_id = parts.product_cate_pc_id',
				'left'
			)
		);
		
	}
	
	public function get_part_list()
	{
		$this->db->select('part_id, part_name');
		$this->db->where('active', '1');
		
		$query = $this->db->get($this->table_name);
		
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function get_list_part_by_cate($cate_id)
	{
		$this->db->select('part_id, part_name');
		
		$this->db->where(array('active'=>'1', 'product_cate_pc_id'=>$cate_id));
		
		$query = $this->db->get($this->table_name);
		
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function get_part_name($pa_id) {

		$this->db->select('part_name');
		$this->db->where('part_id', $pa_id);

		return $this->db->get($this->table_name)->row()->part_name;

	}
	
	public function total_part_count()
	{
		$this->db->where('active', '1');
		return $this->db->count_all_results($this->table_name);
	}
	
	// return number
	public function get_part_count_by_cate($cate_id)
	{
		
		// count all available chapter
		if($cate_id!='') $this->db->where('product_cate_pc_id', $cate_id);
		
		$this->db->where('active', '1');
		
		return $this->db->count_all_results('parts');
		
	}
	
	// add - edit action
	public function validate() {
		$this->form_validation->set_rules('product_cate_pc_id', $this->lang->line('product_category'), 'trim|required');
		$this->form_validation->set_rules('part_name', $this->lang->line('part_name'), 'trim|required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('part_link_image', 'Image', 'trim|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('part_price', 'Price', 'trim|numeric|xss_clean|htmlspecialchars');
		//$this->form_validation->set_rules('part_intro', $this->lang->line('part_intro'), 'xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('part_desc', $this->lang->line('part_description'), 'xss_clean');
		$this->form_validation->set_rules('display_order', $this->lang->line('part_priority'), 'trim|numeric');
		$this->form_validation->set_rules('active', $this->lang->line('part_active'));
		
		return parent::validate($this);
	}

	public function delete($pa_id) {

		/* Delete the client record */
		parent::delete(array('part_id'=>$pa_id));
	}

	public function save($db_array = NULL) {
		
		if (!$db_array) {

			$db_array = parent::db_array();

		}
		
		// date create - update
		$db_array['created_on'] = time();
		$db_array['updated_on'] = time();
		
		if (!$this->input->post('active') and !isset($db_array['active'])) {

			$db_array['active'] = 0;

		}
		
		$part_id = 0;
		$part_id = parent::save_return_id($db_array, uri_assoc('pa_id'));
		
		// save language
		unset($db_array);
		$db_array = array('part_id'=>$part_id,
						'lang'=>'ENG',
						'part_name'=>trim(htmlspecialchars($this->input->post('part_name_en'))),
						'part_desc'=>trim($this->input->post('part_desc_en', TRUE))
						);
		
		$this->_set_part_lang($db_array);
		
	}
	
	/*#################### language processing ###########################*/
	private function _set_part_lang($db_array) {
		if($this->check_lang_exist('parts','part_id',uri_assoc('pa_id'))) {
			$this->db->set('part_name', $db_array['part_name']);
			$this->db->set('part_desc', $db_array['part_desc']);
			$this->db->where(array('part_id'=>$db_array['part_id'], 'lang'=>$db_array['lang']));
			$this->db->update('parts_lang');
		}
		else {
			$this->db->set('part_id', $db_array['part_id']);
			$this->db->set('lang', $db_array['lang']);
			$this->db->set('part_name', $db_array['part_name']);
			$this->db->set('part_desc', $db_array['part_desc']);
			$this->db->insert('parts_lang');
		}
	}
	
	public function get_part_lang($part_id)
	{
		$this->db->select('part_name, part_desc');
		$this->db->from('parts_lang');
		$this->db->where(array('lang'=>'ENG','part_id'=>$part_id));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
}