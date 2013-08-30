<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_page extends CI_Model {
	
	private $table_pagename;
	private $table_menu;
	private $table_pagetree;
	
	private $table_pagelang;
	private $table_menulang;
	
	public function __construct()
	{		
		parent::__construct();
		$this->table_pagename = 'pages';
		$this->table_pagelang = 'page_lang';
		
		$this->table_menu = 'isuzu_menu';
		$this->table_menulang = 'isuzu_menu_lang';
		
		$this->table_pagetree = 'page_tree';
	}
	
	public function get_parent_menu($lang='')
	{
		$this->db->select($this->table_menu.'.*');
		$this->db->join($this->table_menulang, $this->table_menulang.'.menu_id='.$this->table_menu.'.id', 'left');
		$this->db->where($this->table_menu.'.active','1');
		$this->db->where($this->table_menu.'.seft_id',0);
		if($lang=='ENG'){
			$this->db->select($this->table_menulang.'.*');
			$this->db->where($this->table_menulang.'.lang',$lang);
		}
		$this->db->order_by($this->table_menu.'.display_order asc, '.$this->table_menu.'.updated_on desc');
		$query = $this->db->get($this->table_menu);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function get_child_menu($parent_id, $lang='')
	{
		//$this->db->select('id, seft_id parent_id, name as menu_name, title as menu_title, menu_slug as slug, url as menu_url');
		$this->db->select($this->table_menu.'.*');
		$this->db->join($this->table_menulang, $this->table_menulang.'.menu_id='.$this->table_menu.'.id', 'left');
		$this->db->where($this->table_menu.'.active','1');
		$this->db->where($this->table_menu.'.seft_id',$parent_id);
		if($lang=='ENG'){
			$this->db->select($this->table_menulang.'.*');
			$this->db->where($this->table_menulang.'.lang',$lang);
		}
		$this->db->order_by($this->table_menu.'.display_order asc, '.$this->table_menu.'.updated_on desc');
		$query = $this->db->get($this->table_menu);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	// get pages show on home
	public function get_pages_home($onpageshow=1, $limit, $lang='')
	{
		//$this->db->select('page_id, page_title as page_name, page_slug, page_content');
		$this->db->select($this->table_pagename.'.*');
		$this->db->join($this->table_pagelang, $this->table_pagelang.'.page_id='.$this->table_pagename.'.page_id', 'left');
		
		$this->db->where($this->table_pagename.'.active','1');
		$this->db->where($this->table_pagename.'.page_tree_pt_id',$onpageshow);
		
		if($lang=='ENG'){
			$this->db->select($this->table_pagelang.'.*');
			$this->db->where($this->table_pagelang.'.lang',$lang);
		}
		
		$this->db->order_by($this->table_pagename.'.display_order asc');
		$this->db->limit($limit);
		$query = $this->db->get($this->table_pagename);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	// detail
	
	public function get_page_by_slug($page_slug, $lang='')
	{
		$this->db->select($this->table_pagename.'.*');
		$this->db->join($this->table_pagelang, $this->table_pagelang.'.page_id='.$this->table_pagename.'.page_id', 'left');
		
		$this->db->where($this->table_pagename.'.active','1');
		$this->db->where($this->table_pagename.'.page_slug',trim($page_slug));
		
		if($lang=='ENG'){
			$this->db->select($this->table_pagelang.'.*');
			$this->db->where($this->table_pagelang.'.lang',$lang);
		}
		
		$this->db->order_by($this->table_pagename.'.display_order asc, '.$this->table_pagename.'.updated_on desc');
		$this->db->limit(1);
		$query = $this->db->get($this->table_pagename);
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
	/* save form registration */
	public function save_test_drive_regform($full_name, $gender, $birthdate, $company, $form_email, $phone, $address, $city, $item_owner, $item_registered, $date_received)
	{
		$this->db->set('full_name', $full_name);
		$this->db->set('gender', $gender);
		$this->db->set('birthdate', $birthdate);
		$this->db->set('company', $company);
		$this->db->set('form_email', $form_email);
		$this->db->set('phone', $phone);
		$this->db->set('address', $address);
		$this->db->set('city', $city);
		$this->db->set('item_owner', $item_owner);
		$this->db->set('item_registered', $item_registered);
		$this->db->set('date_received', $date_received);
		
		$this->db->insert('reg_form_drive');
		return $this->db->insert_id();
	}
	
	public function save_event_regform($full_name, $gender, $birthdate, $company, $form_email, $phone, $address, $city, $item_owner, $event_id, $date_received)
	{
		$this->db->set('full_name', $full_name);
		$this->db->set('gender', $gender);
		$this->db->set('birthdate', $birthdate);
		$this->db->set('company', $company);
		$this->db->set('form_email', $form_email);
		$this->db->set('phone', $phone);
		$this->db->set('address', $address);
		$this->db->set('city', $city);
		$this->db->set('item_owner', $item_owner);
		$this->db->set('event_id', $event_id);
		$this->db->set('date_received', $date_received);
				
		$this->db->insert('reg_form_event');
		return $this->db->insert_id();
	}
	
}
