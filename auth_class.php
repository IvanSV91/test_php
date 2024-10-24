<?php

include "./reg_class.php";

class UserAuth extends UserRegistration {

	public $passErr = "";
	
	public function __construct($data) {
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$this->email = $data["email"];
			$this->password = $data["password"];
			$this->validate();
			$this->login();
		}
	}

	private function login() {
	
		$authenticate = new UserDatabase("localhost", "root", "qwerty", "reg_users");
		$user_id = $authenticate->userAuth($this->email, $this->password);
		if($user_id)
		{	
			setcookie("user_id", $user_id, time() + 1800, "/");
			header("Location: ./profile.php");
			exit();
		}	
		else{
			echo "Invalid Email or Pasword";
			return false;
		}
	}
	private function validate(){
		$this->validatePassword();
		$this->validateEmail();
	}
	
	private function validatePassword(){
		if(empty(trim($this->password)))
		{	
			$this->passErr = "Enter password";
			return false;
		}
		return true;
	}

}


?>
