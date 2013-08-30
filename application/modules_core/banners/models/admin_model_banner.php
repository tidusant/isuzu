<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_banner extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'banners';

		$this->primary_key = 'banners.banner_id';
		$this->order_by = 'banners.banner_id desc';
	}
	
	public function get($params = NULL) {

		$banners = parent::get($params);

		return $banners;

	}

	public function validate() {
		$this->form_validation->set_rules('banner_title', $this->lang->line('banner_title'), 'trim|required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('banner_link_image', 'Image', 'trim|required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('banner_link', $this->lang->line('banner_link'), 'trim|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('position_id', $this->lang->line('banner_position'), 'trim|required|xss_clean');
		$this->form_validation->set_rules('display_order', $this->lang->line('banner_priority'), 'trim|numeric|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('active', $this->lang->line('banner_active'));
		
		return parent::validate($this);

	}

	public function delete($banner_id) {

		/* Delete the client record */
		parent::delete(array('banner_id'=>$banner_id));
	}

	public function save($db_array = NULL) {

		if (!$db_array) {

			$db_array = parent::db_array();

		}
		
		// date - upload file
		$db_array['created_on'] = time();
		$db_array['updated_on'] = time();
		
			
		if (!$this->input->post('active') and !isset($db_array['active'])) {

			$db_array['active'] = 0;

		}
		
		parent::save($db_array, uri_assoc('banner_id'));
		
	}
	
}
