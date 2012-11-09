<?php
	setcookie('user-id', '', time()-60*60*24*365);
	setcookie("shop-cart-mode",false,time() + (86400 * 1));
	include "loginForm.php";
?>