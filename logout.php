<?php
	setcookie('username', '', time()-60*60*24*365);
	header("Location: index.php");
?>