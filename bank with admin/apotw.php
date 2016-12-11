<?php
if(!(isset($_COOKIE["login"]))){
	header("location: logout.php");
}else{
	setcookie("login",$_COOKIE["login"], time()+10*60, "/");
}

require_once("databaseConnection.php");

$id = isset($_POST['id'])?$_POST['id']:"";

$db = myDb();
$row = query($db, "UPDATE przelewy SET czyZatwierdzone = '0' WHERE id = '$id'");
header("location: adminHome.php");
