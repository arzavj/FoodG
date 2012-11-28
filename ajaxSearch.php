<?php
		include "config.php";
		if($_POST["all"]){
			$storequest = sprintf('SELECT * from foods WHERE food LIKE "%%%s%%"', $_POST["search"]);
			$url = "description.php?food=%s";
		} else{
			$storequest= sprintf('SELECT foods.* FROM foods inner join (user_foods inner join user_storages ON user_foods.user_storage_id = user_storages.id) ON foods.id = user_foods.food_id WHERE user_storages.user_id = %s AND foods.food LIKE "%%%s%%"', $_COOKIE['user-id'], $_POST["search"]);
			$url = "description.php?food=%s&update=1";
		}
		$result = mysql_query($storequest);
		while($row = mysql_fetch_array($result)){
	?>
	<li class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-li-has-thumb ui-btn-up-c">
		<div class="ui-btn-inner ui-li">
			<div class="ui-btn-text">
				<a class="ui-link-inherit" href="<?php echo sprintf($url, $row["id"])?>">
					<img src="<?php echo $row["image_url"] ?>" class="ui-li-thumb" />
					<h3 class="ui-li-heading"><?php echo $row["food"] ?></h3>
					<p class="ui-li-desc"><!-- TODO fill count--></p>
				</a>
			</div>
			<span class="ui-icon ui-icon-arrow-r ui-icon-shadow"> </span>
		</div>
	</li>

<?php 
	}
?>

