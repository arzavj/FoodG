<html>
	<head>
	        <?php
	                include 'head.php';
	        ?>
	</head>
	<body>
		<?php 
			include "helperFunctions.php";
			$user_storage_query = sprintf("SELECT id from user_storages WHERE user_id = %s", $_COOKIE["user-id"]);
			$user_storage = mysql_fetch_array(mysql_query($user_storage_query));
			$foodName = getFoodName($_GET["food"]);
			$alreadyInFridge = isInFridge($user_storage["id"], $_GET["food"]);
			$alreadyInCart = "false";
			$mode = "Fridge";
			$currentQuantityInCart = "";
			$foodNameInCart = "";
			$quantityType = "";
			if($_COOKIE["shop-cart-mode"]=="true")
			{
				$alreadyInCart = isInCart($currentQuantityInCart, $foodNameInCart, $quantityType);
				$mode = "Cart";
			}
			function isInCart(&$currQ, &$foodN, &$qType)
			{
				if (get_magic_quotes_gpc() == true) {
				 foreach($_COOKIE as $key => $value) {
				   $_COOKIE[$key] = stripslashes($value);
				  }
				}
				
				if($_COOKIE["shop-cart-mode"]!="true")
					return "false";
				$cartArray = $_COOKIE["cart"];
				if(!is_null($cartArray))
					$cartArray = unserialize($cartArray);
				else
					return "false";
				foreach($cartArray as $key=>$map) //if added item is already in shopping cart
				{
					if($map["food_id"]==$_GET["food"])
					{
						$currQ = $map["quantity"];
						$foodN = getFoodName($map["food_id"]);
						$qType = getQuantityName($map["quantity_type_id"]);
						//echo "<p>".$currentQuantityInCart.$quantityType." of ".$foodNameInCart."</p>";
						return "true";
					}
				}
				return "false";
			}
			
			if($alreadyInFridge){
				$currentQuantity = retrieveCurrQuantity($user_storage["id"], $_GET["food"]);
			}
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
					$temp = mysql_fetch_assoc($result);
					return $temp["quantity"];
				}
				return 0;
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

			function checkIfFull($user_id)
			{
				$query = sprintf("SELECT * FROM user_storages WHERE user_id = %s", $user_id);
				$result = mysql_query($query);
				$storage = mysql_fetch_assoc($result);
				$fullness = floatval($storage["curr_volume"]) / floatval($storage["max_volume"])	;
				if($fullness > 0.95)
				{
					return $fullness;
				}
				return false;
			}
		?>

		<div data-role="page" data-add-back-btn="true">
		<div data-role="header">
            <!-- <a data-rel="back" data-icon="back">Back</a> -->
            <?php
            	$query = sprintf("SELECT foods.*, user_foods.quantity from (user_storages inner join user_foods ON (user_storages.id = user_foods.user_storage_id)) inner join foods ON (user_foods.food_id = foods.id) WHERE user_storages.user_id = %s AND foods.id = %s LIMIT 1", $_COOKIE['user-id'], $_GET['food']);
            	$user_result = mysql_query($query);
            	$row = NULL;
            	$update = $_GET['update'] ? "1" : "0";
            	if (mysql_num_rows($user_result) > 0)
				{
            		$row = mysql_fetch_array($user_result);
            	} 
				else
				{
            		$query = sprintf("SELECT foods.*, 0 AS quantity from foods WHERE id = %s", $_GET['food']);
            		$row = mysql_fetch_array(mysql_query($query));
            		$update = "0";
            	}
            ?>
			<h1><?php echo $row["food"];?></h1>
			<a href="logout.php" data-role="button" class="ui-btn-right">Logout</a>
	    </div><!-- /header -->

	    <div data-role="content">
	    	<script src="//cdn.optimizely.com/js/141265170.js"></script>
	    <!-- Pop Up Goes Here -->
		<!-- shopping cart popup -->
		<div data-role="popup" id="popupCart" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
			<div data-role="header" data-theme="a" class="ui-corner-top">
				<h1>Shopping Cart</h1>
			</div>
			<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
				<h3 class="ui-title">You already have <?php echo $currentQuantityInCart.$quantityType." of ".$foodNameInCart;?>.</h3>
				<p>Are you sure you want to add more?</p>
				<a href="#" data-role="button" data-inline="true" data-theme="c" onclick="document.getElementById('foodForm').submit();">Add to Cart</a>    
				<a href= "#" data-role="button" data-inline="true" data-transition="flow" data-theme="b" onclick="window.location = 'myCart.php';">Don't Add </a> 
			</div>
		</div>
		
		<div data-role="popup" id="popupDialog" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
			<div data-role="header" data-theme="a" class="ui-corner-top">
				<h1>Fridge Check</h1>
			</div>
			<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
				<h3 class="ui-title">You already have <?php echo $currentQuantity." ".$foodName;?>.</h3>
				<p>Are you sure you want to add more?</p>
				<a href="#" data-role="button" data-inline="true" data-theme="c" onclick="manualSubmit();">Add to Fridge</a>    
				<a href= "#" data-role="button" data-inline="true" data-transition="flow" data-theme="b" onclick="manualSubmit2();">Don't Add </a> 
			</div>
		</div>

		<div data-role="popup" id="popupDialogFull" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
			<div data-role="header" data-theme="a" class="ui-corner-top">
				<h1>Fridge Check</h1>
			</div>
			<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
				<h3 class="ui-title">Your storage is almost full!</h3>
				<p>Are you sure you want to add more?</p>
				<a href="#" data-role="button" data-inline="true" data-theme="c" onclick="manualSubmit();">Add to Fridge</a>    
				<a href= "#" data-role="button" data-inline="true" data-transition="flow" data-theme="b" onclick="manualSubmit2();">Don't Add </a> 
			</div>
		</div>
		
		<script type="text/javascript">
			var btn = null;
			function capture(button){
				btn = button;
			}

			function manualSubmit(){
				var form = document.getElementById("foodForm");
				if (btn != null){
					$("#btnClick").val(btn.value);
				}
				form.submit();
			}

			function manualSubmit2(){
				var form = document.getElementById("foodForm");
				form.action = "updatePoints.php";
				form.submit();
			}

			function crossCheckFridge()
			{
				var quant_element = document.getElementById('quantField');
				var quantToBeAdded = quant_element.value;
				var addedflag = (<?php echo $alreadyInFridge; ?> < quantToBeAdded) && (<?php echo $update."||".$alreadyInFridge?>);   //Interfered with adding new items: < parseInt(quantToBeAdded)) ;
				var fullflag = <?php echo ($fullFridge ? "true" : "false"); ?>;

				if(<?php echo $alreadyInCart;?>==true && btn==null) //if btn is not update and remove all but is "Add to Cart"
				{
					$("#popupCart").popup();
					$("#popupCart").popup("open");
					return false;
				}
				if (<?php echo (is_null($_COOKIE["shop-cart-mode"]) ? "false" : $_COOKIE["shop-cart-mode"]); ?> && (<?php echo $alreadyInFridge; ?>)){
					return true;
				}
				if(addedflag && $(btn).val() != "Remove All")
				{
					$( "#popupDialog" ).popup();
					$("#popupDialog").popup("open");
					return false;

				}			
				else if(fullflag && $(btn).val() != "Remove All")
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
					<input type="number" id= "quantField" name="quantity" value= "<?php echo $row["quantity"]; ?>" style="display: inline; width: 50%;"/>
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
					if($update || intval($_GET["update"])==1 || $alreadyInFridge)
					{
				?>
					<input type="hidden" name="btnS" id="btnClick"/>
					<input type="submit" data-theme="b" name="btnS" value="Update" onclick="capture(this);"/>
					<input type="submit" data-theme="b" name="btnS" value="Remove All" onclick="capture(this);"/>
				<?php 
					}
					else
					{
				?>
					<input type="hidden" name="btnS" value="Submit"/>			
					<input type="submit" data-theme="b" value="Add to <?php echo $mode; ?>" />
				<?php
					}
				?>
			</form>
			</center>


			
		</div>
		</div>


	 
		
	</body>
</html>


