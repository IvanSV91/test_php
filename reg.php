<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport content="width=device-width, initialscale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="public/css/style.css">
        <title>registration</title>
	</head>
	<?php include "inc/header.php"; ?>
	<body>

<?php
include "./mysql_cli.php";

class UserRegistration {
	public $name;
	public $login;
	public $password;

	public $nameErr = "";
	public $loginErr = "";
	public $passErr = "";

	public function __construct($data) {
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$this->name = $this->sanitizeInput($data["user_name"]);
			$this->login = $this->sanitizeInput($data["login"]);
			$this->password = $data["password"];
			$this->validate();
		}
	}

	private function sanitizeInput($data) {
		return htmlspecialchars(stripslashes(trim($data)));
	}

	private function validate() {
		$this->validateName();
		$this->validateLogin();
		$this->validatePassword();

		if($this->isValid()) {
			$this->registerUser();
		}
	}

	private function validateName() {
		if(empty($this->name)) {
			$this->nameErr = "Enter your name";
			return false;
		} else {
				if($this->strlenCheck($this->name, 3, 32, $this->nameErr)) 
				{
					return false;
				}		
				if(!preg_match("/^[a-zA-Z0-9]*$/", $this->name)) {
					$this->nameErr = "Only letters and numbers are allowed";
					return false;	
			}
		}
		return true;
	}
	
	private function validateLogin() {
		if(empty($this->login)) {
			$this->loginErr = "Enter your login";
			return false;
		} else {
				if ($this->strlenCheck($this->login, 3, 32, $this->loginErr)) {	
						return false;
				}
			if (!preg_match("/^[a-zA-Z0-9]*$/", $this->login)) {
				$this->loginErr = "Only letters and numbers are allowed for login";
				return false;
			}
		}
		return true;
	}
		
	private function validatePassword() {
		if(empty($this->password)) {
			$this->passErr = "Enter password";
			return false;
		} elseif ($this->validatePasswordComplexity($this->password, 8, 32, $this->passErr)) {
			return false;
		}
		return true;	
	}

	private function validatePasswordComplexity($password, $min_count, $max_count, &$error) {
		$length = strlen($password);
    	if ($length < $min_count || $length > $max_count) {
        	$error = "Password must be between $min_count and $max_count characters";
       		 return false;
    	}

    	if (!preg_match("/[a-z]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[\W]/", $password)) {
        	$error = "Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character";
        	return false;
    	}

    	return true;
	}

	private function strlenCheck($data, $min_count, $max_count, &$error) {
		$length = strlen($data);
		
		if($length < $min_count) {
			$error = "A minimum of " . $min_count . " is required";
            return false;
        }

       if ($length > $max_count) {
           $error = "A maximum of " . $max_count . " is required.";
       	   return false;
        }

       return true;
   }

	private function isValid() {
			return empty($this->nameErr) && empty($this->loginErr) && empty($this->passErr);
	}

	private function registerUser() {
		mysqli_cli($this->name, $this->login, $this->password);
	}
}

$registration = new UserRegistration($_POST);

    $input_arr = array (
        array("name_f" => "user_name", "type" => "text", "name" => "Name"),
        array("name_f" => "login", "type" => "text", "name" => "Login"),
        array("name_f" => "password", "type" => "password", "name" => "Password")
    );

	
	 echo "<div class=\"div_table\">
            <form action=\"" . htmlspecialchars($_SERVER["PHP_SELF"]) ."\" method=\"POST\">
            <h1 style=\"text-align: center\">Sign Up</h1>
            <table>";

    $i = 0;
    while($i < count($input_arr))
	{		
		$input_f = $input_arr[$i]["name_f"];
		$input_type = $input_arr[$i]["type"];
		$input_name = $input_arr[$i]["name"];
		echo "<tr>
                <td class=\"table_td_name;\"><label for=\"{$input_f}\">{$input_name}:</label></td>
                <td><input type=\"{$input_type}\" name=\"{$input_f}\" id=\"{$input_f}\"></td>
              </tr>";
		
			$i++;
    }
	
    echo " <tr>
            <td><button type=\"submit\">Registration</button></td>
			</tr>
			</table>
		 </form>
   	 </div>
		 <div class=\"div_error\">" 
				. $registration->nameErr ."<br>"
                . $registration->loginErr . "<br>"
                . $registration->passErr . "<br>
                <br><br>
                your name: " . $registration->name ."<br>
                your login: " . $registration->login . "<br>
                your password: " .  $registration->password . "<br>
    </div>";


?>


    </body>
</html>
    




