<?php
class dbConfig
{
	private $dbDriver = "mysql"; 
	private $host = "10.41.26.10"; 
	private $username = "taufik"; 
	private $password = "W4zI57"; 	
	private $database = "surveilance";		
    protected $connection;
    
	public function __construct(){
		try{
            $this->connection = new PDO($this->dbDriver.':host='.$this->host.';dbname='.$this->database,$this->username,$this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e){
        	die("Connection Error vro: " . $e->getMessage());
    	}
	}
}	

class methodDB extends dbConfig{

	public function getUsers($id){
		$query = "SELECT * FROM `registrasi` WHERE step = 'selesai' AND status = 1 AND arr_step!='' AND user_id = ".$id;
        
		try{
			$result = $this->connection->query($query);			
			return $result->fetchAll();
		}
		catch (PDOException $e){
			die("Create Error: " . $e->getMessage());
			return false;
    	}
	}

    // public function insertUsers($data){
	// 	$query = "INSERT INTO users VALUES(:id,:lastChat)"; //query
        
	// 	try{
	// 		$result = $this->connection->prepare($query);			
	// 		$result->execute([
    //             ':id' => 1,
    //             ':lastChat' => $data
	// 		]);
			
	// 		return true;
	// 	}
	// 	catch (PDOException $e){
	// 		die("Create Error: " . $e->getMessage());
	// 		return false;
    // 	}
	// }

}

$db = new methodDB();
var_dump($db->getUsers(100001561));