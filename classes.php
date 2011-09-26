<?php
include("dbcon.php");
class User{
	public $id;
	public $userArray;
	public function chkLogin($idVal,$password){
		$this->id=$this->getId($idVal,$password);
		if($this->id==''){
			return "null";
		}
		else{
			return $this->id;
		}
	}
	
	public function getId($val1,$val2){
		$query=mysql_query("select * from users where userid='$val1' and password='$val2'");
		$row=mysql_fetch_array($query);
		return $row['id'];
	}
	
	public function getPositions(){
		$query1=mysql_query("select * from sample");
		$count=0;
		while($row1=mysql_fetch_array($query1)){
			$this->userArray[]=array();
			$this->userArray[$count]['id']=$row1['id'];
			$this->userArray[$count]['x']=$row1['x'];
			$this->userArray[$count]['y']=$row1['y'];
			$count+=1;
		}
		return $this->userArray;
	}
}


?>