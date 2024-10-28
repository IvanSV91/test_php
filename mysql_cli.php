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

	public function registerUser($name, $login, $hashPassword, $email, $phone) {
		$sql = "INSERT INTO `users` (`name`, `login`, `password`, `email`, `phone`) Values (?, ?, ?, ?, ?)";

		if($stmt = $this->connection->prepare($sql))
		{
			$stmt->bind_param("sssss", $name, $login, $hashPassword, $email, $phone);
			
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

	public function userAuth($email, $phone, $password) {
		$sql = "SELECT password, user_id FROM users WHERE email = ? OR phone = ?";
	
		$stmt = $this->connection->prepare($sql);
		$stmt->bind_param('ss', $email, $phone);
		$stmt->execute();
    	$result = $stmt->get_result();

    	if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$hashPassword = $row['password'];
				if(password_verify($password, $hashPassword)) {
				$stmt->close();		
				return $row['user_id'];
				}
		}else{
				$stmt->close();
				return false;
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
	

    public function editUserDatadb($oldData, $newData, $key)
	{
		if($key == "password"){	
			$hash = password_hash($newData, PASSWORD_DEFAULT);
		}

        $sql = "UPDATE users SET `$key`=? where `$key`=?";
		$stmt = $this->connection->prepare($sql);
        $stmt->bind_param('ss', $newData, $oldData);

        $stmt->execute();

        $result = $stmt->get_result();
			echo "working";
		$stmt->close();
    }

}
?>
