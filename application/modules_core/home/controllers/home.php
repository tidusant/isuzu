<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
	
	var $_render_data;
	var $_clang='';
	
	public function __construct() {

		parent::__construct();
		$this->load->model(array('news/model_news', 'banners/model_banner', 'products/model_category', 'products/model_product', 'pages/model_page', 'settings/isuzu_setting_data'));
		$this->load->helper('text');
		
		$this->output->set_header("HTTP/1.0 200 OK");
		$this->output->set_header("HTTP/1.1 200 OK");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 
	}
	
	public function index() {

		if($this->session->userdata('site_lang') && $this->session->userdata('site_lang')=="english")
		$this->_clang = strtoupper("eng");
		else $this->_clang = '';
		
		$content_render = '';
		$which_module = $this->uri->segment(1);
		
		// website title
		$web_title = '';
		
		// widget social buttons
		$this->_render_data['isuzu_twitter_page'] = $this->isuzu_setting_data->get('setting_twitter_script');
		$this->_render_data['isuzu_fb_page'] = $this->isuzu_setting_data->get('setting_facebook_script');
		$this->_render_data['isuzu_gplus_id'] = $this->isuzu_setting_data->get('setting_gplus_script');
		
		// some params
		$main_slide_banner = '';
		
		// menu active
		$menu_active = array();
		switch($which_module) {
			case 'language':
				$content_render = modules::run('langloader/langloader/index');
				break;
			case 'san-pham':
				$product_render = modules::run('products/products/index', $this->_clang);
				$content_render = $product_render['main_content'];
				if(isset($product_render['page_title'])) 
					$web_title = $product_render['page_title'];
				if(isset($product_render['main_slide_banner'])) 
					$main_slide_banner = $product_render['main_slide_banner'];
				else $main_slide_banner = $this->_render_slide_banner();// default
				unset($product_render);
				$web_title .= $this->lang->line('seo_product_page_title').' - ';
				break;
			case 'phu-tung':
				$part_render = modules::run('products/parts/index', $this->_clang);
				$content_render = $part_render['main_content'];
				if(isset($part_render['page_title'])) $web_title = $part_render['page_title'];
				unset($part_render);
				$main_slide_banner = $this->_render_slide_banner();
				$web_title .= $this->lang->line('seo_part_page_title').' - ';
				break;
			case 'dai-ly':
				$web_title = $this->lang->line('seo_dealer_page_title').' - ';
				$content_render = modules::run('partner/index', $this->_clang);
				break;
			case 'faq':
				$web_title = $this->lang->line('seo_faq_page_title').' - ';
				$content_render = modules::run('faq/index', $this->_clang);
				$main_slide_banner = $this->_render_slide_banner();
				break;
			case 'tin-tuc':
				$news_render = modules::run('news/index', $this->_clang);
				$content_render = $news_render['main_content'];
				if(isset($news_render['page_title'])) $web_title = $news_render['page_title'].' - ';
				$web_title .= $this->lang->line('seo_news_page_title').' - ';
				unset($news_render);
				break;
			case 'dang-ki-lai-thu':
				$web_title = $this->lang->line('seo_testdrive_page_title').' - ';
				$content_render = modules::run('pages/testdrive/index', $this->_clang);
				$main_slide_banner = $this->_render_slide_banner();
				break;
			case 'lien-he':
				$web_title = $this->lang->line('seo_contactus_page_title').' - ';
				$content_render = modules::run('contact/index');
				$main_slide_banner = $this->_render_slide_banner();
				break;
			default:
				if($which_module!='' && $which_module!='english' && $which_module!='vietnamese' ) {
					if($which_module!='dich-vu') $main_slide_banner = $this->_render_slide_banner();
					$page_render = modules::run('pages/index', $this->_clang);
					$content_render = $page_render['main_content'];
					if(isset($page_render['page_title'])) $web_title = $page_render['page_title'].' - ';
				}
				else {
					$main_slide_banner = $this->_render_slide_banner();
					$content_render = $this->_render_homepage($this->_clang);
				}
		}
		
		$menu_active[$which_module] = ' class="active"';
		if($which_module=='') $menu_active['home'] = ' class="active"';
		
		// main menu
		$this->_render_data['active_current_menu'] = $menu_active;
		$this->_render_data['render_main_menu'] = $this->_render_main_menu($this->_clang);
		// banner
		$this->_render_data['main_slide_banner'] = $main_slide_banner;
		$this->_render_data['content_render'] = $content_render;
		// footer
		$this->_render_data['footer_contact_info'] = $this->_render_footer_contact_info($this->_clang);
		
		// website title
		$web_title .= $this->isuzu_setting_data->get('application_title');
		$this->_render_data['web_title'] = $web_title;
		
		$this->load->view('home/master_layout', $this->_render_data, false);
	}
	
	private function _render_homepage($lang='') {
		$promotion_limit = $this->isuzu_setting_data->get('home_show_promotion');
		$news_limit = $this->isuzu_setting_data->get('home_show_news');
		// promotion
		$this->_render_data['event_promotion'] = $this->model_news->get_promotion_home($news_limit, $lang);
		// news
		$this->_render_data['event_news'] = $this->model_news->get_news_home($news_limit, $lang);
		// product
		$catalog_limit = 4;
		$this->_render_data['catalog_home'] = $this->model_category->get_priority_catalog($lang, $catalog_limit);
		
		// page show home
		$page_onhome_limit = $this->isuzu_setting_data->get('home_show_pages');
		$this->_render_data['page_show_home'] = $this->model_page->get_pages_home(1, $page_onhome_limit, $lang); // 1 mean home on page tree
		
		return $this->load->view('home/home/index', $this->_render_data);
	}
	
	private function _render_main_menu($lang='')
	{
		$this->_render_data['cur_lang'] = $lang;
		$this->_render_data['menu_page_tree'] = $this->model_page->get_parent_menu($lang);
		$this->_render_data['menu_product_catalog'] = $this->model_category->get_category_menu($lang);
		return $this->load->view('home/widgets/main_menu', $this->_render_data);
	}
	
	public function _render_search_form()
	{
		return $this->load->view('home/widgets/search_form', $this->_render_data);
	}
	
	private function _render_slide_banner()
	{
		$slide_banner_limit = $this->isuzu_setting_data->get('banner_slide_show');
		$this->_render_data['banner_slide'] = $this->model_banner->get_banner(1, $slide_banner_limit);
		
		return $this->load->view('widgets/slide_banner', $this->_render_data);
	}
	
	public function _render_top_menu()
	{
		return $this->load->view('widgets/top_menu', $this->_render_data);
	}
	
	public function _render_footer_contact_info($lang='')
	{
		$this->_render_data['footer_contact_info'] = $this->isuzu_setting_data->get_setting_front_end('setting_contact_footer', $lang);
		return $this->load->view('widgets/footer_contact_info', $this->_render_data);
	}
	
	public function _render_footer_weblinks()
	{
		$this->_render_data['footer_weblinks'] = $this->isuzu_setting_data->get_weblinks();
		return $this->load->view('widgets/footer_weblinks', $this->_render_data);
	}
	
	// message - error alert system
	public function _render_system_message()
	{
		return $this->load->view('widgets/front_end_message', $this->_render_data);
	}
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */