<?php
session_start();
include_once ("../SqlWrapper/Class.DatabaseAlt.php");

class Applicant {
	
	private $applicantId;
	private $givegetId;
	private $userId;
	private $comments;
	private $status;
	private $tableName;
	private $columnArray;
	private $valueArray;
	private $whereColumn;
	private $whereColumnValue;
	private $db;
	
	function __construct() {
		//$this->db = new Database ();
	}
	
	/**
	 * @return the $applicantId
	 */
	public function getApplicantId() {
		return $this->applicantId;
	}

	/**
	 * @param field_type $applicantId
	 */
	public function setApplicantId($applicantId) {
		$this->applicantId = $applicantId;
	}
	
	/**
	 * @return the $givegetId
	 */
	public function getGivegetId() {
		return $this->givegetId;
	}

	/**
	 * @return the $userId
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * @return the $comments
	 */
	public function getComments() {
		return $this->comments;
	}

	/**
	 * @return the $status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return the $tableName
	 */
	public function getTableName() {
		return $this->tableName;
	}

	/**
	 * @return the $columnArray
	 */
	public function getColumnArray() {
		return $this->columnArray;
	}

	/**
	 * @return the $valueArray
	 */
	public function getValueArray() {
		return $this->valueArray;
	}

	/**
	 * @return the $whereColumn
	 */
	public function getWhereColumn() {
		return $this->whereColumn;
	}

	/**
	 * @return the $whereColumnValue
	 */
	public function getWhereColumnValue() {
		return $this->whereColumnValue;
	}

	/**
	 * @param field_type $givegetId
	 */
	public function setGivegetId($givegetId) {
		$this->givegetId = $givegetId;
	}

	/**
	 * @param field_type $userId
	 */
	public function setUserId($userId) {
		$this->userId = $userId;
	}

	/**
	 * @param field_type $comments
	 */
	public function setComments($comments) {
		$this->comments = $comments;
	}

	/**
	 * @param field_type $status
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * @param field_type $tableName
	 */
	public function setTableName($tableName) {
		$this->tableName = $tableName;
	}

	/**
	 * @param field_type $columnArray
	 */
	public function setColumnArray($columnArray) {
		$this->columnArray = $columnArray;
	}

	/**
	 * @param field_type $valueArray
	 */
	public function setValueArray($valueArray) {
		$this->valueArray = $valueArray;
	}

	/**
	 * @param field_type $whereColumn
	 */
	public function setWhereColumn($whereColumn) {
		$this->whereColumn = $whereColumn;
	}

	/**
	 * @param field_type $whereColumnValue
	 */
	public function setWhereColumnValue($whereColumnValue) {
		$this->whereColumnValue = $whereColumnValue;
	}
	
	public function insertApplicant() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("INSERT INTO applicant (applicant_id,giveget_id,user_id,comments,status) VALUES ('".$this->applicantId."','".$this->givegetId."','".$this->userId."','".mysql_real_escape_string($this->comments)."','".$this->status."')");
		$resultArray = $this->db->executeQuery();
		return $resultArray;
	}
	
	public function getAllApplicants() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("SELECT applicant_id, giveget_id, applicant.user_id, comments, status, first_name, last_name, image, timestamp FROM applicant INNER JOIN users on applicant.user_id = users.user_id ORDER BY timestamp desc");
		$resultArray = $this->db->executeQuery();
		return $resultArray;
	}
	
	public function updateApplicant() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("UPDATE applicant SET status='".$this->status."' WHERE applicant_id='".$this->applicantId."'");
		$resultArray = $this->db->executeQuery();
		return $resultArray;
	}
	
	public function deleteApplicant() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("DELETE FROM applicant WHERE giveget_id='".$this->givegetId."'");
		$resultArray = $this->db->executeQuery();
		return $resultArray;
	}
	
	public function getLastApplicantId() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("SELECT applicant_id FROM applicant");
		$result = $this->db->executeQuery();
		if (sizeof ( $result ) > 0) {
			for($i = 0; $i <(sizeof($result)); $i++) {
				$idArray [$i] = explode ( "t", $result [$i] ['applicant_id'] );
			}
			$lastId = $idArray [0] [1];
			for($j = 0; $j < (sizeof ( $idArray )); $j ++) {
				if (( int ) $lastId < ( int ) $idArray [$j] [1]) {
					$lastId = $idArray [$j] [1];
				}
			}
		} else {
			$lastId = null;
		}
		return $lastId;
	}
	
	public function getNewId($lastId) {
		$tempArray = explode ( "0", $lastId );
		$newIdVal = ( int ) $lastId + 1;
		$limit = 5 - strlen((string)$newIdVal);
		for($i = 0; $i < $limit; $i ++) {
			$newId .= "0";
		}
		$newId .= $newIdVal;
		$newId = "applicant" . $newId;
		return $newId;
	}
}
?>