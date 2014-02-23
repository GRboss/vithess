<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Enterprises extends CI_Controller {

	public function index() {
		$this->load->view('_top');
		$this->load->view('enterprises/enterprises');
		$this->load->view('_bottom');
	}
	
	public function login() {
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$this->load->model('Login_model');
			$result = $this->Login_model->do_login(
				$this->input->post('username'),
				$this->input->post('password')
			);
			
			if($result['success']) {
				$authenticated = 1;
				$newdata = array(
					'authenticated'  => $authenticated,
					'user_full_name' => $result['user_full_name'],
					'user_id' => $result['user_id'],
					'user_user_type_id' => $result['user_user_type_id'],
					'user_company_id' => $result['user_company_id']
				);
				
				if($this->input->post('rememberme')=='on') {
					$cookie = array(
						'name'   => 'vithess_username',
						'value'  => $this->input->post('username'),
						'expire' => '86500',
						'domain' => '/'
					);
					$this->input->set_cookie($cookie);
					$cookie = array(
						'name'   => 'vithess_password',
						'value'  => $this->encrypt->encode($this->input->post('password')),
						'expire' => '86500',
						'domain' => '/'
					);
					$this->input->set_cookie($cookie);
				}
				
				$this->session->set_userdata($newdata);
				
				header("Location: ".base_url('index.php/homepage'));
			} else {
				$authenticated = 0;
				$newdata = array(
					'authenticated'  => $authenticated,
					'user_full_name' => '',
					'user_id' => 0,
					'user_user_type_id' => 0,
					'user_company_id' => 0
				);
				$this->index();
			}
		}
	}
	
	public function logout() {
		$this->session->sess_destroy();
		header("Location: ".base_url());
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */