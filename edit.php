<?php 
	session_start();

	include "./mysql_cli.php";
	include "./edit_class.php";
	
	if(isset($_COOKIE["user_id"])) {
		$user_id = $_COOKIE["user_id"];
	}
	
	$user = new UserDatabase("localhost", "root", "qwerty", "reg_users");
	$user->setUserSession($user_id);
	//echo "<br>session start correctly<br>";
	//echo $_SESSION['user']['user_id'];
	//echo $_SESSION['user']['name'];
	//echo $_SESSION['user']['login'];
	//echo $_SESSION['user']['email'];
	//echo $_SESSION['user']['password'];
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$edit = new editUserProfile($_POST);
	//	$edit->editUserData();
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
		<div class="div_table">
        <h1 style="text-align: center">Edit Profile</h1>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <table>
            <tr> 
            <td class="table_td_name"><label for="email">New Mail:</label></td>
            <td><input type="email" name="email" id="email"></td>
			<td><button type="submit">change</button></td>
			</tr>
            <tr>
            <td class="table_td_name"><label for="password">New Password:</label></td>
            <td><input type="password" name="password" id="password"></td>
			</tr>
			<tr>
			<td class="table_td_name"><label for="password_check">New Password:</label></td>
            <td><input type="password" name="password_check" id="password_check"></td>
			<td><button type="submit">change</button></td>
			</tr>
			<tr>
            <td class="table_td_name"><label for="login">New Login:</label></td>
            <td><input type="text" name="login" id="login"></td>
			<td><button type="submit">change</button></td>   
			</tr>
			<tr>
			<td><?php $edit->enterErrors(); $edit->enterMessage(); ?></td>
			</tr>
        </table>
    </form>
    <div>



</body>
</html>



