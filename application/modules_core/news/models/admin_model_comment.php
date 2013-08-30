<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_comment extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'event_comments';

		$this->primary_key = 'event_comments.cmt_id';
		$this->order_by = 'event_comments.cmt_date desc';
	}
	
	public function get_total_comment()
	{
		return $this->db->count_all_results($this->table_name);
	}
	
	public function get_list_cmt()
	{
		$this->db->select('cmt_id, cmt_author, cmt_email, cmt_ipaddress, cmt_date');
		$this->db->from($this->table_name);
		$this->db->where('enable', '1');
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		return false;
	}
	
	public function get_cmt_active($params = NULL) { //  all

		if (!$params) {

			$params = array(
				'where'	=>	array(
					'enable'	=>	1
				)
			);

		}

		else {

			$params['where']['enable'] = 1;

		}

		return $this->get($params);

	}
	
	public function get_comment_info($cmt_id)
	{
		$this->db->select('cmt_author, cmt_email, cmt_ipaddress');
		$this->db->from($this->table_name);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row();
		return false;
	}
	
	public function get_cmt_count($event_id)
	{
		
		if($event_id!='') $this->db->where('events_event_id', $event_id);
		
		$this->db->where('enable', '1');
		
		return $this->db->count_all_results($this->table_name);
		
	}
	
	// add - edit action
	public function validate() {
		
		$this->form_validation->set_rules('cmt_author', $this->lang->line('comment_author'), 'required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('cmt_email', $this->lang->line('comment_email'), 'required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('cmt_content', $this->lang->line('comment_content'), 'required|xss_clean');
		$this->form_validation->set_rules('cmt_date', $this->lang->line('comment_date'));
		$this->form_validation->set_rules('enable', $this->lang->line('comment_active'));
		
		return parent::validate($this);

	}

	public function delete($cmt_id) {

		/* Delete the client record */
		parent::delete(array('cmt_id'=>$cmt_id));
	}

	public function save($db_array = NULL) {

		if (!$db_array) {

			$db_array = parent::db_array();

		}
		
		// date
		$db_array['cmt_date'] = time();
			
		if (!$this->input->post('enable') and !isset($db_array['enable'])) {

			$db_array['enable'] = 0;

		}

		parent::save($db_array, uri_assoc('cmt_id'));

	}
	
}