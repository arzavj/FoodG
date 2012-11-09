<?php 
	include "config.php";
	$user_storage_query = sprintf("SELECT id from user_storages WHERE user_id = %s", $_COOKIE["user-id"]);
	$user_storage = mysql_fetch_array(mysql_query($user_storage_query));

	$oldpoints = getCurrPoints($_COOKIE["user_id"]);
	$prevQuant = mysql_fetch_array(mysql_query(sprintf("SELECT quantity from user_foods WHERE user_storage_id = %s AND food_id = %s", $user_storage["id"], $_POST["food_id"])));
	if (intval($prevQuant["quantity"]) > intval($_POST["quantity"])){
		$total = $oldpoints + (intval($prevQuant["quantity"]) - intval($_POST["quantity"])) ;
		$query = sprintf("UPDATE users SET saved_points = %s WHERE id = %s", $total, $$user_id);
		$result = mysql_query($query);
	}

	function getCurrPoints($user_id){
		$query = sprintf("SELECT saved_points FROM users WHERE id = %s", $user_id);
		$result = mysql_query($query);
		$user = mysql_fetch_assoc($result);
		return $user["saved_points"];
	}
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