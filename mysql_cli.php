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

	public function registerUser($name, $login, $password, $email) {
		$sql_q = "INSERT INTO `users` (`name`, `login`, `password`, `email`) Values ('$name', '$login', '$password', '$email')";

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
		$sql_q = "SELECT email, password, user_id from users where email='$email' and password='$password'";

    	$result = $this->connection->query($sql_q);

    	if ($result->num_rows > 0) {
        	$row = $result->fetch_assoc();
            return $row['user_id'];
		}else{
        	echo "Invalid Email or Password";
       		return false;
    	}
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

	
	//public function editUserProfile($oldData, $newData, $type_post)


}
?>
