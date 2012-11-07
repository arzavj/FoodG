<?php
	include "config.php";
	
	$user_storage_query = sprintf("SELECT user_storages.id AS id from user_storages inner join users ON (users.id = user_storages.user_id) WHERE users.username = \"%s\"", $_COOKIE["username"]);
	$user_storage = mysql_fetch_array(mysql_query($user_storage_query));

	
	if ($_POST["update"] == "0"){ //Not an update
		$test = sprintf("SELECT * from user_foods WHERE user_storage_id = %s AND food_id = %s", $user_storage["id"], $_POST["food_id"]);
		$test_result = mysql_query($test);
		if (mysql_num_rows($test_result) == 0){
			$query = sprintf("INSERT INTO user_foods(user_storage_id, food_id, quantity, quantity_type_id) VALUES (%s, %s, %s, %s)", $user_storage["id"], $_POST["food_id"], $_POST["quantity"], $_POST["quantity_type_id"]);
			mysql_query($query);
			updateFridgeVolume($user_storage["id"], calculateAddedVolume($_POST["food_id"], $_POST["quantity"], $_POST["quantity_type_id"]));
		} else{
			//TODO make the alert and update points
		}
	} else{ //Need to update
		if($_POST["btnS"] == "Update"){
			$query = sprintf("UPDATE user_foods SET quantity = %s, quantity_type_id = %s WHERE user_storage_id = %s AND food_id = %s", $_POST["quantity"], $_POST["quantity_type_id"], $user_storage["id"], $_POST["food_id"]);
			mysql_query($query);
		} else if ($_POST["btnS"] == "Remove All"){
			$query = sprintf("DELETE FROM user_foods WHERE user_storage_id = %s AND food_id = %s", $user_storage["id"], $_POST["food_id"]);
			mysql_query($query);
		}
	}
	
	//returns added volume
	function calculateAddedVolume($food_id, $quantity, $quantity_type_id)
	{
		$query = sprintf("SELECT * from quantity_types WHERE id = %s", $quantity_type_id);
		$quantityRow = mysql_fetch_array(mysql_query($query));
		$query = sprintf("SELECT * from foods WHERE id = %s", $food_id);
		$foodRow = mysql_fetch_array(mysql_query($query));
		if($quantityRow["kg_equivalent"]==0)
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