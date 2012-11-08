<?php
	include "config.php";
	
	$user_storage_query = sprintf("SELECT user_storages.id AS id from user_storages inner join users ON (users.id = user_storages.user_id) WHERE users.username = \"%s\"", $_COOKIE["username"]);
	$user_storage = mysql_fetch_array(mysql_query($user_storage_query));

	$test = sprintf("SELECT * from user_foods WHERE user_storage_id = %s AND food_id = %s", $user_storage["id"], $_POST["food_id"]);
	$test_result = mysql_query($test);
	if ($_POST["update"] == "0") //if new item is added through add item button
	{ 
		if (mysql_num_rows($test_result) == 0) //if item does not exist in the fridge
		{
			$query = sprintf("INSERT INTO user_foods(user_storage_id, food_id, quantity, quantity_type_id) VALUES (%s, %s, %s, %s)", $user_storage["id"], $_POST["food_id"], $_POST["quantity"], $_POST["quantity_type_id"]);
			mysql_query($query);
			updateFridgeVolume($user_storage["id"], calculateAddedVolume($_POST["food_id"], $_POST["quantity"], $_POST["quantity_type_id"])); //this line updates the curr_volume column in the database appropriately
		} 
		else //if item already exists in the fridge
		{
			//TODO make the alert and update points
		}
	} 
	else //if food item is clicked on through home page and is updated or removed all
	{ 
		if($_POST["btnS"] == "Update")
		{
			if(intval($_POST["quantity_type_id"])==$test_result["quantity_type_id"]) //if user enters same units as before
			{
				$changeInQuantity = intval($_POST["quantity"]) - $test_result["quantity"]; //change = new - old
				updateFridgeVolume($user_storage["id"], calculateAddedVolume($_POST["food_id"], $changeInQuantity, $_POST["quantity_type_id"]));
			}		
			else
			{
				//in case user enters different units then when previously entered
			}
			$query = sprintf("UPDATE user_foods SET quantity = %s, quantity_type_id = %s WHERE user_storage_id = %s AND food_id = %s", $_POST["quantity"], $_POST["quantity_type_id"], $user_storage["id"], $_POST["food_id"]);
			mysql_query($query);
		} 
		else if ($_POST["btnS"] == "Remove All")
		{
			//change fridge volume
			$query = sprintf("DELETE FROM user_foods WHERE user_storage_id = %s AND food_id = %s", $user_storage["id"], $_POST["food_id"]);
			mysql_query($query);
		}
	}
	
	//returns added volume
	function calculateAddedVolume($food_id, $quantity, $quantity_type_id)
	{
		$query = sprintf("SELECT quantity_types.kg_equivalent from quantity_types WHERE id = %s", $quantity_type_id);
		$quantityRow = mysql_fetch_array(mysql_query($query));
		$query = sprintf("SELECT * from foods WHERE id = %s", $food_id);
		$foodRow = mysql_fetch_array(mysql_query($query));
		if($quantityRow["kg_equivalent"]==0) //in the case of units where we need the weight of 1 unit from the foods table
		{
			//take care of things like apples
		}
		else
			return ($quantity*$quantityRow["kg_equivalent"])/$foodRow["density"]; //volume = mass (kg) / density (kg/m3)
	}
	
	//gets current volume and updates it
	//addedVolume is a double
	function updateFridgeVolume($user_storage_id, $addedVolume)
	{
		$query = sprintf("SELECT user_storages.curr_volume from user_storages WHERE id = %s", $user_storage_id);
		$storage = mysql_fetch_array(mysql_query($query));
		$newVolume = $storage["curr_volume"] + $addedVolume;
		$updateQuery = sprintf("UPDATE user_storages SET curr_volume = %f WHERE id = %s", $newVolume, $user_storage_id);
		mysql_query($updateQuery);
	}

?>

<html>
	<body>
		<script>
			window.location = "index.php";
		</script>
	</body>
</html>