<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	/**
	* Thumb()
	* A TimThumb-style function to generate image thumbnails on the fly.
	*
	* @author Darren Craig
	* @param string $image_path
	* @param int $width
	* @param int $height
	* @return String
	*
	*/
	
	function filter_file_name($file_upload_obj)
	{
		
		$name = $file_upload_obj['name'];
		
		$piece_array = array(
			"À" => "A",
			"Â" => "A",
			"Ã" => "A",
			"Ä" => "A",
			"Å" => "A",
			"Ç" => "C",
			"È" => "E",
			"É" => "E",
			"Ê" => "E",
			"Ë" => "E",
			"Ì" => "I",
			"Í" => "I",
			"Î" => "I",
			"Ï" => "I",
			"Ò" => "O",
			"Ó" => "O",
			"Ô" => "O",
			"Õ" => "O",
			"Ö" => "O",
			"Ù" => "U",
			"Ú" => "U",
			"Û" => "U",
			"Ü" => "U",
			"Ý" => "Y",
			"à" => "a",
			"á" => "a",
			"â" => "a",
			"ã" => "a",
			"ä" => "a",
			"å" => "a",
			"ç" => "c",
			"è" => "e",
			"é" => "e",
			"ê" => "e",
			"ë" => "e",
			"ì" => "i",
			"í" => "i",
			"î" => "i",
			"ï" => "i",
			"ð" => "o",
			"ò" => "o",
			"ó" => "o",
			"ô" => "o",
			"õ" => "o",
			"ö" => "o",
			"ù" => "u",
			"ú" => "u",
			"û" => "u",
			"ü" => "u",
			"ý" => "y",
			"ÿ" => "y"
		);
		$name = strtr($name, $piece_array);
		$name = preg_replace('/([^.a-z0-9]+)/i', '_', $name);
		return $name;
	}
	
	/**
 * Thumb()
 * A TimThumb-style function to generate image thumbnails on the fly.
 * 
 * @author Darren Craig
 * @param string $image_path
 * @param int $width
 * @param int $height
 * @return String
 * 
 */

function return_thumb_file_path($original_file_path, $width, $height)
{
	// get file extension
	$file = explode(".", $original_file_path);
	$ext = array_pop($file);
	$file_name = array_shift($file);
	$file_name = str_replace(dirname($original_file_path) . "/", "", $file_name);

	// Path to image thumbnail
	return str_replace("media", "thumbnail", dirname($original_file_path)) . '/' . $file_name . "_" . $height . '_' . $width . "." . $ext;
}

function image_thumb($image_path, $width, $height, $gallery_type='') {
	
	if(!strstr($image_path, 'uploads/assets/media')) return $image_path;
	else {
	
	// Get the CodeIgniter super object
	$CI = &get_instance();
	
	// Path to image thumbnail
	$image_thumb = return_thumb_file_path($image_path, $width, $height);
	
	if (!file_exists($image_thumb) && file_exists($image_path)) {
		
		// LOAD LIBRARY
		$CI->load->library('image_lib');
		
		$original_width = 0;
		$original_height = 0;
		list($original_width, $original_height) = getimagesize($image_path);
		
		$width = intval($width);
		$height = intval($height);
		
		// CONFIGURE IMAGE LIBRARY
		$config['image_library'] = 'gd2';
		$config['quality'] = '100%';
		$config['source_image'] = $image_path;
		$config['new_image'] = $image_thumb;
		$config['maintain_ratio'] = false;
		$config['master_dim'] = "width";
		
		if ($height > $width) {
			$config['master_dim'] = "height";
		}
		
		$config['width'] = $width;
		$config['height'] = $height;
		
		if($gallery_type!='' && $gallery_type=='gallery-type') {
			// gallery type images
			if($original_width > $width || $original_height > $height) {
				
				$img_ratio = $original_width / $original_height;

				if($img_ratio < 1) { // portrait
					//$config['width'] *= $img_ratio; 
					
					$scale_ratio = $original_height/$height;
					$config['width'] = round($original_width/$scale_ratio);

					if($config['width'] > $width)
					{
					  $scale_ratio = $config['width'] / $width;
					  $config['width'] = $width;
					  $config['height'] = round($config['height'] / $scale_ratio);
					}
 
				}
				else { // landscape
					//$config['height'] /= $img_ratio; 
					
					//scale theo width sao cho o_width = max_width
					$scale_ratio = $original_width/$width;
					$config['height'] = round($original_height/$scale_ratio);

					if($config['height'] > $height) {
					  $scale_ratio = $config['height'] / $height;
					  $config['height'] = $height;
					  $config['width'] = round($config['width'] / $scale_ratio);
					}
 
				}
			}
		}
		
		$CI->image_lib->initialize($config);
		$CI->image_lib->resize();
		$CI->image_lib->clear();
		
	}
		
		if(!file_exists($image_path) && file_exists($image_thumb))
		{
			@unlink($image_thumb);
			return base_url().'assets/images/image_not_found.png';
		}
		
		return str_replace($_SERVER['DOCUMENT_ROOT']."/demo/", base_url(), $image_thumb);
	}

}

?>