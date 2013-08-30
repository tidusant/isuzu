<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends MY_Controller {
	
	var $_render_data;
	var $_cur_lang;
	
	var $_product_title_page;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_product','model_category','banners/model_banner','settings/isuzu_setting_data'));
		$this->load->library('pagination');
		$this->load->helper('text');
		$this->load->helper('myhelp_helper');
	}
	
	public function index($lang='') {
		
		$this->_cur_lang = $lang;
		$content_render = '';
		switch($this->uri->segment(2)){
			case 'loai':
				$content_render['main_content'] =  $this->_cate($lang);
				$content_render['page_title'] = $this->_get_title_product_page();
				
				if($this->uri->segment(3))
					$content_render['main_slide_banner'] = $this->_render_catagory_slide_banner( $this->uri->segment(3)); // catalog banner
				
				if($this->uri->segment(4) && $this->uri->segment(4)=='thu-vien') {
					$content_render['main_content'] = $this->_render_cate_gallery($this->uri->segment(3), $lang);
					

					$content_render['page_title'] = $this->_get_title_product_page();
				}
				break;
			case 'chi-tiet':
				$content_render['main_content'] = $this->_detail($lang);
				$content_render['page_title'] = $this->_get_title_product_page();
				if($this->uri->segment(3))
					$content_render['main_slide_banner'] = $this->_render_product_slide_banner($this->uri->segment(3)); // product banner
				break;
			case 'phu-kien':
				$accessory_render = modules::run('products/accessories/index', $lang);
				$content_render['main_content'] = $accessory_render['main_content'];
				if(isset($accessory_render['page_title'])) $content_render['page_title'] = $accessory_render['page_title'];
				unset($accessory_render);
				break;
			case 'thung-xe':
				$rearbody_render = modules::run('products/rearbody/index', $lang);
				$content_render['main_content'] = $rearbody_render['main_content'];
				if(isset($rearbody_render['page_title'])) $content_render['page_title'] = $rearbody_render['page_title'];
				unset($rearbody_render);
				break;
			default:
				$content_render['main_content'] = $this->_p_list($lang); // list
		}
		
		if($content_render!='') return $content_render;
		else show_404();
	}
	
	private function _p_list($lang='')
	{
		$category_limit = 4;
		$this->_render_data['category_list'] = $this->model_category->get_priority_category_list($category_limit, $lang);
		
		return $this->load->view('main/index', $this->_render_data);
	}
	
	private function _cate($lang='') {
		
		$category_id = 0; $product_limit = 20;
		$category_slug = $this->uri->segment(3);
		
		if($category_slug!='')  $category_id = intval($this->model_category->get_category_id($category_slug));
		
		$this->_render_data['cur_lang'] = $this->_cur_lang;
		
		$this->_render_data['catalog_name'] = $this->model_category->get_category_name($category_id, $lang);
		
		$this->_render_data['product_list'] = $this->model_product->get_product_list_by_cate($category_id, $product_limit, $lang);
		
		// loading effect sticky
		$this->_render_data['news_sticky_js'] = $this->_load_script_sticky();
		
		// set title page
		$this->_set_title_product_page($this->_render_data['catalog_name'].' &raquo; ');
		
		return $this->load->view('main/category', $this->_render_data);
	}
	
	private function _detail($lang='') {
		
		$this->_render_data['lang'] = $lang;
		$product_id = 0;
		$product_slug = $this->uri->segment(3);
		$product_id = $this->model_product->get_product_id($product_slug);
		
		if($product_id == 0) show_404();
		
		$product_info_detail = $this->model_product->get_product_detail($product_id, $lang);
		
		$this->_render_data['product_name'] = $product_info_detail->product_name;
		
		$this->_render_data['product_detail'] = $product_info_detail;
		
		$this->_render_data['category_slug'] = $this->model_category->get_category_slug($product_info_detail->product_cate_pc_id);
		
		$this->_render_data['category_name'] = $this->model_category->get_category_name($product_info_detail->product_cate_pc_id, $lang);
		
		// other products
		$this->_render_data['list_other_products'] = $this->model_product->get_other_product_by_cate($product_info_detail->product_cate_pc_id, $product_id, $lang);
		
		// tech info
		$this->_render_data['list_pattern_group'] = $this->model_product->get_pattern_group($lang);
		
		$this->_render_data['product_cate_id'] = $product_info_detail->product_cate_pc_id;
		$this->_render_data['product_id'] = $product_id;
		
		$check_product_pattern_by_catalog = $this->model_product->check_product_tech_pattern($product_info_detail->product_cate_pc_id, $product_id);
		
		$this->_render_data['thongsokithuat_tab'] = ($check_product_pattern_by_catalog!=false)? '1':'0';
		
		$product_info_gallery = $this->model_product->get_product_info_gallery($product_slug);
		$product_gallery = $product_info_gallery->product_gallery_type;
		
		//####################### check gallery type
		
		$this->_render_data['product_interior_tab'] = 0;
		$this->_render_data['product_exterior_tab'] = 0;
		$this->_render_data['product_safety_tab'] = 0;
		$this->_render_data['product_pallete_tab'] = 0;
		if(strstr($product_gallery, '|')) {
			$product_gallery = explode('|', $product_gallery);
			foreach($product_gallery as $pgal) {
				$product_gallery_type = explode(':', $pgal);
				if($product_gallery_type[0]=='2') { // interior type :2
					$this->_render_data['product_interior_tab'] = $product_gallery_type[1]; // get interior id
				}
				
				if($product_gallery_type[0]=='3') { // exterior type :3
					$this->_render_data['product_exterior_tab'] = $product_gallery_type[1]; // get exterior id
				}
				
				if($product_gallery_type[0]=='4') { // safety type :4
					$this->_render_data['product_safety_tab'] = $product_gallery_type[1]; // get safety id
				}
				
				if($product_gallery_type[0]=='5') { // pallete type :5
					$this->_render_data['product_pallete_tab'] = $product_gallery_type[1]; // get pallete id
				}
				
			}
			
		} else { // leaf
			$product_gallery = explode(':', $product_gallery);
			if($product_gallery[0] == '2') { // interior type
				$this->_render_data['product_interior_tab'] = $product_gallery[1]; // get id
			}
			
			if($product_gallery[0] == '3') { // exterior type
				$this->_render_data['product_exterior_tab'] = $product_gallery[1]; // get id
			}
			
			if($product_gallery[0] == '4') { // safety type
				$this->_render_data['product_safety_tab'] = $product_gallery[1]; // get id
			}
			
			if($product_gallery[0] == '5') { // pallete type
				$this->_render_data['product_pallete_tab'] = $product_gallery[1]; // get id
			}
		}
		
		/*################### get product gallery type */
		$this->_render_data['load_lightbox_code'] = ''; // intializing
		
		$interior_data = $this->_render_product_interior($product_slug, $lang); // interior
		$this->_render_data['product_interior_content_render'] = $interior_data['main_content'];
		$this->_render_data['load_lightbox_code'] = $interior_data['lightbox_code'];
		unset($interior_data);
		
		$exterior_data = $this->_render_product_exterior($product_slug, $lang); // exterior
		$this->_render_data['product_exterior_content_render'] = $exterior_data['main_content'];
		$this->_render_data['load_lightbox_code'] .= $exterior_data['lightbox_code'];
		unset($exterior_data);
		
		$safety_data = $this->_render_product_safety($product_slug, $lang); // safety
		$this->_render_data['product_safety_content_render'] = $safety_data['main_content'];
		$this->_render_data['load_lightbox_code'] .= $safety_data['lightbox_code'];
		unset($safety_data);
		
		$pallete_data = $this->_render_product_pallete($product_slug, $lang); // pallete
		$this->_render_data['product_pallete_content_render'] = $pallete_data['main_content'];
		$this->_render_data['load_lightbox_code'] .= $pallete_data['lightbox_code'];
		unset($pallete_data);
		
		//################### category gallery
		$pc_gallery_id = $this->model_category->get_category_gallery_id($product_info_detail->product_cate_pc_id);
		
		$this->_render_data['cate_gallery'] = $this->model_category->check_category_gallery($pc_gallery_id);
		
		// load lightbox script
		$this->_render_data['lightbox_script'] = load_lightbox_script();
		$this->_render_data['script_addon_extended'] = true;
		
		// set title page
		$this->_set_title_product_page($product_info_detail->product_name.' &raquo; '.$this->_render_data['category_name'].' &raquo; ');
		
		unset($product_info_detail);
		unset($product_info_gallery);
		$product_gallery = '';
		
		return $this->load->view('main/detail', $this->_render_data);
	}
	
	public function _render_sidebar($lang='') {
		$this->_render_data['catalog_product'] = $this->model_category->get_category_menu($lang);
		return $this->load->view('widgets/sidebar', $this->_render_data);
	}
	
	public function _render_other_page_sidebar($lang='') {	
		$this->_render_data['catalog_product'] = $this->model_category->get_category_menu($lang);
		return $this->load->view('widgets/sidebar2', $this->_render_data);
	}
	
	public function _render_right_banner() {
		$right_banner_limit = $this->isuzu_setting_data->get('banner_sidebar_show');
		$this->_render_data['banner_sidebar'] = $this->model_banner->get_banner(2, $right_banner_limit);
		return $this->load->view('widgets/right_banner', $this->_render_data);
	}
	
	/*####################### gallery ############################*/
	private function _render_cate_gallery($category_slug, $lang='') {
		
		$category_info = $this->model_category->get_category_info(trim(htmlspecialchars($category_slug)), $lang);

		$this->_render_data['catalog_info'] = $category_info;
		// get gallery
		$category_gallery_data = false;
		$category_full_path_img = '';
		$this->_render_data['catalog_gallery_content'] = '';
		$cate_gallery = $this->model_category->get_category_gallery($category_info->pc_gallery_id, $lang);
		if($cate_gallery) {
			
			$category_gallery_data['img'] = explode('|', $cate_gallery->cate_gallery_images); // image
			$category_gallery_data['video'] = explode('|', $cate_gallery->cate_gallery_video); // video
			$category_full_path_img = $cate_gallery->full_url_path;
			$content_html_return = $this->_render_html_for_gallery($category_gallery_data, $category_full_path_img, 'catalog_gallery', $cate_gallery->cate_gallery_caption);
			
			// load lightbox script
			$this->_render_data['lightbox_script'] = load_lightbox_script();
			$this->_render_data['load_lightbox_code'] = $content_html_return['lightbox_code'];
			$this->_render_data['catalog_gallery_content'] = $content_html_return['main_content'];
			
			unset($category_gallery_data);
			unset($content_html_return);
		}
		
		$this->_render_data['download_catalogue_link'] = strip_tags($category_info->pc_source_doc);
		
		$this->_set_title_product_page($this->lang->line('seo_catalog_gallery_page_title').' &raquo; '.$category_info->pc_name.' &raquo; ');
		
		unset($cate_gallery);
		unset($category_info);
		
		return $this->load->view('main/cate_gallery', $this->_render_data);
	}
	
	/*################ slide banner ##########################*/
	public function _render_catagory_slide_banner($category_slug) {
		
		if(!$category_slug) show_404();
		$category_info = $this->model_category->get_category_info(trim(htmlspecialchars($category_slug)));
		// get slide banner
		$this->_render_data['category_slide_banner'] = false;
		$cate_gallery = $this->model_category->get_category_slide_banner($category_info->pc_slide_id);
		$this->_render_data['category_full_path'] = $cate_gallery->full_url_path;
		if($cate_gallery) {
			$this->_render_data['category_slide_banner'] = explode("|", $cate_gallery->cate_gallery_images); // retrieve it
		}
		$this->_render_data['category_info'] = $category_info;
		unset($category_info);
		unset($cate_gallery);
		return $this->load->view('widgets/category_slide_banner', $this->_render_data);
	}
	
	// product
	public function _render_product_slide_banner($product_slug) {
		
		if(!$product_slug) show_404();
		
		$product_info = $this->model_product->get_product_info_gallery($product_slug);
		$product_gallery = $product_info->product_gallery_type;
		$product_slide_id = 0;
		
		if(strstr($product_gallery, '|')) {
			$product_gallery = explode('|', $product_gallery);
			foreach($product_gallery as $pgal) {
				$product_gallery_type = explode(':', $pgal);
				if($product_gallery_type[0]=='1') { // slide type :1
					$product_slide_id = $product_gallery_type[1]; // get slide id
				}
			}
			
		} else { // leaf
			$product_gallery = explode(':', $product_gallery);
			if($product_gallery[0] == '1') { // slide type
				$product_slide_id = $product_gallery[1]; // get slide id
			} 
		}
		
		$this->_render_data['product_slide_banner'] = false; // default value
		$this->_render_data['product_full_path'] = '';
		// get slide banner
		if($product_slide_id > 0) {
			$product_gallery_obj = $this->model_product->get_product_gallery($product_slide_id, 1, '');
			$this->_render_data['product_slide_banner'] = explode("|", $product_gallery_obj->product_gallery_images); // retrieve it
			$this->_render_data['product_full_path'] = $this->model_product->get_product_gallery_path($product_slide_id);
			unset($product_gallery_obj);
		}
		
		$this->_render_data['download_catalogue_link'] = strip_tags($product_info->product_source_doc);
		
		$this->_render_data['category_info'] = $this->model_category->get_category_info_id($product_info->product_cate_pc_id);
		unset($product_info);
		
		return $this->load->view('widgets/product_slide_banner', $this->_render_data);
	}
	
	/*###################### product interior - id: 2 ##########################*/
	private function _render_product_interior($product_slug, $lang='') {
		
		if(!$product_slug) show_404();
		
		$data_return['main_content'] = '';
		$data_return['lightbox_code'] = '';
		
		$product_info = $this->model_product->get_product_info_gallery($product_slug);
		$product_gallery = $product_info->product_gallery_type;
		$product_interior_id = 0;
		if(strstr($product_gallery, '|')) {
			$product_gallery = explode('|', $product_gallery);
			foreach($product_gallery as $pgal) {
				$product_gallery_type = explode(':', $pgal);
				if($product_gallery_type[0]=='2') { // interior type :2
					$product_interior_id = $product_gallery_type[1]; // get interior id
				}
			}
			
		} else { // leaf
			$product_gallery = explode(':', $product_gallery);
			if($product_gallery[0] == '2') { // interior type
				$product_interior_id = $product_gallery[1]; // get slide id
			} 
		}
		
		$product_interior_data = false; // default value
		$product_full_path_img = '';
		// get slide banner
		if($product_interior_id > 0) {
			$product_gallery_obj = $this->model_product->get_product_gallery($product_interior_id, 2, $lang);
			$product_interior_data['img'] = explode("|", $product_gallery_obj->product_gallery_images); // images
			$product_interior_data['video'] = explode("|", $product_gallery_obj->product_gallery_video); // video
			
			$product_full_path_img = $this->model_product->get_product_gallery_path($product_interior_id);
			$content_html_return = $this->_render_html_for_gallery($product_interior_data, $product_full_path_img, 'interior_gallery', $product_gallery_obj->product_gallery_caption);
			
			$data_return['lightbox_code'] = $content_html_return['lightbox_code'];
			$data_return['main_content'] = $content_html_return['main_content'];
			
			unset($product_gallery_obj);
			unset($content_html_return);
		}
		
		unset($product_info);
		
		return $data_return;
	}
	
	/*###################### product exterior - id: 3 ##########################*/
	private function _render_product_exterior($product_slug, $lang='') {
		
		if(!$product_slug) show_404();
		
		$data_return['main_content'] = '';
		$data_return['lightbox_code'] = '';
		
		$product_info = $this->model_product->get_product_info_gallery($product_slug);
		$product_gallery = $product_info->product_gallery_type;
		$product_exterior_id = 0;
		
		if(strstr($product_gallery, '|')) {
			$product_gallery = explode('|', $product_gallery);
			foreach($product_gallery as $pgal) {
				$product_gallery_type = explode(':', $pgal);
				if($product_gallery_type[0]=='3') { // exterior type :3
					$product_exterior_id = $product_gallery_type[1]; // get interior id
				}
			}
			
		} else { // leaf
			$product_gallery = explode(':', $product_gallery);
			if($product_gallery[0] == '3') { // exterior type
				$product_exterior_id = $product_gallery[1]; // get slide id
			} 
		}
		
		$product_exterior_data = false; // default value
		$product_full_path_img = '';
		// get slide banner

		if($product_exterior_id > 0) {
			$product_gallery_obj = $this->model_product->get_product_gallery($product_exterior_id, 3, $lang);
		// 	echo '<!--'.$product_exterior_id.'-->';
		// exit;
			$product_exterior_data['img'] = explode("|", $product_gallery_obj->product_gallery_images); // image
			$product_exterior_data['video'] = explode("|", $product_gallery_obj->product_gallery_video); // video
			$product_full_path_img = $this->model_product->get_product_gallery_path($product_exterior_id);
			$content_html_return = $this->_render_html_for_gallery($product_exterior_data, $product_full_path_img, 'exterior_gallery', $product_gallery_obj->product_gallery_caption);
			
			$data_return['lightbox_code'] = $content_html_return['lightbox_code'];
			$data_return['main_content'] = $content_html_return['main_content'];
			
			unset($product_exterior_data);
			unset($content_html_return);
			unset($product_gallery_obj);
		}
		unset($product_info);
		
		return $data_return;
	}
	
	/*###################### product safety - id: 4 ##########################*/
	private function _render_product_safety($product_slug, $lang='') {
		if(!$product_slug) show_404();
		
		$data_return['main_content'] = '';
		$data_return['lightbox_code'] = '';
		
		$product_info = $this->model_product->get_product_info_gallery($product_slug);
		$product_gallery = $product_info->product_gallery_type;
		$product_safety_id = 0;
		
		if(strstr($product_gallery, '|')) {
			$product_gallery = explode('|', $product_gallery);
			foreach($product_gallery as $pgal) {
				$product_gallery_type = explode(':', $pgal);
				if($product_gallery_type[0]=='4') { // safety type :3
					$product_safety_id = $product_gallery_type[1]; // get interior id
				}
			}
			
		} else { // leaf
			$product_gallery = explode(':', $product_gallery);
			if($product_gallery[0] == '4') { // safety type
				$product_safety_id = $product_gallery[1]; // get slide id
			} 
		}
		
		$product_safety_data = false; // default value
		$product_full_path_img = '';
		
		// get slide banner
		if($product_safety_id > 0) {
			$product_gallery_obj = $this->model_product->get_product_gallery($product_safety_id, 4, $lang);
			$product_safety_data['img'] = explode("|", $product_gallery_obj->product_gallery_images); // images
			$product_safety_data['video'] = explode("|", $product_gallery_obj->product_gallery_images); // video
			$product_full_path_img = $this->model_product->get_product_gallery_path($product_safety_id);
			$content_html_return = $this->_render_html_for_gallery($product_safety_data, $product_full_path_img, 'safety_gallery', $product_gallery_obj->product_gallery_caption);
			
			$data_return['lightbox_code'] = $content_html_return['lightbox_code'];
			$data_return['main_content'] = $content_html_return['main_content'];
			
			unset($product_safety_data);
			unset($content_html_return);
			unset($product_gallery_obj);
		}
		
		unset($product_info);
		
		return $data_return;
	}
	
	/*###################### product pallete - id: 5 ##########################*/
	private function _render_product_pallete($product_slug, $lang='') {
		if(!$product_slug) show_404();
		
		$product_info = $this->model_product->get_product_info_gallery($product_slug);
		$product_gallery = $product_info->product_gallery_type;
		$product_pallete_id = 0;
		
		if(strstr($product_gallery, '|')) {
			$product_gallery = explode('|', $product_gallery);
			foreach($product_gallery as $pgal) {
				$product_gallery_type = explode(':', $pgal);
				if($product_gallery_type[0]=='5') { // safety type :3
					$product_pallete_id = $product_gallery_type[1]; // get interior id
				}
			}
			
		} else { // leaf
			$product_gallery = explode(':', $product_gallery);
			if($product_gallery[0] == '5') { // safety type
				$product_pallete_id = $product_gallery[1]; // get slide id
			} 
		}
		
		$product_pallete_data = false; // default value
		$product_full_path_img = '';
		// get slide banner
		if($product_pallete_id > 0) {
			$product_gallery_obj = $this->model_product->get_product_gallery($product_pallete_id, 5, $lang);
			$product_pallete_data['img'] = explode("|", $product_gallery_obj->product_gallery_images); // img
			$product_pallete_data['video'] = explode("|", $product_gallery_obj->product_gallery_video); // video
			$product_full_path_img = $this->model_product->get_product_gallery_path($product_pallete_id);
			$content_html_return = $this->_render_html_for_gallery($product_pallete_data, $product_full_path_img, 'pallete_gallery', $product_gallery_obj->product_gallery_caption);
			
			$data_return['lightbox_code'] = $content_html_return['lightbox_code'];
			$data_return['main_content'] = $content_html_return['main_content'];
			
			unset($content_html_return);
			unset($product_gallery_obj);
			unset($product_pallete_data);
		}
		
		unset($product_info);
		return $data_return;
	}
	
	// render content html
	private function _render_html_for_gallery($gallery_list, $full_path, $class_name, $caption='') {
		
		$data['main_content'] = '';
		$data['lightbox_code'] = '';
		$img_array['original'] = '';
		$img_array['thumb'] = '';
		$caption_title = '';
		if($caption!='') $caption_title = explode('|',$caption);
		
		if($gallery_list!=false) {
			$_run = 0;
			$img_gallery_list = $gallery_list['img'];
			$video_gallery_list = $gallery_list['video'];
			
			/// video part
			foreach($video_gallery_list as $index=>$video) {
				
				$data['main_content'] .= '
				<div class="item_detail_product';
				
				if($_run > 0) $data['main_content'] .= ' mrL20';
					
				if($video!='') {
					$data['main_content'] .= '">
						<a href="#" class="'.$class_name.'">';
					$data['main_content'] .= embed_video_player($video);
					$data['main_content'] .= '</a>';
				} 
				$data['main_content'] .= '</div>';
				
				$_run += 1;
				if($_run==3) $_run=0;
				
			} /// for
			
			// images part
			foreach($img_gallery_list as $index=>$img) {
				
				$data['main_content'] .= '
				<div class="item_detail_product';
				
				if($_run > 0) $data['main_content'] .= ' mrL20';
				
				$place_caption = trim($caption_title[$index]);
				if($place_caption == $this->lang->line('caption_title_textbox') || $place_caption == $this->lang->line('caption_title_textbox_en')) $place_caption = '';
					
				$data['main_content'] .= '">
					<a href="#" class="'.$class_name.'">';
						if($img!='') {
						$image_src = $full_path.'/'.$img;
						
						if($image_src!='') {
							$img_array['original'] .= $image_src.'|';
							if(!strstr($image_src, base_url())) {
								$image_src = $image_src;
							} else {
								$folder_link_image = str_replace($this->config->item('admin_mediastore_real_url'), '', $image_src);
								$image_src = image_thumb($this->config->item('original_image_upload_path').$folder_link_image, $this->config->item('product_gallery_size_w'), $this->config->item('product_gallery_size_h'), 'gallery-type');
							}
							$img_array['thumb'] .= $image_src.'|';
						}
						
							$data['main_content'] .= '<img src="'.$image_src.'" alt="'.$place_caption.'" />';
							
						} else {
							$data['main_content'] .= '<img src="'.base_url().'assets/images/noithat.png" alt="" width="'.$this->config->item('product_gallery_size_w').'" height="'.$this->config->item('product_gallery_size_h').'" />';
						}
					$data['main_content'] .= '</a>';
					
					$data['main_content'] .= '
						<div class="name_item_product">
							<p>'.$place_caption.'</p>
						</div>';
					
				$data['main_content'] .= '</div>';
				
				$_run += 1;
				if($_run==3) $_run=0;
				
			} /// for
			
			$img_array['original'] 	= substr($img_array['original'], 0, -1);
			$img_array['thumb'] 	= substr($img_array['thumb'], 0, -1);
			
			$data['lightbox_code'] = load_lightbox_custom_code($img_array, $caption, $class_name);
			
		} // if
					
		return $data;
					
	}

	private function _load_script_sticky() {
		$js_script = '';
		$js_script = '
			<script src="'.base_url().'assets/js/jquery.easing.1.3.js"></script>
			<script src="'.base_url().'assets/js/stickysidebar.jquery.min.js"></script>
			<script type="text/javascript">
			  $(function () {
				$("#sidebar_ads").stickySidebar({
					timer: 300,
					easing: "easeInOutBack"
				});
			  });
			</script>
			';
		return $js_script;
	}
	
	// render data for seo
	private function _get_title_product_page()
	{
		return $this->_product_title_page;
	}
	
	private function _set_title_product_page($title_page)
	{
		$this->_product_title_page = $title_page;
	}
}