<html>
	<head>
		<?php
		include("head.php");
		?>
	</head>
	<body>
		
<!-- Main view -->
<div data-role="page" id="home" data-add-back-btn="true">

	<div data-role="header">
		<!-- <a href="#Home" data-icon="back">Back</a> -->
		<h1>My Fridge</h1>
		<a href="logout.php" data-role="button" class="ui-btn-right">Logout</a>
		<script>
		$(document).ready(function(){
			<?php
				if($_COOKIE["shop-cart-mode"]==true)
				{
				?>
					$('#shop-cart').val('on').trigger('keyup');
					alert("boo");
				<?php
				}	
				else
				{
				?>
					$("#my-cart-link").hide();
				<?php
				}
			?>
			//$( "#accordion" ).accordion();
			$('#shop-cart').change(function() {
			    var myswitch = $(this);
			    var show     = myswitch[0].selectedIndex == 1 ? true:false;
			    $('#my-cart-link').toggle(show);
				$.post("shop-cart-mode.php", {"shop-cart-mode":show}, function(data) {});
			});
		});
		
		</script>
	</div><!-- /header -->

	<div data-role="content">
		
		<?php
		include "config.php";

		$userName = sprintf("SELECT username from users WHERE id = %s", $_COOKIE['user-id']);
		$userName = mysql_fetch_array(mysql_query($userName));
		echo "Hello, <b>".$userName["username"]."</b>. <br>";
		?>
		
		<div data-role="fieldcontain">
			<label for="shop-cart">Shopping Cart Mode:</label>
			<select data-inline="true" name="shop-cart" id="shop-cart" data-role="slider">
				<option value="off">Off</option>
				<option value="on">On</option>
			</select>
		</div>
		
		<a href="myCart.php" id="my-cart-link" data-icon="arrow-r" data-iconpos="right" data-role="button">My Cart</a>
		
		<?php
		$storequest= sprintf('SELECT id,max_volume,curr_volume FROM user_storages WHERE user_id = %s', $_COOKIE['user-id']);
		$storeLoc = mysql_query($storequest);
		$storageId = mysql_fetch_array($storeLoc);
		$percentUsed = ($storageId["curr_volume"]/$storageId["max_volume"])*100;
		echo '<div id="fullness-bar">'.'Your fridge is '.$percentUsed.'% full'.'</div>';
		echo '<a href="search.php" data-role="button" data-icon="search">Search Your Fridge</a>';
		$query = sprintf('SELECT food_id FROM user_foods WHERE user_storage_id = %s', $storageId['id']);

		$catrequest = sprintf('SELECT DISTINCT categories.id AS id, category FROM foods inner join categories ON categories.id = foods.category_id WHERE foods.id IN (%s)', $query);
		$catresult = mysql_query($catrequest);

		echo '<div id="accordion">';
		while ($row = mysql_fetch_assoc($catresult)){
			echo "<h2>".$row["category"]."</h2>\n";
			$itemsQuery = sprintf("SELECT foods.* from user_foods inner join foods ON foods.id = user_foods.food_id WHERE user_storage_id = %s AND foods.category_id = %s", $storageId['id'], $row['id']);
			$itemsresult = mysql_query($itemsQuery);
			while ($item = mysql_fetch_assoc($itemsresult)){
				echo "<div>\n";
				$link = sprintf("<a href='description.php?food=%s&update=1'>", $item['id']);
				echo $link;
				echo "<p>".$item['food'];
				$image = sprintf("<img src= %s class = %s />", $item['image_url'],'thumb' );
				echo $image."</a></p>\n";
				echo "</div>\n";
			}
		}
		echo '</div>';
		?>
		
		<!--
		<div style="position: relative; left: 50%; top: 0;">	
			<img src="images/fridgeView.png" class="displayView" />	
		</div>
		-->
		
		
	</div><!-- /content -->
	<?php
		include("footer.php");
	?>

</div>




<!-- Start of third page: #freezerview -->
<!-- <div data-role="page" id="freezerview" data-add-back-btn="true">

	<div data-role="header">
		<a href="#Home" data-icon="back">Back</a>
		<h1>MyFreezer</h1>
		<a href="#" data-icon="gear">Settings</a>
		<a href="#" id="logout">Logout</a>
	</div>

	<div data-role="content">
		<div style="position: relative; left: 50%; top: 0;">		
			<img src="images/fridgeView.png" class="displayView" />
		</div>
	</div>
	<?php
		//include("footer.php");
		?>

</div> --><!-- /page three -->

		
	</body>
</html>
