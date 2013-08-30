<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model_news extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		$this->table_name = 'events';

		$this->primary_key = 'events.event_id';
		$this->order_by = 'events.updated_on DESC';
	}
	
	public function get_news_title($news_id) {

		$this->db->select('event_title');
		$this->db->where('event_id', $news_id);
		$query = $this->db->get('events');
		if($query->num_rows() > 0) {
			return $query->row()->event_title;
		} else return false;
	}
	
	public function get_total_news()
	{
		return $this->db->count_all_results($this->table_name);
	}
	
	public function validate() {
		
		$this->form_validation->set_rules('event_title', $this->lang->line('news_title'), 'trim|required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('event_link_image', 'Image', 'trim|required|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('event_slug', $this->lang->line('news_slug'), 'trim|required|xss_clean|htmlspecialchars|callback_eventslug_check');
		$this->form_validation->set_rules('event_content', $this->lang->line('news_content'), 'required');
		$this->form_validation->set_rules('event_ontop', $this->lang->line('news_ontop'));
		$this->form_validation->set_rules('event_promotion', $this->lang->line('news_promotion'));
		$this->form_validation->set_rules('event_reg_form', $this->lang->line('news_reg_form'));
		$this->form_validation->set_rules('comment_allow', $this->lang->line('news_comment'));
		$this->form_validation->set_rules('display_order', $this->lang->line('news_priority'), 'numeric|xss_clean|htmlspecialchars');
		$this->form_validation->set_rules('active', $this->lang->line('news_active'));
		
		return parent::validate($this);

	}
	
	public function eventslug_check($slug) {

		$this->db->where('event_slug', $slug);

		if (uri_assoc('news_id')) {

			$this->db->where('event_id <>', uri_assoc('news_id'));

		}
		
		$query = $this->db->get($this->table_name);

		if ($query->num_rows()) {

			$this->form_validation->set_message('eventslug_check', $this->lang->line('eventslug_already_exists'));

			return FALSE;

		}

		return TRUE;

	}
	
	public function delete($news_id) {
		parent::delete(array('event_id'=>$news_id));
	}

	public function save($db_array = NULL) {

		if (!$db_array) {

			$db_array = parent::db_array();

		}
		
		// date create - date update
		$db_array['created_on'] = time();
		$db_array['updated_on'] = time();
			
		if (!$this->input->post('active') and !isset($db_array['active'])) {

			$db_array['active'] = '0';
			
		}
		
		if (!$this->input->post('comment_allow') and !isset($db_array['comment_allow'])) {

			$db_array['comment_allow'] = '0';
			
		}
		
		if (!$this->input->post('event_reg_form') and !isset($db_array['event_reg_form'])) {

			$db_array['event_reg_form'] = '0';
			
		}
		
		if (!$this->input->post('event_promotion') and !isset($db_array['event_promotion'])) {

			$db_array['event_promotion'] = '0';
			
		}
		
		if (!$this->input->post('event_ontop') and !isset($db_array['event_ontop'])) {

			$db_array['event_ontop'] = '0';
			
		}
		
		$news_id = 0;
		$news_id = parent::save_return_id($db_array, uri_assoc('news_id'));
		
		// save language
		unset($db_array);
		$db_array = array('event_id'=>$news_id,
						'lang'=>'ENG',
						'event_title'=>trim(htmlspecialchars($this->input->post('news_title_en'))),
						'event_content'=>trim($this->input->post('news_content_en', TRUE)));
		
		$this->_set_news_lang($db_array);
		
	}
	
	private function _set_news_lang($db_array) {
		if($this->check_lang_exist('events','event_id',uri_assoc('news_id'))) {
			$this->db->set('event_title',$db_array['event_title']);
			$this->db->set('event_content',$db_array['event_content']);
			$this->db->where(array('event_id'=>$db_array['event_id'], 'lang'=>'ENG'));
			$this->db->update('events_lang');
		}
		else {
			$this->db->set('event_id',$db_array['event_id']);
			$this->db->set('lang',$db_array['lang']);
			$this->db->set('event_title',$db_array['event_title']);
			$this->db->set('event_content',$db_array['event_content']);
			$this->db->insert('events_lang');
		}
	}
	
	public function get_news_lang($news_id)
	{
		$this->db->select('event_title, event_content');
		$this->db->from('events_lang');
		$this->db->where(array('lang'=>'ENG','event_id'=>$news_id));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
}