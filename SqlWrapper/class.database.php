<?php
session_start();

class Database{
	private $db_host="localhost";
	private $db_user="root";
	private $db_password="";
	private $db_dbname="nayadaur";
	private $numResults;
	private $result=array();
	public $connect;
	
	public function connect(){		
		$this->connect = mysql_pconnect($this->db_host,$this->db_user,$this->db_password);
		if($this->connect){
			$seldb=mysql_select_db($this->db_dbname,$this->connect);
			if($seldb){
				$this->con=true;
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
		
	}
	
	public function disconnect(){
		if($this->con){
			if(mysql_close()){
				$this->con=false;
				return true;
			}
			else{
				return false;
			}
		}
	}
	
	public function tableExists($table){
		$tableInDb=mysql_query("SHOW tables FROM ".$this->db_dbname." LIKE '".$table."'");
		if($tableInDb){
			if(mysql_num_rows($tableInDb)==1){
				return true;				
			}
			else{
				return false;
			}
		}
	}
	
	
	/**
	 * method to execute select query
	 * @param String $table
	 * @param Array $columns
	 * @param String $where
	 * @param String $orderby
	 * @param String $id
	 * @return multitype:|boolean
	 */
	public function select($table,$columns,$where,$orderby,$id){
		$arrColumns=implode(',',$columns);
		$q='SELECT '.$arrColumns.' FROM '.$table;
		if(!is_array($where)){
			if($where != ''){
				$q.=' WHERE '.$where.' = "'.$id.'"';		
			}				
		}
		else {
			$q .= ' WHERE ';
			for ($i=0; $i<sizeof($where); $i++){
				if($i == (sizeof($where)-1)){
					$q .= $where[$i].' ="'.$id[$i].'"';
				}
				else {
					$q .= $where[$i].' ="'.$id[$i].'" OR ';					
				}			
			}
		}
		if($orderby != ''){
			$q.=' ORDER BY '.$orderby." DESC";			
		}
		if($this->tableExists($table)){
			$query=mysql_query($q);
			$ret_Val = 0;
			if($query){
				$this->numResults=mysql_num_rows($query);
				for($i = 0; $i < $this->numResults; $i++){
					$r=mysql_fetch_array($query);
					$keys=array_keys($r);
					for($x = 0; $x < count($keys); $x++){
						if(!is_int($keys[$x])){
							if(mysql_num_rows($query)>=1){
							$this->result[$i][$keys[$x]]=$r[$keys[$x]];
							}
						}
					}
				}
				return $this->result;
			}
			else{
				return false;
			}		
		}	
	}
	
	
	public function selectGiveLists(){
		//echo $q;
		$query=mysql_query("SELECT * FROM give
INNER JOIN object ON object.object_id = give.object_id  INNER JOIN users ON give.user_id=users.userid order by timestamp desc" );
		//echo $query;
		if($query){
				$this->numResults=mysql_num_rows($query);
				for($i = 0; $i < $this->numResults; $i++){
					$r=mysql_fetch_array($query);
					$keys=array_keys($r);
					for($x = 0; $x < count($keys); $x++){
						if(!is_int($keys[$x])){
							if(mysql_num_rows($query)>=1){
							$this->result[$i][$keys[$x]]=$r[$keys[$x]];
							}
						}
					}
				}
				return $this->result;
			}
			else{
				return false;
			}		
		
	}
	
	
public function selectGetLists(){
		//echo $q;
		$query=mysql_query("SELECT * FROM get
INNER JOIN object ON object.object_id = get.object_id  INNER JOIN users ON get.user_id=users.userid order by timestamp desc" );
		//echo $query;
		if($query){
				$this->numResults=mysql_num_rows($query);
				for($i = 0; $i < $this->numResults; $i++){
					$r=mysql_fetch_array($query);
					$keys=array_keys($r);
					for($x = 0; $x < count($keys); $x++){
						if(!is_int($keys[$x])){
							if(mysql_num_rows($query)>=1){
							$this->result[$i][$keys[$x]]=$r[$keys[$x]];
							}
						}
					}
				}
				return $this->result;
			}
			else{
				return false;
			}		
		
	}
	
	public function insert($table,$values,$columns){
		if($this->tableExists($table)){
			$insert='INSERT INTO '.$table;
			if($columns != null){
				$arr=implode(',',$columns);
				$insert.='('.$arr.')';
				for($i=0;$i<count($values);$i++){
					if(is_string($values[$i])){
						$values[$i]='"'.$values[$i].'"';
					}
					
				}
				$values=implode(',',$values);
				$insert.='VALUES('.$values.')';
				//echo $insert;
				$ins=mysql_query($insert);
				if($ins){
					return mysql_insert_id();
				}
				else{
					return false;
				}
			}
		}
		
	}
	
	
		
	public function joiningMethods($table1,$table2,$columns,$where='null',$orderby='null',$val1,$val2,$id){
		$arrColumns=implode(',',$columns);
		$q='SELECT '.$arrColumns.' FROM '.$table1.' INNER JOIN '.$table2.' ON '.$table2 .' . '. $val1.' = '.$table1.' . '.$val2;
		if($where != 'null'){
			$q.=' WHERE '.$where.' = "'.$id.'"';
		}
		if($orderby != 'null'){
			$q.='ORDERBY'.$orderby;
		}
		$query=mysql_query($q);
		if($query){
				$this->numResults=mysql_num_rows($query);
				for($i = 0; $i < $this->numResults; $i++){
					$r=mysql_fetch_array($query);
					$keys=array_keys($r);
					for($x = 0; $x < count($keys); $x++){
						if(!is_int($keys[$x])){
							if(mysql_num_rows($query)>1){
							$this->result[$i][$keys[$x]]=$r[$keys[$x]];
							}
							else if(mysql_num_rows($query)<1)
							$this->result=null;
							else
							$this->result[$keys[$x]]=$r[$keys[$x]];
							
							
						}
					}
				}
				return true;
			}
			else{
				return false;
			}
	}
	
	/*public function update($table,$val1,$val2,$val3,$val4,$val5,$val6,$id){
		$query="UPDATE $table SET EventName = '$val1', image ='$val2', EventDesc = '$val3', date = '$val4', time = '$val5', venue = '$val6' WHERE id='$id'";
		//echo $query;
		$update=mysql_query($query);
		if($update){
			echo "Updated Succ";
		}
	}*/
	
	public function update($table,$columns,$values,$where,$whereValue) {
		$query = "UPDATE ".$table." SET ";
		for ($i=0;$i<sizeof($columns);$i++) {
			if ($i == (sizeof($columns)-1)) {
				$query .= $columns[$i]." = '".$values[$i]."'";
			}
			else {
				$query .= $columns[$i]." = ".$values[$i].",";
			}
		}
		if ($where != null) {
			$query .= " WHERE ".$where." = '".$whereValue."'";
		}
		$update=mysql_query($query);
		if($update) {
			return true;
		}		
		else{
			return false;
		}
	}
	
	
	public function getResult(){
		return $this->result;
	}
	
}
?>