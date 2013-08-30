<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_category extends CI_Model {
	
	private $table_query;
	private $table_lang;
	public function __construct()
	{		
		parent::__construct();
		$this->table_query = 'product_cate';
		$this->table_lang = 'product_cate_lang';
	}
	
	// get priority categories
	public function get_priority_catalog($lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->join($this->table_lang, $this->table_lang.'.pc_id='.$this->table_query.'.pc_id', 'left');
		$this->db->where($this->table_query.'.active', '1');
		if($lang=='ENG'){
			$this->db->select($this->table_lang.'.*');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->order_by('display_order asc');
		$this->db->limit(4);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	// main menu list
	
	public function get_category_menu($lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->where($this->table_query.'.active', '1');
		if($lang=='ENG'){
			$this->db->join($this->table_lang, $this->table_lang.'.pc_id='.$this->table_query.'.pc_id', 'left');
			$this->db->select($this->table_lang.'.*');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->order_by('display_order asc');
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	// return id
	public function get_category_id($category_slug)
	{
		$this->db->select('pc_id');
		$this->db->from($this->table_query);
		$this->db->where(array('active'=>'1', 'pc_slug'=>$category_slug));
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row()->pc_id;
		else return false;
	}
	
	// return slug
	public function get_category_slug($category_id)
	{
		$this->db->select('pc_slug');
		$this->db->from($this->table_query);
		$this->db->where(array('active'=>'1', 'pc_id'=>$category_id));
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row()->pc_slug;
		else return false;
	}
	
	// get product category info
	public function get_category_info($category_slug, $lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->join($this->table_lang, $this->table_lang.'.pc_id='.$this->table_query.'.pc_id', 'left');
		$this->db->where($this->table_query.'.active', '1');
		$this->db->where($this->table_query.'.pc_slug', $category_slug);
		if($lang=='ENG'){
			$this->db->select($this->table_lang.'.*');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->limit(1);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
	public function get_category_info_id($category_id, $lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->join($this->table_lang, $this->table_lang.'.pc_id='.$this->table_query.'.pc_id', 'left');
		$this->db->where($this->table_query.'.active', '1');
		$this->db->where($this->table_query.'.pc_id', $category_id);
		if($lang=='ENG'){
			$this->db->select($this->table_lang.'.*');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->limit(1);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
	/// category list
	public function get_category_list($limit, $lang='')
	{
		//$this->db->select('pc_id as cate_id, pc_name as cate_name, pc_slug as slug, pc_image_link');
		$this->db->select($this->table_query.'.*');
		$this->db->join($this->table_lang, $this->table_lang.'.pc_id='.$this->table_query.'.pc_id', 'left');
		$this->db->where($this->table_query.'.active', '1');
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
	
	/// category list
	public function get_priority_category_list($limit, $lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->join($this->table_lang, $this->table_lang.'.pc_id='.$this->table_query.'.pc_id', 'left');
		$this->db->where($this->table_query.'.active', '1');
		if($lang=='ENG'){
			$this->db->select($this->table_lang.'.*');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->order_by($this->table_query.'.display_order asc');
		$this->db->limit($limit);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	// get category name
	public function get_category_name($id, $lang='')
	{
		$this->db->select($this->table_query.'.pc_name');
		$this->db->join($this->table_lang, $this->table_lang.'.pc_id='.$this->table_query.'.pc_id', 'left');
		$this->db->where($this->table_query.'.active', '1');
		$this->db->where($this->table_query.'.pc_id', $id);
		if($lang=='ENG'){
			$this->db->select($this->table_lang.'.pc_name');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->limit(1);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query->row()->pc_name;
		else return false;
	}
	
	// get pc_gallery_id by slug
	public function get_category_gallery_id($cate_id)
	{
		$this->db->select('pc_gallery_id');
		$this->db->where('pc_id', $cate_id);
		$query = $this->db->get('product_cate');
		if($query->num_rows() > 0) return $query->row()->pc_gallery_id;
		else return false;
	}
	
	// get catagory slide banner
	public function get_category_slide_banner($cate_slide_id)
	{
		$this->db->where(array('id'=>$cate_slide_id, 'cate_type'=>'cate-slide')); // slide banner
		$this->db->limit(1);
		$query = $this->db->get('product_cate_gallery');
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
	/// get category gallery
	public function get_category_gallery($cate_gallery_id, $lang='')
	{	
		$this->db->select('product_cate_gallery.*');
		if($lang=='ENG'){
			$this->db->select('product_cate_gallery_lang.*');
			$this->db->join('product_cate_gallery_lang', 'product_cate_gallery_lang.id=product_cate_gallery.id', 'left');
			$this->db->where('product_cate_gallery_lang.lang',$lang);
		}
		
		$this->db->where(array('product_cate_gallery.id'=>$cate_gallery_id, 'product_cate_gallery.cate_type'=>'cate-gallery')); // gallery
		
		$this->db->limit(1);
		$query = $this->db->get('product_cate_gallery');
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
	// check category gallery
	public function check_category_gallery($cate_gallery_id)
	{
		$this->db->select('id');
		$this->db->where(array('id'=>$cate_gallery_id, 'cate_type'=>'cate-gallery')); // gallery
		$this->db->limit(1);
		$query = $this->db->get('product_cate_gallery');
		if($query->num_rows() > 0) return true;
		else return false;
	}
}