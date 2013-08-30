<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_page extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'pages';
		$this->primary_key = 'pages.page_id';
		$this->order_by = 'pages.page_title';
	}
	
	
	public function get($params = NULL) {

		$pages = parent::get($params);

		return $pages;

	}
	
	public function get_list_page_index()
	{
		$this->db->where('active', '1');
		if($this->session->userdata('member_id') != 1 && $this->session->userdata('user_level')!=1) $this->db->where_not_in('page_id', array(10,11));
		$this->db->order_by('updated_on desc');
		$query = $this->db->get('pages');
		if($query->num_rows() > 0) return $query;
		return false;
	}
	
	public function get_list_page()
	{
		$this->db->select('page_id, page_title');
		$this->db->from('pages');
		$this->db->where('active', '1');
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		return false;
	}
	
	public function get_page_title($page_id) {

		$this->db->select('page_title');
		$this->db->where('page_id', $page_id);

		return $this->db->get('pages')->row()->page_title;

	}

	public function validate() {
		
		$this->form_validation->set_rules('page_tree_pt_id', $this->lang->line('pagetree_module'), 'trim|xss_clean');
		$this->form_validation->set_rules('isuzu_menu_id', $this->lang->line('menu_module'), 'trim|xss_clean');
		$this->form_validation->set_rules('page_title', $this->lang->line('page_name'), 'required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('page_slug', $this->lang->line('page_slug'), 'required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('page_content', $this->lang->line('page_description'), 'required');
		$this->form_validation->set_rules('layout', 'Page Layout', 'trim|xss_clean');
		$this->form_validation->set_rules('display_order', $this->lang->line('page_priority'));
		$this->form_validation->set_rules('active', $this->lang->line('page_active'));
		
		return parent::validate($this);

	}

	public function delete($page_id) {

		/* Delete the author record */
		parent::delete(array('page_id'=>$page_id));
	}

	public function save($db_array = NULL) {
		
		if (!$db_array) $db_array = parent::db_array();
		
		// date create - date update
		$db_array['created_on'] = time();
		$db_array['updated_on'] = time();
			
		if (!$this->input->post('active') and !isset($db_array['active'])) {
			$db_array['active'] = 0;
		}
		
		$page_id = 0;
		$page_id = parent::save_return_id($db_array, uri_assoc('page_id'));
		
		// save language
		unset($db_array);
		$db_array = array('page_id'=>$page_id,
						'lang'=>'ENG',
						'page_title'=>trim(htmlspecialchars($this->input->post('page_title_en'))),
						'page_content'=>trim($this->input->post('page_content_en'))
						);
		
		$this->_set_page_lang($db_array);
	}
	
	private function _set_page_lang($db_array) {
		if($this->check_lang_exist('page','page_id',uri_assoc('page_id'))) {
			$this->db->set('page_title',$db_array['page_title']);
			$this->db->set('page_content',$db_array['page_content']);
			$this->db->where(array('page_id'=>$db_array['page_id'], 'lang'=>$db_array['lang']));
			$this->db->update('page_lang');
		}
		else {
			$this->db->set('page_id',$db_array['page_id']);
			$this->db->set('lang',$db_array['lang']);
			$this->db->set('page_title',$db_array['page_title']);
			$this->db->set('page_content',$db_array['page_content']);
			$this->db->insert('page_lang');
		}
	}
	
	public function get_page_lang($page_id)
	{
		$this->db->select('page_title, page_content');
		$this->db->from('page_lang');
		$this->db->where(array('page_id'=>$page_id,'lang'=>'ENG'));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
}