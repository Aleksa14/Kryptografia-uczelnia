<?php 
require_once("databaseConnection.php");

$mpass = isset($_POST['mpass'])?$_POST['mpass']:"";
$pass = isset($_POST['pass'])?$_POST['pass']:"";
$repass = isset($_POST['repass'])?$_POST['repass']:"";

if($mpass === ""){
	header("location: wrong.php");
}else{
	if(!password_verify($mpass, $_COOKIE['sendhash'])){
		header("location: wrong.php");
	}else if($pass !== $repass){
		echo '<p>Zle wpisane hasło!</p>';
		}else{
			
			$db = myDb();
			$nr_rachunku = $_COOKIE['nr_rachunku'];
			$rehash = password_hash($pass, PASSWORD_DEFAULT);
			$row = query($db, "UPDATE users SET password = '$rehash' WHERE rachunek = '$nr_rachunku'");
			header("location: index.php");
}
	
}
?>
