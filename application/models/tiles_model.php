<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Tiles_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function load_tiles() {
		//echo $this->session->userdata('authenticated');
		$query = $this->db->query("
			SELECT *
			FROM tiles
			WHERE tile_active=1
			ORDER BY tile_id ASC;
		");
		$result = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result[] = $row;
			}
		}
		return $result;
	}
}
