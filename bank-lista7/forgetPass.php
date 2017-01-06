<?php
	require_once("databaseConnection.php");
	$login = isset($_POST['login'])?$_POST['login']:"";
	$nr_rachunku = isset($_POST['nr_rachunku'])?$_POST['nr_rachunku']:"";
	if($login === "" || $nr_konta === ""){
		header("location: wrong.php");
	}else{
		$db = myDb();
		$row = myDbSelect($db, "SELECT login, rachunek FROM users WHERE login = '$login' AND rachunek = '$nr_rachunku'");
		setcookie("login", $row[0]['login'], time()+20*60, "/");
		setcookie("nr_rachunku", $row[0]['rachunek'], time()+20*60, "/");
		header("location: http://bank.com/bank/questions.php");	
	}	
?>
