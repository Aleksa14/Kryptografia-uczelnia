<?php

setcookie("login", "", time()-3600, "/");
setcookie("nr_rachunku", "", time()-3600, "/");
header("location: index.php");
?>
