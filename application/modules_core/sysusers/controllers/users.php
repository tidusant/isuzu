<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends Admin_Controller {

	function __construct() {

		parent::__construct();

	}
	
	function index() {
	//	$this->_post_handler();
        $this->redir->set_last_index();
        $this->load->helper('text');
		
		/* $this->load->model(
			array(
			'invoices/mdl_invoices',
			'templates/mdl_templates'
			)
		);

		if ($this->mdl_mcb_data->setting('dashboard_show_open_invoices') == 'TRUE') {

			$data['open_invoices'] = $this->mdl_invoices->get_recent_open();

		}

		if ($this->mdl_mcb_data->setting('dashboard_show_quotes') == 'TRUE') {

			$data['quotes'] = $this->mdl_invoices->get_quotes();

		} */
		
		$data = '';
		$this->load->view('main/index', $data);

	}
	
	function transcript() {}
	
	function educationhistory() {}
	
	function documentation() {}
	
	function lists() {}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */