<?php
if(!(isset($_COOKIE["nr_rachunku"]) && isset($_COOKIE["login"]))){
	header("location: logout.php");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8"/>
</head>

<body>
<article>
	<div class="narrow">
		<p>Wys³ano przelew!</p>
		<form method="get" action="logout.php">
			Jesteœ zalogowany(a) jako <?php echo $_COOKIE["login"];?>
			<input type="submit" value="Wyloguj">
		</form>
		<div id="przelew">
			<a href="przelew.php">Wyslij przelew</a>
		</div>
		<div id="historia">
			<a href="historia.php">Historia przelewow</a>
		</div>
	</div>
</article>
</body>
</html>