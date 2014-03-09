<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Areas extends CI_Controller {
	
	public function index() {
		
	}
	
	public function details($area_id=0) {
		$this->load->model('Tiles_model');
		$this->load->model('Areas_model');
		$tiles = $this->Tiles_model->load_tiles();
		$area_tiles = $this->Areas_model->get_area_tiles($area_id);
		$message = $this->Areas_model->get_area_message($area_id);
		
		$data = array(
			'tiles' => $tiles,
			'user_company_id' => $this->session->userdata('user_company_id'),
			'area_tiles' => $area_tiles,
			'message' => $message
		);
		
		$this->load->view('_top');
		$this->load->view('areas/details',$data);
		$this->load->view('_bottom');
	}
	
	public function create() {
		$this->load->model('Tiles_model');
		$tiles = $this->Tiles_model->load_tiles();
		
		$data = array(
			'tiles' => $tiles
		);
		
		$this->form_validation->set_rules('area_name', 'Όνομα περιοχής', 'trim|required|xss_clean');
		$this->form_validation->set_rules('area_timestamp_start', 'Στιγμή ενεργοποίησης', 'trim|required|xss_clean');
		$this->form_validation->set_rules('area_timestamp_finish', 'Στιγμή απενεργοποίησης', 'trim|required|xss_clean');
		$this->form_validation->set_rules('tiles', 'Περιοχές', 'trim|required|xss_clean');
		$this->form_validation->set_rules('message_title', 'Τίτλος μηνύματος', 'trim|required|xss_clean');
		$this->form_validation->set_rules('message_teaser', 'Σύντομη περιγραφή', 'trim|required|xss_clean');
		$this->form_validation->set_rules('message_text', 'Κείμενο μηνύματος', 'trim|required|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('_top');
			$this->load->view('areas/create',$data);
			$this->load->view('_bottom');
		} else {
			$this->save();
		}
	}
	
	public function save() {
		$this->load->model('Areas_model');
		$this->Areas_model->save(array(
			'data' => $this->input->post()
		));
		header("Location: ".  base_url("index.php/homepage"));
	}
	
	public function action($content) {
		$parts = explode("_", $content);
		
		if($parts[0]=='yes') {
			$state_id=2;
		} else if($parts[0]=='no') {
			$state_id=3;
		} else {
			$state_id='';
		}
		
		$this->load->model('Areas_model');
		$this->Areas_model->action($state_id,$parts[1]);
		
		
	}
}
