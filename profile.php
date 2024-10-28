<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initialscale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="public/css/style.css">
        <title>profile</title>
    </head>
    <?php include "inc/header.php"; ?>
    <body>
<h1>Profile</h1>
<?php
	echo "your id is:" . $_COOKIE["user_id"];
	if(isset($_POST["exit"])) {
    setcookie("user_id", $_COOKIE["user_id"], time() - 180 * 10, "/");
	header("Location: ./index.php");
	}
	if(isset($_POST["edit"])) {
    	header("Location: ./edit.php");
   	}



?>	
	<div>
	<p>your name</p>
	<p>your Email</p>
	<p>Phone number</p>	
	<form method="post">
        <button type="submit" name="edit">Edit Profile</button>
    </form>
	<form method="post">
        <button type="submit" name="exit">Exit</button>
    </form>
	</div>
</body>
</html>
