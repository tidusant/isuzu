<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rearbody extends MY_Controller {
	
	var $_render_data;
	var $_cur_lang;
	var $_rearbody_title_page;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_part','model_category','settings/isuzu_setting_data'));
		$this->load->library('pagination');
		$this->load->helper(array('text', 'myhelp_helper'));
	}
	
	public function index($lang='') {
		
		$content_render = '';
		$this->_cur_lang = $lang;
		$content_render['main_content'] = $this->_rearbody_list($lang);
		$content_render['page_title'] = $this->_get_title_rearbody_page();
		if($content_render!='') return $content_render;
		else show_404();
		
	}
	
	private function _rearbody_list($lang='') {
		
		$part_limit = 20;
		
		$rear_data = $this->_render_content_rearbody($this->model_part->get_rearbody_list($part_limit, $lang));
		
		$this->_render_data['cur_lang'] = $this->_cur_lang;
		
		$this->_render_data['rearbody_content'] = $rear_data['main_content'];
		$this->_render_data['lightbox_script'] = load_lightbox_script();
		$this->_render_data['load_lightbox_code'] = $rear_data['lightbox_code'];
		
		unset($rear_data);
		
		// loading effect sticky
		$this->_render_data['news_sticky_js'] = $this->_load_script_sticky('sidebar_ads');
		$this->_set_title_rearbody_page($this->lang->line('seo_rearbody_page_title').' &raquo; ');
		
		return $this->load->view('rearbody/list', $this->_render_data);
	}
	
	private function _render_content_rearbody($rearbody_list) {
		
		$data['main_content'] = '';
		$data['lightbox_code'] = '';
		
		$img_array['original'] = '';
		$img_array['thumb'] = '';
		$caption_array = '';
		
		if($rearbody_list!=false) {
			foreach($rearbody_list->result() as $pl) {
				
				$thumb_img = '';
				if(!strstr($pl->rear_link_image, 'uploads/assets/media')) {
					$thumb_img = $pl->rear_link_image;
				} else {
					$folder_link_image = str_replace($this->config->item('admin_mediastore_real_url'), '', $pl->rear_link_image);
					$thumb_img = image_thumb($this->config->item('original_image_upload_path').$folder_link_image, $this->config->item('part_list_size_w'), $this->config->item('part_list_size_h'));
				}
				$img_array['original'] .= $pl->rear_link_image.'|';
				$img_array['thumb'] .= $thumb_img.'|';
				
				$data['main_content'] .= '
					<div class="item_part_list">';
						$data['main_content'] .= '<a href="#" class="inline_gallery">';
						if($pl->rear_link_image!='' && $thumb_img!='') {
							
							$data['main_content'] .= '
									<img src="'.$thumb_img.'" alt="'.$pl->rearbody_name.'" />';
								
						} else {
						
							$data['main_content'] .= '<img src="'.base_url().'assets/images/part_list.png" alt="'.$pl->rearbody_name.'" />';
						}
							$data['main_content'] .= '</a>';
							
						$data['main_content'] .= '
							<div class="name_item_part_list">
								<h3>'.$pl->rearbody_name.'</h3>';
							
							if($pl->rearbody_url!=NULL) {
								$data['main_content'] .= '
								<div class="view_detail">
									<a href="'.site_url($pl->rearbody_url).'">'.$this->lang->line('button_news_detail').'</a>
								</div>';
							}
								
							$data['main_content'] .= '</div>
					</div>
				';
				$caption_array .= strtoupper($pl->rearbody_name).'|';
				
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
	private function _get_title_rearbody_page()
	{
		return $this->_rearbody_title_page;
	}
	
	private function _set_title_rearbody_page($title_page)
	{
		$this->_rearbody_title_page = $title_page;
	}
	
}