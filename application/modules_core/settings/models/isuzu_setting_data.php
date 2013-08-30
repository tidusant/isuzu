<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Isuzu_Setting_Data extends MY_Model {

	public $settings;
	public $mimes = FALSE;
	
	public function get_setting_front_end($key, $lang='') {

		$this->db->select('data_settings.data_value');

		$this->db->join('data_settings_lang', 'data_settings.data_id=data_settings_lang.data_id', 'left');
		
		$this->db->where('data_settings.data_key', $key);
		
		if($lang=='ENG') {
			$this->db->select('data_settings_lang.data_value');
			$this->db->where('data_settings_lang.data_key', $key);
			$this->db->where('data_settings_lang.lang', $lang);
		}
		$query = $this->db->get('data_settings');

		if ($query->row()) {

			return $query->row()->data_value;

		}

		else {

			return NULL;

		}

	}
	
	public function get($key) {

		$this->db->select('data_value');

		$this->db->where('data_key', $key);

		$query = $this->db->get('data_settings');

		if ($query->row()) {

			return $query->row()->data_value;

		}

		else {

			return NULL;

		}

	}
	
	public function save($key, $value, $only_if_null = FALSE) {

		if (!is_null($this->get($key)) and !$only_if_null) {

			$this->db->where('data_key', $key);

			$db_array = array(
				'data_value'	=>	$value
			);

			$this->db->update('data_settings', $db_array);

		}

		else {

			if ($only_if_null) {

				if (!is_null($this->get($key))) {

					return;

				}

			}

			$db_array = array(
				'data_key'	=>	$key,
				'data_value'	=>	$value
			);

			$this->db->insert('data_settings', $db_array);

		}

	}
	
	public function save_lang($key, $value, $only_if_null = FALSE)
	{
		if (!is_null($this->get($key))) {

			$this->db->where('data_key', $key);

			$db_array = array(
				'lang'	=> 'ENG',
				'data_value'	=>	$value
			);

			$this->db->update('data_settings_lang', $db_array);

		}

		else {

			if ($only_if_null) {

				if (!is_null($this->get($key))) {

					return;

				}

			}

			$db_array = array(
				'lang'	=> 'ENG',
				'data_key'	=>	$key,
				'data_value'	=>	$value
			);

			$this->db->insert('data_settings_lang', $db_array);

		}
	}
	
	public function set_session_data() {

		$data_settings = $this->db->get('data_settings')->result();

		foreach ($data_settings as $data) {

			$this->settings->{$data->data_key} = $data->data_value;

		}

	}

    public function set_application_title() {

        $this->settings->application_title = $this->get('application_title');

    }

	public function setting($key) {

		return (isset($this->settings->$key)) ? $this->settings->$key : NULL;

	}
	
	// get setting language
	public function get_lang($key) {
		
		$this->db->select('data_value');

		$this->db->where('data_key', $key);

		$query = $this->db->get('data_settings_lang');

		if ($query->row()) {

			return $query->row()->data_value;

		}

		else {

			return '';

		}
	}

    public function set_setting($key, $value) {

        $this->settings->$key = $value;

    }
	
	// upload config
	public function save_data_upload($args)
	{
		$db_data = array();
		if(is_array($args)){
			foreach($args as $file=>$data){
				$db_data = array(
					'Image' => strtolower($data['raw_name']),
					'ImageType' => strtolower($data['file_ext'])
				);
			}
		}
		return $db_data;
	}
	
	public function save_logs($user_id, $which_controller, $actiontype, $target_desc)
	{
		$this->db->set('User', $user_id);
		$this->db->set('Controller', $which_controller);
		$this->db->set('Action', $actiontype);
		$this->db->set('Description', $actiontype.' '.$target_desc);
		$this->db->set('DateUpdated', time());
		$this->db->insert('isuzu_logs');
	}
	
	function save_contacter($fullname, $email, $phone, $fax, $address, $company, $subject, $content, $date_received)
	{
		$this->db->set('fullname', $fullname);
		$this->db->set('email', $email);
		$this->db->set('phone', $phone);
		$this->db->set('fax', $fax);
		$this->db->set('address', $address);
		$this->db->set('company', $company);
		$this->db->set('subject', $subject);
		$this->db->set('content', $content);
		$this->db->set('date_received', $date_received);
				
		$this->db->insert('contacts');
		return $this->db->insert_id();
	}
	
	public function get_weblinks()
	{
		$this->db->where('active', '1');
		$this->db->order_by('display_order asc');
		$query = $this->db->get('web_links');
		if($query->num_rows > 0) return $query;
		else return false;
	}
	
	public function get_allowed_extensions($type = FALSE)
	{
		$allowed_extensions = array();

		$mimes = $this->get_mimes_types();

		$filemanager_file_types = explode(',', $this->get('filemanager_file_types'));

		if ($type == FALSE)
		{
			foreach($mimes as $type)
			{
				foreach($type as $ext => $mime)
				{
					if (in_array($ext, $filemanager_file_types))
						$allowed_extensions[] = $ext;
				}
			}
		}
		else
		{
			if ( ! empty($mimes[$type]))
			{
				foreach($mimes[$type] as $ext => $mime)
				{
					if (in_array($ext, $filemanager_file_types))
						$allowed_extensions[] = $ext;
				}
			}
		}
		
		return $allowed_extensions;
	}
	
	public function get_mimes_types()
	{
		if ($this->mimes == FALSE)
		{
			$mimes = array();
			if (@require_once(APPPATH.'config/mimes_isuzu'.EXT))
			{
				$this->mimes = $mimes;
				unset($mimes);
			}
		}

		return $this->mimes;
	}
	
}

?>