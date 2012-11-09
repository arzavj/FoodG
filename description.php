<html>
	<head>
	        <?php
	                include 'head.php';
	        ?>

   



	</head>
	<body>
		<?php 
			$user_storage_query = sprintf("SELECT id from user_storages WHERE user_id = %s", $_COOKIE["user-id"]);
			$user_storage = mysql_fetch_array(mysql_query($user_storage_query));
			$foodName = getFoodName($_GET["food"]);
			$currentQuantity = retrieveCurrQuantity($user_storage["id"], $_GET["food"]);
			$alreadyInFridge = isInFridge($user_storage["id"], $_GET["food"]);
			$fullFridge = checkIfFull($_COOKIE["user-id"]);
			//returns name of the food
			function getFoodName($food_id)
			{
				$query = sprintf("SELECT food FROM foods WHERE id = %s", $food_id);
				$result = mysql_query($query);
				if(mysql_num_rows($result) > 0)
				{
					$name = mysql_fetch_assoc($result);
					return $name["food"];
				}
				return "NULL_FOOD_NAME";
			}
			//returns boolean if it is in the fridge
			function isInFridge($user_storage_id, $food_id)
			{
				$query = sprintf("SELECT quantity FROM user_foods WHERE user_storage_id = %s AND food_id = %s", $user_storage_id, $food_id);
				$result = mysql_query($query);
				if(mysql_num_rows($result) > 0)
				{
					return true;
				}
				return false;
			}

			//returns food quantity
			function retrieveCurrQuantity($user_storage_id, $food_id)
			{
				$query = sprintf("SELECT quantity FROM user_foods WHERE user_storage_id = %s AND food_id = %s", $user_storage_id, $food_id);
				$result = mysql_query($query);
				if(mysql_num_rows($result) > 0)
				{
					$currQuantity = mysql_fetch_assoc($result);
					return $currQuantity["quantity"];
				}
				return -1;
			}

				function getCurrPoints($user_id)
				{
					$query = sprintf("SELECT saved_points FROM users WHERE id = %s", $user_id);
					$result = mysql_query($query);
					$user = mysql_fetch_assoc($result);
					return $user["saved_points"];
				}

			function checkIfFull($user_id)
			{
				$query = sprintf("SELECT * FROM user_storages WHERE user_id = %s", $user_id);
				$result = mysql_query($query);
				$storage = mysql_fetch_assoc($result);
				$fullness = $storage["max_volume"] / $storage["curr_volume"];
				if($fullness > 0.95)
				{
					return true;
				}
				return false;
			}
		?>

		<script type="text/javascript">
			function updatePoints()
			{
				var quant_element = document.getElementById('quantField');
				var quantToBeAdded = quant_element.value;
				<?php
					$oldpoints = getCurrPoints($_COOKIE["user_id"]);
					$total =  + $oldpoints;
					$query = sprintf("UPDATE users SET saved_points = %s WHERE id = %s", $total, $$user_id);
					$result = mysql_query($query);
				?>
			}

		</script>




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
	    <!-- Pop Up Goes Here -->
		<div data-role="popup" id="popupDialog" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
			<div data-role="header" data-theme="a" class="ui-corner-top">
				<h1>Fridge Check</h1>
			</div>
			<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
				<h3 class="ui-title">You already have <?php echo $currentQuantity." ".$foodName;?>.</h3>
				<p>Are you sure you want to add more?</p>
				<a href="#" data-role="button" data-inline="true" data-theme="c" onclick="document.getElementById('foodForm').submit();">Add to MyFood</a>    
				<a href= "index.php" data-role="button" data-inline="true" data-transition="flow" data-theme="b">Stop Adding </a> 
			</div>
		</div>

		<div data-role="popup" id="popupDialogFull" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
			<div data-role="header" data-theme="a" class="ui-corner-top">
				<h1>Fridge Check</h1>
			</div>
			<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
				<h3 class="ui-title">Your storage is almost full!</h3>
				<p>Are you sure you want to add more?</p>
				<a href="#" data-role="button" data-inline="true" data-theme="c" onclick="document.getElementById('foodForm').submit();">Add to MyFood</a>    
				<a href= "index.php" data-role="button" data-inline="true" data-transition="flow" data-theme="b">Stop Adding </a> 
			</div>
		</div>

		<script type="text/javascript">
		function crossCheckFridge()
		{
			var quant_element = document.getElementById('quantField');
			var quantToBeAdded = quant_element.value;
			var addedflag = <?php echo $alreadyInFridge; ?>;
			var fullflag = <?php echo $fullFridge; ?>;
			if(addedflag)
			{
				$( "#popupDialog" ).popup();
				$("#popupDialog").popup("open");
				return false;

			}			
			else if(fullflag)
			{
				$( "#popupDialogFull" ).popup();
				$("#popupDialogFull").popup("open");	
				return false;
			}			
			else
			{
				return true;
			}
			
		}
		</script>	

	    	<center>
				<img src="<?php echo $row["image_url"]?>" class="image_description"/>
			<form action="submit.php" id="foodForm" method="post" data-ajax="false" onsubmit="return crossCheckFridge();">
				<input type="hidden" name="update" value="<?php  echo $update; ?>" />
	 			<input type="hidden" name="food_id" value="<?php  echo $_GET['food']; ?>" />
				<div data-role="fieldcontain">
					<label for="quantity" class="ui-input-text" style="display :inline;">Quantity: </label>
					<input type="number" id= "quantField" name="quantity" value= "<?php echo $row["quantity"]?>" style="display: inline; width: 50%;"/>
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


