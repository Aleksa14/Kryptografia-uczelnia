<?php

require_once("databaseConnection.php");

$login = isset($_POST['login'])?$_POST['login']:"";
$passwd = isset($_POST['passwd'])?$_POST['passwd']:"";
$nr = isset($_POST['nr'])?$_POST['nr']:"";

if($login === "" || $passwd === ""){
	header("location: index.html");
}else{
	$db = myDb();
	$hash = password_hash($passwd, PASSWORD_DEFAULT);
	$row = query($db, "INSERT INTO users (login, rachunek, password) VALUES ('$login', '$nr', '$hash')");
	if(!password_verify($passwd, $row["password"])){}
	else{
		header("location: index.html");
	}
}
?>