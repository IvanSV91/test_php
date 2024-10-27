<?php 
	include "./reg_class.php";

	class editUserProfile extends UserRegistration {

		public $oldData;
		public $newData;
		public $keys = ["login", "password", "password_check", "email"];
		public $key;	
		public $message;

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
					if(!empty($data[$this->keys[$i]]) && $this->keys[$i] != "password_check")
					{	
						echo $data[$this->keys[$i]];
						$this->oldData = $_SESSION['user'][$this->keys[$i]];
						$this->newData = $data[$this->keys[$i]];
						$this->key = $this->keys[$i];
						var_dump($this->newData);
					}
					elseif($this->keys[$i] == "password_check"){
							$this->password_check = $data[$this->keys[$i]];
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
		}

		protected function validateLogin(){
			  
			$this->login = $this->newData;
	        if(parent::validateLogin()){
			$this->message = $this->key;
			$this->editUserData();
   
				return true;
			}else{
					return false;
	             }
		}

		protected function validateEmail(){

				$this->email = $this->newData;
				if(parent::validateEmail()) {
					$this->message = $this->key;
					$this->editUserData();
					return true;
				}
			return false;
		}
		
		protected function validatePassword() {
				
				$this->password = $this->newData;
				if(parent::validatePassword()){
					$this->message = $this->key;
					$this->editUserData();
					return true;
				}else{
					return false;
					}
		}

		private function editUserData() {
	
			$editData = new UserDatabase("localhost", "root", "qwerty", "reg_users");
			$editData->editUserDatadb($this->oldData, $this->newData, $this->key);
		}
	}

