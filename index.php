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
		
<!-- Start of first page: #fridgeview -->
<div data-role="page" id="Home" data-add-back-btn="true">

	<div data-role="header">
		<!-- <a href="#Home" data-icon="back">Back</a> -->
		<h1>My Fridge</h1>
		<a href="logout.php" data-role="button" >Logout</a>
	</div><!-- /header -->

	<div data-role="content">
	
	<!-- METHOD TO EXTRACT CATEGORIES USER "OWNS" IN FRIDGE -->
	<?php
		function filterFridgeView($storeID, $cat){
			$storequest = sprintf('SELECT food_id FROM user_foods WHERE user_storage_id = %s', $storeID);
			$storesult = mysql_query($storequest);	
			$foodset = array();
			while($row = mysql_fetch_assoc($storesult)){
				$foodrequest = sprintf('SELECT * FROM foods WHERE category_id = %s && id = %s', $cat, $row['food_id']);
				$foodresult = mysql_query($foodrequest);
				if(mysql_num_rows($foodresult)>0){
					$foodset[] = mysql_fetch_assoc($foodresult);
				}
			}
			return $foodset;
		}
	?>
		
		
		
		
		<?php
		include "config.php";
		$userName = $_COOKIE['username'];
		echo "Hello, <b>".$userName."</b>. <br>";
		$usrrequest = sprintf('SELECT id FROM users WHERE username = \'%s\'', $userName);
		$userresult = mysql_query($usrrequest);
		$userId = mysql_fetch_assoc($userresult);
		$storequest= sprintf('SELECT id FROM user_storages WHERE user_id = %s', $userId['id']);
		$storeLoc = mysql_query($storequest);
		$storageId = mysql_fetch_array($storeLoc);
		$query = sprintf('SELECT food_id FROM user_foods WHERE user_storage_id = %s', $storageId['id']);
		$result = mysql_query($query);
		$set = array();
		while ($row = mysql_fetch_assoc($result)){
				$catrequest = sprintf('SELECT category_id FROM foods Where id = %s', $row['food_id']);
				$catresult = mysql_query($catrequest);
				$catID = mysql_fetch_assoc($catresult);
				$element = $catID['category_id'];
				if(! in_array($element, $set) ){
					$set[] = $catID['category_id'];
				}
		}
		$displayUsrsCat = array();
		foreach($set as $catNum){
			$catrequest = sprintf('SELECT category FROM categories WHERE id = %s', $catNum);
			$catresult = mysql_query($catrequest);
			$catName = mysql_fetch_assoc($catresult);
			$displayUsrsCat[] = $catName['category'];
		}

		$accordion = sprintf('<div id=%s >', "accordion");
		echo $accordion;
		foreach($displayUsrsCat as $cat){
			echo "<h2>".$cat."</h2>\n";
			$numRequest = sprintf('SELECT id FROM categories WHERE category= \'%s\'', $cat);
			$numResult = mysql_query($numRequest);
			$catNum = mysql_fetch_assoc($numResult);
			$itemArray = filterFridgeView($storageId['id'], $catNum['id']);
			foreach($itemArray as $item){
				
				echo "<div>\n";
				$link = sprintf("<a href='description.php?food=%s'>", $item['id']);
				echo $link;
				echo "<p>".$item['food'];
				$image = sprintf("<img src= %s class = %s />", $item['image_url'],'thumb' );
				echo $image."</a></p>\n";
				echo "</div>\n";
			}
		}
		?>
		
		<div style="position: relative; left: 50%; top: 0;">	
			<img src="images/fridgeView.png" class="displayView" />	
		</div>
		
	</div><!-- /content -->
	<?php
		include("footer.php");
	?>

</div><!-- /page two -->




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