<header>
<table align = "center" bordercolor = "none">
<tr>
<?php

	$urls = array (
		array("url" => "/reg.php", "name" => "Registration"),
		array("url" => "/auth.php", "name" => "Enter"),
		array("url" => "/profile.php", "name" => "Portfolio")
	);

	$i = 0;
	while($i < count($urls))
	{
		echo "<td style=\"padding-right: 30px\"><a href='".$urls[$i][url]."'>".$urls[$i][name]."</a></td>";
		$i++;
	}

?>
</tr>
</table>
</header>
