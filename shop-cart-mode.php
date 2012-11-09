<?php
	setcookie("shop-cart-mode", '',time() + (86400 * 1));
	setcookie("shop-cart-mode", $_POST["shop-cart-mode"],time() + (86400 * 1));
?>