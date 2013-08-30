<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mcategory extends Admin_Controller {
	
	private $_push;
	
	function __construct()
	{
		parent::__construct();
		$this->_post_handler();
		$this->load->model('admin_model_category');
		$this->load->helper(array('isuzu_date', 'text'));
		$this->load->language('product');
	}

	public function index() {
		
		$which_page = $this->uri->segment(3);
		$content_render = '';
		
		switch($which_page) {
			case 'form':
				$content_render = $this->_manage_category();// add or edit
				break;
			case 'delete':
				$content_render = $this->_delete_category();// delete
				break;
			case 'gallery':
				switch($this->uri->segment(4)) {
					case 'form':
						$content_render = $this->_manage_cate_gallery();
						break;
					case 'delete':
						$content_render = $this->_delete_cate_gallery();
						break;
					default: $content_render = $this->_list_cate_gallery();
				}
				break;
			case 'pattern':
				switch($this->uri->segment(4)) {
					case 'form':
						$content_render = $this->_manage_cate_pattern();
						break;
					case 'delete':
						$content_render = $this->_delete_cate_pattern();
						break;
					default: $content_render = $this->_list_cate_pattern();
				}
				break;
			case 'pattern-group':
				switch($this->uri->segment(4)) {
					case 'form':
						$content_render = $this->_manage_pattern_group();
						break;
					case 'delete':
						$content_render = $this->_delete_pattern_group();
						break;
					default: $content_render = $this->_list_pattern_group();
				}
				break;
			default:
				$content_render = $this->_list_category(); // just list user
		}
		
		if($content_render!='') return $content_render;
		else show_404();
		
	}
	
	/*############################### CATEGORY ############################*/
	private function _list_category()
	{
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);

		$this->_push['categories'] = $this->admin_model_category->get($params);

		return $this->load->view('admin/category/list', $this->_push);
	}
	
	private function _manage_category() {
		
		$cate_id = uri_assoc('cate_id');
		
		$this->load->helper('isuzu_js');
		$this->load->model('admin_model_categallery');
		
		$this->_push['action_type'] = $this->lang->line('editing_action');
		
		$this->_push['extended_js'] = load_extended_js('category_name'); // generate slug
		
		$this->_push['tinymce_init'] = load_tinymce_plugin(); // load textarea editor
		
		// slide banner category
		$this->_push['slide_images_list'] = $this->admin_model_categallery->get_list_gallery_type('cate-slide');
		// gallery category
		$this->_push['gallery_images_list'] = $this->admin_model_categallery->get_list_gallery_type('cate-gallery');
		
		
		if ($this->admin_model_category->validate()) {

			$this->admin_model_category->save();

			$cate_id = ($cate_id) ? $cate_id : $this->db->insert_id();
			
			$log_action_type = (!uri_assoc('cate_id')) ? 'Added' : 'Edited';
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('category_module'), $log_action_type, $this->lang->line('category_name').': '.$this->admin_model_category->form_value('pc_name').' at '.format_date(time()));
			
			redirect($this->uri->segment(1).'/catalog/index');

		}

		else {

			if (!$_POST AND $cate_id) $this->admin_model_category->prep_validation($cate_id);
			else $this->_push['action_type'] = $this->lang->line('adding_action');
			
			// get lang
			$this->_push['catalogobj_en'] = $this->admin_model_category->get_cate_lang($cate_id);
			
			return $this->load->view('admin/category/form', $this->_push);

		}

	}
	
	private function _delete_category() {
		
		$cate_id = uri_assoc('cate_id');

		if ($cate_id) {

			$this->admin_model_category->delete($cate_id);
			
			$this->isuzu_setting_data->save_logs($this->session->userdata('member_id'), $this->lang->line('category_module'), 'Deleted', $this->lang->line('category_name').': '.$this->admin_model_category->get_category_name($cate_id).' at '.format_date(time()));
			
		}

		$this->redir->redirect($this->uri->segment(1).'/catalog/index');
	}
	
	/*############################### CATEGORY GALLERY ############################*/
	private function _list_cate_gallery() {
		$this->load->model('admin_model_categallery');
		$this->redir->set_last_index();
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);
		$this->_push['galleries'] = $this->admin_model_categallery->get($params);
		return $this->load->view('admin/category/gallery/list', $this->_push);
	}
	
	private function _manage_cate_gallery() {
		$this->_push['action_type'] = $this->lang->line('editing_action');
		$this->load->model('admin_model_categallery');
		$cgal_id = uri_assoc('cgal_id');
		if ($this->admin_model_categallery->validate()) {
			$this->admin_model_categallery->save();
			redirect($this->uri->segment(1).'/catalog/gallery/index');
		}
		else {
			if (!$_POST AND $cgal_id) {
				$this->admin_model_categallery->prep_validation($cgal_id);
			} else {
				$this->_push['action_type'] = $this->lang->line('adding_action');	
			}
			
			return $this->load->view('admin/category/gallery/form', $this->_push);
		}
	}
	
	private function _delete_cate_gallery() {
		
		$cgal_id = uri_assoc('cgal_id');
		if($cgal_id) {
			$this->load->model('admin_model_categallery');
			
			$folder_relative_path = str_replace(base_url(), $this->config->item('upload_relative_path'), $this->admin_model_categallery->get_categallery_foldername($cgal_id));
			
			$this->load->helper('myhelp_helper');
			do_delete_folder_n_file($folder_relative_path);
			
			$this->admin_model_categallery->delete($cgal_id);
		}
		
		$this->redir->redirect($this->uri->segment(1).'/catalog/gallery/index');
	}
	
	/*############################### CATEGORY PATTERN ############################*/
	private function _list_cate_pattern() {
		$cate_id = 0;
		if($this->uri->segment(5) != '') $cate_id = $this->uri->segment(5);
		$this->load->model('admin_model_pattern');
		$this->redir->set_last_index();
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page'),
		);
		$params['where'] = array('product_cate_pc_id'=>$cate_id);
		$this->_push['pattern'] = $this->admin_model_pattern->get($params);
		return $this->load->view('admin/category/pattern/list', $this->_push);
	}
	
	private function _manage_cate_pattern() {
		$this->load->model('admin_model_pattern');
		$this->_push['action_type'] = $this->lang->line('editing_action');
		$this->_push['catalog_list'] = $this->admin_model_category->get_list_categories();
		$this->_push['pattern_group_list'] = $this->admin_model_category->get_pattern_group();
		$pat_id = uri_assoc('pat_id');
		if ($this->admin_model_pattern->validate()) {
			$this->admin_model_pattern->save();
			$breadcum = 1;
			if(uri_assoc('cate_id')) $breadcum = uri_assoc('cate_id');
			elseif(uri_assoc('pat_id')) $breadcum = $this->admin_model_pattern->form_value('product_cate_pc_id');
			redirect($this->uri->segment(1).'/catalog/pattern/index/'.$breadcum);
		}
		else {
			if (!$_POST AND $pat_id) {
				$this->admin_model_pattern->prep_validation($pat_id);
			} else {
				$this->_push['action_type'] = $this->lang->line('adding_action');	
			}
			
			$this->_push['patterntech_obj_en'] = $this->admin_model_pattern->get_pattern_lang($pat_id);
			return $this->load->view('admin/category/pattern/form', $this->_push);
		}
	}
	
	private function _delete_cate_pattern() {
		$this->load->model('admin_model_pattern');
		if(uri_assoc('pat_id')) $this->admin_model_pattern->delete(uri_assoc('pat_id'));
		$this->redir->redirect($this->uri->segment(1).'/catalog/pattern/index/'.uri_assoc('cate_id'));
	}
	
	/*############################### CATEGORY PATTERN ############################*/
	private function _list_pattern_group() {
		
		$this->redir->set_last_index();
		$this->_push['pattern_group'] = $this->admin_model_category->get_pattern_group();
		return $this->load->view('admin/category/patterngroup/list', $this->_push);
	}
	
	private function _manage_pattern_group() {
		$this->load->model('admin_model_patterngroup');
		$this->_push['action_type'] = $this->lang->line('editing_action');
		$group_id = uri_assoc('group_id');
		if ($this->admin_model_patterngroup->validate()) {
			$this->admin_model_patterngroup->save();
			redirect($this->uri->segment(1).'/catalog/pattern-group/index');
		}
		else {
			if (!$_POST AND $group_id) {
				$this->admin_model_patterngroup->prep_validation($group_id);
			} else {
				$this->_push['action_type'] = $this->lang->line('adding_action');	
			}
			
			$this->_push['group_name_en'] = $this->admin_model_patterngroup->get_group_lang($group_id);
			return $this->load->view('admin/category/patterngroup/form', $this->_push);
		}
	}
	
	private function _delete_pattern_group() {
		$this->load->model('admin_model_patterngroup');
		if(uri_assoc('group_id')) $this->admin_model_patterngroup->delete(uri_assoc('group_id'));
		$this->redir->redirect($this->uri->segment(1).'/catalog/pattern/index');
	}
	
	function _post_handler() {
		
		if ($this->input->post('btn_cancel')) {
			
			redirect($this->session->userdata('last_index'));

		}

	}
}