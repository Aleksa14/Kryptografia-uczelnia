<?php
if(!(isset($_COOKIE["login"]))){
	header("location: logout.php");
}else{
	setcookie("login",$_COOKIE["login"], time()+10*60, "/");
}

require_once("databaseConnection.php");
$db = myDb();
$row = myDbSelect($db, "SELECT * FROM przelewy WHERE czyZatwierdzone='1'");
$str = '<table><tr><th>Odbiorca:</th><th>Numer rachunku nadawcy:</th><th>Numer rachunku odbiorcy:</th><th>Kwota:</th><th>Tytul:</th></tr>';
foreach($row as $w){
	$od = $w["odbiorca"];
	$nrn = $w["rachunek_nadawcy"];
	$nro = $w["nr_rachunku"];
	$kw = $w["kwota"];
	$tt = $w["tytul"];
	$id = $w["id"];
	$str.= "<tr><td>$od</td><td>$nrn</td><td>$nro</td><td>$kw</td><td>$tt</td><td><form method='post' action='apotw.php'> 
						<input name='id' type='hidden' value='$id'><input type='submit' value='confirm'>
													</form></td></tr>"; 	
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
		
	</div>
</article>
</body>
</html>

