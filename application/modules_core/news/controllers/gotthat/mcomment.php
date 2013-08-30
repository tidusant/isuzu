<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mcomment extends Admin_Controller {
	
	private $_push;
	
	public function __construct()
	{
		parent::__construct();
		$this->_post_handler();
		$this->load->model('admin_model_comment');
		$this->load->helper(array('isuzu_image', 'isuzu_date', 'text', 'myhelp_helper'));
		$this->load->language('news');
		
	}
	
	public function index() { // list
		
		$which_page = $this->uri->segment(3);
		$content_render = '';
		
		switch($which_page) {
			case 'form':
				$content_render = $this->_manage_comment();// add or edit
				break;
			case 'delete':
				$this->_delete_comment();// delete
			case 'approve':
				$this->_approve_comment(); // approve
				break;
			case 'unapprove':
				$this->_unapprove_comment(); // unapprove
				break;
			case 'browse':
				$content_render = $this->_browse_comment();
				break;
			default:
				$content_render = $this->_list_comment(); // just list user
		}
		
		if($content_render!='') return $content_render;
		else show_404();
		
	}
	
	private function _list_comment() {
		
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);

		$this->_push['comments'] = $this->admin_model_comment->get($params);

		return $this->load->view('admin/comment/list', $this->_push);
	}
	
	private function _manage_comment() {
		
		$this->_push['action_type'] = $this->lang->line('editing_action');
		
		$cmt_id = uri_assoc('cmt_id');

		if ($this->admin_model_comment->validate()) {

			$this->admin_model_comment->save();

			$cmt_id = ($cmt_id) ? $cmt_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('cmt_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('comment_module'), $log_action_type, $this->lang->line('comment_author').': '.$this->admin_model_comment->form_value('cmt_author').' at '.format_date(time()));
			
			redirect($this->uri->segment(1).'/comment/index');

		}

		else {

			if (!$_POST AND $cmt_id) {
				
				$this->admin_model_comment->prep_validation($cmt_id);
				
			}

			$cmt_id = uri_assoc('cmt_id');

			$cmt_params = array(
				'where'	=>	array(
					'event_comments.cmt_id'	=>	$cmt_id
				)
			);
			
			$this->_push['commentobj'] = $this->admin_model_comment->get($cmt_params);
			
			return $this->load->view('admin/comment/form', $this->_push);

		}

	}
	
	private function _approve_comment()
	{
		$cmt_id = uri_assoc('cmt_id');
		
		$db_array['enable'] = '1';
		
		$this->admin_model_comment->save($db_array);
		
		$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('comment_module'), $log_action_type, 'Approved comment # '.$cmt_id.' at '.format_date(time()));
		
		$this->session->set_flashdata('success_save', $this->lang->line('this_comment_has_been_approved'));
		
		redirect($this->uri->segment(1).'/comment/index');
	}
	
	private function _unapprove_comment()
	{
		$cmt_id = uri_assoc('cmt_id');
		
		$db_array['enable'] = '0';
		
		$this->admin_model_comment->save($db_array);
		
		$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('comment_module'), $log_action_type, 'Unapproved comment # '.$cmt_id.' at '.format_date(time()));
		
		$this->session->set_flashdata('success_save', $this->lang->line('this_comment_has_been_unapproved'));
		
		redirect($this->uri->segment(1).'/comment/index');
	}
	
	private function _browse_comment()
	{
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);
		// browse to belong which categories
		$browsetype = $this->uri->segment(4);
		$news_id = uri_assoc('news_id');
		if($browsetype=='news_id' && $news_id!==NULL) {
			$params['where']['event_comments.events_event_id'] = $news_id;
		}
		
		$this->redir->set_last_index();

		$this->_push['comments'] = $this->admin_model_comment->get($params);

		return $this->load->view('admin/comment/list', $this->_push);
		
	}
	
	private function _delete_comment() {

		$cmt_id = uri_assoc('cmt_id');

		if ($cmt_id) {

			$this->admin_model_comment->delete($cmt_id);
			
			$cmtinfoarr = $this->admin_model_comment->get_comment_info($cmt_id);
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('comment_module'), 'Deleted', $this->lang->line('comment_author').': '.$cmtinfoarr->cmt_author.'-'.$this->lang->line('comment_email').': '.$cmtinfoarr->cmt_email.' from IP: '.$cmtinfoarr->cmt_ipaddress.' at '.format_date(time()));
			
		}

		$this->redir->redirect($this->uri->segment(1).'/comment/index');
	}
	
	function _post_handler() {

		if ($this->input->post('btn_cancel')) {

			redirect($this->session->userdata('last_index'));

		}

	}
}