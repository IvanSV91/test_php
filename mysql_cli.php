<?php

class UserDatabase {
	private $connection;

	public function __construct($host, $username, $password, $database){
		$this->connection = new mysqli($host, $username, $password, $database);
		if($this->connection->connect_error) {
			die("Connection failed: " .$this->connection->connect_error);
		}
	}
	public function __destruct() {
		$this->connection->close();
	}

	public function registerUser($name, $login, $hashPassword, $email) {
		$sql = "INSERT INTO `users` (`name`, `login`, `password`, `email`) Values (?, ?, ?, ?)";

		if($stmt = $this->connection->prepare($sql))
		{
			$stmt->bind_param("ssss", $name, $login, $hashPassword, $email);
			
			if(!$stmt->execute()){
				echo "something wrong";
				$stmt->close();
				return false;
			}
			$stmt->close();
			return true;
		}else {
			echo "something wrong";
			$stmt->close();
			return false;	
		}
	}

	public function userAuth($email, $password) {
		$sql = "SELECT password, user_id FROM users WHERE email = ?";
	
		$stmt = $this->connection->prepare($sql);
		$stmt->bind_param('s', $email);
		$stmt->execute();

    	$result = $stmt->get_result();

    	if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$hashPassword = $row['password'];
				if(password_verify($password, $hashPassword)) {
				$stmt->close();		
				return $row['user_id'];
				
				}
			}
		$stmt->close();
		return false;
	}    


	public function setUserSession($user_id) {
	
		$sql = "SELECT * FROM users WHERE user_id=?";
		if($stmt = $this->connection->prepare($sql)) {
			$stmt->bind_param("s", $user_id);
			if(!$stmt->execute()){
				echo "Something wrong:";
				$stmt->close();
				return false;
			}
		

			$result = $stmt->get_result();

			if($result->num_rows > 0) {
				$user_data = $result->fetch_assoc();
				$_SESSION["user"] = $user_data;
			
				$stmt->close();
				return true;
			}
			else {
				echo "something went wrong";
				$stmt->close();
				return false;
			}
		}else {
			echo "smth went wrong";
			$stmt->close();
			return false;
		}
	}
	
	public function editUserProfileSql($oldData, $newData, $key)
	{
		$sql = "UPDATE users SET `$key`='$newData' where `$key` ='$oldData'";
		
		if($this->connection->query($sql) === TRUE)
        {
              echo "record created";
        } else {
             echo "Error: " .$sql . "<br>" . $this->connection->error;   
   			}
	
	}

    public function editUserPassword($oldData, $hash, $key)
	{
		if($key == "password"){	
			$hash = password_hash($hash, PASSWORD_DEFAULT);
		}

        $sql = "UPDATE users SET `$key`=? where `$key`=?";
		$stmt = $this->connection->prepare($sql);
        $stmt->bind_param('ss', $hash, $oldData);

        $stmt->execute();

        $result = $stmt->get_result();
			echo "working";
		$stmt->close();
    }




}
?>
