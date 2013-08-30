<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_categallery extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'product_cate_gallery';

		$this->primary_key = 'product_cate_gallery.id';
		$this->order_by = 'product_cate_gallery.created_on';
	}
	
	
	public function get_list_gallery()
	{
		$this->db->select('id, cate_gallery_name');
		$this->db->from($this->table_name);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		return false;
	}
	
	public function get_list_gallery_type($type_name)
	{
		$this->db->select('id, cate_gallery_name');
		$this->db->from($this->table_name);
		$this->db->where('cate_type', $type_name);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		return false;
	}
	
	public function get_categallery_name($categ_id) {

		$this->db->select('cate_gallery_name');
		$this->db->where('id', $categ_id);

		return $this->db->get($this->table_name)->row()->cate_gallery_name;
	}
	
	public function get_categallery_info($categ_id)
	{
		$this->db->where('id', $categ_id);
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0)
		return $query->row();
		else return false;
	}
	
	public function get_categallery_foldername($categ_id)
	{
		$this->db->select('full_url_path');
		$this->db->where('id', $categ_id);
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0) return $query->row()->full_url_path;
		else return false;
	}
	
	// add - edit action
	public function validate() {
		$this->form_validation->set_rules('cate_gallery_name', 'Title', 'required|trim|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('cate_type', 'Cate Type', 'xss_clean');
		
		return parent::validate($this);

	}

	public function delete($categ_id) {
		
		parent::delete(array('id'=>$categ_id));
	}

	public function save($db_array = NULL) {

		if (!$db_array) {

			$db_array = parent::db_array();

		}
		
		// date
		$db_array['created_on'] = time();
		
		/* create folder just happen when adding new gallery */
		if(!uri_assoc('cgal_id')) {
			// add action
			$this->load->helper('isuzu_dir');
			$folder_name = process_string_foldername($db_array['cate_gallery_name']).'_'.$db_array['created_on'];
			// folder created - media folder
			$path_to_categories = $this->config->item('image_upload_path');
			create_sub_folder($path_to_categories, $folder_name, 'categories/');
			$db_array['created_folder'] = realpath($path_to_categories.'categories/'.$folder_name); // and not change anymore
			
			/// full url path
			$db_array['full_url_path'] = $this->config->item('admin_mediastore_real_url').'categories/'.$folder_name;
		}
		
		parent::save($db_array, uri_assoc('cgal_id'));
	}
	
	// update gallery images
	public function get_img_categallery($categal_id) {
		$this->db->select('cate_gallery_images');
		$this->db->where('id', $categal_id);
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0) return $query->row()->cate_gallery_images;
		else return false;
	}
	
	public function get_caption_categallery($categal_id) {
		$this->db->select('cate_gallery_caption');
		$this->db->where('id', $categal_id);
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0) return $query->row()->cate_gallery_caption;
		else return false;
	}
	
	public function update_categallery($categal_id, $str_images, $str_video='')
	{
		if($str_images!='') $this->db->set('cate_gallery_images', $str_images);
		if($str_video!='') $this->db->set('cate_gallery_video', $str_video);
		$this->db->where('id', $categal_id);
		return $this->db->update($this->table_name);
	}
	
	// gallery video
	public function get_video_categallery($categal_id) {
		$this->db->select('cate_gallery_video');
		$this->db->where('id', $categal_id);
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0) return $query->row()->cate_gallery_video;
		else return false;
	}
	
	/// update gallery caption
	public function update_categallery_caption($categal_id, $str_caption)
	{
		$this->db->set('cate_gallery_caption', $str_caption);
		$this->db->where('id', $categal_id);
		return $this->db->update($this->table_name);
	}
	
	public function update_categallery_caption_lang($categal_id, $str_caption_en)
	{
		if($this->check_lang_exist($this->table_name, 'id', $categal_id)) { // update
			$this->db->set('cate_gallery_caption', $str_caption_en);
			$this->db->where(array('id'=>$categal_id, 'lang'=>'ENG'));
			return $this->db->update($this->table_name.'_lang');
		} else { // insert
			$this->db->set('id', $categal_id);
			$this->db->set('lang', 'ENG');
			$this->db->set('cate_gallery_caption', $str_caption_en);
			return $this->db->insert($this->table_name.'_lang');
		}
		
	}
	
	public function get_categallery_caption_lang($categal_id)
	{
		$this->db->select('cate_gallery_caption');
		$this->db->where(array('id'=>$categal_id, 'lang'=>'ENG'));
		$query = $this->db->get($this->table_name.'_lang');
		if($query->num_rows() > 0) return $query->row()->cate_gallery_caption;
		else return false;
	}
	
}