<?php

function mysqli_cli($name, $login, $password)
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

		$sql_q = "INSERT INTO `users` (`name`, `login`, `password`) Values ('$name', '$login', '$password')";
		
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

?>
