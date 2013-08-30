<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mformmanage extends Admin_Controller {

	private $_push;
	
	public function __construct() {
		parent::__construct();
		$this->_post_handler();
		$this->load->model(array('admin_model_eventform', 'admin_model_driveform', 'admin_model_contact'));
		$this->load->helper(array('isuzu_image', 'isuzu_date', 'text', 'myhelp_helper'));
		$this->load->language('setting');
		
	}
	
	public function index()
	{
		$content_render = '';
		$which_page = $this->uri->segment(3);
		switch($which_page) {
			case 'event_reg':
				switch($this->uri->segment(4)) {
					case 'delete': $content_render = $this->_delete_event_reg(); break;
					case 'view': $content_render = $this->_view_event_reg(); break;
					case 'export': $content_render = $this->_export_event_reg(); break;
					default: $content_render = $this->_list_event_reg();
				}
				break;
			case 'test_drive_reg':
				switch($this->uri->segment(4)) {
					case 'delete': $content_render = $this->_delete_testdrive_reg(); break;
					case 'view': $content_render = $this->_view_testdrive_reg(); break;
					case 'export': $content_render = $this->_export_testdrive_reg(); break;
					default: $content_render = $this->_list_test_drive();
				}
				break;
			case 'contacter':
				switch($this->uri->segment(4)) {
					case 'delete': $content_render = $this->_delete_contact(); break;
					case 'view': $content_render = $this->_view_contact(); break;
					case 'export': $content_render = $this->_export_contact(); break;
					default:$content_render = $this->_list_contacts();
				}
				break;
			default: ;
		}
		
		if($content_render!='') return $content_render;
		else show_404();
	}
	
	private function _list_event_reg() {
		
		$this->redir->set_last_index();
		$this->load->model('news/admin_model_news');
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);
		
		$this->_push['regforms'] = $this->admin_model_eventform->get($params);
		
		return $this->load->view('admin/event/list', $this->_push);
	}
	
	private function _delete_event_reg()
	{
		$reg_id = uri_assoc('reg_id');

		if ($reg_id) {

			$this->admin_model_eventform->delete($reg_id);
		}

		$this->redir->redirect($this->uri->segment(1).'/form_management/event_reg/');
	}
	
	private function _view_event_reg()
	{
		$this->load->model('news/admin_model_news');
		$reg_id = uri_assoc('reg_id');
		
		$regformevent_params = array(
			'where'	=>	array(
				'reg_form_event.id' =>	$reg_id
			)
		);
		
		$this->_push['regformobj'] = $this->admin_model_eventform->get($regformevent_params);
		return $this->load->view('admin/event/form', $this->_push);
	}
	
	// export event reg form list
	private function _export_event_reg() {
        $query = $this->admin_model_eventform->get_data_to_export();
		$this->_export_to_csv_list($query, "csv_event_reg_list");
	}
	
	/* test drive registration */
	
	private function _list_test_drive() {
		$this->redir->set_last_index();
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);
		$this->_push['regforms'] = $this->admin_model_driveform->get($params);
		return $this->load->view('admin/drive/list', $this->_push);
	}
	
	private function _delete_testdrive_reg() {
		$reg_id = uri_assoc('reg_id');
		if ($reg_id) $this->admin_model_driveform->delete($reg_id);
		$this->redir->redirect($this->uri->segment(1).'/form_management/test_drive_reg/');
	}
	
	private function _view_testdrive_reg() {
		$reg_id = uri_assoc('reg_id');
		$regformdrive_params = array(
			'where'	=>	array(
				'reg_form_drive.id' =>	$reg_id
			)
		);
		$this->_push['regformobj'] = $this->admin_model_driveform->get($regformdrive_params);
		return $this->load->view('admin/drive/form', $this->_push);
	}
	
	// export testdrive list
	private function _export_testdrive_reg() {
        $query = $this->admin_model_driveform->get_data_to_export();
		$this->_export_to_csv_list($query, "csv_testdrive_reg_list");
	}
	
	/* contacter */
	private function _list_contacts()
	{
		
		$this->redir->set_last_index();
		
		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->isuzu_setting_data->setting('results_per_page'),
			'page'		=>	uri_assoc('page')
		);

		$this->_push['contacts'] = $this->admin_model_contact->get($params);
		
		return $this->load->view('admin/contact/list', $this->_push);
	}
	
	private function _delete_contact()
	{
		$contact_id = uri_assoc('contact_id');

		if ($contact_id) {

			$this->admin_model_contact->delete($contact_id);
			
		}

		$this->redir->redirect($this->uri->segment(1).'/form_management/contacter');
	}
	
	private function _view_contact() {
		
		
		$contact_id = uri_assoc('contact_id');
		
		$contact_params = array(
			'where'	=>	array(
				'contacts.contact_id' =>	$contact_id
			)
		);
		
		$this->_push['contactformobj'] = $this->admin_model_contact->get($contact_params);
		return $this->load->view('admin/contact/form', $this->_push);
	}
	
	// export testdrive list
	private function _export_contact() {
        $query = $this->admin_model_contact->get_data_to_export();
		$this->_export_to_csv_list($query, "csv_contact_list");
	}
	
	/*####################### private controller supporting function #####################*/
	private function _export_to_csv_list($data_result, $file_name) {
		if($data_result!=false) {
			
			$this->load->dbutil();
			$this->load->helper('download');
			
			$delimiter = "\t";
			$newline = "\r\n";
			
			$dataforcsv = $this->dbutil->csv_from_result($data_result, $delimiter, $newline);
			//$dataforcsv = mb_convert_encoding($dataforcsv, 'UCS-2LE', 'UTF-8'); // for excel format
			$dataforcsv = chr(255).chr(254).mb_convert_encoding($dataforcsv, "UTF-16LE", "UTF-8");
			force_download($file_name.'.csv', $dataforcsv); // direct view/download file
			unset($dataforcsv);
		}
		else show_error('Data list is null to export');
		exit();
	}
	
	/* post handler*/
	function _post_handler() {
		
		if ($this->input->post('btn_cancel')) {
			redirect($this->session->userdata('last_index'));

		}

	}
	
}

/* End of file mformmanage.php */
/* Location: ./application/controllers/mformmanage.php */