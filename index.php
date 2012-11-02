<html>
	<head>
		<?php
		include("head.php");
		?>
	</head>
	<body>
	
	
	<!-- Start of first page: #one -->
<div data-role="page" id="Home">
	<div data-role="header">
	
		<h1>Food Gatherer</h1>
	</div><!-- /header -->
	<div data-role="content">
		<div style="position: absolute; text-align: center; width: 100%;">
			<img src="images/fridgeHome.png" usemap ="#fridgeMap" id="mainFridge"/>
		</div>
		<map id ="fridgeMap"name="fridgeMap">
			<area shape="rect" coords="0,0,103,452" href="#freezerview" alt="" title=""    />
			<area shape="rect" coords="104,0,237,452" href="#fridgeview" alt="" title=""    />

		</map>
	</div><!-- /content -->
	<?php
		include("footer.php");
	?>
</div><!-- /page one -->



	
	
	

		
		
		<!-- Start of second page: #fridgeview -->
<div data-role="page" id="fridgeview" data-add-back-btn="true">

	<div data-role="header">
		<a href="#Home" data-icon="back">Back</a>
		<h1>MyFridge</h1>
		<a href="#" data-role="button" >Logout</a>
	</div><!-- /header -->

	<div data-role="content">
	
	<!-- <script type="text/javascript">
		//var usr;
		//usr = localStorage.getItem('username'); -->
		<?php
		include "config.php";
		$userId = 1; //"SELECT id FROM users WHERE username - usr";
		$trans = sprintf('SELECT storage_id FROM user_storages WHERE user_id = %s', $userId);
		$storeLoc = mysql_query($trans);
		$storageId = mysql_fetch_array($storeLoc);
		$query = sprintf('SELECT food_id FROM user_foods WHERE user_storage_id = %s', $storageId['storage_id']);
		$result = mysql_query($query);
		$set = array();
		while ($row = mysql_fetch_assoc($result)){
			foreach($row as $value){
				$catrequest = sprintf('SELECT category_id FROM foods Where id = %s', $value);
				$catresult = mysql_query($catrequest);
				$catID = mysql_fetch_assoc($catresult);
				if(!array_search($catId['category_id'], $set)){
					$set[] = $catID['category_id']
				}
			}
		}
		$displayUsrsCat = array();
		foreach($set as $catNum){
			$catrequest = sprintf('SELECT category FROM categories WHERE id = %s', $catNum);
			$catresult = mysql_query($catrequest);
			$ccatName = mysql_fetch_assoc($catresult);
			$displayUsrsCat[] = $catName['category'];
		}
		print_r($displayUsrsCat);
		echo "<br />"
		?>
		<div style="position: relative; left: 50%; top: 0;">	
			<img src="images/fridgeView.png" class="displayView" />	
			<?
				if($_POST["name"] == "Apple"){
			?>

			<img src="images/apple.jpg" style="width: 25px; height: 25px; position: absolute; top: 240px; left: 0;" />

			<?php
			}
			?>
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
		<a href="#">Logout</a>
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