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
		$result = array(
		);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result[] = $row;
			}
		}
		return $result;
	}
}
