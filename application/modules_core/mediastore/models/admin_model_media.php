<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_media extends MY_Model {
	
	var $media_path;
	var $media_path_url;
	
	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'media';
		$this->primary_key = 'media.id';
		$this->order_by = 'media.updated_on desc';
	}
	
	
	public function get($params = NULL) {

		$ms = parent::get($params);

		return $ms;

	}
	
	public function action_do_upload($full_path_dest) {
		
		$config = array(
			'allowed_types' => $this->config->item('allowed_types'),
			'upload_path' => $full_path_dest,
			'max_size' => $this->config->item('maxium_size')
		);
		
		$this->load->library('upload', $config);
		         
		$image_data = $this->upload->do_multi_upload();
		
		if ( ! $image_data ) { log($this->upload->display_errors()); return false; }
		
		return $image_data;
		
	}
	
	public function resizing_image($full_path_dest, $image_name)
	{
		$image_thumb_size = $this->config->item('admin_thumbnail_media_list');
		$config = array(
			'image_library' => 'gd2',
			'source_image' => $image_name,
			'new_image' => $full_path_dest,
			'maintain_ration' => true,
			'width' => $image_thumb_size['width'],
			'height' => $image_thumb_size['height']
		);
		
		$this->load->library('image_lib', $config);
		
		if ( ! $this->image_lib->resize())
		{
			show_error($this->image_lib->display_errors());
		}
		
		$this->image_lib->clear();
		
	}
	
	/** 
	 * Inserts / Update a media into the media table.
	 * Updates the media if the media complete path already exists
	 * 
	 * @param	string	Medium type. Can be 'picture', 'music', 'video', 'file'
	 * @param	string	Complete path to the medium, including file name.
	 * @return	boolean	TRUE if succeed, FALSE if errors
	 *
	 */
	function insert_media($type, $path, $file_name, $file_size, $file_ext, $name, $dir_name)
	{
		if ($path) {
			
			$data['media_type'] =  $type;
			$data['media_name'] =  $name;
			$data['media_path'] =  $path;
			$data['main_url'] = $this->config->item('admin_mediastore_real_url');
			$data['thumb_url'] = $this->config->item('admin_mediastore_url');
			$data['media_filename'] = $file_name;
			$data['media_size'] = $file_size;
			$data['media_type_ext'] = $file_ext;
			$data['media_directory'] = $dir_name;
			$data['active'] = '1';
			
			// Update if exists
			$query = $this->get_where(array('media_filename'=>$file_name));
			if( $query->num_rows() > 0)
			{
				$data['updated_on'] = time();
				$medium = $query->row_array();
				$this->db->where('media_filename', $file_name);
				$this->db->update($this->table_name, $data);
				$id = $medium['id'];
			}
			// Insert
			else
			{
				$data['created_on'] = time();
				$data['display_order'] = 9;
				$this->db->insert($this->table_name, $data);
				$id = $this->db->insert_id();
			}
			return $id;
		}
		return FALSE;
	}


	// ------------------------------------------------------------------------
	
	public function delete_image($media_filename) {
		
		if($media_filename!='') {
			// delete image
			// load media id
			$media_info = $this->get_file_info_by_name($media_filename);
			$file_relative_path = str_replace(base_url(), $_SERVER['DOCUMENT_ROOT']."/", $media_info->main_url.$media_info->media_directory.$media_filename);
			if(is_file($file_relative_path)){
				@unlink($file_relative_path);
				// get thumbnail file show in admin
				$thumb_file_relative_path = return_thumb_file_path($file_relative_path, '160', '120');
				if(file_exists($thumb_file_relative_path))
					@unlink($thumb_file_relative_path);
			}
				
			parent::delete(array('id'=>$media_info->id));
			unset($media_info);
			return true;
		} else return false;
		
    }
	
	private function get_file_name_by_id($media_id)
	{
		$this->db->select('media_filename');
		$this->db->from($this->table_name);
		$this->db->where(array('id' => $media_id, 'active' => '1'));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row()->media_filename;
		else return '';
	}
	
	private function get_file_info_by_name($media_filename)
	{
		$this->db->select('id, media_type, media_filename, main_url, thumb_url, media_directory');
		$this->db->from($this->table_name);
		$this->db->where(array('media_filename' => $media_filename, 'active' => '1'));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row();
		else return '';
	}
	
	// old stuff
	public function get_list_mediastore()
	{
		$this->db->select('id, media_name, media_filename, thumb_url');
		$this->db->from($this->table_name);
		$this->db->where('active', '1');
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		return false;
	}
	
	public function get_list_mediastore_by_dir($dir_name)
	{
		$query = $this->db->where(array('active'=>'1', 'media_directory'=>$dir_name));
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0) return $query;
		return false;
	}

	public function delete($media_id) {

		/* Delete the author record */
		parent::delete(array('id'=>$media_id));
		// unlink file image
	}
	
	// get media by name
	public function find_image_id_by_name($unique_image_name)
	{
		$this->db->select('media.id');
		$this->db->from('media');
		$this->db->where(array('media.active'=>'1', 'media.media_filename'=>$unique_image_name));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row()->id;
		return false;
	}
	
	// get gallery image
	public function scan_images_folder($dir) {
		
		$this->load->helper('directory');
		$map_files = directory_map('./'.$dir.'/');
		
		$preg_pattern = "/.(".$this->config->item('allowed_types').")/i"; //match the following files, can be changed to limit or extend range, ie: png,jpeg,etc.

		$images = array();

		foreach($map_files as $matched_image) { //loop through directory files
			if(substr($matched_image, 0, 1) != '.') { //ignore anything starting with a period
				if(preg_match($preg_pattern, $matched_image))
					$images[]= $matched_image;
			}
		}
				
		return $images;
	}
	
	
}