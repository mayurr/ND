<?php
include_once ("../SqlWrapper/class.database.php");
class GiveGetList {
	private $db;
	private $tableName;
	private $columnArray;
	private $whereColumn;
	private $whereColumnValue;
	
	function __construct() {
		$this->db = new Database ();
	}
	
	public function setTableName($tableName) {
		$this->tableName = $tableName;
	}
	
	public function setColumnArray($columnArray) {
		$this->columnArray = $columnArray;
	}
	
	public function setWhereColumn($whereColumn) {
		$this->whereColumn = $whereColumn;
	}
	
	public function setWhereColumnValue($whereColumnValue) {
		$this->whereColumnValue = $whereColumnValue;
	}
	
	public function fetchGiveLists() {
		$connect = $this->db->connect ();
		if ($connect) {
			$result = $this->db->select($this->tableName, $this->columnArray, $this->whereColumn, "timestamp", $this->whereColumnValue);
		}
		return $result;
	}
	public function fetchGetLists() {
		$connect = $this->db->connect ();
		if ($connect) {
			$result = $this->db->select($this->tableName, $this->columnArray, $this->whereColumn, "timestamp", $this->whereColumnValue);
		}
		return $result;
	}
}
?>