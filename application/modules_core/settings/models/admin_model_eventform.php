<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Admin_model_eventform extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'reg_form_event';

		$this->primary_key = 'reg_form_event.id';
		$this->order_by = 'reg_form_event.date_received DESC';
	}
	
	
	public function get_data_to_export()
	{
		$this->db->select($this->table_name.'.full_name as Name,'.$this->table_name.'.company as Company,'.$this->table_name.'.form_email as Email,'.$this->table_name.'.phone as Phone,'.$this->table_name.'.address as Address,'.$this->table_name.'.city as City,'.$this->table_name.'.item_owner as Owner');
		
		$this->db->select('FROM_UNIXTIME('.$this->table_name.'.birthdate, \'%d-%m-%Y\') as `Birth Date`', false);
		
		$this->db->select('(select events.event_title from events where events.event_id = '.$this->table_name.'.event_id) As `Event Registered`');
		
		$this->db->select('case '.$this->table_name.'.gender 
			when \'1\' then \'Male\'
			when \'0\' then \'Female\'
		else \'Unknow\' end as Gender', false);
		
		$this->db->select('FROM_UNIXTIME('.$this->table_name.'.date_received, \'%d-%m-%Y\') as `Date Registered`', false);
		
		$this->db->order_by($this->order_by);
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function delete($reg_id) {
		
		parent::delete(array('id'=>$reg_id));
	}

	public function save($db_array = NULL) {

		if (!$db_array) {

			$db_array = parent::db_array();

		}
		
		parent::save($db_array, uri_assoc('reg_id'));
		
	}
}

?>