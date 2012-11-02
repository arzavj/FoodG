<head>
	<?php
		include 'head.php';
	?>
</head>
<body>
        <div data-role="header">
                <a data-rel="back" data-icon="back">Back</a>
                		<?php
                			$query = sprintf("SELECT category from categories WHERE id = %s LIMIT 1", $_GET["cat_id"]);
							$result = mysql_query($query);
							$row = mysql_fetch_array($result);
                		?>
                        <h1><?php echo $row["category"] ?></h1>


        </div><!-- /header -->
	
	<ul data-role="listview">
		<li>
		<div data-role="navbar">
			<ul>
				<?php
					$query = sprintf("SELECT * from foods WHERE category_id = %s", $_GET["cat_id"]);
					$result = mysql_query($query);
					while($row = mysql_fetch_array($result)){
				?>
					<li><img src="<?php echo $row["image_url"] ?>" class="thumb"></li>
					<li><a href="description.php?food=<?php echo $row["id"]?>" > <?php echo $row["food"] ?> </a></li>
				<?php
					}
				?>
			</ul>
		</div>
		</li>
	</ul>

</body>
