<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reported extends CI_Controller {

	public function index() {
		$this->load->model('Areas_model');
		
		$reports = $this->Areas_model->load_reports();
		
		$data = array(
			'reports' => $reports
		);
		
		$this->load->view('_top');
		$this->load->view('reported/reported',$data);
		$this->load->view('_bottom');
	}
	
	public function action($content) {
		$parts = explode("_", $content);
		
		if($parts[0]=='yes') {
			$verdict='accepted';
		} else if($parts[0]=='no') {
			$verdict='rejected';
		} else {
			$verdict='';
		}
		
		$this->load->model('Areas_model');
		$this->Areas_model->action_reported($verdict,$parts[1],$parts[2]);
	}
}

