<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Isuzu_Auth extends MY_Model {
	
	protected $encryption_key;
	
	public function __construct()
	{		
		parent::__construct();
		
		$this->load->library('encrypt');
		
		$this->encryption_key = config_item('encryption_key');
	}
	
	public function encrypt($password, $user)
	{
		
		$hash 	= $this->encrypt->sha1($user['fullname'] . $user['salt']);
		$key 	= $this->encrypt->sha1($this->encryption_key . $hash);

		return $this->encrypt->encode($password, substr($key, 0, 56));
	}
	
	public function decrypt($password, $user)
	{
		
		$hash 	= $this->encrypt->sha1($user['fullname'] . $user['salt']);
		$key 	= $this->encrypt->sha1($this->encryption_key . $hash);

		return $this->encrypt->decode($password, substr($key, 0, 56));
	}
	
	public function find_member_info($useremail)
	{
		$this->db->select('isuzu_systemusers.id as member_id, isuzu_systemusers.su_email as email, isuzu_systemusers.su_password as password, isuzu_systemusers.su_fullname as fullname, isuzu_systemusers.su_salt as salt, isuzu_systemusergroup.group_id as user_level');
		$this->db->from('isuzu_systemusers');
		$this->db->join('isuzu_systemusergroup', 'isuzu_systemusergroup.group_id=isuzu_systemusers.group_id','left');
		$this->db->where(array('isuzu_systemusers.active'=>'1', 'isuzu_systemusers.su_email'=>$useremail));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row_array();
		return false;
	}
	
	public function set_session($user_object, $object_vars, $custom_vars = NULL) {

		$session_data = array();

		foreach ($object_vars as $object_var) {

			$session_data[$object_var] = $user_object[$object_var];

		}

		if ($custom_vars) {

			foreach ($custom_vars as $key=>$var) {

				$session_data[$key] = $var;

			}

		}

		$this->session->set_userdata($session_data);

	}

	public function update_timestamp($table, $key_field, $key_id, $value_field, $value_value) {

		$this->db->where($key_field, $key_id);

		$this->db->update($table, array($value_field => $value_value));

	}

	public function validate_login() {
		
		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->form_validation->set_rules('useremail', $this->lang->line('username'), 'trim|required|min_length[4]|xss_clean|htmlspecialchars');

		$this->form_validation->set_rules('userpassword', $this->lang->line('password'), 'trim|required|min_length[4]|xss_clean');
	
		return parent::validate();

	}
	
}

?>