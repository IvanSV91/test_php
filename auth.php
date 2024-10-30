<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="public/css/style.css">
    <title>Login</title>
	<script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>
	<script src="public/js/script.js" defer></script>
</head>
<?php include "inc/header.php"; ?>
<?php include "./mysql_cli.php"; ?>
<?php include "./auth_class.php"; 
    $auth = new UserAuth($_POST); ?>
<body>
	<div class="div_table">
        <h1 style="text-align: center">Login</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateInput();">
            <table>
                <tr>   
                <td class="table_td_name"><label for="userInput">Email/Phone:</label></td>
                <td><input type="text" id="userInput" required></td>
                </tr>
                <tr>
                <td class="table_td_name"><label for="password">Password:</label></td>
                <td><input type="password" name="password" id="password" required></td>
				</tr>         
				<tr><td colspan="2">
				<div
  					style="height: 100px"
	  				id="captcha-container"
	  				class="smart-captcha"
	  				data-sitekey="ysc1_BG9x7Tr5tDQEbQ3ZXPSCw5OrNAez5ehnwVK89I7Fcea15308">
					<input type="hidden" name="smart-token" value="token">
				</div>
				</td>
				</div>
				<div>
				</td></tr>
                <tr>
                <td><button type="submit">Login</button></td>
                <td><a href="reg.php">Registration</a></td>
                </tr>
			</table>   
        </form>
        <div style="text-align: center">
            <?php
                echo $auth->displayErrors();
            ?>
        </div>
    </div>
</body>
</html>
