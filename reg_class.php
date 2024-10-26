<?php

class UserRegistration {
	public $name;
	public $login;
	public $email;
	public $password;
	public $password_check;
	public $hashPassword;

	public $nameErr = "";
	public $loginErr = "";
	public $emailErr = "";
	public $passErr = "";

	public function __construct($data) {
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$this->name = $this->sanitizeInput($data["user_name"]);
			$this->login = $this->sanitizeInput($data["login"]);
			$this->email = $data["email"];
			$this->password = $data["password"];
			$this->password_check = $data["password_check"];
			$this->validate();
		}
	}

	public function enterErrors(){
		if(!empty($this->nameErr))
    	{
        	echo "<p style=\"color: red\">" . $this->nameErr ."</p>";
    	}
    	if(!empty($this->loginErr))
    	{
        	echo "<p style=\"color: red\">" . $this->loginErr . "</p>";
		}
		if(!empty($this->emailErr))
		{
				echo "<p style=\"color: red\">" . $this->emailErr ." </p>";
		}
    	if(!empty($this->passErr))
    	{
        	echo "<p style=\"color: red\">" . $this->passErr ."</p>";
    	}

	}

	protected function sanitizeInput($data) {
		return htmlspecialchars(stripslashes(trim($data)));
	}

	private function validate() {
		$this->validateName();
		$this->validateLogin();
		$this->validateEmail();
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
	
	protected function validateLogin() {

		echo "function ValidateLogin handle $this->login <br>";
		
		if(empty($this->login)) {
			$this->loginErr = "Enter your login";
			return false;
		} else {
				if (!$this->strlenCheck($this->login, 3, 32, $this->loginErr)) {	
						return false;
				}
			if (!preg_match("/^[a-zA-Z0-9]*$/", $this->login)) {
				$this->loginErr = "Only letters and numbers are allowed for login";
				return false;
			}
		}
		return true;
	}


	protected function validateEmail() {
        if (empty($this->email)) {
            $this->emailErr = "Enter your email";
            return false;
        } else {
            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->emailErr = "Invalid email format";
                return false;
            }
        }
        return true;
    }

		
	protected function validatePassword() {
		if(empty($this->password) || empty($this->password_check)) {
			$this->passErr = "Create a password and enter it in both fields";
			return false;
		}
		elseif(strcmp($this->password, $this->password_check)){
			$this->passErr = "The passwords entered in both passwords fields should match";
			return false;
		}
		elseif (!$this->validatePasswordComplexity($this->password, 8, 32, $this->passErr)) {
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
			return empty($this->nameErr) && empty($this->loginErr) && empty($this->passErr) && empty($this->emailErr);
	}

	private function registerUser() {
		$dbReg = new UserDatabase("localhost", "root", "qwerty", "reg_users");
		$this->hashPassword = password_hash($this->password, PASSWORD_DEFAULT);
		$dbReg->registerUser($this->name, $this->login, $this->hashPassword, $this->email);
		header("Location: ./auth.php");
	}
}

?>
