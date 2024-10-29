<header>
<?php

if(isset($_POST["main"])) {
	header("Location: ./index.php");
	exit();
}

if(isset($_POST['profile'])) {
	if($_COOKIE["user_id"] == "")
	{
    	header("Location: ./auth.php");
		exit();
	}
	else{	
    	header("Location: ./profile.php");
		exit();
	}
}
if(isset($_POST['registration'])) {
    if($_COOKIE["user_id"] == "") 
    {
        header("Location: ./reg.php");
		exit();
	}
	else{
		echo "<script>alert(\"you already have an account\")</script>";	
    }
}
?>
<table class="menu">
    <tr>
        <td>
            <form method="post">
                <button class="menu_button" type="submit" name="main">Main</button>
                <button class="menu_button" type="submit" name="registration">Registration</button>
                <button class="menu_button" type="submit" name="profile">Profile</button>
            </form>
        </td>
    </tr>
</table>

</header>
