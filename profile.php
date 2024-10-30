<?php
	session_start();
	include __DIR__ . "/classes/mysql_cli.php";
	if(!empty($_COOKIE["user_id"])){
		$userSession = new UserDatabase("localhost", "root", "qwerty", "reg_users");
		$userSession->setUserSession($_COOKIE["user_id"]);
	}else{
		session_destroy();
		header("Location: /index.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initialscale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="public/css/style.css">
        <title>profile</title>
    </head>
    <?php include __DIR__ . "/inc/header.php"; ?>
    <body>
<h1>Profile</h1>
<?php
	echo "your id is:" . $_COOKIE["user_id"];
	if(isset($_POST["exit"])) {
    setcookie("user_id", $_COOKIE["user_id"], time() - 180 * 10, "/");
	session_destroy();
	header("Location: ./index.php");
	exit();
	}
	if(isset($_POST["edit"])) {
		header("Location: ./edit.php");
		exit();
	}
?>	
	<div>
	<p><?php echo "your name is " . $_SESSION["user"]["name"]; ?></p>
	<p><?php echo "your Email is " . $_SESSION["user"]["email"]; ?></p>
	<p><?php echo "phone number is " . $_SESSION["user"]["phone"];?></p>	
	<form method="post">
        <button type="submit" name="edit">Edit Profile</button>
    </form>
	<form method="post">
        <button type="submit" name="exit">Exit</button>
    </form>
	</div>
</body>
</html>
