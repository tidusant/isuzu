<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mbannerposition extends Admin_Controller {
	
	private $_push;
	
	function __construct() {

		parent::__construct();
		$this->_post_handler();
		$this->load->model('admin_model_bannerposition');
		$this->load->helper(array('isuzu_image', 'isuzu_date'));
		$this->load->language('banner');
		
		// menu render
		$this->_push = array(
			'menu_render' => $this->render_menu()
		);
	}
	
	public function index() { // list
		
		$this->load->helper('text');
		$this->redir->set_last_index();
		
		$this->_push['bannerposition'] = $this->admin_model_bannerposition->get();

		$this->load->view('admin/bp/list', $this->_push);
		
	}
	
	public function form() {
		
		$this->_push['action_type'] = 'Edit';
		
		$bp_id = uri_assoc('bp_id');

		if ($this->admin_model_bannerposition->validate()) {

			$this->admin_model_bannerposition->save();

			$bp_id = ($bp_id) ? $bp_id : $this->db->insert_id();

			redirect('banners/gotthat/mbannerposition');

		}

		else {

			if (!$_POST AND $bp_id) {

				$this->admin_model_bannerposition->prep_validation($bp_id);
				
			} else {
				
				$this->_push['action_type'] = 'Add';
				
			}

			$this->load->helper('text');
			
			$this->load->view('admin/bp/form', $this->_push);

		}

	}

	public function delete() {

		$bp_id = uri_assoc('bp_id');

		if ($bp_id) {

			$this->admin_model_bannerposition->delete($bp_id);

		}

		$this->redir->redirect('banners/gotthat/mbannerposition');
	}
	
	public function get($params = NULL) {

		return $this->admin_model_bannerposition->get($params);

	}

	function _post_handler() {

		if ($this->input->post('btn_add_client')) {

			redirect('banners/gotthat/mbannerposition/form');

		}

		elseif ($this->input->post('btn_cancel')) {

			redirect($this->session->userdata('last_index'));

		}

	}
}

/* End of file Mbanners.php */
/* Location: ./application/controllers/Mbanners.php */