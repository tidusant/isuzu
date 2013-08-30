<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_pagetree extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'page_tree';
		$this->primary_key = 'page_tree.pt_id';
		$this->order_by = 'page_tree.pt_name';
	}
	
	
	public function get($params = NULL) {

		$pagetree = parent::get($params);

		return $pagetree;

	}
	
	public function get_list_page_tree()
	{
		$this->db->select('pt_id, pt_name');
		$this->db->from('page_tree');
		$this->db->where('active', '1');
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		return false;
	}
	
	public function get_pagetree_name($pt_id) {

		$this->db->select('pt_name');
		$this->db->where('pt_id', $pt_id);

		return $this->db->get('page_tree')->row()->pt_name;

	}

	public function get_active($params = NULL) {

		if (!$params) {

			$params = array(
				'where'	=>	array(
					'active'	=>	1
				)
			);

		}

		else {

			$params['where']['active'] = 1;

		}

		return $this->get($params);

	}

	public function validate() {
		$this->form_validation->set_rules('pt_name', $this->lang->line('pagetree_name'), 'trim|required|xss_clean|htmlspecialchars|callback__ptname_check');
		$this->form_validation->set_rules('display_order', $this->lang->line('pagetree_priority'));
		$this->form_validation->set_rules('active', $this->lang->line('pagetree_active'));
		
		return parent::validate($this);

	}

	public function delete($pt_id) {

		/* Delete the author record */
		parent::delete(array('pt_id'=>$pt_id));
	}

	public function save($db_array = NULL) {
		
		if (!$db_array) $db_array = parent::db_array();
		
		// date create - date update
		$db_array['created_on'] = time();
		$db_array['updated_on'] = time();
			
		if (!$this->input->post('active') and !isset($db_array['active'])) {
			$db_array['active'] = 0;
		}

		parent::save($db_array, uri_assoc('pt_id'));

	}
	
	public function _ptname_check($pt_name)
	{
		$this->db->where('pt_name', $pt_name);

		if (uri_assoc('pt_id')) {

			$this->db->where('pt_id <>', uri_assoc('pt_id'));

		}

		$query = $this->db->get($this->table_name);

		if ($query->num_rows()) {

			$this->form_validation->set_message('_ptname_check', $this->lang->line('ptname_already_exists'));

			return FALSE;

		}

		return TRUE;
	}
	
}
