<?php

require_once("databaseConnection.php");

$login = isset($_POST['login'])?$_POST['login']:"";
$passwd = isset($_POST['passwd'])?$_POST['passwd']:"";

if($login === "" || $passwd === ""){
	header("location: adminLogin.php");
}else{
	$db = myDb();
	$hash = password_hash($passwd, PASSWORD_DEFAULT);
	$row = query($db, "INSERT INTO admins (login, password) VALUES ('$login', '$hash')");
	if(!password_verify($passwd, $row["password"])){}
	else{
		header("location: adminLogin.php");
	}
}
?>
