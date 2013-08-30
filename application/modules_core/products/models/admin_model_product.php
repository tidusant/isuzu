<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_product extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'products';
		$this->primary_key = 'products.product_id';
		$this->order_by = 'products.updated_on desc';
		
		$this->select_fields = "
		SQL_CALC_FOUND_ROWS
		products.*, product_cate.pc_name AS category_name";
		
		$this->joins = array(
			'product_cate'	=>	array(
				'product_cate.pc_id = products.product_cate_pc_id',
				'left'
			)
		);
		
	}
	
	public function get_total_product()
	{
		return $this->db->count_all_results($this->table_name);
	}
	
	public function get_product_list()
	{
		$this->db->select('product_id, product_name');
		$this->db->where('active', '1');
		
		$query = $this->db->get($this->table_name);
		
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function get_list_product_by_cate($cate_id)
	{
		$this->db->select('product_id, product_name');
		
		$this->db->where(array('active'=>'1', 'product_cate_pc_id'=>$cate_id));
		
		$query = $this->db->get($this->table_name);
		
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function get_product_name($p_id) {

		$this->db->select('product_name');
		$this->db->where('product_id', $p_id);

		return $this->db->get($this->table_name)->row()->product_name;

	}
	
	// get product gallery type
	public function get_product_gallery_type($p_id)
	{
		$this->db->select('product_gallery_type');
		$this->db->where('product_id', $p_id);

		return $this->db->get($this->table_name)->row()->product_gallery_type;
	}
	
	public function total_product_count()
	{
		$this->db->where('active', '1');
		return $this->db->count_all_results($this->table_name);
	}
	
	// return number
	public function get_product_count_by_cate($cate_id)
	{
		
		// count all available chapter
		if($cate_id!='') $this->db->where('product_cate_pc_id', $cate_id);
		
		$this->db->where('active', '1');
		
		return $this->db->count_all_results('products');
		
	}
	
	// add - edit action
	public function validate() {
		$this->form_validation->set_rules('product_cate_pc_id', $this->lang->line('product_category'), 'trim|required');
		$this->form_validation->set_rules('product_name', $this->lang->line('product_name'), 'trim|required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('product_slug', $this->lang->line('product_slug'), 'trim|required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('product_intro', $this->lang->line('product_intro'), 'trim|xss_clean');
		$this->form_validation->set_rules('product_description', $this->lang->line('product_description'), 'trim');
		$this->form_validation->set_rules('product_image_link', 'Avatar Image', 'trim|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('product_source_doc', 'Product Catalogue', 'trim|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('ishot', $this->lang->line('product_ishot'));
		$this->form_validation->set_rules('display_order', $this->lang->line('product_priority'), 'trim|numeric');
		$this->form_validation->set_rules('active', $this->lang->line('product_active'));
		
		return parent::validate($this);

	}

	public function delete($p_id) {

		/* Delete the client record */
		parent::delete(array('product_id'=>$p_id));
	}

	public function save($db_array = NULL) {
		
		if (!$db_array) {

			$db_array = parent::db_array();

		}
		
		// date create - update
		$db_array['created_on'] = time();
		$db_array['updated_on'] = time();
		
		/// get product gallery
		$product_gallery_type = ''; // save to database
		/*########### 1: slide, 2: noithat, 3: ngoaithat, 4: an toan, 5: bang mau ###########*/
		$product_gallery_type = ($this->input->post('product_slide_id')!='0')? '1:'.trim(htmlspecialchars($this->input->post('product_slide_id'))).'|' : ''; // slide type
		$product_gallery_type .= ($this->input->post('product_interior_id')!='0')? '2:'.trim(htmlspecialchars($this->input->post('product_interior_id'))).'|' : ''; // interior type
		$product_gallery_type .= ($this->input->post('product_exterior_id')!='0')? '3:'.trim(htmlspecialchars($this->input->post('product_exterior_id'))).'|' : ''; // exterior type
		$product_gallery_type .= ($this->input->post('product_safety_id')!='0')? '4:'.trim(htmlspecialchars($this->input->post('product_safety_id'))).'|' : ''; // safety type
		$product_gallery_type .= ($this->input->post('product_pallete_id')!='0')? '5:'.trim(htmlspecialchars($this->input->post('product_pallete_id'))).'|' : ''; // pallete type
		
		// save gallery type & gallery id
		if($product_gallery_type!='') 
			$product_gallery_type = substr($product_gallery_type, 0,-1);// remove last comma
		
		$db_array['product_gallery_type'] = $product_gallery_type;
		
		if (!$this->input->post('active') and !isset($db_array['active'])) $db_array['active'] = 0;
		
		// insert - update media
		if(!uri_assoc('p_id')) { // add action
			$product_id = parent::save_return_id($db_array);
			// save new product tech value
			/// get pattern tech id & value
			$this->_save_product_tech_value($product_id);
		} else { // update action
			$product_id = uri_assoc('p_id');
			parent::save($db_array, $product_id);
			/*########### tech info ############*/
			// remove old stuffs
			$this->db->delete('pattern_tech_value', array('product_id' => $product_id));
			/// and save the new
			$this->_save_product_tech_value($product_id);
		}
		
		// save language
		unset($db_array);
		$db_array = array('product_id'=>$product_id,
						'lang'=>'ENG',
						'product_name'=>trim(htmlspecialchars($this->input->post('product_name_en'))),
						'product_intro'=>trim($this->input->post('product_intro_en')),
						'product_description'=>trim($this->input->post('product_description_en'))
						);
		
		$this->_set_product_lang($db_array);
		
	}
	
	
	// product tech value processing
	private function _save_product_tech_value($product_id)
	{
		// save new product tech value
		/// get pattern tech id & value
		$pattern_ids = $this->input->post('pattern_tech_id', true);
		if($pattern_ids!==NULL) {
			foreach($pattern_ids as $pattern_id) {
				// get value
				$tech_value = trim(htmlspecialchars($this->input->post('pattern_tech_value_'.$pattern_id)));
				$pattern_tech_value_id = $this->admin_model_category->save_pattern_tech_value($pattern_id, $product_id, $tech_value);
				
				$db_array = array('pattern_tech_value_id'=>$pattern_tech_value_id,
						'lang'=>'ENG',
						'pattern_tech_value'=>trim(htmlspecialchars($this->input->post('pattern_tech_value_en_'.$pattern_id)))
						);
		
				$this->_set_pattern_tech_value_lang($db_array);
				unset($db_array);
			}
		}
	}
	
	public function return_catalog_id($product_id)
	{
		$this->db->select('product_cate_pc_id');
		$this->db->from($this->table_name);
		$this->db->where(array('active'=>'1', 'product_id'=>$product_id));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row()->product_cate_pc_id;
		return false;
	}
	
	/*#################### language processing ###########################*/
	private function _set_product_lang($db_array) {
		if($this->check_lang_exist('products','product_id',uri_assoc('p_id'))) {
			$this->db->set('product_name', $db_array['product_name']);
			$this->db->set('product_intro', $db_array['product_intro']);
			$this->db->set('product_description', $db_array['product_description']);
			$this->db->where(array('product_id'=>$db_array['product_id'], 'lang'=>$db_array['lang']));
			$this->db->update('products_lang');
		}
		else {
			$this->db->set('product_id', $db_array['product_id']);
			$this->db->set('lang', $db_array['lang']);
			$this->db->set('product_name', $db_array['product_name']);
			$this->db->set('product_intro', $db_array['product_intro']);
			$this->db->set('product_description', $db_array['product_description']);
			$this->db->insert('products_lang');
		}
	}
	
	public function get_product_lang($product_id)
	{
		$this->db->select('product_name, product_intro, product_description');
		$this->db->from('products_lang');
		$this->db->where(array('lang'=>'ENG','product_id'=>$product_id));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
	// tech value
	private function _set_pattern_tech_value_lang($db_array) {
		if($this->check_lang_exist('pattern_tech_value','pattern_tech_value_id',uri_assoc('p_id'))) {
			$this->db->set('pattern_tech_value', $db_array['pattern_tech_value']);
			$this->db->where(array('pattern_tech_value_id'=>$db_array['pattern_tech_value_id'], 'lang'=>$db_array['lang']));
			$this->db->update('pattern_tech_value_lang');
		}
		else {
			$this->db->set('pattern_tech_value_id', $db_array['pattern_tech_value_id']);
			$this->db->set('lang', $db_array['lang']);
			$this->db->set('pattern_tech_value', $db_array['pattern_tech_value']);
			$this->db->insert('pattern_tech_value_lang');
		}
	}
	
	public function get_pattern_tech_value_lang($pattern_tech_value_id)
	{
		$this->db->select('pattern_tech_value');
		$this->db->from('pattern_tech_value_lang');
		$this->db->where(array('lang'=>'ENG','pattern_tech_value_id'=>$pattern_tech_value_id));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row()->pattern_tech_value;
		else return false;
	}
}