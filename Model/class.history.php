<?php
session_start();
include_once ("../SqlWrapper/Class.DatabaseAlt.php");

class History {
	
	private $transactionId;
	private $transactionType;
	private $startDate;
	private $endDate;
	private $comments;
	private $status;
	private $openingTimestamp;
	private $closingTimestamp;
	private $objectId;
	private $objectType;
	private $objectName;
	private $objectImage;
	private $objectDescription;
	private $giverId;
	private $giverX;
	private $giverY;
	private $getterId;
	private $getterX;
	private $getterY;
	private $applicantIds;
	private $applicantTimestamps;	
	
	/**
	 * @return the $transactionId
	 */
	public function getTransactionId() {
		return $this->transactionId;
	}

	/**
	 * @return the $transactionType
	 */
	public function getTransactionType() {
		return $this->transactionType;
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
	 * @return the $openingTimestamp
	 */
	public function getOpeningTimestamp() {
		return $this->openingTimestamp;
	}

	/**
	 * @return the $closingTimestamp
	 */
	public function getClosingTimestamp() {
		return $this->closingTimestamp;
	}

	/**
	 * @return the $objectId
	 */
	public function getObjectId() {
		return $this->objectId;
	}

	/**
	 * @return the $objectType
	 */
	public function getObjectType() {
		return $this->objectType;
	}

	/**
	 * @return the $objectName
	 */
	public function getObjectName() {
		return $this->objectName;
	}

	/**
	 * @return the $objectImage
	 */
	public function getObjectImage() {
		return $this->objectImage;
	}

	/**
	 * @return the $objectDescription
	 */
	public function getObjectDescription() {
		return $this->objectDescription;
	}

	/**
	 * @return the $giverId
	 */
	public function getGiverId() {
		return $this->giverId;
	}

	/**
	 * @return the $giverX
	 */
	public function getGiverX() {
		return $this->giverX;
	}

	/**
	 * @return the $giverY
	 */
	public function getGiverY() {
		return $this->giverY;
	}

	/**
	 * @return the $getterId
	 */
	public function getGetterId() {
		return $this->getterId;
	}

	/**
	 * @return the $getterX
	 */
	public function getGetterX() {
		return $this->getterX;
	}

	/**
	 * @return the $getterY
	 */
	public function getGetterY() {
		return $this->getterY;
	}

	/**
	 * @return the $applicantIds
	 */
	public function getApplicantIds() {
		return $this->applicantIds;
	}

	/**
	 * @return the $applicantTimestamps
	 */
	public function getApplicantTimestamps() {
		return $this->applicantTimestamps;
	}

	/**
	 * @param field_type $transactionId
	 */
	public function setTransactionId($transactionId) {
		$this->transactionId = $transactionId;
	}

	/**
	 * @param field_type $transactionType
	 */
	public function setTransactionType($transactionType) {
		$this->transactionType = $transactionType;
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
	 * @param field_type $openingTimestamp
	 */
	public function setOpeningTimestamp($openingTimestamp) {
		$this->openingTimestamp = $openingTimestamp;
	}

	/**
	 * @param field_type $closingTimestamp
	 */
	public function setClosingTimestamp($closingTimestamp) {
		$this->closingTimestamp = $closingTimestamp;
	}

	/**
	 * @param field_type $objectId
	 */
	public function setObjectId($objectId) {
		$this->objectId = $objectId;
	}

	/**
	 * @param field_type $objectType
	 */
	public function setObjectType($objectType) {
		$this->objectType = $objectType;
	}

	/**
	 * @param field_type $objectName
	 */
	public function setObjectName($objectName) {
		$this->objectName = $objectName;
	}

	/**
	 * @param field_type $objectImage
	 */
	public function setObjectImage($objectImage) {
		$this->objectImage = $objectImage;
	}

	/**
	 * @param field_type $objectDescription
	 */
	public function setObjectDescription($objectDescription) {
		$this->objectDescription = $objectDescription;
	}

	/**
	 * @param field_type $giverId
	 */
	public function setGiverId($giverId) {
		$this->giverId = $giverId;
	}

	/**
	 * @param field_type $giverX
	 */
	public function setGiverX($giverX) {
		$this->giverX = $giverX;
	}

	/**
	 * @param field_type $giverY
	 */
	public function setGiverY($giverY) {
		$this->giverY = $giverY;
	}

	/**
	 * @param field_type $getterId
	 */
	public function setGetterId($getterId) {
		$this->getterId = $getterId;
	}

	/**
	 * @param field_type $getterX
	 */
	public function setGetterX($getterX) {
		$this->getterX = $getterX;
	}

	/**
	 * @param field_type $getterY
	 */
	public function setGetterY($getterY) {
		$this->getterY = $getterY;
	}

	/**
	 * @param field_type $applicantIds
	 */
	public function setApplicantIds($applicantIds) {
		$this->applicantIds = $applicantIds;
	}

	/**
	 * @param field_type $applicantTimestamps
	 */
	public function setApplicantTimestamps($applicantTimestamps) {
		$this->applicantTimestamps = $applicantTimestamps;
	}

	public function insertTransaction(){
		$this->db = new DatabaseAlt();
		$this->db->setQuery("INSERT INTO history (transaction_id,transaction_type,start_date,end_date,comments,status,opening_timestamp,closing_timestamp,object_id,object_type,object_name,object_image,object_description,giver_id,giver_x,giver_y,getter_id,getter_x,getter_y,applicant_ids,applicant_timestamps) VALUES('".$this->transactionId."','".$this->transactionType."','".$this->startDate."','".$this->endDate."','".mysql_real_escape_string($this->comments)."','".$this->status."','".$this->openingTimestamp."','".$this->closingTimestamp."','".$this->objectId."','".$this->objectType."','".mysql_real_escape_string($this->objectName)."','".$this->objectImage."','".mysql_real_escape_string($this->objectDescription)."','".$this->giverId."',".$this->giverX.",".$this->giverY.",'".$this->getterId."',".$this->getterX.",".$this->getterY.",'".$this->applicantIds."','".$this->applicantTimestamps."')");
		$resultArray = $this->db->executeQuery();
		return $resultArray;
	}
	
	public function getLastTransactionId() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("SELECT transaction_id FROM history");
		$result = $this->db->executeQuery();
		if (sizeof ( $result ) > 0) {
			for($i = 0; $i <(sizeof($result)); $i++) {
				$idArray [$i] = explode ( "n", $result [$i] ['transaction_id'] );
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
		$newId = "tran" . $newId;
		return $newId;
	}
}
?>