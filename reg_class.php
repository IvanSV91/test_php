<?php


class UserRegistration {
	private $name;
	private $login;
	private $email;
	private $phone;
	private $password;
	private $passwordCheck;
	private $hashPassword;
	protected $errors = [];
	public $err;
	
	public function __construct($data) {
		if($_SERVER["REQUEST_METHOD"] == "POST") {
				
			$this->setName($data["userName"]);		
			$this->setLogin($data["login"]);		
			$this->setEmail($data["email"]);		
			$this->setPhone($data["phone"]);		
			$this->setPassword($data["password"]);		
			$this->setPasswordCheck($data["passwordCheck"]);
			$this->validate();
			
		}
	}


	public function setName($name) {
		$this->name = $this->sanitizeInput($name);
	}

	
	public function setLogin($login) {
		$this->login = $this->sanitizeInput($login);
	}
	
	public function setEmail($email) {
		$this->email = $this->sanitizeInput($email);
	}

	public function getEmail() {
		return $this->email;
	}
	
	public function setPhone($phone) {
		$this->phone = $this->sanitizeInput($phone);
	}

	public function getPhone() {
		return $this->phone;
	}

	public function setPasswordCheck($passwordCheck){ 
		$this->passwordCheck = $this->sanitizeInput($passwordCheck);
	}

	public function setPassword($password) {
		$this->password = $this->sanitizeInput($password);
	}

	public function getPassword()
	{
		return $this->password;
	}


	public function displayErrors() {
		for($i = 0; $i < count($this->errors); $i++)
		{
			echo "<p style=\"color: red\">{$this->errors[$i]}</p>";
		}
	}

	protected function sanitizeInput($data) {
		return htmlspecialchars(stripslashes(trim($data)));
	}

	private function validate() {
		$this->validateName();
		$this->validateLogin();
		$this->validateEmail();
		$this->validatePhone();
		$this->validatePassword();

		if($this->isValid()) {
			$this->registerUser();
		}
	}

	protected function validateName() {
		if(empty($this->name)) {
			$this->errors[] = "Enter your name";
			return false;
		} else {
				if(!$this->strlenCheck($this->name, 3, 32)) 
				{	
					return false;
				}		
				if(!preg_match("/^[a-zA-Z0-9]*$/", $this->name)) {
					$this->errors[] = "Only letters and numbers are allowed";
					return false;	
			}
		}
		return true;
	}
	
	protected function validateLogin() {

		if(empty($this->login)) {
			$this->errors[] = "Enter your login";
			return false;
		} else {
				if (!$this->strlenCheck($this->login, 3, 32)) {	
						return false;
				}
			if (!preg_match("/^[a-zA-Z0-9]*$/", $this->login)) {
				$this->errors[] = "Only letters and numbers are allowed for login";
				return false;
			}
		}
		return true;
	}


	protected function validateEmail() {
        if (empty($this->email)) {
            $this->errors[] = "Enter your email";
            return false;
        } else {
            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->errors[] = "Invalid email format";
                return false;
            }
        }
        return true;
    }

	protected function validatePhone() {
		if(empty($this->phone)) {
			$this->errors[] = "Enter your phone number";
			return false;
		}else{
			$sanitizedPhone = filter_var($this->phone, FILTER_SANITIZE_NUMBER_INT);
			
			if (strlen($sanitizedPhone) < 10 || strlen($sanitizedPhone) > 15) {
       	    	$this->errors[] = "Phone number must be between 10 and 15 digits";
            	return false;
			}   
		}
		
		return true;
	}

	protected function validatePassword() {
		if(empty($this->password) || empty($this->passwordCheck)) {
			$this->errors[] = "Create a password and enter it in both fields";
			return false;
		}
		elseif($this->password !== $this->passwordCheck){
			$this->errors[] = "The passwords entered in both passwords fields should match";
			return false;
		}
		elseif (!$this->validatePasswordComplexity($this->password, 8, 32)) {
			return false;
		}
		return true;	
	}

	private function validatePasswordComplexity($password, $min_count, $max_count) {
		$length = strlen($password);
    	if ($length < $min_count || $length > $max_count) {
        	$this->errors[] = "Password must be between $min_count and $max_count characters";
       		 return false;
    	}

    	if (!preg_match("/[a-z]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[\W]/", $password)) {
        	$this->errors[] = "Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character";
        	return false;
    	}

    	return true;
	}

	private function strlenCheck($data, $min_count, $max_count) {
		$length = strlen($data);
		
		if($length < $min_count) {
			$this->errors[] = "A minimum of " . $min_count . " symbols is required";
            return false;
        }

       if ($length > $max_count) {
           $this->errors[] = "A maximum of " . $max_count . " symbols is required.";
       	   return false;
        }

       return true;
   }

	private function isValid() {
	return empty($this->errors);
	}

	private function registerUser() {
			
		$dbReg = new UserDatabase("localhost", "root", "qwerty", "reg_users");
		$this->hashPassword = password_hash($this->password, PASSWORD_DEFAULT);
		
		try{
			if($dbReg->registerUser($this->name, $this->login, $this->hashPassword, $this->email, $this->phone)) {
		header("Location: ./auth.php");
		exit();}	
		}
		catch (Exception $err) {
			$this->errors[] = $err->getMessage();
		}
	}
}

?>
