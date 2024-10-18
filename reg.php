	<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport content="width=device-width, initialscale=1.0>
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="public/css/style.css">
        <title>registration</title>
	</head>
	 <?php require "inc/header.php" ?>
	<body>

<?php
$nameErr = $loginErr = "";
$name=$login="";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(empty($_POST["user_name"]))
	{
			$nameErr = "Enter your name";
	}
	else
	{		
		$name = validate_input($_POST["user_name"]);
	}

	if(empty($_POST["login"]))
	{
		$loginErr = "Enter your login";
	}
	else
	{
		$login=validate_input($_POST["login"]);
	}
}

function validate_input($data)
{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
}

?>




		<div>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<h1 style="text-align: center">Sign Up</h1>
			<div class="form_box">
				<label style="padding-right: 40px" for="user_name">Name:</label>
				<input type="text" name="user_name" id="user_name">		
			<span> <?php echo $nameErr; ?></span>
			</div>
			<br><br>
			<div class="form_box">
			<label style="padding-right: 40px"  for="login">Login:</label>
				<input type="text" name="login" id="login">
				<span> <?php echo $loginErr; ?></span>
			</div>
			<br><br>
			<div class="form_box">
				<label for="password">Password:</label>
				<input type="password" name="password" id="password">
			</div>
			<br><br>
			<div class="form_box">
				<label for="password2">Password:</label>
				<input type="password" name="password2" id="password2">
			</div class="form_box">
			<button type="submit">Register</button>	
		</form>
	</div>		

	<div>
		Welcome <?php echo $_POST["user_name"]; ?><br>
		Your login is: <?php echo $_POST["login"]; ?>
	</div>

    </body>
</html>
    




