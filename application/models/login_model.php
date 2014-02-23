<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function do_login($username,$password) {    	
        $query = $this->db->query("
			SELECT user_full_name,user_id,user_user_type_id,user_company_id
			FROM users
			WHERE user_username='".$username."'
			AND user_password='".$password."'
			AND user_active=1
        ");
	if ($query->num_rows() > 0) {
		$row = $query->result_array();
		$row[0]['success'] = true;
		$row[0]['user_id'] = intval($row[0]['user_id']);
		$row[0]['user_user_type_id'] = intval($row[0]['user_user_type_id']);
		$row[0]['user_company_id'] = intval($row[0]['user_company_id']);
		return $row[0];
	} else {
		return array(
			'success' => false
		);
	}
    }
}
