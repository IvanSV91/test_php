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
		$sql_q = "INSERT INTO `users` (`name`, `login`, `password`, `email`) Values ('$name', '$login', '$hashPassword', '$email')";

     	if($this->connection->query($sql_q) === TRUE)
        {
            echo "record created";
        }
        else
        {
            echo "Error: " .$sql_q . "<br>" . $this->connection->error;
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
            	return $row['user_id'];
				}
			}
        echo "Invalid Email or Password";
		$stmt->close();
		return false;
	}    


	public function setUserSession($user_id) {
	
		$sqlQ = "SELECT * FROM users WHERE user_id='$user_id'";
	
		$result = $this->connection->query($sqlQ);
		
		if($result->num_rows > 0) {
			$userData = $result->fetch_assoc();
			$_SESSION['user'] = $userData;
		}else {
				echo "user did not found";
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


}
?>
