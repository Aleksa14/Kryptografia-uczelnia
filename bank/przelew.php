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
<h1>Zrób przelew</h1>

<h3>Dane do przelewu:</h3>
<form method="post" action="potwierdzenie.php">
	<span>Odbiorca: </span> <input type="text"     name="odb"><br>
	<span>Nr rachunku: </span> <input  type="text" name="nr"> <br>
	<span>Kwota: </span> <input type="text"     name="kw"><br>
	<span>Tytu³: </span> <input type="text"     name="t"><br>
	<input type="submit"  class="button" value="Wyœlij przelew">
</form>

</body>
</html>