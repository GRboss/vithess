<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Areas extends CI_Controller {
	
	public function index() {
		
	}
	
	public function details($area_id=0) {
		$this->load->view('_top');
		$this->load->view('areas/details');
		$this->load->view('_bottom');
	}
}
