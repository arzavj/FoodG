<?php
	include "config.php";
	$query = "";
	if ($_POST["catID"] != "0"){
		$cat = mysql_query(sprintf("SELECT category from categories WHERE id = %s", $_POST["catID"]));
		$cat = mysql_fetch_array($cat);
		$query = sprintf("SELECT *, foods.id AS fID from (((user_foods inner join foods ON foods.id = user_foods.food_id) 
			inner join quantity_types ON quantity_types.id = user_foods.quantity_type_id) 
			inner join user_storages ON user_storages.id = user_foods.user_storage_id)
			inner join categories ON categories.id = foods.category_id
			WHERE foods.category_id = %s AND user_storages.user_id = %s", $_POST["catID"], $_COOKIE['user-id']);
?>
		<!--<div style="text-align:center;"><h3><?= $cat["category"] ?></h3></div>-->
<?php
	} else{
		$query = sprintf("SELECT *, foods.id AS fID from (((user_foods inner join foods ON foods.id = user_foods.food_id) 
			inner join quantity_types ON quantity_types.id = user_foods.quantity_type_id) 
			inner join user_storages ON user_storages.id = user_foods.user_storage_id)
			inner join categories ON categories.id = foods.category_id
			WHERE user_storages.user_id = %s", $_COOKIE['user-id']);
	}

	$foods = mysql_query($query);
	$counter = 16; //Can only display 16 items in fridge at a time.
	$col = 0;
?>
	<div class="ui-grid-c"  style="background-image: url('images/fridgeView.png'); background-size: 100%">
<?php
	while($item = mysql_fetch_array($foods)){
		$counter--;
		if($counter < 1) break;
?>
	<?php 
		if($col == 0){ 
	?>
				<div class="ui-block-a">
					<a href='description.php?food=<?= $item['fID']?>&update=1'>
					 <img src= "<?= $item['display_url'] ?>" class = 'thumb' /> 
					</a>
					<div class="imgCaption"><?= $item['food'] ?></div>
				</div>
	<?php 		
				$col++;
		}else if($col == 1){ 
	?>
				<div class="ui-block-b">
					<a href='description.php?food=<?= $item['fID']?>&update=1'>
					 <img src= "<?= $item['display_url'] ?>" class = 'thumb' /> 
					</a>
					<div class="imgCaption"><?= $item['food'] ?></div>
				</div>
	<?php
				$col++;
		}else if($col == 2){ 
	?>
				<div class="ui-block-c">
					<a href='description.php?food=<?= $item['fID']?>&update=1'>
					 <img src= "<?= $item['display_url'] ?>" class = 'thumb' /> 
					</a>
					<div class="imgCaption"><?= $item['food'] ?></div>
				</div>
	<?php
				$col++;
		}else if($col == 3) { 
	?>
				<div class="ui-block-d">
					<a href='description.php?food=<?= $item['fID']?>&update=1'>
					 <img src= "<?= $item['display_url'] ?>" class = 'thumb' /> 
					</a>
					<div class="imgCaption"><?= $item['food'] ?></div>
				</div>

<?php
				$col = 0;
		}
	}
?>
</div>
	
