<?php
if(!(isset($_COOKIE["nr_rachunku"]) && isset($_COOKIE["login"]))){
	header("location: logout.php");
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
				Złe dane!!!!
			</div>
			<h1>Zrób przelew</h1>

<h3>Dane do przelewu:</h3>
<form method="post" action="potwierdzenie.php">
	<span>Odbiorca: </span> <input type="text"     name="odb"><br>
	<span>Nr rachunku: </span> <input  type="text" name="nr"> <br>
	<span>Kwota: </span> <input type="text"     name="kw"><br>
	<span>Tytuł: </span> <input type="text"     name="t"><br>
	<input type="submit"  class="button" value="Wyślij przelew">
</form>

		</div>
	</article>
</body>
</html>