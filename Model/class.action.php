<?php
session_start();
include_once ("../SqlWrapper/Class.DatabaseAlt.php");

class Action {
	
	private $userId;
	private $db;
	
	public function getAllGives() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("SELECT give_id, users.user_id, object.object_id, name, description, object.image AS object_image, type, start_date, end_date, comments, status, location, first_name, last_name, users.image AS user_image, give.timestamp FROM give INNER JOIN object ON object.object_id = give.object_id  INNER JOIN users ON give.user_id=users.user_id order by timestamp desc");
		$resultArray = $this->db->executeQuery();
		return $resultArray;
	}
	
	public function getAllGets() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("SELECT get_id, users.user_id, object.object_id, name, description, object.image AS object_image, type, start_date, end_date, comments, status, location, first_name, last_name, users.image AS user_image, get.timestamp FROM get INNER JOIN object ON object.object_id = get.object_id  INNER JOIN users ON get.user_id=users.user_id order by timestamp desc");
		$resultArray = $this->db->executeQuery();
		return $resultArray;
	}
	
}
?>