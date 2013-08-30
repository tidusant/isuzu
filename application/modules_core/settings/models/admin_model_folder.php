<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Admin_model_folder extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->load->helper('isuzu_dir');
		$this->table_name = 'folders';

		$this->primary_key = 'folders.folder_id';
		$this->order_by = 'folders.created_on DESC';
	}
	

	public function delete($folder_id) {
		
		parent::delete(array('folder_id'=>$folder_id));
	}
  
	public function save($db_array = NULL) {

		if (!$db_array) {

			$db_array = parent::db_array();

		}
		
		
		parent::save($db_array, uri_assoc('folder_id'));
		
	}
}

?>