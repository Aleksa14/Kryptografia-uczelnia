<?php
require_once("databaseConnection.php");

if(!(isset($_COOKIE["nr_rachunku"]) && isset($_COOKIE["login"]))){
	header("location: logout.php");
}else{
	setcookie("login",$_COOKIE["login"], time()+10*60, "/");
	setcookie("nr_rachunku", $_COOKIE["nr_rachunku"], time()+10*60, "/");

$odb = isset($_POST['odb'])?$_POST['odb']:"";
$nr = isset($_POST['nr'])?$_POST['nr']:"";
$kw = isset($_POST['kw'])?$_POST['kw']:"";
$t = isset($_POST['t'])?$_POST['t']:"";
$nr2 = $_COOKIE["nr_rachunku"];

if($odb === "" || $nr === "" || $kw === "" || $t === ""){
	header("location: zlyp.php");
}else{
	$db = myDb();
	$row = query($db, "INSERT INTO przelewy (odbiorca, nr_rachunku, kwota, tytul, rachunek_nadawcy) VALUES ('$odb', '$nr', '$kw', '$t', '$nr2')");
	header("location: wyslano.php");
}
}