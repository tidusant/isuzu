<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_rearbody extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'rearbody';
		$this->primary_key = 'rearbody.rearbody_id';
		$this->order_by = 'rearbody.updated_on desc';
		
	}
	
	public function get_rearbody_list()
	{
		$this->db->select('rearbody_id, rearbody_name');
		$this->db->where('active', '1');
		
		$query = $this->db->get($this->table_name);
		
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function get_rearbody_name($a_id) {

		$this->db->select('rearbody_name');
		$this->db->where('rearbody_id', $a_id);

		return $this->db->get($this->table_name)->row()->rearbody_name;

	}
	
	public function total_rearbody_count()
	{
		$this->db->where('active', '1');
		return $this->db->count_all_results($this->table_name);
	}
	
	// add - edit action
	public function validate() {
		$this->form_validation->set_rules('rearbody_name', $this->lang->line('part_name'), 'trim|required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('rearbody_price', 'Price', 'trim|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('rearbody_url', 'Page URL', 'trim|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('rear_link_image', 'Image', 'trim|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('rearbody_desc', $this->lang->line('part_description'), 'xss_clean');
		$this->form_validation->set_rules('feature', $this->lang->line('accessory_feature'));
		$this->form_validation->set_rules('display_order', $this->lang->line('part_priority'), 'trim|numeric');
		$this->form_validation->set_rules('active', $this->lang->line('part_active'));
		
		return parent::validate($this);
	}

	public function delete($a_id) {

		/* Delete the client record */
		parent::delete(array('rearbody_id'=>$a_id));
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
		
		$rear_id = 0;
		$rear_id = parent::save_return_id($db_array, uri_assoc('r_id'));
		
		// save language
		unset($db_array);
		$db_array = array('rearbody_id'=>$rear_id,
						'lang'=>'ENG',
						'rearbody_name'=>trim(htmlspecialchars($this->input->post('rearbody_name_en'))),
						'rearbody_desc'=>trim($this->input->post('rearbody_intro_en', TRUE))
						);
		
		$this->_set_rearbody_lang($db_array);
	}
	
	/*#################### language processing ###########################*/
	private function _set_rearbody_lang($db_array) {
		if($this->check_lang_exist('rearbody','rearbody_id',uri_assoc('r_id'))) {
			$this->db->set('rearbody_name', $db_array['rearbody_name']);
			$this->db->set('rearbody_desc', $db_array['rearbody_desc']);
			$this->db->where(array('rearbody_id'=>$db_array['rearbody_id'], 'lang'=>$db_array['lang']));
			$this->db->update('rearbody_lang');
		}
		else {
			$this->db->set('rearbody_id', $db_array['rearbody_id']);
			$this->db->set('lang', $db_array['lang']);
			$this->db->set('rearbody_name', $db_array['rearbody_name']);
			$this->db->set('rearbody_desc', $db_array['rearbody_desc']);
			$this->db->insert('rearbody_lang');
		}
	}
	
	public function get_rearbody_lang($rearbody_id)
	{
		$this->db->select('rearbody_name, rearbody_desc');
		$this->db->from('rearbody_lang');
		$this->db->where(array('lang'=>'ENG','rearbody_id'=>$rearbody_id));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
}