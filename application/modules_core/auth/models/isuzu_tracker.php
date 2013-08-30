<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Isuzu_Tracker extends MY_Model {
	
	private $_enable_tracker = TRUE;
	private $_blocking_severeness = 1.0;
	private $_blocking_exponent	= 1.75;
	private $_tracker_cleaning_probability = 5;
	private $_tracker_clean_older_than = 86400;
	
	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'isuzu_logintracker';
		$this->primary_key = 'isuzu_logintracker.ip_address';
	}
	
    // login tracker
	
	public function check_track($post_array)
	{
		// Tracker
		if($this->_enable_tracker === TRUE)
		{
			$tracker = $this->_tracker();
			
			if($this->_blocked())
			{
				list($key, $id) = each($post_array);
				$this->_increment_failures($key, $id);
				
				//$this->error = $this->set_error_message('connect_blocked', (is_numeric($this->time_left()) ? 'in '.$this->time_left().' seconds.' : 'later.'));
				
				return FALSE;
			}
		}
		
		// login fail
		/*else
		{
			if($this->_enable_tracker)
			{
				list($key, $id) = each($post_array);
				$this->_increment_failures($key, $id);
			}
			
			$this->error = $this->set_error_message('connect_login_failed');
			
			return FALSE;
		} */
	}
	
	public function _tracker()
	{
	
		if( ! isset($this->tracker))
		{
			$this->tracker = array();
			
			// defaults
			$this->tracker['failures'] = 0;
			$this->tracker['first_time'] = time();

			// clean table, if the die wants
			srand(time());
			if((rand() % 100) < $this->_tracker_cleaning_probability)
			{
				$this->db->delete($this->table_name, array('first_time <' => time() - $this->_tracker_clean_older_than));
			}

			// load data, if we have some
			$q = $this->db->get_where($this->table_name, array('ip_address' => $this->input->ip_address()), 1);

			$this->tracker = $q->num_rows() ? $q->row_array() : $this->tracker;
		}

		return $this->tracker;
	}
	
	public function _blocked()
	{
		$sum = pow($this->tracker['failures'], $this->_blocking_exponent) / (time() - $this->tracker['first_time'] + 1) * $this->_blocking_severeness;

		if($sum > 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function _increment_failures($key, $id)
	{
		$CI =& get_instance();
		
		$this->tracker['failures'] += 1;

		$this->save_tracker($this->tracker);
		
		$val = log($this->tracker['failures'], 10);
		
		if($val > 0 && $val % 1 == 0)
		{
			log_message('error', 'Connect: Many tries to login with the identification '.$key.':"'.$id.'" from ip "'.$this->input->ip_address().'", try no '.$this->tracker['failures']);
		}
	}
	
	public function save_tracker($tracker)
	{
		// update : No client IP : Set it ! 
		if ( empty($tracker['ip_address']) )
		{
			$tracker['ip_address'] = $this->input->ip_address();
			return $this->db->insert($this->table_name, $tracker);
		}
		else
		{
			return $this->db->where('ip_address', $this->input->ip_address())
					->update($this->table_name, $tracker);
		}
	}
	
	public function set_error_message($line_key = '', $args = '')
	{
		if( ! is_array($args))
	    {
	        $args = array($args);
	    }
		
	    $line_key = $this->lang->line($line_key);
	    $message = vsprintf($line_key, $args);
		
		return $message;
	}

}

?>