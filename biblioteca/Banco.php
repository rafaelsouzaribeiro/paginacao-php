<?php
namespace biblioteca;

abstract class Banco{
	private $servername;
	private $username;
	private $password;
	private $db;
	private $conn;
	private $last_id;
	
	public function __get($prop) {
        return $this->$prop;
    }
        
    public function __set($prop, $val) {
        $this->$prop = $val;
    }
	
	public function __destruct(){
		unset($this->servername);
		unset($this->username);
		unset($this->password);
		unset($this->db);
		unset($this->conn);
		unset($this->last_id);
		
	}	


	
}