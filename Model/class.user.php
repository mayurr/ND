<?php
session_start();
include_once ("../SqlWrapper/Class.DatabaseAlt.php");

class User {
	private $id;
	private $fName;
	private $lName;
	private $db;
	private $tableName;
	private $columnArray;
	private $whereColumn;
	private $whereColumnValue;
	
	public function __construct(){
	
	}
	
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return the $fName
	 */
	public function getFName() {
		return $this->fName;
	}
	
	/**
	 * @return the $lName
	 */
	public function getLName() {
		return $this->lName;
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
	 * @return the $whereColumn
	 */
	public function getWhereColumn() {
		return $this->whereColumn;
	}
	
	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * @param field_type $fName
	 */
	public function setFName($fName) {
		$this->fName = $fName;
	}
	
	/**
	 * @param field_type $lName
	 */
	public function setLName($lName) {
		$this->lName = $lName;
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
	
	public function getUserDetails() {
		$connect = $this->db->connect ();
		if ($connect) {
			$result = $this->db->select ( $this->tableName, $this->columnArray, $this->whereColumn, null, $this->whereColumnValue );
			$this->setFName ( $result [0] ['first_name'] );
			$this->setLName ( $result [0] ['last_name'] );
		}
		return $result;
	}
	
	public function getPositions() {
		$connect = $this->db->connect ();
		if ($connect) {
			$result = $this->db->select ( $this->tableName, $this->columnArray, null, null, null );
			return $result;
		}
	}
	
	public function getAllUsers() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("SELECT user_id, first_name, last_name, email, image, x, old_x, y, old_y from users");
		$resultArray = $this->db->executeQuery();
		return $resultArray;
	}
	
	public function updatePositions($x,$y,$oldX,$oldY) {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("UPDATE users SET x=".$x.",y=".$y.",old_x=".$oldX.",old_y=".$oldY." WHERE user_id='".$this->id."'");
		$resultArray = $this->db->executeQuery();
		return $resultArray;
	}

}
?>