<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Hits_m extends CI_Model {
	
	public function __construct()
	{		
		parent::__construct();
		$this->load->model('truyen_m');
		$this->load->model('author_m');

	}

		public function check($id,$url,$type,$option='null')
		{
			$data =  array('SessionId'=>$this->session->userdata('session_id'),'HitsId'=>$id,'HitsUrl'=>$url,'HitsType'=>$type);
			
			$query = $this->db->get_where('storyhits',$data, 1, 0);
			$query = $query->row_array();
			if (count($query)  < 1) {
				$data['CreatedOn'] = time();
				$this->db->insert('storyhits', $data);
				$this->update_view($id,$type,$option);
			} 
			
		}
			
		public function update_view($id,$type,$option)
		{						
			switch ($type) {
				case 'story':
					if($option !='null') $this->chappter_m->update_view($option);		
					return	$this->truyen_m->update_view($id);
				case 'author':
					return	$this->author_m->update_view($id);			
				case 'meme':
					return	$this->meme_m->update_view($id);									
			}
		}	
	
}