<?php
	include "config.php";
	$query = "";
	if ($_POST["catID"] != "0"){
		$cat = mysql_query(sprintf("SELECT category from categories WHERE id = %s", $_POST["catID"]));
		$cat = mysql_fetch_array($cat);
		$query = sprintf("SELECT *, foods.id AS fID from ((user_foods inner join foods ON foods.id = user_foods.food_id) 
			inner join quantity_types ON quantity_types.id = user_foods.quantity_type_id) 
			inner join user_storages ON user_storages.id = user_foods.user_storage_id 
			WHERE foods.category_id = %s AND user_storages.user_id = %s", $_POST["catID"], $_COOKIE['user-id']);
?>
		<div style="text-align:center;"><h3><?= $cat["category"] ?></h3></div>
<?php
	} else{
		$query = sprintf("SELECT *, foods.id AS fID from ((user_foods inner join foods ON foods.id = user_foods.food_id) 
			inner join quantity_types ON quantity_types.id = user_foods.quantity_type_id) 
			inner join user_storages ON user_storages.id = user_foods.user_storage_id 
			WHERE user_storages.user_id = %s", $_COOKIE['user-id']);
	}

	$foods = mysql_query($query);
	while($item = mysql_fetch_array($foods)){
?>
	<!-- This is the code that needs to be updated for the display-->
	<div>
		<p>
			<a href='description.php?food=<?= $item['fID']?>&update=1'>
				<?= $item['food'] ?> <img src= "<?= $item['image_url'] ?>" class = 'thumb' /> 
			</a>
			Quantity: <?= $item['quantity']." ".$item['quantity_type'] ?>
		</p>
	</div>
<?php
	}
?>