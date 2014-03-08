<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Api_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function get_messages($lat,$long,$user_id,$category_id) {
		$query = $this->db->query("
			SELECT *
			FROM tiles,areas,tiles_to_areas,messages
			WHERE (tile_bl_lat<='".$lat."' AND tile_bl_long<='".$long."')
			AND (tile_tr_lat>='".$lat."' AND tile_tr_long>='".$long."')
			AND tile_to_area_tile_id=tile_id
			AND tile_to_area_area_id=area_id
			AND message_area_id=area_id
			ORDER BY message_creation_timestamp DESC
		");
		$result = array();
		foreach ($query->result_array() as $row) {
			$result[] = array(
				'message_id' => $row['message_id'],
				'message_title' => $row['message_title'],
				'message_teaser' => $row['message_teaser'],
				'message_text' => $row['message_text'],
			);
		}
		return json_encode($result);
	}
}