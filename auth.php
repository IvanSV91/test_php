<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initialscale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="public/css/style.css">
		<title>login</title>
	</head>

<body>
	<?php include "inc/header.php"; ?>
	<?php include "./mysql_cli.php";?>
	<?php include "./auth_class.php"; ?>
	<?php $auth = new UserAuth($_POST); ?>
	<div class="div_table">
        <h1 style="text-align: center">Login</h1>
		<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
		<table>
			<tr>   
			<td class="table_td_name"><label for="email">Email:</label></td>
			<td><input type="email" name="email" id="email"></td>
			</tr>
			<tr>
			<td class="table_td_name"><label for="password">Password:</label></td>
            <td><input type="password" name="password" id="password"></td>
			</tr>		   
			<tr>
			<td><button type="submit">Login</button></td>
        	<td><a href="reg.php">Registration</a></td>
			</tr>
		</table>   
	</form>
	<div>
		<?php
			echo $auth->enterErrors();
		 ?>
	</div>
</body>
</html>

