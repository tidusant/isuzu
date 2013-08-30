<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Parts extends MY_Controller {
	
	var $_render_data;
	var $_cur_lang;
	var $_part_title_page;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_part','model_category','settings/isuzu_setting_data'));
		$this->load->library('pagination');
		$this->load->helper(array('text', 'myhelp_helper'));
	}
	
	public function index($lang='') {
		$this->_cur_lang = $lang;
		$content_render = '';
		switch($this->uri->segment(2)) {
			case 'loai':
				$content_render['main_content'] =  $this->_part_cate($lang);
				$content_render['page_title'] = $this->_get_title_part_page();
				break;
			default:
				$content_render['main_content'] = $this->_part_list($lang); // list
		}
		
		if($content_render!='') return $content_render;
		else show_404();
	}
	
	private function _part_list($lang='') {
		$category_limit = 4;
		$this->_render_data['category_list'] = $this->model_category->get_priority_category_list($category_limit, $lang);
		
		return $this->load->view('part/index', $this->_render_data);
	}
	
	private function _part_cate($lang='') {
		
		$category_id = 0; $part_limit = 20;
		$category_slug = $this->uri->segment(3);
		
		if($category_slug!='')  $category_id = intval($this->model_category->get_category_id($category_slug)); 
		else show_404();
		
		$this->_render_data['cur_lang'] = $this->_cur_lang;
		$this->_render_data['category_name'] = $this->model_category->get_category_name($category_id, $lang);
		
		$this->_set_title_part_page($this->_render_data['category_name'].' &raquo; ');
		
		$part_data = $this->_render_content_part($this->model_part->get_part_list_by_cate($category_id, $part_limit, $lang));
		
		$this->_render_data['part_content'] = $part_data['main_content'];
		$this->_render_data['lightbox_script'] = load_lightbox_script();
		$this->_render_data['load_lightbox_code'] = $part_data['lightbox_code'];
		
		unset($part_data);
		
		// loading effect sticky
		$this->_render_data['news_sticky_js'] = $this->_load_script_sticky('sidebar_ads');
		
		return $this->load->view('part/category', $this->_render_data);
	}
	
	public function _render_sidebar() {
		$this->_render_data['catalog_product'] = $this->model_category->get_category_menu($this->_cur_lang);
		return $this->load->view('widgets/sidebar', $this->_render_data);
	}
	
	private function _render_content_part($part_list) {
		
		$data['main_content'] = '';
		$data['lightbox_code'] = '';
		
		$img_array['original'] = '';
		$img_array['thumb'] = '';
		$caption_array = '';
		
		if($part_list!=false) {
			foreach($part_list->result() as $pl) {
				
				$thumb_img = '';
				if(!strstr($pl->part_link_image, 'uploads/assets/media')) {
					$thumb_img = $pl->part_link_image;
				} else {
					$folder_link_image = str_replace($this->config->item('admin_mediastore_real_url'), '', $pl->part_link_image);
					$thumb_img = image_thumb($this->config->item('original_image_upload_path').$folder_link_image, $this->config->item('part_list_size_w'), $this->config->item('part_list_size_h'));
				}
				$img_array['original'] .= $pl->part_link_image.'|';
				$img_array['thumb'] .= $thumb_img.'|';
				
				$data['main_content'] .= '
					<div class="item_part_list">';
						if($pl->part_link_image!='' && $thumb_img!='') {
							
							$data['main_content'] .= '<a href="#" class="inline_gallery">';
							$data['main_content'] .= '
									<img src="'.$thumb_img.'" alt="'.$pl->part_name.'" />';
								
						} else {
						
							$data['main_content'] .= '<img src="'.base_url().'assets/images/part_list.png" alt="'.$pl->part_name.'" />';
						}
							$data['main_content'] .= '</a>';
							
						$data['main_content'] .= '
							<div class="name_item_part_list">
								<h3>'.$pl->part_name.'</h3>
								<p>'.$this->lang->line('part_price').': ';
							
							$part_price = '';
							if($pl->part_price!=0) $part_price = number_format($pl->part_price).' VNĐ'; 
							else $part_price = $this->lang->line('part_contactus');
							
							$data['main_content'] .= $part_price.'</p>
							</div>
					</div>
				';
				$caption_array .= strtoupper($pl->part_name).'. '.$this->lang->line('part_price').': '.$part_price.'|';
				
			} // for
			
			$img_array['original'] 	= substr($img_array['original'], 0, -1);
			$img_array['thumb'] 	= substr($img_array['thumb'], 0, -1);
			$caption_array = substr($caption_array, 0, -1);
			
			$data['lightbox_code'] = load_lightbox_custom_code($img_array, $caption_array);
				
		} /// if
		return $data;
	}
	
	private function _load_script_sticky($element_id='')
	{
		$element_sidebar_id = 'sidebar_sticky';
		if($element_id!='') $element_sidebar_id = $element_id;
		$js_script = '';
		$js_script = '
			<script src="'.base_url().'assets/js/jquery.easing.1.3.js"></script>
			<script src="'.base_url().'assets/js/stickysidebar.jquery.min.js"></script>
			<script type="text/javascript">
			  $(function () {
				$("#'.$element_sidebar_id.'").stickySidebar({
					timer: 300,
					easing: "easeInOutBack"
				});
			  });
			</script>
			';
		return $js_script;
	}
	
	// render data for seo
	private function _get_title_part_page()
	{
		return $this->_part_title_page;
	}
	
	private function _set_title_part_page($title_page)
	{
		$this->_part_title_page = $title_page;
	}
}