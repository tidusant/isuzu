<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_product extends CI_Model {
	
	private $table_query;
	private $table_lang;
	
	public function __construct() {		
		parent::__construct();
		$this->table_query = 'products';
		$this->table_lang = 'products_lang';
	}
	
	public function get_product_home($limit, $lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->join($this->table_lang, $this->table_lang.'.product_id='.$this->table_query.'.product_id', 'left');
		$this->db->where($this->table_query.'.active', '1');
		$this->db->where($this->table_query.'.ishot', '1');
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
	
	public function get_product_list_selectbox($limit, $lang='')
	{
		$this->db->select($this->table_query.'.product_id, '.$this->table_query.'.product_name');
		$this->db->where($this->table_query.'.active', '1');
		if($lang=='ENG'){
			$this->db->join($this->table_lang, $this->table_lang.'.product_id='.$this->table_query.'.product_id', 'left');
			$this->db->select($this->table_lang.'.product_name');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->order_by($this->table_query.'.display_order asc, '.$this->table_query.'.updated_on desc');
		$this->db->limit($limit);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	// list product by cate select box
	public function get_product_list_by_cate_selectbox($cate_id, $limit, $lang='')
	{
		$this->db->select($this->table_query.'.product_id, '.$this->table_query.'.product_name');
		$this->db->where($this->table_query.'.active', '1');
		$this->db->where($this->table_query.'.product_cate_pc_id', $cate_id);
		if($lang=='ENG'){
			$this->db->join($this->table_lang, $this->table_lang.'.product_id='.$this->table_query.'.product_id', 'left');
			$this->db->select($this->table_lang.'.product_name');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->order_by($this->table_query.'.display_order asc');
		$this->db->limit($limit);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	// product index
	public function get_product_list_by_cate($category_id, $limit, $lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->join($this->table_lang, $this->table_lang.'.product_id='.$this->table_query.'.product_id', 'left');
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
	
	// get product id
	public function get_product_id($product_slug)
	{
		$this->db->select('product_id');
		$this->db->from($this->table_query);
		$this->db->where(array('active'=>'1', 'product_slug'=>$product_slug));
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row()->product_id;
		else return false;
	}
	
	// get product name
	public function get_product_name($product_id, $lang='')
	{
		$this->db->select($this->table_query.'.product_name');
		$this->db->join($this->table_lang, $this->table_lang.'.product_id='.$this->table_query.'.product_id', 'left');
		$this->db->where($this->table_query.'.active', '1');
		$this->db->where($this->table_query.'.product_id', $product_id);
		if($lang=='ENG'){
			$this->db->select($this->table_lang.'.product_name');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query->row()->product_name;
		else return false;
	}
	
	// get product detail
	public function get_product_detail($product_id, $lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->join($this->table_lang, $this->table_lang.'.product_id='.$this->table_query.'.product_id', 'left');
		$this->db->where($this->table_query.'.active', '1');
		$this->db->where($this->table_query.'.product_id', $product_id);
		if($lang=='ENG'){
			$this->db->select($this->table_lang.'.*');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->order_by($this->table_query.'.updated_on desc');
		$this->db->limit(1);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
	public function get_product_info($product_slug)
	{
		$this->db->where(array('active'=>'1', 'product_slug'=>$product_slug));
		$this->db->order_by('updated_on desc');
		$this->db->limit(1);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
	public function get_product_info_gallery($product_slug)
	{
		$this->db->where(array('active'=>'1', 'product_slug'=>$product_slug));
		$this->db->order_by('updated_on desc');
		$this->db->limit(1);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
	// get other products
	public function get_other_product_by_cate($catalog_id, $product_id, $lang='')
	{
		$this->db->select($this->table_query.'.product_id, '.$this->table_query.'.product_name, '.$this->table_query.'.product_cate_pc_id');
		$this->db->join($this->table_lang, $this->table_lang.'.product_id='.$this->table_query.'.product_id', 'left');
		$this->db->where($this->table_query.'.active', '1');
		$this->db->where($this->table_query.'.product_cate_pc_id', $catalog_id);
		$this->db->where_not_in($this->table_query.'.product_id', $product_id);
		if($lang=='ENG'){
			$this->db->select($this->table_lang.'.product_name');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->order_by($this->table_query.'.display_order asc, '.$this->table_query.'.product_id asc');
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	// thong so ki thuat info
	public function check_product_tech_pattern($catalog_id, $product_id)
	{
		$this->db->select('pattern_tech_value.tech_value, pattern_tech_value.product_id, pattern_tech.*');
		$this->db->from('pattern_tech');
		$this->db->join('pattern_tech_value', 'pattern_tech_value.pattern_tech_id=pattern_tech.id', 'left');
		$this->db->where(array('pattern_tech.product_cate_pc_id'=>$catalog_id,'pattern_tech_value.product_id'=>$product_id));
		$this->db->order_by('pattern_tech.id asc');
		$query = $this->db->get();
		if($query->num_rows() > 0) return true;
		else return false;
	}
	
	public function get_product_tech_pattern_by_group($group_id, $catalog_id, $product_id, $lang='')
	{
		$this->db->select('pattern_tech_value.tech_value, pattern_tech_value.product_id, pattern_tech.*');
		$this->db->join('pattern_tech_value', 'pattern_tech_value.pattern_tech_id=pattern_tech.id', 'left');
		
		if($lang=='ENG'){
			// language
			$this->db->join('pattern_tech_lang', 'pattern_tech_lang.pattern_tech_id=pattern_tech.id', 'left');
			$this->db->join('pattern_tech_value_lang', 'pattern_tech_value_lang.pattern_tech_value_id=pattern_tech_value.id', 'left');
			$this->db->select('pattern_tech_lang.*, pattern_tech_value_lang.pattern_tech_value as tech_value');
			$this->db->where(array('pattern_tech_lang.lang'=>$lang, 'pattern_tech_value_lang.lang'=>$lang));
		}
		
		$this->db->where(array('pattern_tech.product_cate_pc_id'=>$catalog_id,'pattern_tech.pattern_group_id'=>$group_id,'pattern_tech_value.product_id'=>$product_id));
		$this->db->order_by('pattern_tech.id asc');
		$query = $this->db->get('pattern_tech');
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function get_product_tech_pattern_value($product_id, $pattern_tech_id, $lang='')
	{
		$this->db->select('pattern_tech_value.tech_value');
		
		if($lang=='ENG'){
			// language
			$this->db->join('pattern_tech_value_lang', 'pattern_tech_value_lang.pattern_tech_value_id=pattern_tech_value.id', 'left');
			$this->db->select('pattern_tech_value_lang.pattern_tech_value as tech_value');
			$this->db->where('pattern_tech_value_lang.lang',$lang);
		}
		
		$this->db->where(array('pattern_tech_value.product_id'=>$product_id,'pattern_tech_value.pattern_tech_id'=>$pattern_tech_id));
		$query = $this->db->get('pattern_tech_value');
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	// get pattern tech group
	public function get_pattern_group($lang='')
	{
		$this->db->select('pattern_group.id, pattern_group.group_name');
		$this->db->join('pattern_group_lang', 'pattern_group_lang.group_id=pattern_group.id', 'left');
		
		if($lang=='ENG'){
			$this->db->select('pattern_group_lang.group_name');
			$this->db->where('pattern_group_lang.lang',$lang);
		}
		
		$query = $this->db->get('pattern_group');
		if($query->num_rows() > 0) {
			$arr_return = array();
			foreach($query->result() as $group)
			{
				if($this->_check_pattern_group_have_child($group->id))
					$arr_return[$group->id] = $group->group_name;
			}
			return $arr_return;
		}
		else return false;
	}
	
	private function _check_pattern_group_have_child($group_id)
	{
		$result = 0;
		$this->db->where('pattern_group_id', $group_id);
		$this->db->from('pattern_tech');
		$result = $this->db->count_all_results();
		return $result = ($result > 0)? true:false;
	}
	
	/*###################### IMAGE PROCESSING ########################*/
	
	/*########### 1: slide, 2: noithat, 3: ngoaithat, 4: an toan, 5: bang mau ###########*/
	
	// get product slide banner
	public function get_product_gallery($product_gallery_id, $gallery_type, $lang='')
	{
		$this->db->select('product_gallery.product_gallery_images, product_gallery.product_gallery_caption, product_gallery.product_gallery_video');
		if($lang=='ENG'){
			// language
			$this->db->join('product_gallery_lang', 'product_gallery_lang.id=product_gallery.id', 'left');
			$this->db->select('product_gallery_lang.product_gallery_caption');
			$this->db->where('product_gallery_lang.lang',$lang);
		}
		
		$this->db->where(array('product_gallery.id'=>$product_gallery_id, 'product_gallery.product_gallery_type'=>$gallery_type)); // slide
		$this->db->limit(1);
		$query = $this->db->get('product_gallery');
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
	public function get_product_gallery_path($product_gal_id)
	{
		$this->db->select('full_path_image');
		$this->db->where('id', $product_gal_id);
		$this->db->order_by('created_on desc');
		$this->db->limit(1);
		$query = $this->db->get('product_gallery');
		if($query->num_rows() > 0) return $query->row()->full_path_image;
		else return false;
	}
}