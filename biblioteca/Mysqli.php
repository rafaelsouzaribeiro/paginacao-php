<?php
namespace biblioteca;

class Mysqli  extends Banco{
	public function init(){
		$this->servername="localhost";
		$this->username="root";
		$this->password="root";
		$this->db ="vendas";
	}
	
	
	public function Conectar(): ?object{
		$this->conn = mysqli_connect($this->servername, $this->username, $this->password);
		
		// Check connection
		if (!$this->conn) {
			die("Connection failed: " . mysqli_connect_error());
			
		}

		return $this;
	
	}

	public function SelectDb(): ?object{
			// make foo the current db
			$db_selected = mysqli_select_db($this->conn,$this->db);
			if (!$db_selected) {
				die ('Can\'t use foo : ' . mysql_error());
			}
	
			return $this;
		
	}
	
	
	
	public function FetchAll($sql): ?array{
		$sql = mysqli_query($this->conn,$sql) or mysql_error();
		
		$array = array();
		while($dados=mysqli_fetch_object($sql))
		{
			array_push($array,$dados);
		}
		
		return $array;
	}
	
	public function FetchAllArray($sql): ?array{
		$sql = mysqli_query($this->conn,$sql) or mysql_error();
		$array = array();
		while($dados=mysqli_fetch_array($sql))
		{
	
			array_push($array,$dados);
		}
		
		return $array;
	}	
	
	public function ExecuteSql($sql): ?bool{
		
		mysqli_query($this->conn,$sql);
		
		if(mysqli_error($this->conn)){
			return false;
		}else{
			$this->last_id = mysqli_insert_id($this->conn);
			return true;
		}

	}
	
	
	public function __destruct(){
			@mysqli_close($this->conn);
			parent::__destruct();
	}
}

?>