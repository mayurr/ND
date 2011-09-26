<?php
session_start();
include_once ("../SqlWrapper/Class.DatabaseAlt.php");

class Object {
	
	private $objectId;
	private $name;
	private $description;
	private $image;
	private $type;
	private $counter;
	private $tableName;
	private $columnArray;
	private $valueArray;
	private $whereColumn;
	private $whereColumnValue;
	private $andOr;
	private $db;
	
	function __construct() {

	}
	
	/**
	 * @return the $objectId
	 */
	public function getObjectId() {
		return $this->objectId;
	}
	
	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @return the $description
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * @return the $image
	 */
	public function getImage() {
		return $this->image;
	}
	
	/**
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * @return the $counter
	 */
	public function getCounter() {
		return $this->counter;
	}
	
	/**
	 * @param field_type $objectId
	 */
	public function setObjectId($objectId) {
		$this->objectId = $objectId;
	}
	
	/**
	 * @param field_type $name
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * @param field_type $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
	
	/**
	 * @param field_type $image
	 */
	public function setImage($image) {
		$this->image = $image;
	}
	
	/**
	 * @param field_type $type
	 */
	public function setType($type) {
		$this->type = $type;
	}
	
	/**
	 * @param field_type $counter
	 */
	public function setCounter($counter) {
		$this->counter = $counter;
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
	
	/**
	 * @param field_type $whereColumnArray
	 */
	public function setWhereColumnArray($whereColumnArray) {
		$this->whereColumnArray = $whereColumnArray;
	}
	
	/**
	 * @param field_type $whereColumnValueArray
	 */
	public function setWhereColumnValueArray($whereColumnValueArray) {
		$this->whereColumnValueArray = $whereColumnValueArray;
	
	}
	
	/**
	 * @param field_type $andOr
	 */
	public function setAndOr($andOr) {
		$this->whereColumnValueArray = $andOr;
	
	}
	
	public function insertObject() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("INSERT INTO object (object_id, name, description, image, type, counter) VALUES ('".$this->objectId."','".$this->name."','".mysql_real_escape_string($this->description)."','".$this->image."','".$this->type."',".$this->counter.")");
		$resultArray = $this->db->executeQuery();
		return $resultArray;
	}
	
	public function fetchObjects() {
		$connect = $this->db->connect ();
		if ($connect) {
			$result = $this->db->select ( $this->tableName, $this->columnArray, $this->whereColumn, null, $this->whereColumnValue );
		}
		return $result;
	}
	
	public function getLastObjectId() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("SELECT object_id FROM object");
		$result = $this->db->executeQuery();
		if (sizeof ( $result ) > 0) {
			for($i = 0; $i <(sizeof($result)); $i++) {
				$idArray [$i] = explode ( "j", $result [$i] ['object_id'] );
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
		$newId = "obj" . $newId;
		return $newId;
	}

}
?>