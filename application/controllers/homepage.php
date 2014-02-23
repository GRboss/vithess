<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends CI_Controller {

	public function index() {
		$this->load->model('Areas_model');
		$areas = $this->Areas_model->load_areas($this->session->userdata('user_company_id'));
		
		$data = array(
			'areas' => $areas
		);
		
		$this->load->view('_top');
		$this->load->view('homepage/homepage',$data);
		$this->load->view('_bottom');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */