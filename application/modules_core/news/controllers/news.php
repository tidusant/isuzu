<?php defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MY_Controller {
	
	var $_render_data;
	var $_cur_lang;
	var $_news_title_page;
	
	public function __construct() {
		parent::__construct();
		$this->load->model(array('model_news','banners/model_banner', 'products/model_product', 'products/model_category','pages/model_page', 'settings/isuzu_setting_data'));
		$this->load->library('form_validation');
		$this->load->helper('text');
	}
	
	public function index($lang='') {
		
		$content_render = '';
		$this->_cur_lang = $lang;
		$which_page = $this->uri->segment(2);
		$which_page = strtolower($which_page);
		switch($which_page) {
			case 'binh-luan':
				$content_render['main_content'] = $this->_do_comment();
				break;
			default:
				if($which_page!=''  && $which_page!='english' && $which_page!='vietnamese') { // detail
					$content_render['main_content'] = $this->_news_detail($lang);
					$content_render['page_title'] = $this->_get_title_news_page();
					if($which_page=='trang' && $this->uri->segment(3)!='') {
						$content_render['main_content'] = $this->_news_list($lang, $this->uri->segment(3)); // list
						$content_render['page_title'] = $this->lang->line('paging_for_news').' '.$this->uri->segment(3).' &raquo; '.$this->lang->line('seo_news_page_title');
					}
				} else { // default
					$content_render['main_content'] = $this->_news_list($lang); // list
				}
		}
		
		if($content_render!='') return $content_render;
		else show_404();
		
	}
	
	private function _news_list($lang='', $page_number=0)
	{
		$this->load->helper('myhelp');
		$this->_render_data['promotion_latest'] = $this->model_news->get_promotion_latest(1, $lang);
		
		// loading effect sticky
		$this->_render_data['news_sticky_js'] = $this->_load_script_sticky('sidebar_ads');
		
		$promotion_id = 0;$ontop_id = 0;
		
		if($this->_render_data['promotion_latest']!=false) $promotion_id = $this->_render_data['promotion_latest']->event_id;
		
		$this->_render_data['news_ontop_latest'] = $this->model_news->get_news_ontop($promotion_id, 1, $lang);
		
		if($this->_render_data['news_ontop_latest']!=false) $ontop_id = $this->_render_data['news_ontop_latest']->event_id;
		
		$list_news_not_in = array($promotion_id, $ontop_id);
		
		$per_page = 8;
		$total_rows = $this->model_news->get_count_list_news($list_news_not_in);
		$pagination = $this->model_news->config_style_pagination($total_rows, 'tin-tuc', $per_page);
		
		$start = $pagination['start_page'];
		$limit = $pagination['per_page'];
		
		$this->_render_data['pagination'] = $pagination['links'];
		$this->_render_data['news_list'] = $this->model_news->get_list_news($list_news_not_in, $start, $limit, $lang);
		
		unset($pagination);
		$this->_render_data['short_desc_limit_mininews'] = 25;
		$this->_render_data['short_desc_limit_topnews'] = 50;
		$this->_render_data['short_desc_limit_promotion'] = 70;
		if($lang=='ENG') {
			$this->_render_data['short_desc_limit_mininews'] = 15;
			$this->_render_data['short_desc_limit_topnews'] = 45;
			$this->_render_data['short_desc_limit_promotion'] = 60;
		}
		
		$this->_render_data['sharethis_intializing'] = sharethis_loading_script();
		$this->_render_data['facebook_intializing'] = facebook_loading_script();
		
		return $this->load->view('main/index', $this->_render_data);
	}
	
	private function _news_detail($lang='') {
		
		$this->load->helper('isuzu_date');
		$this->load->helper('myhelp');
		
		$this->_render_data['facebook_intializing'] = facebook_loading_script();
		$this->_render_data['sharethis_intializing'] = sharethis_loading_script();
		
		$news_detail = $this->model_news->get_news_detail($this->uri->segment(2), $lang);
		$this->_render_data['news_detail'] = $news_detail;
		
		$event_id = $news_detail->event_id;
		$this->_render_data['allow_reg_event'] = $news_detail->event_reg_form;
		
		$this->_set_title_news_page($news_detail->event_title);
		unset($news_detail);
		
		// list city
		$this->load->helper('myhelp');
		
		// get comment
		$comment_show_limit = $this->isuzu_setting_data->get('comment_news_show');
		$this->_render_data['comment_list'] = $this->model_news->get_comment_by_news($event_id, $comment_show_limit);
		
		// registration for event
		$this->form_validation->set_rules('fullname', $this->lang->line('eventform_fullname'), 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('phone', $this->lang->line('eventform_phone'), 'required|numeric');
		$this->form_validation->set_rules('birthdate', $this->lang->line('eventform_birthdate'), 'required');
		
		$this->form_validation->set_message('required', $this->lang->line('form_message_required'));
		
		$this->form_validation->set_message('valid_email', $this->lang->line('form_message_validemail'));
		
		$this->form_validation->set_message('numeric', $this->lang->line('form_message_numeric'));
		
		if ($this->form_validation->run() !== FALSE) {
		
			if($this->input->post()) {
				
				$full_name = trim(htmlspecialchars($this->input->post('fullname')));
				$gender = trim(htmlspecialchars($this->input->post('gender')));
				$birthdate = trim(htmlspecialchars($this->input->post('birthdate')));
				$company = trim(htmlspecialchars($this->input->post('company')));
				$form_email = trim(htmlspecialchars($this->input->post('email')));
				$phone = trim(htmlspecialchars($this->input->post('phone')));
				$address = trim(htmlspecialchars($this->input->post('address')));
				$city = trim(htmlspecialchars($this->input->post('city')));
				$item_owner = trim(htmlspecialchars($this->input->post('model_owning')));
				$event_id = intval($event_id);
				$date_received = time();
		
				// saving
				$reg_event_id = $this->model_page->save_event_regform($full_name, $gender, $birthdate, $company, $form_email, $phone, $address, $city, $item_owner, $event_id, $date_received);
				if($reg_event_id > 0) $this->session->set_flashdata('success_comment', $this->lang->line('success_save_reg_form'));
			} else {
				$this->session->set_flashdata('failure_comment', $this->lang->line('failure_save_reg_form'));
			}
			
			redirect($this->uri->uri_string(), 'refresh');
		}
		
		// loading effect sticky
		$this->_render_data['news_sticky_js'] = $this->_load_script_sticky('sidebar_ads');
		
		return $this->load->view('main/detail', $this->_render_data);
	}
	
	private function _do_comment() {
		
		$this->form_validation->set_rules('authorname', $this->lang->line('author_name_field'), 'required');
		$this->form_validation->set_rules('email', $this->lang->line('email_field'), 'required');
		$this->form_validation->set_rules('comment', $this->lang->line('comment_content_field'), 'required');
		$this->form_validation->set_rules('news_no', $this->lang->line('event_selected_field'), 'required');

		if ($this->form_validation->run() !== FALSE) {
			if($this->input->post() && $this->input->post('authorname') != $this->lang->line('comment_fullname')) {
				
				$events_event_id = intval($this->input->post('news_no'));
				$cmt_author = trim(htmlspecialchars($this->input->post('authorname')));
				$cmt_email = trim(htmlspecialchars($this->input->post('email')));
				$cmt_content = trim($this->input->post('comment'));
				$cmt_ipaddress = trim(htmlspecialchars($this->input->ip_address()));
				$cmt_date = time() + (7*3600);
				$enable = '0';
		
				// saving
				$this->model_news->set_comment_by_news($events_event_id, $cmt_author, $cmt_email, $cmt_content, $cmt_ipaddress, $cmt_date, $enable);
				
				$this->session->set_flashdata('success_comment', $this->lang->line('success_post_comment'));
			} else {
				$this->session->set_flashdata('failure_comment', $this->lang->line('error_post_comment'));
			}
			
			redirect($this->input->server('HTTP_REFERER'), 'refresh');
		}
	}
	
	public function _render_sidebar() { // normally sidebar
		$sidebar_news_limit = $this->isuzu_setting_data->get('sidebar_show_news');
		$this->_render_data['sidebar_latest_news'] = $this->model_news->get_latest_news($sidebar_news_limit, $this->_cur_lang);
		return $this->load->view('widgets/sidebar', $this->_render_data);
	}
	
	public function _render_sidebar_detail() { // render sidebar detail page
		
		return $this->load->view('widgets/sidebar_detail', $this->_render_data);
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
	private function _get_title_news_page() {
		return $this->_news_title_page;
	}
	
	private function _set_title_news_page($title_page) {
		$this->_news_title_page = $title_page;
	}
}