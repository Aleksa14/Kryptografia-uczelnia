<?php
require_once("databaseConnection.php");
require_once "Mail.php";
$naz_pan = isset($_POST['naz_pan'])?$_POST['naz_pan']:"";
$zwierz = isset($_POST['zwierz'])?$_POST['zwierz']:"";
if($naz_pan === "" || $zwierz === ""){
	header("location: wrong.php");
}else{
	$nr_rachunku = $_COOKIE['nr_rachunku'];
	$db = myDb();
	$row = myDbSelect($db, "SELECT email FROM users WHERE odp1 = '$naz_pan' AND odp2 = '$zwierz' AND rachunek = '$nr_rachunku'");
	
	$rpass = rand(10000000, 99999999);
	$hash = password_hash($rpass, PASSWORD_DEFAULT);
	setcookie("sendhash", $hash, time()+20*60, "/");


    $from = "surveynokia2016@gmail.com";
    $to = $row[0]['email'];
    $subject = "Przywrocenie hasla.";
    $body = "Ta wiadomosc została wysłana, ponieważ prosiles o przywrocenie hasła. 
Uzyj ponizszego hasła aby zresetowac haslo do strony bank.com. 
$rpass
Jezeli nie prosiles o przywrocenie hasla, zignoruj ta wiadomosc.";

    $host = "smtp.gmail.com";
    $port = "587";
    $username = "surveynokia2016@gmail.com";
    $password = "votefortrump2016";

    $headers = array ('From' => $from,
      'To' => $to,
      'Subject' => $subject);
    $smtp = Mail::factory('smtp',
      array ('host' => $host,
        'port' => $port,
        'auth' => true,
        'username' => $username,
        'password' => $password));

    $mail = $smtp->send($to, $headers, $body);

    if (PEAR::isError($mail)) {
      echo("<p>" . $mail->getMessage() . "</p>");
    } else {
      echo("<p>Message successfully sent!</p>");
    }




	header("location: http://bank.com/bank/resetPass.php");
	
}	
?>
