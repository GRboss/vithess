<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {
	public function index() {
		$this->load->view('_top');
		$this->load->view('signup/signup');
		$this->load->view('_bottom');
	}
	
	public function save() {
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$type = intval($this->input->post('type'));
		
		$this->load->model('Signup_model');
		
		if(empty($username) || empty($email) || empty($password) || !($type===2 || $type===3)) {
			header("Location: ".base_url('index.php/signup'));
		} else {
			$this->Signup_model->save_user(
				mysql_real_escape_string($username),
				mysql_real_escape_string($email),
				mysql_real_escape_string($password),
				$type
			);
			header("Location: ".base_url());
		}
	}
}
