<html>
	<head>
	        <?php
	                include 'head.php';
	        ?>
	</head>
	<body>
		<div data-role="header">
            <a data-rel="back" data-icon="back">Back</a>
            <?php
            	$query = sprintf("SELECT foods.*, user_foods.quantity from ((users inner join user_storages ON (users.id = user_storages.user_id)) inner join user_foods ON (user_storages.id = user_foods.user_storage_id)) inner join foods ON (user_foods.food_id = foods.id) WHERE users.username = \"%s\" AND foods.id = %s LIMIT 1", $_COOKIE['username'], $_GET['food']);
            	$row = mysql_fetch_array(mysql_query($query));
            ?>
			<h1><?php echo $row["food"];?></h1>
	    </div><!-- /header -->

	    <div data-role="content">
			<div class="ui-grid-a">
				<div class="ui-block-a"><img src="<?php echo $row["image_url"]?>" /></div>
				<div class="ui-block-b">
					<form action="index.php" method="post" data-ajax="false">
				 		<input type="hidden" name="name" value="Apple" />
						<div data-role="fieldcontain">
							<label for="quantity" class="ui-input-text">Quantity: </label>
							<input type="number" name="quantity" value= "1" style="width: 25%;"/><span>units</span>
						<div data-role="fieldcontain">
							<label for="expiry" class="ui-input-text">Expiry Date: </label>
							<input type="date" name="expiry"></input>			
						</div>
						<input type="submit" data-theme="b" value="Submit" />
					</form>
				</div>
			</div><!-- /grid-a -->
		</div>

	</body>
</html>


