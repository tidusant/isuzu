<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_category extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'product_cate';

		$this->primary_key = 'product_cate.pc_id';
		$this->order_by = 'product_cate.pc_name asc';
	}
	
	
	public function get_list_categories()
	{
		$this->db->select('pc_id, pc_name');
		$this->db->from($this->table_name);
		$this->db->where('active', '1');
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		return false;
	}
	
	public function get_category_name($cate_id) {

		$this->db->select('pc_name');
		$this->db->where('pc_id', $cate_id);

		return $this->db->get($this->table_name)->row()->pc_name;

	}
	
	// add - edit action
	public function validate() {
		$this->form_validation->set_rules('pc_name', $this->lang->line('category_name'), 'required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('pc_slug', $this->lang->line('product_slug'), 'required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('pc_desc', $this->lang->line('product_description'), 'xss_clean');
		$this->form_validation->set_rules('pc_source_doc', 'Catalogue Link', 'trim|htmlspecialchars|xss_clean');
		$this->form_validation->set_rules('pc_image_link_sub', 'Submenu Image', 'trim|htmlspecialchars|xss_clean');
		$this->form_validation->set_rules('pc_image_link', 'Logo Image', 'trim|htmlspecialchars|xss_clean');
		$this->form_validation->set_rules('pc_image_link_extra', 'Avatar Image', 'trim|htmlspecialchars|xss_clean');
		$this->form_validation->set_rules('pc_gallery_id', 'Catalog Gallery', 'trim|htmlspecialchars|xss_clean');
		$this->form_validation->set_rules('pc_slide_id', 'Catalog Slide', 'trim|htmlspecialchars|xss_clean');
		$this->form_validation->set_rules('display_order', $this->lang->line('product_priority'));
		$this->form_validation->set_rules('active', $this->lang->line('product_active'));
		
		return parent::validate($this);

	}

	public function delete($cate_id) {
		parent::delete(array('pc_id'=>$cate_id));
	}

	public function save($db_array = NULL) {

		if (!$db_array) {

			$db_array = parent::db_array();

		}
		
		// date
		$db_array['created_on'] = time();
		$db_array['updated_on'] = time();
		
		
		if (!$this->input->post('active') and !isset($db_array['active'])) {

			$db_array['active'] = 0;

		}
		
		$cate_id = 0;
		$cate_id = parent::save_return_id($db_array, uri_assoc('cate_id'));
		
		// tech information add
		/*if($cate_id <> 0) {
			
			$pattern_group_id = intval($this->input->post('pattern_group'));
			$product_cate_pc_id = intval($cate_id);
			$pattern_name = trim(htmlspecialchars($this->input->post('pattern_name')));
			$pattern_unit = trim(htmlspecialchars($this->input->post('pattern_unit')));
			$display_order = intval(trim($this->input->post('position_ordering')));
			
			$this->save_pattern_tech($pattern_group_id, $product_cate_pc_id, $pattern_name, $pattern_unit, $display_order);
		} */
		
		// save language
		unset($db_array);
		$db_array = array('pc_id'=>$cate_id,
						'lang'=>'ENG',
						'pc_name'=>trim(htmlspecialchars($this->input->post('pc_name_en'))),
						'pc_desc'=>trim($this->input->post('pc_desc_en', TRUE))
						);
		
		$this->_set_cate_lang($db_array);
	}
	
	/* #############################thong so ky thuat model processing##################### */
	public function get_pattern_group()
	{
		$query = $this->db->get('pattern_group');
		if($query->num_rows() > 0) return $query;
		return false;
	}
	
	public function get_pattern_tech_by_cate($pc_cate_id)
	{
		$this->db->from('pattern_tech');
		$this->db->where('product_cate_pc_id', $pc_cate_id);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		return false;
	}
	
	/// get tech value
	public function get_pattern_tech_value($product_id)
	{
		$this->db->where('product_id', $product_id);
		$query = $this->db->get('pattern_tech_value');
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	/// save tech value
	public function save_pattern_tech_value($pattern_tech_id, $product_id, $tech_value)
	{
		$this->db->set('pattern_tech_id', $pattern_tech_id);
		$this->db->set('product_id', $product_id);
		$this->db->set('tech_value', $tech_value);
				
		$this->db->insert('pattern_tech_value');
		return $this->db->insert_id();
	}
	
	/*#################### language processing ###########################*/
	private function _set_cate_lang($db_array) {
		if($this->check_lang_exist('product_cate', 'pc_id',uri_assoc('cate_id'))) {
			$this->db->set('pc_name', $db_array['pc_name']);
			$this->db->set('pc_desc', $db_array['pc_desc']);
			$this->db->where(array('pc_id'=>$db_array['pc_id'], 'lang'=>$db_array['lang']));
			$this->db->update('product_cate_lang');
		}
		else {
			$this->db->set('pc_id', $db_array['pc_id']);
			$this->db->set('lang', $db_array['lang']);
			$this->db->set('pc_name', $db_array['pc_name']);
			$this->db->set('pc_desc', $db_array['pc_desc']);
			$this->db->insert('product_cate_lang');
		}
	}
	
	public function get_cate_lang($cate_id)
	{
		$this->db->select('pc_name, pc_desc');
		$this->db->from('product_cate_lang');
		$this->db->where(array('lang'=>'ENG','pc_id'=>$cate_id));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
}