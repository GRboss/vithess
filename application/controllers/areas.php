<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Areas extends CI_Controller {
	
	public function index() {
		
	}
	
	public function details($area_id=0) {
		$this->load->model('Tiles_model');
		$this->load->model('Areas_model');
		$tiles = $this->Tiles_model->load_tiles();
		$area_tiles = $this->Areas_model->get_area_tiles($area_id);
		
		$data = array(
			'tiles' => $tiles,
			'area_tiles' => $area_tiles
		);
		
		$this->load->view('_top');
		$this->load->view('areas/details',$data);
		$this->load->view('_bottom');
	}
}
