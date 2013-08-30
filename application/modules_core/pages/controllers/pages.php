<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends MY_Controller {
	
	var $_render_data;
	var $_page_title_page;
	
	public function __construct() {

		parent::__construct();
		$this->load->model('model_page');
		$this->load->library('pagination');
		$this->load->helper('text');
		$this->load->helper('myhelp_helper');
	}
	
	function index($lang='') {
		
		$page_url_level1 = $this->uri->segment(1);
		$page_url_level2 = $this->uri->segment(2);

		$page_url_level1 = strtolower($page_url_level1);		
		$page_url_level2 = strtolower($page_url_level2);

		$content_render = '';
		
		if($page_url_level2 != '' && $page_url_level2 !='english' && $page_url_level2 !='vietnamese') {
			$content_render['main_content'] = $this->_page_detail($page_url_level2, $lang);
		} else $content_render['main_content'] = $this->_page_detail($page_url_level1, $lang);
		
		$content_render['page_title'] = $this->_get_title_page();
		
		if($content_render!='') return $content_render;
		else show_404();
	}
	
	private function _page_detail($page_name, $lang='') {
		
		$this->_render_data['facebook_intializing'] = facebook_loading_script();
		$this->_render_data['sharethis_intializing'] = sharethis_loading_script();
		
		$page_detail = $this->model_page->get_page_by_slug($page_name, $lang);
		
		$page_layout = 0;
		
		if($page_detail!=false) $page_layout = $page_detail->layout;
		else show_404();
		
		$this->_render_data['page_detail'] = $page_detail;
		
		$this->_set_title_page($page_detail->page_title);
		
		unset($page_detail);
		// loading effect sticky
		$this->_render_data['news_sticky_js'] = $this->_load_script_sticky();
		
		// full page or sidebar page
		if($page_layout=='0') { // full page
			return $this->load->view('main/detail_fullpage', $this->_render_data);
		} elseif($page_layout=='1') { // sidebar page
			return $this->load->view('main/detail_sidebar', $this->_render_data);
		}
	}
	
	public function page_list() {
		$this->load->view('main/index', $this->_render_data);
	}
	
	private function _load_script_sticky()
	{
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
	private function _get_title_page()
	{
		return $this->_page_title_page;
	}
	
	private function _set_title_page($title_page)
	{
		$this->_page_title_page = $title_page;
	}
	
}

/* End of file authors.php */
/* Location: ./application/controllers/authors.php */