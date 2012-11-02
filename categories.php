<html>
<head>
        <?php
                include 'head.php';
        ?>
</head>


<body>

<div data-role="page" id="fridgeview" data-add-back-btn="true">
	<div data-role="header">
		<a href="index.php" data-icon="back">Back</a>
			<h1>Categories</h1>
	</div><!-- /header -->
	<div data-role="content">
		<ul data-role="listview">
			<?php
				$result = mysql_query("SELECT * from categories");
				while($row = mysql_fetch_array($result)){
			?>
				<li><a href="list.php?cat_id=<?php echo $row["id"] ?>" rel="external"><?php echo $row["category"] ?></a></li>
			<?php
				}
			?>
	<!--
			<li><a href="#">Meats</a></li>
			<li><a href="#">Vegetables</a></li> -->
			<li><a href="list.php" rel="external">Fruits</a></li>
<!--
			<li><a href="#">Dairy</a></li>
			<li><a href="#">Fish & Seafood</a></li>
			<li><a href="#">Beverages</a></li>
			<li><a href="#">Leftovers</a></li>
			<li><a href="#">Other Foods</a></li>

-->
		</ul>
	</div><!-- /content -->
</div><!-- /End of Categories List Page -->


<!-- Plan to implement "Pop up lists" for selection of each first item -->

</body>

</html>
