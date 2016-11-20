<?php

if(!(isset($_COOKIE["nr_rachunku"]) && isset($_COOKIE["login"]))){
	header("location: logout.php");
}else{
	setcookie("login",$_COOKIE["login"], time()+10*60, "/");
	setcookie("nr_rachunku", $_COOKIE["nr_rachunku"], time()+10*60, "/");
}

require_once("databaseConnection.php");

$odb = isset($_POST['odb'])?$_POST['odb']:"";
$nr = isset($_POST['nr'])?$_POST['nr']:"";
$kw = isset($_POST['kw'])?$_POST['kw']:"";
$t = isset($_POST['t'])?$_POST['t']:"";

if($odb === "" || $nr === "" || $kw === "" || $t === ""){
	header("location: zlyp.php");
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8"/>
</head>

<body>
<h1>Poywierdzenie</h1>
<p>
Sprawdz czy dane sa poprawne.
</p>

<form method="post" action="wyslijp.php">
	<label>Odbiorca: <?php echo $odb ?></label><br>
	<input type="hidden" name="odb" value="<?php echo $odb ?>">
	<label>Nr rachunku: <?php echo $nr ?></label> 
	<input type="hidden" id="nr" name="nr" value="<?php echo $nr ?>">
	<label>Kwota: <?php echo $kw ?></label> 
	<input type="hidden" name="kw" value="<?php echo $kw ?>">
	<label>Tytuł: <?php echo $t ?></label> 
	<input type="hidden" name="t" value="<?php echo $t ?>">
	<input type="submit"  class="button" value="Wyślij przelew">
</form>
<script src="change.js"></script>
</body>
</html>