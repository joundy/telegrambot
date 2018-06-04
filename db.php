<?php

class DBConfig{

	private $host = ""; 
	private $username = ""; 
	private $password = ""; 	
	private $database = "";		
    protected $conn;

	public function __construct(){
        try{
            $this->conn = new mysqli($this->host,$this->username,$this->password,$this->database);
        }catch (Exception $e){
            $error = $e->getMessage();
            echo $error;
        }
    }
}

class DB extends DBConfig{

    public function getUserById($id){
		$query = "".$id;

        $result = mysqli_query($this->conn,$query);

        $rows = array();
        while($r = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $rows[] = $r;
        }

        return $rows;
    }
    
    public function getUserInfo($id){
        $query = "".$id;

        $result = mysqli_query($this->conn,$query);

        $rows = array();
        while($r = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $rows[] = $r;
        }

        return $rows;
    }
}
