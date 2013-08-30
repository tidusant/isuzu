<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_producttech extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'product_tech';
		$this->primary_key = 'product_tech.techinfo_id';
		$this->order_by = 'product_tech.updated_on desc';
		
	}
	
	public function get_active($params = NULL) { //  all

		if (!$params) {

			$params = array(
				'where'	=>	array(
					'active'	=>	1
				)
			);

		}

		else {

			$params['where']['active'] = 1;

		}

		return $this->get($params);

	}

	public function delete($pt_id) {
		parent::delete(array('techinfo_id'=>$pt_id));
	}

	public function save($db_array = NULL, $pt_id) {
		
		// date create - update
		$db_array['created_on'] = time();
		$db_array['updated_on'] = time();
		
		parent::save($db_array, $pt_id);
		
		
	}
}