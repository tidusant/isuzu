<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_news extends CI_Model {
	
	private $table_query;
	private $table_lang;
	private $primary_key;
	
	public function __construct()
	{
		parent::__construct();
		$this->table_query = 'events';
		$this->table_lang = 'events_lang';
		$this->primary_key = 'event_id';
	}
	
	public function get_promotion_home($limit, $lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->join($this->table_lang, $this->table_lang.'.'.$this->primary_key.'='.$this->table_query.'.'.$this->primary_key, 'left');
		$this->db->where($this->table_query.'.active','1');
		$this->db->where($this->table_query.'.event_promotion','1');
		if($lang=='ENG'){
			$this->db->select($this->table_lang.'.*');
			$this->db->where($this->table_lang.'.lang',$lang);
		} 
		$this->db->order_by($this->table_query.'.event_id DESC');
		$this->db->limit($limit);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function get_news_home($limit, $lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->join($this->table_lang, $this->table_lang.'.'.$this->primary_key.'='.$this->table_query.'.'.$this->primary_key, 'left');
		$this->db->where($this->table_query.'.active','1');
		$this->db->where($this->table_query.'.event_promotion','0');
		if($lang=='ENG') { 
			$this->db->select($this->table_lang.'.*');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->order_by($this->table_query.'.event_id DESC');
		$this->db->limit($limit);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function get_count_list_news($list_news_not_in)
	{
		$this->db->where($this->table_query.'.active', '1');
		$this->db->where_not_in($this->table_query.'.event_id', $list_news_not_in);
		$this->db->order_by($this->table_query.'.event_ontop DESC, '.$this->table_query.'.display_order ASC, '.$this->table_query.'.event_id DESC');
		$this->db->from($this->table_query);
		return $this->db->count_all_results();
	}
	
	public function get_list_news($list_news_not_in, $start, $limit, $lang='') {
		$this->db->select($this->table_query.'.*');
		if($lang=='ENG') {
			$this->db->join($this->table_lang, $this->table_lang.'.'.$this->primary_key.'='.$this->table_query.'.'.$this->primary_key, 'left');
			$this->db->select($this->table_lang.'.*');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->where($this->table_query.'.active', '1');
		$this->db->where_not_in($this->table_query.'.event_id', $list_news_not_in);
		$this->db->order_by($this->table_query.'.event_ontop DESC, '.$this->table_query.'.display_order ASC, '.$this->table_query.'.event_id DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function get_latest_news($limit, $lang='')
	{
		$this->db->select($this->table_query.'.event_id, '.$this->table_query.'.event_slug, '.$this->table_query.'.event_title');
		$this->db->join($this->table_lang, $this->table_lang.'.'.$this->primary_key.'='.$this->table_query.'.'.$this->primary_key, 'left');
		$this->db->where($this->table_query.'.active', '1');
		$this->db->where($this->table_query.'.event_promotion', '0');
		if($lang=='ENG') {
			$this->db->select($this->table_lang.'.event_title');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->order_by($this->table_query.'.event_id DESC');
		$this->db->limit($limit);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	public function get_promotion_latest($limit, $lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->where($this->table_query.'.active','1');
		$this->db->where($this->table_query.'.event_promotion','1');
		if($lang=='ENG') {
			$this->db->join($this->table_lang, $this->table_lang.'.'.$this->primary_key.'='.$this->table_query.'.'.$this->primary_key, 'left');
			$this->db->select($this->table_lang.'.*');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->order_by($this->table_query.'.event_ontop DESC, '.$this->table_query.'.display_order ASC, '.$this->table_query.'.event_id DESC');
		$this->db->limit($limit);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
	public function get_news_ontop($promotion_id, $limit, $lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->where($this->table_query.'.active','1');
		$this->db->where_not_in($this->table_query.'.event_id', array($promotion_id, 0));
		$this->db->where($this->table_query.'.event_promotion','0');
		if($lang=='ENG') {
			$this->db->join($this->table_lang, $this->table_lang.'.'.$this->primary_key.'='.$this->table_query.'.'.$this->primary_key, 'left');
			$this->db->select($this->table_lang.'.*');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->order_by($this->table_query.'.event_ontop DESC, '.$this->table_query.'.display_order ASC, '.$this->table_query.'.event_id DESC');
		$this->db->limit($limit);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
	public function get_news_detail($slug, $lang='')
	{
		$this->db->select($this->table_query.'.*');
		$this->db->where($this->table_query.'.active','1');
		$this->db->where($this->table_query.'.event_slug',$slug);
		if($lang=='ENG') {
			$this->db->join($this->table_lang, $this->table_lang.'.'.$this->primary_key.'='.$this->table_query.'.'.$this->primary_key, 'left');
			$this->db->select($this->table_lang.'.*');
			$this->db->where($this->table_lang.'.lang',$lang);
		}
		$this->db->order_by($this->table_query.'.updated_on DESC');
		$this->db->limit(1);
		$query = $this->db->get($this->table_query);
		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
	
	public function get_comment_count_news($news_id)
	{
		$this->db->from('event_comments');
		$this->db->where(array('enable'=>'1','events_event_id'=>$news_id));
		return $this->db->count_all_results();
	}
	
	public function get_comment_by_news($news_id, $limit)
	{
		$this->db->select('cmt_id, cmt_author, cmt_email, cmt_content, cmt_date');
		$this->db->from('event_comments');
		$this->db->where(array('enable'=>'1', 'events_event_id'=>$news_id));
		$this->db->order_by('cmt_date DESC');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() > 0) return $query;
		else return false;
	}
	
	// insert comment
	public function set_comment_by_news($events_event_id, $cmt_author, $cmt_email, $cmt_content, $cmt_ipaddress, $cmt_date, $enable)
	{
		$this->db->set('events_event_id', $events_event_id);
		$this->db->set('cmt_author', $cmt_author);
		$this->db->set('cmt_email', $cmt_email);
		$this->db->set('cmt_content', $cmt_content);
		$this->db->set('cmt_ipaddress', $cmt_ipaddress);
		$this->db->set('cmt_date', $cmt_date);
		$this->db->set('enable', $enable);
				
		$this->db->insert('event_comments');
		return $this->db->insert_id();
	}
	
	public function config_style_pagination($total_rows, $url, $per_page=25) {
		
		$this->load->library('pagination');
		$this->load->config('pagination');
		
		//paging config
		$config['base_url'] 		= $url;
		$config['next_link'] 		= $this->lang->line('next_link');
		$config['prev_link'] 		= $this->lang->line('prev_link');
		$config['first_link'] 		= $this->lang->line('first_link');
		$config['last_link'] 		= $this->lang->line('last_link');
		$config['full_tag_open'] 	= $this->lang->line('full_tag_open');
		$config['full_tag_close'] 	= $this->lang->line('full_tag_close');
		$config['cur_tag_open'] 	= $this->lang->line('cur_tag_open');
		$config['cur_tag_close'] 	= $this->lang->line('cur_tag_close');
		$config['num_tag_open'] 	= $this->lang->line('num_tag_open');
		$config['num_tag_close'] 	= $this->lang->line('num_tag_close');
		$config['num_links'] 		= $this->lang->line('num_links');
		$config['next_tag_open']	= $this->lang->line('next_tag_open');
		$config['next_tag_close']	= $this->lang->line('next_tag_close');
		$config['prev_tag_open']	= $this->lang->line('prev_tag_open');
		$config['prev_tag_close']	= $this->lang->line('prev_tag_close');
		$config['total_rows'] 		= $total_rows;
		$config['per_page'] 		= $per_page;
		
		$this->pagination->initialize($config);
		
		$start = $this->pagination->segment_value();
		$pagination['start_page'] = $start;
		$pagination['per_page'] = $per_page;
		$pagination['links'] = $this->pagination->create_links();
		return $pagination;
	}
}