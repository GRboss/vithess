<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Areas_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function load_areas() {
		echo $this->session->userdata('authenticated');
		$query = $this->db->query("
			SELECT *
			FROM areas
			WHERE area_company_id=1
		");
		$result = array(
			'success' => true,
			'areas' => array()
		);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result['areas'][] = $row;
			}
		}
		return $result;
	}
}
