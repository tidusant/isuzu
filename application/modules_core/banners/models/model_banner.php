<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_banner extends MY_Model {
	
	var $table_name;
	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'banners';
	}
	
	public function get_banner($position_id=1, $limit)
	{
		$this->db->where(array($this->table_name.'.active'=>'1', $this->table_name.'.position_id'=>$position_id));
		$this->db->order_by($this->table_name.'.display_order asc, '.$this->table_name.'.updated_on desc');
		$this->db->limit($limit);
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
}
