<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administration extends MX_Controller {
	
	public static $is_loaded;
	private $_push;
	
	function __construct() {

		parent::__construct();
		
		$this->load->library('session');
	//	$this->load->library('ion_auth');

		if (!isset(self::$is_loaded)) {

			self::$is_loaded = TRUE;
			
			$this->load->helper('url');
			
		//	$this->load->config(array('custom', 'ion_auth'));
			$this->load->config('custom');
			
			//$this->config->item('use_mongodb', 'ion_auth') ?
			//$this->load->library('mongo_db') :
		
			$this->load->database();

			$this->load->helper(array('uri', 'isuzu_date', 'isuzu_numbers'));
			
			$this->load->model(array('sysusers/admin_model_member', 'sysusers/admin_model_membergroup', 'settings/isuzu_setting_data'));
			
            $this->isuzu_setting_data->set_session_data();
			
			$this->load->language('isuzu');
			
			$this->load->library(array('form_validation', 'redir'));

			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		}
		
		$this->_no_cache_backend();
		
	}
	
	public function index() {
		
		$content_render = '';
		$which_module = $this->uri->segment(2);
		
		if($which_module=='login') {
			return modules::run('auth/login');
		} elseif($which_module=='logout') {
			return modules::run('auth/logout');
		}
		
		switch($which_module) {
			case 'products':
				$content_render = modules::run('products/gotthat/mproduct/index');
				break;
			case 'catalog':
				$content_render = modules::run('products/gotthat/mcategory/index');
				break;
			case 'parts':
				$content_render = modules::run('products/gotthat/mpart/index');
				break;
			case 'accessories':
				$content_render = modules::run('products/gotthat/maccessory/index');
				break;
			case 'rearbody':
				$content_render = modules::run('products/gotthat/mrearbody/index');
				break;
			case 'partners';
				$content_render = modules::run('partner/gotthat/mpartner/index');
				break;
			case 'pages';
				$content_render = modules::run('pages/gotthat/mpage/index');
				break;
			case 'menu';
				$content_render = modules::run('pages/gotthat/mmenu/index');
				break;
			case 'news';
				$content_render = modules::run('news/gotthat/mnews/index');
				break;
			case 'comment';
				$content_render = modules::run('news/gotthat/mcomment/index');
				break;
			case 'settings';
				$content_render = modules::run('settings/gotthat/msetting/index');
				break;
			case 'form_management';
				$content_render = modules::run('settings/gotthat/mformmanage/index');
				break;
			case 'filemanager':
				$content_render = modules::run('mediastore/gotthat/mfilemanager/index');
				break;
			case 'banners':
				$content_render = modules::run('banners/gotthat/mbanners/index');
				break;
			case 'logs':
				$content_render = modules::run('logs/gotthat/mlogs/index');
				break;
			case 'faqs':
				$content_render = modules::run('faq/gotthat/mfaq/index');
				break;
			case 'system_users':
				$content_render = modules::run('sysusers/gotthat/musers/index');
				break;
			case 'web-links':
				$content_render = modules::run('weblinks/gotthat/mweblinks/index');
				break;
			default:
				$content_render = $this->_dashboard();
		}
		
		
		//check login
		$this->_check_login();
        
		$this->_push['content_render'] = $content_render;
		
		return $this->load->view('master_layout', $this->_push, false);

	}
	
	private function _dashboard() {
		
		$this->load->model(array('news/admin_model_news', 'news/admin_model_comment', 'products/admin_model_product', 'sysusers/admin_model_member'));
		
		$this->_push['total_count_news'] = $this->admin_model_news->get_total_news();
		
		$this->_push['total_count_comment'] = $this->admin_model_comment->get_total_comment();
		
		$this->_push['total_count_products'] = $this->admin_model_product->get_total_product();
		
		$this->_push['total_count_member'] = $this->admin_model_member->get_total_member();
		
		return $this->load->view('main/index', $this->_push);
		
	}
	
	private function _check_login()
	{
		
		$user_id = $this->session->userdata('member_id');
        if (!$user_id) redirect($this->uri->segment(1).'/login');
		
		/*if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->uri->segment(1).'/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin())
		{
			//redirect them to the home page because they must be an administrator to view this
			redirect('/', 'refresh');
		}
		else
		{
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list the users
			$this->data['users'] = $this->ion_auth->users()->result();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}

			$this->_render_page('auth/index', $this->data);
		}*/
		
	}
	
	public function _render_menu()
	{
		
		$menu_data = '';
		if($this->admin_model_member->logged_in())
		{
			// check user level
			$user_level = $this->session->userdata('user_level');
			
			// return list module permission
			$module_permission = $this->admin_model_membergroup->check_module_user_permision($user_level);
			
			$menu_data = '
				<li>
				<a href="'.site_url($this->uri->segment(1)).'"';
				
				if(strstr($this->uri->uri_string(), 'administration')) 
					$menu_data .= ' class="active"';
				
				$menu_data .= '><i class="icon-fire"></i>Dashboard</a>
				</li>';
				
				if($module_permission!=false && isset($module_permission[1])) {
				$menu_data .= '<!-- product -->
				<li';
				if(strstr($this->uri->uri_string(), 'products') || strstr($this->uri->uri_string(), 'products/form') || strstr($this->uri->uri_string(), 'catalog') || strstr($this->uri->uri_string(), 'parts') || strstr($this->uri->uri_string(), 'accessories') || strstr($this->uri->uri_string(), 'rearbody')) $menu_data .= ' class="active"';
				
				$menu_data .= '>
				<a href="#product"><i class="icon-leaf"></i>'.$this->lang->line('modul_product').'</a>
				
				<ul>
				<li>
				<a href="'.site_url($this->uri->segment(1).'/products/form').'"';
				
				if(strstr($this->uri->uri_string(), '/products/form')) $menu_data .= ' class="active"';
				
				$menu_data .= '><i class="icon-magic"></i>'.$this->lang->line('modul_createproduct').'</a>
				</li>
				<li>
				<a href="'.site_url($this->uri->segment(1).'/products/index').'"';
				if(strstr($this->uri->uri_string(), 'products/index')) $menu_data .= ' class="active"';
				
				$menu_data .= '><i class="icon-th-list"></i>'.$this->lang->line('modul_list').'</a>
				</li>
				<li>
				<a href="'.site_url($this->uri->segment(1).'/catalog/index').'"';
				if(strstr($this->uri->uri_string(), 'catalog')) $menu_data .= ' class="active"';
				
				$menu_data .= '><i class="icon-th-list"></i>'.$this->lang->line('modul_category').'</a>
				</li>
				<li>
				<a href="'.site_url($this->uri->segment(1).'/parts/index').'"';
				if(strstr($this->uri->uri_string(), 'parts')) $menu_data .= ' class="active"';
				$menu_data .= '><i class="icon-th-list"></i>Parts</a>
				</li>
				<li>
				<a href="'.site_url($this->uri->segment(1).'/accessories/index').'"';
				if(strstr($this->uri->uri_string(), 'accessories')) $menu_data .= ' class="active"';
				$menu_data .= '><i class="icon-th-list"></i>Accessories</a>
				</li>
				<li>
				<a href="'.site_url($this->uri->segment(1).'/rearbody/index').'"';
				if(strstr($this->uri->uri_string(), 'rearbody')) $menu_data .= ' class="active"';
				$menu_data .= '><i class="icon-th-list"></i>Rear Body</a>
				</li>
				</ul>
				</li>';
				} // product permission
				
				if($module_permission!=false) {
					$menu_data .= '<!-- news -->
					<li';
					
					if(strstr($this->uri->uri_string(), 'news') || strstr($this->uri->uri_string(), 'comment')) $menu_data .= ' class="active"';
					
					$menu_data .= '>
					<a href="#news"><i class="icon-leaf"></i>'.$this->lang->line('modul_news').'</a>
					<ul>';
					
					if(isset($module_permission[2])) {
						$menu_data .= '<li>
						<a href="'.site_url($this->uri->segment(1).'/news/form').'"';
						if(strstr($this->uri->uri_string(), 'news/form')) $menu_data .= ' class="active"';
						$menu_data .= '><i class="icon-magic"></i>'.$this->lang->line('modul_createnew').'</a>
						</li>
						<li>
						<a href="'.site_url($this->uri->segment(1).'/news/index').'"';
						if(strstr($this->uri->uri_string(), 'news/index')) $menu_data .= ' class="active"';
						$menu_data .= '><i class="icon-th-list"></i>'.$this->lang->line('modul_list').'</a>
						</li>';
					}
					
					if(isset($module_permission[3])) {
						$menu_data .= '<li>
						<a href="'.site_url($this->uri->segment(1).'/comment/index').'"';
						if(strstr($this->uri->uri_string(), 'comment')) $menu_data .= ' class="active"';
						$menu_data .= '><i class="icon-th-list"></i>Comments</a>
						</li>';
					}

					$menu_data .= '</ul>
					</li>';
				
				} // news module
				
				if($module_permission!=false) {
					$menu_data .= '<!-- faq -->
					<li';
					if(strstr($this->uri->uri_string(), 'faqs')) $menu_data .= ' class="active"';
					
					$menu_data .= '>
					<a href="#faq"><i class="icon-leaf"></i>'.$this->lang->line('modul_faq').'</a>
					<ul>';
					
					if(isset($module_permission[9])) {
						$menu_data .= '<li>
						<a href="'.site_url($this->uri->segment(1).'/faqs/form').'"';
						if(strstr($this->uri->uri_string(), 'faqs/form')) $menu_data .= ' class="active"';
						$menu_data .= '><i class="icon-magic"></i>'.$this->lang->line('modul_createfaq').'</a>
						</li>
						<li>
						<a href="'.site_url($this->uri->segment(1).'/faqs/index').'"';
						if(strstr($this->uri->uri_string(), 'faqs/index')) $menu_data .= ' class="active"';
						$menu_data .= '><i class="icon-th-list"></i>'.$this->lang->line('modul_list').'</a>
						</li>';
						
					}
					
					$menu_data .= '</ul>
					</li>';
				
				} // faq module
				
				if($module_permission!=false && isset($module_permission[4])) {
				$menu_data .= '<!-- media store -->
				<li';
				if(strstr($this->uri->uri_string(), 'filemanager')) $menu_data .= ' class="active"';
				
				$menu_data .= '>
				<a href="#media store"><i class="icon-leaf"></i>'.$this->lang->line('modul_mediastore').'</a>
					<ul>
						<li><a href="'.site_url($this->uri->segment(1).'/filemanager/attachmedia').'"';
						if(strstr($this->uri->uri_string(), 'filemanager/attachmedia')) $menu_data .= ' class="active"';
						
						$menu_data .= '><i class="icon-magic"></i>'.$this->lang->line('modul_creatmedia').'</a></li>
						<li><a href="'.site_url($this->uri->segment(1).'/filemanager/index').'"';
						if(strstr($this->uri->uri_string(), 'filemanager/index')) $menu_data .= ' class="active"';
						
						$menu_data .= '><i class="icon-th-list"></i>'.$this->lang->line('modul_list').'</a></li>';
						
						$menu_data .= '
					</ul>
				</li>';
				}
				
				if($module_permission!=false && (isset($module_permission[5]) || isset($module_permission[6]))) {
				$menu_data .= '<!-- page -->
				<li';
				if(strstr($this->uri->uri_string(), 'pages/index') || strstr($this->uri->uri_string(), 'menu/index') || strstr($this->uri->uri_string(), 'pages/form') || strstr($this->uri->uri_string(), 'menu/form')) $menu_data .= ' class="active"';
				
				$menu_data .= '>
				<a href="#page"><i class="icon-font"></i>'.$this->lang->line('modul_page').'</a>
					<ul>';
					
					if(isset($module_permission[5])) {
						$menu_data .= '
						<!-- page -->
						<li><a href="'.site_url($this->uri->segment(1).'/pages/form').'"';
						if(strstr($this->uri->uri_string(), 'pages/form')) $menu_data .= ' class="active"';
						
						$menu_data .= '><i class="icon-magic"></i>'.$this->lang->line('modul_createpage').'</a></li>
						<li><a href="'.site_url($this->uri->segment(1).'/pages/index').'"';
						if(strstr($this->uri->uri_string(), 'pages/index')) $menu_data .= ' class="active"';
						
						$menu_data .= '><i class="icon-th-list"></i>'.$this->lang->line('modul_list').'</a></li>';
					}
					
					if(isset($module_permission[6])) {
						$menu_data .= '<!-- menu -->
						<li><a href="'.site_url($this->uri->segment(1).'/menu/index').'"';
						if(strstr($this->uri->uri_string(), 'menu/index') || strstr($this->uri->uri_string(), 'menu/form')) $menu_data .= ' class="active"';
						
						$menu_data .= '><i class="icon-th-list"></i>'.$this->lang->line('modul_pagemenu').'</a></li>';
					}
					
					$menu_data .= '	
					</ul>
				</li>';
				}
				
				if($module_permission!=false) {
					$menu_data .= '<!-- partner -->
					<li';
					
					if(strstr($this->uri->uri_string(), 'partners') || strstr($this->uri->uri_string(), 'partners/location')) $menu_data .= ' class="active"';
					
					$menu_data .= '>
					<a href="#partner"><i class="icon-leaf"></i>'.$this->lang->line('modul_partner').'</a>
					<ul>';
					
					if(isset($module_permission[10])) {
						$menu_data .= '<li>
						<a href="'.site_url($this->uri->segment(1).'/partners/form').'"';
						if(strstr($this->uri->uri_string(), 'partners/form')) $menu_data .= ' class="active"';
						$menu_data .= '><i class="icon-magic"></i>'.$this->lang->line('modul_createpartner').'</a>
						</li>
						<li>
						<a href="'.site_url($this->uri->segment(1).'/partners/index').'"';
						if(strstr($this->uri->uri_string(), 'partners/index')) $menu_data .= ' class="active"';
						$menu_data .= '><i class="icon-th-list"></i>'.$this->lang->line('modul_list').'</a>
						</li>';
						
						$menu_data .= '<li>
						<a href="'.site_url($this->uri->segment(1).'/partners/location').'"';
						if(strstr($this->uri->uri_string(), 'partners/location')) $menu_data .= ' class="active"';
						
						$menu_data .= '><i class="icon-th-list"></i>'.$this->lang->line('modul_partner_location').'</a>
						</li>';
						
					}
					

					$menu_data .= '</ul>
					</li>';
				
				} // partner module
				
				if($module_permission!=false && isset($module_permission[7])) {
					$menu_data .= '<!-- banner -->
					<li ';
					if(strstr($this->uri->uri_string(), 'banners') || strstr($this->uri->uri_string(), 'banners/position')) $menu_data .= 'class="active"';
					
					$menu_data .= '><a href="#banner"><i class="icon-picture"></i>'.$this->lang->line('modul_banner').'</a>
						<ul>';
					
					// banner management
					$menu_data .= '<li>
					<a href="'.site_url($this->uri->segment(1).'/banners/index').'"';
					if(strstr($this->uri->uri_string(), 'banners/index') || strstr($this->uri->uri_string(), 'banners/form')) $menu_data .= ' class="active"';
					$menu_data .= '><i class="icon-picture"></i>Manage</a></li>';
					
					/// banner position
					$menu_data .= '<!-- banner position -->
					<li>
					<a href="'.site_url($this->uri->segment(1).'/banners/position').'"';
					if(strstr($this->uri->uri_string(), 'banners/position')) $menu_data .= ' class="active"';
					
					$menu_data .= '><i class="icon-picture"></i>Position</a>
					</li>';
					
					$menu_data .= '
						</ul>
					</li>';
					
					$menu_data .= '<!-- logs -->
					<li>
					<a href="'.site_url($this->uri->segment(1).'/logs/index').'"';
					if(strstr($this->uri->uri_string(), 'mlogs')) $menu_data .= ' class="active"';
					
					$menu_data .= '><i class="icon-calendar"></i>'.$this->lang->line('modul_log').'</a>
					</li>';
				}
				
				// web links
				if($module_permission!=false && isset($module_permission[12])) {
					
					$menu_data .= '<!-- weblinks -->
					<li>
					<a href="'.site_url($this->uri->segment(1).'/web-links/index').'"';
					if(strstr($this->uri->uri_string(), 'web-links')) $menu_data .= ' class="active"';
					
					$menu_data .= '><i class="icon-th-list"></i>Web Links</a>
					</li>';
					
				}
				
				if($module_permission!=false && isset($module_permission[8])) {
					
					$menu_data .= '
					<!-- users -->
					<li ';
					if(strstr($this->uri->uri_string(), 'system_users')) $menu_data .= ' class="active"';
					
					$menu_data .= '>
					<a href="#sysusers"><i class="icon-star"></i>'.$this->lang->line('modul_member').'</a>
						<ul>
							<li>
							<a href="'.site_url($this->uri->segment(1).'/system_users/index').'"';
							if(strstr($this->uri->uri_string(), 'system_users/index')) $menu_data .=  ' class="active"';
							
							$menu_data .= '>LIST</a>
							</li>
							<li><a href="'.site_url($this->uri->segment(1).'/system_users/groups').'"';
							if(strstr($this->uri->uri_string(), 'system_users/groups')) $menu_data .=  ' class="active"';
							
							$menu_data .= '>'.$this->lang->line('modul_membergroup').'</a></li>
						</ul>
					</li>
				';
				}
				
				if($module_permission!=false && isset($module_permission[11]) && $this->session->userdata('user_level') == 1) {
					
					$menu_data .= '
					<!-- setting -->
					<li ';
					if(strstr($this->uri->uri_string(), 'settings')) $menu_data .= ' class="active"';
					
					$menu_data .= '>
					<a href="'.site_url($this->uri->segment(1).'/settings/index').'"';
					if(strstr($this->uri->uri_string(), 'settings/index')) $menu_data .= ' class="active"';
					$menu_data .= '><i class="icon-star"></i>'.$this->lang->line('modul_systemsetting').'</a>
					</li>
					';
				
					// report
					$menu_data .= '
					<!-- report -->
					<li ';
					if(strstr($this->uri->uri_string(), 'form_management/event_reg') || strstr($this->uri->uri_string(), 'form_management/test_drive_reg') || strstr($this->uri->uri_string(), 'form_management/contacter')) $menu_data .= ' class="active"';
					
					$menu_data .= '><a href="#systemsetting"><i class="icon-th-list"></i>Report</a>
						<ul>';
						
					// event form register
					$menu_data .= '
					<li>
						<a href="'.site_url($this->uri->segment(1).'/form_management/event_reg').'"';
					if(strstr($this->uri->uri_string(), 'form_management/event_reg')) $menu_data .=  ' class="active"';
					$menu_data .= '>Event Form Register</a>
					</li>';
					
					// drive form register
					$menu_data .= '
					<li>
						<a href="'.site_url($this->uri->segment(1).'/form_management/test_drive_reg').'"';
					if(strstr($this->uri->uri_string(), 'form_management/test_drive_reg')) $menu_data .=  ' class="active"';
					$menu_data .= '>Drive Form Register</a>
					</li>';
					
					// contact form
					$menu_data .= '
					<li>
						<a href="'.site_url($this->uri->segment(1).'/form_management/contacter').'"';
					if(strstr($this->uri->uri_string(), 'form_management/contacter')) $menu_data .=  ' class="active"';
					$menu_data .= '>Contact List</a>
					</li>';
					
					$menu_data	.= '
						</ul>
					</li>
					';
					
				}
			
		}
		return $menu_data;
	}
	
	public function _render_topline()
	{
		return $this->load->view('widgets/topline', $this->_push);
	}
	
	public function _render_breadcum()
	{
		return $this->load->view('widgets/breadcum', $this->_push);
	}
	
	public function _render_dashboardnav()
	{
		return $this->load->view('widgets/dashboardnav', $this->_push);
	}
	
	public function _render_system_alert_message()
	{
		return $this->load->view('system_messages');
	}
	
	private function _no_cache_backend()
	{
		// No cache for backend
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", FALSE);
		$this->output->set_header("Pragma: no-cache");
	}
	
	private function _render_page($view, $data=null, $render=true)
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $render);

		if (!$render) return $view_html;
	}
	
	public function _render_browse_image()
	{
		return $this->load->view('plugins/browse_image', $this->_push);
	}
}

/* End of file administration.php */
/* Location: ./application/controllers/administration.php */