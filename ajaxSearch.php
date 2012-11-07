<?php
	include "config.php";
	$storequest= sprintf('SELECT foods.* FROM foods inner join (user_foods inner join user_storages ON user_foods.user_storage_id = user_storages.id) ON foods.id = user_foods.food_id WHERE user_storages.user_id = %s AND foods.food LIKE "%%%s%%"', $_COOKIE['user-id'], $_POST["search"]);
	$result = mysql_query($storequest);
	while($row = mysql_fetch_array($result)){
?>
	 <li><img src="<?php echo $row["image_url"] ?>" class="thumb"></li>
	 <li><a href="description.php?food=<?php echo $row["id"]?>&update=1" > <?php echo $row["food"] ?> </a></li>

<?php 
	}
?>
