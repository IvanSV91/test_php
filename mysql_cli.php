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
		$sql_q = "SELECT email, password from users where email='$email' and password='$password'";

    	$result = $this->connection->query($sql_q);

    	if ($result->num_rows > 0) {
        	$row = $result->fetch_assoc();
            return true;
		}else{
        	echo "Invalid Email or Password";
       		return false;
    	}
	}    
}



//function mysqli_cli($name, $login, $password, $email)
//{
//
//		$conn = new mysqli("localhost", "root", "qwerty", "reg_users");
//		if ($conn->connect_error)
//		{
//		   	die("Connection failed: " . $conn->connect_error);
//		}
//		else
//		{
//       		echo "Access";
//    	}

//		$sql_q = "INSERT INTO `users` (`name`, `login`, `password`, `email`) Values ('$name', '$login', '$password', '$email')";
		
//		if($conn->query($sql_q) === TRUE)
//		{
//			echo "record created";
//		}	
//		else
//		{
//			echo "Error: " .$sql_q . "<br>" . $conn->error;
//		}
		
//		$conn->close();
//}

//function mysqli_cli_auth($email, $password)
//{
//	$conn = new mysqli("localhost", "root", "qwerty", "reg_users");
  //      if ($conn->connect_error)
    //    {
    //        die("Connection failed: " . $conn->connect_error);
    //    }
    //    else
    //    {
    //        echo "Access";
    //    }

//	$sql_q = "SELECT email, password from users where email='$email' and password='$password'";
	
//	$result = $conn->query($sql_q);
    
//    if ($result->num_rows > 0) {
//        $row = $result->fetch_assoc();
//        if ($row['password'] != $password) {
//            echo "Invalid login or password.";
//			$conn->close();
//		 	return false;	
//		} else {
//			$conn->close();
//			return true;
  //  	}
//	}else{
//		$conn->close();
//		echo "Invalid Email or Password";
//		return false;
//	}
	
//	$conn->close();
//	return false;
//}

?>
