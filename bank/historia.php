<?php
if(!(isset($_COOKIE["nr_rachunku"]) && isset($_COOKIE["login"]))){
	header("location: logout.php");
}else{
	setcookie("login",$_COOKIE["login"], time()+10*60, "/");
	setcookie("nr_rachunku", $_COOKIE["nr_rachunku"], time()+10*60, "/");
}

require_once("databaseConnection.php");

$nr = $_COOKIE["nr_rachunku"];
$db = myDb();
$row = myDbSelect($db, "SELECT * FROM przelewy WHERE rachunek_nadawcy = '$nr' OR nr_rachunku = '$nr'");
$str = '<table><tr><th>Odbiorca:</th><th>Numer rachunku nadawcy:</th><th>Numer rachunku odbiorcy:</th><th>Kwota:</th><th>Tytu³:</th></tr>';
foreach($row as $w){
	$od = $w["odbiorca"];
	$nrn = $w["rachunek_nadawcy"];
	$nro = $w["nr_rachunku"];
	$kw = $w["kwota"];
	$tt = $w["tytul"];
	$str.= "<tr><td>$od</td><td>$nrn</td><td>$nro</td><td>$kw</td><td>$tt</td></tr>"; 	
}
$str.='</table>';
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8"/>
</head>

<body>
<article>
	<div class="narrow">
		<h2>Historia</h2>
		<?php echo $str ?>
		<div id="przelew">
			<a href="przelew.php">Wyslij przelew</a>
		</div>
	</div>
</article>
</body>
</html>

