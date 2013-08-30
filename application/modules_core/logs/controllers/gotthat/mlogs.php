<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mlogs extends MX_Controller {

	private $_push;
	
	function __construct() {
		parent::__construct();
		$this->load->model('admin_model_log');
		$this->load->helper(array('isuzu_image', 'isuzu_date', 'text'));
		$this->load->language('log');
	}
	
	function index() {
		
		$content_render = $this->_list_log();
		
		if($content_render!='') return $content_render;
		else show_404();
	}
	
	private function _list_log()
	{
		
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);

		$this->_push['logs'] = $this->admin_model_log->get($params);

		return $this->load->view('admin/list', $this->_push);
	}
	
}

/* End of file logs.php */
/* Location: ./application/controllers/logs.php */