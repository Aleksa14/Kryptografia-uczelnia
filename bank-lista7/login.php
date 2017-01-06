<?php

require_once("databaseConnection.php");

$login = isset($_POST['login'])?$_POST['login']:"";
$passwd = isset($_POST['passwd'])?$_POST['passwd']:"";
$captcha= isset($_POST['g-recaptcha-response'])?$_POST['g-recaptcha-response']:"";
if(!$captcha){
	echo '<h2>Please check the the captcha form.</h2>';
        exit;
}

$secretKey = "6LebxhAUAAAAAE6fVykQrRAVfK7jZZc3ncm9NaUH";
$ip = $_SERVER['REMOTE_ADDR'];
$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
$responseKeys = json_decode($response,true);

if($login === "" || $passwd === ""){
	header("location: wrong.php");
}else if(intval($responseKeys["success"]) !== 1){
	echo '<h2>You are spammer ! Get the @$%K out</h2>';
}else {
	$db = myDb();
	$row = myDbSelect($db, "SELECT login, rachunek, password FROM users WHERE login = '$login'");
	if(!password_verify($passwd, $row[0]["password"])){
		header("location: wrong.php");
	}else{
		setcookie("login", $row[0]['login'], time()+10*60, "/");
		setcookie("nr_rachunku", $row[0]['rachunek'], time()+10*60, "/");
		header("location: logged.php");
	}
}
?>



