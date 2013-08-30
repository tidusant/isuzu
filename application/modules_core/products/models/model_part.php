<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_part extends CI_Model {
	
	private $table_query;
	private $table_lang;
	
	public function __construct() {		
		parent::__construct();
		$this->table_query = 'parts';
		$this->table_lang = 'parts_lang';
	}
	
	// product index
	public function get_part_list_by_cate($category_id, $limit, $lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->join($this->table_lang, $this->table_lang.'.part_id='.$this->table_query.'.part_id', 'left');
		$this->db->where($this->table_query.'.active', '1');
		$this->db->where($this->table_query.'.product_cate_pc_id', $category_id);
		if($lang=='ENG'){
			$this->db->select($this->table_lang.'.*');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->order_by($this->table_query.'.display_order asc, '.$this->table_query.'.updated_on desc');
		$this->db->limit($limit);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	// accessory
	public function get_accessories_list($limit, $lang='')
	{
		$this->db->select('accessories.*');
		$this->db->join('accessories_lang', 'accessories_lang.acc_id=accessories.acc_id', 'left');
		$this->db->where('accessories.active', '1');
		if($lang=='ENG'){
			$this->db->select('accessories_lang.*');
			$this->db->where('accessories_lang.lang',$lang);
		}
		$this->db->order_by('accessories.display_order asc, accessories.updated_on desc');
		$this->db->limit($limit);
		$query = $this->db->get('accessories');
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	// rearbody
	public function get_rearbody_list($limit, $lang='')
	{
		$this->db->select('rearbody.*');
		$this->db->join('rearbody_lang', 'rearbody_lang.rearbody_id=rearbody.rearbody_id', 'left');
		$this->db->where('rearbody.active', '1');
		if($lang=='ENG'){
			$this->db->select('rearbody_lang.*');
			$this->db->where('rearbody_lang.lang',$lang);
		}
		$this->db->order_by('rearbody.display_order asc, rearbody.updated_on desc');
		$this->db->limit($limit);
		$query = $this->db->get('rearbody');
		if($query->num_rows() > 0) return $query;
		else return false;
	}
}