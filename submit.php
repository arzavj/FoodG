<?php
	include "config.php";
	include "helperFunctions.php";
	$user_storage_query = sprintf("SELECT id from user_storages WHERE user_id = %s", $_COOKIE["user-id"]);
	$user_storage = mysql_fetch_array(mysql_query($user_storage_query));

	$test = sprintf("SELECT * from user_foods WHERE user_storage_id = %s AND food_id = %s", $user_storage["id"], $_POST["food_id"]);
	$test_result = mysql_query($test);
	if($_POST["btnS"] == "Submit")//if ($_POST["update"] == "0") //if new item is added through add item button
	{
		if($_COOKIE["shop-cart-mode"]=="true")
		{
			if (get_magic_quotes_gpc() == true) {
			 foreach($_COOKIE as $key => $value) {
			   $_COOKIE[$key] = stripslashes($value);
			  }
			}
			$item = array("food_id"=>$_POST["food_id"], "quantity" => $_POST["quantity"], "quantity_type_id" => $_POST["quantity_type_id"]);
			$cartArray = $_COOKIE["cart"];
			$alreadyInCart = false;
			if(is_null($cartArray))
				$cartArray = array($item);
			else
			{
				$cartArray = unserialize($cartArray);
				foreach ($cartArray as $key=>$map) //if added item is already in shopping cart
				{
					if($map["food_id"]==$_POST["food_id"])
					{
						$alreadyInCart = true;
						break;
					}
				}
				if(!$alreadyInCart)
					array_push($cartArray, $item);
			}	
			setcookie("cart",serialize($cartArray), time() + (86400 * 1));

		}
		else
		{
			if (mysql_num_rows($test_result) == 0 && intval($_POST["quantity"]) > 0) //if item does not exist in the fridge
			{
				$query = sprintf("INSERT INTO user_foods(user_storage_id, food_id, quantity, quantity_type_id) VALUES (%s, %s, %s, %s)", $user_storage["id"], $_POST["food_id"], $_POST["quantity"], $_POST["quantity_type_id"]);
				mysql_query($query);
				updateFridgeVolume($user_storage["id"], calculateVolume($_POST["food_id"], $_POST["quantity"], $_POST["quantity_type_id"])); //this line updates the curr_volume column in the database appropriately
			} 
		}
	} 
	else //if food item is clicked on through home page and is updated or removed all
	{
		if($_COOKIE["shop-cart-mode"]=="true")
		{
			if (get_magic_quotes_gpc() == true) 
			{
			 	foreach($_COOKIE as $key => $value) 
				{
			   		$_COOKIE[$key] = stripslashes($value);
			  	}
			}
		
			$cartArray = unserialize($_COOKIE["cart"]);
			foreach ($cartArray as $key=>$map) //remove old food item's array in both update and remove all case
			{
				if($map["food_id"]==$_POST["food_id"])
				{
					unset($cartArray[$key]);
					break;
				}
			}
			if($_POST["btnS"] == "Update" && intval($_POST["quantity"]) > 0)
			{
				$item = array("food_id"=>$_POST["food_id"], "quantity" => $_POST["quantity"], "quantity_type_id" => $_POST["quantity_type_id"]);
				array_push($cartArray, $item);
			}
			setcookie("cart",serialize($cartArray), time() + (86400 * 1));
		}
		else
		{
			$foodInFridge = mysql_fetch_array($test_result);
			$foodsOldVolume = calculateVolume($_POST["food_id"], $foodInFridge["quantity"], $foodInFridge["quantity_type_id"]);
			$foodsNewVolume = 0;
			if($_POST["btnS"] == "Update" && intval($_POST["quantity"]) > 0)
			{
				$foodsNewVolume = calculateVolume($_POST["food_id"], $_POST["quantity"], $_POST["quantity_type_id"]);
				$query = sprintf("UPDATE user_foods SET quantity = %s, quantity_type_id = %s WHERE user_storage_id = %s AND food_id = %s", $_POST["quantity"], $_POST["quantity_type_id"], $user_storage["id"], $_POST["food_id"]);
				mysql_query($query);
			} 
			else if ($_POST["btnS"] == "Remove All" || $_POST["quantity"] == "0")
			{
				$query = sprintf("DELETE FROM user_foods WHERE user_storage_id = %s AND food_id = %s", $user_storage["id"], $_POST["food_id"]);
				mysql_query($query);
			}
			updateFridgeVolume($user_storage["id"], $foodsNewVolume - $foodsOldVolume);
		}
	}

?>

<html>
	<head>
	</head>
	<body>
		<script>
		<?php
			if($_COOKIE["shop-cart-mode"]=="true")
			{
				if($alreadyInCart)
				{
		?>
					alert("You already have that item in your cart!");
		<?php
				}
		?>
				window.location = "myCart.php";
		<?php
			}
			else
			{
		?>
				window.location = "index.php";
		<?php
			}
		?>
		</script>
	</body>
</html>