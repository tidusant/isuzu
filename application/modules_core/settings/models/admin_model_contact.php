<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Admin_model_contact extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'contacts';

		$this->primary_key = 'contacts.contact_id';
		$this->order_by = 'contacts.date_received DESC';
	}
	
	public function get_data_to_export()
	{
		$this->db->select($this->table_name.'.fullname as Name,'.$this->table_name.'.company as Company,'.$this->table_name.'.email as Email,'.$this->table_name.'.phone as Phone, '.$this->table_name.'.fax as Fax, '.$this->table_name.'.address as Address,'.$this->table_name.'.subject as Subject, '.$this->table_name.'.content as Content');
		
		$this->db->select('FROM_UNIXTIME('.$this->table_name.'.date_received, \'%d-%m-%Y\') as `Date Contact`', false);
		
		$this->db->order_by($this->order_by);
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function delete($contact_id) {
		
		parent::delete(array('contact_id'=>$contact_id));
	}

	public function save($db_array = NULL) {

		if (!$db_array) {

			$db_array = parent::db_array();

		}
		
		parent::save($db_array, uri_assoc('contact_id'));
		
	}
}

?>