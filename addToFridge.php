<?php
	include "config.php";
	include "helperFunctions.php";
	$user_storage_query = sprintf("SELECT id from user_storages WHERE user_id = %s", $_COOKIE["user-id"]);
	$user_storage = mysql_fetch_array(mysql_query($user_storage_query));
	
	if (get_magic_quotes_gpc() == true) 
	{
		foreach($_COOKIE as $key => $value) 
		{
			$_COOKIE[$key] = stripslashes($value);
		}
	}

	$cartArray = $_COOKIE["cart"];
	$cartArray = array_filter(unserialize($cartArray));
	if(!empty($_COOKIE["cart"]))
	{
		foreach ($cartArray as $map)
		{
			if(isset($map))
			{
				$foodInFridge = mysql_query(sprintf("SELECT * from user_foods WHERE user_storage_id = %s AND food_id = %s", $user_storage["id"], $map["food_id"]));
				if(mysql_num_rows($foodInFridge) == 0) //doesn't exist in the fridge
				{
					$insertFood = sprintf("INSERT INTO user_foods(user_storage_id, food_id, quantity, quantity_type_id) VALUES (%s, %s, %s, %s)", $user_storage["id"], $map["food_id"], $map["quantity"], $map["quantity_type_id"]);
					mysql_query($insertFood);
					 //this line updates the curr_volume column in the database appropriately
				}
				else //if exists in the fridge
				{
					//this assumes that the quantity_type_id is same for the same item in fridge and shopping cart
					$foodInFridge = mysql_fetch_array($foodInFridge);
					//$foodsOldVolume = calculateVolume($map["food_id"], $foodInFridge["quantity"], $foodInFridge["quantity_type_id"]);
					//$foodsNewVolume = calculateVolume($map["food_id"], $map["quantity"], $map["quantity_type_id"]);
					$updateFood = sprintf("UPDATE user_foods SET quantity = %s, quantity_type_id = %s WHERE user_storage_id = %s AND food_id = %s", intval($foodInFridge["quantity"])+intval($map["quantity"]), $map["quantity_type_id"], $user_storage["id"], $map["food_id"]);
					mysql_query($updateFood);
				}
				updateFridgeVolume($user_storage["id"], calculateVolume($map["food_id"], $map["quantity"], $map["quantity_type_id"]));
			}
		}
	}
	setcookie("cart",'', time() + (86400 * 1));
	setcookie("shop-cart-mode",'',time() + (86400 * 1));
?>

<html>
	<head>
	</head>
	<body>
		<script>
			window.location = "index.php";
		</script>
	</body>
</html>