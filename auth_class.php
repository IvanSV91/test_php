<?php

include "./reg_class.php";

class UserAuth extends UserRegistration {
	
	public $loginErr;
	public $token;
	public function __construct($data) {
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			if(isset($_POST['email'])){	
				$this->email = $data["email"];
			}
			elseif(isset($_POST['phone'])) {
				$this->phone = $data["phone"];
			}
			$this->token = $data["smart-token"];
			$this->password = $data["password"];
			$this->validate();
			$this->login();
		}
	}

	private function login() {
		
		if($this->check_captcha())
		{
			$authenticate = new UserDatabase("localhost", "root", "qwerty", "reg_users");
			$user_id = $authenticate->userAuth($this->email, $this->phone,  $this->password);
			if($user_id)
			{	
				setcookie("user_id", $user_id, time() + 1800, "/");
				header("Location: ./profile.php");
				exit();
			}	
			else{
				$this->loginErr =  "Invalid Email\Phone or Pasword";
				return false;
				}
		}
	}


	protected function validate(){
		$this->validatePassword();
		if(isset($this->email)){	
			$this->validateEmail();
		}
		elseif(isset($this->phone)){
			$this->validatePhone();
		}
	}
	
	protected function validatePassword(){
		if(empty(trim($this->password)))
		{	
			$this->passErr = "Enter password";
			return false;
		}
		return true;
	}

	protected function captcha($token) {
    	$ch = curl_init("https://smartcaptcha.yandexcloud.net/validate");
    	$args = [
        	"secret" => 'ysc2_BG9x7Tr5tDQEbQ3ZXPSCiHSDYkr0zFD6mk5Ib2x97fa06942',
        	"token" => $this->token
    	];
   		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    	curl_setopt($ch, CURLOPT_POST, true);    
    	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    	$server_output = curl_exec($ch); 
    	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    	curl_close($ch);

    	if ($httpcode !== 200) {
        	echo "Allow access due to an error: code=$httpcode; message=$server_output\n";
        	return false;
    	}
 
    	$resp = json_decode($server_output);
    	return $resp->status === "ok";
	}	


	protected function check_captcha(){
		echo "token is \"$this->token\"";
	if ($this->captcha($this->token)) {
		echo "Passed\n";
		return true;
	} else {
		return false;
	}
}


}


?>
