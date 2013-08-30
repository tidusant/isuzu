<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Accessories extends MY_Controller {
	
	var $_render_data;
	var $_cur_lang;
	var $_accessory_title_page;
	
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
		$content_render['main_content'] = $this->_accessory_list($lang);
		$content_render['page_title'] = $this->_get_title_accessory_page();
		if($content_render!='') return $content_render;
		else show_404();
	}
	
	private function _accessory_list($lang='') {
		
		$part_limit = 20;
		
		$acc_data = $this->_render_content_accessory($this->model_part->get_accessories_list($part_limit, $lang));
		
		$this->_render_data['cur_lang'] = $this->_cur_lang;
		
		$this->_render_data['acc_content'] = $acc_data['main_content'];
		$this->_render_data['lightbox_script'] = load_lightbox_script();
		$this->_render_data['load_lightbox_code'] = $acc_data['lightbox_code'];
		
		unset($acc_data);
		
		// loading effect sticky
		$this->_render_data['news_sticky_js'] = $this->_load_script_sticky('sidebar_ads');
		
		$this->_set_title_accessory_page($this->lang->line('seo_accessory_page_title').' &raquo; ');
		
		return $this->load->view('accessory/list', $this->_render_data);
	}
	
	private function _render_content_accessory($accessory_list) {
		
		$data['main_content'] = '';
		$data['lightbox_code'] = '';
		
		$img_array['original'] = '';
		$img_array['thumb'] = '';
		$caption_array = '';
		
		if($accessory_list!=false) {
			foreach($accessory_list->result() as $pl) {
				
				$thumb_img = '';
				if(!strstr($pl->acc_link_image, 'uploads/assets/media')) {
					$thumb_img = $pl->acc_link_image;
				} else {
					$folder_link_image = str_replace($this->config->item('admin_mediastore_real_url'), '', $pl->acc_link_image);
					$thumb_img = image_thumb($this->config->item('original_image_upload_path').$folder_link_image, $this->config->item('part_list_size_w'), $this->config->item('part_list_size_h'));
				}
				$img_array['original'] .= $pl->acc_link_image.'|';
				$img_array['thumb'] .= $thumb_img.'|';
				
				$data['main_content'] .= '
					<div class="item_part_list">';
						$data['main_content'] .= '<a href="#" class="inline_gallery">';
						if($pl->acc_link_image!='' && $thumb_img!='') {
							
							$data['main_content'] .= '
									<img src="'.$thumb_img.'" alt="'.$pl->acc_name.'" />';
								
						} else {
						
							$data['main_content'] .= '<img src="'.base_url().'assets/images/part_list.png" alt="'.$pl->acc_name.'" />';
						}
							$data['main_content'] .= '</a>';
							
						$data['main_content'] .= '
							<div class="name_item_part_list">
								<h3>'.$pl->acc_name.'</h3>
								<p>'.$this->lang->line('part_price').': ';
							
							$acc_price = '';
							if($pl->acc_price!=0) $acc_price = number_format($pl->acc_price).' VNĐ'; 
							else $acc_price = $this->lang->line('part_contactus');
							
							$data['main_content'] .= $acc_price.'</p>
							</div>
					</div>
				';
				$caption_array .= strtoupper($pl->acc_name).'. '.$this->lang->line('part_price').': '.$acc_price.'|';
				
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
	private function _get_title_accessory_page()
	{
		return $this->_accessory_title_page;
	}
	
	private function _set_title_accessory_page($title_page)
	{
		$this->_accessory_title_page = $title_page;
	}
}