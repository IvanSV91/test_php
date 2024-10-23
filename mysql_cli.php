<?php

function mysqli_cli($name, $login, $password, $email)
{

		$conn = new mysqli("localhost", "root", "qwerty", "reg_users");
		if ($conn->connect_error)
		{
 		   	die("Connection failed: " . $conn->connect_error);
		}
		else
		{
       		echo "Access";
    	}

		$sql_q = "INSERT INTO `users` (`name`, `login`, `password`, `email`) Values ('$name', '$login', '$password', '$email')";
		
		if($conn->query($sql_q) === TRUE)
		{
			echo "record created";
		}	
		else
		{
			echo "Error: " .$sql_q . "<br>" . $conn->error;
		}
		
		$conn->close();
}

function mysqli_cli_auth($email, $password)
{
	$conn = new mysqli("localhost", "root", "qwerty", "reg_users");
        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }
        else
        {
            echo "Access";
        }

	$sql_q = "SELECT email, password from users where email='$email' and password='$password'";
	
	$result = $conn->query($sql_q);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['password'] === $password) {
            header("Location: ./profile.php");
            exit();
        } else {
            echo "Invalid login or password.";
        }
    } else {
        echo "No rows";
    }


    $conn->close();

	
}

?>
