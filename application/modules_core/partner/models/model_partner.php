<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_partner extends CI_Model {

	private $table_query;
	private $table_lang;
	public function __construct()
	{		
		parent::__construct();
		$this->table_query = 'partners';
		$this->table_lang = 'partners_lang';
	}
	
	// location
	public function get_location($lang='')
	{
		$this->db->select('ll_id, location');
		if($lang=='ENG') $this->db->select('location_en as location');
		$this->db->from('location_list');
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	/// partner list
	public function get_partner_list($start, $limit, $lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->join($this->table_lang, $this->table_lang.'.partner_id='.$this->table_query.'.partner_id', 'left');
		$this->db->where($this->table_query.'.active', '1');
		if($lang=='ENG'){
			$this->db->select($this->table_lang.'.*');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->order_by($this->table_query.'.display_order ASC, '.$this->table_query.'.updated_on DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function get_partner_by_location($location_id, $limit, $lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->join($this->table_lang, $this->table_lang.'.partner_id='.$this->table_query.'.partner_id', 'left');
		$this->db->where($this->table_query.'.active', '1');
		$this->db->where($this->table_query.'.partner_location', $location_id);
		if($lang=='ENG'){
			$this->db->select($this->table_lang.'.*');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		
		$this->db->order_by($this->table_query.'.display_order ASC, '.$this->table_query.'.updated_on DESC');
		$this->db->limit($limit);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
}