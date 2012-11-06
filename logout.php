<?php
	setcookie('user-id', '', time()-60*60*24*365);
	include "loginForm.php";
?>