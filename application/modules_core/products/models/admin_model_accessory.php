<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_accessory extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'accessories';
		$this->primary_key = 'accessories.acc_id';
		$this->order_by = 'accessories.updated_on desc';
		
	}
	
	public function get_accessory_list()
	{
		$this->db->select('acc_id, acc_name');
		$this->db->where('active', '1');
		
		$query = $this->db->get($this->table_name);
		
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function get_accessory_name($a_id) {

		$this->db->select('acc_name');
		$this->db->where('acc_id', $a_id);

		return $this->db->get($this->table_name)->row()->acc_name;

	}
	
	public function total_accessory_count()
	{
		$this->db->where('active', '1');
		return $this->db->count_all_results($this->table_name);
	}
	
	// add - edit action
	public function validate() {
		$this->form_validation->set_rules('acc_name', $this->lang->line('part_name'), 'required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('acc_price', 'Price', 'trim|numeric|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('acc_link_image', 'Image', 'trim|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('acc_desc', $this->lang->line('part_description'), 'xss_clean');
		$this->form_validation->set_rules('feature', $this->lang->line('accessory_feature'));
		$this->form_validation->set_rules('display_order', $this->lang->line('part_priority'), 'trim|numeric');
		$this->form_validation->set_rules('active', $this->lang->line('part_active'));
		
		return parent::validate($this);
	}

	public function delete($a_id) {

		/* Delete the client record */
		parent::delete(array('acc_id'=>$a_id));
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
		
		$acc_id = 0;
		$acc_id = parent::save_return_id($db_array, uri_assoc('a_id'));
		
		// save language
		unset($db_array);
		$db_array = array('acc_id'=>$acc_id,
						'lang'=>'ENG',
						'acc_name'=>trim(htmlspecialchars($this->input->post('acc_name_en'))),
						'acc_desc'=>trim($this->input->post('acc_desc_en', TRUE))
						);
		
		$this->_set_accessory_lang($db_array);
	}
	
	/*#################### language processing ###########################*/
	private function _set_accessory_lang($db_array) {
		if($this->check_lang_exist('accessories','acc_id',uri_assoc('a_id'))) {
			$this->db->set('acc_name', $db_array['acc_name']);
			$this->db->set('acc_desc', $db_array['acc_desc']);
			$this->db->where(array('acc_id'=>$db_array['acc_id'], 'lang'=>$db_array['lang']));
			$this->db->update('accessories_lang');
		}
		else {
			$this->db->set('acc_id', $db_array['acc_id']);
			$this->db->set('lang', $db_array['lang']);
			$this->db->set('acc_name', $db_array['acc_name']);
			$this->db->set('acc_desc', $db_array['acc_desc']);
			$this->db->insert('accessories_lang');
		}
	}
	
	public function get_accessory_lang($acc_id)
	{
		$this->db->select('acc_name, acc_desc');
		$this->db->from('accessories_lang');
		$this->db->where(array('lang'=>'ENG','acc_id'=>$acc_id));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
}