<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function save_user($username,$email,$password,$type) {
		if($type===2) {
			$query = $this->db->query("
				INSERT INTO users (user_user_type_id,user_company_id,user_full_name,user_username,user_password,user_active)
				VALUES (2,1,'".$username."','".$email."','".$password."',1)
			");
		} else if($type===3) {
			$query = $this->db->query("
				INSERT INTO users (user_user_type_id,user_company_id,user_full_name,user_username,user_password,user_active)
				VALUES (2,NULL,'".$username."','".$email."','".$password."',1)
			");
		}
    }
}
