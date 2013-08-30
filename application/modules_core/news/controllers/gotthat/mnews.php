<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mnews extends MX_Controller {
	
	private $_push;
	
	public function __construct() {
		
		parent::__construct();
		$this->_post_handler();
		$this->load->model('admin_model_news');
		$this->load->helper(array('isuzu_image', 'isuzu_date', 'text', 'myhelp_helper'));
		$this->load->language('news');
		
	}
	
	public function index() { // list
		
		$which_page = $this->uri->segment(3);
		$content_render = '';
		
		switch($which_page) {
			case 'form':
				$content_render = $this->_manage_news();// add or edit
				break;
			case 'delete':
				$this->_delete_news();// delete
			case 'comment':
				break;
			default:
				$content_render = $this->_list_news(); // just list user
		}
		
		if($content_render!='') return $content_render;
		else show_404();
		
	}
	
	private function _list_news() {
		
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);

		$this->_push['news'] = $this->admin_model_news->get($params);

		return $this->load->view('admin/news/list', $this->_push);
	}
	
	private function _manage_news() {
		
		$this->load->helper('isuzu_js');
		
		$this->_push['action_type'] =  $this->lang->line('editing_action');
		
		$this->_push['extended_js'] = load_extended_js('news_name'); // generate slug
		
		$this->_push['tinymce_init'] = load_tinymce_plugin();
		
		$news_id = uri_assoc('news_id');

		if ($this->admin_model_news->validate()) {

			$this->admin_model_news->save();

			$news_id = ($news_id) ? $news_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('news_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('news_module'), $log_action_type, $this->lang->line('news_name').': '.$this->admin_model_news->form_value('event_title').' at '.format_date(time()));
			
			redirect($this->uri->segment(1).'/news/index');

		}

		else {

			if (!$_POST AND $news_id) {

				$this->admin_model_news->prep_validation($news_id);
				
			} else {
				
				$this->_push['action_type'] = $this->lang->line('adding_action');
				
			}
			
			// get lang
			$this->_push['newsobj_en'] = $this->admin_model_news->get_news_lang($news_id);
			
			return $this->load->view('admin/news/form', $this->_push);

		}

	}

	private function _delete_news() {

		$news_id = uri_assoc('news_id');

		if ($news_id) {

			$this->admin_model_news->delete($news_id);
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('news_module'), 'Deleted', $this->lang->line('news_name').': '.$this->admin_model_news->get_news_title($news_id).' at '.format_date(time()));
			
		}

		$this->redir->redirect($this->uri->segment(1).'/news/index');
	}
	 
	function _post_handler() {

		if ($this->input->post('btn_cancel')) {

			redirect($this->session->userdata('last_index'));

		}

	}
	
}