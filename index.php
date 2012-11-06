<html>
	<head>
		<?php
		include("head.php");
		?>
		<script>
		$(function() {
			$( "#accordion" ).accordion();
		});
		</script>
	</head>
	<body>
		
<!-- Main view -->
<div data-role="page" data-add-back-btn="true">

	<div data-role="header">
		<!-- <a href="#Home" data-icon="back">Back</a> -->
		<h1>My Fridge</h1>
		<a href="logout.php" data-role="button" >Logout</a>
	</div><!-- /header -->

	<div data-role="content">
		
		<?php
		include "config.php";
		$userName = $_COOKIE['username'];
		echo "Hello, <b>".$userName."</b>. <br>";
		$storequest= sprintf('SELECT user_storages.id FROM user_storages inner join users ON users.id = user_storages.user_id  WHERE users.username = \'%s\'', $userName);
		$storeLoc = mysql_query($storequest);
		$storageId = mysql_fetch_array($storeLoc);
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
		<br />
		<a href="search.php"><i>Search</i></a>
		
	</div><!-- /content -->
	<?php
		include("footer.php");
	?>

</div>




<!-- Start of third page: #freezerview -->
<div data-role="page" id="freezerview" data-add-back-btn="true">

	<div data-role="header">
		<a href="#Home" data-icon="back">Back</a>
		<h1>MyFreezer</h1>
		<a href="#" data-icon="gear">Settings</a>
		<a href="#" id="logout">Logout</a>
	</div><!-- /header -->

	<div data-role="content">
		<div style="position: relative; left: 50%; top: 0;">		
			<img src="images/fridgeView.png" class="displayView" />
		</div>
	</div><!-- /content -->
	<?php
		include("footer.php");
		?>

</div><!-- /page three -->

		
	</body>
</html>