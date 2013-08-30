<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Partner extends MY_Controller {
	
	var $_render_data;
	
	public function __construct() {
		parent::__construct();
		$this->load->model(array('model_partner','banners/model_banner','products/model_category','pages/model_page', 'settings/isuzu_setting_data'));
		$this->load->library('pagination');
	}
	
	public function index($lang='') {
		$content_render = $this->_partner_list($lang);
		if($content_render!='') return $content_render;
		else show_404();
	}
	
	private function _partner_list($lang='') {
		$this->load->helper('myhelp');
		$this->_render_data['cur_lang'] = $lang;
		$this->_render_data['partner_location'] = $this->model_partner->get_location($lang);
		
		$this->_render_data['news_sticky_js'] = $this->_load_script_sticky('sidebar_ads');
		return $this->load->view('main/index', $this->_render_data);
		
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
}