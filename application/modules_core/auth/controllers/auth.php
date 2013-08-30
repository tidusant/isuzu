<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	private $_push;
	
    function __construct() {

        parent::__construct();
		
	//	$this->load->library('ion_auth');
		$this->load->library('form_validation');
		
		// Load MongoDB library instead of native db driver if required
	///	$this->config->item('use_mongodb', 'ion_auth') ?
	///	$this->load->library('mongo_db') :
		
	//	$this->load->language('auth');
	//	$this->load->helper('language');
    }

    function index() {
        redirect($this->uri->segment(1).'/login');
    }
	
	/*public function login()
	{
		//validate form input
		$this->form_validation->set_rules('useremail', 'Email', 'required');
		$this->form_validation->set_rules('userpassword', 'Password', 'required');

		if ($this->form_validation->run() == true) {
			
			//check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('useremail'), $this->input->post('userpassword'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('custom_error', $this->ion_auth->messages());
				redirect($this->uri->segment(1), 'refresh');
			}
			else
			{
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('custom_error', $this->ion_auth->errors());
				redirect($this->uri->segment(1).'/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$this->_push['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->_push['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->_push['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);

			$this->_render_page('auth/login', $this->data);
		}
	}*/
	
    function login() {
		
        $this->load->model('isuzu_auth');
		
		if ($this->isuzu_auth->validate_login()) {
			
			$useremail = $this->input->post('useremail', TRUE);
			$userpassword = $this->input->post('userpassword', TRUE);
			
			// find system user
			$userinfo = $this->isuzu_auth->find_member_info($useremail);
			
			if ($userinfo != FALSE && $userpassword == $this->isuzu_auth->decrypt($userinfo['password'], $userinfo)) {
				
				$object_vars = array('member_id', 'fullname', 'email', 'user_level');
				$this->isuzu_auth->set_session($userinfo, $object_vars, array('logged_in'=>true));
				//print_r($this->session->all_userdata());die();

				// update the last login field for this user
				$this->isuzu_auth->update_timestamp('isuzu_systemusers', 'id', $userinfo['member_id'], 'lastlogin', time());
				
				// unset array
				unset($userinfo);
				
				redirect($this->uri->segment(1)); // redirect to dashboard

			} else {
				$this->session->set_flashdata('custom_error', $this->lang->line('username_or_pw_incorrect'));
			
				redirect($this->uri->segment(1).'/login');
			}

		} // validate login
		
        return $this->load->view('login', $this->_push);

    }

    function logout() {
		
		//Destroy the session
		$this->session->sess_destroy();
		//Recreate the session
		if (substr(CI_VERSION, 0, 1) == '2')
		{
			$this->session->sess_create();
		}
		
        redirect($this->uri->segment(1).'/login');
		
		//log the user out
		///$logout = $this->ion_auth->logout();

		//redirect them to the login page
		///$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('auth/login', 'refresh');
		
    }
	
	
}

?>