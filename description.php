<html>
	<head>
	        <?php
	                include 'head.php';
	        ?>
	</head>
	<body>
		<div data-role="page" data-add-back-btn="true">
		<div data-role="header">
            <!-- <a data-rel="back" data-icon="back">Back</a> -->
            <?php
            	$query = sprintf("SELECT foods.*, user_foods.quantity from (user_storages inner join user_foods ON (user_storages.id = user_foods.user_storage_id)) inner join foods ON (user_foods.food_id = foods.id) WHERE user_storages.user_id = %s AND foods.id = %s LIMIT 1", $_COOKIE['user-id'], $_GET['food']);
            	$user_result = mysql_query($query);
            	$row = NULL;
            	$update = $_GET['update'] ? "1" : "0";
            	if (mysql_num_rows($user_result) > 0){
            		$row = mysql_fetch_array($user_result);
            	} else{
            		$query = sprintf("SELECT foods.*, 0 AS quantity from foods WHERE id = %s", $_GET['food']);
            		$row = mysql_fetch_array(mysql_query($query));
            		$update = "0";
            	}
            ?>
			<h1><?php echo $row["food"];?></h1>
			<a href="logout.php" data-role="button" class="ui-btn-right">Logout</a>
	    </div><!-- /header -->

	    <div data-role="content">
	    	<center>
				<img src="<?php echo $row["image_url"]?>" class="image_description"/>
			<form action="submit.php" method="post" data-ajax="false">
				<input type="hidden" name="update" value="<?php  echo $update; ?>" />
	 			<input type="hidden" name="food_id" value="<?php  echo $_GET['food']; ?>" />
				<div data-role="fieldcontain">
					<label for="quantity" class="ui-input-text" style="display :inline;">Quantity: </label>
					<input type="number" name="quantity" value= "<?php echo $row["quantity"]?>" style="display: inline; width: 50%;"/>
					<select data-inline="true" data-native-menu="false" name="quantity_type_id">
						<?php
							$result = mysql_query("SELECT * from quantity_types");
							while($row = mysql_fetch_array($result))
							{
	
						?>
								<option value="<?php echo $row["id"] ?>"><?php echo $row["quantity_type"]?></option>
						<?php
							}
						?>
					</select>
				</div>
				<!-- <div data-role="fieldcontain">
					<label for="expiry" class="ui-input-text">Expiry Date: </label>
					<input type="date" name="expiry"></input>			
				</div> -->
				<?php 
					if ($update) :
				?>
					<input type="submit" data-theme="b" name="btnS" value="Update" />
					<input type="submit" data-theme="b" name="btnS" value="Remove All" />
				<?php 
					else:
				?>
					<input type="submit" data-theme="b" name="btnS" value="Submit" />
				<?php
					endif;
				?>
			</form>
			</center>
		</div>
		</div>
	</body>
</html>


