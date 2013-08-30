<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_productgallery extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'product_gallery';

		$this->primary_key = 'product_gallery.id';
		$this->order_by = 'product_gallery.created_on';
	}
	
	
	public function get_list_gallery()
	{
		$this->db->select('id, product_gallery_name');
		$this->db->from($this->table_name);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		return false;
	}
	
	/*############################## product gallery type :1 - slide banner, 2 - noi that, 3- ngoai that, 4- an toan, 5 - bang mau ##############################*/
	public function get_list_gallery_type($type_id)
	{
		$this->db->select('id, product_gallery_name');
		$this->db->from($this->table_name);
		$this->db->where('product_gallery_type', $type_id);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		return false;
	}
	
	public function get_productgallery_name($pgallery_id) {

		$this->db->select('product_gallery_name');
		$this->db->where('id', $pgallery_id);

		return $this->db->get($this->table_name)->row()->product_gallery_name;
	}
	
	public function get_productgallery_info($pgallery_id)
	{
		$this->db->where('id', $pgallery_id);
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
	public function get_productgallery_foldername($pgallery_id)
	{
		$this->db->select('full_path_image');
		$this->db->where('id', $pgallery_id);
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0) return $query->row()->full_path_image;
		else return false;
	}
	
	/// product gallery type
	public function get_list_product_gallery_type()
	{
		$query = $this->db->get('product_gallery_type');
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	public function get_product_gallery_type($type_id)
	{
		$this->db->select('type_name');
		$this->db->where('id', $type_id);
		return $this->db->get('product_gallery_type')->row()->type_name;
	}
	
	// add - edit action
	public function validate() {
		$this->form_validation->set_rules('product_gallery_name', 'Title', 'required|trim|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('product_gallery_type', 'Gallery Type', 'trim|required|xss_clean');
		
		return parent::validate($this);

	}

	public function delete($pgal_id) {
		
		parent::delete(array('id'=>$pgal_id));
		
	}

	public function save($db_array = NULL) {

		if (!$db_array) {

			$db_array = parent::db_array();

		}
		
		// date
		$db_array['created_on'] = time();
		
		/* create folder just happen when adding new gallery */
		if(!uri_assoc('pgal_id')) {
			// add action
			$this->load->helper('isuzu_dir');
			$folder_name = process_string_foldername($db_array['product_gallery_name']).'_'.$db_array['created_on'];
			$path_to_product = $this->config->item('image_upload_path');
			create_sub_folder($path_to_product, $folder_name, 'products/');// folder created
			$db_array['created_folder'] = realpath($path_to_product.'products/'.$folder_name); // and not change anymore
			
			/// full url path
			$db_array['full_path_image'] = $this->config->item('admin_mediastore_real_url').'products/'.$folder_name;
		}
		
		parent::save($db_array, uri_assoc('pgal_id'));
	}
	
	// update gallery images
	public function get_img_productgallery($productgal_id) {
		$this->db->select('product_gallery_images');
		$this->db->where('id', $productgal_id);
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0) return $query->row()->product_gallery_images;
		else return false;
	}
	
	public function get_video_productgallery($productgal_id)
	{
		$this->db->select('product_gallery_video');
		$this->db->where('id', $productgal_id);
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0) return $query->row()->product_gallery_video;
		else return false;
	}
	
	public function get_caption_productgallery($productgal_id) {
		$this->db->select('product_gallery_caption');
		$this->db->where('id', $productgal_id);
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0) return $query->row()->product_gallery_caption;
		else return false;
	}
	
	public function update_productgallery($pgal_id, $str_images, $str_video='')
	{
		if($str_images!='') $this->db->set('product_gallery_images', $str_images);
		if($str_video!='') $this->db->set('product_gallery_video', $str_video);
		$this->db->where('id', $pgal_id);
		return $this->db->update($this->table_name);
	}
	
	/// update gallery caption
	public function update_productgallery_caption($productgal_id, $str_caption)
	{
		$this->db->set('product_gallery_caption', $str_caption);
		$this->db->where('id', $productgal_id);
		return $this->db->update($this->table_name);
	}
	
	public function update_productgallery_caption_lang($productgal_id, $str_caption_en)
	{
		if($this->check_lang_exist($this->table_name, 'id', $productgal_id)) { // update
			$this->db->set('product_gallery_caption', $str_caption_en);
			$this->db->where(array('id'=>$productgal_id, 'lang'=>'ENG'));
			return $this->db->update($this->table_name.'_lang');
		} else { // insert
			$this->db->set('id', $productgal_id);
			$this->db->set('lang', 'ENG');
			$this->db->set('product_gallery_caption', $str_caption_en);
			return $this->db->insert($this->table_name.'_lang');
		}
	}
	
	public function get_productgallery_caption_lang($productgal_id)
	{
		$this->db->select('product_gallery_caption');
		$this->db->where(array('id'=>$productgal_id, 'lang'=>'ENG'));
		$query = $this->db->get($this->table_name.'_lang');
		if($query->num_rows() > 0) return $query->row()->product_gallery_caption;
		else return false;
	}
}