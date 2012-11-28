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
                			$query1 = sprintf("SELECT category from categories WHERE id = %s LIMIT 1", $_GET["cat_id"]);
							$result1 = mysql_query($query1);
							$row1 = mysql_fetch_array($result1);
                		?>
                        <h1><?php echo $row1["category"] ?></h1>
						<a href="logout.php" data-role="button" class="ui-btn-right">Logout</a>

        </div><!-- /header -->
	<div data-role="content">
		<ul data-role="listview">
			<?php
				$query = sprintf("SELECT * from foods WHERE category_id = %s LIMIT 20", $_GET["cat_id"]);
				$result = mysql_query($query);
				if (mysql_num_rows($result) > 0){
					while($row = mysql_fetch_array($result)){
				?>
					<li>
						<a href="description.php?food=<?php echo $row["id"]?>" >
							<img src="<?php echo $row["image_url"] ?>" class="ui-li-thumb" />
							<?php echo $row["food"] ?>
						</a>
					</li>
				<?php
					}
				} else{
					echo '<div data-role="navbar"><ul><li><center>Sorry,but there is nothing in this category at the moment.</center></li></ul></div>';
				}
				?>
		</ul>
	</div>
	</div>
</body>
