<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Imagefc {

	public $CI;

	function Imagefc() {

		$this->CI =& get_instance();

	}

	/**
	 * Upload a file. If it's an image, a thumbnail will be created.
	 * 
	 * FORMAT - The $args parameter must be in the following format:
	 * 		1. As an array: 	array('key'=>'val', 'key2'=>'val2')
	 * 		
	 * OPTIONS - The following options are available for $args:
	 *
	 * allowed_types (string)(optional)
	 *   Specify what file types are allowed
	 *   Default: jpg
	 * large_size (array)(optional)
	 *   Specify the width and height of the large image. 
	 *   Default: array('w'=>500, 'h'=>500)
	 * thumb_size (array)(optional)
	 *   Specify the width and height of the thumbnail image. 
	 *   Default: array('w'=>200, 'h'=>200)
	 * 
	 * @param mixed $args
	 * @return array
	 */
	 
	function _uploadFile( $args ){
		$message = '';
		$upload_data_arr = FALSE;
		$upload_path = $args['upload_path'];
		
		if($upload_path == NULL){
			$this->_setMessage('Upload failed. Missing file upload path.', 'error');
			return FALSE;
		}
		
		$count = 0;
		$this->CI->load->library('image_lib');
		$this->CI->load->library('upload');	
		
		//set default image sizes
		if($args['large_size'] == NULL)
			$args['large_size'] = array('w'=>237, 'h'=>320);
		if($args['thumb_size'] == NULL)
			$args['thumb_size'] = array('w'=>110, 'h'=>148);
		if($args['ad_size'] == NULL)
			$args['ad_size'] = array('w'=>67, 'h'=>80);
			
		//set default for allowed_types
		if($args['allowed_types'] == NULL)
			$args['allowed_types'] = 'jpg,png,gif,jpeg';
			
		//config options for upload class
		$config = array('upload_path' => $upload_path, 'allowed_types' => $args['allowed_types']);
		
		//loop through each FILE input
		foreach($_FILES as $field=>$data){
			//fixes a bug with the file names
			$this->CI->upload->initialize($config);
			
			if($data['name'] == null || $data['error'])
				break;
			
			if(!$this->CI->upload->do_upload($field)){
				$message .= $this->CI->upload->display_errors('','');
				
				break;
			}
			
			$upload_data = $this->CI->upload->data();
			
			//filename to lower case
			rename($upload_path . $upload_data['file_name'], $upload_path . strtolower($upload_data['file_name']));
			
			if($upload_data['is_image']){
				$this->_createThumb($upload_path, $upload_data['file_name'], $args['thumb_size']['w'], $args['thumb_size']['h']);
				if(isset($args['medium_size']) && $args['medium_size'] !== NULL) {
					$args['medium_size'] = array('w'=>190, 'h'=>256);
					$this->_createThumb($upload_path, $upload_data['file_name'], $args['medium_size']['w'], $args['medium_size']['h']);
				}
				$this->_createThumb($upload_path, $upload_data['file_name'], $args['large_size']['w'], $args['large_size']['h'], '_large');
				$this->_createThumb($upload_path, $upload_data['file_name'], $args['ad_size']['w'], $args['ad_size']['h'], '_ad');
			}
			
			//save upload data for return
			$upload_data_arr[] = $upload_data;
			
			$count++;
		}
		
		if($count > 0 && $message == NULL) {
			$this->_setMessage("$count file(s) uploaded successfully.", 'success');
		} 
		elseif($message != NULL){
			$this->_setMessage($message, 'error');
		}
		return $upload_data_arr;
	}
	
	/**
	 * Delete a file.
	 *
	 * @param string $upload_path
	 * @param string $filename
	 * @param string $fileext
	 */
	function _deleteFile($upload_path=NULL, $filename, $fileext='.jpg'){
		//add the 'dot' if it's not there
		if(substr($fileext,0,1) != '.')
			$fileext = '.' . $fileext;
		
		//check for upload path
		if($upload_path == NULL)
			$upload_path = $this->CI->config->item('image_upload_path');
			
		//delete file
		if(file_exists($upload_path . $filename . $fileext)){
			unlink($upload_path . $filename . $fileext);
			
			$this->_setMessage("$filename$fileext has been deleted.", 'success');
			
			//delete large image size
			if(file_exists($upload_path . $filename . '_large' . $fileext))
				unlink($upload_path . $filename . '_large' . $fileext);
			//delete small image size
			if(file_exists($upload_path . $filename . '_small' . $fileext))
				unlink($upload_path . $filename . '_small' . $fileext);
			//delete admin image size
			if(file_exists($upload_path . $filename . '_ad' . $fileext))
				unlink($upload_path . $filename . '_ad' . $fileext);
		} else {
			$this->_setMessage("$filename$fileext does not exist.");
		}
	}
	
	/**
	 * Create a thumbnail
	 *
	 * @param string $upload_path
	 * @param string $file_name
	 * @param int $width
	 * @param int $height
	 * @param string $thumb_marker
	 */
	function _createThumb($upload_path, $file_name, $width=200, $height=200, $thumb_marker='_small'){
		$config['image_library'] = 'gd2';
		$config['source_image'] = $upload_path . strtolower($file_name);
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = $width;
		$config['height'] = $height;
		$config['thumb_marker'] = $thumb_marker;
		
		$this->CI->image_lib->initialize($config); 
		$this->CI->image_lib->resize();
		$this->CI->image_lib->clear();
	}
	
	function _setMessage($message, $class='warning'){
		log_message($class, $message);
	}

}

?>