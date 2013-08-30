<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Model_Member extends MY_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'isuzu_systemusers';
		$this->primary_key = 'isuzu_systemusers.id';
		$this->order_by = 'isuzu_systemusers.lastlogin';
	}
	
	public function get_total_member()
	{
		return $this->db->count_all_results($this->table_name);
	}
	
	public function get_group_list()
	{
		$this->db->select('group_id, group_name, active');
		$this->db->from('isuzu_systemusergroup');
		$this->db->where('group_id <> ', 1); // master admin
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query; 
		else return false;
	}
	
	public function get_level_name($group_id)
	{
		$this->db->select('group_name');
		$this->db->from('isuzu_systemusergroup');
		$this->db->where('group_id', $group_id);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row()->group_name;
		return 'none';
	}
	
	public function get_list_member()
	{
		$this->db
			->select('isuzu_systemusers.id, isuzu_systemusers.su_fullname, isuzu_systemusers.su_email')
			->from('isuzu_systemusers')
			->where('isuzu_systemusers.active', '1')
			->where('isuzu_systemusers.group_id <> ', 1)
			->order_by('isuzu_systemusers.lastlogin', 'DESC');
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function validate() {

		$this->form_validation->set_rules('su_email', $this->lang->line('member_email'), 'required|trim|callback_useremail_check');
		$this->form_validation->set_rules('su_fullname', $this->lang->line('member_name'), 'required|trim|callback_username_check');

		if (!uri_assoc('member_id')) {

			$this->form_validation->set_rules('su_password', $this->lang->line('member_password'), 'required');
			$this->form_validation->set_rules('passwordv', $this->lang->line('member_password_verify'), 'required|matches[su_password]');

		}
		
		$this->form_validation->set_rules('group_id', $this->lang->line('member_level'));
		$this->form_validation->set_rules('display_order', $this->lang->line('member_priority'));
		$this->form_validation->set_rules('active', $this->lang->line('member_active'));
		
		return parent::validate($this);

	}

	public function username_check($username) {

		$this->db->where('su_fullname', $username);

		if (uri_assoc('member_id')) {

			$this->db->where('id <>', uri_assoc('member_id'));

		}

		elseif ($this->uri->segment(2) == 'profile') {

			$this->db->where('id <>', $this->session->userdata('member_id'));

		}

		$query = $this->db->get($this->table_name);

		if ($query->num_rows()) {

			$this->form_validation->set_message('username_check', $this->lang->line('username_already_exists'));

			return FALSE;

		}

		return TRUE;

	}
	
	public function useremail_check($useremail) {

		$this->db->where('su_email', $useremail);

		if (uri_assoc('member_id')) {

			$this->db->where('id <>', uri_assoc('member_id'));

		}

		elseif ($this->uri->segment(2) == 'profile') {

			$this->db->where('id <>', $this->session->userdata('member_id'));

		}

		$query = $this->db->get($this->table_name);

		if ($query->num_rows()) {

			$this->form_validation->set_message('useremail_check', $this->lang->line('useremail_already_exists'));

			return FALSE;

		}

		return TRUE;

	}

	public function save($db_array, $user_id = NULL) {
		
		// password processing
		
		if($user_id==NULL) {
			
			$this->load->model('auth/isuzu_auth');
			$db_array['su_salt'] = $this->get_salt();
			
			$userarr = array('salt'=>$db_array['su_salt'],
							'fullname'=>$db_array['su_fullname']);
							
			$db_array['su_password'] = $this->isuzu_auth->encrypt($this->input->post('su_password', TRUE), $userarr);
			
			unset($userarr);
		}
		
		unset($db_array['passwordv']);
		
		parent::save($db_array, $user_id);
		
		
		if (!$user_id) {

			$user_id = $this->db->insert_id();

		}

		return $user_id;

	}

	public function validate_change_password() {

		$this->form_validation->set_rules('new_password', $this->lang->line('new_password'), 'required');
		$this->form_validation->set_rules('new_passwordv', $this->lang->line('new_password_verify'), 'required|matches[new_password]');

		return parent::validate();

	}

	public function get_email_address($user_id) {

		$this->db->select('su_email');

		$this->db->where('Id', $user_id);

		return $this->db->get('isuzu_systemusers')->row()->UserEmail;

	}
	
	public function get_username($user_id) {

		$this->db->select('su_fullname');

		$this->db->where('id', $user_id);
		
		$query = $this->db->get('isuzu_systemusers')->row();
		
		if(count($query) > 0) return $query->su_fullname;
		else return 'None';

	}

	public function delete($user_id) {

		if ($user_id) {

			if ($user_id == $this->session->userdata('member_id')) {

				$this->session->set_flashdata('custom_error', $this->lang->line('cannot_delete_user_account') . '.');

			}

			else {

				parent::delete(array('id'=>$user_id));

			}

		}

	}
	
	public function get_salt()
	{
		return substr(md5(uniqid(rand(), TRUE)), 0, 15);
	}
	
	// profile user checking
	public function logged_in()
	{
		if($this->session->userdata('logged_in') === TRUE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function restrict($group = NULL)
	{
		if($group === NULL)
		{
			if($this->logged_in() == TRUE)
			{
				return TRUE;
			}
			else
			{
				show_error($this->lang->line('insufficient_privs'));
			}
		}
		elseif($this->logged_in() == TRUE)
		{
			$this->load->model('admin_model_membergroup');
			$level_id = $this->admin_model_membergroup->get_groupid_by_slug($group);
			$user_level_id = $this->session->userdata('user_level');
			
			if($user_level_id > $level_id && $user_level !== $level)
			{
				show_error($this->lang->line('insufficient_privs'));
			}
			
			return TRUE;
		}
		else
		{
			redirect('/auth/login', 'refresh');
		}
	}
	
}