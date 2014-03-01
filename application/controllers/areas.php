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
		$this->form_validation->set_rules('area_timestamp_finish', 'Στιγμή απενεργοποίησης', 'trim|required|xss_clean');
		$this->form_validation->set_rules('message_title', 'Τίτλος μηνύματος', 'trim|required|xss_clean');
		$this->form_validation->set_rules('message_teaser', 'Σύντομη περιγραφή', 'trim|required|xss_clean');
		$this->form_validation->set_rules('message_text', 'Κείμενο μηνύματος', 'trim|required|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('_top');
			$this->load->view('areas/create',$data);
			$this->load->view('_bottom');
		} else {
			$this->load->view('formsuccess');
		}
	}
}
