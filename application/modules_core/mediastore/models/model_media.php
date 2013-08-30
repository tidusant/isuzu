<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_media extends CI_Model {
	
	var $table_name;
	var $join_table_name;
	
	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'media';
	}
	
	public function get_media()
	{
		$this->db->select('id, media_name, media_filename, media_path, main_url, thumb_url');
		$this->db->from($this->table_name);
		$this->db->where('active', '1');
		$this->db->order_by('updated_on DESC');
	//	$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function get_media_news($news_id)
	{
		
		$this->db->select($this->table_name.'.media_name, '.$this->table_name.'.media_filename, '.$this->table_name.'.media_path, '.$this->table_name.'.main_url, '.$this->table_name.'.thumb_url');
		$this->db->from($this->table_name);
		$this->db->join('event_media', 'event_media.media_id=media.id', 'left');
		$this->db->where(array($this->table_name.'.active'=>'1', 'event_media.event_id'=>$news_id));
		$this->db->order_by($this->table_name.'.updated_on DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
	public function get_media_product($product_id)
	{
		
		$this->db->select($this->table_name.'.media_name, '.$this->table_name.'.media_filename, '.$this->table_name.'.media_path, '.$this->table_name.'.main_url, '.$this->table_name.'.thumb_url');
		$this->db->from($this->table_name);
		$this->db->join('product_media', 'product_media.media_id=media.id', 'left');
		$this->db->where(array($this->table_name.'.active'=>'1', 'product_media.product_id'=>$product_id));
		$this->db->order_by($this->table_name.'.updated_on DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
	public function get_media_category($cate_id)
	{
		
		$this->db->select($this->table_name.'.media_name, '.$this->table_name.'.media_filename, '.$this->table_name.'.media_path, '.$this->table_name.'.main_url, '.$this->table_name.'.thumb_url');
		$this->db->from($this->table_name);
		$this->db->join('product_cate_media', 'product_cate_media.media_id='.$this->table_name.'.id', 'left');
		$this->db->where(array($this->table_name.'.active'=>'1', 'product_cate_media.pc_id'=>$cate_id));
		$this->db->order_by($this->table_name.'.updated_on DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
}