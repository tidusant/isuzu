<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_faq extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'isuzu_faq';

		$this->primary_key = 'isuzu_faq.faq_id';
		$this->order_by = 'isuzu_faq.updated_on DESC';
	}
	
	/* admin */
	
	public function get_faq_question($f_id) {

		$this->db->select('faq_question');
		$this->db->where('faq_id', $f_id);

		return $this->db->get($this->table_name)->row()->faq_question;

	}
	
	public function get_faq_answer($f_id) {

		$this->db->select('faq_answer');
		$this->db->where('faq_id', $f_id);

		return $this->db->get($this->table_name)->row()->faq_answer;

	}
	
	public function get_active($params = NULL) {

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
	
	public function validate() {
		
		$this->form_validation->set_rules('faq_question', $this->lang->line('faq_question'), 'required|xss_clean');
		$this->form_validation->set_rules('faq_answer', $this->lang->line('faq_answer'), 'required|xss_clean');
		$this->form_validation->set_rules('is_feature', $this->lang->line('faq_feature'));
		
		$this->form_validation->set_rules('display_order', $this->lang->line('faq_priority'));
		$this->form_validation->set_rules('enable', $this->lang->line('faq_active'));
		
		return parent::validate($this);

	}

	public function delete($f_id) {
		
		parent::delete(array('faq_id'=>$f_id));
	}

	public function save($db_array = NULL) {

		if (!$db_array) {

			$db_array = parent::db_array();

		}
		
		// date create - date update
		$db_array['created_on'] = time();
		$db_array['updated_on'] = time();
			
		if (!$this->input->post('enable') and !isset($db_array['enable'])) {

			$db_array['enable'] = '0';
			
		}
		
		if (!$this->input->post('is_feature') and !isset($db_array['is_feature'])) {

			$db_array['is_feature'] = '0';
			
		}
		
		$faq_id = 0;
		
		$faq_id = parent::save_return_id($db_array, uri_assoc('f_id'));
		
		// save language
		unset($db_array);
		$db_array = array('faq_id'=>$faq_id,
						'lang'=>'ENG',
						'faq_question'=>trim($this->input->post('question_title_en')),
						'faq_answer'=>trim($this->input->post('answer_content_en')));
		
		$this->_set_faq_lang($db_array);
		
	}
	
	private function _set_faq_lang($db_array) {
		if($this->check_lang_exist('isuzu_faq','faq_id',uri_assoc('f_id'))) {
			$this->db->set('faq_question',$db_array['faq_question']);
			$this->db->set('faq_answer',$db_array['faq_answer']);
			$this->db->where(array('faq_id'=>$db_array['faq_id'], 'lang'=>$db_array['lang']));
			$this->db->update('isuzu_faq_lang');
		}
		else {
			$this->db->set('faq_id',$db_array['faq_id']);
			$this->db->set('lang',$db_array['lang']);
			$this->db->set('faq_question',$db_array['faq_question']);
			$this->db->set('faq_answer',$db_array['faq_answer']);
			$this->db->insert('isuzu_faq_lang');
		}
	}
	
	public function get_faq_lang($faq_id)
	{
		$this->db->select('faq_question, faq_answer');
		$this->db->from('isuzu_faq_lang');
		$this->db->where(array('lang'=>'ENG','faq_id'=>$faq_id));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
	
}