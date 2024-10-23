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
		mysqli_cli_auth($this->email, $this->password);
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
