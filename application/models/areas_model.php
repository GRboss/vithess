<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Areas_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function get_total_areas($state_id) {
		if($state_id>0) {
			$query = $this->db->query("
				SELECT count(area_id) AS total_areas
				FROM areas
				WHERE area_company_id=1
				AND area_state_id=".$state_id."
				AND area_active=1
			");
		} else {
			$query = $this->db->query("
				SELECT count(area_id) AS total_areas
				FROM areas
				WHERE area_company_id=1
				AND area_active=1
			");
		}
		$result = $query->result_array();
		return $result[0]['total_areas'];
	}

	function load_areas($state_id,$company_id,$offset,$limit) {
		if($state_id>0) {
			$query = $this->db->query("
				SELECT areas.*,messages.*,area_id,count(tile_id) AS total_tiles,sum(tile_price) AS sum_price
				FROM areas,messages,tiles_to_areas,tiles
				where message_area_id=area_id
				AND tile_to_area_area_id=area_id
				AND tile_id=tile_to_area_tile_id
				AND area_company_id".($company_id==0 ? " IS NULL" : "=".$company_id)."
				AND area_state_id=".$state_id."
				AND area_active=1
				GROUP BY area_id
				ORDER BY area_timestamp_start DESC
				LIMIT ".$offset.",".$limit."
			");
		} else {
			echo "
				SELECT areas.*,messages.*,area_id,count(tile_id) AS total_tiles,sum(tile_price) AS sum_price
				FROM areas,messages,tiles_to_areas,tiles
				where message_area_id=area_id
				AND tile_to_area_area_id=area_id
				AND tile_id=tile_to_area_tile_id
				AND area_company_id".($company_id==0 ? " IS NULL" : "=".$company_id)."
				AND area_active=1
				GROUP BY area_id
				ORDER BY area_timestamp_start DESC
				LIMIT ".$offset.",".$limit."
			";
			$query = $this->db->query("
				SELECT areas.*,messages.*,area_id,count(tile_id) AS total_tiles,sum(tile_price) AS sum_price
				FROM areas,messages,tiles_to_areas,tiles
				where message_area_id=area_id
				AND tile_to_area_area_id=area_id
				AND tile_id=tile_to_area_tile_id
				AND area_company_id".($company_id==0 ? " IS NULL" : "=".$company_id)."
				AND area_active=1
				GROUP BY area_id
				ORDER BY area_timestamp_start DESC
				LIMIT ".$offset.",".$limit."
			");
		}
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
	
	function save($pin) {
		$query = $this->db->query("
			INSERT INTO areas (area_name,area_company_id,area_timestamp_start,area_timestamp_finish)
			VALUES ('".$pin['data']['area_name']."','".$this->session->userdata('user_company_id')."','".$pin['data']['area_timestamp_start'].":00','".$pin['data']['area_timestamp_finish'].":00')
		");
		$area_id = $this->db->insert_id();
		
		$dateTime = new DateTime("now", new DateTimeZone('Europe/Athens'));
		$now = $dateTime->format("Y-m-d H:i:s");
		
		$query = $this->db->query("
			INSERT INTO messages (message_user_id,message_title,message_teaser,message_text,message_creation_timestamp,message_area_id)
			VALUES ('".$this->session->userdata('user_id')."','".$pin['data']['message_title']."','".$pin['data']['message_teaser']."','".$pin['data']['message_text']."','".$now."','".$area_id."')
		");
		
		$tiles = explode("|", $pin['data']['tiles']);
		for($i=0; $i<count($tiles); $i++) {
			$query = $this->db->query("
				INSERT INTO tiles_to_areas (tile_to_area_tile_id,tile_to_area_area_id)
				VALUES ('".$tiles[$i]."','".$area_id."')
			");
		}
	}
}
