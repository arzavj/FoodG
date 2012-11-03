<?php
	include "config.php";
	
	$user_storage_query = sprintf("SELECT user_storages.id AS id from user_storages inner join users ON (users.id = user_storages.user_id) WHERE users.username = \"%s\"", $_COOKIE["username"]);
	$user_storage = mysql_fetch_array(mysql_query($user_storage_query));

	if ($_POST["update"] == "0"){ //Not an update
		$query = sprintf("INSERT INTO user_foods(user_storage_id, food_id, quantity) VALUES (%s, %s, %s)", $user_storage["id"], $_POST["food_id"], $_POST["quantity"]);
		mysql_query($query);
	} else{ //Need to update
		if($_POST["btnS"] == "Update"){
			$query = sprintf("UPDATE user_foods SET quantity = %s WHERE user_storage_id = %s AND food_id = %s", $_POST["quantity"], $user_storage["id"], $_POST["food_id"]);
			mysql_query($query);
		} else if ($_POST["btnS"] == "Remove All"){
			$query = sprintf("DELETE FROM user_foods WHERE user_storage_id = %s AND food_id = %s", $user_storage["id"], $_POST["food_id"]);
			mysql_query($query);
		}


	}
?>

<html>
	<body>
		<script>
			window.location = "index.php";
		</script>
	</body>
</html>