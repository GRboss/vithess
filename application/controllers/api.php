<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	public function index() {
		
	}
	
	public function get_messages($lat,$long,$user_id,$category_id) {
		$this->load->model('api_model');
		$result = $this->api_model->get_messages($lat,$long,$user_id,$category_id);
		echo json_encode($result);
	}
	
	public function rate_the_message($user_id,$message_id,$rating) {
		$this->load->model('api_model');
		$result = $this->api_model->rate_the_message($user_id,$message_id,$rating);
		echo json_encode($result);
	}
	
	public function create_new_message() {
		/*$latitude = $this->input->post('user_longitude');
		$longitude = $this->input->post('user_longitude');
		$user_id = $this->input->post('user_id');
		$message_title = $this->input->post('message_title');
		$message_text = $this->input->post('message_text');*/
		$latitude = 44;
		$longitude = 22;
		$user_id = 154;
		$message_title = 'Thunder';
		$message_text = 'Road';
		
		$this->load->model('api_model');
		$result = $this->api_model->create_new_message($latitude,$longitude,$user_id,$message_title,$message_text);
		
		echo json_encode($result);
	}
	
	public function save_my_settings() {
		/*$user_id = $this->input->post('user_id');
		$category_ids = $this->input->post('user_id');
		$notifications_active = $this->input->post('notifications_active');*/
		$user_id = 122;
		$category_ids = '1';
		$notifications_active = 0;
		
		$this->load->model('api_model');
		$result = $this->api_model->save_my_settings($user_id,$category_ids,$notifications_active);
		
		echo json_encode($result);
	}
	
	public function get_me_my_settings($user_id) {
		$this->load->model('api_model');
		$result = $this->api_model->get_me_my_settings($user_id);
		
		echo json_encode($result);
	}
}

