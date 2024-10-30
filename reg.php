<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initialscale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="public/css/style.css">
        <title>registration</title>
	</head>
	<?php include __DIR__ . "/inc/header.php"; ?>
	<body>
<?php
	include __DIR__ . "/classes/mysql_cli.php";
	include __DIR__ . "/classes/reg_class.php";

	$registration = new UserRegistration($_POST);

?>
	<div class="div_tabe">
		<form action=" <?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<h1 style="text-align: center">Registration</h1>
			<table>
				<tr>
             	<td class="table_td_name"><label for="userName">Name:</label></td>
             	<td><input type="text" name="userName" id="userName"></td>
				</tr>
				<tr>
             	<td class="table_td_name"><label for="login">Login:</label></td>
             	<td><input type="text" name="login" id="login"></td>
				</tr>
				<tr>
             	<td class="table_td_name"><label for="phone">Phone:</label></td>
             	<td><input type="text" name="phone" id="phone"></td>
				</tr>
				<tr>
             	<td class="table_td_name"><label for="email">Mail:</label></td>
             	<td><input type="email" name="email" id="email"></td>
				</tr>
				<tr>
             	<td class="table_td_name"><label for="password">Password:</label></td>
             	<td><input type="password" name="password" id="password"></td>
             	</tr>
				<tr>
             	<td class="table_td_name"><label for="passwordCheck">Password:</label></td>
             	<td><input type="password" name="passwordCheck" id="passwordCheck"></td>
             	</tr>
				<tr>
         		<td><button type=\"submit\">Registration</button></td>
         		</tr>
         	</table>
         </form>
	</div>
    <div class="div_error">
		<?php $registration->displayErrors(); ?>
	</div>

    </body>
</html>
    




