<?php
	//returns added volume
	function calculateVolume($food_id, $quantity, $quantity_type_id)
	{
		$query = sprintf("SELECT quantity_types.kg_equivalent from quantity_types WHERE id = %s", $quantity_type_id);
		$quantityRow = mysql_fetch_array(mysql_query($query));
		$query = sprintf("SELECT * from foods WHERE id = %s", $food_id);
		$foodRow = mysql_fetch_array(mysql_query($query));
		if($quantityRow["kg_equivalent"]==0) //in the case of units where we need the weight of 1 unit from the foods table
			return ($quantity*$foodRow["weight_per_unit"])/$foodRow["density"];
		else
			return ($quantity*$quantityRow["kg_equivalent"])/$foodRow["density"]; //volume = mass (kg) / density (kg/m3)
	}
	
	//gets current volume and updates it
	//addedVolume is a double. addedVolume is change in volume
	function updateFridgeVolume($user_storage_id, $addedVolume)
	{
		$query = sprintf("SELECT user_storages.curr_volume from user_storages WHERE id = %s", $user_storage_id);
		$storage = mysql_fetch_array(mysql_query($query));
		$newVolume = $storage["curr_volume"] + $addedVolume;
		$updateQuery = sprintf("UPDATE user_storages SET curr_volume = %f WHERE id = %s", $newVolume, $user_storage_id);
		mysql_query($updateQuery);
	}
?>
