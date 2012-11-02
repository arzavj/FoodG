<html>
<head>
        <?php
                include 'head.php';
        ?>
</head>


<body>

<div data-role="page" id="fridgeview" data-add-back-btn="true">
	<div data-role="header">
		<a data-rel="back" data-icon="back">Back</a>
			<h1>Categories</h1>
	</div><!-- /header -->
	<div data-role="content">
		<div class="ui-grid-a">
			<?php
				$count = 0;
				$result = mysql_query("SELECT * from categories");
				while($row = mysql_fetch_array($result)){
					if ($count == 0){
						echo '<div class="ui-block-a">';
					} else {
						echo '<div class="ui-block-b">';
					}		
			?>
				<div class="dashboard-icon">
					<a href="list.php?cat_id=<?php echo $row["id"] ?>">
						<div><img src="<?php echo $row["image_url"]?>" /></div>
						<div class="category-name"><?php echo $row["category"] ?></div>
					</a>
				</div>
			<?php
				echo "</div>";
				$count = ($count + 1) % 2;  
				}
			?>
		</div>
	</div><!-- /content -->
</div><!-- /End of Categories List Page -->


<!-- Plan to implement "Pop up lists" for selection of each first item -->

</body>

</html>
