<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_weblink extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'web_links';

		$this->primary_key = 'web_links.id';
		$this->order_by = 'web_links.title ASC';
	}
	
	public function get_weblink_title($id) {

		$this->db->select('title');
		$this->db->where('id', $id);

		return $this->db->get($this->table_name)->row()->title;

	}
	
	public function validate() {
		
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('weblink', 'Link', 'trim|required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('display_order', $this->lang->line('news_priority'), 'numeric|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('active', $this->lang->line('news_active'));
		
		return parent::validate($this);

	}

	public function delete($weblink_id) {
		
		parent::delete(array('id'=>$weblink_id));
	}

	public function save($db_array = NULL) {

		if (!$db_array) {

			$db_array = parent::db_array();

		}
			
		if (!$this->input->post('active') and !isset($db_array['active'])) {

			$db_array['active'] = '0';
			
		}
		
		parent::save($db_array, uri_assoc('weblink_id'));
		
	}
	
}