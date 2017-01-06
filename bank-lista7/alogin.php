<?php

require_once("databaseConnection.php");

$login = isset($_POST['login'])?$_POST['login']:"";
$passwd = isset($_POST['passwd'])?$_POST['passwd']:"";

if($login === "" || $passwd === ""){
	header("location: wrong.php");
}else{
	$db = myDb();
	$row = myDbSelect($db, "SELECT login, password FROM admins WHERE login = '$login'");
	if(!password_verify($passwd, $row[0]["password"])){
		header("location: wrong.php");
	}else{
		setcookie("login", $row[0]['login'], time()+10*60, "/");
		header("location: adminHome.php");
	}
}
?>

