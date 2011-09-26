<?php
session_start();
include_once '../SqlWrapper/Class.DatabaseAlt.php';

class Notification {
	private $userId;
	
	/**
	 * @param field_type $userId
	 */
	public function setUserId($userId) {
		$this->userId = $userId;
	}

	public function fetchGiveNotifications() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("SELECT object.object_id, object.image AS object_image, object.name AS object_name, give.give_id, applicant.applicant_id, applicant.user_id AS applicant_user_id, users.user_id, users.image AS user_image, users.first_name, users.last_name FROM give INNER JOIN applicant ON give.give_id = applicant.giveget_id INNER JOIN object ON give.object_id = object.object_id INNER JOIN users ON give.user_id = users.user_id WHERE applicant.status = 'Chosen' AND applicant.user_id ='".$this->userId."'");
		$resultArray = $this->db->executeQuery();
		return $resultArray;
	}
	
	public function fetchGetNotifications() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("SELECT object.object_id, object.image AS object_image, object.name AS object_name, get.get_id, applicant.applicant_id, applicant.user_id AS applicant_user_id, get.user_id, users.image AS user_image, users.first_name, users.last_name FROM get INNER JOIN object ON get.object_id = object.object_id INNER JOIN applicant ON get.get_id = applicant.giveget_id INNER JOIN users ON applicant.user_id = users.user_id WHERE applicant.status = 'Chosen' AND get.user_id='".$this->userId."'");
		$resultArray = $this->db->executeQuery();
		return $resultArray;
	}
}
?>