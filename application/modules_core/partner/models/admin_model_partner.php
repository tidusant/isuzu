<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_partner extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'partners';

		$this->primary_key = 'partners.partner_id';
		$this->order_by = 'partners.updated_on DESC';
	}
	
	/* admin */
	
	public function get_partner_name($pa_id) {

		$this->db->select('partner_name');
		$this->db->where('partner_id', $pa_id);

		return $this->db->get($this->table_name)->row()->partner_name;

	}
	
	public function validate() {
		
		$this->form_validation->set_rules('partner_location', $this->lang->line('partner_location'), 'required');
		$this->form_validation->set_rules('partner_name', $this->lang->line('partner_name'), 'trim|required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('partner_link_image', 'Image', 'trim|xss_clean|htmlspecialchars');
		/*$this->form_validation->set_rules('partner_address', 'Address', 'trim|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('partner_email', 'Email', 'trim|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('partner_tel', 'Tel', 'trim|numeric|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('partner_fax', 'Fax', 'trim|numeric|xss_clean|htmlspecialchars');*/
		$this->form_validation->set_rules('partner_description', $this->lang->line('partner_description'), 'trim|required');
		$this->form_validation->set_rules('partner_url', $this->lang->line('partner_url'), 'trim|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('display_order', $this->lang->line('partner_priority'), 'numeric|trim|htmlspecialchars');
		$this->form_validation->set_rules('partner_active', $this->lang->line('partner_active'));
		
		return parent::validate($this);

	}

	public function delete($pa_id) {
		
		parent::delete(array('partner_id'=>$pa_id));
	}

	public function save($db_array = NULL) {

		if (!$db_array) {

			$db_array = parent::db_array();

		}
		
		// date create - date update
		$db_array['created_on'] = time();
		$db_array['updated_on'] = time();
			
		if (!$this->input->post('active') and !isset($db_array['active'])) {

			$db_array['active'] = '0';
			
		}
		
		$pa_id = 0;
		$pa_id = parent::save_return_id($db_array, uri_assoc('pa_id'));
		
		// save language
		unset($db_array);
		$db_array = array('partner_id'=>$pa_id,
						'lang'=>'ENG',
						'partner_name'=>trim(htmlspecialchars($this->input->post('partner_name_en'))),
						'partner_description'=>trim($this->input->post('partner_description_en')));
		
		$this->_set_partner_lang($db_array);
		
	}
	
	private function _set_partner_lang($db_array) {
		if($this->check_lang_exist('partners','partner_id',uri_assoc('pa_id'))) {
			$this->db->set('partner_name', $db_array['partner_name']);
			$this->db->set('partner_description', $db_array['partner_description']);
			$this->db->where(array('partner_id'=>$db_array['partner_id'], 'lang'=>$db_array['lang']));
			$this->db->update('partners_lang');
		}
		else {
			$this->db->set('partner_id', $db_array['partner_id']);
			$this->db->set('lang', $db_array['lang']);
			$this->db->set('partner_name', $db_array['partner_name']);
			$this->db->set('partner_description', $db_array['partner_description']);
			$this->db->insert('partners_lang');
		}
	}
	
	public function get_partner_lang($pa_id)
	{
		$this->db->select('partner_name, partner_description');
		$this->db->from('partners_lang');
		$this->db->where(array('lang'=>'ENG','partner_id'=>$pa_id));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
}