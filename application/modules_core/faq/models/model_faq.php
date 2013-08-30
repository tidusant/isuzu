<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_faq extends CI_Model {
	
	private $table_query;
	private $table_lang;
	public function __construct()
	{
		parent::__construct();
		$this->table_query = 'isuzu_faq';
		$this->table_lang = 'isuzu_faq_lang';
	}
	
	/// faq
	public function get_faq_list($start, $limit, $lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->join($this->table_lang, $this->table_lang.'.faq_id='.$this->table_query.'.faq_id', 'left');
		$this->db->where($this->table_query.'.enable', '1');
		if($lang=='ENG'){
			$this->db->select($this->table_lang.'.*');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->order_by($this->table_query.'.display_order ASC, '.$this->table_query.'.created_on DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function get_latest_faq($limit, $lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->join($this->table_lang, $this->table_lang.'.faq_id='.$this->table_query.'.faq_id', 'left');
		$this->db->where($this->table_query.'.enable', '1');
		if($lang=='ENG'){
			$this->db->select($this->table_lang.'.*');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->order_by($this->table_query.'.created_on DESC');
		$this->db->limit($limit);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	// save faq form
	public function save_faq_ask($faq_question, $ask_fullname, $ask_phone, $ask_email, $created_on, $display_order, $enable)
	{
		$this->db->set('faq_question', $faq_question);
		$this->db->set('faq_answer', $faq_answer);
		$this->db->set('ask_fullname', $ask_fullname);
		$this->db->set('ask_phone', $ask_phone);
		$this->db->set('ask_email', $ask_email);
		$this->db->set('created_on', $created_on);
		$this->db->set('display_order', $display_order);
		$this->db->set('enable', $enable);
				
		$this->db->insert('isuzu_faq');
		return $this->db->insert_id();
	}
}