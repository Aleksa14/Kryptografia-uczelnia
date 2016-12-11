<?php
if(isset($_COOKIE["login"]) && isset($_COOKIE["nr_rachunku"])){
	header("location: logged.php");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8"/>
</head>

<body>
	<article>
		<div class="narrow">
			<div id="loginError">
				Zły Login lub hasło!!!!
			</div>
			<form method="post" action="login.php">
				Login: <input type="text" name="login" ><br>
				Hasło: <input type="password" name="passwd"><br>
				<input type="submit" value="Zaloguj">
			</form>
		</div>
	</article>
</body>
</html>
