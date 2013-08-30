<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_menu extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'isuzu_menu';
		$this->primary_key = 'isuzu_menu.id';
		$this->order_by = 'isuzu_menu.name';
	}
	
	
	public function get($params = NULL) {

		$menu = parent::get($params);

		return $menu;

	}
	
	public function get_list_menu()
	{
		$this->db->select('id, name');
		$this->db->from($this->table_name);
		$this->db->where('active', '1');
		$this->db->order_by('display_order ASC, updated_on DESC');
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		return false;
	}
	
	public function get_root_list_menu()
	{
		$this->db->select('id, name');
		$this->db->from($this->table_name);
		$this->db->where(array('active'=>'1','seft_id'=>0));
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		return false;
	}
	
	public function get_child_list_menu($parent_menu_id)
	{
		$this->db->select('id, name');
		$this->db->from($this->table_name);
		$this->db->where(array('active'=>'1','seft_id'=>$parent_menu_id));
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		return false;
	}
	
	public function get_menu_name($menu_id) {

		$this->db->select('name');
		$this->db->where('id', $menu_id);

		return $this->db->get($this->table_name)->row()->name;

	}
	
	public function get_parents_name($submenu_id)
	{
		$this->db->select('name');
		$this->db->from($this->table_name);
		$this->db->where(array('active'=>'1','id'=>$submenu_id));
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row()->name;
		return false;
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
		$this->form_validation->set_rules('seft_id', $this->lang->line('root_menu_name'));
		$this->form_validation->set_rules('name', $this->lang->line('menu_name'), 'trim|required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('title', $this->lang->line('menu_title'), 'trim|required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('menu_slug', $this->lang->line('menu_slug'), 'trim|required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('url', $this->lang->line('menu_url'), 'xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('display_order', $this->lang->line('menu_priority'));
		$this->form_validation->set_rules('active', $this->lang->line('menu_active'));
		
		return parent::validate($this);

	}

	public function delete($menu_id) {

		/* Delete the author record */
		parent::delete(array('id'=>$menu_id));
	}

	public function save($db_array = NULL) {
		
		if (!$db_array) $db_array = parent::db_array();
		// date create - date update
		$db_array['created_on'] = time();
		$db_array['updated_on'] = time();
			
		if (!$this->input->post('active') and !isset($db_array['active'])) {
			$db_array['active'] = 0;
		}
		
		$menu_id = 0;
		
		$menu_id = parent::save_return_id($db_array, uri_assoc('menu_id'));
		
		// save language
		unset($db_array);
		$db_array = array('menu_id'=>$menu_id,
						'lang'=>'ENG',
						'name'=>trim(htmlspecialchars($this->input->post('name_en'))),
						'title'=>trim(htmlspecialchars($this->input->post('title_en'))));
		
		$this->_set_menu_lang($db_array);
		
	}
	
	private function _set_menu_lang($db_array) {
		if($this->check_lang_exist('isuzu_menu','menu_id',uri_assoc('menu_id'))) {
			$this->db->set('name',$db_array['name']);
			$this->db->set('title',$db_array['title']);
			$this->db->where(array('menu_id'=>$db_array['menu_id'], 'lang'=>$db_array['lang']));
			$this->db->update('isuzu_menu_lang');
		}
		else {
			$this->db->set('menu_id',$db_array['menu_id']);
			$this->db->set('lang',$db_array['lang']);
			$this->db->set('name',$db_array['name']);
			$this->db->set('title',$db_array['title']);
			$this->db->insert('isuzu_menu_lang');
		}
	}
	
	public function get_menu_lang($menu_id)
	{
		$this->db->select('name, title');
		$this->db->from('isuzu_menu_lang');
		$this->db->where(array('menu_id'=>$menu_id,'lang'=>'ENG'));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
}
