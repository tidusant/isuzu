<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mfilemanager extends Admin_Controller {

	private $_push;
	
	public function __construct() {
		parent::__construct();
		$this->load->model('admin_model_media');
		$this->load->helper(array('isuzu_image', 'isuzu_date', 'text', 'myhelp_helper'));
		$this->load->language('media');
	}
	
	public function index() {
		
		$which_page = $this->uri->segment(3);
		$content_render = '';
		
		switch($which_page) {
			case 'attachmedia':
				$content_render = $this->_attachmedia();// add or edit
				break;
			case 'attach_upload_media':
				$content_render = $this->attach_upload_media();
				break;
			case 'delete_upload_media':
				$content_render = $this->_unattach_upload_media();
				break;
			case 'categal':
				switch($this->uri->segment(4)) {
					case 'addimg':
						$cate_gal_id = $this->uri->segment(5);
						if($cate_gal_id!='') $content_render = $this->_pc_categal_addimg_form($cate_gal_id);
						break;
					case 'uploadimg':
						$content_render = $this->_pc_categal_upload_images();
						break;
					case 'deleteimg':
						$content_render = $this->_pc_categal_delete_images();
						break;
					case 'deletevideo':
						$content_render = $this->_pc_categal_delete_video();
						break;
					default:
						$cate_gal_id = $this->uri->segment(5);
						if($cate_gal_id!='') $content_render = $this->_pc_categal_list_img($cate_gal_id);
				}
				break;
			case 'productgal':
				switch($this->uri->segment(4)) {
					case 'addimg':
						$cate_gal_id = $this->uri->segment(5);
						if($cate_gal_id!='') $content_render = $this->_pc_productgal_addimg_form($cate_gal_id);
						break;
					case 'uploadimg':
						$content_render = $this->_pc_productgal_upload_images(); // ajax
						break;
					case 'deleteimg':
						$content_render = $this->_pc_productgal_delete_images();
						break;
					case 'deletevideo':
						$content_render = $this->_pc_productgal_delete_video();
						break;
					default:
						$cate_gal_id = $this->uri->segment(5);
						if($cate_gal_id!='') $content_render = $this->_pc_productgal_list_img($cate_gal_id);
				}
				break;
			default:
				$content_render = $this->_list_media(); // just list user
		}
		
		if($content_render!='') return $content_render;
		else show_404();
	}
	
	private function _list_media() {
		
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);
		
		$this->_push['mediastores_dir_news'] = $this->admin_model_media->get_list_mediastore_by_dir('news/');
		$this->_push['mediastores_dir_products'] = $this->admin_model_media->get_list_mediastore_by_dir('products/');
		$this->_push['mediastores_dir_categories'] = $this->admin_model_media->get_list_mediastore_by_dir('categories/');
		$this->_push['mediastores_dir_pages'] = $this->admin_model_media->get_list_mediastore_by_dir('pages/');
		$this->_push['mediastores_dir_partners'] = $this->admin_model_media->get_list_mediastore_by_dir('partners/');
		$this->_push['mediastores_dir_banners'] = $this->admin_model_media->get_list_mediastore_by_dir('banners/');
		$this->_push['mediastores_dir_accessories'] = $this->admin_model_media->get_list_mediastore_by_dir('accessories/');
		$this->_push['mediastores_dir_rearbody'] = $this->admin_model_media->get_list_mediastore_by_dir('rearbody/');
		$this->_push['mediastores_dir_parts'] = $this->admin_model_media->get_list_mediastore_by_dir('parts/');
		
		// load lightbox script
		$lightbox_script = load_lightbox_script();
		$this->_push['header_extended_css'] = $lightbox_script['css'];
		$this->_push['extended_js'] = $lightbox_script['js'].'
			<script type="text/javascript">
			$(document).ready(function () {
					$("ul.thumbnails li a.thumbnail").iLightBox();
			});
			</script>';
		unset($lightbox_script);
		return $this->load->view('admin/filemanager/index', $this->_push);
	}
	
	public function _render_upload_form() {
		return $this->load->view('admin/filemanager/upload_form', $this->_push);
	}
	
	public function _attachmedia() {
		
		$this->_push['extended_js'] = '
			<script type="text/javascript">
				$(document).ready(function() {
					
					$(function() {
						$("#image_type").click(enable_selectboximg); // image type checkbox
						$("#pdf_type").click(enable_selectboxpdf); // pdf type checkbox
					});
					
					function enable_selectboximg() {
						if (this.checked) {
							$("#dir_name_pdf").prop("disabled", "disabled");
							$("#dir_name_img").removeAttr("disabled", true);
						} else {
							$("#dir_name_img").prop("disabled", "disabled");
						}
					}
					
					function enable_selectboxpdf() {
						if (this.checked) {
							$("#dir_name_img").prop("disabled", "disabled");
							$("#dir_name_pdf").removeAttr("disabled", true);
						} else {
							$("#dir_name_pdf").prop("disabled", "disabled");
						}
					}
					
				});
			</script>
		';
		return $this->load->view('admin/filemanager/upload', $this->_push);
	}
	
	public function attach_upload_media() {
		$dir_name = trim(htmlspecialchars($this->input->post('directory_name')));
		// make upload main path & upload thumb path
		$path_to_upload = realpath($this->config->item('image_upload_path').$dir_name);
		
		$img_array = $this->_do_upload_media($path_to_upload, $dir_name);
		return $this->load->view('admin/filemanager/upload', $this->_push);
	}
	
	private function _unattach_upload_media() {
		$delete_success = $this->admin_model_media->delete_image(uri_assoc('file'));
		
		redirect($this->uri->segment(1).'/filemanager/index');
	}
	
	public function _render_upload_button() {
		return $this->load->view('admin/widgets/multi_ajax_upload_button', $this->_push);
	}
	
	/*################## PRODUCT CATE GALLERY PROCESSING #####################*/
	
	private function _pc_categal_list_img($cate_gal_id) {
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);
		
		$this->_push['cate_gallery_full_path'] = '';
		$this->_push['cate_gallery_images'] = false;
		$this->_push['cate_gallery_video'] = false;
		$this->_push['cate_gallery_caption'] = false;
		$this->_push['cate_gallery_caption_en'] = false;
		
		$this->load->model('products/admin_model_categallery');
		
		$cate_gallery_obj = $this->admin_model_categallery->get_categallery_info($cate_gal_id);
		
		$this->_push['cate_gallery_name'] = $cate_gallery_obj->cate_gallery_name;
		
		if($cate_gallery_obj!=false) {
			$this->_push['cate_gallery_full_path'] = $cate_gallery_obj->full_url_path;
			$this->_push['cate_gallery_images'] = $cate_gallery_obj->cate_gallery_images;
			$this->_push['cate_gallery_video'] = $cate_gallery_obj->cate_gallery_video;
			$this->_push['cate_gallery_caption'] = $cate_gallery_obj->cate_gallery_caption;
			$this->_push['cate_gallery_caption_en'] = $this->admin_model_categallery->get_categallery_caption_lang($cate_gal_id);
		}
		
		unset($cate_gallery_obj);
		
		if($this->input->post()) {
			
			$caption_name = $this->input->post('catalog_gallery_caption');
			$caption_name_en = $this->input->post('catalog_gallery_caption_en');
			
			// video
			$video_link = $this->input->post('gal_video');
			
			$caption_str = ''; $caption_str_en = '';
			$videolink_str = '';
			
			if($caption_name!=NULL) {
				foreach($caption_name as $index=>$cn) {
					$caption_str .= process_input($cn).'|';
					$caption_str_en .= process_input($caption_name_en[$index]).'|';
				}
			}
			
			if($video_link!=NULL) {
				foreach($video_link as $vl) {
					$videolink_str .= process_input($vl).'|';
				}
			}
			
			
			// remove last char
			$caption_str = substr($caption_str, 0, -1);
			$caption_str_en = substr($caption_str_en, 0, -1);
			$videolink_str = substr($videolink_str, 0, -1);
			
			$update_id = 0;
			if($caption_str!='') $update_id = $this->admin_model_categallery->update_categallery_caption($cate_gal_id, $caption_str);
				
			if($caption_str_en!='') $update_id = $this->admin_model_categallery->update_categallery_caption_lang($cate_gal_id, $caption_str_en);
			
			if($videolink_str!='') $update_id = $this->admin_model_categallery->update_categallery($cate_gal_id, '', $videolink_str);
			
			if($update_id > 0) $this->session->set_flashdata('success_save', true);
			else $this->session->set_flashdata('custom_error', 'Some errors occurs!');
			
			redirect($this->uri->segment(1).'/filemanager/categal/index/'.$this->uri->segment(5));
		}
		
		return $this->load->view('admin/filemanager/categal/list', $this->_push);
	}
	
	private function _pc_categal_addimg_form($cate_gal_id) {
		
		$this->_push['extended_js'] = $this->_js_addmorebutton();
		$this->load->model('products/admin_model_categallery');
		$this->_push['cate_gal_info'] = $this->admin_model_categallery->get_categallery_info($cate_gal_id);
		return $this->load->view('admin/filemanager/categal/upload', $this->_push);
	}
	
	private function _pc_categal_upload_images() {
		$this->load->model('products/admin_model_categallery');
		
		$cate_gal_id = trim(htmlspecialchars($this->input->post('cat_gal')));
		$path_to_upload = trim(htmlspecialchars($this->input->post('dir_to_upload')));
		$video_link = $this->input->post('video_link');
		
		$dir_cate_name = $this->admin_model_categallery->get_categallery_foldername($cate_gal_id);
		
		if($dir_cate_name!=false) {
			$dir_cate_name = explode("/", trim($dir_cate_name));
			$dir_cate_folder = $dir_cate_name[(count($dir_cate_name)-2)];
			$dir_cate_subfolder = $dir_cate_name[(count($dir_cate_name)-1)];
			$dir_cate_name = $dir_cate_folder.'/'.$dir_cate_subfolder.'/';
		}
		
		
		$img_str = $this->_do_upload_media($path_to_upload, $dir_cate_name); // just upload to original place
		
		$video_str = '';
		if($video_link!='' && is_array($video_link)) {
			foreach($video_link as $vl) {
				$video_str .= trim(htmlspecialchars($vl)).'|';
			}
			$video_str = substr($video_str, 0, -1);
		}
		
		// add more - update image list
		$old_img_str = $this->admin_model_categallery->get_img_categallery($cate_gal_id);
		
		if($old_img_str!=NULL) $img_str = $old_img_str.'|'.$img_str;
		
		/// update cate gallery
		$img_str = substr($img_str, 0,-1); // remove last letter
		$success_update = $this->admin_model_categallery->update_categallery($cate_gal_id, $img_str, $video_str);
		
		if($success_update > 0) redirect($this->input->server('HTTP_REFERER'));
		else show_404();
	}
	
	private function _pc_categal_delete_images() {
		
		$filename = uri_assoc('file');
		$filename = base64_decode($filename);
		if($filename) {
			$cate_gal_id = 0;
			$dest_file_name = '';
			
			if(strstr($filename, "-")) {
				$id_n_file = explode("-", $filename);
				if(count($id_n_file)==2) { // just 1
					$cate_gal_id = $id_n_file[0];
					$dest_file_name = $id_n_file[1];
				} elseif(count($id_n_file) > 2) { // more
					$cate_gal_id = $id_n_file[0];
					unset($id_n_file[0]);// remove id from filename
					$dest_file_name = implode("-", $id_n_file);
				}
				$this->load->model('products/admin_model_categallery');
				if($cate_gal_id > 0) {
					// get old cate gallery images
					$cate_img_gallery = $this->admin_model_categallery->get_img_categallery($cate_gal_id);
					$cate_caption_gallery = $this->admin_model_categallery->get_caption_categallery($cate_gal_id);
					$cate_caption_en_gallery = $this->admin_model_categallery->get_categallery_caption_lang($cate_gal_id);
					if($cate_img_gallery!='') {
						
						if(strstr($cate_img_gallery, "|")) {
							$old_cate_img_gallery = explode("|", $cate_img_gallery);
							$old_cate_caption_gallery = explode("|", $cate_caption_gallery);
							$old_cate_caption_en_gallery = explode("|", $cate_caption_en_gallery);
							foreach($old_cate_img_gallery as $index=>$img_name) {
								if(trim($img_name) == trim($dest_file_name)) {
									// remove specify image name
									unset($old_cate_img_gallery[$index]);
									unset($old_cate_caption_gallery[$index]);
									unset($old_cate_caption_en_gallery[$index]);
									break;
								}
							} // loop image list
							
							// update new list image
							$cate_img_gallery = implode("|", $old_cate_img_gallery);
							$cate_caption_gallery = implode("|", $old_cate_caption_gallery);
							$cate_caption_en_gallery = implode("|", $old_cate_caption_en_gallery);
							
						} else {
							$cate_img_gallery = "";
							$cate_caption_gallery = "";
							$cate_caption_en_gallery = "";
						}
						
						// and update
						$success_update = $this->admin_model_categallery->update_categallery($cate_gal_id, $cate_img_gallery, '');
						$success_update = $this->admin_model_categallery->update_categallery_caption($cate_gal_id, $cate_caption_gallery);
						$success_update = $this->admin_model_categallery->update_categallery_caption_lang($cate_gal_id, $cate_caption_en_gallery);
						if($success_update > 0) {
							$this->admin_model_media->delete_image($dest_file_name); // delete physical file
							redirect($this->input->server('HTTP_REFERER'));
						}
						else show_404();
					}
				}
				
				redirect($this->input->server('HTTP_REFERER'));
			} else exit();
			
		}
		
	}
	
	private function _pc_categal_delete_video()
	{
		$filename = uri_assoc('file');
		$filename = base64_decode($filename);
		if($filename) {
			$cate_gal_id = 0;
			$dest_file_name = '';
			
			if(strstr($filename, "-")) {
				
				$id_n_file = explode("-", $filename);
				if(count($id_n_file)==2) { // just 1
					$cate_gal_id = $id_n_file[0];
					$dest_file_name = $id_n_file[1];
				} elseif(count($id_n_file) > 2) { // more
					$cate_gal_id = $id_n_file[0];
					unset($id_n_file[0]);// remove id from filename
					$dest_file_name = implode("-", $id_n_file);
				}
				$this->load->model('products/admin_model_categallery');
				if($cate_gal_id > 0) {
					// get old cate gallery video
					$cate_video_gallery = $this->admin_model_categallery->get_video_categallery($cate_gal_id);
					
					if($cate_video_gallery!='') {	
						if(strstr($cate_video_gallery, "|")) {
							$old_cate_video_gallery = explode("|", $cate_video_gallery);
							foreach($old_cate_video_gallery as $index=>$video_link) {
								if(trim($video_link) == trim($dest_file_name)) {
									// remove specify image name
									unset($old_cate_video_gallery[$index]);
									break;
								}
							} // loop image list
							
							// update new list image
							$cate_video_gallery = implode("|", $old_cate_video_gallery);
						} else {
							$cate_video_gallery = 'NULL';
						}
						
						// and update
						$success_update = $this->admin_model_categallery->update_categallery($cate_gal_id, '', $cate_video_gallery);
						
						if($success_update > 0) redirect($this->input->server('HTTP_REFERER'));
						else show_404();
					}
				}
			}
			redirect($this->input->server('HTTP_REFERER'));
		} else exit();
	}
	
	/*################## PRODUCT GALLERY PROCESSING #####################*/
	
	private function _pc_productgal_list_img($product_gal_id) {
		
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);
		
		$this->_push['mediastores_dir'] = false;
		
		// define
		$this->_push['product_gallery_full_path'] = '';
		$this->_push['product_gallery_images'] = false;
		$this->_push['product_gallery_video'] = false;
		$this->_push['product_gallery_caption'] = false;
		$this->_push['product_gallery_caption_en'] = false;
		
		$this->load->model('products/admin_model_productgallery');
		
		$product_gallery_obj = $this->admin_model_productgallery->get_productgallery_info($product_gal_id);
		
		$this->_push['product_gallery_name'] = $product_gallery_obj->product_gallery_name;
		
		if($product_gallery_obj!=false) {
			$this->_push['product_gallery_full_path'] = $product_gallery_obj->full_path_image;
			$this->_push['product_gallery_images'] = $product_gallery_obj->product_gallery_images;
			$this->_push['product_gallery_video'] = $product_gallery_obj->product_gallery_video;
			$this->_push['product_gallery_caption'] = $product_gallery_obj->product_gallery_caption;
			$this->_push['product_gallery_caption_en'] = $this->admin_model_productgallery->get_productgallery_caption_lang($product_gal_id);
		}
		
		unset($product_gallery_obj);
		if($this->input->post()) {
			
			$caption_name = $this->input->post('product_gallery_caption');
			$caption_name_en = $this->input->post('product_gallery_caption_en');
			
			// video
			$video_link = $this->input->post('gal_video');
			
			$caption_str = ''; $caption_str_en = '';
			$videolink_str = '';
			
			if($caption_name!=NULL) {
				foreach($caption_name as $index=>$cn) {
					$caption_str .= process_input($cn).'|';
					$caption_str_en .= process_input($caption_name_en[$index]).'|';
				}
			}
			
			if($video_link!=NULL) {
				foreach($video_link as $index=>$vl) {
					$videolink_str .= process_input($vl).'|';
				}
			}
			
			// remove last char
			$caption_str = substr($caption_str, 0, -1);
			$caption_str_en = substr($caption_str_en, 0, -1);
			$videolink_str = substr($videolink_str, 0, -1);
			
			$update_id = 0;
			if($caption_str!='') $update_id = $this->admin_model_productgallery->update_productgallery_caption($product_gal_id, $caption_str);
				
			if($caption_str_en!='') $update_id = $this->admin_model_productgallery->update_productgallery_caption_lang($product_gal_id, $caption_str_en);
			
			if($videolink_str!='') $update_id = $this->admin_model_productgallery->update_productgallery($product_gal_id, '', $videolink_str);
			
			if($update_id > 0) $this->session->set_flashdata('success_save', true);
			else $this->session->set_flashdata('custom_error', 'Some errors occurs!');
			
			redirect($this->uri->segment(1).'/filemanager/productgal/index/'.$this->uri->segment(5));
		}
		
		return $this->load->view('admin/filemanager/productgal/list', $this->_push);
	}
	
	private function _pc_productgal_addimg_form($product_gal_id) {
		$this->_push['extended_js'] = $this->_js_addmorebutton();
		$this->load->model('products/admin_model_productgallery');
		$this->_push['product_gal_info'] = $this->admin_model_productgallery->get_productgallery_info($product_gal_id);
		return $this->load->view('admin/filemanager/productgal/upload', $this->_push);
	}
	
	private function _pc_productgal_upload_images() {
		$this->load->model('products/admin_model_productgallery');
		
		$product_gal_id = trim(htmlspecialchars($this->input->post('pro_gal')));
		$path_to_upload = trim(htmlspecialchars($this->input->post('dir_to_upload')));
		$video_link = $this->input->post('video_link');
		
		$dir_cate_name = $this->admin_model_productgallery->get_productgallery_foldername($product_gal_id);
		
		if($dir_cate_name!=false) {
			$dir_cate_name = explode("/", trim($dir_cate_name));
			$dir_cate_folder = $dir_cate_name[(count($dir_cate_name)-2)];
			$dir_cate_subfolder = $dir_cate_name[(count($dir_cate_name)-1)];
			$dir_cate_name = $dir_cate_folder.'/'.$dir_cate_subfolder.'/';
		}
		
		$img_str = $this->_do_upload_media($path_to_upload,$dir_cate_name); // just upload to original place
		
		$video_str = '';
		if($video_link!='' && is_array($video_link)) {
			foreach($video_link as $vl) {
				$video_str .= trim(htmlspecialchars($vl)).'|';
			}
			$video_str = substr($video_str, 0, -1);
		}
		
		
		// add more - update image list
		$old_img_str = $this->admin_model_productgallery->get_img_productgallery($product_gal_id);
		if($old_img_str!=NULL) $img_str = $old_img_str.'|'.$img_str;
		
		/// update cate gallery
		$img_str = substr($img_str, 0, -1);// remove last letter
		
		$this->admin_model_productgallery->update_productgallery($product_gal_id, $img_str, $video_str);
		redirect($this->input->server('HTTP_REFERER'));
	}
	
	private function _pc_productgal_delete_images() {
		
		$filename = uri_assoc('file');
		$filename = base64_decode($filename);
		
		if($filename) {
			$product_gal_id = 0;
			$dest_file_name = '';
			
			if(strstr($filename, "-")) {
				$id_n_file = explode("-", $filename);
				if(count($id_n_file)==2) { // just 1
					$product_gal_id = $id_n_file[0];
					$dest_file_name = $id_n_file[1];
				} elseif(count($id_n_file) > 2) { // more
					$product_gal_id = $id_n_file[0];
					unset($id_n_file[0]);// remove id from filename
					$dest_file_name = implode("-", $id_n_file);
				}
				$this->load->model('products/admin_model_productgallery');
				if($product_gal_id > 0) {
					// get old cate gallery images
					$product_img_gallery = $this->admin_model_productgallery->get_img_productgallery($product_gal_id);
					$product_caption_gallery = $this->admin_model_productgallery->get_caption_productgallery($product_gal_id);
					$product_caption_en_gallery = $this->admin_model_productgallery->get_productgallery_caption_lang($product_gal_id);
					
					if($product_img_gallery!='') {
						
						if(strstr($product_img_gallery, "|")) {
							$old_product_img_gallery = explode("|", $product_img_gallery);
							$old_product_caption_gallery = explode("|", $product_caption_gallery);
							$old_product_caption_en_gallery = explode("|", $product_caption_en_gallery);
							foreach($old_product_img_gallery as $index=>$img_name) {
								if(trim($img_name) == trim($dest_file_name)) {
									// remove specify image name
									unset($old_product_img_gallery[$index]);
									unset($old_product_caption_gallery[$index]);
									unset($old_product_caption_en_gallery[$index]);
									break;
								}
								
							} // loop image list
							
							// update new list image
							$product_img_gallery = implode("|", $old_product_img_gallery);
							$product_caption_gallery = implode("|", $old_product_caption_gallery);
							$product_caption_en_gallery = implode("|", $old_product_caption_en_gallery);
							unset($old_product_img_gallery);
							unset($old_product_caption_gallery);
							unset($old_product_caption_en_gallery);
						} else { // clear all
							$product_img_gallery = "";
							$product_caption_gallery = "";
							$product_caption_en_gallery = "";
						}
						
						// and update
						$success_update = $this->admin_model_productgallery->update_productgallery($product_gal_id, $product_img_gallery, '');
						// update caption
						$success_update = $this->admin_model_productgallery->update_productgallery_caption($product_gal_id, $product_caption_gallery);
						$success_update = $this->admin_model_productgallery->update_productgallery_caption_lang($product_gal_id, $product_caption_en_gallery);
						
						if($success_update > 0) {
							$this->admin_model_media->delete_image($dest_file_name); // delete physical file
							redirect($this->input->server('HTTP_REFERER'));
						}
						else show_404();
					}
				}
				
				redirect($this->input->server('HTTP_REFERER'));
			} else exit();
			
		}
		
	}
	
	private function _pc_productgal_delete_video()
	{
		$filename = uri_assoc('file');
		$filename = base64_decode($filename);
		
		if($filename) {
			$product_gal_id = 0;
			$dest_file_name = '';
			
			if(strstr($filename, "-")) {
				$id_n_file = explode("-", $filename);
				if(count($id_n_file)==2) { // just 1
					$product_gal_id = $id_n_file[0];
					$dest_file_name = $id_n_file[1];
				} elseif(count($id_n_file) > 2) { // more
					$product_gal_id = $id_n_file[0];
					unset($id_n_file[0]);// remove id from filename
					$dest_file_name = implode("-", $id_n_file);
				}
				$this->load->model('products/admin_model_productgallery');
				if($product_gal_id > 0) {
					// get old cate gallery images
					$product_video_gallery = $this->admin_model_productgallery->get_video_productgallery($product_gal_id);
					if($product_video_gallery!='') {
						
						if(strstr($product_video_gallery, "|")) {
							$old_product_video_gallery = explode("|", $product_video_gallery);
							foreach($old_product_video_gallery as $index=>$video_name) {
								if(trim($video_name) == trim($dest_file_name)) {
									// remove specify image name
									unset($old_product_video_gallery[$index]);
									break;
								}
								
							} // loop image list
							
							// update new list image
							$product_video_gallery = implode("|", $old_product_img_gallery);
							unset($old_product_video_gallery);
						} else { // clear all
							$product_video_gallery = 'NULL';
						}
						
						// and update
						$success_update = $this->admin_model_productgallery->update_productgallery($product_gal_id, '', $product_video_gallery);
						
						if($success_update > 0) {
							redirect($this->input->server('HTTP_REFERER'));
						}
						else show_404();
					}
				}
				
				redirect($this->input->server('HTTP_REFERER'));
			} else exit();
			
		}
	}
	
	/*################## do upload action ###########################*/
	// return json data
	private function _do_upload_media($path_to_upload, $dir_name) {
		
		$upload_data = $this->admin_model_media->action_do_upload($path_to_upload);
		$image_arr = '';
		// check file uploading
		if($upload_data!==FALSE && sizeof($upload_data) > 0) {
			foreach($upload_data as $upload)
			{
				// database inserting
				$type = 'PIC';
				if($upload['is_image'] <> 1) // not image
				{
					$type = 'other';
				}
				
				$media_id = $this->admin_model_media->insert_media($type, $this->config->item('image_upload_path'), $upload['file_name'], $upload['file_size'], $upload['file_ext'], $upload['raw_name'], $dir_name);
				
				// return image name
				$image_arr .= $upload['file_name'].'|';
				
			}
		}
		
		return $image_arr;
		
	}
	
	private function _js_addmorebutton()
	{
		$js = '
			<script type="text/javascript">
				$(document).ready(function(){
				var counter = 2;
			 
				$("#addButton").click(function () {
			 
					if(counter>10){
						alert("Only 10 links allow");
						return false;
					}   
				 
					var newtextboxp = $(document.createElement(\'p\')).attr("id", \'video-link-more\' + counter);
					
					newtextboxp.html(\'<input type="text" name="video_link[]" id="textbox\' + counter + \'" value="" class="input-xlarge" />\');
					newtextboxp.appendTo("#textboxarea");
					counter++;
				});
			 
				 $("#removeButton").click(function () {
					if(counter==1){
						alert("No more link to remove");
						return false;
					}   
			 
					counter--;
					
					$("#textbox" + counter).remove();
				});
				
			});
			</script>
		';
		
		return $js;
	}
}

/* End of file mfilemanager.php */
/* Location: ./application/controllers/mfilemanager.php */