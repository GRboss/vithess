<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Areas_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function get_total_areas($state_id,$company_id) {
		if($state_id>0) {
			$query = $this->db->query("
				SELECT count(area_id) AS total_areas
				FROM areas
				WHERE area_company_id=".$company_id."
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
				SELECT areas.*,messages.*,area_id,count(tile_id) AS total_tiles,sum(tile_price) AS sum_price,companies.*
				FROM areas,messages,tiles_to_areas,tiles,companies
				where message_area_id=area_id
				AND tile_to_area_area_id=area_id
				AND tile_id=tile_to_area_tile_id
				AND area_company_id".($company_id==0 ? ">0" : "=".$company_id)."
				AND company_id=area_company_id
				AND area_state_id=".$state_id."
				AND area_active=1
				GROUP BY area_id
				ORDER BY area_timestamp_start DESC
				LIMIT ".$offset.",".$limit."
			");
		} else {
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
	
	function get_message_votes($message_id,$vote) {
		$query = $this->db->query("
			SELECT vote_message_id,COUNT(vote_id) AS total
			FROM votes
			WHERE vote_message_id=".$message_id."
			AND vote_vote=".$vote."
			GROUP BY vote_message_id
		");
		$row = $query->result_array();
		if($query->num_rows>0) return intval($row[0]['total']);
		else return 0;
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
			$result[0]['message_views'] = $this->get_message_views($result[0]['message_id']);
			return $result[0];
		} else {
			return array();
		}
	}
	
	function get_message_views($message_id) {
		$query = $this->db->query("
			SELECT view_message_id,COUNT(view_person_id) as total
			FROM views
			WHERE view_message_id=".$message_id."
			GROUP BY view_message_id
		");
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			return intval($result[0]['total']);
		} else {
			return 0;
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
	
	function action($state_id,$area_id) {
		if(is_int($state_id)) {
			$this->db->query("
				UPDATE areas
				SET area_state_id=".$state_id."
				WHERE area_id=".$area_id."
			");
		}
	}
	
	function load_reports() {
		/*$query = $this->db->query("
			SELECT *
			FROM reports,areas,messages,companies
			WHERE message_id=report_message_id
			AND area_id=message_area_id
			AND company_id=area_company_id
		");*/
		$query = $this->db->query("
			SELECT *
			FROM reports,messages LEFT JOIN areas ON message_area_id=area_id
			WHERE message_id=report_message_id
		");
		$result = array();
		if($query->num_rows > 0) {
			foreach ($query->result_array() as $row) {
				$result[] = array(
					'report_id' => $row['report_id'],
					'area_id' => $row['area_id'],
					'area_name' => $row['area_name'],
					'company_id' => (empty($row['company_id']) ? '' : $row['company_id']),
					'company_name' => (empty($row['company_name']) ? '' : $row['company_name']),
					'message_creation_timestamp' => $row['message_creation_timestamp'],
					'message_id' => $row['message_id'],
					'message_title' => $row['message_title'],
					'message_teaser' => $row['message_teaser'],
					'message_text' => $row['message_text']
				);
			}
		}
		return $result;
	}
	
	function action_reported($verdict,$area_id,$report_id) {
		if($verdict=='accepted') {
			$this->db->query("
				UPDATE areas
				SET area_state_id=4
				WHERE area_id=".$area_id."
			");
			
			$this->db->query("
				DELETE FROM reports
				WHERE report_id=".$report_id."
			");
		} else if($verdict=='rejected') {
			$this->db->query("
				DELETE FROM reports
				WHERE report_id=".$report_id."
			");
		}
	}
	
	function get_state_name($area_id) {
		$query = $this->db->query("
			SELECT state_name
			FROM areas,states
			WHERE area_id=".$area_id."
			AND state_id=area_state_id
		");
		$row = $query->result_array();
		return $row[0]['state_name'];
	}
}
