<?php
session_start();
include ("../SqlWrapper/Class.DatabaseAlt.php");

class Login {
	
	private $userId;
	private $userName;
	private $password;
	public $db;
	private $tableName;
	private $columnArray;
	private $whereColumn;
	private $connect;
	
	/**
	 * Login Class Constructor
	 */
	function __construct() {
		$this->tableName = "login";
		$this->columnArray = array ();
		array_push ( $this->columnArray, "id", "user_name", "password" );
		$this->whereColumn = "user_name";
	}
	
	/**
	 * @return the $userId
	 */
	public function getUserId() {
		return $this->userId;
	}
	
	/**
	 * @return the $userName
	 */
	public function getUserName() {
		return $this->userName;
	}
	
	/**
	 * @return the $password
	 */
	public function getPassword() {
		return $this->password;
	}
	
	/**
	 * @return the $db Object
	 */
	public function getDbObject() {
		return $this->db;
	}
	
	/**
	 * @param field_type $userId
	 */
	public function setUserId($userId) {
		$this->userId = $userId;
	}
	
	/**
	 * @param field_type $userName
	 */
	public function setUserName($userName) {
		$this->userName = $userName;
	}
	
	/**
	 * @param field_type $password
	 */
	public function setPassword($password) {
		$this->password = $password;
	}
	
	/**
	 * method to check login credentials of user/admin
	 * @return boolean
	 */
	public function checkLogin() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("Select * from login Where user_name='".$this->userName."'");
		$resultArray = $this->db->executeQuery();
		
		if (sizeof ( $resultArray ) == 0) {
			return FALSE;
		} else {
			if ($resultArray [0] ['password'] != $this->password) {
				return FALSE;
			} else {
				echo $resultArray [0] ['id'];
				$this->userId = $resultArray [0] ['id'];
				return $this->db;
			}
		}
	}
	
	
	
	public function checkAdminLogin() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("Select * from admin Where user_name='".$this->userName."'");
		$resultArray = $this->db->executeQuery();
		if (sizeof ( $resultArray ) == 0) {
			return FALSE;
		} else {
			if ($resultArray [0] ['password'] != $this->password) {
				return FALSE;
			} else {
				echo $resultArray [0] ['id'];
				$this->userId = $resultArray [0] ['id'];
				return $this->db;
			}
		}
	}
	/**
	 * method to insert new user/admin in Login Table
	 * @return boolean
	 */
	public function insertLogin() {
		$numRows = $this->db->insert ();
		if ($numRows === 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * method to update existing user/admin in Login Table
	 * @return boolean
	 */
	public function updateLogin() {
		$numRows = $this->db->update ();
		if ($numRows === 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * method to delete existing user/admin in Login Table
	 * @return boolean
	 */
	public function deleteLogin() {
		$numRows = $this->db->delete ();
		if ($numRows === 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

}