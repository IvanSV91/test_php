<?php

class ErrorHandler {
	
	private $errors = [];

	public function __construct($errorData = null) {
		$this->addError($errorData);
	}

	public function addError($errorData) {
		$this->errors[] = $errorData;
	}

	public function displayErrors(){
		if(empty($this->errors)){
			return;
		}	
		
		for($i = 0; $i < count($this->errors); $i++)
        {
            echo "<p style=\"color: red\">{$this->errors[$i]}</p>";
        }

	}

}

?>
