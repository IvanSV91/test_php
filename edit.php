<?php 
session_start();
include "./mysql_cli.php";
	if(isset($_COOKIE["userEmail"])) {
		print_r($_COOKIE["userEmail"]);
		$email = $_COOKIE["userEmail"];

	$user = new UserDatabase("localhost", "root", "qwerty", "reg_users");
	$user->setUserSession($email);
	echo "<br>session start correctly<br>";
	echo $_SESSION['user']['name'];
	echo $_SESSION['user']['login'];
	echo $_SESSION['user']['email'];
	echo $_SESSION['user']['password'];
	}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport content="width=device-width, initialscale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="public/css/style.css">
        <title>edit profile</title>
    </head>
	<?php include "inc/header.php"; ?>
	<body>
		<?php
			if($_COOKIE["userEmail"] == "")
    		{
        		header("Location: ./login.php");
			}
		?>

		<div class="div_table">
        <h1 style="text-align: center">Edit Profile</h1>
        <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <table>
            <tr> 
            <td class="table_td_name"><label for="email">New Mail:</label></td>
            <td><input type="email" name="email" id="email"></td>
			<td><button type="submit">change</button></td>
			</tr>
            <tr>
            <td class="table_td_name"><label for="password">New Password:</label></td>
            <td><input type="password" name="password" id="password"></td>
			<td><button type="submit">change</button></td>
			</tr>
			<tr>
            <td class="table_td_name"><label for="password">New Login:</label></td>
            <td><input type="password" name="password" id="password"></td>
			<td><button type="submit">change</button></td>   
			</tr>
<tr>
            <td class="table_td_name"><label for="password">New Phone number</label></td>
            <td><input type="password" name="password" id="password"></td>
			<td><button type="submit">change</button></td>
			</tr>
        </table>
    </form>
    <div>



</body>
</html>



