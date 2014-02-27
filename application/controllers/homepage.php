<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends CI_Controller {

	public function index() {
		$this->page();
	}
	
	public function page() {
		$this->load->library('pagination');
		$this->load->model('Areas_model');
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3)-1 : 0;
		
		$config['base_url'] = base_url('index.php/homepage/page');
		$config['total_rows'] = 4;
		$config['per_page'] = 2; 

		$this->pagination->initialize($config); 
		
		$areas = $this->Areas_model->load_areas($this->session->userdata('user_company_id'),$page*$config['per_page'],$config['per_page']);
		
		$data = array(
			'areas' => $areas,
			'pagination' => $this->pagination->create_links()
		);
		
		$this->load->view('_top');
		$this->load->view('homepage/homepage',$data);
		$this->load->view('_bottom');
	}
}

