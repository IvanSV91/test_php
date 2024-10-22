<?php

class UserRegistration {
	public $name;
	public $login;
	public $password;
	public $password_check;

	public $nameErr = "";
	public $loginErr = "";
	public $passErr = "";

	public function __construct($data) {
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$this->name = $this->sanitizeInput($data["user_name"]);
			$this->login = $this->sanitizeInput($data["login"]);
			$this->password = $data["password"];
			$this->password_check = $data["password_check"];
			$this->validate();
		}
	}

	public function enterErrors(){
		if(!empty($this->nameErr))
    	{
        	echo "<p style=\"color: red\">" . $this->nameErr ." for Name</p>";
    	}
    	if(!empty($this->loginErr))
    	{
        	echo "<p style=\"color: red\">" . $this->loginErr ." for Login</p>";
    	}
    	if(!empty($this->passErr))
    	{
        	echo "<p style=\"color: red\">" . $this->passErr ."</p>";
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
		if(empty($this->password) || empty($this->password_check)) {
			$this->passErr = "Create a password and enter it in both fields";
			return false;
		}
		elseif(strcmp($this->password, $this->password_check)){
			$this->passErr = "The passwords entered in both passwords fields should match";
			return false;
		}
		elseif ($this->validatePasswordComplexity($this->password, 8, 32, $this->passErr)) {
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
			$error = "A minimum of " . $min_count . " symbols is required";
            return false;
        }

       if ($length > $max_count) {
           $error = "A maximum of " . $max_count . " symbols is required.";
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

?>
