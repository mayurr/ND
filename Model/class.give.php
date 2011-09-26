<?php
session_start();
include_once ("../SqlWrapper/Class.DatabaseAlt.php");

class Give {
	
	private $giveId;
	private $userId;
	private $objectId;
	private $startDate;
	private $endDate;
	private $comments;
	private $status;
	private $location;
	private $timestamp;
	private $tableName;
	private $columnArray;
	private $valueArray;
	private $whereColumn;
	private $whereColumnValue;
	private $db;
	
	function __construct() {
		
	}
	
	/**
	 * @return the $giveId
	 */
	public function getGiveId() {
		return $this->giveId;
	}
	
	/**
	 * @return the $userId
	 */
	public function getUserId() {
		return $this->userId;
	}
	
	/**
	 * @return the $objectId
	 */
	public function getObjectId() {
		return $this->objectId;
	}
	
	/**
	 * @return the $startDate
	 */
	public function getStartDate() {
		return $this->startDate;
	}
	
	/**
	 * @return the $endDate
	 */
	public function getEndDate() {
		return $this->endDate;
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
	 * @return the $location
	 */
	public function getLocation() {
		return $this->location;
	}
	
	/**
	 * @return the $timestamp
	 */
	public function getTimestamp() {
		return $this->timestamp;
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
	 * @param field_type $giveId
	 */
	public function setGiveId($giveId) {
		$this->giveId = $giveId;
	}
	
	/**
	 * @param field_type $userId
	 */
	public function setUserId($userId) {
		$this->userId = $userId;
	}
	
	/**
	 * @param field_type $objectId
	 */
	public function setObjectId($objectId) {
		$this->objectId = $objectId;
	}
	
	/**
	 * @param field_type $startDate
	 */
	public function setStartDate($startDate) {
		$this->startDate = $startDate;
	}
	
	/**
	 * @param field_type $endDate
	 */
	public function setEndDate($endDate) {
		$this->endDate = $endDate;
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
	 * @param field_type $location
	 */
	public function setLocation($location) {
		$this->location = $location;
	}
	
	/**
	 * @param field_type $timestamp
	 */
	public function setTimestamp($timestamp) {
		$this->timestamp = $timestamp;
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
	 * @param field_type $columnArray
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
	
	public function insertGive() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("INSERT INTO give (give_id, user_id, object_id, start_date, end_date, comments, status, location) VALUES ('".$this->giveId."','".$this->userId."','".$this->objectId."','".$this->startDate."','".$this->endDate."','".mysql_real_escape_string($this->comments)."','".$this->status."','".mysql_real_escape_string($this->location)."')");
		$resultArray = $this->db->executeQuery();
		return $resultArray;
	}
	
	public function updateGive() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("UPDATE give SET status='".$this->status."' WHERE give_id='".$this->giveId."'");
		$resultArray = $this->db->executeQuery();
		return $resultArray;
	}
	
	public function deleteGive() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("DELETE FROM give WHERE give_id='".$this->giveId."'");
		$resultArray = $this->db->executeQuery();
		return $resultArray;
	}
	
	public function getLastGiveId() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("SELECT give_id FROM give");
		$result = $this->db->executeQuery();
		if (sizeof ( $result ) > 0) {
			for($i = 0; $i <(sizeof($result)); $i++) {
				$idArray [$i] = explode ( "e", $result [$i] ['give_id'] );
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
		$newId = "give" . $newId;
		return $newId;
	}

}
?>