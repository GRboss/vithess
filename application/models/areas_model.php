<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Areas_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function load_areas($company_id,$offset,$limit) {
		//echo $this->session->userdata('authenticated');
		$query = $this->db->query("
			SELECT areas.*,messages.*,area_id,count(tile_id) AS total_tiles,sum(tile_price) AS sum_price
			FROM areas,messages,tiles_to_areas,tiles
			where message_area_id=area_id
			AND tile_to_area_area_id=area_id
			AND tile_id=tile_to_area_tile_id
			AND area_company_id=".$company_id."
			AND area_active=1
			GROUP BY area_id
			ORDER BY area_timestamp_start DESC
			LIMIT ".$offset.",".$limit."
		");
		$result = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result[] = $row;
			}
		}
		return $result;
	}
	
	function get_area_tiles($area_id) {
		$query = $this->db->query("
			SELECT tiles.*
			FROM tiles,tiles_to_areas
			WHERE tile_to_area_area_id=".$area_id."
			AND tile_id=tile_to_area_tile_id
			AND tile_active=1
		");
		$result = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result[] = $row;
			}
		}
		return $result;
	}
	
	function get_area_message($area_id) {
		$query = $this->db->query("
			SELECT *
			FROM messages
			WHERE message_area_id=".$area_id."
			AND message_active=1
		");
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			return $result[0];
		} else {
			return array();
		}
	}
}
