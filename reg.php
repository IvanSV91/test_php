<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport content="width=device-width, initialscale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="public/css/style.css">
        <title>registration</title>
	</head>
	<?php include "inc/header.php"; ?>
	<body>
<?php
	include "./mysql_cli.php";
	require "./reg_class.php";

	$registration = new UserRegistration($_POST);

	$input_arr = array (
        array("name_f" => "user_name", "type" => "text", "name" => "Name"),
        array("name_f" => "login", "type" => "text", "name" => "Login"),
        array("name_f" => "password", "type" => "password", "name" => "Password"),
		array("name_f" => "passwordCheck", "type" => "password", "name" => "Password"),
		array("name_f" => "phone", "type" => "tel", "name" => "Phone"),
		array("name_f" => "email", "type" => "email", "name" => "Mail")
		
);
	
	echo 
		"<div class=\"div_table\">
		<form action=\"" . htmlspecialchars($_SERVER["PHP_SELF"]) ."\" method=\"POST\">
        <h1 style=\"text-align: center\">Sign Up</h1>
        <table>";

    $i = 0;
    while($i < count($input_arr))
	{		
		$input_f = $input_arr[$i]["name_f"];
		$input_type = $input_arr[$i]["type"];
		$input_name = $input_arr[$i]["name"];
		echo 
			"<tr>
             <td class=\"table_td_name;\"><label for=\"{$input_f}\">{$input_name}:</label></td>
             <td><input type=\"{$input_type}\" name=\"{$input_f}\" id=\"{$input_f}\"></td>
             </tr>";
		
		$i++;
    }
	echo 
		"<tr>
         <td><button type=\"submit\">Registration</button></td>
		 </tr>
		 </table>
		 </form>
   	 	 </div>
		 <div class=\"div_error\">"; 
		$registration->displayErrors();
			
	echo	
		//"<br><br>
        //your name: " . $registration->name ."<br>
        //your login: " . $registration->login . "<br>
        //your password: " .  $registration->password . "<br>
    	"</div>";

?>
    </body>
</html>
    




