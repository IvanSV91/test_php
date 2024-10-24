<header>
<?php

if(isset($_POST['profile'])) {
	if($_COOKIE["user_id"] == "")
	{
    	header("Location: ./auth.php");
	}
	else{	
    	header("Location: ./profile.php");
	}
}
if(isset($_POST['registration'])) {
    if($_COOKIE["user_id"] == "") 
    {
        header("Location: ./reg.php");
    }
	else{
		echo "<script>alert(\"you already have an account\")</script>";	
    }
} 	
	echo "<table class=\"menu\";><tr>";
	echo "<td style=\"padding-right: 30px\"><a href=\"index.php\">Main</a></td>";
	
	echo "<td>
        <form method=\"post\">
        <button class=\"menu_button\" type=\"submit\" name=\"registration\">Registration</button>
        </form>
    </td>";

	echo "<td>
		<form method=\"post\">
        <button class=\"menu_button\" type=\"submit\" name=\"profile\">Profile</button>
    	</form>
	</td>";
?>
</tr>
</table>
</header>
