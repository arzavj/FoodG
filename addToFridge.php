<?php
	include "config.php";

	$user_storage_query = sprintf("SELECT id from user_storages WHERE user_id = %s", $_COOKIE["user-id"]);
	$user_storage = mysql_fetch_array(mysql_query($user_storage_query));
	
	if (get_magic_quotes_gpc() == true) {
		foreach($_COOKIE as $key => $value) {
			$_COOKIE[$key] = stripslashes($value);
		}
	}

	$cartArray = $_COOKIE["cart"];
	$cartArray = unserialize($cartArray);
	if(!is_null($_COOKIE["cart"]) && $_COOKIE["shop-cart-mode"]=="true")
	{
		foreach ($cartArray as $map)
		{
			if(isset($map))
			{
				$foodInFridge = mysql_query(sprintf("SELECT * from user_foods WHERE user_storage_id = %s AND food_id = %s", $user_storage["id"], $map["food_id"]));
				if(mysql_num_rows($foodInFridge) == 0) //doesn't exist in the fridge
				{
					
				}
				else //if exists in the fridge
				{
					$foodInFridge = mysql_fetch_array($foodInFridge);
					$foodsNewVolume = calculateVolume($_POST["food_id"], $_POST["quantity"], $_POST["quantity_type_id"]);
					$query = sprintf("UPDATE user_foods SET quantity = %s, quantity_type_id = %s WHERE user_storage_id = %s AND food_id = %s", $_POST["quantity"], $_POST["quantity_type_id"], $user_storage["id"], $_POST["food_id"]);
					mysql_query($query);
				}
			}

		}
	}
	include("helperFunctions.php");
?>