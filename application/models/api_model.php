<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Api_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function get_messages($lat,$long,$user_id,$category_id) {
		$person_id = $this->get_person_id($user_id);
		
		$query = $this->db->query("
			SELECT *
			FROM tiles,areas,tiles_to_areas,messages
			WHERE (tile_bl_lat<='".$lat."' AND tile_bl_long<='".$long."')
			AND (tile_tr_lat>='".$lat."' AND tile_tr_long>='".$long."')
			AND tile_to_area_tile_id=tile_id
			AND tile_to_area_area_id=area_id
			AND message_area_id=area_id
			AND area_state_id=2
			ORDER BY message_creation_timestamp DESC
		");
		$result = array();
		foreach ($query->result_array() as $row) {
			$result[] = array(
				'message_id' => $row['message_id'],
				'message_title' => $row['message_title'],
				'message_teaser' => $row['message_teaser'],
				'message_text' => $row['message_text'],
				'message_views' => $this->get_views($row['message_id']),
				'message_up_votes' => $this->get_message_votes($row['message_id'],1),
				'message_down_votes' => $this->get_message_votes($row['message_id'],-1),
			);
			
			$this->add_view($person_id,$row['message_id']);
		}
		return $result;
	}
	
	private function get_views($message_id) {
		$query = $this->db->query("
			SELECT view_message_id,COUNT(view_id) AS views
			FROM views
			WHERE view_message_id=".$message_id."
			GROUP BY view_message_id
		");
		$row = $query->result_array();
		if($query->num_rows>0) return intval($row[0]['views']);
		else return 0;
	}
	
	private function add_view($person_id,$message_id) {
		$dateTime = new DateTime("now", new DateTimeZone('Europe/Athens'));
		$now = $dateTime->format("Y-m-d H:i:s");
		
		$this->db->query("
			INSERT INTO views(view_person_id,view_message_id,view_timestamp)
			VALUES (".$person_id.",".$message_id.",'".$now."')
		");
	}


	private function get_person_id($facebook_id) {
		$query = $this->db->query("
			SELECT *
			FROM persons
			WHERE person_facebook_id='".$facebook_id."'
		");
		if($query->num_rows>0) {
			$row = $query->result_array();
			return intval($row[0]['person_id']);
		} else {
			$this->db->query("
				INSERT INTO persons(person_facebook_id)
				VALUES ('".$facebook_id."')
			");
			return $this->get_person_id($facebook_id);
		}
	}
	
	private function get_message_votes($message_id,$vote) {
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
	
	
	function rate_the_message($user_id,$message_id,$rating) {
		$person_id = $this->get_person_id($user_id);
		
		$dateTime = new DateTime("now", new DateTimeZone('Europe/Athens'));
		$now = $dateTime->format("Y-m-d H:i:s");
		
		$result = array(
			'success' => 1
		);
		
		switch ($rating) {
			case 'like':
				$this->db->query("
					INSERT INTO votes (vote_person_id,vote_message_id,vote_vote)
					VALUES (".$person_id.",".$message_id.",1)
				");
				break;
			case 'dislike':
				$this->db->query("
					INSERT INTO votes (vote_person_id,vote_message_id,vote_vote)
					VALUES (".$person_id.",".$message_id.",-1)
				");
				break;
			case 'report':
				$this->db->query("
					INSERT INTO reports (report_person_id,report_message_id,report_timestamp)
					VALUES (".$person_id.",".$message_id.",'".$now."')
				");
				break;
			default :
				$result['success'] = 0;
		}
		
		return $result;
	}
	
	function create_new_message($latitude,$longitude,$user_id,$message_title,$message_text) {
		$person_id = $this->get_person_id($user_id);
		
		$dateTime = new DateTime("now", new DateTimeZone('Europe/Athens'));
		$now = $dateTime->format("Y-m-d H:i:s");
		
		$this->db->query("
			INSERT INTO messages (message_person_id,message_title,message_text,message_lat,message_long,message_creation_timestamp)
			VALUES (".$person_id.",'".$message_title."','".$message_text."',".$latitude.",".$longitude.",'".$now."')
		");
		
		$result = array(
			'success' => 1
		);
		
		return $result;
	}
	
	function save_my_settings($user_id,$category_ids,$notifications_active) {
		$person_id = $this->get_person_id($user_id);
		
		$this->db->query("
			UPDATE persons
			SET person_notifications_active=".$notifications_active."
			WHERE person_id=".$person_id."
		");
		
		$this->db->query("
			DELETE FROM persons_to_categories
			WHERE person_to_category_person_id=".$person_id."
		");
		
		$ids = explode(",", $category_ids);
		for($i=0; $i<count($ids); $i++) {
			$this->db->query("
				INSERT INTO persons_to_categories (person_to_category_person_id,person_to_category_category_id)
				VALUES (".$person_id.",".$ids[$i].")
			");
		}
		
		$result = array(
			'success' => 1
		);
		
		return $result;
	}
	
	function get_me_my_settings($user_id) {
		$person_id = $this->get_person_id($user_id);
		
		$result = array(
			'notifications_active' => 0,
			'categories' => array()
		);
		
		$query = $this->db->query("
			SELECT person_notifications_active
			FROM persons
			WHERE person_id=".$person_id."
		");
		$row = $query->result_array();
		$result['notifications_active'] = $row[0]['person_notifications_active'];
		
		$query = $this->db->query("
			SELECT *
			FROM categories LEFT JOIN persons_to_categories
			ON categories.category_id=persons_to_categories.person_to_category_category_id
			AND person_to_category_person_id=".$user_id."
		");
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result['categories'][] = array(
					'category_name' => $row['category_name'],
					'in_use' => ($row['person_to_category_id']=='' ? 0:1)
				);
			}
		}
		
		return $result;
	}
}