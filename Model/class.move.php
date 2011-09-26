<?php
session_start();
include_once ("../SqlWrapper/Class.DatabaseAlt.php");

class Move {
	
	private $userId;
	private $x1;
	private $y1;
	private $x2;
	private $y2;
	private $db;
	private $dx;
	private $dy;
	private $distance;
	
	/**
	 * @return the $x1
	 */
	public function getX1() {
		return $this->x1;
	}

	/**
	 * @return the $y1
	 */
	public function getY1() {
		return $this->y1;
	}

	/**
	 * @return the $x2
	 */
	public function getX2() {
		return $this->x2;
	}

	/**
	 * @return the $y2
	 */
	public function getY2() {
		return $this->y2;
	}

	/**
	 * @param field_type $x1
	 */
	public function setX1($x1) {
		$this->x1 = $x1;
	}

	/**
	 * @param field_type $y1
	 */
	public function setY1($y1) {
		$this->y1 = $y1;
	}

	/**
	 * @param field_type $x2
	 */
	public function setX2($x2) {
		$this->x2 = $x2;
	}

	/**
	 * @param field_type $y2
	 */
	public function setY2($y2) {
		$this->y2 = $y2;
	}

	/**
	 * @return the $userId
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * @param field_type $userId
	 */
	public function setUserId($userId) {
		$this->userId = $userId;
	}

	public function getPosition() {
		$this->db = new DatabaseAlt();
		$this->db->setQuery("SELECT x,y FROM users where user_id='".$this->userId."'");
		$resultArray = $this->db->executeQuery();
		return $resultArray;
	}
	
	public function getDx($distance) {
		$this->dx = (5.5*($this->x2 - $this->x1))/$distance;
		return round($this->dx,2);
	}
	
	public function getDy($distance) {		
		$this->dy = (5.5*($this->y2 - $this->y1))/$distance;
		return round($this->dy,2);
	}
	
	public function getDistance() {
		$this->distance = sqrt(pow(($this->x2-$this->x1),2) + pow(($this->y2-$this->y1),2));
		return round($this->distance,2);
	}
	 
}
?>