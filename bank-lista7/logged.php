<?php
if(!(isset($_COOKIE["nr_rachunku"]) && isset($_COOKIE["login"]))){
	header("location: logout.php");
}else{
	setcookie("login",$_COOKIE["login"], time()+10*60, "/");
	setcookie("nr_rachunku", $_COOKIE["nr_rachunku"], time()+10*60, "/");
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
		<form method="get" action="logout.php">
			Jesteś zalogowany(a) jako <?php echo $_COOKIE["login"];?>
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