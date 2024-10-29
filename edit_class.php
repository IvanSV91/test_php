<?php 
	include "./reg_class.php";

	class editUserProfile extends UserRegistration {

		private $oldData;
		private $newData;
		private $keys = ["login", "password", "passwordCheck", "email", "phone"];
		private $key;	
		private $message;
		private $passwordCheck;

		public function __construct($data){
			if($_SERVER["REQUEST_METHOD"] == "POST"){ 
				$this->PostNameKey($data);
				$this->validate();
			}
		}


		public function enterMessage()
		{		
			if(!empty($this->message)) {
				echo "<p> $this->message is changed </p>";
				}		
		}

		private function PostNameKey($data) {
				
			for($i = 0; $i < count($this->keys); $i++)
			{
				if(!empty($data[$this->keys[$i]]) && $this->keys[$i] != "passwordCheck")
				{	
					$this->oldData = $this->sanitizeInput($_SESSION['user'][$this->keys[$i]]);
					$this->newData = $this->sanitizeInput($data[$this->keys[$i]]);
					$this->key = $this->keys[$i];
				}
				elseif($this->keys[$i] == "passwordCheck"){
					$this->passwordCheck = $this->sanitizeInput($data[$this->keys[$i]]);
				}
			} 
		}	

			
		private function validate() {
				
			if($this->key == "login"){
				$this->validateLogin();
			}
			if($this->key == "email"){
				$this->validateEmail();
			}
			if($this->key == "password"){
				$this->validatePassword();
			}
			if($this->key == "phone") {
				$this->validatePhone();
			}
		}

		protected function validateLogin(){
			$this->setLogin($this->newData); 
	        if(parent::validateLogin()){
			$this->message = $this->key;
			$this->editUserData();
   			return true;
			}else{
				return false;
	        }
		}

		protected function validateEmail(){
			$this->setEmail($this->newData);
			if(parent::validateEmail()) {
				$this->message = $this->key;
				$this->editUserData();
				return true;
			}
			return false;
		}

		protected function validatePhone() {
			$this->setPhone($this->newData);
			if(parent::validatePhone()) {
				$this->message = $this->key;
				$this->editUserData();
				return true;
			}
			return false;	
		}

		
		protected function validatePassword() {
			$this->setPassword($this->newData);
			$this->setPasswordCheck($this->passwordCheck);
			if(parent::validatePassword()){
				$this->message = $this->key;
				$this->editUserData();
				return true;
			}
			return false;
		}

		private function editUserData() {
	
			$editData = new UserDatabase("localhost", "root", "qwerty", "reg_users");
			$editData->editUserDatadb($this->oldData, $this->newData, $this->key);
		}
	}

