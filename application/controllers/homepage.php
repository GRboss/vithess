<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends CI_Controller {

	public function index() {
		$this->load->view('_top');
		$this->load->view('homepage/homepage');
		$this->load->view('_bottom');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */